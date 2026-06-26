<?= $this->extend('layout/admin/main') ?>

<?= $this->section('content') ?>

<style>
    /* ============================================================
       INVOICES — Dark theme, selaras pelanggan_layout.php
       ============================================================ */

    /* ===== PRINT ===== */
    @media print {
        .sidebar, .admin-topbar, .no-print { display: none !important; }
        body, .main-content { background: #fff !important; color: #000 !important; }
        .table-wrapper { box-shadow: none !important; border: 1px solid #ddd !important; }
        .table-wrapper th, .table-wrapper td { border: 1px solid #eee !important; color: #000 !important; }
        .invoice-cards { display: none !important; }
        .table-wrapper { display: block !important; }
    }

    .table-wrapper table { min-width: 700px; }

    .inv-number { font-weight: 700; color: var(--ink); }
    .inv-date   { font-size: 13px; color: var(--ink-secondary); }
    .inv-total  { font-weight: 700; color: var(--ink); }
    .inv-user   { font-size: 14px; color: var(--ink-secondary); }

    .status-lunas   { color: #4ade80; font-weight: 700; font-size: 12.5px; }
    .status-pending { color: #facc15; font-weight: 700; font-size: 12.5px; }

    .aksi-group { display: flex; justify-content: center; gap: 8px; }
    .aksi-group a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px; height: 34px;
        border-radius: var(--radius-sm);
        text-decoration: none;
        font-size: 14px;
        background: var(--surface-raised);
        color: var(--ink-secondary);
        transition: background var(--transition), color var(--transition);
    }
    .aksi-group a:hover { background: var(--surface-high); color: var(--ink); }

    /* ===== CARD MOBILE ===== */
    .invoice-cards { display: none; }

    .inv-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 16px;
        margin-bottom: 12px;
        box-shadow: var(--shadow-sm);
    }

    .inv-card-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
    }

    .inv-card-number { font-weight: 800; color: var(--ink); font-size: 15px; }
    .inv-card-date { font-size: 12px; color: var(--ink-muted); margin-top: 3px; }

    .inv-card-meta {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-bottom: 14px;
        font-size: 13px;
    }

    .inv-meta-label {
        font-size: 10px;
        font-weight: 800;
        color: var(--ink-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 3px;
    }

    .inv-meta-value { font-weight: 600; color: var(--ink); }

    .inv-card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 12px;
        border-top: 1px solid var(--border-light);
    }

    .inv-card-aksi a {
        color: var(--ink-secondary);
        margin-left: 12px;
        font-size: 16px;
        text-decoration: none;
        transition: color var(--transition);
    }
    .inv-card-aksi a:hover { color: var(--brand); }

    .empty-row { padding: 40px; text-align: center; color: var(--ink-secondary); }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .table-wrapper { display: none; }
        .invoice-cards { display: block; }
    }
</style>

<!-- HEADER -->
<div class="page-header">
    <div>
        <h1 class="page-title">Daftar Invoice</h1>
        <p class="page-subtitle">Kelola dan cetak invoice transaksi pelanggan.</p>
    </div>
    <div class="page-header-actions">
        <button onclick="window.print()" class="btn btn-primary no-print">
            <i class="fas fa-print"></i> Cetak Laporan
        </button>
    </div>
</div>

<!-- TABEL (desktop) -->
<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>No. Invoice</th>
                <th>Pelanggan ID</th>
                <th>Tanggal</th>
                <th>Total Tagihan</th>
                <th>Status</th>
                <th style="text-align:center;" class="no-print">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($invoices) && is_array($invoices)) : ?>
                <?php foreach (array_reverse($invoices) as $inv) : ?>
                <tr>
                    <td class="inv-number">#INV-<?= str_pad($inv['id'], 4, '0', STR_PAD_LEFT) ?></td>
                    <td class="inv-user"><?= $inv['user_id'] ?></td>
                    <td class="inv-date"><?= date('d M Y', strtotime($inv['tgl_pesan'])) ?></td>
                    <td class="inv-total">Rp <?= number_format($inv['total_harga'], 0, ',', '.') ?></td>
                    <td>
                        <?php $lunas = ($inv['status_pembayaran'] == 'sudah_bayar'); ?>
                        <span class="<?= $lunas ? 'status-lunas' : 'status-pending' ?>">
                            <?= strtoupper(str_replace('_', ' ', $inv['status_pembayaran'])) ?>
                        </span>
                    </td>
                    <td class="no-print">
                        <div class="aksi-group">
                            <a href="#" title="Lihat"><i class="fas fa-eye"></i></a>
                            <a href="#" title="Cetak" onclick="window.print()"><i class="fas fa-print"></i></a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="6" class="empty-row">Belum ada data invoice yang tersedia.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- CARD (mobile) -->
<div class="invoice-cards no-print">
    <?php if (!empty($invoices) && is_array($invoices)) : ?>
        <?php foreach (array_reverse($invoices) as $inv) : ?>
        <div class="inv-card">
            <div class="inv-card-top">
                <div>
                    <div class="inv-card-number">#INV-<?= str_pad($inv['id'], 4, '0', STR_PAD_LEFT) ?></div>
                    <div class="inv-card-date"><?= date('d M Y', strtotime($inv['tgl_pesan'])) ?></div>
                </div>
                <?php $lunas = ($inv['status_pembayaran'] == 'sudah_bayar'); ?>
                <span class="<?= $lunas ? 'status-lunas' : 'status-pending' ?>">
                    <?= strtoupper(str_replace('_', ' ', $inv['status_pembayaran'])) ?>
                </span>
            </div>

            <div class="inv-card-meta">
                <div>
                    <div class="inv-meta-label">Pelanggan ID</div>
                    <div class="inv-meta-value"><?= $inv['user_id'] ?></div>
                </div>
                <div>
                    <div class="inv-meta-label">Total Tagihan</div>
                    <div class="inv-meta-value">Rp <?= number_format($inv['total_harga'], 0, ',', '.') ?></div>
                </div>
            </div>

            <div class="inv-card-footer">
                <span style="font-size:12px; color:var(--ink-muted);">Invoice #<?= str_pad($inv['id'], 4, '0', STR_PAD_LEFT) ?></span>
                <div class="inv-card-aksi">
                    <a href="#" title="Lihat"><i class="fas fa-eye"></i></a>
                    <a href="#" title="Cetak" onclick="window.print()"><i class="fas fa-print"></i></a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php else : ?>
        <div class="empty-row">Belum ada data invoice yang tersedia.</div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>