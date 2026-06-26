<?= $this->extend('layout/pelanggan_layout') ?>

<?= $this->section('content') ?>
<style>
    /* ── PAGE CONTAINER ── */
    .edit-wrapper {
        max-width: 640px;
        margin: 0 auto;
    }

    /* ── PAGE HEADER ── */
    .edit-header {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 32px;
    }
    .edit-back {
        width: 38px; height: 38px;
        border-radius: 50%;
        background: var(--surface-raised);
        border: 1px solid var(--border);
        display: flex; align-items: center; justify-content: center;
        color: var(--ink);
        text-decoration: none;
        font-size: 14px;
        flex-shrink: 0;
        transition: background var(--transition), border-color var(--transition);
    }
    .edit-back:hover { background: var(--surface-high); border-color: rgba(255,255,255,0.15); }
    .edit-title {
        font-size: 22px;
        font-weight: 800;
        letter-spacing: -0.5px;
        color: var(--ink);
    }

    /* ── AVATAR SECTION ── */
    .avatar-section {
        display: flex;
        justify-content: center;
        margin-bottom: 36px;
    }
    .avatar-wrap {
        position: relative;
        width: 112px;
        height: 112px;
    }
    .avatar-circle {
        width: 112px; height: 112px;
        border-radius: 50%;
        border: 2.5px solid var(--brand);
        overflow: hidden;
        background: var(--surface-raised);
        display: flex; align-items: center; justify-content: center;
    }
    .avatar-circle i { font-size: 50px; color: var(--ink-muted); }
    .avatar-circle img { width: 100%; height: 100%; object-fit: cover; }

    .avatar-upload-btn {
        position: absolute;
        bottom: 0; right: 0;
        width: 36px; height: 36px;
        border-radius: 50%;
        background: var(--surface);
        border: 1.5px solid var(--border);
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        box-shadow: var(--shadow-sm);
        transition: background var(--transition), border-color var(--transition);
    }
    .avatar-upload-btn:hover { background: var(--brand); border-color: var(--brand); }
    .avatar-upload-btn:hover i { color: #fff; }
    .avatar-upload-btn i {
        font-size: 13px;
        color: var(--ink-secondary);
        transition: color var(--transition);
    }

    /* ── FORM CARD ── */
    .edit-form-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-xl);
        padding: 28px 24px;
    }

    /* ── FORM GROUP ── */
    .form-group {
        margin-bottom: 22px;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .form-group:last-of-type { margin-bottom: 0; }

    .form-label {
        font-size: 13px;
        font-weight: 600;
        color: var(--ink-secondary);
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .form-label .hint {
        font-size: 11px;
        font-weight: 400;
        color: var(--ink-muted);
    }

    .form-input,
    .form-select,
    .form-textarea {
        width: 100%;
        background: var(--surface-raised);
        border: 1.5px solid var(--border);
        color: var(--ink);
        padding: 13px 16px;
        border-radius: var(--radius-md);
        font-family: 'Outfit', sans-serif;
        font-size: 14px;
        outline: none;
        transition: border-color var(--transition), box-shadow var(--transition);
        box-sizing: border-box;
    }
    .form-input::placeholder,
    .form-textarea::placeholder { color: var(--ink-muted); }

    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
        border-color: var(--brand);
        box-shadow: 0 0 0 3px var(--brand-glow);
    }

    .form-select {
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 16px center;
        padding-right: 40px;
    }

    .form-textarea {
        min-height: 96px;
        resize: vertical;
        line-height: 1.6;
        font-family: 'Outfit', sans-serif;
    }

    /* ── ROW: 2 kolom (Kecamatan / Desa) ── */
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 22px;
    }
    .form-row .form-group { margin-bottom: 0; }

    /* ── SUBMIT BUTTON ── */
    .form-divider {
        height: 1px;
        background: var(--border);
        margin: 28px 0 22px;
    }
    .btn-submit {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: var(--brand);
        color: #fff;
        border: none;
        padding: 15px;
        border-radius: var(--radius-md);
        font-family: 'Outfit', sans-serif;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        transition: background var(--transition), transform var(--transition), box-shadow var(--transition);
        box-shadow: 0 4px 16px rgba(249,115,22,0.35);
    }
    .btn-submit:hover {
        background: var(--brand-dark);
        transform: translateY(-1px);
        box-shadow: 0 6px 22px rgba(249,115,22,0.45);
    }
    .btn-submit:active { transform: translateY(0); }

    /* ── RESPONSIVE ── */
    @media (max-width: 600px) {
        .edit-form-card { padding: 22px 18px; border-radius: var(--radius-lg); }
        .form-row { grid-template-columns: 1fr; gap: 22px; }
        .avatar-circle { width: 96px; height: 96px; }
        .avatar-wrap { width: 96px; height: 96px; }
        .avatar-circle i { font-size: 42px; }
        .edit-title { font-size: 19px; }
    }
</style>

<div class="edit-wrapper">

    <!-- HEADER -->
    <div class="edit-header">
        <a href="<?= base_url('pelanggan/profile') ?>" class="edit-back">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="edit-title">Edit Profile</h1>
    </div>

    <!-- AVATAR -->
    <div class="avatar-section">
        <div class="avatar-wrap">
            <div class="avatar-circle">
                <i class="fa-solid fa-user"></i>
            </div>
            <label for="upload-photo" class="avatar-upload-btn" title="Ubah foto profil">
                <i class="fa-solid fa-camera"></i>
                <input type="file" id="upload-photo" accept="image/*" style="display:none">
            </label>
        </div>
    </div>

    <!-- FORM -->
    <div class="edit-form-card">
        <form action="<?= base_url('pelanggan/update_profile') ?>" method="post">
            <?= csrf_field() ?>

            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" class="form-input"
                       value="<?= esc(session()->get('nama')) ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label">Nomor Telepon</label>
                <input type="text" name="no_hp" class="form-input"
                       value="<?= esc(session()->get('no_hp')) ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label">Provinsi</label>
                <input type="text" name="provinsi" class="form-input"
                       value="<?= esc(session()->get('provinsi')) ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label">
                    Kota/Kabupaten
                    <span class="hint">(penting untuk ongkir)</span>
                </label>
                <select name="kota" class="form-select" required>
                    <option value="">— Pilih Kota —</option>
                    <?php foreach ($wilayah as $w) : ?>
                        <option value="<?= esc($w['nama_kota']) ?>"
                            <?= (session()->get('kota') == $w['nama_kota']) ? 'selected' : '' ?>>
                            <?= esc($w['nama_kota']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- 2 kolom: Kecamatan / Desa -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Kecamatan</label>
                    <input type="text" name="kecamatan" class="form-input"
                           value="<?= esc(session()->get('kecamatan')) ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Desa</label>
                    <input type="text" name="desa" class="form-input"
                           value="<?= esc(session()->get('desa')) ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Detail Alamat (Jalan / No. Rumah)</label>
                <textarea name="alamat_lengkap" class="form-textarea"
                          placeholder="Contoh: Jl. Merdeka No. 12, RT 03/RW 05"
                          required><?= esc(session()->get('alamat_lengkap')) ?></textarea>
            </div>

            <div class="form-divider"></div>

            <button type="submit" class="btn-submit">
                <i class="fa-solid fa-floppy-disk"></i>
                Simpan Perubahan
            </button>
        </form>
    </div>

</div>
<?= $this->endSection() ?>