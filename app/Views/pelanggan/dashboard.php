<?= $this->extend('layout/pelanggan_layout') ?>

<?= $this->section('content') ?>
<style>
    /* ============================================================
       DASHBOARD — Marketplace Style (Dark Mode)
       Token warna mengacu ke :root di pelanggan_layout.php
       ============================================================ */

    /* ── HEADER ── */
    .dash-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
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

    /* ── STICKY SEARCH BAR (mobile only) ── */
    .mobile-search-sticky {
        display: none;
        position: sticky;
        top: 0;
        z-index: 40;
        background: var(--bg);
        padding: 10px 0 12px;
        margin: -16px -16px 12px;
        padding-left: 16px;
        padding-right: 16px;
    }
    .mobile-search-sticky .search-box { width: 100%; }

    /* ── PROMO BANNER ── */
    .promo-banner {
        background: linear-gradient(135deg, #ea580c 0%, #c2410c 45%, #991b1b 100%);
        border-radius: var(--radius-xl);
        padding: 36px 44px;
        color: #fff;
        margin-bottom: 24px;
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

    /* ── KATEGORI CHIP (khas marketplace) ── */
    .kategori-scroll {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        padding: 2px 2px 16px;
        margin-bottom: 8px;
        scrollbar-width: none;
    }
    .kategori-scroll::-webkit-scrollbar { display: none; }
    .kategori-chip {
        flex-shrink: 0;
        display: flex;
        align-items: center;
        gap: 8px;
        background: var(--surface);
        border: 1.5px solid var(--border);
        color: var(--ink-secondary);
        padding: 9px 18px;
        border-radius: var(--radius-pill);
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        white-space: nowrap;
        transition: background var(--transition), color var(--transition), border-color var(--transition);
        user-select: none;
    }
    .kategori-chip i { font-size: 12px; }
    .kategori-chip:hover { border-color: rgba(249,115,22,0.4); color: var(--ink); }
    .kategori-chip.active {
        background: var(--brand);
        border-color: var(--brand);
        color: #fff;
        box-shadow: 0 4px 14px rgba(249,115,22,0.35);
    }

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
    .product-card:active { transform: translateY(-1px) scale(0.99); }

    .product-img-wrap {
        position: relative;
        overflow: hidden;
        aspect-ratio: 1 / 1;
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

    /* ── STOK HABIS ── */
    .product-card.habis .product-img-wrap img { filter: grayscale(1) brightness(0.55); }
    .habis-overlay {
        position: absolute;
        inset: 0;
        z-index: 3;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .habis-overlay span {
        background: rgba(15,23,42,0.85);
        border: 1px solid rgba(255,255,255,0.15);
        color: #fff;
        font-size: 11.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        padding: 5px 14px;
        border-radius: var(--radius-pill);
    }
    .btn-add.is-disabled,
    .btn-buy.is-disabled {
        pointer-events: none;
        opacity: 0.4;
        cursor: not-allowed;
        box-shadow: none;
    }

    .product-body {
        padding: 12px 14px 14px;
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
        font-size: 13.5px;
        font-weight: 700;
        color: var(--ink);
        line-height: 1.35;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 4px;
        min-height: 36px;
    }

    .price-row { display: flex; flex-direction: column; gap: 1px; margin-bottom: 6px; margin-top: auto; }
    .old-price  { font-size: 11.5px; color: var(--ink-muted); text-decoration: line-through; }
    .new-price  { font-size: 16px; font-weight: 800; color: var(--brand); letter-spacing: -0.3px; }
    .normal-price { font-size: 16px; font-weight: 800; color: var(--ink); letter-spacing: -0.3px; }

    /* Meta seperti marketplace: rating & lokasi (opsional, tampil jika data ada) */
    .product-meta {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        color: var(--ink-muted);
        margin-bottom: 8px;
    }
    .product-meta .stars { color: #facc15; }

    .card-actions { display: flex; flex-direction: column; gap: 8px; }
    .card-actions-row { display: flex; gap: 8px; }
    .btn-detail {
        flex: 1;
        font-size: 12px;
        font-weight: 600;
        font-family: 'Outfit', sans-serif;
        text-align: center;
        text-decoration: none;
        color: var(--brand);
        border: 1.5px solid rgba(249,115,22,0.5);
        padding: 8px 10px;
        border-radius: var(--radius-md);
        transition: background var(--transition), color var(--transition), border-color var(--transition);
        display: flex; align-items: center; justify-content: center; gap: 6px;
    }
    .btn-detail:hover { background: var(--brand); color: #fff; border-color: var(--brand); }

    .btn-add {
        background: var(--surface-raised);
        color: var(--ink);
        border: 1.5px solid var(--border);
        width: 36px; height: 36px;
        border-radius: var(--radius-md);
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        transition: background var(--transition), color var(--transition), transform var(--transition);
        flex-shrink: 0; font-size: 13px;
    }
    .btn-add:hover { background: var(--brand); color: #fff; border-color: var(--brand); transform: scale(1.07); }
    .btn-add:active { transform: scale(0.96); }

    .btn-buy {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        background: var(--brand);
        color: #fff;
        text-decoration: none;
        font-size: 12px;
        font-weight: 700;
        font-family: 'Outfit', sans-serif;
        padding: 8px 10px;
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

    /* ── FLOATING CART BUTTON (khas app marketplace mobile) ── */
    .fab-cart {
        display: none;
        position: fixed;
        right: 16px;
        bottom: 86px;
        width: 54px; height: 54px;
        border-radius: 50%;
        background: var(--brand);
        color: #fff;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        text-decoration: none;
        box-shadow: 0 8px 24px rgba(249,115,22,0.45);
        z-index: 90;
        transition: transform var(--transition);
    }
    .fab-cart:active { transform: scale(0.92); }
    .fab-cart .fab-badge {
        position: absolute;
        top: -4px; right: -4px;
        background: #ef4444;
        color: #fff;
        font-size: 10px;
        font-weight: 800;
        min-width: 18px;
        height: 18px;
        border-radius: 999px;
        display: flex; align-items: center; justify-content: center;
        padding: 0 4px;
        border: 2px solid var(--bg);
    }

    /* ── RESPONSIVE ── */
    @media (max-width: 768px) {
        .dash-header { flex-direction: column; align-items: flex-start; gap: 10px; }
        .dash-header .search-box { display: none; } /* diganti sticky search di bawah */
        .mobile-search-sticky { display: block; }
        .promo-banner { padding: 24px 20px; border-radius: var(--radius-lg); margin-bottom: 18px; }
        .promo-banner h2 { font-size: 20px; }
        .promo-banner p { font-size: 13px; }
        .kategori-scroll { margin: 0 -16px 16px; padding-left: 16px; padding-right: 16px; }
        .product-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
        .product-body { padding: 10px 11px 12px; }
        .product-name { font-size: 12.5px; min-height: 32px; }
        .new-price, .normal-price { font-size: 14.5px; }
        .btn-detail span { display: none; }
        .fab-cart { display: flex; }
    }
    @media (max-width: 400px) {
        .product-grid { grid-template-columns: 1fr 1fr; gap: 8px; }
    }
</style>

<!-- SEARCH STICKY (khusus mobile) -->
<div class="mobile-search-sticky">
    <div class="search-box">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" id="searchInputMobile" placeholder="Cari produk sport favoritmu..." autocomplete="off">
    </div>
</div>

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

<!-- KATEGORI CHIP -->
<div class="kategori-scroll" id="kategoriScroll">
    <div class="kategori-chip active" data-kategori="semua">
        <i class="fa-solid fa-border-all"></i> Semua
    </div>
    <div class="kategori-chip" data-kategori="1">
        <i class="fa-solid fa-socks"></i> Celana Pendek
    </div>
    <div class="kategori-chip" data-kategori="2">
        <i class="fa-solid fa-shirt"></i> Celana Panjang
    </div>
    <div class="kategori-chip" data-kategori="diskon">
        <i class="fa-solid fa-tags"></i> Lagi Diskon
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
            // total_stok hanya ada jika query controller sudah JOIN product_sizes.
            // Jika belum ada datanya, anggap tersedia (tidak menganggu tampilan lama).
            $stokHabis = isset($p['total_stok']) && (int) $p['total_stok'] <= 0;
        ?>
        <div class="product-card<?= $stokHabis ? ' habis' : '' ?>"
             data-name="<?= strtolower(esc($p['nama_produk'])) ?>"
             data-category="<?= (int) $p['category_id'] ?>"
             data-diskon="<?= $hasDiskon ? 1 : 0 ?>">

            <div class="product-img-wrap">
                <?php if ($hasDiskon && !$stokHabis) : ?>
                    <div class="discount-badge">
                        <i class="fa-solid fa-tag"></i><?= $p['diskon'] ?>%
                    </div>
                <?php endif; ?>
                <?php if ($stokHabis) : ?>
                    <div class="habis-overlay"><span>Stok Habis</span></div>
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

                <?php if (isset($p['rating']) && $p['rating'] > 0) : ?>
                <div class="product-meta">
                    <span class="stars"><i class="fa-solid fa-star"></i> <?= number_format($p['rating'], 1) ?></span>
                    <?php if (isset($p['total_terjual'])): ?>
                        <span>· <?= (int)$p['total_terjual'] ?> terjual</span>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

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
                            <button type="submit" class="btn-add<?= $stokHabis ? ' is-disabled' : '' ?>"
                                    title="Tambah ke keranjang" <?= $stokHabis ? 'disabled' : '' ?>>
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </form>
                    </div>

                    <a href="<?= $stokHabis ? 'javascript:void(0)' : (session()->get('isLoggedIn')
                            ? base_url('pelanggan/detail/' . $p['id'])
                            : base_url('auth/register')) ?>"
                       class="btn-buy<?= $stokHabis ? ' is-disabled' : '' ?>">
                        <i class="fa-solid fa-bolt"></i>
                        <?= $stokHabis ? 'Stok Habis' : 'Beli Sekarang' ?>
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- FLOATING CART BUTTON (mobile) -->
<a href="<?= base_url('pelanggan/keranjang') ?>" class="fab-cart" title="Keranjang">
    <i class="fa-solid fa-bag-shopping"></i>
</a>

<script>
    const productGrid  = document.getElementById('productGrid');
    const productCount = document.getElementById('productCount');
    const allCards     = [...document.querySelectorAll('.product-card')];
    const searchInput       = document.getElementById('searchInput');
    const searchInputMobile = document.getElementById('searchInputMobile');
    const kategoriChips     = document.querySelectorAll('.kategori-chip');

    let currentKategori = 'semua';
    let currentQuery    = '';

    function applyFilter() {
        const q = currentQuery.toLowerCase().trim();
        let visible = 0;

        allCards.forEach(card => {
            const matchName = card.dataset.name.includes(q);

            let matchKategori = true;
            if (currentKategori === 'diskon') {
                matchKategori = card.dataset.diskon === '1';
            } else if (currentKategori !== 'semua') {
                matchKategori = card.dataset.category === currentKategori;
            }

            const match = matchName && matchKategori;
            card.style.display = match ? '' : 'none';
            if (match) visible++;
        });

        productCount.textContent = visible + ' produk';

        let emptyEl = productGrid.querySelector('.search-empty');
        if (visible === 0) {
            if (!emptyEl) {
                emptyEl = document.createElement('div');
                emptyEl.className = 'empty-state search-empty';
                emptyEl.innerHTML = `<i class="fa-solid fa-magnifying-glass"></i>
                    <p>Produk tidak ditemukan${q ? ' untuk "<strong>' + q + '</strong>"' : ''}.</p>`;
                productGrid.appendChild(emptyEl);
            }
        } else {
            emptyEl && emptyEl.remove();
        }
    }

    /* ── Live search: dua input (desktop & mobile) saling sinkron ── */
    function bindSearch(input) {
        input.addEventListener('input', () => {
            currentQuery = input.value;
            if (searchInput && input !== searchInput) searchInput.value = input.value;
            if (searchInputMobile && input !== searchInputMobile) searchInputMobile.value = input.value;
            applyFilter();
        });
    }
    if (searchInput) bindSearch(searchInput);
    if (searchInputMobile) bindSearch(searchInputMobile);

    /* ── Filter kategori ── */
    kategoriChips.forEach(chip => {
        chip.addEventListener('click', () => {
            kategoriChips.forEach(c => c.classList.remove('active'));
            chip.classList.add('active');
            currentKategori = chip.dataset.kategori;
            applyFilter();
        });
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