<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login <?= ucfirst($role) ?> - Sport Center</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* ============================================================
           DESIGN TOKENS — sama dengan layout dashboard
           ============================================================ */
        :root {
            --brand:          #f97316;
            --brand-dark:     #ea6c08;
            --brand-subtle:   rgba(249,115,22,0.15);
            --brand-glow:     rgba(249,115,22,0.20);

            --bg:             #0b1120;
            --surface:        #0f172a;
            --surface-raised: #1e293b;
            --surface-high:   #273549;

            --ink:            #f1f5f9;
            --ink-secondary:  #94a3b8;
            --ink-muted:      #475569;

            --border:         rgba(255,255,255,0.09);
            --border-light:   rgba(255,255,255,0.05);

            --shadow-md:  0 8px 24px rgba(0,0,0,0.45), 0 2px 6px rgba(0,0,0,0.25);
            --shadow-lg:  0 20px 48px rgba(0,0,0,0.55), 0 4px 12px rgba(0,0,0,0.3);

            --radius-md:   14px;
            --radius-lg:   20px;
            --radius-xl:   28px;

            --transition: 0.22s cubic-bezier(0.4, 0, 0.2, 1);

            /* ── Accent per role ──
               Admin tetap dibedakan tapi sekarang versi dark-friendly
               (bukan hitam pekat #2D3436 yang kontras-nya rendah di dark bg) */
            <?php if ($role == 'admin'): ?>
            --accent:        #60a5fa;
            --accent-dark:   #3b82f6;
            --accent-subtle: rgba(96,165,250,0.15);
            --accent-glow:   rgba(96,165,250,0.20);
            <?php else: ?>
            --accent:        var(--brand);
            --accent-dark:   var(--brand-dark);
            --accent-subtle: var(--brand-subtle);
            --accent-glow:   var(--brand-glow);
            <?php endif; ?>
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Outfit', sans-serif;
            /* ✦ UPGRADE: Gradient navy → purple, sama dengan login_choice */
            background: linear-gradient(135deg, #0b1120 0%, #151a35 45%, #1e1b3a 100%);
            color: var(--ink);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        /* Dekorasi blur — accent role tetap dipakai, plus aksen purple
           agar menyatu dengan gradient background */
        body::before {
            content: '';
            position: fixed;
            top: -120px; right: -100px;
            width: 360px; height: 360px;
            border-radius: 50%;
            background: radial-gradient(circle, var(--accent-glow) 0%, transparent 70%);
            pointer-events: none;
        }
        body::after {
            content: '';
            position: fixed;
            bottom: -140px; left: -100px;
            width: 340px; height: 340px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(139,92,246,0.14) 0%, transparent 70%);
            pointer-events: none;
        }

        /* ── CARD ── */
        .login-card {
            width: 100%;
            max-width: 400px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-xl);
            padding: 44px 36px;
            text-align: center;
            box-shadow: var(--shadow-lg);
            position: relative;
            z-index: 1;
        }

        /* ── LOGO ── */
        .login-logo {
            width: 72px; height: 72px;
            background: var(--accent-subtle);
            border: 1px solid var(--accent-glow);
            border-radius: var(--radius-lg);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 22px;
            color: var(--accent);
            font-size: 28px;
        }

        .login-title {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: var(--ink);
            margin-bottom: 8px;
            text-transform: capitalize;
        }
        .login-subtitle {
            font-size: 13.5px;
            color: var(--ink-secondary);
            margin-bottom: 28px;
        }

        /* ── ROLE BADGE ── */
        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--accent-subtle);
            color: var(--accent);
            border: 1px solid var(--accent-glow);
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 20px;
        }

        /* ── FLASH ERROR ── */
        .flash-error {
            background: rgba(239,68,68,0.12);
            color: #f87171;
            border: 1px solid rgba(239,68,68,0.2);
            padding: 12px 16px;
            border-radius: var(--radius-md);
            margin-bottom: 18px;
            font-size: 13px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            text-align: left;
        }

        /* ── FORM ── */
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 16px;
            text-align: left;
        }
        .form-label {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--ink-secondary);
        }
        .form-input {
            width: 100%;
            padding: 14px 16px;
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
        .form-input::placeholder { color: var(--ink-muted); }
        .form-input:focus {
            border-color: var(--accent);
            background: var(--surface);
            box-shadow: 0 0 0 3px var(--accent-glow);
        }

        /* ── SUBMIT ── */
        .btn-submit {
            width: 100%;
            padding: 15px;
            border-radius: var(--radius-md);
            border: none;
            margin-top: 8px;
            cursor: pointer;
            font-weight: 700;
            font-size: 14.5px;
            font-family: 'Outfit', sans-serif;
            background: var(--accent);
            color: <?= $role == 'admin' ? '#0b1120' : '#fff' ?>;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 6px 20px var(--accent-glow);
            transition: background var(--transition), transform var(--transition), box-shadow var(--transition);
        }
        .btn-submit:hover {
            background: var(--accent-dark);
            transform: translateY(-1px);
            box-shadow: 0 8px 24px var(--accent-glow);
        }
        .btn-submit:active { transform: translateY(0); }

        /* ── REGISTER LINK ── */
        .register-link {
            margin-top: 22px;
            font-size: 13px;
            color: var(--ink-muted);
        }
        .register-link a {
            color: var(--accent);
            font-weight: 700;
            text-decoration: none;
            transition: color var(--transition);
        }
        .register-link a:hover { color: var(--accent-dark); }

        /* ── BACK TO CHOICE ── */
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

        @media (max-width: 480px) {
            .login-card { padding: 32px 24px; }
            .login-logo { width: 60px; height: 60px; font-size: 24px; }
            .login-title { font-size: 19px; }
        }
    </style>
</head>
<body>
    <div class="login-card">

        <div class="role-badge">
            <i class="fa-solid fa-<?= $role == 'admin' ? 'user-shield' : 'user' ?>"></i>
            <?= ucfirst($role) ?>
        </div>

        <div class="login-logo">
            <i class="fa-solid fa-lock"></i>
        </div>

        <h1 class="login-title">Login <?= ucfirst($role) ?></h1>
        <p class="login-subtitle">Masukkan Username dan Password Anda</p>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="flash-error">
                <i class="fa-solid fa-circle-exclamation"></i>
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('auth/attemptLogin') ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="role" value="<?= esc($role) ?>">

            <div class="form-group">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-input"
                       placeholder="Masukkan username" required autofocus>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-input"
                       placeholder="Masukkan password" required>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fa-solid fa-right-to-bracket"></i>
                Masuk
            </button>

            <?php if ($role !== 'admin'): ?>
            <p class="register-link">
                Belum punya akun?
                <a href="<?= base_url('auth/register') ?>">Daftar di sini</a>
            </p>
            <?php endif; ?>
        </form>

        <a href="<?= base_url('auth') ?>" class="back-link">
            <i class="fa-solid fa-arrow-left" style="font-size:10px;"></i>
            Kembali ke pilihan login
        </a>

    </div>
</body>
</html>