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
    .alert-error {
        background: rgba(239,68,68,0.12);
        border: 1px solid rgba(239,68,68,0.3);
        color: #f87171;
        padding: 14px 18px;
        border-radius: var(--radius-md);
        margin-bottom: 20px;
        font-weight: 600;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .table-wrapper table { min-width: 860px; }
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

    /* ── Kolom Bukti Transfer / Verifikasi ── */
    .bukti-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #60a5fa;
        text-decoration: none;
        font-size: 12.5px;
        font-weight: 600;
        padding: 6px 10px;
        border: 1px solid rgba(96,165,250,0.25);
        border-radius: var(--radius-sm);
        background: rgba(59,130,246,0.08);
        transition: background var(--transition);
        margin-bottom: 6px;
    }
    .bukti-link:hover { background: rgba(59,130,246,0.18); }

    .verifikasi-group { display: flex; gap: 6px; }
    .btn-verif {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 11.5px;
        font-weight: 700;
        padding: 6px 10px;
        border-radius: var(--radius-sm);
        text-decoration: none;
        transition: background var(--transition);
        border: 1px solid transparent;
    }
    .btn-verif.terima {
        background: rgba(34,197,94,0.15);
        color: #4ade80;
        border-color: rgba(74,222,128,0.25);
    }
    .btn-verif.terima:hover { background: rgba(34,197,94,0.28); }
    .btn-verif.tolak {
        background: rgba(239,68,68,0.12);
        color: #f87171;
        border-color: rgba(239,68,68,0.25);
    }
    .btn-verif.tolak:hover { background: rgba(239,68,68,0.24); }

    .empty-row { padding: 30px; text-align: center; color: var(--ink-secondary); font-style: italic; }
</style>

<!-- HEADER -->
<div class="page-header">
    <div>
        <h1 class="page-title">Daftar Pesanan</h1>
        <p class="page-subtitle">Pantau dan kelola status pembayaran serta pengiriman pesanan pelanggan.</p>
    </div>
    <div class="page-header-actions">
        <a href="<?= base_url('admin/normalize_status_pembayaran') ?>" class="btn btn-secondary"
           onclick="return confirm('Rapikan data status pembayaran lama (ejaan tidak konsisten)?')">
            <i class="fa-solid fa-broom"></i> Rapikan Status Lama
        </a>
    </div>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert-success">
        <i class="fa-solid fa-circle-check"></i>
        <?= session()->getFlashdata('success'); ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert-error">
        <i class="fa-solid fa-circle-exclamation"></i>
        <?= session()->getFlashdata('error'); ?>
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
                <th>Verifikasi</th>
                <th>Pengiriman (Aksi)</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($orders)) : ?>
                <?php foreach ($orders as $row) :
                    $statusBayar = $row['status_pembayaran'] ?? '';
                    $isVaBank    = strtolower($row['metode_pembayaran'] ?? '') === 'va_bank';
                    $sudahBayar  = ($statusBayar === 'sudah_bayar' || $statusBayar === 'sudah_payar');
                    $dibatalkan  = ($statusBayar === 'dibatalkan');
                    $adaBukti    = !empty($row['bukti_transfer']);

                    // ✅ FIX: sebelumnya tombol Terima/Tolak HANYA muncul kalau
                    // status_pembayaran persis sama dengan string
                    // 'menunggu_verifikasi'. Kalau ada order lama/aneh yang
                    // nilainya NULL, kosong, atau ejaan lain (padahal bukti
                    // transfer sudah jelas-jelas ada), tombolnya tidak pernah
                    // muncul dan admin harus bolak-balik klik "Rapikan Status
                    // Lama". Sekarang jauh lebih simpel & tahan bug:
                    // tampilkan Terima/Tolak selama ada bukti transfer DAN
                    // belum berstatus sudah bayar / dibatalkan — apa pun
                    // ejaan persis status_pembayaran-nya saat ini.
                    $perluVerifikasi = $isVaBank && $adaBukti && !$sudahBayar && !$dibatalkan;
                ?>
                    <tr>
                        <td style="font-weight:700; color:var(--ink);">#ORD-<?= str_pad($row['id'], 3, '0', STR_PAD_LEFT); ?></td>

                        <td style="color:var(--ink-secondary);"><?= esc($row['username'] ?? 'Umum/Guest'); ?></td>

                        <td style="font-weight:800; color:var(--ink);">Rp <?= number_format($row['total_harga'], 0, ',', '.'); ?></td>

                        <td>
                            <?php
                                $metode = strtolower($row['metode_pembayaran']);
                                $warnaMetode = ($metode === 'cod') ? '#facc15' : (($metode === 'va_bank') ? '#60a5fa' : 'var(--ink-secondary)');
                            ?>
                            <span style="text-transform:uppercase; font-weight:600; font-size:12.5px; color:<?= $warnaMetode ?>;"><?= $row['metode_pembayaran']; ?></span>
                        </td>

                        <td style="font-weight:700;">
                            <?php if ($sudahBayar) : ?>
                                <span style="color:#4ade80;">Sudah Bayar</span>
                            <?php elseif ($dibatalkan) : ?>
                                <span style="color:#f87171;">Dibatalkan</span>
                            <?php elseif ($perluVerifikasi) : ?>
                                <span style="color:#facc15;">Menunggu Verifikasi</span>
                            <?php else : ?>
                                <span style="color:#facc15;">Belum Bayar</span>
                            <?php endif; ?>
                        </td>

                        <!-- Kolom Verifikasi bukti transfer -->
                        <td>
                            <?php if (!$isVaBank) : ?>
                                <span style="color:var(--ink-muted); font-size:12px;">— (COD)</span>
                            <?php elseif (!$adaBukti) : ?>
                                <span style="color:var(--ink-muted); font-size:12px;">Belum upload</span>
                            <?php else : ?>
                                <div>
                                    <a href="<?= base_url('uploads/bukti_transfer/' . esc($row['bukti_transfer'])) ?>"
                                       target="_blank" class="bukti-link">
                                        <i class="fa-solid fa-image"></i> Lihat Bukti
                                    </a>
                                </div>

                                <?php if ($sudahBayar) : ?>
                                    <span style="color:#4ade80; font-size:12px; font-weight:600;">
                                        <i class="fa-solid fa-circle-check"></i> Terverifikasi
                                    </span>
                                <?php elseif ($perluVerifikasi) : ?>
                                    <div class="verifikasi-group">
                                        <a href="<?= base_url('admin/terima_pembayaran/' . $row['id']) ?>"
                                           class="btn-verif terima"
                                           onclick="return confirm('Konfirmasi pembayaran order #<?= $row['id'] ?> sebagai sudah lunas?')">
                                            <i class="fa-solid fa-check"></i> Terima
                                        </a>
                                        <a href="<?= base_url('admin/tolak_pembayaran/' . $row['id']) ?>"
                                           class="btn-verif tolak"
                                           onclick="return confirm('Tolak bukti transfer order #<?= $row['id'] ?>? Pelanggan harus upload ulang.')">
                                            <i class="fa-solid fa-xmark"></i> Tolak
                                        </a>
                                    </div>
                                <?php endif; ?>
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
                    <td colspan="7" class="empty-row">Belum ada data pesanan masuk ke sistem.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>