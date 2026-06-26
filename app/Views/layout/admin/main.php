<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sport Center — Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* ============================================================
           DESIGN TOKENS ADMIN — disamakan dengan pelanggan_layout.php
           Palette: slate-900 base, slate-800 surface, orange accent
           ============================================================ */
        :root {
            --brand:          #f97316;
            --brand-dark:     #ea6c08;
            --brand-subtle:   rgba(249,115,22,0.15);
            --brand-glow:     rgba(249,115,22,0.20);

            --admin-sidebar-bg:     #0f172a;
            --admin-sidebar-hover:  rgba(255,255,255,0.07);
            --admin-sidebar-active: rgba(255,140,0,0.18);
            --admin-accent:         #f97316;
            --admin-accent-dim:     rgba(249,115,22,0.5);

            --admin-text:           #f1f5f9;
            --admin-text-muted:     #64748b;
            --admin-text-secondary: #94a3b8;
            --admin-border-dark:    rgba(255,255,255,0.07);

            /* Dark palette — sama persis dengan pelanggan */
            --bg:             #0b1120;
            --content-bg:     #0b1120;
            --surface:        #0f172a;
            --surface-raised: #1e293b;
            --surface-high:   #273549;

            --ink:            #f1f5f9;
            --ink-secondary:  #94a3b8;
            --ink-muted:      #475569;

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

            --sidebar-width: 260px;
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
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.65);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            z-index: 99;
            opacity: 0;
            transition: opacity var(--transition);
        }
        .sidebar-overlay.active { opacity: 1; }

        /* ============================================================
           MAIN WRAPPER
           ============================================================ */
        .main-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin-left: var(--sidebar-width);
            transition: margin-left 0.32s cubic-bezier(0.4,0,0.2,1);
        }

        .main-content {
            flex: 1;
            padding: 40px 44px;
            overflow-y: auto;
            background-color: var(--content-bg);
            padding-bottom: 80px;
        }
        .main-content::-webkit-scrollbar { width: 6px; }
        .main-content::-webkit-scrollbar-track { background: transparent; }
        .main-content::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: var(--radius-pill); }

        /* ============================================================
           TOPBAR ADMIN (mobile)
           ============================================================ */
        .admin-topbar {
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
        .admin-topbar-logo {
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -1px;
            color: var(--ink);
        }
        .admin-topbar-logo span { color: var(--brand); }

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
           UTILITY CLASSES — disamakan dengan pelanggan
           ============================================================ */
        .card {
            background: var(--surface);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            padding: 24px;
            transition: box-shadow var(--transition), transform var(--transition), border-color var(--transition);
        }
        .card:hover { box-shadow: var(--shadow-md); border-color: rgba(255,255,255,0.12); }

        .card-featured {
            background: linear-gradient(135deg, var(--brand) 0%, #fbbf24 100%);
            color: #fff;
            border: none;
            box-shadow: 0 8px 32px rgba(249,115,22,0.35);
        }

        /* ✦ Stat cards */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(190px, 1fr));
            gap: 16px;
            margin-bottom: 28px;
        }
        .stat-card {
            background: var(--surface);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            padding: 20px 22px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            transition: transform var(--transition), box-shadow var(--transition);
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
        .stat-card-icon {
            width: 42px; height: 42px;
            border-radius: var(--radius-md);
            display: flex; align-items: center; justify-content: center;
            font-size: 17px;
        }
        .stat-card-icon.orange { background: rgba(249,115,22,0.15); color: var(--brand); }
        .stat-card-icon.blue   { background: rgba(59,130,246,0.15); color: #60a5fa; }
        .stat-card-icon.green  { background: rgba(34,197,94,0.15);  color: #4ade80; }
        .stat-card-icon.purple { background: rgba(168,85,247,0.15); color: #c084fc; }
        .stat-card-icon.red    { background: rgba(239,68,68,0.15);  color: #f87171; }

        .stat-card-value {
            font-size: 26px;
            font-weight: 700;
            letter-spacing: -0.8px;
            color: var(--ink);
            line-height: 1;
        }
        .stat-card-label {
            font-size: 12.5px;
            color: var(--ink-secondary);
            font-weight: 500;
        }
        .stat-card-trend {
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .stat-card-trend.up   { color: #4ade80; }
        .stat-card-trend.down { color: #f87171; }

        /* Page header */
        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 28px;
            flex-wrap: wrap;
        }
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
            font-weight: 400;
        }
        .page-header-actions {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
        }

        /* Buttons */
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
            white-space: nowrap;
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

        .btn-danger {
            background: rgba(239,68,68,0.12);
            color: #f87171;
            border: 1px solid rgba(239,68,68,0.3);
        }
        .btn-danger:hover { background: rgba(239,68,68,0.2); }

        /* Badge */
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
        .badge-neutral { background: var(--surface-raised); color: var(--ink-secondary); }

        /* Table */
        .table-wrapper {
            background: var(--surface);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            overflow-x: auto;
        }
        .table-wrapper table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            min-width: 600px;
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

        /* Form input */
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

        /* Divider */
        .divider {
            height: 1px;
            background: var(--border);
            margin: 20px 0;
        }

        /* ============================================================
           RESPONSIVE
           ============================================================ */
        @media (max-width: 768px) {
            .admin-topbar { display: flex; }
            .main-wrapper { margin-left: 0; width: 100%; }
            .main-content {
                padding: 16px;
                padding-top: 76px;
                padding-bottom: 40px;
            }
            .stat-grid { grid-template-columns: repeat(2, 1fr); }
            .page-header { flex-direction: column; align-items: flex-start; }
            .table-wrapper table { min-width: 480px; }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            :root { --sidebar-width: 220px; }
            .main-content { padding: 28px 28px; }
        }
    </style>
</head>
<body>

    <div class="sidebar-overlay" id="adminOverlay"></div>

    <header class="admin-topbar">
        <span class="admin-topbar-logo">SPORT<span>.</span></span>
        <button class="hamburger" id="adminHamburger" aria-label="Toggle menu">
            <span></span><span></span><span></span>
        </button>
    </header>

    <?= $this->include('layout/admin/sidebar') ?>

    <div class="main-wrapper">
        <div class="main-content">
            <?= $this->renderSection('content') ?>
        </div>
    </div>

    <script>
        const adminSidebar   = document.getElementById('adminSidebar');
        const adminOverlay   = document.getElementById('adminOverlay');
        const adminHamburger = document.getElementById('adminHamburger');

        function openAdminSidebar() {
            adminSidebar.classList.add('open');
            adminOverlay.style.display = 'block';
            adminOverlay.getBoundingClientRect();
            adminOverlay.classList.add('active');
            adminHamburger.classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeAdminSidebar() {
            adminSidebar.classList.remove('open');
            adminOverlay.classList.remove('active');
            adminHamburger.classList.remove('open');
            document.body.style.overflow = '';
            setTimeout(() => {
                if (!adminOverlay.classList.contains('active')) {
                    adminOverlay.style.display = 'none';
                }
            }, 300);
        }

        adminHamburger.addEventListener('click', () => {
            adminSidebar.classList.contains('open') ? closeAdminSidebar() : openAdminSidebar();
        });

        adminOverlay.addEventListener('click', closeAdminSidebar);

        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) closeAdminSidebar();
        });
    </script>
</body>
</html>