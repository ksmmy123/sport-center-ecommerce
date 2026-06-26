<?= $this->extend('layout/pelanggan_layout') ?>

<?= $this->section('content') ?>
<style>
    /* ── PAGE WRAPPER ── */
    .security-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: calc(100vh - 80px);
        padding: 20px 0;
    }

    /* ── CARD ── */
    .security-card {
        width: 100%;
        max-width: 440px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-xl);
        padding: 36px 32px;
        box-shadow: var(--shadow-md);
    }

    /* ── HEADER ── */
    .security-header {
        text-align: center;
        margin-bottom: 32px;
    }
    .security-icon {
        width: 64px; height: 64px;
        border-radius: var(--radius-lg);
        background: var(--brand-subtle);
        border: 1px solid rgba(249,115,22,0.2);
        color: var(--brand);
        display: flex; align-items: center; justify-content: center;
        font-size: 26px;
        margin: 0 auto 18px;
        transform: rotate(-5deg);
    }
    .security-title {
        font-size: 20px;
        font-weight: 800;
        letter-spacing: -0.4px;
        color: var(--ink);
        margin: 0;
        text-transform: capitalize;
    }
    .security-desc {
        font-size: 13.5px;
        color: var(--ink-secondary);
        margin-top: 10px;
        line-height: 1.6;
    }

    /* ── FORM ── */
    .security-form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-bottom: 18px;
    }
    .security-label {
        font-size: 12.5px;
        font-weight: 600;
        color: var(--ink-secondary);
        text-transform: capitalize;
    }
    .security-input {
        width: 100%;
        padding: 13px 16px;
        border-radius: var(--radius-md);
        border: 1.5px solid var(--border);
        background: var(--surface-raised);
        color: var(--ink);
        font-family: 'Outfit', sans-serif;
        font-size: 14px;
        outline: none;
        box-sizing: border-box;
        transition: border-color var(--transition), box-shadow var(--transition),
                    background var(--transition);
    }
    .security-input::placeholder { color: var(--ink-muted); }
    .security-input:focus {
        border-color: var(--brand);
        background: var(--surface);
        box-shadow: 0 0 0 3px var(--brand-glow);
    }

    /* ── PASSWORD STRENGTH HINT (opsional, ringan) ── */
    .security-hint {
        font-size: 11.5px;
        color: var(--ink-muted);
        margin-top: 2px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    /* ── SUBMIT ── */
    .security-divider {
        height: 1px;
        background: var(--border);
        margin: 8px 0 22px;
    }
    .btn-security-submit {
        width: 100%;
        background: var(--brand);
        color: #fff;
        padding: 14px;
        border-radius: var(--radius-md);
        border: none;
        font-family: 'Outfit', sans-serif;
        font-weight: 700;
        font-size: 14.5px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-transform: capitalize;
        box-shadow: 0 4px 16px rgba(249,115,22,0.35);
        transition: background var(--transition), transform var(--transition), box-shadow var(--transition);
    }
    .btn-security-submit:hover {
        background: var(--brand-dark);
        transform: translateY(-1px);
        box-shadow: 0 6px 22px rgba(249,115,22,0.45);
    }
    .btn-security-submit:active { transform: translateY(0); }

    /* ── BACK LINK ── */
    .security-back {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: 24px;
        color: var(--ink-muted);
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        text-transform: capitalize;
        transition: color var(--transition);
    }
    .security-back:hover { color: var(--brand); }

    /* ── RESPONSIVE ── */
    @media (max-width: 600px) {
        .security-card { padding: 28px 22px; border-radius: var(--radius-lg); }
        .security-icon { width: 56px; height: 56px; font-size: 22px; }
        .security-title { font-size: 18px; }
    }
</style>

<div class="security-wrapper">
    <div class="security-card">

        <!-- HEADER -->
        <div class="security-header">
            <div class="security-icon">
                <i class="fa-solid fa-fingerprint"></i>
            </div>
            <h1 class="security-title">Keamanan Akun</h1>
            <p class="security-desc">
                Jaga keamanan profil Anda dengan memperbarui kata sandi secara rutin.
            </p>
        </div>

        <!-- FLASH ERROR -->
        <?php if (session()->getFlashdata('error')) : ?>
            <div style="background: rgba(239,68,68,0.12); color: #f87171; border: 1px solid rgba(239,68,68,0.2);
                        padding: 12px 16px; border-radius: var(--radius-md); margin-bottom: 18px;
                        font-size: 13px; font-weight: 500; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-circle-exclamation"></i>
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <!-- FLASH SUCCESS -->
        <?php if (session()->getFlashdata('success')) : ?>
            <div style="background: rgba(34,197,94,0.12); color: #4ade80; border: 1px solid rgba(74,222,128,0.2);
                        padding: 12px 16px; border-radius: var(--radius-md); margin-bottom: 18px;
                        font-size: 13px; font-weight: 500; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-circle-check"></i>
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <!-- FORM -->
        <form action="<?= base_url('pelanggan/update_password') ?>" method="POST">
            <?= csrf_field() ?>

            <div class="security-form-group">
                <label class="security-label">Password Baru</label>
                <input type="password" name="new_password" class="security-input"
                       placeholder="Ketik password baru di sini..." required>
                <span class="security-hint">
                    <i class="fa-solid fa-circle-info"></i>
                    Minimal 6 karakter untuk keamanan optimal
                </span>
            </div>

            <div class="security-form-group">
                <label class="security-label">Ulangi Password</label>
                <input type="password" name="confirm_password" class="security-input"
                       placeholder="Masukkan sekali lagi..." required>
            </div>

            <div class="security-divider"></div>

            <button type="submit" class="btn-security-submit">
                <i class="fa-solid fa-shield-halved"></i>
                Simpan Perubahan
            </button>
        </form>

        <!-- BACK -->
        <a href="<?= base_url('pelanggan/profile') ?>" class="security-back">
            <i class="fa-solid fa-chevron-left" style="font-size:10px;"></i>
            Kembali ke Profil
        </a>

    </div>
</div>
<?= $this->endSection() ?>