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

    .trx-meta { color: var(--ink-muted); font-size: 12.5px; }
    .trx-amount { color: #4ade80; font-weight: 800; }

    .empty-row { padding: 30px; text-align: center; color: var(--ink-secondary); }
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
    <p class="saldo-label">Total Saldo Masuk</p>
    <h2 class="saldo-value">Rp <?= number_format($total_masuk, 0, ',', '.') ?></h2>
    <div class="saldo-trend">
        <i class="fa-solid fa-arrow-trend-up"></i> +12% dari bulan lalu
    </div>
</div>

<!-- TABEL TRANSAKSI -->
<div class="card" style="padding: 24px;">
    <h3 style="font-size:16px; font-weight:700; color:var(--ink); margin-bottom:18px;">Transaksi Terakhir</h3>

    <div class="table-wrapper" style="box-shadow:none; border:1px solid var(--border);">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Metode</th>
                    <th>Waktu</th>
                    <th style="text-align:right;">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($transaksi)) : ?>
                    <?php $no = 1; foreach (array_reverse($transaksi) as $row) : ?>
                    <tr>
                        <td style="font-weight:700; color:var(--ink);">#TRX-<?= $no++; ?></td>
                        <td>
                            <?php
                                $metode = strtolower($row['metode_pembayaran']);
                                $warnaMetode = ($metode === 'cod') ? '#facc15' : (($metode === 'va_bank') ? '#60a5fa' : 'var(--ink-secondary)');
                            ?>
                            <span style="text-transform:uppercase; font-weight:600; font-size:12.5px; color:<?= $warnaMetode ?>;"><?= $row['metode_pembayaran']; ?></span>
                        </td>
                        <td class="trx-meta"><?= $row['tgl_pesan']; ?></td>
                        <td style="text-align:right;" class="trx-amount">+ Rp <?= number_format($row['total_harga'], 0, ',', '.'); ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="4" class="empty-row">Belum ada data transaksi.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>