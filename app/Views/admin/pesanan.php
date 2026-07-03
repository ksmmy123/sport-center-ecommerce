<?= $this->extend('layout/admin/main') ?>
<?= $this->section('content') ?>

<style>
    /* ── ALERTS ── */
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
        border: 1px solid rgba(239,68,68,0.25);
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

    /* ── TABLE ── */
    .table-wrapper table { min-width: 900px; }
    .table-wrapper th, .table-wrapper td { white-space: nowrap; }

    /* ── STATUS SELECT ── */
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

    /* ── BUKTI TRANSFER SECTION ── */
    .bukti-wrap {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Thumbnail bukti — klik untuk perbesar */
    .bukti-thumb {
        width: 44px;
        height: 44px;
        border-radius: var(--radius-sm);
        object-fit: cover;
        border: 1px solid var(--border);
        cursor: pointer;
        transition: transform var(--transition), box-shadow var(--transition);
        flex-shrink: 0;
    }
    .bukti-thumb:hover {
        transform: scale(1.08);
        box-shadow: 0 4px 12px rgba(0,0,0,0.35);
    }

    /* Tombol verifikasi */
    .btn-terima {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: rgba(34,197,94,0.15);
        color: #4ade80;
        border: 1px solid rgba(74,222,128,0.25);
        padding: 6px 12px;
        border-radius: var(--radius-sm);
        font-family: 'Outfit', sans-serif;
        font-size: 11.5px;
        font-weight: 700;
        cursor: pointer;
        white-space: nowrap;
        transition: background var(--transition), color var(--transition);
        text-decoration: none;
    }
    .btn-terima:hover { background: rgba(34,197,94,0.28); color: #86efac; }

    .btn-tolak {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: rgba(239,68,68,0.12);
        color: #f87171;
        border: 1px solid rgba(239,68,68,0.22);
        padding: 6px 12px;
        border-radius: var(--radius-sm);
        font-family: 'Outfit', sans-serif;
        font-size: 11.5px;
        font-weight: 700;
        cursor: pointer;
        white-space: nowrap;
        transition: background var(--transition), color var(--transition);
        text-decoration: none;
    }
    .btn-tolak:hover { background: rgba(239,68,68,0.25); color: #fca5a5; }

    /* Label status bukti */
    .bukti-status {
        font-size: 11px;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: var(--radius-pill);
    }
    .bukti-status.menunggu {
        background: rgba(250,204,21,0.12);
        color: #facc15;
        border: 1px solid rgba(250,204,21,0.2);
    }
    .bukti-status.diterima {
        background: rgba(34,197,94,0.12);
        color: #4ade80;
        border: 1px solid rgba(74,222,128,0.2);
    }

    /* ── MODAL PREVIEW GAMBAR ── */
    .img-modal {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.88);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 16px;
    }
    .img-modal.active { display: flex; }
    .img-modal-img {
        max-width: 88vw;
        max-height: 78vh;
        border-radius: var(--radius-lg);
        box-shadow: 0 20px 60px rgba(0,0,0,0.6);
        object-fit: contain;
    }
    .img-modal-label {
        font-size: 13px;
        color: rgba(255,255,255,0.6);
        font-weight: 500;
    }
    .img-modal-close {
        position: absolute;
        top: 16px; right: 16px;
        width: 40px; height: 40px;
        border-radius: 50%;
        background: rgba(255,255,255,0.12);
        border: none;
        color: #fff;
        font-size: 18px;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: background var(--transition);
    }
    .img-modal-close:hover { background: rgba(255,255,255,0.25); }

    .empty-row {
        padding: 30px;
        text-align: center;
        color: var(--ink-secondary);
        font-style: italic;
    }
</style>

<!-- MODAL PREVIEW BUKTI TRANSFER -->
<div class="img-modal" id="imgModal" onclick="tutupModal()">
    <button class="img-modal-close" onclick="tutupModal()">
        <i class="fa-solid fa-xmark"></i>
    </button>
    <img src="" id="imgModalSrc" class="img-modal-img" alt="Bukti Transfer">
    <span class="img-modal-label" id="imgModalLabel"></span>
</div>

<!-- PAGE HEADER -->
<div class="page-header">
    <div>
        <h1 class="page-title">Daftar Pesanan</h1>
        <p class="page-subtitle">Pantau status pembayaran, bukti transfer, dan pengiriman pesanan pelanggan.</p>
    </div>
</div>

<!-- FLASH MESSAGES -->
<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert-success">
        <i class="fa-solid fa-circle-check"></i>
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert-error">
        <i class="fa-solid fa-circle-exclamation"></i>
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<!-- TABEL PESANAN -->
<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>ID Order</th>
                <th>Pelanggan</th>
                <th>Total</th>
                <th>Metode</th>
                <th>Bukti Transfer</th>
                <th>Status Bayar</th>
                <th>Pengiriman</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($orders)) : ?>
                <?php foreach ($orders as $row) :
                    $statusBayar  = $row['status_pembayaran'] ?? '';
                    $metodeBayar  = strtolower($row['metode_pembayaran'] ?? '');
                    $buktiFoto    = $row['bukti_transfer'] ?? null;
                    $sudahBayar   = in_array($statusBayar, ['sudah_bayar', 'sudah_payar']);
                    $orderId      = str_pad($row['id'], 3, '0', STR_PAD_LEFT);
                ?>
                <tr>
                    <!-- ID -->
                    <td style="font-weight:700; color:var(--ink);">#ORD-<?= $orderId ?></td>

                    <!-- Pelanggan -->
                    <td style="color:var(--ink-secondary);">
                        <?= esc($row['username'] ?? 'Umum/Guest') ?>
                    </td>

                    <!-- Total -->
                    <td style="font-weight:800; color:var(--ink);">
                        Rp <?= number_format($row['total_harga'], 0, ',', '.') ?>
                    </td>

                    <!-- Metode -->
                    <td style="text-transform:uppercase; font-weight:600; color:var(--ink-secondary); font-size:12.5px;">
                        <?= esc($row['metode_pembayaran']) ?>
                    </td>

                    <!-- Bukti Transfer — hanya untuk va_bank -->
                    <td>
                        <?php if ($metodeBayar === 'va_bank') : ?>
                            <?php if (!empty($buktiFoto)) : ?>
                                <div class="bukti-wrap">
                                    <!-- Thumbnail — klik untuk perbesar -->
                                    <img src="<?= base_url('uploads/bukti_transfer/' . $buktiFoto) ?>"
                                         class="bukti-thumb"
                                         alt="Bukti #ORD-<?= $orderId ?>"
                                         onclick="bukaModal(this.src, '#ORD-<?= $orderId ?>')"
                                         title="Klik untuk perbesar">

                                    <?php if (!$sudahBayar) : ?>
                                        <!-- Belum diverifikasi — tampilkan tombol -->
                                        <div style="display:flex; flex-direction:column; gap:5px;">
                                            <span class="bukti-status menunggu">
                                                <i class="fa-solid fa-clock" style="font-size:9px;"></i>
                                                Menunggu
                                            </span>
                                            <!-- Tombol Terima -->
                                            <a href="<?= base_url('admin/terima_pembayaran/' . $row['id']) ?>"
                                               class="btn-terima"
                                               onclick="return confirm('Terima pembayaran #ORD-<?= $orderId ?>?')">
                                                <i class="fa-solid fa-circle-check"></i> Terima
                                            </a>
                                            <!-- Tombol Tolak -->
                                            <a href="<?= base_url('admin/tolak_pembayaran/' . $row['id']) ?>"
                                               class="btn-tolak"
                                               onclick="return confirm('Tolak bukti pembayaran ini? Pelanggan harus upload ulang.')">
                                                <i class="fa-solid fa-xmark"></i> Tolak
                                            </a>
                                        </div>
                                    <?php else : ?>
                                        <!-- Sudah diverifikasi -->
                                        <span class="bukti-status diterima">
                                            <i class="fa-solid fa-circle-check" style="font-size:9px;"></i>
                                            Diterima
                                        </span>
                                    <?php endif; ?>
                                </div>
                            <?php else : ?>
                                <!-- Belum upload bukti -->
                                <span style="font-size:12px; color:var(--ink-muted); font-style:italic;">
                                    Belum upload
                                </span>
                            <?php endif; ?>
                        <?php else : ?>
                            <!-- COD / metode lain — tidak perlu bukti -->
                            <span style="font-size:12px; color:var(--ink-muted);">—</span>
                        <?php endif; ?>
                    </td>

                    <!-- Status Bayar -->
                    <td style="font-weight:700;">
                        <?php if ($sudahBayar) : ?>
                            <span style="color:#4ade80;">
                                <i class="fa-solid fa-circle-check" style="font-size:10px;"></i>
                                Sudah Bayar
                            </span>
                        <?php elseif ($statusBayar === 'dibatalkan') : ?>
                            <span style="color:#f87171;">
                                <i class="fa-solid fa-xmark" style="font-size:10px;"></i>
                                Dibatalkan
                            </span>
                        <?php else : ?>
                            <span style="color:#facc15;">
                                <i class="fa-solid fa-clock" style="font-size:10px;"></i>
                                Belum Bayar
                            </span>
                        <?php endif; ?>
                    </td>

                    <!-- Status Pengiriman -->
                    <td>
                        <form action="<?= base_url('admin/update_status_pengiriman/' . $row['id']) ?>" method="POST">
                            <?= csrf_field() ?>
                            <select name="status_pengiriman"
                                    onchange="this.form.submit()"
                                    class="status-select <?= esc($row['status_pengiriman']) ?>">
                                <option value="diproses" <?= $row['status_pengiriman'] === 'diproses' ? 'selected' : '' ?>>Diproses</option>
                                <option value="dikirim"  <?= $row['status_pengiriman'] === 'dikirim'  ? 'selected' : '' ?>>Dikirim</option>
                                <option value="sampai"   <?= $row['status_pengiriman'] === 'sampai'   ? 'selected' : '' ?>>Selesai</option>
                            </select>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="7" class="empty-row">
                        <i class="fa-solid fa-inbox" style="font-size:24px; display:block; margin-bottom:8px; color:var(--ink-muted);"></i>
                        Belum ada data pesanan masuk ke sistem.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
    function bukaModal(src, label) {
        document.getElementById('imgModalSrc').src  = src;
        document.getElementById('imgModalLabel').textContent = 'Bukti Transfer ' + label;
        document.getElementById('imgModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function tutupModal() {
        document.getElementById('imgModal').classList.remove('active');
        document.getElementById('imgModalSrc').src = '';
        document.body.style.overflow = '';
    }

    // Tutup modal dengan tombol Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') tutupModal();
    });
</script>

<?= $this->endSection() ?>