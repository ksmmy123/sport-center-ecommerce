<?= $this->extend('layout/admin/main') ?>

<?= $this->section('content') ?>

<style>
    /* ============================================================
       PENGATURAN — Dark theme, selaras pelanggan_layout.php
       ============================================================ */
    .settings-wrapper { max-width: 760px; }

    .settings-section-title {
        font-size: 15px;
        font-weight: 700;
        color: var(--ink);
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .settings-section-title i { color: var(--brand); font-size: 14px; }

    .map-frame {
        width: 100%;
        height: 200px;
        border-radius: var(--radius-md);
        overflow: hidden;
        border: 1px solid var(--border);
        margin-top: 8px;
        background: var(--surface-raised);
    }
    .map-frame iframe { width: 100%; height: 100%; border: 0; }

    .map-placeholder {
        width: 100%;
        height: 200px;
        border-radius: var(--radius-md);
        border: 1.5px dashed var(--border);
        margin-top: 8px;
        background: var(--surface-raised);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: var(--ink-muted);
        gap: 8px;
        font-size: 13px;
        text-align: center;
        padding: 16px;
    }
    .map-placeholder i { font-size: 28px; }

    textarea.form-control { min-height: 90px; resize: vertical; }

    /* Info cards section */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        margin-top: 20px;
    }
    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 16px;
        background: var(--surface-raised);
        border: 1px solid var(--border-light);
        border-radius: var(--radius-md);
    }
    .info-icon {
        width: 38px; height: 38px;
        border-radius: var(--radius-sm);
        background: var(--brand-subtle);
        color: var(--brand);
        display: flex; align-items: center; justify-content: center;
        font-size: 15px;
        flex-shrink: 0;
    }
    .info-label { font-size: 11px; font-weight: 700; color: var(--ink-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
    .info-value { font-size: 13.5px; font-weight: 600; color: var(--ink); line-height: 1.5; word-break: break-word; }

    .section-spacer { margin-top: 24px; }

    @media (max-width: 768px) {
        .settings-wrapper { max-width: 100%; }
        .info-grid { grid-template-columns: 1fr; }
    }
</style>

<!-- HEADER -->
<div class="page-header">
    <div>
        <h1 class="page-title">Pengaturan Toko</h1>
        <p class="page-subtitle">Kelola informasi profil dan lokasi toko Anda.</p>
    </div>
</div>

<div class="settings-wrapper">

    <!-- FORM PROFIL TOKO -->
    <div class="card">
        <div class="settings-section-title">
            <i class="fa-solid fa-store"></i> Profil Toko
        </div>

        <form action="<?= base_url('admin/simpan_pengaturan'); ?>" method="post">
            <?= csrf_field(); ?>

            <div class="form-group">
                <label class="form-label">Nama Toko</label>
                <input type="text" name="nama_toko" class="form-control"
                       value="<?= esc($alamat_admin['nama_toko'] ?? ''); ?>" placeholder="Contoh: Sport Center Pemalang">
            </div>

            <div class="form-group">
                <label class="form-label">Alamat Lengkap</label>
                <textarea name="alamat_gudang" class="form-control" placeholder="Jalan, Kecamatan, Kota, Provinsi"><?= esc(($alamat_admin['jalan'] ?? '') . ', ' . ($alamat_admin['kecamatan'] ?? '') . ', ' . ($alamat_admin['kota'] ?? '')); ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center;">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
            </button>
        </form>
    </div>

    <!-- RINGKASAN INFORMASI TOKO -->
    <div class="card section-spacer">
        <div class="settings-section-title">
            <i class="fa-solid fa-circle-info"></i> Informasi Toko Saat Ini
        </div>

        <div class="info-grid">
            <div class="info-item">
                <div class="info-icon"><i class="fa-solid fa-shop"></i></div>
                <div>
                    <div class="info-label">Nama Toko</div>
                    <div class="info-value"><?= !empty($alamat_admin['nama_toko']) ? esc($alamat_admin['nama_toko']) : '-' ?></div>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon"><i class="fa-solid fa-location-dot"></i></div>
                <div>
                    <div class="info-label">Kecamatan / Kota</div>
                    <div class="info-value"><?= esc(($alamat_admin['kecamatan'] ?? '-') . ', ' . ($alamat_admin['kota'] ?? '-')) ?></div>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon"><i class="fa-solid fa-map"></i></div>
                <div>
                    <div class="info-label">Provinsi</div>
                    <div class="info-value"><?= !empty($alamat_admin['provinsi']) ? esc($alamat_admin['provinsi']) : '-' ?></div>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon"><i class="fa-solid fa-link"></i></div>
                <div>
                    <div class="info-label">Status Lokasi Peta</div>
                    <div class="info-value"><?= !empty($alamat_admin['maps_link']) ? 'Terpasang' : 'Belum diatur' ?></div>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>