<?= $this->extend('layout/admin/main') ?>

<?= $this->section('content') ?>

<style>
    /* ============================================================
       PENGATURAN — Dark theme, selaras pelanggan_layout.php
       ============================================================ */
    .settings-wrapper { max-width: 900px; }

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
    .settings-section-desc {
        font-size: 12.5px;
        color: var(--ink-secondary);
        margin-top: -14px;
        margin-bottom: 20px;
    }

    /* ── SUB-LABEL untuk mengelompokkan field dalam satu form ── */
    .form-subgroup-label {
        font-size: 11px;
        font-weight: 700;
        color: var(--ink-muted);
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin: 22px 0 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .form-subgroup-label:first-of-type { margin-top: 0; }
    .form-subgroup-label i { color: var(--brand); font-size: 11px; }

    /* ── GRID FORM ── */
    .form-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0 20px;
    }
    .form-grid-3 {
        display: grid;
        grid-template-columns: 1.4fr 1fr 1fr;
        gap: 0 20px;
    }

    .map-frame {
        width: 100%;
        height: 220px;
        border-radius: var(--radius-md);
        overflow: hidden;
        border: 1px solid var(--border);
        background: var(--surface-raised);
    }
    .map-frame iframe { width: 100%; height: 100%; border: 0; }

    .map-placeholder {
        width: 100%;
        height: 160px;
        border-radius: var(--radius-md);
        border: 1.5px dashed var(--border);
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
    .map-placeholder i { font-size: 26px; }

    textarea.form-control { min-height: 90px; resize: vertical; }

    .form-hint {
        font-size: 11.5px;
        color: var(--ink-muted);
        margin-top: -12px;
        margin-bottom: 18px;
        display: flex;
        align-items: flex-start;
        gap: 6px;
        line-height: 1.6;
    }
    .form-hint i { margin-top: 2px; flex-shrink: 0; }

    /* Icon-prefix input (telepon, email) */
    .input-icon-wrap { position: relative; }
    .input-icon-wrap i {
        position: absolute;
        left: 14px; top: 50%; transform: translateY(-50%);
        color: var(--ink-muted);
        font-size: 13px;
        pointer-events: none;
    }
    .input-icon-wrap input { padding-left: 38px; }

    /* ── INFO LIST — ringkasan info detail ── */
    .info-list {
        display: flex;
        flex-direction: column;
        gap: 0;
    }
    .info-row {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 14px 0;
        border-bottom: 1px solid var(--border-light);
    }
    .info-row:last-child { border-bottom: none; padding-bottom: 0; }
    .info-row:first-child { padding-top: 0; }
    .info-icon {
        width: 38px; height: 38px;
        border-radius: var(--radius-sm);
        background: var(--brand-subtle);
        color: var(--brand);
        display: flex; align-items: center; justify-content: center;
        font-size: 15px;
        flex-shrink: 0;
    }
    .info-icon.blue   { background: rgba(59,130,246,0.12); color: #60a5fa; }
    .info-icon.green  { background: rgba(34,197,94,0.12);  color: #4ade80; }
    .info-icon.purple { background: rgba(168,85,247,0.12); color: #c084fc; }

    .info-content { flex: 1; min-width: 0; }
    .info-label { font-size: 11px; font-weight: 700; color: var(--ink-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
    .info-value { font-size: 13.5px; font-weight: 600; color: var(--ink); line-height: 1.6; word-break: break-word; }
    .info-value.muted { color: var(--ink-muted); font-weight: 400; font-style: italic; }

    /* Badge status lokasi peta */
    .map-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 11.5px;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: var(--radius-pill);
    }
    .map-status-badge.aktif { background: rgba(34,197,94,0.12); color: #4ade80; border: 1px solid rgba(74,222,128,0.2); }
    .map-status-badge.kosong { background: rgba(239,68,68,0.12); color: #f87171; border: 1px solid rgba(248,113,113,0.2); }

    /* ✦ Link buka peta di samping badge status */
    .map-open-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        font-weight: 600;
        color: #60a5fa;
        text-decoration: none;
        margin-left: 10px;
        transition: color var(--transition);
    }
    .map-open-link:hover { color: #93c5fd; text-decoration: underline; }

    /* ✦ Section preview peta di bawah ringkasan info */
    .map-preview-section {
        margin-top: 22px;
        padding-top: 20px;
        border-top: 1px solid var(--border-light);
    }
    .map-preview-label {
        font-size: 12px;
        font-weight: 700;
        color: var(--ink-secondary);
        text-transform: uppercase;
        letter-spacing: 0.6px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .map-preview-label i { color: var(--brand); }
    .map-fullscreen-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        font-weight: 600;
        color: var(--ink-secondary);
        text-decoration: none;
        margin-top: 10px;
        transition: color var(--transition);
    }
    .map-fullscreen-link:hover { color: var(--brand); }

    .section-spacer { margin-top: 24px; }

    /* ============================================================
       ✦ TAB NAVIGATION — memecah halaman jadi 2 "slide" supaya
       tidak perlu scroll panjang (Edit vs Ringkasan & Peta)
       ============================================================ */
    .settings-tabs {
        display: flex;
        gap: 4px;
        margin-bottom: 20px;
        border-bottom: 1px solid var(--border);
    }
    .settings-tab-btn {
        background: none;
        border: none;
        color: var(--ink-secondary);
        padding: 12px 18px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        border-bottom: 2px solid transparent;
        margin-bottom: -1px;
        transition: color var(--transition), border-color var(--transition);
        font-family: inherit;
    }
    .settings-tab-btn i { font-size: 12px; }
    .settings-tab-btn:hover { color: var(--ink); }
    .settings-tab-btn.active { color: var(--brand); border-bottom-color: var(--brand); }

    .settings-tab-panel { display: none; }
    .settings-tab-panel.active { display: block; }

    .settings-tab-footer-nav {
        display: flex;
        justify-content: flex-end;
        margin-top: 16px;
    }
    .settings-tab-footer-nav .btn { width: auto; }

    /* ── RESPONSIVE ── */
    @media (max-width: 768px) {
        .settings-wrapper { max-width: 100%; }
        .form-grid-2, .form-grid-3 { grid-template-columns: 1fr; }
        .map-open-link { display: block; margin-left: 0; margin-top: 6px; }
        .settings-tab-btn { flex: 1; justify-content: center; padding: 12px 8px; font-size: 12px; }
        .settings-tab-btn span { display: none; }
    }
</style>

<!-- HEADER -->
<div class="page-header">
    <div>
        <h1 class="page-title">Pengaturan Toko</h1>
        <p class="page-subtitle">Kelola informasi profil, alamat, kontak, dan lokasi toko Anda secara rinci.</p>
    </div>
</div>

<div class="settings-wrapper">

    <!-- ✦ TAB NAV -->
    <div class="settings-tabs">
        <button type="button" class="settings-tab-btn active" data-tab="ringkasan" onclick="switchSettingsTab('ringkasan')">
            <i class="fa-solid fa-map-location-dot"></i> <span>Ringkasan &amp; Peta</span>
        </button>
        <button type="button" class="settings-tab-btn" data-tab="edit" onclick="switchSettingsTab('edit')">
            <i class="fa-solid fa-pen-to-square"></i> <span>Edit Profil Toko</span>
        </button>
    </div>

    <!-- ============================================================
         TAB 1 — FORM EDIT
         ============================================================ -->
    <div class="settings-tab-panel" id="tab-edit">
        <div class="card">
            <div class="settings-section-title">
                <i class="fa-solid fa-store"></i> Profil &amp; Alamat Toko
            </div>
            <p class="settings-section-desc">Data ini digunakan sebagai alamat pengiriman "Dikirim Dari" pada halaman checkout pelanggan, dan otomatis menentukan lokasi peta di tab "Ringkasan &amp; Peta".</p>

            <form action="<?= base_url('admin/simpan_pengaturan'); ?>" method="post">
                <?= csrf_field(); ?>

                <!-- SUB: Identitas Toko -->
                <div class="form-subgroup-label"><i class="fa-solid fa-id-card"></i> Identitas Toko</div>

                <div class="form-group">
                    <label class="form-label">Nama Toko</label>
                    <input type="text" name="nama_toko" class="form-control"
                           value="<?= esc($alamat_admin['nama_toko'] ?? ''); ?>" placeholder="Contoh: Sport Center Pemalang">
                </div>

                <!-- SUB: Alamat Terperinci -->
                <div class="form-subgroup-label"><i class="fa-solid fa-location-dot"></i> Alamat Terperinci</div>

                <div class="form-group">
                    <label class="form-label">Nama Jalan / Detail Alamat</label>
                    <input type="text" name="jalan" class="form-control"
                           value="<?= esc($alamat_admin['jalan'] ?? ''); ?>"
                           placeholder="Contoh: Jl. Menur 7 Gang Depot, Kebukuran">
                </div>

                <div class="form-grid-3">
                    <div class="form-group">
                        <label class="form-label">Kecamatan</label>
                        <input type="text" name="kecamatan" class="form-control"
                               value="<?= esc($alamat_admin['kecamatan'] ?? ''); ?>" placeholder="Contoh: Comal">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kota / Kabupaten</label>
                        <input type="text" name="kota" class="form-control"
                               value="<?= esc($alamat_admin['kota'] ?? ''); ?>" placeholder="Contoh: Pemalang">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kode Pos</label>
                        <input type="text" name="kode_pos" class="form-control"
                               value="<?= esc($alamat_admin['kode_pos'] ?? ''); ?>" placeholder="Contoh: 52362">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Provinsi</label>
                    <input type="text" name="provinsi" class="form-control"
                           value="<?= esc($alamat_admin['provinsi'] ?? ''); ?>" placeholder="Contoh: Jawa Tengah">
                </div>

                <!-- SUB: Kontak & Operasional -->
                <div class="form-subgroup-label"><i class="fa-solid fa-headset"></i> Kontak &amp; Jam Operasional</div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label">Nomor Telepon / WhatsApp</label>
                        <div class="input-icon-wrap">
                            <i class="fa-solid fa-phone"></i>
                            <input type="text" name="no_telepon" class="form-control"
                                   value="<?= esc($alamat_admin['no_telepon'] ?? ''); ?>" placeholder="0812-3456-xxxx">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email Toko</label>
                        <div class="input-icon-wrap">
                            <i class="fa-solid fa-envelope"></i>
                            <input type="email" name="email" class="form-control"
                                   value="<?= esc($alamat_admin['email'] ?? ''); ?>" placeholder="halo@tokoanda.id">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Jam Operasional</label>
                    <input type="text" name="jam_operasional" class="form-control"
                           value="<?= esc($alamat_admin['jam_operasional'] ?? ''); ?>"
                           placeholder="Contoh: Senin – Sabtu, 08.00 – 20.00 WIB">
                </div>

                <p class="form-hint">
                    <i class="fa-solid fa-circle-info"></i>
                    <span>Link peta Google Maps tidak perlu diisi manual — sistem otomatis membangun peta dari alamat (Jalan, Kecamatan, Kota, Provinsi, Kode Pos) yang kamu isi di atas. Cek hasilnya di tab "Ringkasan &amp; Peta".</span>
                </p>

                <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center;">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                </button>
            </form>
        </div>
    </div>

    <!-- ============================================================
         TAB 2 — RINGKASAN & PETA
         ============================================================ -->
    <div class="settings-tab-panel active" id="tab-ringkasan">
        <div class="card">
            <div class="settings-section-title">
                <i class="fa-solid fa-circle-info"></i> Ringkasan Informasi Toko Saat Ini
            </div>
            <p class="settings-section-desc">Berikut tampilan data toko yang sedang aktif digunakan di seluruh sistem.</p>

            <div class="info-list">

                <div class="info-row">
                    <div class="info-icon"><i class="fa-solid fa-shop"></i></div>
                    <div class="info-content">
                        <div class="info-label">Nama Toko</div>
                        <div class="info-value <?= empty($alamat_admin['nama_toko']) ? 'muted' : '' ?>">
                            <?= !empty($alamat_admin['nama_toko']) ? esc($alamat_admin['nama_toko']) : '— Belum diatur' ?>
                        </div>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-icon"><i class="fa-solid fa-location-dot"></i></div>
                    <div class="info-content">
                        <div class="info-label">Alamat Lengkap</div>
                        <div class="info-value">
                            <?php
                                $bagianAlamat = array_filter([
                                    $alamat_admin['jalan'] ?? '',
                                    !empty($alamat_admin['kecamatan']) ? 'Kec. ' . $alamat_admin['kecamatan'] : '',
                                    $alamat_admin['kota'] ?? '',
                                    $alamat_admin['provinsi'] ?? '',
                                    !empty($alamat_admin['kode_pos']) ? $alamat_admin['kode_pos'] : '',
                                ]);
                            ?>
                            <?= !empty($bagianAlamat) ? esc(implode(', ', $bagianAlamat)) : '— Belum diatur' ?>
                        </div>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-icon blue"><i class="fa-solid fa-phone"></i></div>
                    <div class="info-content">
                        <div class="info-label">Kontak</div>
                        <div class="info-value <?= empty($alamat_admin['no_telepon']) && empty($alamat_admin['email']) ? 'muted' : '' ?>">
                            <?php if (!empty($alamat_admin['no_telepon'])) : ?>
                                <i class="fa-solid fa-phone" style="font-size:11px; color:var(--ink-muted); margin-right:4px;"></i><?= esc($alamat_admin['no_telepon']) ?>
                            <?php endif; ?>
                            <?php if (!empty($alamat_admin['no_telepon']) && !empty($alamat_admin['email'])) : ?>
                                <span style="color:var(--ink-muted); margin:0 6px;">·</span>
                            <?php endif; ?>
                            <?php if (!empty($alamat_admin['email'])) : ?>
                                <i class="fa-solid fa-envelope" style="font-size:11px; color:var(--ink-muted); margin-right:4px;"></i><?= esc($alamat_admin['email']) ?>
                            <?php endif; ?>
                            <?php if (empty($alamat_admin['no_telepon']) && empty($alamat_admin['email'])) : ?>
                                — Belum diatur
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-icon green"><i class="fa-solid fa-clock"></i></div>
                    <div class="info-content">
                        <div class="info-label">Jam Operasional</div>
                        <div class="info-value <?= empty($alamat_admin['jam_operasional']) ? 'muted' : '' ?>">
                            <?= !empty($alamat_admin['jam_operasional']) ? esc($alamat_admin['jam_operasional']) : '— Belum diatur' ?>
                        </div>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-icon purple"><i class="fa-solid fa-map"></i></div>
                    <div class="info-content">
                        <div class="info-label">Status Lokasi Peta</div>
                        <div class="info-value">
                            <?php if (!empty($alamat_admin['maps_link'])) : ?>
                                <span class="map-status-badge aktif"><i class="fa-solid fa-circle-check"></i> Terpasang</span>
                                <a href="<?= esc($alamat_admin['maps_link'], 'attr') ?>" target="_blank" rel="noopener" class="map-open-link">
                                    <i class="fa-solid fa-up-right-from-square"></i> Buka di Google Maps
                                </a>
                            <?php else : ?>
                                <span class="map-status-badge kosong"><i class="fa-solid fa-circle-exclamation"></i> Belum diatur</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>

            <!-- ✦ Preview peta tertanam, tampil jika link Maps sudah diisi -->
            <?php if (!empty($alamat_admin['maps_link'])) : ?>
                <div class="map-preview-section">
                    <div class="map-preview-label">
                        <i class="fa-solid fa-map-location-dot"></i> Pratinjau Lokasi
                    </div>
                    <div class="map-frame">
                        <iframe
                            src="<?= esc($alamat_admin['maps_link'], 'attr') ?>"
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            allowfullscreen>
                        </iframe>
                    </div>
                    <a href="<?= esc($alamat_admin['maps_link'], 'attr') ?>" target="_blank" rel="noopener" class="map-fullscreen-link">
                        <i class="fa-solid fa-expand"></i> Buka peta di halaman penuh
                    </a>
                </div>
            <?php else : ?>
                <div class="map-preview-section">
                    <div class="map-preview-label">
                        <i class="fa-solid fa-map-location-dot"></i> Pratinjau Lokasi
                    </div>
                    <div class="map-placeholder">
                        <i class="fa-solid fa-map-location-dot"></i>
                        <span>Alamat toko belum diisi.<br>Lengkapi alamat di tab "Edit Profil Toko" untuk menampilkan peta di sini.</span>
                    </div>
                </div>
            <?php endif; ?>

            <div class="settings-tab-footer-nav">
                <button type="button" class="btn btn-secondary" onclick="switchSettingsTab('edit')">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Edit
                </button>
            </div>
        </div>
    </div>

</div>

<script>
    function switchSettingsTab(tab) {
        document.querySelectorAll('.settings-tab-panel').forEach(function (panel) {
            panel.classList.remove('active');
        });
        document.querySelectorAll('.settings-tab-btn').forEach(function (btn) {
            btn.classList.remove('active');
        });
        document.getElementById('tab-' + tab).classList.add('active');
        document.querySelector('.settings-tab-btn[data-tab="' + tab + '"]').classList.add('active');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Kalau baru saja submit form dan ada notifikasi sukses, langsung
    // arahkan ke tab Ringkasan supaya admin langsung lihat hasilnya.
    document.addEventListener('DOMContentLoaded', function () {
        var successFlash = document.querySelector('.alert-success, [data-flash="success"]');
        if (successFlash) {
            switchSettingsTab('ringkasan');
        }
    });
</script>

<?= $this->endSection() ?>