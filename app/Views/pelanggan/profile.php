<?= $this->extend('layout/pelanggan_layout') ?>

<?= $this->section('content') ?>
<style>
    /* ── PAGE CONTAINER ── */
    .profile-wrapper {
        max-width: 560px;
        margin: 0 auto;
    }

    .profile-page-title {
        font-size: 22px;
        font-weight: 800;
        letter-spacing: -0.5px;
        color: var(--ink);
        margin-bottom: 28px;
    }

    /* ── HEADER CARD: avatar + nama ── */
    .profile-head-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-xl);
        padding: 32px 24px;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        margin-bottom: 24px;
    }

    .profile-avatar {
        width: 96px;
        height: 96px;
        border-radius: 50%;
        border: 2.5px solid var(--brand);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background: var(--surface-raised);
        flex-shrink: 0;
        margin-bottom: 16px;
    }
    .profile-avatar i {
        font-size: 44px;
        color: var(--ink-muted);
    }
    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-name {
        font-size: 18px;
        font-weight: 800;
        letter-spacing: -0.3px;
        color: var(--ink);
        margin-bottom: 3px;
        word-break: break-word;
    }
    .profile-username {
        font-size: 13px;
        color: var(--ink-secondary);
    }

    /* ── MENU CARD ── */
    .profile-menu-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-xl);
        overflow: hidden;
    }

    .profile-menu-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 16px 20px;
        text-decoration: none;
        color: var(--ink);
        border-bottom: 1px solid var(--border-light);
        transition: background var(--transition);
    }
    .profile-menu-item:last-child { border-bottom: none; }
    .profile-menu-item:hover { background: var(--surface-raised); }

    .profile-menu-icon {
        width: 38px;
        height: 38px;
        border-radius: var(--radius-md);
        background: var(--surface-raised);
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        color: var(--ink-secondary);
        flex-shrink: 0;
        transition: background var(--transition), color var(--transition),
                    border-color var(--transition);
    }
    .profile-menu-item:hover .profile-menu-icon {
        background: var(--brand-subtle);
        color: var(--brand);
        border-color: rgba(249,115,22,0.2);
    }

    .profile-menu-label {
        flex: 1;
        font-size: 14.5px;
        font-weight: 600;
    }

    .profile-menu-chevron {
        color: var(--ink-muted);
        font-size: 13px;
        flex-shrink: 0;
        transition: transform var(--transition), color var(--transition);
    }
    .profile-menu-item:hover .profile-menu-chevron {
        transform: translateX(3px);
        color: var(--ink-secondary);
    }

    /* Logout item — warna merah */
    .profile-menu-item.danger { color: #f87171; }
    .profile-menu-item.danger .profile-menu-icon {
        color: #f87171;
        background: rgba(239,68,68,0.08);
        border-color: rgba(239,68,68,0.15);
    }
    .profile-menu-item.danger:hover {
        background: rgba(239,68,68,0.08);
    }
    .profile-menu-item.danger:hover .profile-menu-icon {
        background: rgba(239,68,68,0.18);
        color: #f87171;
        border-color: rgba(239,68,68,0.25);
    }

    /* ── RESPONSIVE ── */
    @media (max-width: 768px) {
        .profile-head-card { padding: 24px 18px; }
        .profile-avatar { width: 84px; height: 84px; }
        .profile-avatar i { font-size: 38px; }
        .profile-menu-item { padding: 14px 16px; }
    }
</style>

<div class="profile-wrapper">

    <h1 class="profile-page-title">My Profile</h1>

    <!-- HEADER: Avatar + Nama -->
    <div class="profile-head-card">
        <div class="profile-avatar">
            <i class="fa-solid fa-user"></i>
        </div>
        <h2 class="profile-name">
            <?= esc(session()->get('nama') ?? 'Nama Tidak Ditemukan') ?>
        </h2>
        <p class="profile-username">
            @<?= esc(session()->get('username') ?? 'guest') ?>
        </p>
    </div>

    <!-- MENU LIST -->
    <div class="profile-menu-card">
        <a href="<?= base_url('pelanggan/edit_profile') ?>" class="profile-menu-item">
            <span class="profile-menu-icon"><i class="fa-solid fa-user-pen"></i></span>
            <span class="profile-menu-label">Edit Profile</span>
            <i class="fa-solid fa-chevron-right profile-menu-chevron"></i>
        </a>

        <a href="<?= base_url('pelanggan/orders') ?>" class="profile-menu-item">
            <span class="profile-menu-icon"><i class="fa-solid fa-receipt"></i></span>
            <span class="profile-menu-label">My Orders</span>
            <i class="fa-solid fa-chevron-right profile-menu-chevron"></i>
        </a>

        <a href="<?= base_url('pelanggan/security') ?>" class="profile-menu-item">
            <span class="profile-menu-icon"><i class="fa-solid fa-shield-halved"></i></span>
            <span class="profile-menu-label">Security</span>
            <i class="fa-solid fa-chevron-right profile-menu-chevron"></i>
        </a>

        <a href="<?= base_url('auth/logout') ?>" class="profile-menu-item danger">
            <span class="profile-menu-icon"><i class="fa-solid fa-right-from-bracket"></i></span>
            <span class="profile-menu-label">Logout</span>
        </a>
    </div>

</div>
<?= $this->endSection() ?>