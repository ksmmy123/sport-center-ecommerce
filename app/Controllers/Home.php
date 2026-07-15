<?php

namespace App\Controllers;

class Home extends BaseController
{
    // ✅ FIX: sebelumnya method ini return view('pembeli/dashboard') yang
    // filenya tidak pernah ada di project ini, dan controller ini juga
    // tidak pernah di-routing kemanapun — jadi benar-benar dead code.
    // Sekarang dipakai sebagai controller untuk landing page publik
    // (rute '/'), menggantikan Pelanggan::index() yang sebelumnya
    // langsung menampilkan dashboard belanja di halaman utama.
    public function index()
    {
        $db = \Config\Database::connect();

        // Ambil beberapa produk terbaru untuk preview di landing page.
        // Kalau tabel products masih kosong, $produkPreview otomatis
        // array kosong dan section preview di view akan disembunyikan.
        $produkPreview = $db->table('products')
            ->select('products.*, SUM(product_sizes.stok) as total_stok')
            ->join('product_sizes', 'product_sizes.product_id = products.id', 'left')
            ->groupBy('products.id')
            ->orderBy('products.id', 'DESC')
            ->limit(4)
            ->get()->getResultArray();

        return view('landing', ['produk_preview' => $produkPreview]);
    }
}