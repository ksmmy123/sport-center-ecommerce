<?= $this->extend('layout/admin/main') ?>

<?= $this->section('content') ?>

<style>
    /* ============================================================
       LAPORAN — Dark theme, selaras pelanggan_layout.php
       ============================================================ */

    .stat-card-value-md { font-size: 20px; line-height: 1.3; }

    .table-wrapper table { min-width: 500px; }
    .td-bulan  { font-weight: 600; color: var(--ink); }
    .td-total  { font-weight: 700; color: #4ade80; }

    /* Card mobile */
    .laporan-cards { display: none; }
    .laporan-card {
        background: var(--surface-raised);
        border-radius: var(--radius-md);
        padding: 14px 16px;
        margin-bottom: 10px;
        border: 1px solid var(--border-light);
    }
    .lc-bulan { font-weight: 700; color: var(--ink); font-size: 15px; margin-bottom: 10px; }
    .lc-meta { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
    .lc-meta-label { font-size: 10px; font-weight: 800; color: var(--ink-muted); text-transform: uppercase; margin-bottom: 3px; letter-spacing: 0.5px; }
    .lc-meta-value { font-weight: 600; color: var(--ink); font-size: 13px; }
    .lc-meta-value.green { color: #4ade80; }

    .empty-row { padding: 40px; text-align: center; color: var(--ink-secondary); }

    @media (max-width: 768px) {
        .table-wrapper { display: none; }
        .laporan-cards { display: block; }
    }

    /* ===== PRINT ===== */
    @media print {
        .sidebar, .admin-topbar, .no-print { display: none !important; }
        body, .main-content { background: #fff !important; color: #000 !important; }
        .card, .table-wrapper, .stat-card { box-shadow: none !important; border: 1px solid #ddd !important; background: #fff !important; }
        .table-wrapper th, .table-wrapper td, .page-title, .page-subtitle, .stat-card-value, .stat-card-label, .td-bulan, .td-total { color: #000 !important; }
        .laporan-cards { display: none !important; }
        .table-wrapper { display: block !important; }
    }
</style>

<div id="laporanArea">

    <!-- HEADER -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Laporan Penjualan</h1>
            <p class="page-subtitle">Ringkasan performa penjualan dan riwayat transaksi toko.</p>
        </div>
        <div class="page-header-actions">
            <button class="btn btn-primary no-print" onclick="cetakLaporan()">
                <i class="fas fa-print"></i> Cetak Laporan
            </button>
        </div>
    </div>

    <!-- STAT CARDS -->
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-card-icon blue"><i class="fa-solid fa-box"></i></div>
            <div>
                <div class="stat-card-value"><?= number_format($total_terjual, 0, ',', '.') ?> Pcs</div>
                <div class="stat-card-label">Total Terjual</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-icon orange"><i class="fa-solid fa-sack-dollar"></i></div>
            <div>
                <div class="stat-card-value">Rp <?= number_format($omset_bulan, 0, ',', '.') ?></div>
                <div class="stat-card-label">Omset Total</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-icon purple"><i class="fa-solid fa-trophy"></i></div>
            <div>
                <div class="stat-card-value stat-card-value-md">
                    <?= ($produk_terlaris == '-' || empty($produk_terlaris)) ? '-' : $produk_terlaris ?>
                </div>
                <div class="stat-card-label">Produk Terlaris</div>
            </div>
        </div>
    </div>

    <!-- RIWAYAT -->
    <div class="card">
        <h4 style="font-weight:700; margin-bottom:18px; font-size:16px; color:var(--ink);">Riwayat Penjualan</h4>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Bulan</th>
                        <th>Jumlah Transaksi</th>
                        <th>Total Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($riwayat_data)) : ?>
                        <?php foreach ($riwayat_data as $row) : ?>
                        <tr>
                            <td class="td-bulan"><?= $row['bulan'] ?></td>
                            <td style="color:var(--ink-secondary);"><?= $row['jumlah_pesanan'] ?> Pesanan</td>
                            <td class="td-total">Rp <?= number_format($row['total_pendapatan'], 0, ',', '.') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="3" class="empty-row">Belum ada data transaksi.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Card mobile -->
        <div class="laporan-cards">
            <?php if (!empty($riwayat_data)) : ?>
                <?php foreach ($riwayat_data as $row) : ?>
                <div class="laporan-card">
                    <div class="lc-bulan"><?= $row['bulan'] ?></div>
                    <div class="lc-meta">
                        <div>
                            <div class="lc-meta-label">Jumlah Pesanan</div>
                            <div class="lc-meta-value"><?= $row['jumlah_pesanan'] ?> Pesanan</div>
                        </div>
                        <div>
                            <div class="lc-meta-label">Total Pendapatan</div>
                            <div class="lc-meta-value green">Rp <?= number_format($row['total_pendapatan'], 0, ',', '.') ?></div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="empty-row">Belum ada data transaksi.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function cetakLaporan() {
    var konten = document.getElementById('laporanArea').innerHTML;
    var judulHalaman = 'Laporan Penjualan - Sport Center';

    var jendela = window.open('', '_blank', 'width=900,height=700');

    jendela.document.write(`
        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <title>${judulHalaman}</title>
            <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
            <style>
                * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
                body { padding: 30px; background: white; color: #111; }

                .no-print { display: none !important; }
                .laporan-cards { display: none !important; }
                .page-header-actions { display: none !important; }

                .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
                .page-title { font-size: 24px; font-weight: 800; color: #111; }
                .page-subtitle { font-size: 13px; color: #666; margin-top: 4px; }

                .stat-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px; }
                .stat-card { background: #fff; padding: 20px; border-radius: 15px; border: 1px solid #f0f0f0; display:flex; flex-direction:column; gap:8px; }
                .stat-card-icon { display:none; }
                .stat-card-label { color: #aaa; font-size: 11px; font-weight: 700; text-transform: uppercase; }
                .stat-card-value { font-size: 22px; font-weight: 800; color: #111; }

                .card { background: #fff; border-radius: 15px; border: 1px solid #f0f0f0; padding: 20px; }
                .card h4 { font-weight: 700; margin-bottom: 16px; font-size: 15px; color: #111; }

                .table-wrapper table { width: 100%; border-collapse: collapse; }
                .table-wrapper th { padding: 12px 10px; border-bottom: 2px solid #eee; color: #aaa; font-size: 11px; text-transform: uppercase; text-align: left; font-weight: 800; }
                .table-wrapper td { padding: 12px 10px; border-bottom: 1px solid #f5f5f5; font-size: 13px; color: #333; }
                .td-bulan { font-weight: 600; color: #111; }
                .td-total { font-weight: 700; color: #27ae60; }
            </style>
        </head>
        <body>
            ${konten}
            <script>
                window.onload = function() {
                    window.print();
                    window.onafterprint = function() { window.close(); };
                };
            <\/script>
        </body>
        </html>
    `);

    jendela.document.close();
}
</script>

<?= $this->endSection() ?>