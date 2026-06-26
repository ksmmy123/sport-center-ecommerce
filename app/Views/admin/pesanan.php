<?= $this->extend('layout/admin/main') ?>

<?= $this->section('content') ?>

<style>
    /* ============================================================
       PESANAN — Dark theme, selaras pelanggan_layout.php
       ============================================================ */
    .alert-success {
        background: rgba(34,197,94,0.12);
        border: 1px solid rgba(34,197,94,0.3);
        color: #4ade80;
        padding: 14px 18px;
        border-radius: var(--radius-md);
        margin-bottom: 20px;
        font-weight: 600;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .table-wrapper table { min-width: 760px; }
    .table-wrapper th, .table-wrapper td { white-space: nowrap; }

    .status-select {
        padding: 8px 12px;
        border-radius: var(--radius-sm);
        font-size: 11.5px;
        font-weight: 700;
        border: 1px solid var(--border);
        background: var(--surface-raised);
        color: var(--ink);
        font-family: 'Outfit', sans-serif;
        cursor: pointer;
        outline: none;
        transition: border-color var(--transition);
    }
    .status-select:focus { border-color: var(--brand); }

    .status-select.diproses { color: #facc15; }
    .status-select.dikirim  { color: #60a5fa; }
    .status-select.sampai   { color: #4ade80; }

    .empty-row { padding: 30px; text-align: center; color: var(--ink-secondary); font-style: italic; }
</style>

<!-- HEADER -->
<div class="page-header">
    <div>
        <h1 class="page-title">Daftar Pesanan</h1>
        <p class="page-subtitle">Pantau dan kelola status pembayaran serta pengiriman pesanan pelanggan.</p>
    </div>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert-success">
        <i class="fa-solid fa-circle-check"></i>
        <?= session()->getFlashdata('success'); ?>
    </div>
<?php endif; ?>

<!-- TABEL -->
<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>ID Order</th>
                <th>Pelanggan</th>
                <th>Total</th>
                <th>Metode</th>
                <th>Status Bayar</th>
                <th>Pengiriman (Aksi)</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($orders)) : ?>
                <?php foreach ($orders as $row) :
                    $statusBayar = $row['status_pembayaran'] ?? '';
                ?>
                    <tr>
                        <td style="font-weight:700; color:var(--ink);">#ORD-<?= str_pad($row['id'], 3, '0', STR_PAD_LEFT); ?></td>

                        <td style="color:var(--ink-secondary);"><?= esc($row['username'] ?? 'Umum/Guest'); ?></td>

                        <td style="font-weight:800; color:var(--ink);">Rp <?= number_format($row['total_harga'], 0, ',', '.'); ?></td>

                        <td style="text-transform:uppercase; font-weight:600; color:var(--ink-secondary); font-size:12.5px;"><?= esc($row['metode_pembayaran']); ?></td>

                        <td style="font-weight:700;">
                            <?php if ($statusBayar === 'sudah_bayar' || $statusBayar === 'sudah_payar') : ?>
                                <span style="color:#4ade80;">Sudah Bayar</span>
                            <?php elseif ($statusBayar === 'dibatalkan') : ?>
                                <span style="color:#f87171;">Dibatalkan</span>
                            <?php else : ?>
                                <span style="color:#facc15;">Belum Bayar</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <form action="<?= base_url('admin/update_status_pengiriman/' . $row['id']); ?>" method="POST">
                                <?= csrf_field(); ?>
                                <select name="status_pengiriman" onchange="this.form.submit()"
                                        class="status-select <?= esc($row['status_pengiriman']) ?>">
                                    <option value="diproses" <?= $row['status_pengiriman'] === 'diproses' ? 'selected' : ''; ?>>Diproses</option>
                                    <option value="dikirim" <?= $row['status_pengiriman'] === 'dikirim' ? 'selected' : ''; ?>>Dikirim</option>
                                    <option value="sampai" <?= $row['status_pengiriman'] === 'sampai' ? 'selected' : ''; ?>>Selesai</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="6" class="empty-row">Belum ada data pesanan masuk ke sistem.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>