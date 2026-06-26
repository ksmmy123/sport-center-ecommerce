<?= $this->extend('layout/pelanggan_layout') ?>

<?= $this->section('content') ?>
<style>
    /* ── PAGE HEADER ── */
    .cart-page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 28px;
    }
    .cart-page-title {
        font-size: 24px;
        font-weight: 800;
        letter-spacing: -0.6px;
        color: var(--ink);
    }
    .cart-count-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--brand-subtle);
        color: var(--brand);
        border: 1px solid rgba(249,115,22,0.2);
        padding: 4px 12px;
        border-radius: var(--radius-pill);
        font-size: 12px;
        font-weight: 600;
    }

    /* ── FLASH MESSAGE ── */
    .flash-error {
        background: rgba(239,68,68,0.12);
        color: #f87171;
        border: 1px solid rgba(239,68,68,0.2);
        padding: 14px 18px;
        border-radius: var(--radius-md);
        margin-bottom: 20px;
        font-size: 13.5px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* ── EMPTY STATE ── */
    .cart-empty {
        text-align: center;
        padding: 80px 20px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-xl);
    }
    .cart-empty i {
        font-size: 52px;
        color: var(--ink-muted);
        margin-bottom: 16px;
        display: block;
    }
    .cart-empty p { font-size: 15px; color: var(--ink-secondary); margin-bottom: 20px; }
    .cart-empty a {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--brand);
        color: #fff;
        text-decoration: none;
        padding: 11px 22px;
        border-radius: var(--radius-md);
        font-size: 13.5px;
        font-weight: 700;
        box-shadow: 0 4px 14px rgba(249,115,22,0.35);
        transition: background var(--transition), transform var(--transition);
    }
    .cart-empty a:hover { background: var(--brand-dark); transform: translateY(-1px); }

    /* ── CART LIST ── */
    .cart-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-bottom: 0;
    }

    .cart-item {
        display: flex;
        align-items: center;
        gap: 14px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 16px;
        transition: border-color var(--transition), box-shadow var(--transition);
    }
    .cart-item:hover {
        border-color: rgba(255,255,255,0.14);
        box-shadow: var(--shadow-sm);
    }

    /* Checkbox custom */
    .checkbox-custom {
        width: 18px; height: 18px;
        accent-color: var(--brand);
        cursor: pointer;
        flex-shrink: 0;
    }

    /* Gambar produk */
    .cart-img {
        width: 72px; height: 72px;
        border-radius: var(--radius-md);
        overflow: hidden;
        background: var(--surface-raised);
        border: 1px solid var(--border);
        flex-shrink: 0;
    }
    .cart-img img { width: 100%; height: 100%; object-fit: cover; }

    /* Info produk */
    .cart-info { flex: 1; min-width: 0; }
    .cart-name {
        font-size: 14.5px;
        font-weight: 700;
        color: var(--ink);
        display: block;
        margin-bottom: 5px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .cart-price {
        font-size: 15px;
        font-weight: 800;
        color: var(--brand);
        letter-spacing: -0.3px;
    }

    /* Qty control */
    .qty-container {
        display: flex;
        align-items: center;
        gap: 10px;
        background: var(--surface-raised);
        border: 1px solid var(--border);
        padding: 6px 12px;
        border-radius: var(--radius-pill);
        flex-shrink: 0;
    }
    .btn-circle {
        width: 28px; height: 28px;
        background: var(--surface-high);
        color: var(--ink);
        border: 1px solid var(--border);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-weight: 700;
        font-size: 14px;
        transition: background var(--transition), color var(--transition),
                    border-color var(--transition), transform var(--transition);
        flex-shrink: 0;
    }
    .btn-circle:hover {
        background: var(--brand);
        color: #fff;
        border-color: var(--brand);
        transform: scale(1.1);
    }
    /* ✦ TAMBAHAN: tombol + disabled saat jumlah = batas maksimal */
    .btn-circle.disabled {
        background: var(--surface-raised);
        color: var(--ink-muted);
        border-color: var(--border-light);
        cursor: not-allowed;
        opacity: 0.45;
        pointer-events: none;
    }
    /* Badge batas maksimal */
    .max-badge {
        font-size: 10.5px;
        font-weight: 700;
        color: #f87171;
        background: rgba(239,68,68,0.12);
        border: 1px solid rgba(239,68,68,0.2);
        padding: 2px 8px;
        border-radius: var(--radius-pill);
        white-space: nowrap;
    }
    .qty-value {
        font-weight: 700;
        min-width: 22px;
        text-align: center;
        font-size: 14px;
        color: var(--ink);
    }

    /* ✦ Form wrapper flex column agar checkout card turun ke bawah */
    .cart-form-wrapper {
        display: flex;
        flex-direction: column;
        min-height: calc(100vh - 180px);
    }

    /* ── CHECKOUT SUMMARY CARD ── */
    .checkout-bar {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 20px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-top: auto; /* dorong ke bawah */
        box-shadow: var(--shadow-sm);
    }

    .checkout-bar-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .checkout-all-label {
        font-size: 13.5px;
        font-weight: 600;
        color: var(--ink-secondary);
        cursor: pointer;
        user-select: none;
    }

    .checkout-bar-right {
        display: flex;
        align-items: center;
        gap: 24px;
    }
    .checkout-total-wrap { text-align: right; }
    .checkout-total-label {
        font-size: 11.5px;
        color: var(--ink-muted);
        display: block;
        margin-bottom: 2px;
    }
    .checkout-total-price {
        font-size: 22px;
        font-weight: 800;
        color: var(--brand);
        letter-spacing: -0.5px;
    }

    .btn-checkout {
        background: var(--brand);
        color: #fff;
        border: none;
        padding: 13px 28px;
        border-radius: var(--radius-pill);
        font-family: 'Outfit', sans-serif;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        white-space: nowrap;
        transition: background var(--transition), transform var(--transition),
                    box-shadow var(--transition), opacity var(--transition);
        box-shadow: 0 4px 16px rgba(249,115,22,0.35);
    }
    .btn-checkout:hover:not(:disabled) {
        background: var(--brand-dark);
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(249,115,22,0.45);
    }
    .btn-checkout:disabled {
        opacity: 0.45;
        cursor: not-allowed;
        box-shadow: none;
    }

    /* ── RESPONSIVE ── */
    @media (max-width: 768px) {
        .checkout-bar {
            flex-direction: column;
            align-items: stretch;
            gap: 14px;
            padding: 16px;
        }
        .checkout-bar-right {
            justify-content: space-between;
        }
        .checkout-total-wrap { text-align: left; }
        .btn-checkout { width: 100%; justify-content: center; }
        .cart-name { font-size: 13px; }
        .qty-container { padding: 5px 10px; }
    }
</style>

<!-- HEADER -->
<div class="cart-page-header">
    <h1 class="cart-page-title">Keranjang</h1>
    <?php if (!empty($items)) : ?>
        <div class="cart-count-badge">
            <i class="fa-solid fa-bag-shopping"></i>
            <?= count($items) ?> item
        </div>
    <?php endif; ?>
</div>

<!-- FLASH ERROR -->
<?php if (session()->getFlashdata('error')) : ?>
    <div class="flash-error">
        <i class="fa-solid fa-circle-exclamation"></i>
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<!-- FLASH SUCCESS -->
<?php if (session()->getFlashdata('success')) : ?>
    <div style="background:rgba(34,197,94,0.12);color:#4ade80;border:1px solid rgba(74,222,128,0.2);
                padding:14px 18px;border-radius:var(--radius-md);margin-bottom:20px;
                font-size:13.5px;font-weight:500;display:flex;align-items:center;gap:10px;">
        <i class="fa-solid fa-circle-check"></i>
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<!-- KOSONG -->
<?php if (empty($items)) : ?>
    <div class="cart-empty">
        <i class="fa-solid fa-cart-xmark"></i>
        <p>Keranjang Anda masih kosong.</p>
        <a href="<?= base_url('pelanggan/dashboard') ?>">
            <i class="fa-solid fa-store"></i>
            Mulai Belanja
        </a>
    </div>

<?php else : ?>
    <?php $batas = 3; // ✦ Batas maksimal unit per produk ?>
    <form id="cartForm" action="<?= base_url('pelanggan/proses_pilihan') ?>" method="post">
        <?= csrf_field() ?>
        <div class="cart-form-wrapper">

        <div class="cart-list">
            <?php foreach ($items as $item) : ?>
                <div class="cart-item">
                    <input type="checkbox"
                           name="id_keranjang[]"
                           value="<?= $item['id_keranjang'] ?>"
                           class="checkbox-custom item-checkbox"
                           data-harga="<?= $item['harga'] ?>"
                           data-jumlah="<?= $item['jumlah'] ?>"
                           checked>

                    <div class="cart-img">
                        <img src="<?= base_url('images/' . $item['gambar']) ?>"
                             alt="<?= esc($item['nama_produk']) ?>">
                    </div>

                    <div class="cart-info">
                        <span class="cart-name"><?= esc($item['nama_produk']) ?></span>
                        <span class="cart-price">Rp <?= number_format($item['harga'], 0, ',', '.') ?></span>
                        <?php if ($item['jumlah'] >= $batas) : ?>
                            <!-- ✦ Tampilkan badge saat mencapai batas -->
                            <span class="max-badge" style="display:inline-flex;margin-top:4px;">
                                <i class="fa-solid fa-triangle-exclamation" style="font-size:9px;"></i>
                                Batas maksimal <?= $batas ?> unit
                            </span>
                        <?php endif; ?>
                    </div>

                    <div class="qty-container">
                        <a href="<?= base_url('pelanggan/kurangi/' . $item['id_keranjang']) ?>" class="btn-circle">
                            <i class="fa-solid fa-minus" style="font-size:10px;"></i>
                        </a>
                        <span class="qty-value"><?= $item['jumlah'] ?></span>
                        <!-- ✦ Tombol + disabled jika sudah mencapai batas -->
                        <?php if ($item['jumlah'] >= $batas) : ?>
                            <span class="btn-circle disabled" title="Batas maksimal <?= $batas ?> unit per produk">
                                <i class="fa-solid fa-plus" style="font-size:10px;"></i>
                            </span>
                        <?php else : ?>
                            <a href="<?= base_url('pelanggan/tambah/' . $item['id_keranjang']) ?>" class="btn-circle">
                                <i class="fa-solid fa-plus" style="font-size:10px;"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- CHECKOUT BAR -->
        <div class="checkout-bar">
            <div class="checkout-bar-left">
                <input type="checkbox" class="checkbox-custom" id="checkAll" checked>
                <label class="checkout-all-label" for="checkAll">Pilih Semua</label>
            </div>

            <div class="checkout-bar-right">
                <div class="checkout-total-wrap">
                    <span class="checkout-total-label">Total Harga</span>
                    <input type="hidden" name="total_akhir" id="inputTotal">
                    <div class="checkout-total-price" id="displayTotal">Rp 0</div>
                </div>
                <button type="submit" class="btn-checkout" id="btnSubmit" disabled>
                    <?= session()->get('isLoggedIn') ? 'Checkout (0)' : 'Daftar / Checkout (0)' ?>
                </button>
            </div>
        </div><!-- /checkout-bar -->
        </div><!-- /cart-form-wrapper -->
    </form>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkboxes   = document.querySelectorAll('.item-checkbox');
    const displayTotal = document.getElementById('displayTotal');
    const inputTotal   = document.getElementById('inputTotal');
    const btnSubmit    = document.getElementById('btnSubmit');
    const checkAll     = document.getElementById('checkAll');
    const isLoggedIn   = <?= session()->get('isLoggedIn') ? 'true' : 'false' ?>;

    function update() {
        let total = 0, count = 0;
        checkboxes.forEach(cb => {
            if (cb.checked) {
                total += parseInt(cb.dataset.harga) * parseInt(cb.dataset.jumlah);
                count++;
            }
        });
        displayTotal.textContent = 'Rp ' + total.toLocaleString('id-ID');
        inputTotal.value = total;
        btnSubmit.textContent = isLoggedIn
            ? 'Checkout (' + count + ')'
            : 'Daftar / Checkout (' + count + ')';
        btnSubmit.disabled = count === 0;

        // Sinkronisasi checkAll
        if (checkAll) checkAll.checked = count === checkboxes.length && count > 0;
    }

    checkboxes.forEach(cb => cb.addEventListener('change', update));
    if (checkAll) {
        checkAll.addEventListener('change', function () {
            checkboxes.forEach(cb => cb.checked = this.checked);
            update();
        });
    }
    update();
});
</script>

<?= $this->endSection() ?>