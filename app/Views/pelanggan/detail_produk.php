<?= $this->extend('layout/pelanggan_layout') ?>

<?= $this->section('content') ?>
<style>
    /* ============================================================
       DETAIL PRODUK — Dark Mode
       ============================================================ */

    .detail-wrapper {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        align-items: start;
        max-width: 960px;
    }

    /* ── GALERI ── */
    .product-gallery { position: sticky; top: 24px; }

    .gallery-main {
        border-radius: var(--radius-xl);
        overflow: hidden;
        aspect-ratio: 1 / 1;
        background: var(--surface-raised);
        border: 1px solid var(--border);
        position: relative;
    }
    .gallery-main img {
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    .gallery-main:hover img { transform: scale(1.03); }

    .detail-discount-badge {
        position: absolute;
        top: 14px; left: 14px;
        background: #ef4444;
        color: #fff;
        padding: 4px 12px;
        border-radius: var(--radius-pill);
        font-size: 12px; font-weight: 700;
        z-index: 2;
        box-shadow: 0 2px 8px rgba(239,68,68,0.45);
        display: flex; align-items: center; gap: 5px;
    }

    .btn-back {
        position: absolute;
        top: 14px; right: 14px;
        width: 36px; height: 36px;
        border-radius: 50%;
        background: rgba(15,23,42,0.75);
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
        border: 1px solid var(--border);
        display: flex; align-items: center; justify-content: center;
        color: var(--ink);
        text-decoration: none;
        font-size: 13px;
        z-index: 2;
        transition: background var(--transition), transform var(--transition);
        box-shadow: var(--shadow-sm);
    }
    .btn-back:hover { background: rgba(30,41,59,0.95); transform: scale(1.08); }

    /* ── INFO PRODUK ── */
    .product-info {
        display: flex; flex-direction: column;
        gap: 22px;
        padding-top: 4px;
    }

    .detail-category {
        display: inline-flex;
        align-items: center; gap: 6px;
        background: var(--brand-subtle);
        color: var(--brand);
        padding: 4px 12px;
        border-radius: var(--radius-pill);
        font-size: 11.5px; font-weight: 600;
        letter-spacing: 0.5px;
        width: fit-content;
        border: 1px solid rgba(249,115,22,0.2);
    }

    .detail-name {
        font-size: 28px; font-weight: 800;
        letter-spacing: -0.8px;
        color: var(--ink);
        line-height: 1.2; margin: 0;
    }

    /* Price box */
    .detail-price-box {
        display: flex; flex-direction: column; gap: 4px;
        padding: 16px 20px;
        background: var(--surface-raised);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border);
    }
    .detail-price-label {
        font-size: 11px; font-weight: 600;
        color: var(--ink-muted);
        text-transform: uppercase; letter-spacing: 0.8px;
    }
    .detail-old-price {
        font-size: 14px; color: var(--ink-muted);
        text-decoration: line-through;
    }
    .detail-main-price {
        font-size: 32px; font-weight: 800;
        letter-spacing: -1px; color: var(--brand); line-height: 1;
    }
    .detail-main-price.no-discount { color: var(--ink); }
    .detail-savings {
        display: inline-flex; align-items: center; gap: 5px;
        font-size: 12px; font-weight: 600;
        color: #4ade80;
        background: rgba(34,197,94,0.12);
        border: 1px solid rgba(74,222,128,0.2);
        padding: 3px 10px;
        border-radius: var(--radius-pill);
        width: fit-content; margin-top: 4px;
    }

    /* ── SIZE ── */
    .size-section { display: flex; flex-direction: column; gap: 12px; }
    .size-section-label { display: flex; justify-content: space-between; align-items: center; }
    .size-section-label span { font-size: 14px; font-weight: 700; color: var(--ink); }
    .size-guide-link { font-size: 12px; color: var(--brand); text-decoration: none; font-weight: 500; }
    .size-guide-link:hover { text-decoration: underline; }

    .size-options { display: flex; gap: 8px; flex-wrap: wrap; }

    .size-label { cursor: pointer; }
    .size-label input[type="radio"] { position: absolute; opacity: 0; pointer-events: none; }
    .size-chip {
        display: flex; align-items: center; justify-content: center;
        min-width: 52px; height: 44px; padding: 0 14px;
        border: 1.5px solid var(--border);
        border-radius: var(--radius-md);
        font-size: 13.5px; font-weight: 600;
        color: var(--ink-secondary);
        background: var(--surface-raised);
        transition: border-color var(--transition), color var(--transition),
                    background var(--transition), transform var(--transition);
        user-select: none;
    }
    .size-chip:hover {
        border-color: var(--brand);
        color: var(--brand);
        background: var(--brand-subtle);
    }
    .size-label input[type="radio"]:checked + .size-chip {
        border-color: var(--brand);
        background: var(--brand);
        color: #fff;
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(249,115,22,0.35);
    }

    .size-error {
        display: none;
        align-items: center; gap: 6px;
        font-size: 12.5px; color: #f87171; font-weight: 500;
    }
    .size-error.show { display: flex; }

    /* ── DESKRIPSI ── */
    .desc-section { display: flex; flex-direction: column; gap: 10px; }
    .desc-label { font-size: 14px; font-weight: 700; color: var(--ink); }
    .desc-text {
        font-size: 14px; color: var(--ink-secondary); line-height: 1.7;
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .desc-text.expanded { display: block; -webkit-line-clamp: unset; }
    .desc-toggle {
        background: none; border: none;
        font-family: 'Outfit', sans-serif;
        font-size: 13px; color: var(--brand); font-weight: 600;
        cursor: pointer; padding: 0; width: fit-content;
    }

    /* ── SPESIFIKASI PRODUK ──
       ✦ TAMBAHAN: tabel info Merk, Bahan, Warna, Berat, Kategori, Ukuran
       Mengikuti pola visual detail-price-box (surface-raised + border) */
    .spec-section { display: flex; flex-direction: column; gap: 12px; }
    .spec-label { font-size: 14px; font-weight: 700; color: var(--ink); }
    .spec-table {
        display: flex;
        flex-direction: column;
        background: var(--surface-raised);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        overflow: hidden;
    }
    .spec-row {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 12px 16px;
        border-bottom: 1px solid var(--border-light);
    }
    .spec-row:last-child { border-bottom: none; }
    .spec-icon {
        width: 32px; height: 32px;
        border-radius: var(--radius-sm);
        background: var(--brand-subtle);
        color: var(--brand);
        display: flex; align-items: center; justify-content: center;
        font-size: 13px;
        flex-shrink: 0;
    }
    .spec-key {
        font-size: 12.5px;
        font-weight: 600;
        color: var(--ink-secondary);
        width: 120px;
        flex-shrink: 0;
    }
    .spec-val {
        font-size: 13.5px;
        font-weight: 600;
        color: var(--ink);
        flex: 1;
    }
    .spec-val.muted { color: var(--ink-muted); font-weight: 400; font-style: italic; }

    /* Chip ukuran kecil di dalam spec-val */
    .spec-size-chip {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 28px;
        padding: 2px 8px;
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        font-size: 11.5px;
        font-weight: 700;
        color: var(--ink-secondary);
        background: var(--surface);
        margin-right: 4px;
    }

    /* ── ACTIONS ── */
    .action-sticky {
        display: flex; gap: 10px;
        position: sticky;
        bottom: 24px;
        background: rgba(11,17,32,0.92);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-top: 1px solid var(--border);
        padding: 16px 0 4px;
        margin-top: auto;
    }

    .btn-buy-now {
        flex: 1;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        background: var(--brand); color: #fff;
        border: none;
        border-radius: var(--radius-md);
        padding: 14px 20px;
        font-family: 'Outfit', sans-serif;
        font-size: 15px; font-weight: 700;
        cursor: pointer;
        transition: background var(--transition), transform var(--transition), box-shadow var(--transition);
        box-shadow: 0 6px 20px rgba(249,115,22,0.30);
    }
    .btn-buy-now:hover {
        background: var(--brand-dark);
        transform: translateY(-1px);
        box-shadow: 0 8px 24px rgba(249,115,22,0.40);
    }
    .btn-buy-now:active { transform: translateY(0); }

    .btn-keranjang {
        display: flex; align-items: center; justify-content: center; gap: 8px;
        background: var(--surface-raised);
        color: var(--ink);
        border: 1.5px solid var(--border);
        border-radius: var(--radius-md);
        padding: 14px 18px;
        font-family: 'Outfit', sans-serif;
        font-size: 14px; font-weight: 600;
        cursor: pointer;
        transition: background var(--transition), border-color var(--transition);
        text-decoration: none; white-space: nowrap;
    }
    .btn-keranjang:hover { background: var(--surface-high); border-color: rgba(255,255,255,0.2); }

    /* ── RESPONSIVE ── */
    @media (max-width: 768px) {
        .detail-wrapper { grid-template-columns: 1fr; gap: 20px; }
        .product-gallery { position: static; }
        .gallery-main { aspect-ratio: 4/3; border-radius: var(--radius-lg); }
        .detail-name { font-size: 22px; }
        .detail-main-price { font-size: 26px; }
        .action-sticky {
            position: fixed;
            bottom: 76px;
            left: 0; right: 0;
            padding: 10px 16px;
            margin: 0;
            background: rgba(11,17,32,0.97);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-top: 1px solid var(--border);
            border-radius: 0;
            box-shadow: 0 -4px 20px rgba(0,0,0,0.3);
            z-index: 50;
        }
        .product-info { padding-bottom: 100px; }
        .spec-key { width: 96px; font-size: 12px; }
        .spec-val { font-size: 13px; }
    }
</style>

<div class="detail-wrapper">

    <!-- GAMBAR -->
    <div class="product-gallery">
        <div class="gallery-main">
            <a href="javascript:history.back()" class="btn-back" title="Kembali">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <?php if (isset($produk['diskon']) && $produk['diskon'] > 0) : ?>
                <div class="detail-discount-badge">
                    <i class="fa-solid fa-tag"></i>
                    Hemat <?= $produk['diskon'] ?>%
                </div>
            <?php endif; ?>
            <img src="<?= base_url('images/' . $produk['gambar']) ?>"
                 alt="<?= esc($produk['nama_produk']) ?>">
        </div>
    </div>

    <!-- INFO -->
    <div class="product-info">

        <div class="detail-category">
            <i class="fa-solid fa-tag" style="font-size:10px;"></i>
            <?= esc($produk['nama_kategori'] ?? 'Produk Sport') ?>
        </div>

        <h1 class="detail-name"><?= esc($produk['nama_produk']) ?></h1>

        <div class="detail-price-box">
            <span class="detail-price-label">Harga</span>
            <?php if (isset($produk['diskon']) && $produk['diskon'] > 0) :
                $potongan   = $produk['harga'] * ($produk['diskon'] / 100);
                $hargaPromo = $produk['harga'] - $potongan;
            ?>
                <span class="detail-old-price">Rp <?= number_format($produk['harga'], 0, ',', '.') ?></span>
                <span class="detail-main-price">Rp <?= number_format($hargaPromo, 0, ',', '.') ?></span>
                <span class="detail-savings">
                    <i class="fa-solid fa-circle-check" style="font-size:11px;"></i>
                    Hemat Rp <?= number_format($potongan, 0, ',', '.') ?>
                </span>
            <?php else : ?>
                <span class="detail-main-price no-discount">Rp <?= number_format($produk['harga'], 0, ',', '.') ?></span>
            <?php endif; ?>
        </div>

        <div class="size-section">
            <div class="size-section-label">
                <span>Pilih Ukuran</span>
                <a href="#" class="size-guide-link">Panduan Ukuran →</a>
            </div>
            <div class="size-options" id="sizeOptions">
                <?php foreach ($ukuran as $u) : ?>
                    <label class="size-label">
                        <input type="radio" name="selected_size" value="<?= $u['id'] ?>" id="size<?= $u['id'] ?>">
                        <span class="size-chip"><?= esc($u['ukuran']) ?></span>
                    </label>
                <?php endforeach; ?>
            </div>
            <div class="size-error" id="sizeError">
                <i class="fa-solid fa-circle-exclamation"></i>
                Silakan pilih ukuran terlebih dahulu.
            </div>
        </div>

        <!-- ✦ TAMBAHAN: Spesifikasi Produk (Merk, Bahan, Ukuran, Warna, Berat, Kategori) -->
        <div class="spec-section">
            <span class="spec-label">Spesifikasi Produk</span>
            <div class="spec-table">

                <div class="spec-row">
                    <span class="spec-icon"><i class="fa-solid fa-copyright"></i></span>
                    <span class="spec-key">Merk</span>
                    <span class="spec-val<?= empty($produk['merk']) ? ' muted' : '' ?>">
                        <?= !empty($produk['merk']) ? esc($produk['merk']) : '— Tidak ada data' ?>
                    </span>
                </div>

                <div class="spec-row">
                    <span class="spec-icon"><i class="fa-solid fa-layer-group"></i></span>
                    <span class="spec-key">Bahan</span>
                    <span class="spec-val<?= empty($produk['bahan']) ? ' muted' : '' ?>">
                        <?= !empty($produk['bahan']) ? esc($produk['bahan']) : '— Tidak ada data' ?>
                    </span>
                </div>

                <div class="spec-row">
                    <span class="spec-icon"><i class="fa-solid fa-ruler"></i></span>
                    <span class="spec-key">Ukuran</span>
                    <span class="spec-val">
                        <?php if (!empty($ukuran)) : ?>
                            <?php foreach ($ukuran as $u) : ?>
                                <span class="spec-size-chip"><?= esc($u['ukuran']) ?></span>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <span class="muted">— Tidak ada data</span>
                        <?php endif; ?>
                    </span>
                </div>

                <div class="spec-row">
                    <span class="spec-icon"><i class="fa-solid fa-palette"></i></span>
                    <span class="spec-key">Warna</span>
                    <span class="spec-val<?= empty($produk['warna']) ? ' muted' : '' ?>">
                        <?= !empty($produk['warna']) ? esc($produk['warna']) : '— Tidak ada data' ?>
                    </span>
                </div>

                <div class="spec-row">
                    <span class="spec-icon"><i class="fa-solid fa-weight-hanging"></i></span>
                    <span class="spec-key">Berat</span>
                    <span class="spec-val<?= empty($produk['berat']) ? ' muted' : '' ?>">
                        <?= !empty($produk['berat']) ? esc($produk['berat']) . ' gram' : '— Tidak ada data' ?>
                    </span>
                </div>

                <div class="spec-row">
                    <span class="spec-icon"><i class="fa-solid fa-tags"></i></span>
                    <span class="spec-key">Kategori</span>
                    <span class="spec-val<?= empty($produk['nama_kategori']) ? ' muted' : '' ?>">
                        <?= !empty($produk['nama_kategori']) ? esc($produk['nama_kategori']) : '— Tidak ada data' ?>
                    </span>
                </div>

            </div>
        </div>

        <div class="desc-section">
            <span class="desc-label">Deskripsi Produk</span>
            <p class="desc-text" id="descText"><?= nl2br(esc($produk['deskripsi'])) ?></p>
            <button class="desc-toggle" id="descToggle" onclick="toggleDesc()">Baca selengkapnya ↓</button>
        </div>

        <div class="action-sticky">
            <button class="btn-buy-now" onclick="goToCheckout()">
                <i class="fa-solid fa-bolt"></i> Beli Sekarang
            </button>
            <form action="<?= session()->get('isLoggedIn') ? base_url('pelanggan/tambah_keranjang') : base_url('auth/register') ?>"
                  method="<?= session()->get('isLoggedIn') ? 'POST' : 'GET' ?>"
                  id="cartForm" style="margin:0;display:flex;">
                <?= csrf_field() ?>
                <input type="hidden" name="product_id" value="<?= $produk['id'] ?>">
                <input type="hidden" name="size_id" id="cartSizeInput" value="">
                <button type="button" class="btn-keranjang" onclick="addToCart()">
                    <i class="fa-solid fa-cart-plus"></i> Keranjang
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    const isLoggedIn   = <?= session()->get('isLoggedIn') ? 'true' : 'false' ?>;
    const checkoutBase = "<?= base_url('pelanggan/ringkasan_pesanan') ?>/<?= $produk['id'] ?>/";

    function getSelectedSize() {
        const checked = document.querySelector('input[name="selected_size"]:checked');
        return checked ? checked.value : null;
    }
    function showSizeError() {
        const err = document.getElementById('sizeError');
        err.classList.add('show');
        document.getElementById('sizeOptions').scrollIntoView({ behavior: 'smooth', block: 'center' });
        document.querySelectorAll('input[name="selected_size"]').forEach(r => {
            r.addEventListener('change', () => err.classList.remove('show'), { once: true });
        });
    }
    function goToCheckout() {
        if (!isLoggedIn) { window.location.href = "<?= base_url('auth/register') ?>"; return; }
        const size = getSelectedSize();
        if (!size) { showSizeError(); return; }
        window.location.href = checkoutBase + size;
    }
    function addToCart() {
        if (!isLoggedIn) { window.location.href = "<?= base_url('auth/register') ?>"; return; }
        const size = getSelectedSize();
        if (!size) { showSizeError(); return; }
        document.getElementById('cartSizeInput').value = size;
        document.getElementById('cartForm').submit();
    }
    function toggleDesc() {
        const txt = document.getElementById('descText');
        const btn = document.getElementById('descToggle');
        btn.textContent = txt.classList.toggle('expanded') ? 'Sembunyikan ↑' : 'Baca selengkapnya ↓';
    }
</script>

<?= $this->endSection() ?>