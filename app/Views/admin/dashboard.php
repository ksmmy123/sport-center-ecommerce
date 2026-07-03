<?= $this->extend('layout/admin/main') ?>

<?= $this->section('content') ?>

<style>
    /* ============================================================
       DASHBOARD ADMIN — Dark theme, selaras pelanggan_layout.php
       ============================================================ */

    .dash-header { margin-bottom: 28px; }

    .section-label {
        font-size: 15px;
        font-weight: 700;
        color: var(--ink);
        margin-bottom: 14px;
        margin-top: 28px;
    }
    .section-label:first-of-type { margin-top: 0; }

    .stat-card-trend { margin-top: 2px; }

    /* ── INFO BAR (ringkasan all-time, compact) ── */
    .info-bar {
        display: flex;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        margin-bottom: 28px;
    }
    .info-bar-item {
        flex: 1;
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 18px 22px;
        border-right: 1px solid var(--border-light);
    }
    .info-bar-item:last-child { border-right: none; }
    .info-bar-icon {
        width: 40px; height: 40px;
        border-radius: var(--radius-md);
        display: flex; align-items: center; justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }
    .info-bar-icon.blue   { background: rgba(59,130,246,0.12);  color: #60a5fa; }
    .info-bar-icon.purple { background: rgba(168,85,247,0.12);  color: #c084fc; }
    .info-bar-icon.red    { background: rgba(239,68,68,0.12);   color: #f87171; }
    .info-bar-value {
        font-size: 18px;
        font-weight: 700;
        color: var(--ink);
        letter-spacing: -0.4px;
        line-height: 1.2;
    }
    .info-bar-label {
        font-size: 11.5px;
        color: var(--ink-secondary);
        font-weight: 500;
        margin-top: 2px;
    }

    /* ── CHART CARD dengan tab toggle ── */
    .chart-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        padding: 24px;
        margin-bottom: 28px;
    }
    .chart-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 20px;
    }
    .chart-card-header h3 {
        font-size: 16px;
        font-weight: 700;
        color: var(--ink);
    }
    .chart-tabs {
        display: flex;
        gap: 4px;
        background: var(--surface-raised);
        border: 1px solid var(--border);
        border-radius: var(--radius-pill);
        padding: 4px;
    }
    .chart-tab {
        border: none;
        background: transparent;
        color: var(--ink-secondary);
        font-family: 'Outfit', sans-serif;
        font-size: 12.5px;
        font-weight: 600;
        padding: 7px 16px;
        border-radius: var(--radius-pill);
        cursor: pointer;
        transition: background var(--transition), color var(--transition);
    }
    .chart-tab.active {
        background: var(--brand);
        color: #fff;
        box-shadow: 0 4px 12px rgba(249,115,22,0.3);
    }
    .stat-grid-4 {
        display: grid;
        grid-template-columns: repeat(4, minmax(220px, 1fr));
        gap: 16px;
        margin-bottom: 28px;
    }
    @media (max-width: 1200px) {
        .stat-grid-4 { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
        .stat-grid-4 { grid-template-columns: 1fr; }
    }

    .chart-tab:not(.active):hover { color: var(--ink); }

    .dashboard-grid {
        display: grid;
        grid-template-columns: 1.6fr 1fr;
        gap: 20px;
        align-items: start;
        margin-bottom: 28px;
    }
    .dashboard-grid .restock-card { height: 100%; }

    /* ── RESTOCK ── */
    .restock-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        padding: 24px;
    }
    .restock-card h3 {
        font-size: 16px;
        font-weight: 700;
        color: var(--ink);
        margin-bottom: 18px;
    }
    .restock-list {
        max-height: 280px;
        overflow-y: auto;
        padding-right: 4px;
    }
    .restock-list::-webkit-scrollbar { width: 4px; }
    .restock-list::-webkit-scrollbar-track { background: transparent; }
    .restock-list::-webkit-scrollbar-thumb { background: var(--surface-high); border-radius: var(--radius-pill); }
    .restock-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 12px;
        background: var(--surface-raised);
        border: 1px solid var(--border-light);
        border-radius: var(--radius-md);
        margin-bottom: 12px;
        transition: background var(--transition);
    }
    .restock-item:hover { background: var(--surface-high); }
    .restock-item:last-child { margin-bottom: 0; }
    .restock-thumb {
        width: 46px; height: 46px;
        border-radius: var(--radius-sm);
        overflow: hidden;
        background: var(--surface-high);
        flex-shrink: 0;
    }
    .restock-thumb img { width: 100%; height: 100%; object-fit: cover; }
    .restock-info { flex: 1; min-width: 0; }
    .restock-name {
        font-weight: 600;
        font-size: 13px;
        color: var(--ink);
        margin: 0 0 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .restock-stock {
        font-size: 11.5px;
        font-weight: 600;
        color: #f87171;
    }
    .stock-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 9px;
        border-radius: var(--radius-pill);
        font-size: 10.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .stock-badge.habis   { background: rgba(239,68,68,0.15);  color: #f87171; }
    .stock-badge.menipis { background: rgba(234,179,8,0.15);  color: #facc15; }
    .restock-empty {
        text-align: center;
        padding: 30px 10px;
        color: var(--ink-secondary);
        font-size: 13px;
    }

    /* ── PRODUK TERLARIS ── */
    .terlaris-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        padding: 24px;
        margin-bottom: 28px;
    }
    .terlaris-card h3 {
        font-size: 16px;
        font-weight: 700;
        color: var(--ink);
        margin-bottom: 4px;
    }
    .terlaris-subtitle {
        font-size: 12.5px;
        color: var(--ink-secondary);
        margin-bottom: 18px;
    }
    .terlaris-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 12px;
        border-radius: var(--radius-md);
        margin-bottom: 8px;
        transition: background var(--transition);
    }
    .terlaris-item:hover { background: var(--surface-raised); }
    .terlaris-item:last-child { margin-bottom: 0; }

    .terlaris-rank {
        width: 32px; height: 32px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-weight: 800;
        font-size: 13px;
        flex-shrink: 0;
        background: var(--surface-raised);
        color: var(--ink-secondary);
        border: 1px solid var(--border);
    }
    .terlaris-rank.gold   { background: rgba(250,204,21,0.15); color: #facc15; border-color: rgba(250,204,21,0.3); }
    .terlaris-rank.silver { background: rgba(203,213,225,0.15); color: #cbd5e1; border-color: rgba(203,213,225,0.3); }
    .terlaris-rank.bronze { background: rgba(249,115,22,0.15); color: var(--brand); border-color: rgba(249,115,22,0.3); }

    .terlaris-thumb {
        width: 44px; height: 44px;
        border-radius: var(--radius-sm);
        overflow: hidden;
        background: var(--surface-raised);
        flex-shrink: 0;
    }
    .terlaris-thumb img { width: 100%; height: 100%; object-fit: cover; }

    .terlaris-info { flex: 1; min-width: 0; }
    .terlaris-name {
        font-weight: 600;
        font-size: 13.5px;
        color: var(--ink);
        margin: 0 0 6px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .terlaris-bar-track {
        height: 5px;
        background: var(--surface-raised);
        border-radius: var(--radius-pill);
        overflow: hidden;
    }
    .terlaris-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--brand), #fbbf24);
        border-radius: var(--radius-pill);
    }

    .terlaris-sold {
        flex-shrink: 0;
        text-align: right;
        font-size: 13px;
        font-weight: 700;
        color: var(--ink);
        white-space: nowrap;
    }
    .terlaris-sold span {
        display: block;
        font-size: 10.5px;
        font-weight: 500;
        color: var(--ink-muted);
        margin-top: 2px;
    }

    /* ── MONITORING STOK ── */
    .stockmon-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        padding: 24px;
        margin-bottom: 28px;
    }
    .stockmon-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 18px;
    }
    .stockmon-header h3 {
        font-size: 16px;
        font-weight: 700;
        color: var(--ink);
    }
    .stockmon-tabs {
        display: flex;
        gap: 4px;
        background: var(--surface-raised);
        border: 1px solid var(--border);
        border-radius: var(--radius-pill);
        padding: 4px;
    }
    .stockmon-tab {
        border: none;
        background: transparent;
        color: var(--ink-secondary);
        font-family: 'Outfit', sans-serif;
        font-size: 12.5px;
        font-weight: 600;
        padding: 7px 16px;
        border-radius: var(--radius-pill);
        cursor: pointer;
        transition: background var(--transition), color var(--transition);
        display: flex; align-items: center; gap: 6px;
    }
    .stockmon-tab.active.habis   { background: #ef4444; color: #fff; box-shadow: 0 4px 12px rgba(239,68,68,0.3); }
    .stockmon-tab.active.menipis { background: #facc15; color: #1a1a1a; box-shadow: 0 4px 12px rgba(250,204,21,0.3); }
    .stockmon-tab:not(.active):hover { color: var(--ink); }
    .stockmon-count-pill {
        font-size: 10.5px;
        font-weight: 700;
        background: rgba(255,255,255,0.18);
        padding: 1px 7px;
        border-radius: var(--radius-pill);
    }

    .stockmon-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 12px;
    }
    .stockmon-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        background: var(--surface-raised);
        border: 1px solid var(--border-light);
        border-radius: var(--radius-md);
        transition: background var(--transition);
    }
    .stockmon-item:hover { background: var(--surface-high); }
    .stockmon-thumb {
        width: 42px; height: 42px;
        border-radius: var(--radius-sm);
        overflow: hidden;
        background: var(--surface-high);
        flex-shrink: 0;
    }
    .stockmon-thumb img { width: 100%; height: 100%; object-fit: cover; }
    .stockmon-info { flex: 1; min-width: 0; }
    .stockmon-name {
        font-weight: 600;
        font-size: 13px;
        color: var(--ink);
        margin: 0 0 5px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .stockmon-empty {
        grid-column: 1 / -1;
        text-align: center;
        padding: 30px 10px;
        color: var(--ink-secondary);
        font-size: 13px;
    }

    /* ── RESPONSIVE ── */
    @media (max-width: 1024px) {
        .dashboard-grid { grid-template-columns: 1fr; }
    }

    @media (max-width: 768px) {
        .info-bar { flex-direction: column; }
        .info-bar-item { border-right: none; border-bottom: 1px solid var(--border-light); }
        .info-bar-item:last-child { border-bottom: none; }
        .chart-card-header { flex-direction: column; align-items: flex-start; }
        .chart-tabs { width: 100%; }
        .chart-tab { flex: 1; text-align: center; }
    }
</style>

<!-- HEADER -->
<div class="page-header dash-header">
    <div>
        <h1 class="page-title">Dashboard Utama</h1>
        <p class="page-subtitle">Pantau performa toko sport Anda secara real-time.</p>
    </div>
</div>

<!-- ============================================================
     RINGKASAN BULAN INI (UTS E-Business)
     ============================================================ -->
<div class="section-label">Ringkasan Bulan Ini (<?= date('F Y') ?>)</div>

<div class="stat-grid-4">

    <div class="stat-card">
        <div class="stat-card-icon green"><i class="fa-solid fa-sack-dollar"></i></div>
        <div>
            <div class="stat-card-value">Rp <?= number_format($total_pendapatan_bulan_ini, 0, ',', '.'); ?></div>
            <div class="stat-card-label">Total Pendapatan</div>
            <div class="stat-card-trend <?= $trend_pendapatan >= 0 ? 'up' : 'down' ?>">
                <i class="fa-solid fa-arrow-<?= $trend_pendapatan >= 0 ? 'up' : 'down' ?>"></i>
                <?= abs($trend_pendapatan) ?>% vs bulan lalu
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-icon orange"><i class="fa-solid fa-bag-shopping"></i></div>
        <div>
            <div class="stat-card-value"><?= number_format($total_pesanan_bulan_ini, 0, ',', '.'); ?></div>
            <div class="stat-card-label">Total Pesanan Masuk</div>
            <div class="stat-card-trend <?= $trend_pesanan >= 0 ? 'up' : 'down' ?>">
                <i class="fa-solid fa-arrow-<?= $trend_pesanan >= 0 ? 'up' : 'down' ?>"></i>
                <?= abs($trend_pesanan) ?>% vs bulan lalu
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-icon blue"><i class="fa-solid fa-coins"></i></div>
        <div>
            <div class="stat-card-value">Rp <?= number_format($omzet, 0, ',', '.'); ?></div>
            <div class="stat-card-label">Total Penjualan</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-icon purple"><i class="fa-solid fa-box-open"></i></div>
        <div>
            <div class="stat-card-value"><?= number_format($total_produk, 0, ',', '.'); ?> Item</div>
            <div class="stat-card-label">Total Produk</div>
        </div>
    </div>
</div>

<!-- ============================================================
     GRAFIK PENJUALAN + RESTOCK SEGERA — sejajar
     ============================================================ -->
<div class="dashboard-grid">
    <div class="chart-card" style="margin-bottom: 0;">
        <div class="chart-card-header">
            <h3>Tren Penjualan</h3>
            <div class="chart-tabs">
                <button class="chart-tab active" data-mode="30hari" type="button">30 Hari Terakhir</button>
                <button class="chart-tab" data-mode="bulanan" type="button">Per Bulan (<?= date('Y') ?>)</button>
            </div>
        </div>
        <div style="height: 240px; position: relative;">
            <canvas id="chartPenjualan"></canvas>
        </div>
    </div>

    <div class="restock-card">
        <!-- ============================================================
             MONITORING STOK — Habis & Menipis (UTS E-Business)
             ============================================================ -->
       
            <div class="stockmon-header">
                <h3>Monitoring Stok</h3>
                <div class="stockmon-tabs">
                    <button class="stockmon-tab habis active" data-target="stockmon-habis" type="button">
                        <i class="fa-solid fa-circle-xmark"></i> Habis
                        <span class="stockmon-count-pill"><?= $stok_habis_count ?></span>
                    </button>
                    <button class="stockmon-tab menipis" data-target="stockmon-menipis" type="button">
                        <i class="fa-solid fa-triangle-exclamation"></i> Menipis
                        <span class="stockmon-count-pill"><?= $stok_menipis_count ?></span>
                    </button>
                </div>
            </div>

            <!-- TAB: HABIS -->
            <div class="stockmon-grid" id="stockmon-habis">
                <?php if (empty($stok_habis_list)) : ?>
                    <div class="stockmon-empty">
                        <i class="fa-solid fa-circle-check" style="font-size:22px; color:#4ade80; display:block; margin-bottom:8px;"></i>
                        Tidak ada produk yang stoknya habis.
                    </div>
                <?php else : ?>
                    <?php foreach ($stok_habis_list as $p) : ?>
                    <div class="stockmon-item">
                        <div class="stockmon-thumb">
                            <img src="<?= base_url('images/' . $p['gambar']); ?>" alt="<?= esc($p['nama_produk']) ?>">
                        </div>
                        <div class="stockmon-info">
                            <p class="stockmon-name"><?= esc($p['nama_produk']); ?></p>
                            <span class="badge badge-danger">Habis (0 pcs)</span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- TAB: MENIPIS -->
            <div class="stockmon-grid" id="stockmon-menipis" style="display:none;">
                <?php if (empty($stok_menipis_list)) : ?>
                    <div class="stockmon-empty">
                        <i class="fa-solid fa-circle-check" style="font-size:22px; color:#4ade80; display:block; margin-bottom:8px;"></i>
                        Tidak ada produk dengan stok menipis.
                    </div>
                <?php else : ?>
                    <?php foreach ($stok_menipis_list as $p) : ?>
                    <div class="stockmon-item">
                        <div class="stockmon-thumb">
                            <img src="<?= base_url('images/' . $p['gambar']); ?>" alt="<?= esc($p['nama_produk']) ?>">
                        </div>
                        <div class="stockmon-info">
                            <p class="stockmon-name"><?= esc($p['nama_produk']); ?></p>
                            <span class="badge badge-warning">Menipis (<?= esc($p['total_stok']); ?> pcs)</span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

<!-- ============================================================
     PRODUK TERLARIS (UTS E-Business — Top 5)
     ============================================================ -->
<div class="terlaris-card">
    <h3>5 Produk Terlaris</h3>
    <p class="terlaris-subtitle">Berdasarkan jumlah unit terjual (transaksi tidak dibatalkan)</p>

    <?php if (empty($produk_terlaris_list)) : ?>
        <div class="restock-empty">
            <i class="fa-solid fa-chart-line" style="font-size:24px; color:var(--ink-muted); display:block; margin-bottom:8px;"></i>
            Belum ada data penjualan produk.
        </div>
    <?php else : ?>
        <?php
            $maxTerjual = $produk_terlaris_list[0]['total_terjual'] ?? 1;
            $rankClass  = ['gold', 'silver', 'bronze'];
        ?>
        <?php foreach ($produk_terlaris_list as $i => $p) :
            $persen = $maxTerjual > 0 ? round(($p['total_terjual'] / $maxTerjual) * 100) : 0;
        ?>
        <div class="terlaris-item">
            <div class="terlaris-rank <?= $rankClass[$i] ?? '' ?>"><?= $i + 1 ?></div>
            <div class="terlaris-thumb">
                <img src="<?= base_url('images/' . $p['gambar']); ?>" alt="<?= esc($p['nama_produk']) ?>">
            </div>
            <div class="terlaris-info">
                <p class="terlaris-name"><?= esc($p['nama_produk']); ?></p>
                <div class="terlaris-bar-track">
                    <div class="terlaris-bar-fill" style="width: <?= $persen ?>%;"></div>
                </div>
            </div>
            <div class="terlaris-sold">
                <?= number_format($p['total_terjual'], 0, ',', '.') ?>
                <span>terjual</span>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    Chart.defaults.color = '#94a3b8';
    Chart.defaults.borderColor = 'rgba(255,255,255,0.07)';

    // ============================================================
    // DATA SET — disiapkan dari PHP
    // ============================================================
    const dataset30Hari = {
        labels: <?= $chart_30hari_labels; ?>,
        values: <?= $chart_30hari_data; ?>
    };
    const datasetBulanan = {
        labels: <?= $chart_labels; ?>,
        values: <?= $chart_data; ?>
    };

    const ctx = document.getElementById('chartPenjualan').getContext('2d');

    function buildConfig(mode) {
        if (mode === '30hari') {
            return {
                type: 'bar',
                data: {
                    labels: dataset30Hari.labels,
                    datasets: [{
                        label: 'Pendapatan Harian',
                        data: dataset30Hari.values,
                        backgroundColor: 'rgba(96, 165, 250, 0.55)',
                        hoverBackgroundColor: '#60a5fa',
                        borderRadius: 4,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(255,255,255,0.06)' },
                            ticks: { callback: v => 'Rp ' + v.toLocaleString() }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { maxRotation: 0, autoSkip: true, maxTicksLimit: 8 }
                        }
                    }
                }
            };
        }

        // mode === 'bulanan'
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(249, 115, 22, 0.35)');
        gradient.addColorStop(1, 'rgba(249, 115, 22, 0)');

        return {
            type: 'line',
            data: {
                labels: datasetBulanan.labels,
                datasets: [{
                    label: 'Penjualan',
                    data: datasetBulanan.values,
                    borderColor: '#f97316',
                    backgroundColor: gradient,
                    fill: true,
                    borderWidth: 3,
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: '#0f172a',
                    pointBorderColor: '#f97316',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        min: 15000,
                        suggestedMax: 200000,
                        grid: { color: 'rgba(255,255,255,0.06)' },
                        ticks: {
                            stepSize: 30000,
                            callback: v => 'Rp ' + v.toLocaleString()
                        }
                    },
                    x: { grid: { display: false } }
                }
            }
        };
    }

    let currentChart = new Chart(ctx, buildConfig('30hari'));

    // ============================================================
    // TAB TOGGLE
    // ============================================================
    document.querySelectorAll('.chart-tab').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.chart-tab').forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            currentChart.destroy();
            currentChart = new Chart(ctx, buildConfig(this.dataset.mode));
        });
    });
});

// ============================================================
// TOGGLE TAB MONITORING STOK (Habis / Menipis)
// ============================================================
document.querySelectorAll('.stockmon-tab').forEach(btn => {
    btn.addEventListener('click', function () {
        document.querySelectorAll('.stockmon-tab').forEach(b => b.classList.remove('active'));
        this.classList.add('active');

        document.querySelectorAll('.stockmon-grid').forEach(g => g.style.display = 'none');
        document.getElementById(this.dataset.target).style.display = 'grid';
    });
});
</script>

<?= $this->endSection() ?>