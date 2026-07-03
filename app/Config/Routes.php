<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// 1. Halaman Awal & Auth
$routes->get('/', 'Pelanggan::index');
$routes->get('login', 'Auth::index'); // TAMBAHKAN INI agar rute 'login' ditemukan
$routes->get('home', 'Pelanggan::index'); 
$routes->get('auth', 'Auth::index');
$routes->get('auth/login', 'Auth::login');
$routes->get('auth/logout', 'Auth::logout');
$routes->get('auth/register', 'Auth::register');
$routes->post('auth/attemptLogin', 'Auth::attemptLogin');
$routes->post('auth/proses_register', 'Auth::proses_register');
$routes->get('auth/inputPassword/(:any)', 'Auth::inputPassword/$1');

// 2. Group Pelanggan
$routes->group('pelanggan', function($routes) {
    $routes->get('dashboard', 'Pelanggan::index');
    $routes->get('detail/(:num)', 'Pelanggan::detail/$1');
    $routes->get('keranjang', 'Pelanggan::keranjang');
    $routes->get('orders', 'Pelanggan::orders');
    $routes->post('simpan_ulasan/(:num)', 'Pelanggan::simpan_ulasan/$1');
    
    // Fitur Keranjang
    $routes->post('tambah_keranjang', 'Pelanggan::tambah_keranjang'); // Sudah POST
    $routes->get('tambah/(:num)', 'Pelanggan::tambah/$1');
    $routes->get('kurangi/(:num)', 'Pelanggan::kurangi/$1');
    $routes->post('proses_checkout', 'Pelanggan::proses_checkout');

    // Menu Profile & Notif
    $routes->get('profile', 'Pelanggan::profile');
    $routes->get('notifikasi', 'Pelanggan::notifikasi');
    $routes->get('edit_profile', 'Pelanggan::edit_profile');
    $routes->post('update_profile', 'Pelanggan::update_profile');
    $routes->get('security', 'Pelanggan::security');
    $routes->get('search', 'Pelanggan::search'); // Perbaikan: hapus kata 'pelanggan/' karena sudah di dalam group
    // Ganti baris $routes->post('proses_pilihan', ...); menjadi:
$routes->match(['get', 'post'], 'proses_pilihan', 'Pelanggan::proses_pilihan');
    
    $routes->get('ringkasan_pesanan/(:num)/(:num)', 'Pelanggan::ringkasan_pesanan/$1/$2');
    $routes->post('buat_pesanan_final', 'Pelanggan::buat_pesanan_final'); 
    

    $routes->post('update_password', 'Pelanggan::update_password'); // Sesuai nama fungsi baru di controller
    $routes->post('proses_pesanan', 'Pelanggan::proses_pesanan');   // Perbaikan: hapus kata 'pelanggan/' agar tidak double
    $routes->get('konfirmasi_selesai/(:num)', 'Pelanggan::konfirmasi_selesai/$1'); // Perbaikan: hapus kata 'pelanggan/'
    $routes->get('upload_bukti/(:num)', 'Pelanggan::upload_bukti/$1');
    $routes->post('proses_upload_bukti/(:num)', 'Pelanggan::proses_upload_bukti/$1');
});

// 3. Group Admin
$routes->group('admin', function($routes) {
    $routes->get('dashboard', 'Admin::index'); 
    $routes->get('produk', 'Admin::produk');   
    $routes->get('pesanan', 'Admin::pesanan'); 
    $routes->get('user', 'Admin::user');    
    $routes->get('laporan', 'Admin::laporan'); // Perbaikan: cukup 'laporan'
    $routes->get('admin/laporan', 'Admin::laporan');
    // Produk Management
    $routes->get('produk/tambah', 'Admin::tambah'); 
    $routes->post('produk/simpan', 'Admin::simpan');
    $routes->get('produk/edit/(:num)', 'Admin::edit/$1');
    $routes->post('produk/update/(:num)', 'Admin::update/$1');
    $routes->get('produk/delete/(:num)', 'Admin::delete/$1');
    
    $routes->get('delete/(:num)', 'Admin::delete/$1');
    $routes->get('transaksi', 'Admin::transaksi');
    $routes->get('invoices', 'Admin::invoices');
    $routes->get('promosi', 'Admin::promosi');
    $routes->post('update_status_pengiriman/(:num)', 'Admin::update_status_pengiriman/$1');
    // Menu Support
    $routes->get('feedback', 'Admin::feedback');
    $routes->post('balas_ulasan/(:num)', 'Admin::balas_ulasan/$1');
    $routes->get('pengaturan', 'Admin::pengaturan');
    $routes->get('terima_pembayaran/(:num)', 'Admin::terima_pembayaran/$1');
$routes->get('tolak_pembayaran/(:num)',  'Admin::tolak_pembayaran/$1');
    $routes->get('normalize_status_pembayaran', 'Admin::normalize_status_pembayaran');
});