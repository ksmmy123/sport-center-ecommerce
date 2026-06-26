<style>
    /* ============================================================
       ADMIN SIDEBAR — Dark luxury theme
       Menggunakan variabel dari main.php agar konsisten
       ============================================================ */

    .sidebar {
        width: var(--sidebar-width, 260px);
        height: 100vh;
        background: var(--admin-sidebar-bg, #0f172a);
        padding: 28px 14px 24px;
        display: flex;
        flex-direction: column;
        border-right: none;
        position: fixed;
        top: 0; left: 0;
        z-index: 100;
        transition: transform 0.32s cubic-bezier(0.4, 0, 0.2, 1),
                    box-shadow 0.32s ease;
        overflow-y: auto;
        overflow-x: hidden;
    }

    /* ✦ UPGRADE: Custom scrollbar gelap agar sesuai sidebar */
    .sidebar::-webkit-scrollbar { width: 4px; }
    .sidebar::-webkit-scrollbar-track { background: transparent; }
    .sidebar::-webkit-scrollbar-thumb {
        background: rgba(255,255,255,0.1);
        border-radius: 999px;
    }

    /* ============================================================
       LOGO AREA
       ============================================================ */
    .sidebar-logo-area {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 4px 10px 0;
        margin-bottom: 36px;
        text-decoration: none;
    }

    /* ✦ UPGRADE: Logo badge berbentuk persegi dengan gradient */
    .sidebar-logo-badge {
        width: 32px; height: 32px;
        border-radius: 9px;
        background: linear-gradient(135deg, #f97316, #fbbf24);
        display: flex; align-items: center; justify-content: center;
        font-size: 14px;
        font-weight: 800;
        color: #fff;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(249,115,22,0.4);
        letter-spacing: -0.5px;
    }

    .logo {
        font-size: 21px;
        font-weight: 800;
        color: #f1f5f9;
        letter-spacing: -1px;
        margin: 0;
        padding: 0;
    }

    /* ============================================================
       NAVIGATION CATEGORIES
       ============================================================ */
    .nav-category {
        font-size: 9.5px;
        font-weight: 700;
        /* ✦ UPGRADE: Lebih samar agar tidak bersaing dengan menu */
        color: rgba(148, 163, 184, 0.5);
        margin-top: 22px;
        margin-bottom: 4px;
        padding-left: 12px;
        text-transform: uppercase;
        letter-spacing: 1.8px;
    }

    /* ============================================================
       NAV LINKS
       ============================================================ */
    .nav-link {
        text-decoration: none;
        /* ✦ UPGRADE: Default warna lebih muted — active jauh lebih mencolok */
        color: rgba(148, 163, 184, 0.85);
        font-weight: 500;
        display: flex;
        align-items: center;
        padding: 10px 12px;
        border-radius: 10px;
        margin-bottom: 2px;
        transition: background 0.2s, color 0.2s, transform 0.2s;
        font-size: 13.5px;
        position: relative;
        gap: 0;
        letter-spacing: 0.1px;
    }

    /* ✦ UPGRADE: Icon pakai wrapper dengan background subtle */
    .nav-icon-wrap {
        width: 30px; height: 30px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 7px;
        margin-right: 10px;
        font-size: 13px;
        flex-shrink: 0;
        transition: background 0.2s, color 0.2s;
        color: inherit;
    }

    .nav-link:hover {
        background: rgba(255,255,255,0.07);
        color: #f1f5f9;
        transform: translateX(2px);
    }

    /* ✦ UPGRADE: Active state — glow effect + indicator bar */
    .nav-link.active {
        background: rgba(249,115,22,0.16);
        color: #fb923c;
        font-weight: 600;
    }
    .nav-link.active .nav-icon-wrap {
        background: rgba(249,115,22,0.2);
        color: #fb923c;
    }
    /* Indicator strip */
    .nav-link.active::before {
        content: '';
        position: absolute;
        left: 0; top: 50%;
        transform: translateY(-50%);
        width: 3px; height: 55%;
        background: linear-gradient(180deg, #f97316, #fbbf24);
        border-radius: 0 4px 4px 0;
        box-shadow: 0 0 8px rgba(249,115,22,0.6);
    }

    /* ============================================================
       BADGE (notifikasi)
       ============================================================ */
    .badge {
        background: #ef4444;
        color: #fff;
        font-size: 10px;
        padding: 2px 7px;
        border-radius: 999px;
        position: absolute;
        right: 12px;
        font-weight: 700;
        line-height: 1.5;
        /* ✦ UPGRADE: Shadow merah kecil agar terlihat darurat */
        box-shadow: 0 2px 6px rgba(239,68,68,0.45);
    }
    .badge-info { background: #3b82f6; box-shadow: 0 2px 6px rgba(59,130,246,0.45); }

    /* ============================================================
       DIVIDER VISUAL (antar section)
       ============================================================ */
    .sidebar-divider {
        height: 1px;
        background: rgba(255,255,255,0.06);
        margin: 8px 10px;
    }

    /* ============================================================
       LOGOUT SECTION
       ============================================================ */
    .sidebar-logout {
        margin-top: auto;
        color: #f87171;
        text-decoration: none;
        font-weight: 500;
        padding: 10px 12px;
        font-size: 13.5px;
        display: flex;
        align-items: center;
        border-radius: 10px;
        transition: background 0.2s, color 0.2s;
        /* ✦ UPGRADE: Border atas lebih subtle */
        border-top: 1px solid rgba(255,255,255,0.07);
        padding-top: 18px;
        margin-top: 12px;
        gap: 0;
    }
    .sidebar-logout:hover {
        background: rgba(239,68,68,0.12);
        color: #fca5a5;
    }
    .sidebar-logout .nav-icon-wrap {
        color: inherit;
    }

    /* ============================================================
       RESPONSIVE SIDEBAR
       ============================================================ */
    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
            box-shadow: none;
        }
        .sidebar.open {
            transform: translateX(0);
            /* ✦ UPGRADE: Shadow dramatis saat slide-in di mobile */
            box-shadow: 8px 0 40px rgba(0,0,0,0.5);
        }
    }

    @media (min-width: 769px) and (max-width: 1024px) {
        .sidebar { width: 220px; padding: 22px 10px 20px; }
        .logo { font-size: 19px; }
        .nav-link { padding: 9px 10px; font-size: 13px; }
    }
</style>

<div class="sidebar" id="adminSidebar">

    <!-- Logo -->
    <a href="<?= base_url('admin/dashboard') ?>" class="sidebar-logo-area" style="text-decoration:none;">
        <div class="sidebar-logo-badge">S</div>
        <span class="logo">SPORT.</span>
    </a>

    <!-- MENU -->
    <div class="nav-category">Menu</div>

    <a href="<?= base_url('admin/dashboard') ?>"
       class="nav-link <?= (uri_string() == 'admin/dashboard') ? 'active' : '' ?>">
        <span class="nav-icon-wrap"><i class="fas fa-th-large"></i></span>
        Dashboard
    </a>

    <a href="<?= base_url('admin/produk') ?>"
       class="nav-link <?= (uri_string() == 'admin/produk') ? 'active' : '' ?>">
        <span class="nav-icon-wrap"><i class="fas fa-box-open"></i></span>
        Produk
    </a>

    <a href="<?= base_url('admin/pesanan') ?>"
       class="nav-link <?= (uri_string() == 'admin/pesanan') ? 'active' : '' ?>">
        <span class="nav-icon-wrap"><i class="fas fa-shopping-bag"></i></span>
        Pesanan
        <?php if (isset($totalNotifikasi) && $totalNotifikasi > 0) : ?>
            <span class="badge"><?= $totalNotifikasi ?></span>
        <?php endif; ?>
    </a>

    <a href="<?= base_url('admin/user') ?>"
       class="nav-link <?= (uri_string() == 'admin/user') ? 'active' : '' ?>">
        <span class="nav-icon-wrap"><i class="fas fa-users"></i></span>
        User
    </a>

    <!-- FINANCIAL -->
    <div class="sidebar-divider"></div>
    <div class="nav-category">Financial</div>

    <a href="<?= base_url('admin/transaksi') ?>"
       class="nav-link <?= (uri_string() == 'admin/transaksi') ? 'active' : '' ?>">
        <span class="nav-icon-wrap"><i class="fas fa-wallet"></i></span>
        Transaksi
    </a>

    <a href="<?= base_url('admin/invoices') ?>"
       class="nav-link <?= (uri_string() == 'admin/invoices') ? 'active' : '' ?>">
        <span class="nav-icon-wrap"><i class="fas fa-file-invoice-dollar"></i></span>
        Invoices
    </a>

    <a href="<?= base_url('admin/laporan') ?>"
       class="nav-link <?= (uri_string() == 'admin/laporan') ? 'active' : '' ?>">
        <span class="nav-icon-wrap"><i class="fas fa-chart-line"></i></span>
        Laporan
    </a>

    <!-- SUPPORT -->
    <div class="sidebar-divider"></div>
    <div class="nav-category">Support</div>

    <a href="<?= base_url('admin/feedback') ?>"
       class="nav-link <?= (uri_string() == 'admin/feedback') ? 'active' : '' ?>">
        <span class="nav-icon-wrap"><i class="fas fa-comment-dots"></i></span>
        Feedback
    </a>

    <a href="<?= base_url('admin/pengaturan') ?>"
       class="nav-link <?= (uri_string() == 'admin/pengaturan') ? 'active' : '' ?>">
        <span class="nav-icon-wrap"><i class="fas fa-sliders-h"></i></span>
        Pengaturan
    </a>

    <!-- Logout -->
    <a href="<?= base_url('auth/logout') ?>" class="sidebar-logout">
        <span class="nav-icon-wrap"><i class="fas fa-arrow-right-from-bracket"></i></span>
        Keluar
    </a>

</div>