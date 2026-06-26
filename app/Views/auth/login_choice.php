<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sport Center - Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* ============================================================
           DESIGN TOKENS — sama persis dengan pelanggan_layout.php
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
            --radius-pill: 999px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Outfit', sans-serif;
            /* ✦ UPGRADE: Gradient navy → purple, masih dark tapi lebih hidup
               dari flat #0b1120. Diagonal 135deg memberi kesan depth. */
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

        /* Dekorasi blur — orange (brand) + purple accent agar menyatu
           dengan gradient background baru */
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
            width: 76px; height: 76px;
            background: linear-gradient(135deg, var(--brand) 0%, #fbbf24 100%);
            border-radius: var(--radius-lg);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 24px;
            color: #fff;
            font-size: 30px;
            box-shadow: 0 8px 24px rgba(249,115,22,0.35);
        }

        .login-brand {
            font-size: 26px;
            font-weight: 800;
            letter-spacing: -1px;
            color: var(--ink);
            margin-bottom: 8px;
        }
        .login-brand span { color: var(--brand); }

        .login-subtitle {
            font-size: 13.5px;
            color: var(--ink-secondary);
            margin-bottom: 36px;
            line-height: 1.6;
        }

        /* ── BUTTONS ── */
        .btn-login {
            width: 100%;
            padding: 16px;
            border-radius: var(--radius-md);
            margin-bottom: 12px;
            cursor: pointer;
            font-weight: 700;
            font-size: 14px;
            border: none;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-family: 'Outfit', sans-serif;
            transition: transform var(--transition), box-shadow var(--transition),
                        background var(--transition), border-color var(--transition);
        }
        .btn-login:last-of-type { margin-bottom: 0; }

        .btn-user {
            background: var(--brand);
            color: #fff;
            box-shadow: 0 6px 20px rgba(249,115,22,0.35);
        }
        .btn-user:hover {
            background: var(--brand-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(249,115,22,0.45);
        }

        .btn-admin {
            background: var(--surface-raised);
            color: var(--ink);
            border: 1.5px solid var(--border);
        }
        .btn-admin:hover {
            background: var(--surface-high);
            border-color: rgba(255,255,255,0.18);
            transform: translateY(-2px);
        }

        /* ── DIVIDER ── */
        .login-divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 24px 0;
        }
        .login-divider::before,
        .login-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }
        .login-divider span {
            font-size: 11px;
            color: var(--ink-muted);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* transition var fallback (jika ada yang lupa define) */
        :root { --transition: 0.22s cubic-bezier(0.4, 0, 0.2, 1); }

        @media (max-width: 480px) {
            .login-card { padding: 32px 24px; }
            .login-logo { width: 64px; height: 64px; font-size: 26px; }
            .login-brand { font-size: 22px; }
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-logo">
            <i class="fa-solid fa-bolt"></i>
        </div>

        <h1 class="login-brand">Sport<span>.</span>Center</h1>
        <p class="login-subtitle">Manajemen toko &amp; belanja dalam satu aplikasi</p>

        <a href="<?= base_url('auth/inputPassword/pelanggan') ?>" class="btn-login btn-user">
            <i class="fa-solid fa-bag-shopping"></i>
            Masuk sebagai Pelanggan
        </a>

        <div class="login-divider"><span>atau</span></div>

        <a href="<?= base_url('auth/inputPassword/admin') ?>" class="btn-login btn-admin">
            <i class="fa-solid fa-user-shield"></i>
            Masuk Dashboard Admin
        </a>
    </div>
</body>
</html>