<?= $this->extend('layout/admin/main') ?>

<?= $this->section('content') ?>

<style>
    /* ============================================================
       TRANSAKSI — Dark theme, selaras pelanggan_layout.php
       ============================================================ */
    .saldo-card {
        background: linear-gradient(135deg, var(--brand) 0%, #fbbf24 100%);
        padding: 30px;
        border-radius: var(--radius-xl);
        color: #fff;
        box-shadow: 0 8px 32px rgba(249,115,22,0.30);
        margin-bottom: 28px;
    }
    .saldo-label { font-size: 13.5px; opacity: 0.9; margin-bottom: 8px; font-weight: 500; }
    .saldo-value { font-size: 32px; font-weight: 800; letter-spacing: -0.8px; }
    .saldo-trend {
        margin-top: 16px;
        font-size: 12px;
        font-weight: 600;
        background: rgba(255,255,255,0.2);
        padding: 6px 14px;
        border-radius: var(--radius-pill);
        display: inline-flex;
        align-items: center;
        gap: 6px;
        width: fit-content;
    }
    .saldo-trend.turun { background: rgba(0,0,0,0.18); }

    .trx-meta { color: var(--ink-muted); font-size: 12.5px; }
    .trx-amount { color: #4ade80; font-weight: 800; }
    .trx-amount.batal { color: var(--ink-muted); font-weight: 600; text-decoration: line-through; }

    .trx-buyer { font-weight: 600; color: var(--ink); font-size: 13px; }
    .trx-buyer.muted { color: var(--ink-muted); font-weight: 400; font-style: italic; }

    /* Badge status pembayaran */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 11px;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: var(--radius-pill);
        white-space: nowrap;
    }
    .status-badge.lunas    { background: rgba(34,197,94,0.12);  color: #4ade80; border: 1px solid rgba(74,222,128,0.2); }
    .status-badge.menunggu { background: rgba(250,204,21,0.12); color: #facc15; border: 1px solid rgba(250,204,21,0.2); }
    .status-badge.belum    { background: rgba(148,163,184,0.12);color: #94a3b8; border: 1px solid rgba(148,163,184,0.2); }
    .status-badge.batal    { background: rgba(239,68,68,0.12);  color: #f87171; border: 1px solid rgba(248,113,113,0.2); }

    .empty-row { padding: 30px; text-align: center; color: var(--ink-secondary); }

    /* Filter status di atas tabel */
    .trx-filter-bar {
        display: flex;
        gap: 8px;
        margin-bottom: 18px;
        flex-wrap: wrap;
    }
    .trx-filter-btn {
        font-size: 12px;
        font-weight: 600;
        padding: 7px 14px;
        border-radius: var(--radius-pill);
        border: 1px solid var(--border);
        background: var(--surface-raised);
        color: var(--ink-secondary);
        text-decoration: none;
        transition: var(--transition);
    }
    .trx-filter-btn:hover { color: var(--ink); border-color: var(--ink-muted); }
    .trx-filter-btn.active { background: var(--brand); border-color: var(--brand); color: #fff; }
</style>

<!-- HEADER -->
<div class="page-header">
    <div>
        <h1 class="page-title">Arus Kas & Transaksi</h1>
        <p class="page-subtitle">Pantau saldo masuk dan riwayat transaksi pembayaran pelanggan.</p>
    </div>
</div>

<!-- SALDO CARD -->
<div class="saldo-card">
    <p class="saldo-label">Total Saldo Masuk <span style="opacity:0.75; font-weight:400;">(hanya pesanan berstatus lunas/sudah dibayar)</span></p>
    <h2 class="saldo-value">Rp <?= number_format($total_masuk, 0, ',', '.') ?></h2>

    <?php
        // ✅ Tren dihitung dari data asli (dibanding bulan lalu), bukan
        // angka tetap. Panah & warna menyesuaikan naik/turun.
        $trend   = $trend_saldo ?? 0;
        $naik    = $trend >= 0;
    ?>
    <div class="saldo-trend <?= $naik ? '' : 'turun' ?>">
        <i class="fa-solid <?= $naik ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' ?>"></i>
        <?= ($naik ? '+' : '') . number_format($trend, 1, ',', '.') ?>% dari bulan lalu
    </div>
</div>

<!-- TABEL TRANSAKSI -->
<div class="card" style="padding: 24px;">
    <h3 style="font-size:16px; font-weight:700; color:var(--ink); margin-bottom:18px;">Transaksi Terakhir</h3>

    <div class="table-wrapper" style="box-shadow:none; border:1px solid var(--border);">
        <table>
            <thead>
                <tr>
                    <th>ID Order</th>
                    <th>Pembeli</th>
                    <th>Metode</th>
                    <th>Status</th>
                    <th>Waktu</th>
                    <th style="text-align:right;">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($transaksi)) : ?>
                    <?php foreach ($transaksi as $row) : ?>
                    <?php
                        // ✅ FIX: sebelumnya ID pakai nomor urut palsu
                        // (#TRX-1, #TRX-2...), sekarang pakai ID order
                        // asli supaya bisa dicocokkan ke data pesanan.
                        $statusBayar = $row['status_pembayaran'] ?? '';

                        $labelStatus = [
                            'sudah_bayar'          => ['Lunas', 'lunas'],
                            'menunggu_verifikasi'  => ['Menunggu Verifikasi', 'menunggu'],
                            'belum_bayar'          => ['Belum Bayar', 'belum'],
                            'dibatalkan'           => ['Dibatalkan', 'batal'],
                        ];
                        [$teksStatus, $kelasStatus] = $labelStatus[$statusBayar] ?? ['-', 'belum'];

                        $isBatal = ($statusBayar === 'dibatalkan');

                        $metode = strtolower($row['metode_pembayaran'] ?? '');
                        $warnaMetode = ($metode === 'cod') ? '#facc15' : (($metode === 'va_bank') ? '#60a5fa' : 'var(--ink-secondary)');
                    ?>
                    <tr>
                        <td style="font-weight:700; color:var(--ink);">#ORD-<?= $row['id']; ?></td>
                        <td>
                            <span class="trx-buyer <?= empty($row['username']) ? 'muted' : '' ?>">
                                <?= !empty($row['username']) ? esc($row['username']) : 'Pengguna terhapus' ?>
                            </span>
                        </td>
                        <td>
                            <span style="text-transform:uppercase; font-weight:600; font-size:12.5px; color:<?= $warnaMetode ?>;"><?= esc($row['metode_pembayaran'] ?? '-'); ?></span>
                        </td>
                        <td><span class="status-badge <?= $kelasStatus ?>"><?= $teksStatus ?></span></td>
                        <td class="trx-meta"><?= date('d M Y, H:i', strtotime($row['tgl_pesan'])); ?></td>
                        <td style="text-align:right;" class="trx-amount <?= $isBatal ? 'batal' : '' ?>">
                            <?= $isBatal ? '' : '+ ' ?>Rp <?= number_format($row['total_harga'], 0, ',', '.'); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" class="empty-row">Belum ada data transaksi.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>