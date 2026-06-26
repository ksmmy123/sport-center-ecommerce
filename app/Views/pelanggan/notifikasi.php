<?= $this->extend('layout/pelanggan_layout') ?>

<?= $this->section('content') ?>
<style>
    /* ── PAGE HEADER ── */
    .notif-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 28px;
    }
    .notif-title {
        font-size: 24px;
        font-weight: 800;
        letter-spacing: -0.6px;
        color: var(--ink);
    }
    .notif-unread-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: rgba(249,115,22,0.15);
        color: var(--brand);
        border: 1px solid rgba(249,115,22,0.2);
        padding: 4px 12px;
        border-radius: var(--radius-pill);
        font-size: 12px;
        font-weight: 700;
    }

    /* ── NOTIF LIST ── */
    .notif-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
        max-width: 700px;
    }

    /* ── NOTIF CARD ── */
    .notif-card {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 16px 18px;
        transition: border-color var(--transition), box-shadow var(--transition),
                    transform var(--transition);
        position: relative;
        overflow: hidden;
    }
    .notif-card:hover {
        border-color: rgba(255,255,255,0.13);
        box-shadow: var(--shadow-sm);
        transform: translateX(3px);
    }

    /* Unread indicator — garis kiri tipis */
    .notif-card.unread::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 3px;
        border-radius: 0 3px 3px 0;
    }
    .notif-card.unread.type-promo::before    { background: var(--brand); box-shadow: 0 0 8px rgba(249,115,22,0.5); }
    .notif-card.unread.type-sistem::before   { background: #60a5fa; box-shadow: 0 0 8px rgba(59,130,246,0.5); }
    .notif-card.unread.type-pesanan::before  { background: #4ade80; box-shadow: 0 0 8px rgba(34,197,94,0.5); }

    /* Read state — sedikit lebih redup */
    .notif-card.read { opacity: 0.72; }

    /* ── ICON ── */
    .notif-icon {
        width: 44px; height: 44px;
        border-radius: var(--radius-md);
        display: flex; align-items: center; justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
        border: 1px solid;
    }
    .notif-icon.promo {
        background: rgba(249,115,22,0.12);
        color: var(--brand);
        border-color: rgba(249,115,22,0.2);
    }
    .notif-icon.sistem {
        background: rgba(59,130,246,0.12);
        color: #60a5fa;
        border-color: rgba(59,130,246,0.2);
    }
    .notif-icon.pesanan {
        background: rgba(34,197,94,0.12);
        color: #4ade80;
        border-color: rgba(74,222,128,0.2);
    }

    /* ── CONTENT ── */
    .notif-content { flex: 1; min-width: 0; }

    .notif-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 7px;
        gap: 8px;
        flex-wrap: wrap;
    }
    .notif-type-label {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .notif-type-label.promo  { color: var(--brand); }
    .notif-type-label.sistem { color: #60a5fa; }
    .notif-type-label.pesanan{ color: #4ade80; }

    .notif-time {
        font-size: 11px;
        color: var(--ink-muted);
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .notif-body {
        font-size: 13.5px;
        color: var(--ink-secondary);
        line-height: 1.6;
        margin-bottom: 10px;
    }

    /* Promo code pill di dalam body */
    .promo-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: rgba(249,115,22,0.12);
        border: 1px dashed rgba(249,115,22,0.4);
        color: var(--brand);
        padding: 2px 9px;
        border-radius: var(--radius-sm);
        font-size: 12.5px;
        font-weight: 800;
        letter-spacing: 1px;
        cursor: pointer;
        transition: background var(--transition);
    }
    .promo-pill:hover { background: rgba(249,115,22,0.22); }

    /* Action button di bawah body */
    .notif-action {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--surface-raised);
        border: 1px solid var(--border);
        color: var(--ink);
        padding: 7px 14px;
        border-radius: var(--radius-md);
        font-family: 'Outfit', sans-serif;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: background var(--transition), color var(--transition),
                    border-color var(--transition);
        text-decoration: none;
    }
    .notif-action:hover {
        background: var(--brand);
        color: #fff;
        border-color: var(--brand);
    }

    /* ── EMPTY STATE ── */
    .notif-empty {
        text-align: center;
        padding: 80px 20px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-xl);
        max-width: 700px;
    }
    .notif-empty i { font-size: 52px; color: var(--ink-muted); margin-bottom: 16px; display: block; }
    .notif-empty p { color: var(--ink-secondary); font-size: 15px; }

    /* ── RESPONSIVE ── */
    @media (max-width: 600px) {
        .notif-card { flex-direction: column; gap: 12px; }
        .notif-icon { width: 40px; height: 40px; font-size: 16px; }
    }
</style>

<!-- HEADER -->
<div class="notif-header">
    <h1 class="notif-title">Notifikasi</h1>
    <!-- Badge unread — bisa dijadikan dinamis dari controller -->
    <div class="notif-unread-badge">
        <i class="fa-solid fa-bell" style="font-size:11px;"></i>
        2 belum dibaca
    </div>
</div>

<div class="notif-list">

    <!-- ── NOTIF 1: Promo Aktif (UNREAD) ── -->
    <div class="notif-card unread type-promo">
        <div class="notif-icon promo">
            <i class="fa-solid fa-bolt"></i>
        </div>
        <div class="notif-content">
            <div class="notif-top">
                <span class="notif-type-label promo">Promo Khusus</span>
                <span class="notif-time">
                    <i class="fa-regular fa-clock" style="font-size:10px;"></i>
                    Baru saja
                </span>
            </div>
            <p class="notif-body">
                Diskon spesial hari ini! Gunakan kode
                <span class="promo-pill" onclick="navigator.clipboard.writeText('SPORTPRO1112').then(() => {this.textContent='✓ Disalin!'})">
                    <i class="fa-regular fa-copy" style="font-size:10px;"></i>
                    SPORTPRO1112
                </span>
                untuk mendapatkan potongan <strong style="color:var(--ink);">20%</strong> di semua produk pilihan.
            </p>
            <button class="notif-action">
                <i class="fa-solid fa-tag"></i>
                Klaim Sekarang
            </button>
        </div>
    </div>

    <!-- ── NOTIF 2: Promo Lama (READ) ── -->
    <div class="notif-card read type-promo">
        <div class="notif-icon promo">
            <i class="fa-solid fa-tag"></i>
        </div>
        <div class="notif-content">
            <div class="notif-top">
                <span class="notif-type-label promo">Promo Khusus</span>
                <span class="notif-time">
                    <i class="fa-regular fa-clock" style="font-size:10px;"></i>
                    3 hari yang lalu
                </span>
            </div>
            <p class="notif-body">
                Hemat belanja dengan kode
                <span class="promo-pill">SPORTCENTERYAYAYA</span>.
                Berlaku untuk pembelian minimum Rp 150.000.
            </p>
        </div>
    </div>

    <!-- ── NOTIF 3: Sistem (UNREAD) ── -->
    <div class="notif-card unread type-sistem">
        <div class="notif-icon sistem">
            <i class="fa-solid fa-circle-check"></i>
        </div>
        <div class="notif-content">
            <div class="notif-top">
                <span class="notif-type-label sistem">Sistem</span>
                <span class="notif-time">
                    <i class="fa-regular fa-clock" style="font-size:10px;"></i>
                    1 hari yang lalu
                </span>
            </div>
            <p class="notif-body">
                Selamat bergabung di <strong style="color:var(--ink);">Sport Center</strong>!
                Akun Anda telah aktif. Mulai lengkapi koleksi olahraga favoritmu sekarang.
            </p>
            <a href="<?= base_url('pelanggan/dashboard') ?>" class="notif-action">
                <i class="fa-solid fa-store"></i>
                Mulai Belanja
            </a>
        </div>
    </div>

    <!-- Jika tidak ada notifikasi sama sekali, tampilkan ini -->
    <!-- Uncomment jika ingin empty state dinamis:
    <div class="notif-empty">
        <i class="fa-regular fa-bell-slash"></i>
        <p>Belum ada notifikasi untuk Anda.</p>
    </div>
    -->

</div>

<?= $this->endSection() ?>