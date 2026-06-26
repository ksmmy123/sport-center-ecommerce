<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sport Center</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* ============================================================
           DARK MODE DESIGN TOKENS — seragam dengan admin
           Palette: slate-900 base, slate-800 surface, orange accent
           ============================================================ */
        :root {
            --brand:          #f97316;
            --brand-dark:     #ea6c08;
            --brand-subtle:   rgba(249,115,22,0.15);
            --brand-glow:     rgba(249,115,22,0.20);

            /* Dark palette — sama persis dengan admin sidebar */
            --bg:             #0b1120;       /* halaman utama — lebih gelap dari sidebar */
            --surface:        #0f172a;       /* sidebar, card */
            --surface-raised: #1e293b;       /* hover, input bg */
            --surface-high:   #273549;       /* elemen di atas surface-raised */

            --ink:            #f1f5f9;       /* teks utama */
            --ink-secondary:  #94a3b8;       /* teks sekunder */
            --ink-muted:      #475569;       /* placeholder, label */

            --border:         rgba(255,255,255,0.09);
            --border-light:   rgba(255,255,255,0.05);

            --shadow-xs:  0 1px 2px rgba(0,0,0,0.3);
            --shadow-sm:  0 2px 8px rgba(0,0,0,0.35), 0 1px 2px rgba(0,0,0,0.2);
            --shadow-md:  0 8px 24px rgba(0,0,0,0.45), 0 2px 6px rgba(0,0,0,0.25);
            --shadow-lg:  0 20px 48px rgba(0,0,0,0.55), 0 4px 12px rgba(0,0,0,0.3);

            --radius-sm:   8px;
            --radius-md:   14px;
            --radius-lg:   20px;
            --radius-xl:   28px;
            --radius-pill: 999px;
            --sidebar-width: 272px;
            --transition: 0.22s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ============================================================
           RESET & BASE
           ============================================================ */
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg);
            color: var(--ink);
            display: flex;
            min-height: 100vh;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        /* ============================================================
           OVERLAY
           ============================================================ */
        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.65);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            z-index: 99;
            opacity: 0;
            pointer-events: none;
            visibility: hidden;
            transition: opacity var(--transition), visibility var(--transition);
        }
        .sidebar-overlay.active {
            opacity: 1;
            pointer-events: auto;
            visibility: visible;
        }

        /* ============================================================
           SIDEBAR — Dark, sama dengan admin
           ============================================================ */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--surface);
            border-right: 1px solid var(--border);
            padding: 28px 14px 24px;
            position: fixed;
            top: 0; left: 0;
            display: flex;
            flex-direction: column;
            z-index: 100;
            transition: transform 0.32s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.32s ease;
            overflow-y: auto;
            overflow-x: hidden;
        }
        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-track { background: transparent; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: var(--radius-pill); }

        /* Logo */
        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 4px 10px 0;
            margin-bottom: 36px;
            text-decoration: none;
        }
        .sidebar-logo-badge {
            width: 32px; height: 32px;
            border-radius: 9px;
            background: linear-gradient(135deg, #f97316, #fbbf24);
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; font-weight: 800; color: #fff;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(249,115,22,0.4);
            letter-spacing: -0.5px;
        }
        .sidebar-logo-text {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -1px;
            color: var(--ink);
        }

        /* Nav section label */
        .nav-section-label {
            font-size: 9.5px;
            font-weight: 700;
            letter-spacing: 1.8px;
            text-transform: uppercase;
            color: rgba(148,163,184,0.45);
            padding: 0 12px;
            margin: 8px 0 4px;
        }

        .nav-menu { list-style: none; flex-grow: 1; }
        .nav-item  { margin-bottom: 2px; }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0;
            padding: 10px 12px;
            text-decoration: none;
            color: rgba(148,163,184,0.85);
            font-weight: 500;
            font-size: 13.5px;
            border-radius: 10px;
            transition: background var(--transition), color var(--transition), transform var(--transition);
            position: relative;
        }
        .nav-link-icon {
            width: 30px; height: 30px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 7px;
            font-size: 13px;
            flex-shrink: 0;
            margin-right: 10px;
            transition: background var(--transition), color var(--transition);
            color: inherit;
        }
        .nav-link:hover {
            background: rgba(255,255,255,0.07);
            color: var(--ink);
            transform: translateX(2px);
        }
        .nav-link.active {
            background: rgba(249,115,22,0.16);
            color: #fb923c;
            font-weight: 600;
        }
        .nav-link.active .nav-link-icon {
            background: rgba(249,115,22,0.2);
            color: #fb923c;
        }
        .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0; top: 50%;
            transform: translateY(-50%);
            width: 3px; height: 55%;
            background: linear-gradient(180deg, #f97316, #fbbf24);
            border-radius: 0 4px 4px 0;
            box-shadow: 0 0 8px rgba(249,115,22,0.55);
        }

        .sidebar-divider {
            height: 1px;
            background: var(--border);
            margin: 6px 10px;
        }

        /* Footer / logout */
        .sidebar-footer {
            margin-top: 12px;
            padding-top: 16px;
            border-top: 1px solid var(--border);
        }
        .logout-link {
            display: flex;
            align-items: center;
            gap: 0;
            padding: 10px 12px;
            text-decoration: none;
            color: #f87171;
            font-weight: 500;
            font-size: 13.5px;
            border-radius: 10px;
            transition: background var(--transition), color var(--transition);
        }
        .logout-link:hover { background: rgba(239,68,68,0.12); color: #fca5a5; }
        .logout-link .nav-link-icon { color: inherit; }

        /* ============================================================
           TOPBAR (mobile)
           ============================================================ */
        .topbar {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0;
            height: 60px;
            background: rgba(15,23,42,0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            align-items: center;
            justify-content: space-between;
            padding: 0 18px;
            z-index: 98;
        }
        .topbar-logo {
            font-size: 19px;
            font-weight: 800;
            letter-spacing: -1px;
            color: var(--ink);
        }
        .topbar-logo span { color: var(--brand); }

        .hamburger {
            background: rgba(255,255,255,0.07);
            border: none;
            cursor: pointer;
            width: 38px; height: 38px;
            border-radius: var(--radius-sm);
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            gap: 5px;
            transition: background var(--transition);
            -webkit-tap-highlight-color: transparent;
        }
        .hamburger:hover { background: rgba(255,255,255,0.13); }
        .hamburger span {
            display: block;
            width: 18px; height: 2px;
            background: #e2e8f0;
            border-radius: var(--radius-pill);
            transition: transform 0.3s, opacity 0.3s;
        }
        .hamburger.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
        .hamburger.open span:nth-child(2) { opacity: 0; }
        .hamburger.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

        /* ============================================================
           MAIN CONTENT
           ============================================================ */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 40px 44px;
            width: calc(100% - var(--sidebar-width));
            min-height: 100vh;
            padding-bottom: 80px;
        }

        /* ============================================================
           BOTTOM NAV (mobile)
           ============================================================ */
        .bottom-nav {
            display: none;
            position: fixed;
            bottom: 0; left: 0; right: 0;
            height: 68px;
            background: rgba(15,23,42,0.97);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-top: 1px solid var(--border);
            z-index: 97;
            align-items: center;
            justify-content: space-around;
            padding: 0 8px;
        }
        .bottom-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 3px;
            text-decoration: none;
            color: var(--ink-muted);
            font-size: 9.5px;
            font-weight: 500;
            padding: 8px 0;
            border-radius: 12px;
            transition: color var(--transition), background var(--transition);
            flex: 1;
            text-align: center;
            -webkit-tap-highlight-color: transparent;
        }
        .bottom-nav-item i { font-size: 17px; transition: transform var(--transition); }
        .bottom-nav-item.active { color: var(--brand); }
        .bottom-nav-item.active i { transform: scale(1.15); }
        .bottom-nav-item:hover { color: var(--brand); }

        /* ✦ FIX: fa-bag-shopping secara visual lebih besar/tebal dibanding
           ikon lain (house, bell, user) pada font-size yang sama.
           Kecilkan sedikit agar proporsional di sidebar & bottom-nav. */
        .nav-link-icon .fa-bag-shopping { font-size: 12px; }
        .bottom-nav-item .fa-bag-shopping { font-size: 15px; }
        .bottom-nav-item.active .fa-bag-shopping { transform: scale(1.08); }

        /* ============================================================
           UTILITY CLASSES — Dark mode version
           ============================================================ */

        .card {
            background: var(--surface);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            padding: 24px;
            transition: box-shadow var(--transition), transform var(--transition),
                        border-color var(--transition);
        }
        .card:hover { box-shadow: var(--shadow-md); border-color: rgba(255,255,255,0.12); }

        .card-clickable { cursor: pointer; }
        .card-clickable:hover { transform: translateY(-2px); }
        .card-clickable:active { transform: translateY(0); }

        .card-featured {
            background: linear-gradient(135deg, var(--brand) 0%, #fbbf24 100%);
            color: #fff;
            border: none;
            box-shadow: 0 8px 32px rgba(249,115,22,0.35);
        }

        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 16px;
        }
        .stat-card {
            background: var(--surface);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            transition: transform var(--transition), box-shadow var(--transition);
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }
        .stat-card-icon {
            width: 40px; height: 40px;
            border-radius: var(--radius-sm);
            background: var(--brand-subtle);
            color: var(--brand);
            display: flex; align-items: center; justify-content: center;
            font-size: 16px;
        }
        .stat-card-value {
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -0.5px;
            color: var(--ink);
        }
        .stat-card-label {
            font-size: 12.5px;
            color: var(--ink-secondary);
            font-weight: 500;
        }

        .page-header { margin-bottom: 28px; }
        .page-title {
            font-size: 26px;
            font-weight: 700;
            letter-spacing: -0.5px;
            color: var(--ink);
        }
        .page-subtitle {
            font-size: 14px;
            color: var(--ink-secondary);
            margin-top: 4px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            border-radius: var(--radius-pill);
            font-size: 11.5px;
            font-weight: 600;
        }
        .badge-success { background: rgba(34,197,94,0.15);  color: #4ade80; }
        .badge-warning { background: rgba(234,179,8,0.15);  color: #facc15; }
        .badge-danger  { background: rgba(239,68,68,0.15);  color: #f87171; }
        .badge-info    { background: rgba(59,130,246,0.15); color: #60a5fa; }
        .badge-brand   { background: var(--brand-subtle);   color: var(--brand); }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: var(--radius-md);
            font-family: 'Outfit', sans-serif;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all var(--transition);
            text-decoration: none;
        }
        .btn-primary {
            background: var(--brand);
            color: #fff;
            box-shadow: 0 4px 14px rgba(249,115,22,0.35);
        }
        .btn-primary:hover {
            background: var(--brand-dark);
            box-shadow: 0 6px 20px rgba(249,115,22,0.45);
            transform: translateY(-1px);
        }
        .btn-secondary {
            background: var(--surface-raised);
            color: var(--ink);
            border: 1px solid var(--border);
        }
        .btn-secondary:hover { background: var(--surface-high); }

        .divider { height: 1px; background: var(--border); margin: 20px 0; }

        .table-wrapper {
            background: var(--surface);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }
        .table-wrapper table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        .table-wrapper th {
            background: var(--surface-raised);
            color: var(--ink-secondary);
            font-weight: 600;
            font-size: 11.5px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            padding: 13px 18px;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }
        .table-wrapper td {
            padding: 14px 18px;
            color: var(--ink);
            border-bottom: 1px solid var(--border-light);
        }
        .table-wrapper tr:last-child td { border-bottom: none; }
        .table-wrapper tr:hover td { background: var(--surface-raised); transition: background 0.15s; }

        /* Form inputs */
        .form-group { display: flex; flex-direction: column; gap: 6px; margin-bottom: 18px; }
        .form-label { font-size: 13px; font-weight: 600; color: var(--ink-secondary); }
        .form-control {
            padding: 10px 14px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-md);
            font-family: 'Outfit', sans-serif;
            font-size: 14px;
            color: var(--ink);
            background: var(--surface-raised);
            transition: border-color var(--transition), box-shadow var(--transition);
            outline: none;
        }
        .form-control:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 3px var(--brand-glow);
        }
        .form-control::placeholder { color: var(--ink-muted); }

        /* ============================================================
           RESPONSIVE
           ============================================================ */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open {
                transform: translateX(0);
                box-shadow: 8px 0 40px rgba(0,0,0,0.5);
            }
            .topbar { display: flex; }
            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 16px;
                padding-top: 76px;
                padding-bottom: 86px;
            }
            .bottom-nav { display: flex; }
            .stat-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            :root { --sidebar-width: 230px; }
            .main-content { padding: 28px 28px; }
        }
    </style>
</head>
<body>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Topbar (mobile only) -->
    <header class="topbar">
        <span class="topbar-logo">SPORT<span>.</span></span>
        <button class="hamburger" id="hamburgerBtn" aria-label="Toggle menu">
            <span></span><span></span><span></span>
        </button>
    </header>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <a href="<?= base_url('pelanggan/dashboard') ?>" class="sidebar-logo">
            <div class="sidebar-logo-badge">S</div>
            <span class="sidebar-logo-text">SPORT.</span>
        </a>

        <p class="nav-section-label">Menu Utama</p>

        <ul class="nav-menu">
            <li class="nav-item">
                <a href="<?= base_url('pelanggan/dashboard') ?>"
                   class="nav-link <?= ($active ?? '') == 'home' ? 'active' : '' ?>">
                    <span class="nav-link-icon"><i class="fa-solid fa-house-chimney"></i></span>
                    Beranda
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('pelanggan/notifikasi') ?>"
                   class="nav-link <?= ($active ?? '') == 'notifikasi' ? 'active' : '' ?>">
                    <span class="nav-link-icon"><i class="fa-solid fa-bell"></i></span>
                    Notifikasi
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('pelanggan/keranjang') ?>"
                   class="nav-link <?= ($active ?? '') == 'keranjang' ? 'active' : '' ?>">
                    <span class="nav-link-icon"><i class="fa-solid fa-bag-shopping"></i></span>
                    Keranjang
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('pelanggan/profile') ?>"
                   class="nav-link <?= ($active ?? '') == 'profile' ? 'active' : '' ?>">
                    <span class="nav-link-icon"><i class="fa-solid fa-circle-user"></i></span>
                    Profil Saya
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <a href="<?= base_url('auth/logout') ?>" class="logout-link">
                <span class="nav-link-icon"><i class="fa-solid fa-arrow-right-from-bracket"></i></span>
                Keluar
            </a>
        </div>
    </aside>

    <!-- Bottom Navigation (mobile only) -->
    <nav class="bottom-nav">
        <a href="<?= base_url('pelanggan/dashboard') ?>"
           class="bottom-nav-item <?= ($active ?? '') == 'home' ? 'active' : '' ?>">
            <i class="fa-solid fa-house-chimney"></i><span>Beranda</span>
        </a>
        <a href="<?= base_url('pelanggan/notifikasi') ?>"
           class="bottom-nav-item <?= ($active ?? '') == 'notifikasi' ? 'active' : '' ?>">
            <i class="fa-solid fa-bell"></i><span>Notifikasi</span>
        </a>
        <a href="<?= base_url('pelanggan/keranjang') ?>"
           class="bottom-nav-item <?= ($active ?? '') == 'keranjang' ? 'active' : '' ?>">
            <i class="fa-solid fa-bag-shopping"></i><span>Keranjang</span>
        </a>
        <a href="<?= base_url('pelanggan/profile') ?>"
           class="bottom-nav-item <?= ($active ?? '') == 'profile' ? 'active' : '' ?>">
            <i class="fa-solid fa-circle-user"></i><span>Profil</span>
        </a>
        <a href="<?= base_url('auth/logout') ?>"
           class="bottom-nav-item" style="color:#f87171;">
            <i class="fa-solid fa-arrow-right-from-bracket"></i><span>Keluar</span>
        </a>
    </nav>

    <main class="main-content">
        <?= $this->renderSection('content') ?>
    </main>

    <script>
        const sidebar      = document.getElementById('sidebar');
        const overlay      = document.getElementById('sidebarOverlay');
        const hamburgerBtn = document.getElementById('hamburgerBtn');

        function openSidebar() {
            sidebar.classList.add('open');
            overlay.classList.add('active');
            hamburgerBtn.classList.add('open');
            document.body.style.overflow = 'hidden';
        }
        function closeSidebar() {
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
            hamburgerBtn.classList.remove('open');
            document.body.style.overflow = '';
        }

        hamburgerBtn.addEventListener('click', () => {
            sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
        });
        overlay.addEventListener('click', closeSidebar);
        window.addEventListener('resize', () => { if (window.innerWidth > 768) closeSidebar(); });
    </script>
</body>
</html>