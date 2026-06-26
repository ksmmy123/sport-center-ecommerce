<?= $this->extend('layout/pelanggan_layout') ?>

<?= $this->section('content') ?>
<style>
    /* ============================================================
       DASHBOARD — Dark Mode Content Styles
       Token warna mengacu ke :root di pelanggan_layout.php
       ============================================================ */

    /* ── HEADER ── */
    .dash-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
        gap: 16px;
    }
    .welcome-greeting { font-size: 13px; color: var(--ink-secondary); margin-bottom: 4px; }
    .welcome-name { font-size: 26px; font-weight: 800; letter-spacing: -0.8px; color: var(--ink); line-height: 1.1; }

    /* ── SEARCH ── */
    .search-box {
        display: flex;
        align-items: center;
        gap: 10px;
        background: var(--surface);
        border: 1.5px solid var(--border);
        border-radius: var(--radius-pill);
        padding: 10px 18px;
        width: 280px;
        transition: border-color var(--transition), box-shadow var(--transition);
    }
    .search-box:focus-within {
        border-color: var(--brand);
        box-shadow: 0 0 0 3px var(--brand-glow);
    }
    .search-box i { color: var(--ink-muted); font-size: 14px; flex-shrink: 0; }
    .search-box input {
        border: none;
        background: transparent;
        outline: none;
        font-family: 'Outfit', sans-serif;
        font-size: 14px;
        color: var(--ink);
        width: 100%;
    }
    .search-box input::placeholder { color: var(--ink-muted); }

    /* ── PROMO BANNER ── */
    .promo-banner {
        background: linear-gradient(135deg, #ea580c 0%, #c2410c 45%, #991b1b 100%);
        border-radius: var(--radius-xl);
        padding: 36px 44px;
        color: #fff;
        margin-bottom: 40px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 12px 40px rgba(249,115,22,0.22);
        border: 1px solid rgba(249,115,22,0.25);
    }
    .promo-banner::before {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 260px; height: 260px;
        border-radius: 50%;
        background: rgba(255,255,255,0.07);
        pointer-events: none;
    }
    .promo-banner::after {
        content: '';
        position: absolute;
        bottom: -80px; right: 120px;
        width: 180px; height: 180px;
        border-radius: 50%;
        background: rgba(255,255,255,0.05);
        pointer-events: none;
    }
    .promo-banner-inner { position: relative; z-index: 1; }
    .promo-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(4px);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: var(--radius-pill);
        padding: 4px 12px;
        font-size: 11.5px;
        font-weight: 600;
        letter-spacing: 0.5px;
        margin-bottom: 12px;
    }
    .promo-banner h2 { font-size: 30px; font-weight: 800; letter-spacing: -1px; margin-bottom: 10px; line-height: 1.15; }
    .promo-banner p  { font-size: 14.5px; opacity: 0.85; margin-bottom: 20px; }
    .promo-code {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255,255,255,0.12);
        border: 1.5px dashed rgba(255,255,255,0.35);
        border-radius: var(--radius-md);
        padding: 8px 16px;
        font-size: 15px;
        font-weight: 800;
        letter-spacing: 2px;
        cursor: pointer;
        transition: background var(--transition);
        width: fit-content;
    }
    .promo-code:hover { background: rgba(255,255,255,0.22); }

    /* ── SECTION HEADER ── */
    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }
    .section-title { font-size: 18px; font-weight: 700; letter-spacing: -0.4px; color: var(--ink); }
    .section-count { font-size: 13px; color: var(--ink-secondary); }

    /* ── PRODUCT GRID ── */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
        gap: 16px;
    }

    /* ── PRODUCT CARD ── */
    .product-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        overflow: hidden;
        transition: transform var(--transition), box-shadow var(--transition), border-color var(--transition);
        display: flex;
        flex-direction: column;
        position: relative;
    }
    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
        border-color: rgba(255,255,255,0.14);
    }

    .product-img-wrap {
        position: relative;
        overflow: hidden;
        height: 200px;
        background: var(--surface-raised);
    }
    .product-img-wrap img {
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    .product-card:hover .product-img-wrap img { transform: scale(1.04); }
    .product-img-wrap::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 60px;
        background: linear-gradient(to top, rgba(15,23,42,0.6), transparent);
        pointer-events: none;
    }

    .discount-badge {
        position: absolute;
        top: 10px; right: 10px;
        background: #ef4444;
        color: #fff;
        padding: 3px 9px;
        border-radius: var(--radius-pill);
        font-size: 11px;
        font-weight: 700;
        z-index: 2;
        box-shadow: 0 2px 8px rgba(239,68,68,0.45);
        display: flex; align-items: center; gap: 4px;
    }

    .product-body {
        padding: 14px 16px 16px;
        display: flex;
        flex-direction: column;
        flex: 1;
        gap: 4px;
    }
    .product-category {
        font-size: 10.5px;
        font-weight: 600;
        color: var(--ink-muted);
        text-transform: uppercase;
        letter-spacing: 0.8px;
    }
    .product-name {
        font-size: 14.5px;
        font-weight: 700;
        color: var(--ink);
        line-height: 1.35;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 6px;
    }

    .price-row { display: flex; flex-direction: column; gap: 1px; margin-bottom: 14px; margin-top: auto; }
    .old-price  { font-size: 12px; color: var(--ink-muted); text-decoration: line-through; }
    .new-price  { font-size: 18px; font-weight: 800; color: var(--brand); letter-spacing: -0.3px; }
    .normal-price { font-size: 18px; font-weight: 800; color: var(--ink); letter-spacing: -0.3px; }

    .card-actions { display: flex; flex-direction: column; gap: 8px; }
    .card-actions-row { display: flex; gap: 8px; }
    .btn-detail {
        flex: 1;
        font-size: 12.5px;
        font-weight: 600;
        font-family: 'Outfit', sans-serif;
        text-align: center;
        text-decoration: none;
        color: var(--brand);
        border: 1.5px solid rgba(249,115,22,0.5);
        padding: 9px 10px;
        border-radius: var(--radius-md);
        transition: background var(--transition), color var(--transition), border-color var(--transition);
        display: flex; align-items: center; justify-content: center; gap: 6px;
    }
    .btn-detail:hover { background: var(--brand); color: #fff; border-color: var(--brand); }

    .btn-add {
        background: var(--surface-raised);
        color: var(--ink);
        border: 1.5px solid var(--border);
        width: 38px; height: 38px;
        border-radius: var(--radius-md);
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        transition: background var(--transition), color var(--transition), transform var(--transition);
        flex-shrink: 0; font-size: 14px;
    }
    .btn-add:hover { background: var(--brand); color: #fff; border-color: var(--brand); transform: scale(1.07); }
    .btn-add:active { transform: scale(0.96); }

    /* ✦ TAMBAHAN: Tombol Beli Sekarang — full width, baris kedua */
    .btn-buy {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        background: var(--brand);
        color: #fff;
        text-decoration: none;
        font-size: 12.5px;
        font-weight: 700;
        font-family: 'Outfit', sans-serif;
        padding: 9px 10px;
        border-radius: var(--radius-md);
        border: none;
        cursor: pointer;
        width: 100%;
        box-shadow: 0 3px 10px rgba(249,115,22,0.25);
        transition: background var(--transition), transform var(--transition), box-shadow var(--transition);
    }
    .btn-buy:hover {
        background: var(--brand-dark);
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(249,115,22,0.35);
    }
    .btn-buy:active { transform: translateY(0); }

    /* ── EMPTY STATE ── */
    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 80px 20px;
        color: var(--ink-secondary);
    }
    .empty-state i { font-size: 48px; color: var(--ink-muted); margin-bottom: 16px; display: block; }
    .empty-state p { font-size: 15px; }

    /* ── RESPONSIVE ── */
    @media (max-width: 768px) {
        .dash-header { flex-direction: column; align-items: flex-start; gap: 14px; }
        .search-box { width: 100%; }
        .promo-banner { padding: 28px 24px; }
        .promo-banner h2 { font-size: 22px; }
        .product-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
        .product-img-wrap { height: 140px; }
        .btn-detail span { display: none; }
    }
    @media (max-width: 400px) {
        .product-grid { grid-template-columns: 1fr; }
    }
</style>

<!-- HEADER -->
<div class="dash-header">
    <div>
        <p class="welcome-greeting">Selamat datang kembali 👋</p>
        <h2 class="welcome-name"><?= esc(session()->get('username') ?: 'Pelanggan') ?></h2>
    </div>
    <div class="search-box">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" id="searchInput" placeholder="Cari produk..." autocomplete="off">
    </div>
</div>

<!-- PROMO BANNER -->
<div class="promo-banner">
    <div class="promo-banner-inner">
        <div class="promo-eyebrow">
            <i class="fa-solid fa-bolt"></i>
            Penawaran Terbatas
        </div>
        <h2>New Short Sport 2026</h2>
        <p>Koleksi terbaru untuk tampil sporty setiap hari.</p>
        <div class="promo-code" id="promoCode">
            <i class="fa-regular fa-copy"></i>
            SPORTPRO — diskon 20%
        </div>
    </div>
</div>

<!-- SECTION HEADER -->
<div class="section-header">
    <h3 class="section-title">Produk Terbaru</h3>
    <span class="section-count" id="productCount"><?= count($products) ?> produk</span>
</div>

<!-- PRODUCT GRID -->
<div class="product-grid" id="productGrid">
    <?php if (empty($products)) : ?>
        <div class="empty-state">
            <i class="fa-solid fa-box-open"></i>
            <p>Belum ada produk tersedia.</p>
        </div>
    <?php else : ?>
        <?php foreach ($products as $p) :
            $hasDiskon  = isset($p['diskon']) && $p['diskon'] > 0;
            $hargaPromo = $hasDiskon ? $p['harga'] * (1 - $p['diskon'] / 100) : null;
            if ($p['category_id'] == 1)     $kategori = 'Celana Sport Pendek';
            elseif ($p['category_id'] == 2) $kategori = 'Celana Training Panjang';
            else                            $kategori = 'Produk Lainnya';
        ?>
        <div class="product-card" data-name="<?= strtolower(esc($p['nama_produk'])) ?>">

            <div class="product-img-wrap">
                <?php if ($hasDiskon) : ?>
                    <div class="discount-badge">
                        <i class="fa-solid fa-tag"></i><?= $p['diskon'] ?>%
                    </div>
                <?php endif; ?>
                <a href="<?= base_url('pelanggan/detail/' . $p['id']) ?>" tabindex="-1">
                    <img src="<?= base_url('images/' . $p['gambar']) ?>"
                         alt="<?= esc($p['nama_produk']) ?>" loading="lazy">
                </a>
            </div>

            <div class="product-body">
                <span class="product-category"><?= $kategori ?></span>
                <a href="<?= base_url('pelanggan/detail/' . $p['id']) ?>"
                   style="text-decoration:none; color:inherit;">
                    <span class="product-name"><?= esc($p['nama_produk']) ?></span>
                </a>

                <div class="price-row">
                    <?php if ($hasDiskon) : ?>
                        <span class="old-price">Rp <?= number_format($p['harga'], 0, ',', '.') ?></span>
                        <span class="new-price">Rp <?= number_format($hargaPromo, 0, ',', '.') ?></span>
                    <?php else : ?>
                        <span class="normal-price">Rp <?= number_format($p['harga'], 0, ',', '.') ?></span>
                    <?php endif; ?>
                </div>

                <div class="card-actions">
                    <div class="card-actions-row">
                        <a href="<?= base_url('pelanggan/detail/' . $p['id']) ?>" class="btn-detail">
                            <i class="fa-solid fa-eye"></i>
                            <span>Detail</span>
                        </a>
                        <form action="<?= session()->get('isLoggedIn') ? base_url('pelanggan/tambah_keranjang') : base_url('auth/register') ?>"
                              method="<?= session()->get('isLoggedIn') ? 'POST' : 'GET' ?>"
                              style="margin:0;">
                            <?= csrf_field() ?>
                            <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                            <button type="submit" class="btn-add" title="Tambah ke keranjang">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </form>
                    </div>

                    <!-- ✦ TAMBAHAN: Beli Sekarang — arahkan ke detail untuk pilih ukuran
                         sebelum lanjut ke ringkasan pesanan (sesuai flow checkout) -->
                    <a href="<?= session()->get('isLoggedIn')
                            ? base_url('pelanggan/detail/' . $p['id'])
                            : base_url('auth/register') ?>"
                       class="btn-buy">
                        <i class="fa-solid fa-bolt"></i>
                        Beli Sekarang
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
    /* ── Live search ── */
    const searchInput  = document.getElementById('searchInput');
    const productGrid  = document.getElementById('productGrid');
    const productCount = document.getElementById('productCount');
    const allCards     = [...document.querySelectorAll('.product-card')];

    searchInput.addEventListener('input', () => {
        const q = searchInput.value.toLowerCase().trim();
        let visible = 0;
        allCards.forEach(card => {
            const match = card.dataset.name.includes(q);
            card.style.display = match ? '' : 'none';
            if (match) visible++;
        });
        productCount.textContent = visible + ' produk';
        let emptyEl = productGrid.querySelector('.search-empty');
        if (visible === 0 && q !== '') {
            if (!emptyEl) {
                emptyEl = document.createElement('div');
                emptyEl.className = 'empty-state search-empty';
                emptyEl.innerHTML = `<i class="fa-solid fa-magnifying-glass"></i>
                    <p>Tidak ada produk untuk "<strong>${q}</strong>"</p>`;
                productGrid.appendChild(emptyEl);
            }
        } else { emptyEl && emptyEl.remove(); }
    });

    /* ── Copy promo code ── */
    document.getElementById('promoCode').addEventListener('click', function () {
        navigator.clipboard && navigator.clipboard.writeText('SPORTPRO').then(() => {
            this.innerHTML = `<i class="fa-solid fa-check"></i> Disalin!`;
            setTimeout(() => {
                this.innerHTML = `<i class="fa-regular fa-copy"></i> SPORTPRO — diskon 20%`;
            }, 2000);
        });
    });
</script>

<?= $this->endSection() ?>