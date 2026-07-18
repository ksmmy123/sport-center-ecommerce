<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sport Center — Perlengkapan Olahraga Pilihanmu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* ============================================================
           DESIGN TOKENS — disamakan dengan pelanggan_layout.php / auth
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

            --shadow-sm:  0 2px 8px rgba(0,0,0,0.35), 0 1px 2px rgba(0,0,0,0.2);
            --shadow-md:  0 8px 24px rgba(0,0,0,0.45), 0 2px 6px rgba(0,0,0,0.25);
            --shadow-lg:  0 20px 48px rgba(0,0,0,0.55), 0 4px 12px rgba(0,0,0,0.3);

            --radius-sm:   8px;
            --radius-md:   14px;
            --radius-lg:   20px;
            --radius-xl:   28px;
            --radius-pill: 999px;
            --transition: 0.22s cubic-bezier(0.4, 0, 0.2, 1);

            --navbar-h: 72px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Outfit', sans-serif;
            background: var(--bg);
            color: var(--ink);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }
        img { display: block; max-width: 100%; }
        a { color: inherit; }
        section[id] { scroll-margin-top: var(--navbar-h); }

        /* ============================================================
           NAVBAR
           ============================================================ */
        .navbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 200;
            height: var(--navbar-h);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 6vw;
            background: rgba(11,17,32,0.7);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-bottom: 1px solid transparent;
            transition: background var(--transition), border-color var(--transition), box-shadow var(--transition);
        }
        .navbar.scrolled {
            background: rgba(11,17,32,0.95);
            border-bottom: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
        }

        .nav-logo { display: flex; align-items: center; gap: 10px; text-decoration: none; flex-shrink: 0; }
        .nav-logo-badge {
            width: 36px; height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, #f97316, #fbbf24);
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: 16px; color: #fff;
            box-shadow: 0 4px 12px rgba(249,115,22,0.4);
            flex-shrink: 0;
        }
        .nav-logo-text { font-size: 21px; font-weight: 800; letter-spacing: -0.9px; color: var(--ink); }
        .nav-logo-text span { color: var(--brand); }

        /* Center links (desktop) */
        .nav-links {
            display: flex;
            align-items: center;
            gap: 4px;
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--border);
            padding: 6px;
            border-radius: var(--radius-pill);
        }
        .nav-links a {
            position: relative;
            padding: 8px 16px;
            border-radius: var(--radius-pill);
            font-size: 13.5px;
            font-weight: 600;
            text-decoration: none;
            color: var(--ink-secondary);
            transition: background var(--transition), color var(--transition);
            white-space: nowrap;
        }
        .nav-links a:hover { color: var(--ink); background: rgba(255,255,255,0.06); }
        .nav-links a.active { color: #fff; background: var(--brand); box-shadow: 0 4px 14px rgba(249,115,22,0.35); }

        .nav-actions { display: flex; align-items: center; gap: 10px; flex-shrink: 0; }
        .nav-btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 10px 18px;
            border-radius: var(--radius-pill);
            font-size: 13.5px; font-weight: 700;
            text-decoration: none;
            transition: background var(--transition), transform var(--transition), box-shadow var(--transition), color var(--transition);
            white-space: nowrap;
            border: none;
            cursor: pointer;
            font-family: 'Outfit', sans-serif;
        }
        .nav-btn-ghost { background: transparent; color: var(--ink-secondary); border: 1.5px solid var(--border); }
        .nav-btn-ghost:hover { color: var(--ink); border-color: rgba(255,255,255,0.25); }
        .nav-btn-brand { background: var(--brand); color: #fff; box-shadow: 0 4px 14px rgba(249,115,22,0.35); }
        .nav-btn-brand:hover { background: var(--brand-dark); transform: translateY(-1px); box-shadow: 0 6px 18px rgba(249,115,22,0.45); }

        .nav-cart-pill {
            position: relative;
            width: 40px; height: 40px;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
            border: 1.5px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            color: var(--ink-secondary);
            text-decoration: none;
            transition: background var(--transition), color var(--transition), border-color var(--transition);
        }
        .nav-cart-pill:hover { color: var(--brand); border-color: rgba(249,115,22,0.35); background: var(--brand-subtle); }

        .nav-toggle {
            display: none;
            width: 40px; height: 40px;
            border-radius: var(--radius-sm);
            background: rgba(255,255,255,0.06);
            border: none;
            cursor: pointer;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 5px;
            flex-shrink: 0;
        }
        .nav-toggle span {
            display: block; width: 19px; height: 2px;
            background: #e2e8f0; border-radius: var(--radius-pill);
            transition: transform 0.3s, opacity 0.3s;
        }
        .nav-toggle.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
        .nav-toggle.open span:nth-child(2) { opacity: 0; }
        .nav-toggle.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

        /* Mobile dropdown panel */
        .nav-mobile-panel {
            position: fixed;
            top: var(--navbar-h); left: 0; right: 0;
            background: rgba(11,17,32,0.98);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border);
            padding: 10px 20px 20px;
            z-index: 190;
            display: flex;
            flex-direction: column;
            gap: 4px;
            transform: translateY(-12px);
            opacity: 0;
            pointer-events: none;
            transition: transform var(--transition), opacity var(--transition);
        }
        .nav-mobile-panel.open { transform: translateY(0); opacity: 1; pointer-events: auto; }
        .nav-mobile-panel a {
            padding: 13px 12px;
            border-radius: var(--radius-md);
            text-decoration: none;
            color: var(--ink-secondary);
            font-weight: 600;
            font-size: 14.5px;
            display: flex; align-items: center; gap: 10px;
            transition: background var(--transition), color var(--transition);
        }
        .nav-mobile-panel a:hover, .nav-mobile-panel a.active { background: rgba(249,115,22,0.12); color: var(--brand); }
        .nav-mobile-panel .mp-divider { height: 1px; background: var(--border); margin: 8px 4px; }
        .nav-mobile-panel .mp-actions { display: flex; gap: 10px; margin-top: 6px; }
        .nav-mobile-panel .mp-actions a { flex: 1; justify-content: center; }

        /* ============================================================
           HERO
           ============================================================ */
        .lp-hero {
            position: relative;
            overflow: hidden;
            padding: calc(var(--navbar-h) + 70px) 6vw 100px;
            text-align: center;
        }
        .lp-hero::before {
            content: '';
            position: absolute; top: -140px; right: -120px;
            width: 420px; height: 420px; border-radius: 50%;
            background: radial-gradient(circle, rgba(249,115,22,0.18) 0%, transparent 70%);
            pointer-events: none;
        }
        .lp-hero::after {
            content: '';
            position: absolute; bottom: -160px; left: -120px;
            width: 380px; height: 380px; border-radius: 50%;
            background: radial-gradient(circle, rgba(139,92,246,0.14) 0%, transparent 70%);
            pointer-events: none;
        }
        .lp-hero-inner { position: relative; z-index: 1; max-width: 720px; margin: 0 auto; }
        .lp-eyebrow {
            display: inline-flex; align-items: center; gap: 8px;
            background: var(--brand-subtle);
            border: 1px solid rgba(249,115,22,0.25);
            color: var(--brand);
            padding: 6px 16px;
            border-radius: var(--radius-pill);
            font-size: 12px; font-weight: 700; letter-spacing: 0.5px;
            margin-bottom: 24px;
        }
        .lp-hero h1 {
            font-size: 46px; font-weight: 800; letter-spacing: -1.4px;
            line-height: 1.15; margin-bottom: 20px; color: var(--ink);
        }
        .lp-hero h1 span { color: var(--brand); }
        .lp-hero p {
            font-size: 16px; color: var(--ink-secondary);
            max-width: 520px; margin: 0 auto 36px;
        }
        .lp-hero-actions { display: flex; align-items: center; justify-content: center; gap: 14px; flex-wrap: wrap; }
        .lp-btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 10px 18px;
            border-radius: var(--radius-pill);
            font-size: 13.5px; font-weight: 700;
            text-decoration: none;
            transition: background var(--transition), transform var(--transition), box-shadow var(--transition), color var(--transition);
            white-space: nowrap;
        }
        .lp-btn-ghost { background: transparent; color: var(--ink-secondary); border: 1.5px solid var(--border); }
        .lp-btn-ghost:hover { color: var(--ink); border-color: rgba(255,255,255,0.2); }
        .lp-btn-brand { background: var(--brand); color: #fff; box-shadow: 0 4px 14px rgba(249,115,22,0.35); }
        .lp-btn-brand:hover { background: var(--brand-dark); transform: translateY(-1px); box-shadow: 0 6px 18px rgba(249,115,22,0.45); }
        .lp-btn-lg { padding: 15px 30px; font-size: 15px; }

        /* Trust strip under hero */
        .lp-trust-strip {
            position: relative; z-index: 1;
            display: flex; flex-wrap: wrap; justify-content: center; gap: 34px;
            margin-top: 54px;
            padding-top: 34px;
            border-top: 1px solid var(--border);
            max-width: 820px; margin-left: auto; margin-right: auto;
        }
        .lp-trust-item { display: flex; align-items: center; gap: 10px; color: var(--ink-secondary); font-size: 13px; font-weight: 600; }
        .lp-trust-item i { color: var(--brand); font-size: 16px; }

        /* ============================================================
           STATS
           ============================================================ */
        .lp-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            padding: 0 6vw;
            max-width: 1180px;
            margin: 0 auto 10px;
        }
        .lp-stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 26px 22px;
            text-align: center;
            transition: transform var(--transition), border-color var(--transition);
        }
        .lp-stat-card:hover { transform: translateY(-3px); border-color: rgba(255,255,255,0.15); }
        .lp-stat-num { font-size: 30px; font-weight: 800; letter-spacing: -1px; color: var(--brand); }
        .lp-stat-label { font-size: 12px; color: var(--ink-secondary); margin-top: 6px; font-weight: 600; }

        /* ============================================================
           SECTION WRAPPER
           ============================================================ */
        .lp-section { padding: 70px 6vw; max-width: 1180px; margin: 0 auto; }
        .lp-section-head { text-align: center; max-width: 560px; margin: 0 auto 44px; }
        .lp-section-tag {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase;
            color: var(--brand); margin-bottom: 12px;
        }
        .lp-section-head h2 { font-size: 28px; font-weight: 800; letter-spacing: -0.6px; margin-bottom: 12px; }
        .lp-section-head p { color: var(--ink-secondary); font-size: 14.5px; }

        /* ── KATEGORI ── */
        .lp-kategori-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
        .lp-kategori-card {
            display: flex; align-items: center; gap: 18px;
            background: var(--surface); border: 1px solid var(--border);
            border-radius: var(--radius-lg); padding: 28px;
            text-decoration: none;
            transition: transform var(--transition), border-color var(--transition), box-shadow var(--transition);
        }
        .lp-kategori-card:hover { transform: translateY(-4px); border-color: rgba(255,255,255,0.15); box-shadow: var(--shadow-md); }
        .lp-kategori-icon {
            width: 56px; height: 56px; flex-shrink: 0;
            border-radius: var(--radius-md);
            background: var(--brand-subtle); color: var(--brand);
            display: flex; align-items: center; justify-content: center; font-size: 22px;
        }
        .lp-kategori-card h3 { font-size: 16.5px; font-weight: 700; color: var(--ink); margin-bottom: 4px; }
        .lp-kategori-card p { font-size: 12.5px; color: var(--ink-secondary); }
        .lp-kategori-arrow { margin-left: auto; color: var(--ink-muted); transition: transform var(--transition), color var(--transition); }
        .lp-kategori-card:hover .lp-kategori-arrow { transform: translateX(4px); color: var(--brand); }

        /* ── KENAPA KAMI ── */
        .lp-fitur-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .lp-fitur-card {
            background: var(--surface); border: 1px solid var(--border);
            border-radius: var(--radius-lg); padding: 30px 24px; text-align: center;
            transition: transform var(--transition), border-color var(--transition);
        }
        .lp-fitur-card:hover { transform: translateY(-3px); border-color: rgba(255,255,255,0.15); }
        .lp-fitur-icon {
            width: 54px; height: 54px; margin: 0 auto 18px; border-radius: 50%;
            background: var(--brand-subtle); color: var(--brand);
            display: flex; align-items: center; justify-content: center; font-size: 21px;
        }
        .lp-fitur-card h3 { font-size: 15.5px; font-weight: 700; margin-bottom: 8px; color: var(--ink); }
        .lp-fitur-card p { font-size: 13px; color: var(--ink-secondary); line-height: 1.7; }

        /* ── PRODUK PREVIEW ── */
        .lp-produk-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; }
        .lp-produk-card {
            background: var(--surface); border: 1px solid var(--border);
            border-radius: var(--radius-lg); overflow: hidden; text-decoration: none;
            transition: transform var(--transition), border-color var(--transition), box-shadow var(--transition);
        }
        .lp-produk-card:hover { transform: translateY(-4px); border-color: rgba(255,255,255,0.15); box-shadow: var(--shadow-md); }
        .lp-produk-img { aspect-ratio: 1/1; background: var(--surface-raised); overflow: hidden; }
        .lp-produk-img img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease; }
        .lp-produk-card:hover .lp-produk-img img { transform: scale(1.05); }
        .lp-produk-body { padding: 14px 16px 16px; }
        .lp-produk-name {
            font-size: 13.5px; font-weight: 700; color: var(--ink); margin-bottom: 6px;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
        }
        .lp-produk-price { font-size: 15px; font-weight: 800; color: var(--brand); }
        .lp-produk-empty {
            grid-column: 1 / -1; text-align: center; padding: 50px 20px;
            color: var(--ink-secondary); background: var(--surface);
            border: 1px dashed var(--border); border-radius: var(--radius-lg);
        }
        .lp-produk-empty i { font-size: 34px; color: var(--ink-muted); display: block; margin-bottom: 12px; }

        /* ── TESTIMONI ── */
        .lp-testi-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .lp-testi-card {
            background: var(--surface); border: 1px solid var(--border);
            border-radius: var(--radius-lg); padding: 26px; display: flex; flex-direction: column; gap: 16px;
            transition: transform var(--transition), border-color var(--transition);
        }
        .lp-testi-card:hover { transform: translateY(-3px); border-color: rgba(255,255,255,0.15); }
        .lp-testi-stars { color: #facc15; font-size: 13px; letter-spacing: 2px; }
        .lp-testi-text { font-size: 13.5px; color: var(--ink-secondary); line-height: 1.7; font-style: italic; }
        .lp-testi-user { display: flex; align-items: center; gap: 12px; margin-top: auto; }
        .lp-testi-avatar {
            width: 40px; height: 40px; border-radius: 50%;
            background: var(--brand-subtle); color: var(--brand);
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: 15px; flex-shrink: 0;
        }
        .lp-testi-name { font-size: 13px; font-weight: 700; color: var(--ink); }
        .lp-testi-role { font-size: 11px; color: var(--ink-muted); }

        /* ── FAQ ── */
        .lp-faq-list { max-width: 760px; margin: 0 auto; display: flex; flex-direction: column; gap: 10px; }
        .lp-faq-item {
            background: var(--surface); border: 1px solid var(--border);
            border-radius: var(--radius-md); overflow: hidden;
        }
        .lp-faq-q {
            display: flex; align-items: center; justify-content: space-between; gap: 12px;
            padding: 18px 20px; cursor: pointer; user-select: none;
            font-size: 14px; font-weight: 700; color: var(--ink);
        }
        .lp-faq-q i { color: var(--brand); transition: transform var(--transition); flex-shrink: 0; }
        .lp-faq-item.open .lp-faq-q i { transform: rotate(45deg); }
        .lp-faq-a {
            max-height: 0; overflow: hidden;
            transition: max-height var(--transition), padding var(--transition);
            padding: 0 20px;
            font-size: 13.5px; color: var(--ink-secondary); line-height: 1.7;
        }
        .lp-faq-item.open .lp-faq-a { max-height: 220px; padding: 0 20px 20px; }

        /* ── NEWSLETTER / KONTAK ── */
        .lp-contact-grid {
            display: grid; grid-template-columns: 1fr 1fr; gap: 24px;
            background: var(--surface); border: 1px solid var(--border);
            border-radius: var(--radius-xl); padding: 40px; align-items: center;
        }
        .lp-contact-info h2 { font-size: 24px; font-weight: 800; letter-spacing: -0.5px; margin-bottom: 10px; }
        .lp-contact-info p { font-size: 13.5px; color: var(--ink-secondary); margin-bottom: 20px; line-height: 1.7; }
        .lp-contact-list { display: flex; flex-direction: column; gap: 12px; }
        .lp-contact-list-item { display: flex; align-items: center; gap: 12px; font-size: 13px; color: var(--ink-secondary); }
        .lp-contact-list-item i {
            width: 34px; height: 34px; border-radius: var(--radius-sm);
            background: var(--brand-subtle); color: var(--brand);
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .lp-newsletter-form { display: flex; flex-direction: column; gap: 12px; }
        .lp-newsletter-form input,
        .lp-newsletter-form textarea {
            width: 100%; padding: 13px 16px;
            border-radius: var(--radius-md); border: 1.5px solid var(--border);
            background: var(--surface-raised); color: var(--ink);
            font-family: 'Outfit', sans-serif; font-size: 13.5px; outline: none;
            transition: border-color var(--transition), box-shadow var(--transition);
        }
        .lp-newsletter-form textarea { resize: vertical; min-height: 90px; }
        .lp-newsletter-form input:focus,
        .lp-newsletter-form textarea:focus { border-color: var(--brand); box-shadow: 0 0 0 3px var(--brand-glow); }
        .lp-newsletter-form button {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            background: var(--brand); color: #fff; border: none;
            padding: 13px; border-radius: var(--radius-md);
            font-family: 'Outfit', sans-serif; font-size: 14px; font-weight: 700;
            cursor: pointer; transition: background var(--transition), transform var(--transition);
            box-shadow: 0 4px 16px rgba(249,115,22,0.35);
        }
        .lp-newsletter-form button:hover { background: var(--brand-dark); transform: translateY(-1px); }

        /* ── CTA BAWAH ── */
        .lp-cta {
            background: linear-gradient(135deg, #ea580c 0%, #c2410c 45%, #991b1b 100%);
            border-radius: var(--radius-xl);
            margin: 0 6vw 80px;
            padding: 56px 6vw;
            text-align: center;
            box-shadow: 0 12px 40px rgba(249,115,22,0.22);
            position: relative;
            overflow: hidden;
        }
        .lp-cta::before {
            content: ''; position: absolute; top: -60px; right: -40px;
            width: 220px; height: 220px; border-radius: 50%;
            background: rgba(255,255,255,0.08); pointer-events: none;
        }
        .lp-cta h2 { font-size: 26px; font-weight: 800; letter-spacing: -0.6px; margin-bottom: 12px; position: relative; }
        .lp-cta p { color: rgba(255,255,255,0.85); font-size: 14.5px; margin-bottom: 28px; position: relative; }
        .lp-cta .lp-btn-brand { background: #fff; color: var(--brand-dark); position: relative; }
        .lp-cta .lp-btn-brand:hover { background: #f1f5f9; }

        /* ── FOOTER ── */
        .lp-footer-main {
            border-top: 1px solid var(--border);
            padding: 56px 6vw 32px;
            display: grid;
            grid-template-columns: 1.4fr 1fr 1fr 1fr;
            gap: 36px;
        }
        .lp-footer-brand .nav-logo { margin-bottom: 14px; }
        .lp-footer-brand p { font-size: 13px; color: var(--ink-secondary); line-height: 1.7; max-width: 260px; margin-bottom: 18px; }
        .lp-footer-social { display: flex; gap: 10px; }
        .lp-footer-social a {
            width: 34px; height: 34px; border-radius: 50%;
            background: var(--surface); border: 1px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            color: var(--ink-secondary); text-decoration: none; font-size: 13px;
            transition: background var(--transition), color var(--transition), border-color var(--transition);
        }
        .lp-footer-social a:hover { background: var(--brand); color: #fff; border-color: var(--brand); }
        .lp-footer-col h4 { font-size: 13px; font-weight: 700; color: var(--ink); margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.6px; }
        .lp-footer-col ul { list-style: none; display: flex; flex-direction: column; gap: 11px; }
        .lp-footer-col a { font-size: 13px; color: var(--ink-secondary); text-decoration: none; transition: color var(--transition); }
        .lp-footer-col a:hover { color: var(--brand); }

        .lp-footer-bottom {
            border-top: 1px solid var(--border);
            padding: 22px 6vw;
            display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;
            color: var(--ink-muted); font-size: 12.5px;
        }
        .lp-footer-bottom-links { display: flex; gap: 20px; }
        .lp-footer-bottom-links a { color: var(--ink-muted); text-decoration: none; }
        .lp-footer-bottom-links a:hover { color: var(--ink-secondary); }

        /* Back to top */
        .back-to-top {
            position: fixed; bottom: 26px; right: 26px; z-index: 150;
            width: 46px; height: 46px; border-radius: 50%;
            background: var(--brand); color: #fff; border: none;
            display: flex; align-items: center; justify-content: center;
            font-size: 15px; cursor: pointer;
            box-shadow: 0 6px 20px rgba(249,115,22,0.4);
            opacity: 0; pointer-events: none; transform: translateY(10px);
            transition: opacity var(--transition), transform var(--transition), background var(--transition);
        }
        .back-to-top.show { opacity: 1; pointer-events: auto; transform: translateY(0); }
        .back-to-top:hover { background: var(--brand-dark); }

        /* ── RESPONSIVE ── */
        @media (max-width: 980px) {
            .nav-links { display: none; }
            .nav-toggle { display: flex; }
            .lp-stats { grid-template-columns: repeat(2, 1fr); }
            .lp-contact-grid { grid-template-columns: 1fr; }
            .lp-footer-main { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 900px) {
            .lp-fitur-grid { grid-template-columns: 1fr; }
            .lp-produk-grid { grid-template-columns: repeat(2, 1fr); }
            .lp-testi-grid { grid-template-columns: 1fr; }
        }
        @media (max-width: 640px) {
            .navbar { padding: 0 20px; }
            .nav-actions .nav-btn-ghost { display: none; }
            .lp-hero { padding: calc(var(--navbar-h) + 40px) 20px 70px; }
            .lp-hero h1 { font-size: 32px; }
            .lp-hero p { font-size: 14px; }
            .lp-trust-strip { gap: 18px 26px; }
            .lp-section { padding: 50px 20px; }
            .lp-kategori-grid { grid-template-columns: 1fr; }
            .lp-cta { margin: 0 20px 60px; padding: 40px 24px; }
            .lp-footer-main { grid-template-columns: 1fr; padding: 46px 20px 26px; gap: 30px; }
            .lp-footer-bottom { padding: 20px; flex-direction: column; text-align: center; }
            .lp-contact-grid { padding: 26px; }
        }
    </style>
</head>
<body>

    <!-- ============================================================
         NAVBAR
         ============================================================ -->
    <header class="navbar" id="navbar">
        <a href="<?= base_url('/') ?>" class="nav-logo">
            <div class="nav-logo-badge">S</div>
            <span class="nav-logo-text">SPORT<span>.</span></span>
        </a>

        <nav class="nav-links" id="navLinks">
            <a href="#home" class="nav-scroll active">Beranda</a>
            <a href="#kategori" class="nav-scroll">Kategori</a>
            <a href="#produk" class="nav-scroll">Produk</a>
            <a href="#kenapa" class="nav-scroll">Keunggulan</a>
            <a href="#testimoni" class="nav-scroll">Testimoni</a>
            <a href="#faq" class="nav-scroll">FAQ</a>
            <a href="#kontak" class="nav-scroll">Kontak</a>
        </nav>

        <div class="nav-actions">
            <a href="<?= base_url('pelanggan/keranjang') ?>" class="nav-cart-pill" title="Keranjang">
                <i class="fa-solid fa-bag-shopping"></i>
            </a>
            <a href="<?= base_url('auth') ?>" class="nav-btn nav-btn-ghost">
                <i class="fa-solid fa-right-to-bracket"></i> Masuk
            </a>
            <a href="<?= base_url('pelanggan/dashboard') ?>" class="nav-btn nav-btn-brand">
                <i class="fa-solid fa-bolt"></i> Belanja
            </a>
            <button class="nav-toggle" id="navToggle" aria-label="Toggle menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </header>

    <!-- Mobile nav panel -->
    <div class="nav-mobile-panel" id="navMobilePanel">
        <a href="#home" class="nav-scroll">Beranda</a>
        <a href="#kategori" class="nav-scroll">Kategori</a>
        <a href="#produk" class="nav-scroll">Produk</a>
        <a href="#kenapa" class="nav-scroll">Keunggulan</a>
        <a href="#testimoni" class="nav-scroll">Testimoni</a>
        <a href="#faq" class="nav-scroll">FAQ</a>
        <a href="#kontak" class="nav-scroll">Kontak</a>
        <div class="mp-divider"></div>
        <div class="mp-actions">
            <a href="<?= base_url('auth') ?>" class="nav-btn nav-btn-ghost">
                <i class="fa-solid fa-right-to-bracket"></i> Masuk
            </a>
            <a href="<?= base_url('pelanggan/dashboard') ?>" class="nav-btn nav-btn-brand">
                <i class="fa-solid fa-bolt"></i> Belanja
            </a>
        </div>
    </div>

    <!-- ============================================================
         HERO
         ============================================================ -->
    <section class="lp-hero" id="home">
        <div class="lp-hero-inner">
            <div class="lp-eyebrow">
                <i class="fa-solid fa-bolt"></i>
                Sport Center Pemalang
            </div>
            <h1>Perlengkapan Olahraga <span>Pilihanmu</span>, Kualitas Terjamin</h1>
            <p>
                Belanja celana sport pendek &amp; training panjang dengan bahan premium,
                harga bersahabat, dan pengiriman ke seluruh Indonesia.
            </p>
            <div class="lp-hero-actions">
                <a href="<?= base_url('pelanggan/dashboard') ?>" class="lp-btn lp-btn-brand lp-btn-lg">
                    <i class="fa-solid fa-bag-shopping"></i>
                    Belanja Sekarang
                </a>
                <a href="<?= base_url('auth/register') ?>" class="lp-btn lp-btn-ghost lp-btn-lg">
                    <i class="fa-solid fa-user-plus"></i>
                    Daftar Akun Baru
                </a>
            </div>

            <div class="lp-trust-strip">
                <div class="lp-trust-item"><i class="fa-solid fa-truck-fast"></i> Kirim ke seluruh Indonesia</div>
                <div class="lp-trust-item"><i class="fa-solid fa-shield-halved"></i> Pembayaran aman</div>
                <div class="lp-trust-item"><i class="fa-solid fa-rotate-left"></i> Bisa COD</div>
                <div class="lp-trust-item"><i class="fa-solid fa-star"></i> Rating pelanggan tinggi</div>
            </div>
        </div>
    </section>

    <!-- ============================================================
         STATS
         ============================================================ -->
    <div class="lp-stats">
        <div class="lp-stat-card">
            <div class="lp-stat-num" data-count="<?= (int) ($total_pelanggan ?? 0) ?>">0</div>
            <div class="lp-stat-label">Pelanggan Terdaftar</div>
        </div>
        <div class="lp-stat-card">
            <div class="lp-stat-num" data-count="<?= (int) ($total_produk ?? 0) ?>">0</div>
            <div class="lp-stat-label">Varian Produk</div>
        </div>
        <div class="lp-stat-card">
            <div class="lp-stat-num" data-count="<?= (int) ($pesanan_terkirim ?? 0) ?>">0</div>
            <div class="lp-stat-label">Pesanan Terkirim</div>
        </div>
        <div class="lp-stat-card">
            <div class="lp-stat-num" data-count="<?= (int) ($kota_terjangkau ?? 0) ?>">0</div>
            <div class="lp-stat-label">Kota Terjangkau</div>
        </div>
    </div>

    <!-- ============================================================
         KATEGORI
         ============================================================ -->
    <section class="lp-section" id="kategori">
        <div class="lp-section-head">
            <span class="lp-section-tag"><i class="fa-solid fa-layer-group"></i> Kategori</span>
            <h2>Kategori Pilihan</h2>
            <p>Temukan celana sport sesuai kebutuhan aktivitasmu.</p>
        </div>
        <div class="lp-kategori-grid">
            <?php if (!empty($kategori_list)) : ?>
                <?php foreach ($kategori_list as $kat) : ?>
                <a href="<?= base_url('pelanggan/dashboard') ?>?kategori=<?= (int) $kat['id'] ?>" class="lp-kategori-card">
                    <div class="lp-kategori-icon"><i class="fa-solid fa-shirt"></i></div>
                    <div>
                        <h3><?= esc($kat['nama_kategori']) ?></h3>
                        <p><?= (int) $kat['jumlah_produk'] ?> produk tersedia di kategori ini</p>
                    </div>
                    <i class="fa-solid fa-arrow-right lp-kategori-arrow"></i>
                </a>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="lp-produk-empty" style="grid-column:1/-1;">
                    <i class="fa-solid fa-layer-group"></i>
                    <p>Belum ada kategori dengan produk yang tersedia.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- ============================================================
         KENAPA KAMI
         ============================================================ -->
    <section class="lp-section" id="kenapa">
        <div class="lp-section-head">
            <span class="lp-section-tag"><i class="fa-solid fa-award"></i> Keunggulan</span>
            <h2>Kenapa Belanja di Sport Center?</h2>
            <p>Kami pastikan setiap pesanan sampai dengan aman dan tepat waktu.</p>
        </div>
        <div class="lp-fitur-grid">
            <div class="lp-fitur-card">
                <div class="lp-fitur-icon"><i class="fa-solid fa-medal"></i></div>
                <h3>Kualitas Terjamin</h3>
                <p>Bahan premium yang dipilih langsung, nyaman dipakai untuk aktivitas apa pun.</p>
            </div>
            <div class="lp-fitur-card">
                <div class="lp-fitur-icon"><i class="fa-solid fa-truck-fast"></i></div>
                <h3>Pengiriman Cepat</h3>
                <p>Pesanan diproses secepat mungkin dan dikirim ke seluruh wilayah Indonesia.</p>
            </div>
            <div class="lp-fitur-card">
                <div class="lp-fitur-icon"><i class="fa-solid fa-shield-halved"></i></div>
                <h3>Pembayaran Aman</h3>
                <p>Bayar dengan COD atau transfer bank, dengan verifikasi yang jelas dan transparan.</p>
            </div>
        </div>
    </section>

    <!-- ============================================================
         PRODUK TERBARU
         ============================================================ -->
    <section class="lp-section" id="produk">
        <div class="lp-section-head">
            <span class="lp-section-tag"><i class="fa-solid fa-tags"></i> Katalog</span>
            <h2>Produk Terbaru</h2>
            <p>Koleksi yang baru saja kami tambahkan ke katalog.</p>
        </div>
        <div class="lp-produk-grid">
            <?php if (!empty($produk_preview)) : ?>
                <?php foreach ($produk_preview as $p) :
                    $habis = isset($p['total_stok']) && (int) $p['total_stok'] <= 0;
                ?>
                <a href="<?= base_url('pelanggan/detail/' . $p['id']) ?>" class="lp-produk-card">
                    <div class="lp-produk-img">
                        <img src="<?= base_url('images/' . $p['gambar']) ?>" alt="<?= esc($p['nama_produk']) ?>" loading="lazy">
                    </div>
                    <div class="lp-produk-body">
                        <div class="lp-produk-name"><?= esc($p['nama_produk']) ?></div>
                        <?php if ($habis) : ?>
                            <span style="font-size:12px; color:#f87171; font-weight:700;">Stok Habis</span>
                        <?php else : ?>
                            <div class="lp-produk-price">Rp <?= number_format($p['harga'], 0, ',', '.') ?></div>
                        <?php endif; ?>
                    </div>
                </a>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="lp-produk-empty">
                    <i class="fa-solid fa-box-open"></i>
                    <p>Belum ada produk yang bisa ditampilkan saat ini.</p>
                </div>
            <?php endif; ?>
        </div>
        <?php if (!empty($produk_preview)) : ?>
            <div style="text-align:center; margin-top:36px;">
                <a href="<?= base_url('pelanggan/dashboard') ?>" class="lp-btn lp-btn-ghost lp-btn-lg">
                    Lihat Semua Produk <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        <?php endif; ?>
    </section>

    <!-- ============================================================
         TESTIMONI
         ============================================================ -->
    <section class="lp-section" id="testimoni">
        <div class="lp-section-head">
            <span class="lp-section-tag"><i class="fa-solid fa-comments"></i> Testimoni</span>
            <h2>Apa Kata Pelanggan Kami</h2>
            <p>Ribuan pelanggan sudah merasakan pengalaman belanja di Sport Center.</p>
        </div>
        <div class="lp-testi-grid">
            <?php if (!empty($testimoni)) : ?>
                <?php foreach ($testimoni as $t) :
                    $rating   = (int) ($t['rating'] ?? 0);
                    $nama     = trim($t['nama'] ?? 'Pelanggan');
                    $inisial  = strtoupper(substr($nama, 0, 1));
                    $kotaUser = trim($t['kota'] ?? '');
                ?>
                <div class="lp-testi-card">
                    <div class="lp-testi-stars"><?= str_repeat('★', max(0, min(5, $rating))) . str_repeat('☆', 5 - max(0, min(5, $rating))) ?></div>
                    <p class="lp-testi-text">"<?= esc($t['ulasan']) ?>"</p>
                    <div class="lp-testi-user">
                        <div class="lp-testi-avatar"><?= esc($inisial) ?></div>
                        <div>
                            <div class="lp-testi-name"><?= esc($nama) ?></div>
                            <div class="lp-testi-role">Pelanggan<?= $kotaUser ? ' — ' . esc($kotaUser) : '' ?></div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="lp-produk-empty" style="grid-column:1/-1;">
                    <i class="fa-solid fa-comments"></i>
                    <p>Belum ada ulasan dari pelanggan saat ini.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- ============================================================
         FAQ
         ============================================================ -->
    <section class="lp-section" id="faq">
        <div class="lp-section-head">
            <span class="lp-section-tag"><i class="fa-solid fa-circle-question"></i> FAQ</span>
            <h2>Pertanyaan yang Sering Diajukan</h2>
            <p>Belum ketemu jawabannya? Hubungi kami langsung di bagian kontak.</p>
        </div>
        <div class="lp-faq-list" id="faqList">
            <div class="lp-faq-item">
                <div class="lp-faq-q">
                    Berapa lama waktu pengiriman?
                    <i class="fa-solid fa-plus"></i>
                </div>
                <div class="lp-faq-a">
                    Rata-rata pesanan diproses 1×24 jam setelah pembayaran dikonfirmasi, dan dikirim ke seluruh Indonesia dengan estimasi 2–5 hari kerja tergantung lokasi tujuan.
                </div>
            </div>
            <div class="lp-faq-item">
                <div class="lp-faq-q">
                    Metode pembayaran apa saja yang tersedia?
                    <i class="fa-solid fa-plus"></i>
                </div>
                <div class="lp-faq-a">
                    Kami menerima pembayaran COD (Bayar di Tempat) untuk area tertentu, serta transfer bank melalui rekening resmi toko dengan verifikasi bukti transfer oleh admin.
                </div>
            </div>
            <div class="lp-faq-item">
                <div class="lp-faq-q">
                    Bagaimana jika ukuran yang saya terima tidak pas?
                    <i class="fa-solid fa-plus"></i>
                </div>
                <div class="lp-faq-a">
                    Silakan hubungi admin melalui halaman kontak dalam 2×24 jam setelah barang diterima. Kami akan bantu proses penukaran ukuran selama stok tersedia.
                </div>
            </div>
            <div class="lp-faq-item">
                <div class="lp-faq-q">
                    Apakah saya harus punya akun untuk belanja?
                    <i class="fa-solid fa-plus"></i>
                </div>
                <div class="lp-faq-a">
                    Ya, untuk mempermudah pelacakan pesanan dan riwayat transaksi, Anda perlu mendaftar akun terlebih dahulu sebelum melakukan checkout.
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================
         KONTAK / NEWSLETTER
         ============================================================ -->
    <section class="lp-section" id="kontak">
        <div class="lp-contact-grid">
            <div class="lp-contact-info">
                <span class="lp-section-tag"><i class="fa-solid fa-envelope"></i> Hubungi Kami</span>
                <h2>Ada Pertanyaan? Kami Siap Bantu</h2>
                <p>Tim kami siap membantu seputar produk, pesanan, maupun kerja sama. Kirim pesan atau kunjungi toko kami langsung.</p>
                <div class="lp-contact-list">
                    <div class="lp-contact-list-item">
                        <i class="fa-solid fa-location-dot"></i>
                        <?= esc($alamat_admin['jalan'] ?? '') ?>, <?= esc($alamat_admin['kecamatan'] ?? '') ?>, <?= esc($alamat_admin['kota'] ?? '') ?>, <?= esc($alamat_admin['provinsi'] ?? '') ?>
                    </div>
                    <?php if (!empty($alamat_admin['maps_link'])) : ?>
                    <div class="lp-contact-list-item">
                        <i class="fa-solid fa-map"></i>
                        <a href="<?= esc($alamat_admin['maps_link'], 'attr') ?>" target="_blank" rel="noopener">Lihat lokasi di Google Maps</a>
                    </div>
                    <?php endif; ?>
                    <div class="lp-contact-list-item">
                        <i class="fa-solid fa-shop"></i>
                        <?= esc($alamat_admin['nama_toko'] ?? 'Sport Center') ?>
                    </div>
                    <div class="lp-contact-list-item">
                        <i class="fa-solid fa-clock"></i>
                        Senin – Sabtu, 08.00 – 20.00 WIB
                    </div>
                </div>
            </div>
            <form class="lp-newsletter-form" onsubmit="event.preventDefault(); alert('Terima kasih! Pesan Anda telah kami terima.'); this.reset();">
                <input type="text" placeholder="Nama Anda" required>
                <input type="email" placeholder="Alamat Email" required>
                <textarea placeholder="Tulis pesan atau pertanyaan Anda..." required></textarea>
                <button type="submit">
                    <i class="fa-solid fa-paper-plane"></i> Kirim Pesan
                </button>
            </form>
        </div>
    </section>

    <!-- ============================================================
         CTA BAWAH
         ============================================================ -->
    <section class="lp-cta">
        <h2>Siap Belanja Perlengkapan Olahraga?</h2>
        <p>Daftar sekarang dan nikmati kemudahan belanja di Sport Center.</p>
        <a href="<?= base_url('auth/register') ?>" class="lp-btn lp-btn-brand lp-btn-lg">
            <i class="fa-solid fa-user-plus"></i>
            Daftar Akun Baru
        </a>
    </section>

    <!-- ============================================================
         FOOTER
         ============================================================ -->
    <footer>
        <div class="lp-footer-main">
            <div class="lp-footer-brand">
                <a href="<?= base_url('/') ?>" class="nav-logo">
                    <div class="nav-logo-badge">S</div>
                    <span class="nav-logo-text">SPORT<span>.</span></span>
                </a>
                <p>Perlengkapan olahraga pilihanmu dengan kualitas terjamin dan harga bersahabat, sejak berdiri di Pemalang.</p>
                <div class="lp-footer-social">
                    <a href="#" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" title="TikTok"><i class="fa-brands fa-tiktok"></i></a>
                    <a href="#" title="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                </div>
            </div>

            <div class="lp-footer-col">
                <h4>Belanja</h4>
                <ul>
                    <li><a href="<?= base_url('pelanggan/dashboard') ?>">Semua Produk</a></li>
                    <?php if (!empty($kategori_list)) : ?>
                        <?php foreach ($kategori_list as $kat) : ?>
                        <li><a href="<?= base_url('pelanggan/dashboard') ?>?kategori=<?= (int) $kat['id'] ?>"><?= esc($kat['nama_kategori']) ?></a></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <li><a href="<?= base_url('pelanggan/keranjang') ?>">Keranjang Saya</a></li>
                </ul>
            </div>

            <div class="lp-footer-col">
                <h4>Akun</h4>
                <ul>
                    <li><a href="<?= base_url('auth/inputPassword/pelanggan') ?>">Masuk Pelanggan</a></li>
                    <li><a href="<?= base_url('auth/register') ?>">Daftar Akun</a></li>
                    <li><a href="<?= base_url('pelanggan/orders') ?>">Riwayat Pesanan</a></li>
                    <li><a href="<?= base_url('auth/inputPassword/admin') ?>">Login Admin</a></li>
                </ul>
            </div>

            <div class="lp-footer-col">
                <h4>Bantuan</h4>
                <ul>
                    <li><a href="#faq">FAQ</a></li>
                    <li><a href="#kontak">Hubungi Kami</a></li>
                    <li><a href="#testimoni">Testimoni</a></li>
                    <li><a href="#kenapa">Kenapa Kami</a></li>
                </ul>
            </div>
        </div>

        <div class="lp-footer-bottom">
            <span>&copy; <?= date('Y') ?> Sport Center Pemalang. Semua hak dilindungi.</span>
            <div class="lp-footer-bottom-links">
                <a href="#home">Kebijakan Privasi</a>
                <a href="#home">Syarat &amp; Ketentuan</a>
            </div>
        </div>
    </footer>

    <!-- Back to top -->
    <button class="back-to-top" id="backToTop" aria-label="Kembali ke atas">
        <i class="fa-solid fa-arrow-up"></i>
    </button>

    <script>
        /* ── NAVBAR: scroll shadow ── */
        const navbar = document.getElementById('navbar');
        const backToTop = document.getElementById('backToTop');

        window.addEventListener('scroll', () => {
            const scrolled = window.scrollY > 20;
            navbar.classList.toggle('scrolled', scrolled);
            backToTop.classList.toggle('show', window.scrollY > 500);
        });

        /* ── NAVBAR: mobile toggle ── */
        const navToggle = document.getElementById('navToggle');
        const navMobilePanel = document.getElementById('navMobilePanel');

        navToggle.addEventListener('click', () => {
            navToggle.classList.toggle('open');
            navMobilePanel.classList.toggle('open');
        });

        document.querySelectorAll('#navMobilePanel a.nav-scroll').forEach(a => {
            a.addEventListener('click', () => {
                navToggle.classList.remove('open');
                navMobilePanel.classList.remove('open');
            });
        });

        /* ── NAVBAR: scrollspy (highlight active link) ── */
        const sections = document.querySelectorAll('section[id]');
        const navScrollLinks = document.querySelectorAll('.nav-scroll');

        function setActiveLink() {
            let current = 'home';
            const offset = 140;
            sections.forEach(sec => {
                if (window.scrollY >= sec.offsetTop - offset) {
                    current = sec.getAttribute('id');
                }
            });
            navScrollLinks.forEach(link => {
                link.classList.toggle('active', link.getAttribute('href') === '#' + current);
            });
        }
        window.addEventListener('scroll', setActiveLink);
        setActiveLink();

        /* ── BACK TO TOP ── */
        backToTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        /* ── STATS COUNTER (animate when in view) ── */
        const statEls = document.querySelectorAll('.lp-stat-num');
        let statsAnimated = false;

        function animateStats() {
            if (statsAnimated) return;
            const statsBlock = document.querySelector('.lp-stats');
            const rect = statsBlock.getBoundingClientRect();
            if (rect.top < window.innerHeight - 80) {
                statsAnimated = true;
                statEls.forEach(el => {
                    const target = parseInt(el.getAttribute('data-count'), 10);
                    const duration = 1200;
                    const start = performance.now();
                    function tick(now) {
                        const progress = Math.min((now - start) / duration, 1);
                        const eased = 1 - Math.pow(1 - progress, 3);
                        el.textContent = Math.floor(eased * target).toLocaleString('id-ID');
                        if (progress < 1) requestAnimationFrame(tick);
                        else el.textContent = target.toLocaleString('id-ID') + '+';
                    }
                    requestAnimationFrame(tick);
                });
            }
        }
        window.addEventListener('scroll', animateStats);
        animateStats();

        /* ── FAQ ACCORDION ── */
        document.querySelectorAll('.lp-faq-item').forEach(item => {
            item.querySelector('.lp-faq-q').addEventListener('click', () => {
                const isOpen = item.classList.contains('open');
                document.querySelectorAll('.lp-faq-item').forEach(i => i.classList.remove('open'));
                if (!isOpen) item.classList.add('open');
            });
        });
    </script>

</body>
</html>