<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Admin extends BaseController
{
    protected $db;

    protected $alamat_toko = [
        'nama_toko' => 'Sport Center Pemalang',
        'jalan'     => 'Kebukuran, Kebojongan',
        'kecamatan' => 'Comal',
        'kota'      => 'Pemalang',
        'provinsi'  => 'Jawa Tengah',
        'koordinat' => '-6.864558, 109.503805',
        'maps_link' => 'http://googleusercontent.com/maps.google.com/5'
    ];
    public function __construct() {
        $this->db = \Config\Database::connect();
    }
    

   public function index() {
    $db = \Config\Database::connect();
    
    // 1. Ambil data asli dari database untuk Grafik Omzet
    $results = $db->table('orders')
        ->select("MONTHNAME(tgl_pesan) as bulan_nama, SUM(total_harga) as total")
        ->where("YEAR(tgl_pesan)", date('Y'))
        ->groupBy("MONTH(tgl_pesan), MONTHNAME(tgl_pesan)") 
        ->orderBy("MONTH(tgl_pesan)", "ASC")
        ->get()
        ->getResultArray();

    // 2. Mapping Data (Jan - Des) - Default 0
    $listBulan = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    $dataBulanan = array_fill_keys($listBulan, 0); 

    // Masukkan data asli dari database ke dalam array mapping $dataBulanan
    foreach ($results as $row) {
        $namaSingkat = substr($row['bulan_nama'], 0, 3);
        if (array_key_exists($namaSingkat, $dataBulanan)) {
            // Logika baru: Jika total di bawah 15.000, set ke 15.000 agar grafik konsisten
            // dengan batas 'min' di view Chart.js
            $total = (float)$row['total'];
            $dataBulanan[$namaSingkat] = ($total > 0 && $total < 15000) ? 15000 : $total;
        }
    }

    // 3. Ambil data Stok Menipis & Habis dari tabel product_sizes (UTS: Habis=0, Menipis<=3)
    $stokKritis = $db->table('product_sizes')
        ->select('products.id, products.nama_produk, products.gambar, SUM(product_sizes.stok) as total_stok')
        ->join('products', 'products.id = product_sizes.product_id')
        ->groupBy('product_sizes.product_id')
        ->having('SUM(product_sizes.stok) <=', 3)
        ->orderBy('total_stok', 'ASC')
        ->get()
        ->getResultArray();

    // ============================================================
    // ⬇️ TAMBAHAN UNTUK DASHBOARD PENJUALAN BULANAN (UTS E-Business)
    // ============================================================

    // 5. Statistik Bulan Ini
    $bulanIni = date('Y-m');

    $totalTransaksiBulanIni = $db->table('orders')
        ->where("DATE_FORMAT(tgl_pesan, '%Y-%m')", $bulanIni)
        ->where('status_pembayaran', 'sudah_bayar')
        ->countAllResults();

    // ✅ FIX: "Total Pendapatan" = uang yang BENAR-BENAR sudah diterima.
    // Sebelumnya filternya "!= dibatalkan", jadi pesanan yang masih
    // 'belum_bayar' atau 'menunggu_verifikasi' ikut dihitung sebagai
    // pendapatan padahal uangnya belum tentu masuk. Sekarang difilter
    // spesifik status_pembayaran = 'sudah_bayar'.
    $totalPendapatanBulanIni = $db->table('orders')
        ->where("DATE_FORMAT(tgl_pesan, '%Y-%m')", $bulanIni)
        ->where('status_pembayaran', 'sudah_bayar')
        ->selectSum('total_harga')
        ->get()->getRow()->total_harga ?? 0;

    // ✅ FIX: "Total Penjualan" = jumlah pesanan/transaksi yang terjadi
    // (dihitung sebagai penjualan meskipun belum lunas dibayar — misal
    // COD atau menunggu verifikasi tetap terhitung sebagai penjualan).
    // Yang TIDAK dihitung hanya pesanan yang dibatalkan, karena itu
    // bukan penjualan yang jadi.
    $totalPesananBulanIni = $db->table('orders')
        ->where("DATE_FORMAT(tgl_pesan, '%Y-%m')", $bulanIni)
        ->where('status_pembayaran !=', 'dibatalkan')
        ->countAllResults();

    // Data Bulan Lalu (untuk perbandingan tren) — filter disamakan
    // dengan bulan ini supaya perbandingan apple-to-apple.
    $bulanLalu = date('Y-m', strtotime('-1 month'));

    $pendapatanBulanLalu = $db->table('orders')
        ->where("DATE_FORMAT(tgl_pesan, '%Y-%m')", $bulanLalu)
        ->where('status_pembayaran', 'sudah_bayar')
        ->selectSum('total_harga')
        ->get()->getRow()->total_harga ?? 0;

    $pesananBulanLalu = $db->table('orders')
        ->where("DATE_FORMAT(tgl_pesan, '%Y-%m')", $bulanLalu)
        ->where('status_pembayaran !=', 'dibatalkan')
        ->countAllResults();

    // Hitung persentase perubahan (hindari pembagian dengan nol)
    $trendPendapatan = $pendapatanBulanLalu > 0
        ? round((($totalPendapatanBulanIni - $pendapatanBulanLalu) / $pendapatanBulanLalu) * 100, 1)
        : ($totalPendapatanBulanIni > 0 ? 100 : 0);

    $trendPesanan = $pesananBulanLalu > 0
        ? round((($totalPesananBulanIni - $pesananBulanLalu) / $pesananBulanLalu) * 100, 1)
        : ($totalPesananBulanIni > 0 ? 100 : 0);

    // Rata-rata nilai transaksi (AOV) bulan ini
    $rataRataTransaksi = $totalTransaksiBulanIni > 0
        ? $totalPendapatanBulanIni / $totalTransaksiBulanIni
        : 0;

    // ============================================================
    // 6. Grafik Penjualan 7 Hari Terakhir
    // (✅ DIUBAH atas permintaan: sebelumnya 30 hari, sekarang 7 hari)
    // ============================================================
    $hasil7Hari = $db->table('orders')
        ->select("DATE(tgl_pesan) as tanggal, SUM(total_harga) as total")
        ->where('tgl_pesan >=', date('Y-m-d', strtotime('-6 days')))
        ->where('status_pembayaran !=', 'dibatalkan')
        ->groupBy('DATE(tgl_pesan)')
        ->orderBy('tanggal', 'ASC')
        ->get()
        ->getResultArray();

    // Mapping 7 hari (default 0), agar grafik tetap tampil meski tidak ada transaksi di hari tersebut
    $labels7Hari = [];
    $data7Hari   = [];
    for ($i = 6; $i >= 0; $i--) {
        $tgl = date('Y-m-d', strtotime("-$i days"));
        $labels7Hari[$tgl] = date('d M', strtotime($tgl));
        $data7Hari[$tgl]   = 0;
    }
    foreach ($hasil7Hari as $row) {
        if (isset($data7Hari[$row['tanggal']])) {
            $data7Hari[$row['tanggal']] = (float) $row['total'];
        }
    }

    // 8. MONITORING STOK — Habis (=0) & Menipis (<=3)  (UTS E-Business)
    // ============================================================
    $stokHabis = $db->table('product_sizes')
        ->select('products.id, products.nama_produk, products.gambar, SUM(product_sizes.stok) as total_stok')
        ->join('products', 'products.id = product_sizes.product_id')
        ->groupBy('product_sizes.product_id')
        ->having('SUM(product_sizes.stok) =', 0)
        ->get()
        ->getResultArray();

    $stokMenipis = $db->table('product_sizes')
        ->select('products.id, products.nama_produk, products.gambar, SUM(product_sizes.stok) as total_stok')
        ->join('products', 'products.id = product_sizes.product_id')
        ->groupBy('product_sizes.product_id')
        ->having('SUM(product_sizes.stok) > 0')
        ->having('SUM(product_sizes.stok) <=', 3)
        ->get()
        ->getResultArray();

    // ============================================================

    // 7. PRODUK TERLARIS (UTS E-Business — Top 5)
    // ============================================================
    $produkTerlaris = $db->table('order_items')
        ->select('products.id, products.nama_produk, products.gambar, SUM(order_items.jumlah) as total_terjual')
        ->join('products', 'products.id = order_items.product_id')
        ->join('orders', 'orders.id = order_items.order_id')
        ->where('orders.status_pembayaran !=', 'dibatalkan')
        ->groupBy('products.id')
        ->orderBy('total_terjual', 'DESC')
        ->limit(5)
        ->get()
        ->getResultArray();

    // ============================================================

    // 4. Persiapkan data untuk dikirim ke view
    $data = [
        // ✅ FIX: sama seperti statistik bulan ini — 'omzet' (Total
        // Pendapatan sepanjang waktu) sekarang hanya menghitung order
        // yang statusnya 'sudah_bayar' (uang benar-benar diterima),
        // sebelumnya menjumlahkan SEMUA order termasuk yang belum
        // dibayar maupun yang dibatalkan.
        'omzet'             => $db->table('orders')->where('status_pembayaran', 'sudah_bayar')->selectSum('total_harga')->get()->getRow()->total_harga ?? 0,
        // ✅ FIX: 'total_pesanan' (Total Penjualan sepanjang waktu)
        // sekarang tidak menghitung pesanan yang dibatalkan.
        'total_pesanan'     => $db->table('orders')->where('status_pembayaran !=', 'dibatalkan')->countAllResults(),
        'total_produk'      => $db->table('products')->countAllResults(),
        
        // Data Stok Kritis hasil JOIN
        'stok_tipis_count'  => count($stokKritis),
        'stok_tipis_list'   => $stokKritis,
        
        // Data Grafik (Sekarang $dataBulanan sudah didefinisikan di atas)
        'chart_labels'      => json_encode(array_keys($dataBulanan)),
        'chart_data'        => json_encode(array_values($dataBulanan), JSON_NUMERIC_CHECK),

        // ⬇️ Tambahan Dashboard Penjualan Bulanan
        'total_transaksi_bulan_ini'   => $totalTransaksiBulanIni,
        'total_pendapatan_bulan_ini'  => $totalPendapatanBulanIni,
        'total_pesanan_bulan_ini'     => $totalPesananBulanIni,
        'rata_rata_transaksi'         => $rataRataTransaksi,
        'trend_pendapatan'            => $trendPendapatan,
        'trend_pesanan'               => $trendPesanan,

        // ✅ DIUBAH: dari 30 hari jadi 7 hari terakhir (nama variabel tetap
        // chart_30hari_* di sisi view/JS tidak diubah supaya minim risiko -
        // yang berubah cuma ISI datanya, sekarang 7 titik data bukan 30)
        'chart_30hari_labels' => json_encode(array_values($labels7Hari)),
        'chart_30hari_data'   => json_encode(array_values($data7Hari), JSON_NUMERIC_CHECK),

        // ⬇️ Produk Terlaris (Top 5)
        'produk_terlaris_list' => $produkTerlaris,

        // ⬇️ Monitoring Stok (Habis & Menipis)
        'stok_habis_list'      => $stokHabis,
        'stok_habis_count'     => count($stokHabis),
        'stok_menipis_list'    => $stokMenipis,
        'stok_menipis_count'   => count($stokMenipis),
    ];

    return view('admin/dashboard', $data);
}


   public function produk() {
    $db = \Config\Database::connect();
    
    // Query ini menggabungkan tabel products dengan product_sizes
    // Lalu menjumlahkan (SUM) semua stok berdasarkan ID produk
    $builder = $db->table('products')
                  ->select('products.*, SUM(product_sizes.stok) as total_stok')
                  ->join('product_sizes', 'product_sizes.product_id = products.id', 'left')
                  ->groupBy('products.id');

    // Fitur Search
    $search = $this->request->getGet('search');
    if ($search) {
        $builder->groupStart()
                ->like('nama_produk', $search)
                ->orLike('products.id', $search)
                ->groupEnd();
    }

    // Fitur Sortir menggunakan alias 'total_stok'
    $sort = $this->request->getGet('sort');
    if ($sort == 'stok_asc') $builder->orderBy('total_stok', 'ASC');
    if ($sort == 'harga_desc') $builder->orderBy('harga', 'DESC');

    $data = [
        'title'    => 'Manajemen Produk - Sport Center', // Judul dinamis
        'products' => $builder->get()->getResultArray(),
        'search'   => $search
    ];

    return view('admin/produk', $data);
}
    public function pesanan() {
        // Mengambil data dari tabel orders dengan JOIN ke users agar nama pembeli muncul
        $builder = $this->db->table('orders');
        $builder->select('orders.*, users.username');
        $builder->join('users', 'users.id = orders.user_id', 'left');
        
        // PENTING: Urutkan berdasarkan ID terbesar agar pesanan terbaru masuk di baris pertama
        $builder->orderBy('orders.id', 'DESC');
        
        $data['orders'] = $builder->get()->getResultArray();
        $data['title'] = 'Daftar Pesanan Pelanggan';
        
        // ======= ⬇️ INI KODE FIKS YANG DITAMBAHKAN/DIUBAH ⬇️ =======
        $data['totalNotifikasi'] = $this->db->table('orders')
                                            ->where('status_pengiriman', 'diproses')
                                            ->countAllResults();
        // ==========================================================

        return view('admin/pesanan', $data);
    }

    // ✅ DIUBAH: ditambahkan penanganan khusus untuk status 'dibatalkan'.
    // Sebelumnya kolom status_pengiriman di database sudah punya opsi enum
    // 'dibatalkan', tapi method ini belum punya cabang logika untuk itu,
    // sehingga kalau nilainya 'dibatalkan' akan jatuh ke blok "LOGIKA STATUS
    // LAIN" di bawah dan status_pembayaran malah direset jadi 'belum_bayar'
    // (padahal harusnya jadi 'dibatalkan' juga, sesuai enum kolom
    // status_pembayaran: belum_bayar, sudah_bayar, dibatalkan).
    public function update_status_pengiriman($id) {
    $db = \Config\Database::connect();
    $status_baru = $this->request->getPost('status_pengiriman');

    if ($status_baru === 'sampai') {
        // Ambil daftar barang yang dipesan
        $items = $db->table('order_items')
                    ->where('order_id', $id)
                    ->get()->getResultArray();

        foreach ($items as $item) {
            // Ambil SATU baris ukuran yang masih memiliki stok untuk produk ini
            $ukuranTersedia = $db->table('product_sizes')
                                 ->where('product_id', $item['product_id'])
                                 ->where('stok >', 0)
                                 ->get()
                                 ->getRowArray();

            if ($ukuranTersedia) {
                // Kurangi stok pada baris tersebut
                $db->table('product_sizes')
                   ->where('id', $ukuranTersedia['id'])
                   ->decrement('stok', $item['jumlah']);
            }
        }

        // Update status order
        $db->table('orders')->where('id', $id)->update([
            'status_pengiriman' => 'sampai',
            'status_pembayaran' => 'sudah_bayar'
        ]);

        return redirect()->to(base_url('admin/pesanan'))->with('success', 'Pesanan selesai, stok berhasil dikurangi.');
    }

    // ✅ BARU: penanganan khusus untuk pembatalan pesanan. status_pembayaran
    // ikut diset 'dibatalkan' (bukan direset ke 'belum_bayar' seperti status
    // lain), sesuai enum kolom status_pembayaran di database.
    if ($status_baru === 'dibatalkan') {
        $db->table('orders')->where('id', $id)->update([
            'status_pengiriman' => 'dibatalkan',
            'status_pembayaran' => 'dibatalkan',
        ]);

        return redirect()->to(base_url('admin/pesanan'))
                         ->with('success', 'Pesanan #' . $id . ' telah dibatalkan.');
    }

    // --- LOGIKA STATUS LAIN (diproses / dikirim) ---
    $db->table('orders')->where('id', $id)->update([
        'status_pengiriman' => $status_baru,
        'status_pembayaran' => 'belum_bayar' // Reset jika batal/kembali diproses
    ]);

    return redirect()->to(base_url('admin/pesanan'))->with('success', 'Status berhasil diperbarui.');
}

    // ✅ BARU: konfirmasi pembayaran manual (verifikasi bukti transfer bank)
    // Sebelumnya route ini sudah didaftarkan di Routes.php tapi method-nya
    // tidak pernah dibuat, jadi selalu 404 saat admin klik "Terima".
    public function terima_pembayaran($id)
    {
        $db    = \Config\Database::connect();
        $order = $db->table('orders')->where('id', $id)->get()->getRowArray();

        if (!$order) {
            return redirect()->to(base_url('admin/pesanan'))->with('error', 'Order tidak ditemukan.');
        }

        $db->table('orders')->where('id', $id)->update([
            'status_pembayaran' => 'sudah_bayar',
        ]);

        return redirect()->to(base_url('admin/pesanan'))
                         ->with('success', 'Pembayaran order #' . $id . ' telah dikonfirmasi.');
    }

    // ✅ BARU: tolak bukti transfer — status dikembalikan ke belum_bayar
    // dan file bukti lama dihapus supaya pelanggan bisa upload ulang.
    public function tolak_pembayaran($id)
    {
        $db    = \Config\Database::connect();
        $order = $db->table('orders')->where('id', $id)->get()->getRowArray();

        if (!$order) {
            return redirect()->to(base_url('admin/pesanan'))->with('error', 'Order tidak ditemukan.');
        }

        // Hapus file fisik bukti transfer lama jika ada
        if (!empty($order['bukti_transfer'])) {
            $path = ROOTPATH . 'public/uploads/bukti_transfer/' . $order['bukti_transfer'];
            if (is_file($path)) {
                @unlink($path);
            }
        }

        $db->table('orders')->where('id', $id)->update([
            'status_pembayaran' => 'belum_bayar',
            'bukti_transfer'    => null,
        ]);

        return redirect()->to(base_url('admin/pesanan'))
                         ->with('success', 'Bukti transfer order #' . $id . ' ditolak. Pelanggan perlu upload ulang.');
    }

    // ✅ FIX: sebelumnya kondisi where pada $fixTypo salah — mencari baris
    // yang SUDAH bernilai 'sudah_bayar' lalu meng-update-nya jadi
    // 'sudah_bayar' juga (tidak melakukan apa-apa). Tujuan aslinya adalah
    // merapikan data lama yang salah ketik ejaan 'sudah_payar' menjadi
    // 'sudah_bayar' yang benar, jadi kondisi where-nya sekarang mencari
    // 'sudah_payar' (ejaan lama yang typo).
    public function normalize_status_pembayaran()
    {
        $db = \Config\Database::connect();

        // 1) Rapikan typo ejaan lama: 'sudah_payar' -> 'sudah_bayar'
        $fixTypo = $db->table('orders')
                      ->where('status_pembayaran', 'sudah_payar')
                      ->update(['status_pembayaran' => 'sudah_bayar']);

        // 2) Rapikan order yang statusnya 'belum_bayar' padahal sudah
        //    ada bukti transfer (bukti_transfer terisi) -> arahkan ke
        //    'menunggu_verifikasi' supaya admin bisa memverifikasinya.
        $fixNyangkut = $db->table('orders')
                          ->where('status_pembayaran', 'belum_bayar')
                          ->where('bukti_transfer IS NOT NULL')
                          ->where('bukti_transfer !=', '')
                          ->update(['status_pembayaran' => 'menunggu_verifikasi']);

        return redirect()->to(base_url('admin/pesanan'))
                         ->with('success', 'Normalisasi selesai. Ejaan status lama sudah dirapikan dan order dengan bukti transfer yang sebelumnya tersangkut kini berstatus "Menunggu Verifikasi".');
    }
    

    public function user() {
    $builder = $this->db->table('users'); // Sesuai tabel di database Anda
    $data['users'] = $builder->get()->getResultArray();
    return view('admin/user', $data); // Ini akan memanggil file yang baru kita buat
}

    // ✅ BARU: dipanggil dari tombol "Blokir" di admin/user.php.
    // Butuh kolom users.status (lihat migration_users.sql).
    public function blokir_user($id)
    {
        $db   = \Config\Database::connect();
        $user = $db->table('users')->where('id', $id)->get()->getRowArray();

        if (!$user) {
            return redirect()->to(base_url('admin/user'))->with('error', 'User tidak ditemukan.');
        }
        if ($user['role'] === 'admin') {
            return redirect()->to(base_url('admin/user'))->with('error', 'Akun admin tidak bisa diblokir.');
        }

        $db->table('users')->where('id', $id)->update(['status' => 'diblokir']);

        return redirect()->to(base_url('admin/user'))
                         ->with('success', 'Akun @' . $user['username'] . ' berhasil diblokir.');
    }

    // ✅ BARU: dipanggil dari tombol "Aktifkan" di admin/user.php.
    public function aktifkan_user($id)
    {
        $db   = \Config\Database::connect();
        $user = $db->table('users')->where('id', $id)->get()->getRowArray();

        if (!$user) {
            return redirect()->to(base_url('admin/user'))->with('error', 'User tidak ditemukan.');
        }

        $db->table('users')->where('id', $id)->update(['status' => 'aktif']);

        return redirect()->to(base_url('admin/user'))
                         ->with('success', 'Akun @' . $user['username'] . ' berhasil diaktifkan kembali.');
    }

public function daftar_pesanan()
{
    $db = \Config\Database::connect();
    $data['pesanan'] = $db->table('pesanan')
        ->select('pesanan.*, products.nama_produk, users.username')
        ->join('products', 'products.id = pesanan.id_product')
        ->join('users', 'users.id = pesanan.id_user')
        ->get()->getResultArray();

    return view('admin/pesanan', $data);
}

public function transaksi()
{
    $db = \Config\Database::connect();

    // ✅ FIX (lanjutan): "Saldo Masuk" seharusnya cuma uang yang BENAR-
    // BENAR sudah diterima toko. Sebelumnya filter cuma "!= dibatalkan",
    // jadi order 'belum_bayar' dan 'menunggu_verifikasi' ikut terhitung
    // padahal uangnya belum tentu masuk sama sekali. Sekarang difilter
    // spesifik status_pembayaran = 'sudah_bayar' (lunas) saja.
    $data['total_masuk'] = $db->table('orders')
        ->where('status_pembayaran', 'sudah_bayar')
        ->selectSum('total_harga')
        ->get()->getRow()->total_harga ?? 0;

    // Tren saldo (bulan ini vs bulan lalu) — dihitung dari data asli,
    // dengan filter status yang sama (hanya yang sudah lunas).
    $bulanIni  = date('Y-m');
    $bulanLalu = date('Y-m', strtotime('-1 month'));

    $masukBulanIni = $db->table('orders')
        ->where("DATE_FORMAT(tgl_pesan, '%Y-%m')", $bulanIni)
        ->where('status_pembayaran', 'sudah_bayar')
        ->selectSum('total_harga')->get()->getRow()->total_harga ?? 0;

    $masukBulanLalu = $db->table('orders')
        ->where("DATE_FORMAT(tgl_pesan, '%Y-%m')", $bulanLalu)
        ->where('status_pembayaran', 'sudah_bayar')
        ->selectSum('total_harga')->get()->getRow()->total_harga ?? 0;

    $data['trend_saldo'] = $masukBulanLalu > 0
        ? round((($masukBulanIni - $masukBulanLalu) / $masukBulanLalu) * 100, 1)
        : ($masukBulanIni > 0 ? 100 : 0);

    // Tabel tetap menampilkan SEMUA order apa pun statusnya (supaya admin
    // bisa lihat riwayat lengkap termasuk yang belum/batal bayar), status
    // masing-masing baris ditandai lewat badge di view.
    $data['transaksi'] = $db->table('orders')
                            ->select('orders.*, users.username')
                            ->join('users', 'users.id = orders.user_id', 'left')
                            ->orderBy('orders.tgl_pesan', 'DESC')
                            ->get()
                            ->getResultArray();

    return view('admin/transaksi', $data);
}

    public function invoices()
{
    // 1. Hubungkan ke database dengan cara yang benar
    $db = \Config\Database::connect();

    // 2. Query data dengan chaining yang benar
    $invoices = $db->table('orders')
                           ->select('orders.*, users.username')
                           ->join('users', 'users.id = orders.user_id', 'left')
                           ->orderBy('orders.tgl_pesan', 'DESC') // Urutkan dari yang terbaru
                           ->get()
                           ->getResultArray();

    // ✅ BARU: ambil semua item pesanan sekaligus (1 query, bukan query
    // di dalam loop), lalu kelompokkan per order_id di PHP. Dipakai untuk
    // tombol "Lihat" yang sebelumnya dead link (href="#").
    $semuaItem = $db->table('order_items')
                    ->select('order_items.order_id, order_items.jumlah, order_items.subtotal, products.nama_produk')
                    ->join('products', 'products.id = order_items.product_id', 'left')
                    ->get()->getResultArray();

    $itemPerOrder = [];
    foreach ($semuaItem as $item) {
        $itemPerOrder[$item['order_id']][] = $item;
    }
    foreach ($invoices as &$inv) {
        $inv['items'] = $itemPerOrder[$inv['id']] ?? [];
    }
    unset($inv);

    $data['invoices'] = $invoices;

    return view('admin/invoices', $data);
}

    public function laporan()
{
    $db = \Config\Database::connect();

    // Kita ambil SEMUA data KECUALI yang 'dibatalkan'
    $statusTidakDihitung = 'dibatalkan';

    // 1. Total Barang Terjual (Semua pesanan yang tidak dibatalkan)
    $totalQty = $db->table('order_items')
                   ->join('orders', 'orders.id = order_items.order_id')
                   ->where('orders.status_pembayaran !=', $statusTidakDihitung)
                   ->selectSum('order_items.jumlah', 'total')
                   ->get()->getRow();

    // 2. Omset (Semua pesanan yang tidak dibatalkan)
    $omset = $db->table('orders')
                ->where('status_pembayaran !=', $statusTidakDihitung)
                ->selectSum('total_harga', 'total')
                ->get()->getRow();
    
    // 3. Produk Terlaris (Semua yang tidak dibatalkan)
    $terlaris = $db->table('order_items')
                   ->select('products.nama_produk, SUM(order_items.jumlah) as total')
                   ->join('products', 'products.id = order_items.product_id')
                   ->join('orders', 'orders.id = order_items.order_id')
                   ->where('orders.status_pembayaran !=', $statusTidakDihitung)
                   ->groupBy('products.id')
                   ->orderBy('total', 'DESC')
                   ->limit(1)
                   ->get()->getRow();

    // 4. Riwayat Penjualan
    $riwayat = $db->table('orders')
                  ->where('status_pembayaran !=', $statusTidakDihitung)
                  ->select("DATE_FORMAT(tgl_pesan, '%M %Y') as bulan, COUNT(*) as jumlah_pesanan, SUM(total_harga) as total_pendapatan")
                  ->groupBy('bulan')
                  ->orderBy("MAX(tgl_pesan)", "DESC")
                  ->get()->getResultArray();

    $data = [
        'total_terjual'   => $totalQty->total ?? 0,
        'omset_bulan'     => $omset->total ?? 0,
        'produk_terlaris' => $terlaris->nama_produk ?? '-',
        'riwayat_data'    => $riwayat
    ];

    return view('admin/laporan', $data);
}
    public function feedback()
{
    $db = \Config\Database::connect();
    
    $builder = $db->table('orders');
    $builder->select('orders.*, users.nama AS nama_pelanggan'); // Mengambil nama dari tabel users
    $builder->join('users', 'users.id = orders.user_id', 'left'); // Menghubungkan orders ke users
    $builder->where('orders.ulasan IS NOT NULL'); // Hanya ambil yang sudah ada ulasannya
    $builder->where('orders.ulasan !=', '');
    
    $data['ulasan_pelanggan'] = $builder->get()->getResultArray();

    return view('admin/feedback', $data);
}

    // ⬇️ METHOD BARU: Menyimpan balasan admin untuk ulasan pelanggan
    public function balas_ulasan($id)
    {
        $db = \Config\Database::connect();

        $balasan = $this->request->getPost('balasan_admin');

        $db->table('orders')->where('id', $id)->update([
            'balasan_admin' => $balasan
        ]);

        return redirect()->to(base_url('admin/feedback'))->with('success', 'Balasan berhasil disimpan.');
    }
    // ✅ BARU: memastikan tabel 'pengaturan_toko' ada di database.
    // Dibuat otomatis lewat kode (CREATE TABLE IF NOT EXISTS) supaya
    // tidak perlu menjalankan file SQL migration secara manual. Kalau
    // tabel masih kosong, diisi dulu dengan data default (nilai yang
    // sebelumnya hardcode), supaya form tidak pernah tampil kosong.
    private function ensurePengaturanTable($db)
    {
        $db->query("CREATE TABLE IF NOT EXISTS pengaturan_toko (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nama_toko VARCHAR(255) NOT NULL DEFAULT '',
            jalan VARCHAR(255) NOT NULL DEFAULT '',
            kecamatan VARCHAR(100) NOT NULL DEFAULT '',
            kota VARCHAR(100) NOT NULL DEFAULT '',
            provinsi VARCHAR(100) NOT NULL DEFAULT '',
            kode_pos VARCHAR(20) NOT NULL DEFAULT '',
            no_telepon VARCHAR(50) NOT NULL DEFAULT '',
            email VARCHAR(100) NOT NULL DEFAULT '',
            jam_operasional VARCHAR(255) NOT NULL DEFAULT ''
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $jumlahBaris = $db->table('pengaturan_toko')->countAllResults();
        if ($jumlahBaris === 0) {
            $db->table('pengaturan_toko')->insert([
                'nama_toko'       => 'Sport Center Pemalang',
                'jalan'           => 'JL.Menur 7 Gang Depot.Kebukuran, Kebojongan',
                'kecamatan'       => 'Comal',
                'kota'            => 'Pemalang',
                'provinsi'        => 'Jawa Tengah',
                'kode_pos'        => '52362',
                'no_telepon'      => '0812-3456-xxxx',
                'email'           => 'halo@sportcenter.id',
                'jam_operasional' => 'Senin – Sabtu, 08.00 – 17.00 WIB',
            ]);
        }
    }

    public function pengaturan()
{
    $db = \Config\Database::connect();
    $this->ensurePengaturanTable($db);

    // ✅ FIX: sekarang alamat diambil dari database (tabel
    // 'pengaturan_toko'), bukan array hardcode lagi — jadi begitu admin
    // klik "Simpan Perubahan", perubahan yang tersimpan benar-benar
    // muncul kembali di halaman ini.
    $alamat = $db->table('pengaturan_toko')->get()->getRowArray() ?? [];

    // 'maps_link' tetap dibangun OTOMATIS dari komponen alamat (jalan,
    // kecamatan, kota, provinsi, kode_pos), memakai format pencarian
    // Google Maps (https://www.google.com/maps?q=ALAMAT&output=embed)
    // yang tidak perlu API key. Jadi begitu alamat diubah & disimpan,
    // peta ikut otomatis mengikuti alamat yang baru.
    $alamatLengkap = implode(', ', array_filter([
        $alamat['jalan'] ?? '',
        !empty($alamat['kecamatan']) ? 'Kec. ' . $alamat['kecamatan'] : '',
        $alamat['kota'] ?? '',
        $alamat['provinsi'] ?? '',
        $alamat['kode_pos'] ?? '',
    ]));

    $alamat['maps_link'] = $alamatLengkap !== ''
        ? 'https://www.google.com/maps?q=' . urlencode($alamatLengkap) . '&output=embed'
        : '';

    $data['alamat_admin'] = $alamat;

    return view('admin/pengaturan', $data);
}

    public function simpan_pengaturan()
    {
        $db = \Config\Database::connect();
        $this->ensurePengaturanTable($db);

        $baris = $db->table('pengaturan_toko')->get()->getRowArray();

        // ✅ FIX: sebelumnya method ini tidak pernah menyentuh database
        // sama sekali (langsung redirect dengan pesan error). Sekarang
        // datanya benar-benar di-UPDATE ke tabel 'pengaturan_toko'.
        $dataUpdate = [
            'nama_toko'       => $this->request->getPost('nama_toko') ?? '',
            'jalan'           => $this->request->getPost('jalan') ?? '',
            'kecamatan'       => $this->request->getPost('kecamatan') ?? '',
            'kota'            => $this->request->getPost('kota') ?? '',
            'provinsi'        => $this->request->getPost('provinsi') ?? '',
            'kode_pos'        => $this->request->getPost('kode_pos') ?? '',
            'no_telepon'      => $this->request->getPost('no_telepon') ?? '',
            'email'           => $this->request->getPost('email') ?? '',
            'jam_operasional' => $this->request->getPost('jam_operasional') ?? '',
        ];

        $db->table('pengaturan_toko')->where('id', $baris['id'])->update($dataUpdate);

        return redirect()->to(base_url('admin/pengaturan'))
                         ->with('success', 'Pengaturan toko berhasil disimpan.');
    }
    public function promosi()
    {
        return redirect()->to(base_url('admin/dashboard'))
                         ->with('error', 'Fitur Promosi belum tersedia — perlu tabel database baru untuk kode promo/voucher.');
    }

    public function bulk_action()
{
    $productIds = $this->request->getPost('product_ids'); // Mengambil ID yang dicentang
    $action = $this->request->getPost('action');        // Mengambil aksi (hapus/ubah status)

    if (empty($productIds)) {
        return redirect()->back()->with('error', 'Pilih produk terlebih dahulu!');
    }

    $db = \Config\Database::connect();
    $builder = $db->table('products');

    if ($action === 'delete') {
        $builder->whereIn('id', $productIds)->delete();
        $message = 'Produk yang dipilih berhasil dihapus.';
    } 
    elseif ($action === 'status_habis') {
    // Update stok menjadi 0 di tabel product_sizes untuk produk yang dipilih
    $db->table('product_sizes')
       ->whereIn('product_id', $productIds)
       ->update(['stok' => 0]);
    $message = 'Status stok semua ukuran produk terpilih berhasil diubah menjadi habis.';
}

    return redirect()->to(base_url('admin/produk'))->with('success', $message);
}
// --- TAMBAHKAN KODE INI DI BAGIAN BAWAH CONTROLLER ADMIN.PHP ---

    public function edit($id)
    {
        $db = \Config\Database::connect();
        
        // Mengambil data produk berdasarkan ID beserta total stok gabungannya
        $product = $db->table('products')
                      ->select('products.*, SUM(product_sizes.stok) as stok_gabungan')
                      ->join('product_sizes', 'product_sizes.product_id = products.id', 'left')
                      ->where('products.id', $id)
                      ->groupBy('products.id')
                      ->get()
                      ->getRowArray();

        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Produk dengan ID $id tidak ditemukan");
        }

        $data = [
            'title'   => 'Edit Produk - Admin',
            'product' => $product
        ];

        return view('admin/produk_edit', $data);
    }

    public function update($id)
{
    $db = \Config\Database::connect();

    // ⬇️ VALIDASI: stok tidak boleh bernilai negatif (UTS E-Business)
    $stokInput = (int) ($this->request->getPost('stok') ?? 0);
    if ($stokInput < 0) {
        return redirect()->back()->withInput()->with('error', 'Stok tidak boleh bernilai negatif.');
    }

    // 1. Ambil data teks dari form edit admin
    $dataUpdate = [
        'nama_produk' => $this->request->getPost('nama_produk'),
        'harga'       => $this->request->getPost('harga'),
        'category_id' => $this->request->getPost('category_id'),
        'deskripsi'   => $this->request->getPost('deskripsi') ?? '',
        // ⬇️ Spesifikasi Produk (kolom sudah ada di tabel products)
        'merk'        => $this->request->getPost('merk') ?? '',
        'bahan'       => $this->request->getPost('bahan') ?? '',
        'warna'       => $this->request->getPost('warna') ?? '',
        'berat'       => $this->request->getPost('berat') ?? 0,
    ];

    // 2. Proses upload foto baru jika ada
    $fileGambar = $this->request->getFile('gambar');
    if ($fileGambar && $fileGambar->isValid() && !$fileGambar->hasMoved()) {
        $namaGambarBaru = $fileGambar->getRandomName();
        $fileGambar->move(ROOTPATH . 'public/images', $namaGambarBaru);
        $dataUpdate['gambar'] = $namaGambarBaru;
    }

    // 3. Update data dasar produk di tabel 'products'
    $db->table('products')->where('id', $id)->update($dataUpdate);

    // 4. MANAGEMENT STOK SESUAI DATABASE MULTI-UKURAN
    // (stok sudah divalidasi >= 0 di awal method)

    // Ambil semua daftar varian ukuran yang ada untuk produk ini
    $daftarUkuran = $db->table('product_sizes')->where('product_id', $id)->get()->getResultArray();

    if (!empty($daftarUkuran)) {
        // Hitung berapa banyak varian ukuran (misal: S, M, L, XL = 4 ukuran)
        $jumlahVarian = count($daftarUkuran);
        
        // Bagi rata stok input ke masing-masing varian ukuran
        $stokPerUkuran = floor($stokInput / $jumlahVarian);
        $sisaStok      = $stokInput % $jumlahVarian; // Sisa pembagian jika angka ganjil

        foreach ($daftarUkuran as $index => $ukuran) {
            // Tambahkan sisa pembagian ke varian ukuran pertama agar totalnya pas
            $stokFinal = ($index === 0) ? ($stokPerUkuran + $sisaStok) : $stokPerUkuran;

            // Update stok masing-masing baris id ukuran di database
            $db->table('product_sizes')
               ->where('id', $ukuran['id'])
               ->update(['stok' => $stokFinal]);
        }
    } else {
        // Jika produk baru ternyata belum punya data ukuran sama sekali di database, 
        // kita buatkan varian standar (S, M, L, XL) dengan membagi rata stoknya.
        $varianStandar = ['S', 'M', 'L', 'XL'];
        $stokPerUkuran = floor($stokInput / 4);
        $sisaStok      = $stokInput % 4;

        foreach ($varianStandar as $index => $uk) {
            $stokFinal = ($index === 0) ? ($stokPerUkuran + $sisaStok) : $stokPerUkuran;

            $db->table('product_sizes')->insert([
                'product_id' => $id,
                'ukuran'     => $uk,
                'stok'       => $stokFinal
            ]);
        }
    }

    // 5. Kembali ke halaman manajemen produk admin dengan notifikasi sukses
    return redirect()->to(base_url('admin/produk'))->with('success', 'Data produk dan stok berhasil disinkronkan!');
}
public function tambah()
    {
        $data = [
            'title' => 'Tambah Produk Baru - Admin'
        ];
        return view('admin/produk_tambah', $data);
    }

    public function simpan()
    {
        $db = \Config\Database::connect();

        // ✅ FIX: sebelumnya method ini masih baca stok sebagai SATU angka
        // tunggal (int) padahal form produk_tambah.php sudah dikirim
        // sebagai ARRAY per ukuran: stok[S], stok[M], stok[L], stok[XL].
        //
        // (int) pada sebuah array di PHP jadi bernilai 1 (bukan error),
        // sehingga stok yang benar-benar diinput admin di form diabaikan
        // total — hanya angka "1" itu yang dibagi rata ke 4 ukuran
        // (S=1, M=0, L=0, XL=0). Itu sebabnya stok akhir selalu kecil.
        $stokPerUkuranInput = $this->request->getPost('stok'); // ['S'=>.., 'M'=>.., 'L'=>.., 'XL'=>..]

        if (!is_array($stokPerUkuranInput)) {
            return redirect()->back()->withInput()->with('error', 'Data stok per ukuran tidak valid.');
        }

        // Validasi setiap ukuran tidak boleh negatif, sekaligus bersihkan ke integer
        $stokPerUkuran = [];
        foreach (['S', 'M', 'L', 'XL'] as $ukuran) {
            $nilai = (int) ($stokPerUkuranInput[$ukuran] ?? 0);
            if ($nilai < 0) {
                return redirect()->back()->withInput()->with('error', 'Stok tidak boleh bernilai negatif.');
            }
            $stokPerUkuran[$ukuran] = $nilai;
        }

        // 1. Ambil data input dari Form Tambah
        $dataInsert = [
            'nama_produk' => $this->request->getPost('nama_produk'),
            'harga'       => $this->request->getPost('harga'),
            'category_id' => $this->request->getPost('category_id'),
            'diskon'      => (int) ($this->request->getPost('diskon') ?? 0),
            'deskripsi'   => $this->request->getPost('deskripsi') ?? '',
            // ⬇️ Spesifikasi Produk (kolom sudah ada di tabel products)
            'merk'        => $this->request->getPost('merk') ?? '',
            'bahan'       => $this->request->getPost('bahan') ?? '',
            'warna'       => $this->request->getPost('warna') ?? '',
            'berat'       => $this->request->getPost('berat') ?? 0,
        ];

        // 2. Proses upload file gambar produk
        $fileGambar = $this->request->getFile('gambar');
        if ($fileGambar && $fileGambar->isValid() && !$fileGambar->hasMoved()) {
            $namaGambarBaru = $fileGambar->getRandomName();
            $fileGambar->move(ROOTPATH . 'public/images', $namaGambarBaru);
            $dataInsert['gambar'] = $namaGambarBaru;
        } else {
            $dataInsert['gambar'] = 'default.jpg'; // Gambar cadangan jika admin tidak upload
        }

        // 3. Masukkan data dasar ke tabel 'products'
        $db->table('products')->insert($dataInsert);
        
        // Dapatkan ID produk yang baru saja di-generate oleh sistem database
        $productIdBaru = $db->insertID();

        // 4. ✅ FIX: insert stok per ukuran PERSIS sesuai input admin di form,
        // bukan dibagi rata lagi.
        foreach ($stokPerUkuran as $ukuran => $stok) {
            $db->table('product_sizes')->insert([
                'product_id' => $productIdBaru,
                'ukuran'     => $ukuran,
                'stok'       => $stok
            ]);
        }

        // 5. Redirect kembali ke halaman manajemen produk utama
        return redirect()->to(base_url('admin/produk'))->with('success', 'Produk baru berhasil ditambahkan dan stok per ukuran tersimpan sesuai input!');
    }
    public function delete($id) {
        $db = \Config\Database::connect();
        
        // Hapus child data di product_sizes dulu agar tidak melanggar Foreign Key Constraint
        $db->table('product_sizes')->where('product_id', $id)->delete();
        
        // Hapus master data di products
        $db->table('products')->where('id', $id)->delete();
        
        return redirect()->to(base_url('admin/produk'))->with('success', 'Produk berhasil dihapus!');
    }

    
}