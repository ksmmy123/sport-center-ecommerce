<?php

namespace App\Controllers;

class Home extends BaseController
{
    // Alamat toko dipakai di landing page (disamakan dengan properti yang
    // sama persis di Pelanggan.php & Admin.php supaya datanya konsisten).
    protected $alamat_admin = [
        'nama_toko' => 'Sport Center Pemalang',
        'jalan'     => 'JL.Menur 7 Gang Depot.Kebukuran, Kebojongan',
        'kecamatan' => 'Comal',
        'kota'      => 'Pemalang',
        'provinsi'  => 'Jawa Tengah',
        'maps_link' => 'https://www.google.com/maps?q=-6.864558,109.503805'
    ];

    // Landing page publik (route: '/' -> Home::index, lihat Routes.php)
    public function index()
    {
        $db = \Config\Database::connect();

        // 1. Produk terbaru untuk preview (maks 8 produk, urut dari yang
        //    paling baru ditambahkan admin). Query & alias total_stok
        //    dibuat sama persis dengan Pelanggan::index() supaya konsisten.
        $produk_preview = $db->table('products')
            ->select('products.*, categories.nama_kategori, SUM(product_sizes.stok) as total_stok')
            ->join('product_sizes', 'product_sizes.product_id = products.id', 'left')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->groupBy('products.id')
            ->orderBy('products.id', 'DESC')
            ->limit(4)
            ->get()->getResultArray();

        // 2. Kategori yang BENAR-BENAR memiliki produk. Butuh tabel
        //    `categories` dengan kolom `nama_kategori`, sesuai yang
        //    dipakai di Pelanggan::detail().
        $kategori_list = $db->table('categories')
            ->select('categories.id, categories.nama_kategori, COUNT(products.id) as jumlah_produk')
            ->join('products', 'products.category_id = categories.id', 'left')
            ->groupBy('categories.id')
            ->having('COUNT(products.id) >', 0)
            ->get()->getResultArray();

        // 3. Statistik nyata (bukan angka mengarang):
        //    - Pelanggan terdaftar: hitung user dengan role 'pelanggan'
        $total_pelanggan = $db->table('users')
            ->where('role', 'pelanggan')
            ->countAllResults();

        //    - Varian produk: total baris di tabel products
        $total_produk = $db->table('products')->countAllResults();

        //    - Pesanan terkirim: order yang status_pengiriman-nya selesai
        $pesanan_terkirim = $db->table('orders')
            ->whereIn('status_pengiriman', ['selesai', 'sampai'])
            ->countAllResults();

        //    - Kota terjangkau: dihitung dari kota unik milik user yang
        //      sudah pernah membuat pesanan (bukan asumsi angka tetap).
        $kota_terjangkau = $db->table('orders')
            ->select('users.kota')
            ->join('users', 'users.id = orders.user_id')
            ->where('users.kota IS NOT NULL')
            ->where('users.kota !=', '')
            ->groupBy('users.kota')
            ->countAllResults();

        // 4. Testimoni ASLI dari pelanggan: kolom `rating` & `ulasan` pada
        //    tabel `orders` (kolom yang sama dipakai di
        //    Pelanggan::simpan_ulasan() dan Admin::feedback()/balas_ulasan()).
        $testimoni = $db->table('orders')
            ->select('orders.rating, orders.ulasan, users.nama, users.kota')
            ->join('users', 'users.id = orders.user_id')
            ->where('orders.ulasan IS NOT NULL')
            ->where('orders.ulasan !=', '')
            ->orderBy('orders.rating', 'DESC')
            ->orderBy('orders.id', 'DESC')
            ->limit(3)
            ->get()->getResultArray();

        $data = [
            'produk_preview'   => $produk_preview,
            'kategori_list'    => $kategori_list,
            'total_pelanggan'  => $total_pelanggan,
            'total_produk'     => $total_produk,
            'pesanan_terkirim' => $pesanan_terkirim,
            'kota_terjangkau'  => $kota_terjangkau,
            'testimoni'        => $testimoni,
            'alamat_admin'     => $this->alamat_admin,
        ];

        return view('landing', $data);
    }
}