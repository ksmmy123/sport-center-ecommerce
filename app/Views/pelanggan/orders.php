<?= $this->extend('layout/pelanggan_layout') ?>

<?= $this->section('content') ?>
<style>
    /* ── PAGE HEADER ── */
    .orders-header { margin-bottom: 28px; }
    .orders-title {
        font-size: 24px;
        font-weight: 800;
        letter-spacing: -0.6px;
        color: var(--ink);
    }
    .orders-subtitle {
        font-size: 13.5px;
        color: var(--ink-secondary);
        margin-top: 5px;
    }

    /* ── FLASH ── */
    .flash-success {
        background: rgba(34,197,94,0.12);
        color: #4ade80;
        border: 1px solid rgba(74,222,128,0.2);
        padding: 14px 18px;
        border-radius: var(--radius-md);
        margin-bottom: 20px;
        font-size: 13.5px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* ── EMPTY ── */
    .orders-empty {
        text-align: center;
        padding: 80px 20px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-xl);
    }
    .orders-empty i { font-size: 52px; color: var(--ink-muted); margin-bottom: 16px; display: block; }
    .orders-empty p { color: var(--ink-secondary); margin-bottom: 6px; font-size: 15px; font-weight: 600; }
    .orders-empty small { color: var(--ink-muted); font-size: 13px; display: block; margin-bottom: 20px; }
    .orders-empty a {
        display: inline-flex; align-items: center; gap: 8px;
        background: var(--brand); color: #fff; text-decoration: none;
        padding: 11px 22px; border-radius: var(--radius-md);
        font-size: 13.5px; font-weight: 700;
        box-shadow: 0 4px 14px rgba(249,115,22,0.35);
        transition: background var(--transition), transform var(--transition);
    }
    .orders-empty a:hover { background: var(--brand-dark); transform: translateY(-1px); }

    /* ── ORDER CARD ── */
    .order-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        margin-bottom: 16px;
        overflow: hidden;
        transition: border-color var(--transition), box-shadow var(--transition);
    }
    .order-card:hover { border-color: rgba(255,255,255,0.13); box-shadow: var(--shadow-sm); }

    /* Card header */
    .order-card-head {
        padding: 13px 20px;
        background: var(--surface-raised);
        border-bottom: 1px solid var(--border);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }
    .order-id-group {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 13px;
    }
    .order-id {
        font-weight: 700;
        color: var(--ink);
        letter-spacing: 0.2px;
    }
    .order-sep { color: var(--ink-muted); }
    .order-date { color: var(--ink-secondary); }

    /* Status badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: var(--radius-sm);
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .status-diproses { background: rgba(249,115,22,0.15); color: #fb923c; border: 1px solid rgba(249,115,22,0.2); }
    .status-dikirim  { background: rgba(59,130,246,0.15);  color: #60a5fa; border: 1px solid rgba(59,130,246,0.2); }
    .status-selesai  { background: rgba(34,197,94,0.15);   color: #4ade80; border: 1px solid rgba(74,222,128,0.2); }
    .status-batal    { background: rgba(239,68,68,0.15);   color: #f87171; border: 1px solid rgba(248,113,113,0.2); }
    .status-lain     { background: var(--surface-high);    color: var(--ink-secondary); border: 1px solid var(--border); }

    /* Card body */
    .order-card-body {
        padding: 20px;
        border-bottom: 1px solid var(--border);
    }
    .order-body-inner {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 20px;
    }

    /* Kiri — ikon + label */
    .order-item-icon {
        width: 48px; height: 48px;
        background: var(--surface-raised);
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        display: flex; align-items: center; justify-content: center;
        color: var(--ink-secondary);
        font-size: 18px;
        flex-shrink: 0;
    }
    .order-item-label { font-size: 14px; font-weight: 600; color: var(--ink); }
    .order-item-meta { font-size: 12px; color: var(--ink-secondary); margin-top: 3px; }
    .order-item-meta span { color: var(--ink); font-weight: 600; text-transform: uppercase; }

    /* Kanan — breakdown harga */
    .order-price-breakdown {
        min-width: 260px;
        font-size: 13px;
        color: var(--ink-secondary);
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .price-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .price-row span:last-child { font-weight: 600; color: var(--ink); }
    .price-divider {
        height: 1px;
        background: var(--border);
        margin: 6px 0;
    }
    .price-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 15px;
        font-weight: 800;
        color: var(--ink);
    }
    .price-total-value { color: var(--brand); }

    /* VA instruksi */
    .va-notice {
        background: rgba(234,179,8,0.08);
        border-top: 1px solid var(--border);
        border-bottom: 1px solid var(--border);
        padding: 12px 20px;
        font-size: 12.5px;
        color: #fde68a;
        line-height: 1.6;
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }
    .va-notice i { flex-shrink: 0; margin-top: 1px; }

    /* Card footer */
    .order-card-foot {
        padding: 12px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        background: var(--surface);
    }
    .order-help {
        font-size: 12px;
        color: var(--ink-muted);
    }
    .order-help a { color: #60a5fa; text-decoration: none; }
    .order-help a:hover { text-decoration: underline; }

    .btn-konfirmasi {
        display: inline-flex; align-items: center; gap: 7px;
        background: rgba(34,197,94,0.15);
        color: #4ade80;
        border: 1px solid rgba(74,222,128,0.25);
        text-decoration: none;
        padding: 8px 16px;
        border-radius: var(--radius-md);
        font-size: 12.5px;
        font-weight: 700;
        transition: background var(--transition), color var(--transition);
    }
    .btn-konfirmasi:hover { background: rgba(34,197,94,0.25); color: #86efac; }

    .btn-selesai-disabled {
        display: inline-flex; align-items: center; gap: 7px;
        background: var(--surface-raised);
        color: var(--ink-muted);
        border: 1px solid var(--border);
        padding: 8px 16px;
        border-radius: var(--radius-md);
        font-size: 12.5px;
        font-weight: 600;
        cursor: not-allowed;
    }


    /* Modal preview gambar */
    .img-modal {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.85);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }
    .img-modal.active { display: flex; }
    .img-modal img {
        max-width: 90vw;
        max-height: 85vh;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-lg);
    }
    .img-modal-close {
        position: absolute;
        top: 16px; right: 16px;
        width: 40px; height: 40px;
        border-radius: 50%;
        background: rgba(255,255,255,0.15);
        border: none;
        color: #fff;
        font-size: 18px;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: background var(--transition);
    }
    .img-modal-close:hover { background: rgba(255,255,255,0.3); }
    .review-form {
        display: flex;
        gap: 10px;
        align-items: center;
        flex-wrap: wrap;
    }
    .review-select {
        padding: 8px 10px;
        border-radius: var(--radius-sm);
        border: 1.5px solid var(--border);
        background: var(--surface);
        color: var(--ink);
        font-size: 13px;
        font-family: 'Outfit', sans-serif;
        outline: none;
        transition: border-color var(--transition);
    }
    .review-select:focus { border-color: var(--brand); }

    .review-input {
        flex: 1;
        min-width: 160px;
        padding: 8px 12px;
        border-radius: var(--radius-sm);
        border: 1.5px solid var(--border);
        background: var(--surface);
        color: var(--ink);
        font-size: 13px;
        font-family: 'Outfit', sans-serif;
        outline: none;
        transition: border-color var(--transition), box-shadow var(--transition);
    }
    .review-input::placeholder { color: var(--ink-muted); }
    .review-input:focus {
        border-color: var(--brand);
        box-shadow: 0 0 0 3px var(--brand-glow);
    }

    .btn-review {
        background: var(--surface-high);
        color: var(--ink);
        border: 1.5px solid var(--border);
        padding: 8px 16px;
        border-radius: var(--radius-sm);
        font-family: 'Outfit', sans-serif;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: background var(--transition), border-color var(--transition), color var(--transition);
        white-space: nowrap;
    }
    .btn-review:hover { background: var(--brand); color: #fff; border-color: var(--brand); }

    .review-done {
        background: rgba(34,197,94,0.10);
        border: 1px solid rgba(74,222,128,0.18);
        border-radius: var(--radius-md);
        padding: 12px 14px;
    }
    .review-done-label { font-size: 12px; font-weight: 700; color: #4ade80; margin-bottom: 4px; }
    .review-done-text  { font-size: 13px; color: var(--ink-secondary); font-style: italic; }

    /* ── BUKTI TRANSFER UPLOAD ── */
    .bukti-section {
        padding: 16px 20px;
        border-top: 1px solid var(--border);
        background: var(--surface-raised);
    }
    .bukti-section-title {
        font-size: 13px; font-weight: 700; color: var(--ink);
        margin-bottom: 12px;
        display: flex; align-items: center; gap: 8px;
    }
    .bukti-section-title i { color: var(--brand); }

    /* Info rekening */
    .rekening-info {
        background: rgba(234,179,8,0.08);
        border: 1px solid rgba(234,179,8,0.2);
        border-radius: var(--radius-md);
        padding: 12px 14px;
        margin-bottom: 14px;
        font-size: 13px;
        color: #fde68a;
        line-height: 1.7;
    }
    .rekening-info strong { color: #fbbf24; }
    .rekening-num {
        font-size: 18px; font-weight: 800;
        letter-spacing: 2px; color: #fbbf24;
        display: block; margin-top: 4px;
    }

    /* Upload form */
    .upload-form { display: flex; gap: 10px; align-items: flex-end; flex-wrap: wrap; }
    .upload-input-wrap { flex: 1; min-width: 200px; }
    .upload-label-text {
        font-size: 11.5px; font-weight: 600;
        color: var(--ink-secondary); display: block; margin-bottom: 6px;
    }
    .upload-input {
        width: 100%;
        padding: 9px 12px;
        border: 1.5px solid var(--border);
        border-radius: var(--radius-md);
        background: var(--surface);
        color: var(--ink);
        font-family: 'Outfit', sans-serif;
        font-size: 13px;
        cursor: pointer;
        transition: border-color var(--transition);
    }
    .upload-input:focus { outline: none; border-color: var(--brand); }
    .upload-hint {
        font-size: 11px; color: var(--ink-muted); margin-top: 4px;
        display: flex; align-items: center; gap: 4px;
    }
    .btn-upload {
        display: flex; align-items: center; gap: 7px;
        background: var(--brand); color: #fff;
        border: none; border-radius: var(--radius-md);
        padding: 10px 18px;
        font-family: 'Outfit', sans-serif;
        font-size: 13px; font-weight: 700;
        cursor: pointer; white-space: nowrap;
        box-shadow: 0 3px 10px rgba(249,115,22,0.3);
        transition: background var(--transition), transform var(--transition);
    }
    .btn-upload:hover { background: var(--brand-dark); transform: translateY(-1px); }
    .btn-upload-small {
        padding: 8px 12px;
        font-size: 12px;
    }

    /* Sudah upload — preview */
    .bukti-uploaded {
        display: flex; align-items: center; gap: 12px;
        background: rgba(34,197,94,0.08);
        border: 1px solid rgba(74,222,128,0.18);
        border-radius: var(--radius-md);
        padding: 10px 14px;
        margin-top: 10px;
    }
    .bukti-thumb {
        width: 52px; height: 52px;
        border-radius: var(--radius-sm);
        overflow: hidden; flex-shrink: 0;
        border: 1px solid rgba(74,222,128,0.2);
    }
    .bukti-thumb img { width: 100%; height: 100%; object-fit: cover; }
    .bukti-uploaded-label { font-size: 12.5px; font-weight: 600; color: #4ade80; }
    .bukti-uploaded-name  { font-size: 11.5px; color: var(--ink-muted); margin-top: 2px; }
    .btn-ganti-bukti {
        margin-left: auto; font-size: 11.5px; font-weight: 600;
        color: var(--ink-secondary); background: var(--surface-high);
        border: 1px solid var(--border); border-radius: var(--radius-sm);
        padding: 5px 10px; cursor: pointer; white-space: nowrap;
        transition: background var(--transition);
        font-family: 'Outfit', sans-serif;
    }
    .btn-ganti-bukti:hover { background: var(--surface); }

    /* ── RESPONSIVE ── */
    @media (max-width: 768px) {
        .order-card-head { flex-direction: column; align-items: flex-start; }
        .order-price-breakdown { min-width: 100%; }
        .review-form { flex-direction: column; align-items: stretch; }
        .review-select, .btn-review { width: 100%; }
        .upload-form { flex-direction: column; }
        .btn-upload { width: 100%; justify-content: center; }
    }
</style>

<!-- HEADER -->
<div class="orders-header">
    <h1 class="orders-title">Riwayat Pesanan</h1>
    <p class="orders-subtitle">Pantau status pengiriman dan riwayat transaksi belanja Anda</p>
</div>

<!-- FLASH SUCCESS -->
<?php if (session()->getFlashdata('success')) : ?>
    <div class="flash-success">
        <i class="fa-solid fa-circle-check"></i>
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<!-- KOSONG -->
<?php if (empty($orders)) : ?>
    <div class="orders-empty">
        <i class="fa-solid fa-box-open"></i>
        <p>Belum ada pesanan</p>
        <small>Anda belum melakukan transaksi pembelian apapun.</small>
        <a href="<?= base_url('/') ?>">
            <i class="fa-solid fa-store"></i>
            Belanja Sekarang
        </a>
    </div>

<?php else : ?>
    <?php foreach ($orders as $o) :
        $st = strtolower($o['status_pengiriman'] ?? 'diproses');
        $pajak_order     = $o['pajak'] ?? 0;
        $subtotal_produk = $o['total_harga'] - ($o['ongkir'] + $o['biaya_layanan'] + $o['biaya_penanganan'] + $pajak_order);
    ?>
    <div class="order-card">

        <!-- HEAD -->
        <div class="order-card-head">
            <div class="order-id-group">
                <span class="order-id">#ORD-<?= str_pad($o['id'], 3, '0', STR_PAD_LEFT) ?></span>
                <span class="order-sep">·</span>
                <span class="order-date"><?= date('d M Y', strtotime($o['tgl_pesan'])) ?></span>
            </div>

            <?php
                if ($st == 'diproses') :
                    echo '<span class="status-badge status-diproses"><i class="fa-solid fa-clock"></i> Diproses</span>';
                elseif (in_array($st, ['dikemas','dikirim'])) :
                    echo '<span class="status-badge status-dikirim"><i class="fa-solid fa-truck"></i> Dikirim</span>';
                elseif (in_array($st, ['selesai','sampai'])) :
                    echo '<span class="status-badge status-selesai"><i class="fa-solid fa-circle-check"></i> Selesai</span>';
                elseif ($st == 'dibatalkan') :
                    echo '<span class="status-badge status-batal"><i class="fa-solid fa-xmark"></i> Dibatalkan</span>';
                else :
                    echo '<span class="status-badge status-lain">' . esc($o['status_pengiriman']) . '</span>';
                endif;
            ?>
        </div>

        <!-- BODY -->
        <div class="order-card-body">
            <div class="order-body-inner">
                <!-- Kiri -->
                <div style="display:flex; align-items:center; gap:14px;">
                    <div class="order-item-icon">
                        <i class="fa-solid fa-bag-shopping"></i>
                    </div>
                    <div>
                        <div class="order-item-label">Detail Transaksi Belanja</div>
                        <div class="order-item-meta">
                            Metode: <span><?= esc($o['metode_pembayaran']) ?></span>
                        </div>
                    </div>
                </div>

                <!-- Kanan — harga -->
                <div class="order-price-breakdown">
                    <div class="price-row">
                        <span>Subtotal Produk</span>
                        <span>Rp <?= number_format($subtotal_produk, 0, ',', '.') ?></span>
                    </div>
                    <div class="price-row">
                        <span>Ongkir</span>
                        <span>Rp <?= number_format($o['ongkir'], 0, ',', '.') ?></span>
                    </div>
                    <?php if ($pajak_order > 0) : ?>
                    <div class="price-row">
                        <span>Pajak (7.5%)</span>
                        <span>Rp <?= number_format($pajak_order, 0, ',', '.') ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="price-row">
                        <span>Biaya Layanan</span>
                        <span>Rp <?= number_format($o['biaya_layanan'], 0, ',', '.') ?></span>
                    </div>
                    <div class="price-row">
                        <span>Biaya Penanganan</span>
                        <span>Rp <?= number_format($o['biaya_penanganan'], 0, ',', '.') ?></span>
                    </div>
                    <div class="price-divider"></div>
                    <div class="price-total">
                        <span>Total Pembayaran</span>
                        <span class="price-total-value">Rp <?= number_format($o['total_harga'], 0, ',', '.') ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- BUKTI TRANSFER UPLOAD -->
        <?php if ($o['metode_pembayaran'] == 'va_bank' && $o['status_pembayaran'] == 'belum_bayar') : ?>
            <div class="bukti-section">
                <div class="bukti-section-title">
                    <i class="fa-solid fa-building-columns"></i>
                    Instruksi & Konfirmasi Pembayaran Transfer Bank
                </div>

                <!-- Info rekening -->
                <div class="rekening-info">
                    <div>Silakan transfer ke rekening berikut:</div>
                    <strong>Bank BRI — a.n. Sport Center Pemalang</strong>
                    <span class="rekening-num">1234-567-890</span>
                    <div style="margin-top:6px; font-size:12px; color:rgba(253,230,138,0.7);">
                        <i class="fa-solid fa-circle-info"></i>
                        Setelah transfer, upload screenshot bukti pembayaran di bawah ini.
                    </div>
                </div>

                <?php if (empty($o['bukti_transfer'])) : ?>
                    <a href="<?= base_url('pelanggan/upload_bukti/' . $o['id']) ?>" class="btn-upload btn-upload-small">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        Upload
                    </a>
                <?php else : ?>
                    <div class="bukti-uploaded">
                        <div class="bukti-thumb">
                            <img src="<?= base_url('uploads/bukti_transfer/' . $o['bukti_transfer']) ?>"
                                 alt="Bukti Transfer">
                        </div>
                        <div>
                            <div class="bukti-uploaded-label">
                                <i class="fa-solid fa-circle-check"></i>
                                Bukti sudah diupload
                            </div>
                            <div class="bukti-uploaded-name"><?= esc($o['bukti_transfer']) ?></div>
                        </div>
                        <a href="<?= base_url('pelanggan/upload_bukti/' . $o['id']) ?>" class="btn-ganti-bukti" style="display:inline-flex; align-items:center; gap:8px;">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                            Upload Ulang
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- FOOTER -->
        <div class="order-card-foot">
            <span class="order-help">
                Butuh bantuan?
                <a href="#">Hubungi Toko</a>
            </span>

            <?php if (!in_array($st, ['selesai', 'sampai', 'dibatalkan'])) : ?>
                <a href="<?= base_url('pelanggan/konfirmasi_selesai/' . $o['id']) ?>"
                   class="btn-konfirmasi"
                   onclick="return confirm('Apakah Anda yakin pesanan telah diterima dengan baik?')">
                    <i class="fa-solid fa-circle-check"></i>
                    Konfirmasi Selesai
                </a>
            <?php else : ?>
                <span class="btn-selesai-disabled">
                    <i class="fa-solid fa-check"></i>
                    <?= in_array($st, ['selesai','sampai']) ? 'Selesai' : 'Dibatalkan' ?>
                </span>
            <?php endif; ?>
        </div>

        <!-- ULASAN -->
        <?php if (in_array($st, ['selesai', 'sampai'])) : ?>
            <div class="review-section">
                <?php if (empty($o['ulasan'])) : ?>
                    <form action="<?= base_url('pelanggan/simpan_ulasan/' . $o['id']) ?>"
                          method="post" class="review-form">
                        <?= csrf_field() ?>
                        <select name="rating" class="review-select">
                            <option value="5">⭐⭐⭐⭐⭐ (5)</option>
                            <option value="4">⭐⭐⭐⭐ (4)</option>
                            <option value="3">⭐⭐⭐ (3)</option>
                            <option value="2">⭐⭐ (2)</option>
                            <option value="1">⭐ (1)</option>
                        </select>
                        <input type="text" name="ulasan"
                               class="review-input"
                               placeholder="Tulis ulasan Anda..." required>
                        <button type="submit" class="btn-review">
                            <i class="fa-solid fa-paper-plane"></i> Kirim
                        </button>
                    </form>
                <?php else : ?>
                    <div class="review-done">
                        <div class="review-done-label">
                            <i class="fa-solid fa-circle-check"></i> Ulasan Anda
                        </div>
                        <div class="review-done-text">"<?= esc($o['ulasan']) ?>"</div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </div>
    <?php endforeach; ?>
<?php endif; ?>

<?= $this->endSection() ?>