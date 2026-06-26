<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Pelanggan extends BaseController
{
    // ✦ Batas maksimal unit per produk
    protected const BATAS_MAKS = 3;

    protected $alamat_admin = [
        'nama_toko' => 'Sport Center Pemalang',
        'jalan'     => 'JL.Menur 7 Gang Depot.Kebukuran, Kebojongan',
        'kecamatan' => 'Comal',
        'kota'      => 'Pemalang',
        'provinsi'  => 'Jawa Tengah',
        'maps_link' => 'https://www.google.com/maps?q=-6.864558,109.503805'
    ];

    public function index()
    {
        $model = new ProductModel();
        $data = [
            'active'   => 'home',
            'products' => $model->findAll()
        ];
        return view('pelanggan/dashboard', $data);
    }

    public function profile()
    {
        $data = ['active' => 'profile'];
        return view('pelanggan/profile', $data);
    }

    public function notifikasi()
    {
        $data = ['active' => 'notifikasi'];
        return view('pelanggan/notifikasi', $data);
    }

    public function keranjang()
    {
        $id_user = session()->get('id');
        $db = \Config\Database::connect();

        $data['active'] = 'keranjang';
        $data['items']  = $db->table('cart')
            ->select('cart.id as id_keranjang, cart.jumlah, products.nama_produk, products.harga, products.gambar')
            ->join('products', 'products.id = cart.product_id')
            ->where('cart.user_id', $id_user)
            ->get()->getResultArray();

        return view('pelanggan/keranjang', $data);
    }

    // ✦ DIPERBARUI: validasi batas maksimal 3 unit per produk
    public function tambah_keranjang()
    {
        $id_produk = $this->request->getPost('product_id');
        $id_user   = session()->get('id');

        if (!$id_user) {
            return redirect()->to(base_url('auth/register'))
                             ->with('error', 'Silakan login terlebih dahulu');
        }

        $db    = \Config\Database::connect();
        $batas = self::BATAS_MAKS;

        // Cek apakah produk ini sudah ada di keranjang user
        $existing = $db->table('cart')
            ->where('user_id', $id_user)
            ->where('product_id', $id_produk)
            ->get()->getRowArray();

        if ($existing) {
            // Sudah ada — cek apakah jumlah sudah mencapai batas
            if ($existing['jumlah'] >= $batas) {
                return redirect()->back()
                    ->with('error', "Batas maksimal pembelian adalah {$batas} unit per produk.");
            }
            // Belum melebihi — tambah jumlah
            $db->table('cart')
               ->where('id', $existing['id'])
               ->update(['jumlah' => $existing['jumlah'] + 1]);
        } else {
            // Belum ada di keranjang — insert baru dengan jumlah 1
            $db->table('cart')->insert([
                'user_id'    => $id_user,
                'product_id' => $id_produk,
                'jumlah'     => 1,
            ]);
        }

        return redirect()->to('pelanggan/keranjang')
                         ->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    // ✦ DIPERBARUI: cek batas sebelum increment
    public function tambah($id_keranjang)
    {
        $db    = \Config\Database::connect();
        $batas = self::BATAS_MAKS;

        $item = $db->table('cart')->where('id', $id_keranjang)->get()->getRowArray();

        if ($item) {
            if ($item['jumlah'] >= $batas) {
                return redirect()->to(base_url('pelanggan/keranjang'))
                    ->with('error', "Batas maksimal pembelian adalah {$batas} unit per produk.");
            }
            $db->table('cart')->where('id', $id_keranjang)->increment('jumlah');
        }

        return redirect()->to(base_url('pelanggan/keranjang'));
    }

    public function kurangi($id_keranjang)
    {
        $db   = \Config\Database::connect();
        $item = $db->table('cart')->where('id', $id_keranjang)->get()->getRow();

        if ($item) {
            if ($item->jumlah > 1) {
                $db->table('cart')->where('id', $id_keranjang)->decrement('jumlah');
            } else {
                $db->table('cart')->where('id', $id_keranjang)->delete();
            }
        }
        return redirect()->to(base_url('pelanggan/keranjang'));
    }

    public function proses_checkout()
    {
        $userId = session()->get('id');
        $db = \Config\Database::connect();

        $metodeInput = $this->request->getPost('metode') ?? 'cod';
        $metodePembayaran = strtolower(trim($metodeInput));

        $dataOrder = [
            'user_id'           => $userId,
            'total_harga'       => $this->request->getPost('total_akhir'),
            'metode_pembayaran' => $metodePembayaran,
            'status_pembayaran' => 'belum_bayar',
            'status_pengiriman' => 'diproses'
        ];
        $db->table('orders')->insert($dataOrder);
        $orderId = $db->insertID();

        $selectedIds = $this->request->getPost('id_keranjang');
        if ($selectedIds) {
            foreach ($selectedIds as $idKeranjang) {
                $item   = $db->table('cart')->where('id', $idKeranjang)->get()->getRowArray();
                $produk = $db->table('products')->where('id', $item['product_id'])->get()->getRowArray();

                $db->table('order_items')->insert([
                    'order_id'   => $orderId,
                    'product_id' => $item['product_id'],
                    'jumlah'     => $item['jumlah'],
                    'subtotal'   => $item['jumlah'] * $produk['harga']
                ]);

                $db->table('cart')->delete(['id' => $idKeranjang]);
            }
        }

        return redirect()->to(base_url('pelanggan/orders'))->with('success', 'Pesanan Berhasil!');
    }

    public function edit_profile()
    {
        $db = \Config\Database::connect();
        $data = [
            'active'  => 'profile',
            'wilayah' => $db->table('wilayah')->get()->getResultArray()
        ];
        return view('pelanggan/edit_profile', $data);
    }

    public function update_profile()
    {
        $db      = \Config\Database::connect();
        $id_user = session()->get('id');

        $dataUpdate = [
            'nama'           => $this->request->getPost('nama'),
            'no_hp'          => $this->request->getPost('no_hp'),
            'provinsi'       => $this->request->getPost('provinsi'),
            'kota'           => $this->request->getPost('kota'),
            'kecamatan'      => $this->request->getPost('kecamatan'),
            'desa'           => $this->request->getPost('desa'),
            'alamat_lengkap' => $this->request->getPost('alamat_lengkap'),
        ];

        $db->table('users')->where('id', $id_user)->update($dataUpdate);
        session()->set($dataUpdate);

        return redirect()->to(base_url('pelanggan/profile'))->with('success', 'Profil diperbarui!');
    }

    public function ringkasan_pesanan($id_produk, $id_size)
    {
        $db             = \Config\Database::connect();
        $produk         = $db->table('products')->where('id', $id_produk)->get()->getRowArray();
        $ukuran         = $db->table('product_sizes')->where('id', $id_size)->get()->getRowArray();
        $daftar_wilayah = $db->table('wilayah')->get()->getResultArray();

        $data = [
            'produk'           => $produk,
            'ukuran_pilihan'   => $ukuran,
            'wilayah'          => $daftar_wilayah,
            'alamat_admin'     => $this->alamat_admin,
            'active'           => 'home',
            'harga_asli'       => $produk['harga'],
            'biaya_layanan'    => 1000,
            'biaya_penanganan' => 500,
            'user_nama'        => session()->get('nama'),
            'user_telp'        => session()->get('no_hp'),
            'user_alamat'      => session()->get('alamat_lengkap'),
            'user_kota'        => session()->get('kota')
        ];

        return view('pelanggan/ringkasan_pesanan', $data);
    }

    public function simpan_ulasan($id_order)
    {
        $db = \Config\Database::connect();

        $db->table('orders')
           ->where('id', $id_order)
           ->update([
               'rating' => $this->request->getPost('rating'),
               'ulasan' => $this->request->getPost('ulasan')
           ]);

        return redirect()->to(base_url('pelanggan/orders'))->with('success', 'Ulasan berhasil dikirim!');
    }

    public function proses_pilihan()
    {
        $id_keranjang_arr = $this->request->getPost('id_keranjang');

        if (empty($id_keranjang_arr)) {
            return redirect()->back()->with('error', 'Pilih minimal satu barang terlebih dahulu!');
        }

        $db      = \Config\Database::connect();
        $id_user = session()->get('id');

        $items = $db->table('cart')
            ->select('cart.id as id_keranjang, cart.jumlah, cart.product_id,
                      products.nama_produk, products.harga, products.diskon, products.gambar')
            ->join('products', 'products.id = cart.product_id')
            ->where('cart.user_id', $id_user)
            ->whereIn('cart.id', $id_keranjang_arr)
            ->get()
            ->getResultArray();

        if (empty($items)) {
            return redirect()->back()->with('error', 'Item tidak ditemukan di keranjang.');
        }

        $subtotal = 0;
        foreach ($items as $item) {
            $harga_item  = $item['harga'];
            $disc_persen = $item['diskon'] ?? 0;
            $harga_final = $harga_item - ($harga_item * $disc_persen / 100);
            $subtotal   += $harga_final * $item['jumlah'];
        }

        $daftar_wilayah = $db->table('wilayah')->get()->getResultArray();

        return view('pelanggan/ringkasan_pesanan', [
            'active'           => 'keranjang',
            'dari_keranjang'   => true,
            'items'            => $items,
            'id_keranjang'     => $id_keranjang_arr,
            'harga_asli'       => $subtotal,
            'biaya_layanan'    => 1000,
            'biaya_penanganan' => 500,
            'wilayah'          => $daftar_wilayah,
            'alamat_admin'     => $this->alamat_admin,
            'user_nama'        => session()->get('nama'),
            'user_telp'        => session()->get('no_hp'),
            'user_alamat'      => session()->get('alamat_lengkap'),
            'user_kota'        => session()->get('kota'),
        ]);
    }

    // ✦ DIPERBARUI: validasi batas 3 unit di checkout
    public function proses_pesanan()
    {
        $userId = session()->get('id');
        $db     = \Config\Database::connect();
        $batas  = self::BATAS_MAKS;

        $total_harga      = (float) $this->request->getPost('total_harga');
        $ongkir           = (int)   $this->request->getPost('ongkir');
        $biaya_layanan    = (int)   $this->request->getPost('biaya_layanan');
        $biaya_penanganan = (int)   $this->request->getPost('biaya_penanganan');
        $metode           = $this->request->getPost('metode');
        $kota_tujuan      = $this->request->getPost('kota_tujuan');
        $dari_keranjang   = $this->request->getPost('dari_keranjang');
        $id_keranjang_arr = $this->request->getPost('id_keranjang') ?? [];
        $id_produk        = $this->request->getPost('id_produk');
        $id_size          = $this->request->getPost('id_size');
        $alamat           = session()->get('alamat_lengkap');

        if (empty($metode) || empty($kota_tujuan)) {
            return redirect()->back()->with('error', 'Pilih metode pembayaran dan kota tujuan!');
        }
        if (empty($alamat)) {
            return redirect()->to(base_url('pelanggan/edit_profile'))
                             ->with('error', 'Lengkapi alamat pengiriman terlebih dahulu!');
        }

        $db->transBegin();

        try {
            // A. Insert order
            $db->table('orders')->insert([
                'user_id'           => $userId,
                'alamat_pengiriman' => $alamat,
                'total_harga'       => $total_harga,
                'ongkir'            => $ongkir,
                'biaya_layanan'     => $biaya_layanan,
                'biaya_penanganan'  => $biaya_penanganan,
                'metode_pembayaran' => strtolower(trim($metode)),
                'status_pembayaran' => 'belum_bayar',
                'status_pengiriman' => 'diproses',
                'tgl_pesan'         => date('Y-m-d H:i:s'),
            ]);
            $orderId = $db->insertID();

            // B. Insert order_items & validasi batas
            if ($dari_keranjang && !empty($id_keranjang_arr)) {

                // DARI KERANJANG — multi item
                foreach ($id_keranjang_arr as $idk) {
                    $cartItem = $db->table('cart')
                        ->select('cart.*, products.harga, products.diskon')
                        ->join('products', 'products.id = cart.product_id')
                        ->where('cart.id', (int)$idk)
                        ->get()->getRowArray();

                    if (!$cartItem) continue;

                    // ✦ Validasi batas di checkout
                    if ($cartItem['jumlah'] > $batas) {
                        throw new \Exception(
                            "Jumlah produk melebihi batas maksimal {$batas} unit per produk."
                        );
                    }

                    $harga_final = $cartItem['harga'] - ($cartItem['harga'] * ($cartItem['diskon'] / 100));
                    $subtotal    = $harga_final * $cartItem['jumlah'];

                    $db->table('order_items')->insert([
                        'order_id'   => $orderId,
                        'product_id' => $cartItem['product_id'],
                        'jumlah'     => $cartItem['jumlah'],
                        'subtotal'   => $subtotal,
                    ]);

                    $db->table('cart')->delete(['id' => (int)$idk]);
                }

            } else {

                // BELI LANGSUNG — single item (selalu 1, tidak perlu cek batas)
                if (empty($id_produk) || empty($id_size)) {
                    throw new \Exception('Data produk tidak lengkap.');
                }

                $produk = $db->table('products')->where('id', $id_produk)->get()->getRowArray();
                if (!$produk) throw new \Exception('Produk tidak ditemukan.');

                $disc_persen = $produk['diskon'] ?? 0;
                $harga_final = $produk['harga'] - ($produk['harga'] * $disc_persen / 100);

                $db->table('order_items')->insert([
                    'order_id'   => $orderId,
                    'product_id' => $id_produk,
                    'jumlah'     => 1,
                    'subtotal'   => $harga_final,
                ]);

                $itemSize = $db->table('product_sizes')->where('id', $id_size)->get()->getRow();
                if (!$itemSize || $itemSize->stok < 1) {
                    throw new \Exception('Stok untuk ukuran ini sudah habis.');
                }
                $db->table('product_sizes')
                   ->where('id', $id_size)
                   ->update(['stok' => $itemSize->stok - 1]);
            }

            $db->transCommit();
            return redirect()->to(base_url('pelanggan/orders'))
                             ->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function orders()
    {
        $db     = \Config\Database::connect();
        $userId = session()->get('id');
        $data   = [
            'title'  => 'Pesanan Saya',
            'active' => 'profile',
            'orders' => $db->table('orders')
                           ->where('user_id', $userId)
                           ->orderBy('id', 'DESC')
                           ->get()->getResultArray()
        ];
        return view('pelanggan/orders', $data);
    }

    // ✦ DIPERBARUI: join ke categories agar nama_kategori ikut terambil
    public function detail($id)
    {
        $db = \Config\Database::connect();

        $produk = $db->table('products')
            ->select('products.*, categories.nama_kategori')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->where('products.id', $id)
            ->get()->getRowArray();

        $ukuran = $db->table('product_sizes')
                     ->where('product_id', $id)
                     ->get()->getResultArray();

        if (!$produk) {
            return redirect()->to('/')->with('error', 'Produk tidak ditemukan');
        }

        return view('pelanggan/detail_produk', [
            'produk' => $produk,
            'ukuran' => $ukuran,
            'active' => 'home'
        ]);
    }

    public function search()
    {
        $keyword = $this->request->getGet('keyword');
        $db      = \Config\Database::connect();
        $builder = $db->table('products');
        if ($keyword) {
            $builder->like('nama_produk', $keyword)->orLike('deskripsi', $keyword);
        }
        return view('pelanggan/dashboard', [
            'produk'  => $builder->get()->getResultArray(),
            'keyword' => $keyword
        ]);
    }

    public function buat_pesanan_final()
    {
        $userId = session()->get('id');
        $db     = \Config\Database::connect();
        $db->table('orders')->insert([
            'user_id'           => $userId,
            'total_harga'       => $this->request->getPost('total_akhir'),
            'metode_pembayaran' => 'cod',
            'status_pembayaran' => 'belum_bayar',
            'status_pengiriman' => 'diproses'
        ]);
        $orderId = $db->insertID();
        $db->table('order_items')->insert([
            'order_id'   => $orderId,
            'product_id' => $this->request->getPost('product_id'),
            'jumlah'     => 1,
            'subtotal'   => $this->request->getPost('total_akhir')
        ]);
        return redirect()->to(base_url('pelanggan/orders'))->with('success', 'Pesanan berhasil!');
    }

    public function security()
    {
        $db      = \Config\Database::connect();
        $id_user = session()->get('id');
        $cart    = $db->table('cart')->where('user_id', $id_user)->get()->getRowArray();

        if ($cart) {
            $produk = $db->table('products')->where('id', $cart['product_id'])->get()->getRowArray();
        } else {
            $produk = ['gambar' => 'default.jpg', 'nama_produk' => 'Tidak ada produk', 'harga' => 0];
        }

        $data = [
            'active'         => 'profile',
            'produk'         => $produk,
            'ukuran_pilihan' => ['ukuran' => 'All Size']
        ];

        return view('pelanggan/security', $data);
    }

    public function update_password()
    {
        $model           = new \App\Models\UserModel();
        $id_user         = session()->get('id');
        $password_baru   = $this->request->getPost('new_password');
        $ulangi_password = $this->request->getPost('confirm_password');

        if (empty($password_baru) || empty($ulangi_password)) {
            return redirect()->back()->with('error', 'Kata sandi baru tidak boleh kosong!');
        }
        if ($password_baru !== $ulangi_password) {
            return redirect()->back()->with('error', 'Konfirmasi password baru tidak cocok!');
        }

        $model->update($id_user, ['password' => $password_baru]);

        return redirect()->to('/pelanggan/profile')->with('success', 'Password berhasil diperbarui!');
    }

    public function konfirmasi_selesai($id_order)
    {
        $db = \Config\Database::connect();
        $db->table('orders')
           ->where('id', $id_order)
           ->update([
               'status_pengiriman' => 'selesai',
               'status_pembayaran' => 'Sudah Bayar'
           ]);

        return redirect()->to('/pelanggan/orders')
                         ->with('success', 'Pesanan selesai dan status pembayaran diperbarui!');
    }
    // Tampilkan halaman upload bukti
public function upload_bukti($order_id)
{
    $orderModel = new \App\Models\OrderModel();
    $order = $orderModel->find($order_id);

    // Pastikan order milik user yang login
    $user_id = session()->get('user_id');
    if (!$order || $order['user_id'] != $user_id) {
        return redirect()->to('pelanggan/orders')->with('error', 'Order tidak ditemukan.');
    }

    return view('pelanggan/upload_bukti', ['order' => $order]);
}

// Proses upload bukti
public function proses_upload_bukti($order_id)
{
    $orderModel = new \App\Models\OrderModel();
    $order = $orderModel->find($order_id);

    $user_id = session()->get('user_id');
    if (!$order || $order['user_id'] != $user_id) {
        return redirect()->to('pelanggan/orders');
    }

    $file = $this->request->getFile('bukti_transfer');

    // Validasi server-side
    if (!$file || !$file->isValid() || $file->hasMoved()) {
        return redirect()->back()->with('error', 'File tidak valid, coba lagi.');
    }

    $allowedExt  = ['jpg', 'jpeg', 'png'];
    $allowedMime = ['image/jpeg', 'image/png'];

    if (!in_array(strtolower($file->getClientExtension()), $allowedExt) ||
        !in_array($file->getMimeType(), $allowedMime)) {
        return redirect()->back()->with('error', 'Format file tidak didukung. Gunakan JPG atau PNG.');
    }

    if ($file->getSize() > 2 * 1024 * 1024) {
        return redirect()->back()->with('error', 'Ukuran file maksimal 2MB.');
    }

    // Simpan file
    $namaFile = $file->getRandomName();
    $file->move(ROOTPATH . 'public/uploads/bukti_transfer/', $namaFile);

    // Update database
    $orderModel->update($order_id, [
        'bukti_transfer'   => $namaFile,
        'status_pembayaran' => 'menunggu_verifikasi',
    ]);

    return redirect()->to('pelanggan/orders')
                     ->with('success', 'Bukti transfer berhasil dikirim! Menunggu verifikasi admin.');
}

    public function dashboard() { return view('pelanggan/dashboard'); }
    public function wishlist()  { return view('pelanggan/wishlist', ['active' => 'wishlist']); }
}