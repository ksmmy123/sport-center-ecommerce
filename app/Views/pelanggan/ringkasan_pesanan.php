<?= $this->extend('layout/pelanggan_layout') ?>
<?= $this->section('content') ?>
<?php
    $dari_keranjang   = !empty($items);
    $biaya_layanan    = $biaya_layanan    ?? 1000;
    $biaya_penanganan = $biaya_penanganan ?? 500;
    
    // Ambil variabel jumlah/qty jika dibeli langsung, default jadi 1 jika tidak ada
    $jumlah_beli      = $jumlah ?? 1;

    $total_diskon_item = 0;
    $subtotal_kotor    = 0;

    if ($dari_keranjang) {
        // Hitung subtotal kotor dan total diskon dari item keranjang yang di-JOIN dengan tabel produk
        foreach (($items ?? []) as $it) {
            $harga_satuan = $it['harga_asli'] ?? $it['harga'] ?? 0;
            $jumlah       = $it['jumlah'] ?? 1;
            $subtotal_kotor += ($harga_satuan * $jumlah);

            $diskon_persen = $it['diskon'] ?? 0;
            if ($diskon_persen > 0) {
                $disc_item = ($harga_satuan * $diskon_persen / 100) * $jumlah;
                $total_diskon_item += $disc_item;
            }
        }
        $subtotal_produk = $subtotal_kotor - $total_diskon_item;
    } else {
        $diskon_persen   = $produk['diskon'] ?? 0;
        $harga_asli_prod = $produk['harga'] * $jumlah_beli; // Dikalikan dengan qty langsung
        $nominal_diskon  = ($harga_asli_prod * $diskon_persen) / 100;
        $subtotal_produk = $harga_asli_prod - $nominal_diskon;
        $total_diskon_item = $nominal_diskon;
    }
    $total_awal = $subtotal_produk + $biaya_layanan + $biaya_penanganan;
?>
<style>
    /* ── TOP NAV ── */
    .rs-topbar {
        display: flex; align-items: center; gap: 14px;
        margin-bottom: 28px; padding-bottom: 20px;
        border-bottom: 1px solid var(--border);
    }
    .rs-back {
        width: 38px; height: 38px; border-radius: 50%;
        background: var(--surface-raised); border: 1px solid var(--border);
        display: flex; align-items: center; justify-content: center;
        color: var(--ink); text-decoration: none; font-size: 14px; flex-shrink: 0;
        transition: background var(--transition);
    }
    .rs-back:hover { background: var(--surface-high); }
    .rs-page-title { font-size: 20px; font-weight: 800; letter-spacing: -0.5px; color: var(--ink); }

    /* ── LAYOUT ── */
    .rs-grid {
        display: grid;
        grid-template-columns: 1fr 360px;
        gap: 20px;
        align-items: start;
    }

    /* ── CARD ── */
    .rs-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg); overflow: hidden; margin-bottom: 14px; }
    .rs-ico { width: 30px; height: 30px; border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; font-size: 13px; flex-shrink: 0; }
    .rs-ico.orange { background: var(--brand-subtle); color: var(--brand); }
    .rs-ico.red    { background: rgba(239,68,68,0.12); color: #f87171; }
    .rs-ico.green  { background: rgba(34,197,94,0.12); color: #4ade80; }
    .rs-ico.blue   { background: rgba(59,130,246,0.12); color: #60a5fa; }

    /* ── SECTION DALAM SATU CARD ── */
    .rs-section { padding: 18px; }
    .rs-section + .rs-section {
        border-top: 1px solid var(--border);
    }
    .rs-section-label {
        display: flex; align-items: center; gap: 8px;
        font-size: 12px; font-weight: 700;
        color: var(--ink-secondary);
        text-transform: uppercase; letter-spacing: 0.8px;
        margin-bottom: 12px;
    }
    .rs-section-label .rs-ico { width: 24px; height: 24px; font-size: 11px; }

    /* ── TOKO ── */
    .store-name { font-size: 14px; font-weight: 700; color: var(--ink); margin-bottom: 3px; }
    .store-addr { font-size: 12.5px; color: var(--ink-secondary); line-height: 1.5; }
    .store-maps { display: inline-flex; align-items: center; gap: 5px; font-size: 12px; color: #60a5fa; text-decoration: none; margin-top: 6px; font-weight: 500; }

    /* ── ALAMAT ── */
    .addr-row { display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; }
    .addr-name { font-size: 14px; font-weight: 700; color: var(--ink); margin-bottom: 3px; }
    .addr-text  { font-size: 13px; color: var(--ink-secondary); line-height: 1.5; }
    .addr-empty { font-size: 12.5px; color: #f87171; font-style: italic; }
    .btn-ubah {
        font-size: 12px; font-weight: 700; color: var(--brand); text-decoration: none;
        white-space: nowrap; padding: 5px 10px; border: 1px solid rgba(249,115,22,0.3);
        border-radius: var(--radius-sm); background: var(--brand-subtle); flex-shrink: 0;
        transition: background var(--transition);
    }
    .btn-ubah:hover { background: rgba(249,115,22,0.25); }
    .kota-label { font-size: 11px; font-weight: 700; color: var(--ink-muted); text-transform: uppercase; letter-spacing: 0.8px; display: block; margin: 16px 0 8px; }
    .kota-select {
        width: 100%; padding: 11px 36px 11px 14px;
        border-radius: var(--radius-md); border: 1.5px solid var(--border);
        background: var(--surface-raised); color: var(--ink);
        font-family: 'Outfit', sans-serif; font-size: 13.5px; cursor: pointer; outline: none;
        transition: border-color var(--transition), box-shadow var(--transition);
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 14px center;
    }
    .kota-select:focus { border-color: var(--brand); box-shadow: 0 0 0 3px var(--brand-glow); }

    /* ── PRODUK ── */
    .product-row { display: flex; gap: 14px; align-items: center; padding: 10px 0; border-bottom: 1px solid var(--border-light); }
    .product-row:last-child { border-bottom: none; padding-bottom: 0; }
    .product-thumb { width: 64px; height: 64px; border-radius: var(--radius-md); overflow: hidden; background: var(--surface-raised); border: 1px solid var(--border); flex-shrink: 0; }
    .product-thumb img { width: 100%; height: 100%; object-fit: cover; }
    .product-detail { flex: 1; min-width: 0; }
    .product-nm { font-size: 13.5px; font-weight: 700; color: var(--ink); margin-bottom: 3px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .product-var { font-size: 11.5px; color: var(--ink-muted); margin-bottom: 4px; }
    .product-price { font-size: 14px; font-weight: 800; color: var(--ink); }
    .product-price-old { font-size: 11px; color: var(--ink-muted); text-decoration: line-through; margin-right: 5px; }

    /* ── HARGA ── */
    .price-list { display: flex; flex-direction: column; gap: 8px; }
    .price-row-i { display: flex; justify-content: space-between; align-items: center; font-size: 13px; color: var(--ink-secondary); }
    .price-row-i span:last-child { font-weight: 600; color: var(--ink); }
    .price-row-i.disc { color: #4ade80; }
    .price-row-i.disc span:last-child { color: #4ade80; }
    .price-divider { height: 1px; background: var(--border); margin: 8px 0; }
    .price-total { display: flex; justify-content: space-between; align-items: center; padding: 12px 0 0; }
    .price-total-label { font-size: 15px; font-weight: 800; color: var(--ink); }
    .price-total-val { font-size: 22px; font-weight: 800; color: var(--brand); letter-spacing: -0.5px; }

    /* ── METODE PEMBAYARAN ── */
    .payment-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    .payment-option {
        display: flex; align-items: center; gap: 10px; padding: 12px 14px;
        border: 1.5px solid var(--border); border-radius: var(--radius-md);
        cursor: pointer; background: var(--surface-raised);
        transition: border-color var(--transition), background var(--transition);
    }
    .payment-option input[type="radio"] { accent-color: var(--brand); width: 16px; height: 16px; flex-shrink: 0; }
    .payment-content { display: flex; flex-direction: column; gap: 2px; }
    .payment-title { font-size: 13px; font-weight: 700; color: var(--ink); }
    .payment-desc  { font-size: 10px; color: var(--ink-muted); }
    .payment-option:has(input:checked) { border-color: var(--brand); background: var(--brand-subtle); }
    .payment-option:has(input:checked) .payment-title { color: var(--brand); }

    /* ── TOMBOL PESAN ── */
    .btn-pesan {
        width: 100%;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        background: var(--brand); color: #fff; border: none;
        padding: 15px;
        border-radius: var(--radius-md);
        font-family: 'Outfit', sans-serif; font-size: 15px; font-weight: 700;
        cursor: pointer;
        box-shadow: 0 4px 16px rgba(249,115,22,0.35);
        transition: background var(--transition), transform var(--transition), box-shadow var(--transition);
        margin-top: 4px;
    }
    .btn-pesan:hover { background: var(--brand-dark); transform: translateY(-1px); box-shadow: 0 6px 22px rgba(249,115,22,0.45); }
    .btn-pesan:active { transform: translateY(0); }

    /* ── RESPONSIVE ── */
    @media (max-width: 860px) {
        .rs-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 768px) {
        .payment-grid { grid-template-columns: 1fr; }
        .rs-grid > div:last-child .rs-card { position: static !important; top: auto !important; }
        .rs-section { padding: 14px 16px; }
        .product-nm { font-size: 13px; }
        .price-total-val { font-size: 19px; }
    }
</style>

<!-- TOP NAV -->
<div class="rs-topbar">
    <a href="javascript:history.back()" class="rs-back"><i class="fa-solid fa-arrow-left"></i></a>
    <h1 class="rs-page-title">Ringkasan Pesanan</h1>
</div>

<form action="<?= base_url('pelanggan/proses_pesanan') ?>" method="POST" id="formPesanan">
    <?= csrf_field() ?>
    <input type="hidden" name="kota_tujuan"     id="input_kota"   value="<?= esc($user_kota ?? '') ?>">
    <input type="hidden" name="ongkir"          id="input_ongkir" value="0">
    <input type="hidden" name="biaya_layanan"    value="<?= $biaya_layanan ?>">
    <input type="hidden" name="biaya_penanganan" value="<?= $biaya_penanganan ?>">
    <input type="hidden" name="total_harga"     id="input_total"  value="<?= $total_awal ?>">
    <input type="hidden" name="metode"          id="input_metode" value="cod">

    <?php if ($dari_keranjang): ?>
        <?php foreach (($id_keranjang ?? []) as $idk): ?>
            <input type="hidden" name="id_keranjang[]" value="<?= (int)$idk ?>">
        <?php endforeach; ?>
        <input type="hidden" name="dari_keranjang" value="1">
    <?php else: ?>
        <input type="hidden" name="id_produk" value="<?= (int)$produk['id'] ?>">
        <input type="hidden" name="id_size"   value="<?= (int)$ukuran_pilihan['id'] ?>">
        <!-- INPUT JUMLAH QTY AGAR TERKIRIM KE CONTROLLER -->
        <input type="hidden" name="jumlah"    value="<?= (int)$jumlah_beli ?>">
    <?php endif; ?>

    <div class="rs-grid">

        <!-- ════ KIRI — Satu card dengan beberapa section ════ -->
        <div>
            <div class="rs-card">

                <!-- Section: Dikirim dari -->
                <div class="rs-section">
                    <div class="rs-section-label">
                        <span class="rs-ico orange"><i class="fa-solid fa-store"></i></span>
                        Dikirim Dari
                    </div>
                    <div class="store-name"><?= esc($alamat_admin['nama_toko']) ?></div>
                    <div class="store-addr"><?= esc($alamat_admin['jalan']) ?>, Kec. <?= esc($alamat_admin['kecamatan']) ?>, <?= esc($alamat_admin['kota']) ?></div>
                    <a href="<?= $alamat_admin['maps_link'] ?>" target="_blank" class="store-maps">
                        <i class="fa-solid fa-map-location-dot"></i> Lihat di Maps
                    </a>
                </div>

                <!-- Section: Alamat pengiriman -->
                <div class="rs-section">
                    <div class="rs-section-label">
                        <span class="rs-ico red"><i class="fa-solid fa-location-dot"></i></span>
                        Alamat Pengiriman
                    </div>
                    <div class="addr-row">
                        <div style="flex:1;">
                            <div class="addr-name">
                                <?= esc($user_nama ?? '-') ?>
                                <?php if (!empty($user_telp)): ?>
                                    <span style="font-weight:400;color:var(--ink-secondary);font-size:12px;"> · <?= esc($user_telp) ?></span>
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($user_alamat)): ?>
                                <div class="addr-text"><?= esc($user_alamat) ?></div>
                            <?php else: ?>
                                <div class="addr-empty"><i class="fa-solid fa-triangle-exclamation"></i> Alamat belum diatur.</div>
                            <?php endif; ?>
                        </div>
                        <a href="<?= base_url('pelanggan/edit_profile') ?>" class="btn-ubah">Ubah</a>
                    </div>
                    <label class="kota-label"><i class="fa-solid fa-truck"></i> Pilih Kota Tujuan</label>
                    <select id="pilih_kota" class="kota-select" onchange="hitungOngkir()" required>
                        <option value="" data-ongkir="0">— Pilih Kota —</option>
                        <?php foreach ($wilayah as $w): ?>
                            <option value="<?= esc($w['nama_kota']) ?>"
                                    data-ongkir="<?= (int)$w['biaya_ongkir'] ?>"
                                    <?= (($w['nama_kota'] ?? '') == ($user_kota ?? '')) ? 'selected' : '' ?>>
                                <?= esc($w['nama_kota']) ?> (Rp <?= number_format($w['biaya_ongkir'], 0, ',', '.') ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Section: Produk -->
                <div class="rs-section">
                    <div class="rs-section-label">
                        <span class="rs-ico green"><i class="fa-solid fa-bag-shopping"></i></span>
                        Produk Dipesan<?= $dari_keranjang ? ' (' . count($items) . ' item)' : '' ?>
                    </div>
                    <?php if ($dari_keranjang): ?>
                        <?php foreach ($items as $item): ?>
                        <?php
                            $hs = $item['harga_asli'] ?? $item['harga'] ?? 0;
                            $dp = $item['diskon'] ?? 0;
                            $nd = ($hs * $dp) / 100;
                            $hf = $hs - $nd;
                        ?>
                        <div class="product-row">
                            <div class="product-thumb"><img src="<?= base_url('images/' . $item['gambar']) ?>" alt="<?= esc($item['nama_produk']) ?>"></div>
                            <div class="product-detail">
                                <div class="product-nm"><?= esc($item['nama_produk']) ?></div>
                                <div class="product-var">Qty: <?= (int)$item['jumlah'] ?></div>
                                <?php if ($dp > 0): ?><span class="product-price-old">Rp <?= number_format($hs, 0, ',', '.') ?></span><?php endif; ?>
                                <span class="product-price">Rp <?= number_format($hf * $item['jumlah'], 0, ',', '.') ?></span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <?php
                            $dp  = $produk['diskon'] ?? 0;
                            $nd  = ($produk['harga'] * $dp) / 100;
                            $hf  = $produk['harga'] - $nd;
                        ?>
                        <div class="product-row">
                            <div class="product-thumb"><img src="<?= base_url('images/' . $produk['gambar']) ?>" alt="<?= esc($produk['nama_produk']) ?>"></div>
                            <div class="product-detail">
                                <div class="product-nm"><?= esc($produk['nama_produk']) ?></div>
                                <div class="product-var">Ukuran: <?= esc($ukuran_pilihan['ukuran']) ?> | Qty: <?= (int)$jumlah_beli ?></div>
                                <?php if ($dp > 0): ?><span class="product-price-old">Rp <?= number_format($produk['harga'] * $jumlah_beli, 0, ',', '.') ?></span><?php endif; ?>
                                <span class="product-price">Rp <?= number_format($hf * $jumlah_beli, 0, ',', '.') ?></span>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- ════ KANAN — Ringkasan & Pembayaran (1 card) ════ -->
        <div>
            <div class="rs-card" style="position:sticky; top:24px;">

                <!-- Section: Metode pembayaran -->
                <div class="rs-section">
                    <div class="rs-section-label">
                        <span class="rs-ico blue"><i class="fa-solid fa-wallet"></i></span>
                        Metode Pembayaran
                    </div>
                    <div class="payment-grid">
                        <label class="payment-option" onclick="setMetode('cod')">
                            <input type="radio" name="metode_display" value="cod" checked>
                            <div class="payment-content">
                                <span class="payment-title">COD</span>
                                <span class="payment-desc">Bayar di Tempat</span>
                            </div>
                        </label>
                        <label class="payment-option" onclick="setMetode('va_bank')">
                            <input type="radio" name="metode_display" value="va_bank">
                            <div class="payment-content">
                                <span class="payment-title">Transfer</span>
                                <span class="payment-desc">BRI 1234-567-890</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Section: Rincian harga + total + tombol -->
                <div class="rs-section">
                    <div class="rs-section-label">
                        <span class="rs-ico orange"><i class="fa-solid fa-receipt"></i></span>
                        Rincian Pembayaran
                    </div>

                    <div class="price-list">
                        <div class="price-row-i">
                            <span>Subtotal Produk</span>
                            <span>Rp <?= number_format($dari_keranjang ? $subtotal_kotor : ($produk['harga'] * $jumlah_beli), 0, ',', '.') ?></span>
                        </div>

                        <?php if ($total_diskon_item > 0): ?>
                        <div class="price-row-i disc">
                            <span>Total Diskon Produk</span>
                            <span>− Rp <?= number_format($total_diskon_item, 0, ',', '.') ?></span>
                        </div>
                        <?php endif; ?>

                        <div class="price-row-i">
                            <span>Ongkos Kirim</span>
                            <span id="display_ongkir" style="color:#4ade80; font-weight:700;">Rp 0</span>
                        </div>
                        <div class="price-row-i">
                            <span>Biaya Layanan</span>
                            <span>Rp <?= number_format($biaya_layanan, 0, ',', '.') ?></span>
                        </div>
                        <div class="price-row-i">
                            <span>Biaya Penanganan</span>
                            <span>Rp <?= number_format($biaya_penanganan, 0, ',', '.') ?></span>
                        </div>
                        <div class="price-divider"></div>
                        <div class="price-total">
                            <span class="price-total-label">Total</span>
                            <span class="price-total-val" id="display_total">
                                Rp <?= number_format($total_awal, 0, ',', '.') ?>
                            </span>
                        </div>
                    </div>

                    <button type="submit" class="btn-pesan">
                        <i class="fa-solid fa-bolt"></i>
                        Buat Pesanan
                    </button>
                    <p style="text-align:center; font-size:11.5px; color:var(--ink-muted); margin-top:10px; line-height:1.5;">
                        Dengan menekan tombol di atas, Anda menyetujui<br>ketentuan pembelian Sport Center.
                    </p>
                </div>

            </div><!-- /sticky card -->
        </div><!-- /kanan -->

    </div><!-- /rs-grid -->
</form>

<script>
    const SUBTOTAL = <?= (float)$subtotal_produk ?>;
    const BL       = <?= (float)$biaya_layanan ?>;
    const BP       = <?= (float)$biaya_penanganan ?>;
    const USER_ALAMAT = <?= json_encode($user_alamat ?? '') ?>;

    function fmt(n) { return 'Rp ' + Math.round(n).toLocaleString('id-ID'); }

    function hitungOngkir() {
        const sel    = document.getElementById('pilih_kota');
        const opt    = sel.options[sel.selectedIndex];
        const ongkir = parseInt(opt.getAttribute('data-ongkir')) || 0;
        const total  = SUBTOTAL + ongkir + BL + BP;

        document.getElementById('display_ongkir').textContent = fmt(ongkir);
        document.getElementById('display_total').textContent  = fmt(total);
        document.getElementById('input_kota').value   = opt.value;
        document.getElementById('input_ongkir').value = ongkir;
        document.getElementById('input_total').value  = total;
    }

    function setMetode(val) {
        document.getElementById('input_metode').value = val;
    }

    document.getElementById('formPesanan').addEventListener('submit', function(e) {
        const kota = document.getElementById('pilih_kota').value;
        if (!USER_ALAMAT || !USER_ALAMAT.trim()) {
            e.preventDefault();
            alert('Lengkapi alamat pengiriman di profil terlebih dahulu!');
            window.location.href = "<?= base_url('pelanggan/edit_profile') ?>";
            return;
        }
        if (!kota) {
            e.preventDefault();
            document.getElementById('pilih_kota').style.borderColor = '#f87171';
            alert('Pilih kota tujuan pengiriman!');
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        if (document.getElementById('pilih_kota').value) hitungOngkir();
    });
</script>

<?= $this->endSection() ?>