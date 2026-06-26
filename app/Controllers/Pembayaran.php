<?php

namespace App\Controllers;

use App\Models\OrderModel;
use CodeIgniter\Controller;

class Pembayaran extends Controller
{
    // Tampilkan halaman konfirmasi
    public function konfirmasi($order_id)
    {
        $orderModel = new OrderModel();
        $order = $orderModel->find($order_id);

        if (!$order) {
            return redirect()->to('/')->with('error', 'Order tidak ditemukan.');
        }

        return view('pembayaran/konfirmasi', ['order' => $order]);
    }

    // Proses upload bukti transfer
    public function upload($order_id)
    {
        $file = $this->request->getFile('bukti_transfer');

        // --- Validasi File ---
        if (!$file->isValid() || $file->hasMoved()) {
            return redirect()->back()->with('error', 'File tidak valid.');
        }

        // Hanya izinkan ekstensi jpg, jpeg, png
        $allowedTypes = ['jpg', 'jpeg', 'png'];
        $ext = strtolower($file->getClientExtension());

        if (!in_array($ext, $allowedTypes)) {
            return redirect()->back()->with('error', 'Format file tidak didukung. Gunakan JPG atau PNG.');
        }

        // Cek ukuran maksimal 2MB (2048 KB)
        if ($file->getSize() > 2 * 1024 * 1024) {
            return redirect()->back()->with('error', 'Ukuran file maksimal 2MB.');
        }

        // Cek MIME type secara server-side (bukan dari ekstensi saja)
        $allowedMimes = ['image/jpeg', 'image/png'];
        if (!in_array($file->getMimeType(), $allowedMimes)) {
            return redirect()->back()->with('error', 'Tipe file tidak diizinkan.');
        }

        // --- Simpan File ---
        $namaFile = $file->getRandomName(); // Contoh: 1687432891_abc123.jpg
        $file->move(ROOTPATH . 'public/uploads/bukti_transfer/', $namaFile);

        // --- Update Database ---
        $orderModel = new OrderModel();
        $orderModel->update($order_id, ['bukti_transfer' => $namaFile]);

        return redirect()->back()->with('success', 'Bukti transfer berhasil dikirim. Menunggu verifikasi admin.');
    }
}