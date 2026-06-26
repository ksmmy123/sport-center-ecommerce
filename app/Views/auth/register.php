<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Baru - Sport Center</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* ============================================================
           DESIGN TOKENS — sama dengan login_choice & login_password
           ============================================================ */
        :root {
            --brand:          #f97316;
            --brand-dark:     #ea6c08;
            --brand-subtle:   rgba(249,115,22,0.15);
            --brand-glow:     rgba(249,115,22,0.20);

            --surface:        #0f172a;
            --surface-raised: #1e293b;
            --surface-high:   #273549;

            --ink:            #f1f5f9;
            --ink-secondary:  #94a3b8;
            --ink-muted:      #475569;

            --border:         rgba(255,255,255,0.09);
            --border-light:   rgba(255,255,255,0.05);

            --shadow-lg:  0 20px 48px rgba(0,0,0,0.55), 0 4px 12px rgba(0,0,0,0.3);

            --radius-md:   14px;
            --radius-lg:   20px;
            --radius-xl:   28px;

            --transition: 0.22s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Outfit', sans-serif;
            /* ✦ Gradient navy → purple, sama dengan halaman login */
            background: linear-gradient(135deg, #0b1120 0%, #151a35 45%, #1e1b3a 100%);
            color: var(--ink);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 40px 20px;
            position: relative;
            overflow-x: hidden;
        }

        /* Dekorasi blur — orange + purple */
        body::before {
            content: '';
            position: fixed;
            top: -120px; right: -100px;
            width: 360px; height: 360px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(249,115,22,0.18) 0%, transparent 70%);
            pointer-events: none;
        }
        body::after {
            content: '';
            position: fixed;
            bottom: -140px; left: -100px;
            width: 340px; height: 340px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(139,92,246,0.16) 0%, transparent 70%);
            pointer-events: none;
        }

        /* ── CONTAINER ── */
        .register-container {
            max-width: 640px;
            width: 100%;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-xl);
            padding: 40px;
            box-shadow: var(--shadow-lg);
            position: relative;
            z-index: 1;
        }

        /* ── HEADER ── */
        .header { text-align: center; margin-bottom: 32px; }
        .logo-badge {
            width: 64px; height: 64px;
            background: linear-gradient(135deg, var(--brand) 0%, #fbbf24 100%);
            border-radius: var(--radius-lg);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 16px;
            color: #fff;
            font-size: 26px;
            box-shadow: 0 8px 24px rgba(249,115,22,0.35);
        }
        .header h1 {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -0.6px;
            color: var(--ink);
            margin-bottom: 6px;
        }
        .header h1 span { color: var(--brand); }
        .header p {
            color: var(--ink-secondary);
            font-size: 13.5px;
        }

        /* ── FLASH ERROR ── */
        .flash-error {
            background: rgba(239,68,68,0.12);
            color: #f87171;
            border: 1px solid rgba(239,68,68,0.2);
            padding: 12px 16px;
            border-radius: var(--radius-md);
            margin-bottom: 22px;
            font-size: 13px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* ── SECTION LABEL ── */
        .form-section-label {
            font-size: 11px;
            font-weight: 700;
            color: var(--ink-muted);
            text-transform: uppercase;
            letter-spacing: 1.2px;
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .form-section-label:not(:first-child) {
            margin-top: 28px;
            padding-top: 22px;
            border-top: 1px solid var(--border);
        }
        .form-section-label i { color: var(--brand); font-size: 12px; }

        /* ── GRID FORM ── */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }
        .full-width { grid-column: span 2; }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .form-group label {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--ink-secondary);
            text-transform: capitalize;
        }

        input, select, textarea {
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
        input::placeholder, textarea::placeholder { color: var(--ink-muted); }

        input:focus, select:focus, textarea:focus {
            border-color: var(--brand);
            background: var(--surface);
            box-shadow: 0 0 0 3px var(--brand-glow);
        }

        textarea {
            height: 92px;
            resize: vertical;
            line-height: 1.6;
            font-family: 'Outfit', sans-serif;
        }

        /* Select arrow custom (konsisten dengan halaman lain) */
        select {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 38px;
        }

        /* ── PASSWORD TOGGLE ── */
        .password-wrap { position: relative; width: 100%; }
        .password-wrap input { padding-right: 46px; }
        .toggle-password {
            position: absolute;
            right: 14px; top: 50%;
            transform: translateY(-50%);
            color: var(--ink-muted);
            cursor: pointer;
            padding: 6px;
            font-size: 14px;
            transition: color var(--transition);
            z-index: 2;
        }
        .toggle-password:hover { color: var(--ink-secondary); }
        .toggle-password.active { color: var(--brand); }

        /* ── SUBMIT BUTTON ── */
        button[type="submit"] {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: var(--brand);
            color: #fff;
            padding: 15px;
            border-radius: var(--radius-md);
            border: none;
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 15px;
            cursor: pointer;
            margin-top: 28px;
            box-shadow: 0 6px 20px rgba(249,115,22,0.35);
            transition: background var(--transition), transform var(--transition), box-shadow var(--transition);
        }
        button[type="submit"]:hover {
            background: var(--brand-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(249,115,22,0.45);
        }
        button[type="submit"]:active { transform: translateY(0); }

        /* ── LOGIN LINK ── */
        .login-link {
            text-align: center;
            margin-top: 22px;
            font-size: 13.5px;
            color: var(--ink-muted);
        }
        .login-link a {
            color: var(--brand);
            text-decoration: none;
            font-weight: 700;
            transition: color var(--transition);
        }
        .login-link a:hover { color: var(--brand-dark); }

        /* ── BACK LINK ── */
        .back-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 18px;
            color: var(--ink-muted);
            text-decoration: none;
            font-size: 12.5px;
            font-weight: 600;
            transition: color var(--transition);
        }
        .back-link:hover { color: var(--ink-secondary); }

        /* ── RESPONSIVE ── */
        @media (max-width: 600px) {
            .register-container { padding: 28px 22px; border-radius: var(--radius-lg); }
            .form-grid { grid-template-columns: 1fr; gap: 16px; }
            .full-width { grid-column: span 1; }
            .header h1 { font-size: 19px; }
            .logo-badge { width: 56px; height: 56px; font-size: 22px; }
        }
    </style>
</head>
<body>

<div class="register-container">

    <!-- HEADER -->
    <div class="header">
        <div class="logo-badge">
            <i class="fa-solid fa-bolt"></i>
        </div>
        <h1>Sport<span>.</span>Center</h1>
        <p>Buat akun baru kamu untuk mulai berbelanja</p>
    </div>

    <!-- FLASH ERROR -->
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="flash-error">
            <i class="fa-solid fa-circle-exclamation"></i>
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('auth/proses_register') ?>" method="POST">
        <?= csrf_field() ?>

        <!-- SECTION: Akun -->
        <div class="form-section-label">
            <i class="fa-solid fa-user"></i>
            Informasi Akun
        </div>
        <div class="form-grid">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" placeholder="Nama lengkap kamu..."
                       required value="<?= old('nama') ?>">
            </div>

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Username akun..."
                       required value="<?= old('username') ?>">
            </div>

            <div class="form-group">
                <label>Password</label>
                <div class="password-wrap">
                    <input type="password" id="password" name="password"
                           placeholder="Minimal 8 karakter..." required>
                    <i class="fa-solid fa-eye toggle-password" id="togglePassword"></i>
                </div>
            </div>

            <div class="form-group">
                <label>Nomor HP</label>
                <input type="text" name="no_hp" placeholder="Contoh: 0812345xxx"
                       value="<?= old('no_hp') ?>">
            </div>
        </div>

        <!-- SECTION: Alamat -->
        <div class="form-section-label">
            <i class="fa-solid fa-location-dot"></i>
            Alamat Pengiriman
        </div>
        <div class="form-grid">
            <div class="form-group">
                <label>Provinsi</label>
                <input type="text" name="provinsi" placeholder="Provinsi tempat tinggal..."
                       value="<?= old('provinsi') ?>">
            </div>

            <div class="form-group">
                <label>Kota / Kabupaten</label>
                <input type="text" name="kota" placeholder="Kota atau kabupaten..."
                       value="<?= old('kota') ?>">
            </div>

            <div class="form-group">
                <label>Kecamatan</label>
                <input type="text" name="kecamatan" placeholder="Kecamatan..."
                       value="<?= old('kecamatan') ?>">
            </div>

            <div class="form-group">
                <label>Desa / Kelurahan</label>
                <input type="text" name="desa" placeholder="Desa atau kelurahan..."
                       value="<?= old('desa') ?>">
            </div>

            <div class="form-group full-width">
                <label>Alamat Lengkap</label>
                <textarea name="alamat_lengkap"
                          placeholder="Tulis jalan, blok, RT/RW, dan nomor rumah secara detail..."><?= old('alamat_lengkap') ?></textarea>
            </div>
        </div>

        <button type="submit">
            <i class="fa-solid fa-user-plus"></i>
            Daftar Sekarang
        </button>
    </form>

    <div class="login-link">
        Sudah punya akun?
        <a href="<?= base_url('auth/inputPassword/pelanggan') ?>">Login di sini</a>
    </div>

    <a href="<?= base_url('auth') ?>" class="back-link">
        <i class="fa-solid fa-arrow-left" style="font-size:10px;"></i>
        Kembali ke pilihan login
    </a>
</div>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput  = document.getElementById('password');

    togglePassword.addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
        this.classList.toggle('active', type === 'text');
    });
</script>

</body>
</html>