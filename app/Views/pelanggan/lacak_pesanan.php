<?= $this->extend('layout/pelanggan_layout') ?>

<?= $this->section('content') ?>
<?php
    $st = strtolower($order['status_pengiriman'] ?? 'diproses');
    $statusBayar = $order['status_pembayaran'] ?? '';
    $dibatalkan  = ($st == 'dibatalkan');

    function stStep($status) {
        $map = [
            'diproses' => 1,
            'dikemas'  => 2,
            'dikirim'  => 2,
            'selesai'  => 3,
            'sampai'   => 3,
        ];
        return $map[$status] ?? 1;
    }
    $currentStep = stStep($st);
?>
<style>
    .lp-wrapper { max-width: 720px; margin: 0 auto; }

    /* ── TOP NAV ── */
    .lp-topbar { display: flex; align-items: center; gap: 14px; margin-bottom: 24px; }
    .lp-back {
        width: 38px; height: 38px; border-radius: 50%;
        background: var(--surface-raised); border: 1px solid var(--border);
        display: flex; align-items: center; justify-content: center;
        color: var(--ink); text-decoration: none; font-size: 14px; flex-shrink: 0;
        transition: background var(--transition);
    }
    .lp-back:hover { background: var(--surface-high); }
    .lp-page-title { font-size: 20px; font-weight: 800; letter-spacing: -0.5px; color: var(--ink); }
    .lp-page-sub { font-size: 12.5px; color: var(--ink-secondary); margin-top: 2px; }

    /* ── STATUS HERO ── */
    .lp-status-hero {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 26px 24px;
        margin-bottom: 20px;
        text-align: center;
    }
    .lp-status-hero.batal { border-color: rgba(239,68,68,0.3); background: rgba(239,68,68,0.04); }
    .lp-status-icon {
        width: 64px; height: 64px;
        border-radius: 50%;
        margin: 0 auto 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 26px;
    }
    .lp-status-icon.diproses { background: rgba(249,115,22,0.15); color: #fb923c; }
    .lp-status-icon.dikirim  { background: rgba(59,130,246,0.15); color: #60a5fa; }
    .lp-status-icon.selesai  { background: rgba(34,197,94,0.15); color: #4ade80; }
    .lp-status-icon.batal    { background: rgba(239,68,68,0.15); color: #f87171; }
    .lp-status-title { font-size: 17px; font-weight: 800; color: var(--ink); margin-bottom: 4px; }
    .lp-status-desc { font-size: 13px; color: var(--ink-secondary); max-width: 380px; margin: 0 auto; line-height: 1.6; }

    /* ── TIMELINE ── */
    .lp-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 24px 22px;
        margin-bottom: 20px;
    }
    .lp-card-title {
        font-size: 13px; font-weight: 700; color: var(--ink-secondary);
        text-transform: uppercase; letter-spacing: 0.8px;
        margin-bottom: 22px;
        display: flex; align-items: center; gap: 8px;
    }
    .lp-card-title i { color: var(--brand); }

    .timeline { display: flex; flex-direction: column; }
    .timeline-item { display: flex; gap: 16px; position: relative; }
    .timeline-item:last-child .timeline-line { display: none; }

    .timeline-marker { display: flex; flex-direction: column; align-items: center; }
    .timeline-dot {
        width: 30px; height: 30px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 12px; flex-shrink: 0;
        border: 2px solid var(--border);
        background: var(--surface-raised);
        color: var(--ink-muted);
        transition: background var(--transition), border-color var(--transition), color var(--transition);
    }
    .timeline-dot.done   { background: var(--brand); border-color: var(--brand); color: #fff; }
    .timeline-dot.active {
        background: var(--brand-subtle); border-color: var(--brand); color: var(--brand);
        box-shadow: 0 0 0 4px var(--brand-glow);
    }
    .timeline-dot.batal  { background: rgba(239,68,68,0.15); border-color: #f87171; color: #f87171; }

    .timeline-line {
        width: 2px; flex: 1; min-height: 34px;
        background: var(--border);
        margin: 2px 0;
    }
    .timeline-line.done { background: var(--brand); }

    .timeline-content { padding-bottom: 26px; flex: 1; }
    .timeline-item:last-child .timeline-content { padding-bottom: 0; }
    .timeline-label { font-size: 13.5px; font-weight: 700; color: var(--ink-muted); margin-bottom: 2px; }
    .timeline-label.done, .timeline-label.active { color: var(--ink); }
    .timeline-desc { font-size: 12px; color: var(--ink-secondary); line-height: 1.5; }
    .timeline-time { font-size: 11px; color: var(--ink-muted); margin-top: 4px; }

    /* ── PEMBAYARAN ── */
    .lp-payment-row {
        display: flex; align-items: center; justify-content: space-between;
        gap: 12px; flex-wrap: wrap;
    }
    .lp-payment-badge {
        display: inline-flex; align-items: center; gap: 6px;
        font-size: 11.5px; font-weight: 700;
        padding: 5px 12px; border-radius: var(--radius-pill);
    }
    .lp-payment-badge.lunas    { background: rgba(34,197,94,0.12); color: #4ade80; border: 1px solid rgba(74,222,128,0.2); }
    .lp-payment-badge.menunggu { background: rgba(234,179,8,0.12); color: #facc15; border: 1px solid rgba(250,204,21,0.2); }
    .lp-payment-badge.belum    { background: rgba(239,68,68,0.12); color: #f87171; border: 1px solid rgba(248,113,113,0.2); }
    .lp-payment-badge.cod      { background: rgba(59,130,246,0.12); color: #60a5fa; border: 1px solid rgba(96,165,250,0.2); }

    .lp-btn-upload {
        display: inline-flex; align-items: center; gap: 7px;
        background: var(--brand); color: #fff; text-decoration: none;
        padding: 8px 16px; border-radius: var(--radius-md);
        font-size: 12.5px; font-weight: 700;
        transition: background var(--transition);
    }
    .lp-btn-upload:hover { background: var(--brand-dark); }

    /* ── ITEM PESANAN ── */
    .lp-item-row {
        display: flex; align-items: center; gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid var(--border-light);
    }
    .lp-item-row:last-child { border-bottom: none; padding-bottom: 0; }
    .lp-item-thumb {
        width: 50px; height: 50px; border-radius: var(--radius-sm);
        overflow: hidden; background: var(--surface-raised); flex-shrink: 0;
        border: 1px solid var(--border);
    }
    .lp-item-thumb img { width: 100%; height: 100%; object-fit: cover; }
    .lp-item-name { font-size: 13px; font-weight: 700; color: var(--ink); }
    .lp-item-meta { font-size: 11.5px; color: var(--ink-secondary); margin-top: 2px; }
    .lp-item-sub { margin-left: auto; font-size: 13px; font-weight: 700; color: var(--ink); white-space: nowrap; }

    /* ── ACTIONS ── */
    .lp-actions { display: flex; gap: 10px; flex-wrap: wrap; }
    .lp-btn-secondary {
        display: inline-flex; align-items: center; gap: 8px;
        background: var(--surface-raised); color: var(--ink);
        border: 1px solid var(--border); text-decoration: none;
        padding: 11px 20px; border-radius: var(--radius-md);
        font-size: 13px; font-weight: 600;
        transition: background var(--transition);
    }
    .lp-btn-secondary:hover { background: var(--surface-high); }

    @media (max-width: 600px) {
        .lp-payment-row { flex-direction: column; align-items: flex-start; }
    }
</style>

<div class="lp-wrapper">

    <!-- TOP NAV -->
    <div class="lp-topbar">
        <a href="<?= base_url('pelanggan/orders') ?>" class="lp-back">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <div class="lp-page-title">Lacak Pesanan</div>
            <div class="lp-page-sub">Order #ORD-<?= str_pad($order['id'], 3, '0', STR_PAD_LEFT) ?></div>
        </div>
    </div>

    <!-- STATUS HERO -->
    <?php if ($dibatalkan) : ?>
        <div class="lp-status-hero batal">
            <div class="lp-status-icon batal"><i class="fa-solid fa-xmark"></i></div>
            <div class="lp-status-title">Pesanan Dibatalkan</div>
            <p class="lp-status-desc">Pesanan ini telah dibatalkan. Jika ada pertanyaan, silakan hubungi admin toko.</p>
        </div>
    <?php elseif (in_array($st, ['selesai','sampai'])) : ?>
        <div class="lp-status-hero">
            <div class="lp-status-icon selesai"><i class="fa-solid fa-circle-check"></i></div>
            <div class="lp-status-title">Pesanan Selesai</div>
            <p class="lp-status-desc">Pesanan telah sampai ke alamat tujuan. Terima kasih sudah berbelanja di Sport Center!</p>
        </div>
    <?php elseif (in_array($st, ['dikemas','dikirim'])) : ?>
        <div class="lp-status-hero">
            <div class="lp-status-icon dikirim"><i class="fa-solid fa-truck-fast"></i></div>
            <div class="lp-status-title">Pesanan Sedang Dikirim</div>
            <p class="lp-status-desc">Kurir sedang dalam perjalanan mengantar pesanan Anda ke alamat tujuan.</p>
        </div>
    <?php else : ?>
        <div class="lp-status-hero">
            <div class="lp-status-icon diproses"><i class="fa-solid fa-box-open"></i></div>
            <div class="lp-status-title">Pesanan Sedang Diproses</div>
            <p class="lp-status-desc">Toko sedang menyiapkan pesanan Anda sebelum diserahkan ke kurir pengiriman.</p>
        </div>
    <?php endif; ?>

    <!-- TIMELINE -->
    <div class="lp-card">
        <div class="lp-card-title"><i class="fa-solid fa-timeline"></i> Riwayat Status</div>

        <div class="timeline">
            <!-- Step 1: Pesanan Dibuat -->
            <div class="timeline-item">
                <div class="timeline-marker">
                    <div class="timeline-dot done"><i class="fa-solid fa-check"></i></div>
                    <div class="timeline-line done"></div>
                </div>
                <div class="timeline-content">
                    <div class="timeline-label done">Pesanan Dibuat</div>
                    <div class="timeline-desc">Pesanan berhasil dibuat dan menunggu diproses toko.</div>
                    <div class="timeline-time"><?= date('d M Y, H:i', strtotime($order['tgl_pesan'])) ?> WIB</div>
                </div>
            </div>

            <?php if ($dibatalkan) : ?>
                <!-- Jika dibatalkan, tampilkan langsung status batal -->
                <div class="timeline-item">
                    <div class="timeline-marker">
                        <div class="timeline-dot batal"><i class="fa-solid fa-xmark"></i></div>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-label" style="color:#f87171;">Pesanan Dibatalkan</div>
                        <div class="timeline-desc">Pesanan ini tidak dilanjutkan proses pengirimannya.</div>
                    </div>
                </div>
            <?php else : ?>
                <!-- Step 2: Diproses -->
                <div class="timeline-item">
                    <div class="timeline-marker">
                        <div class="timeline-dot <?= $currentStep > 1 ? 'done' : ($currentStep == 1 ? 'active' : '') ?>">
                            <?= $currentStep > 1 ? '<i class="fa-solid fa-check"></i>' : '<i class="fa-solid fa-box-open"></i>' ?>
                        </div>
                        <div class="timeline-line <?= $currentStep > 1 ? 'done' : '' ?>"></div>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-label <?= $currentStep >= 1 ? ($currentStep > 1 ? 'done' : 'active') : '' ?>">Diproses Toko</div>
                        <div class="timeline-desc">Pesanan sedang disiapkan dan dikemas oleh toko.</div>
                    </div>
                </div>

                <!-- Step 3: Dikirim -->
                <div class="timeline-item">
                    <div class="timeline-marker">
                        <div class="timeline-dot <?= $currentStep > 2 ? 'done' : ($currentStep == 2 ? 'active' : '') ?>">
                            <?= $currentStep > 2 ? '<i class="fa-solid fa-check"></i>' : '<i class="fa-solid fa-truck-fast"></i>' ?>
                        </div>
                        <div class="timeline-line <?= $currentStep > 2 ? 'done' : '' ?>"></div>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-label <?= $currentStep >= 2 ? ($currentStep > 2 ? 'done' : 'active') : '' ?>">Dikirim</div>
                        <div class="timeline-desc">Pesanan dalam perjalanan menuju alamat Anda.</div>
                    </div>
                </div>

                <!-- Step 4: Selesai -->
                <div class="timeline-item">
                    <div class="timeline-marker">
                        <div class="timeline-dot <?= $currentStep >= 3 ? 'done' : '' ?>">
                            <i class="fa-solid fa-flag-checkered"></i>
                        </div>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-label <?= $currentStep >= 3 ? 'done' : '' ?>">Pesanan Selesai</div>
                        <div class="timeline-desc">Pesanan telah diterima dengan baik oleh pelanggan.</div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- STATUS PEMBAYARAN -->
    <div class="lp-card">
        <div class="lp-card-title"><i class="fa-solid fa-wallet"></i> Status Pembayaran</div>
        <div class="lp-payment-row">
            <div>
                <?php if (strtolower($order['metode_pembayaran']) == 'cod') : ?>
                    <span class="lp-payment-badge cod"><i class="fa-solid fa-hand-holding-dollar"></i> COD — Bayar di Tempat</span>
                <?php elseif ($statusBayar == 'sudah_bayar') : ?>
                    <span class="lp-payment-badge lunas"><i class="fa-solid fa-circle-check"></i> Sudah Dibayar</span>
                <?php elseif ($statusBayar == 'menunggu_verifikasi') : ?>
                    <span class="lp-payment-badge menunggu"><i class="fa-solid fa-hourglass-half"></i> Menunggu Verifikasi Admin</span>
                <?php else : ?>
                    <span class="lp-payment-badge belum"><i class="fa-solid fa-circle-exclamation"></i> Belum Bayar</span>
                <?php endif; ?>
            </div>

            <?php if (strtolower($order['metode_pembayaran']) == 'va_bank' && $statusBayar != 'sudah_bayar') : ?>
                <a href="<?= base_url('pelanggan/upload_bukti/' . $order['id']) ?>" class="lp-btn-upload">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                    <?= empty($order['bukti_transfer']) ? 'Upload Bukti Transfer' : 'Lihat / Ganti Bukti' ?>
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- ITEM PESANAN -->
    <?php if (!empty($items)) : ?>
    <div class="lp-card">
        <div class="lp-card-title"><i class="fa-solid fa-bag-shopping"></i> Produk Dipesan</div>
        <?php foreach ($items as $it) : ?>
            <div class="lp-item-row">
                <div class="lp-item-thumb">
                    <img src="<?= base_url('images/' . ($it['gambar'] ?? 'default.jpg')) ?>" alt="">
                </div>
                <div>
                    <div class="lp-item-name"><?= esc($it['nama_produk'] ?? 'Produk') ?></div>
                    <div class="lp-item-meta">Qty: <?= (int) $it['jumlah'] ?></div>
                </div>
                <div class="lp-item-sub">Rp <?= number_format($it['subtotal'], 0, ',', '.') ?></div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- ACTIONS -->
    <div class="lp-actions">
        <a href="<?= base_url('pelanggan/orders') ?>" class="lp-btn-secondary">
            <i class="fa-solid fa-list"></i> Kembali ke Riwayat Pesanan
        </a>
        <?php if (!in_array($st, ['selesai', 'sampai', 'dibatalkan'])) : ?>
            <a href="<?= base_url('pelanggan/konfirmasi_selesai/' . $order['id']) ?>"
               class="lp-btn-secondary"
               onclick="return confirm('Apakah Anda yakin pesanan telah diterima dengan baik?')">
                <i class="fa-solid fa-circle-check"></i> Konfirmasi Diterima
            </a>
        <?php endif; ?>
    </div>

</div>
<?= $this->endSection() ?>