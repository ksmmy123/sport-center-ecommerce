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
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Outfit', sans-serif;
            background: var(--bg);
            color: var(--ink);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }
        img { display: block; max-width: 100%; }
        a { color: inherit; }

        /* ── TOPBAR ── */
        .lp-topbar {
            position: sticky; top: 0; z-index: 50;
            background: rgba(11,17,32,0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            padding: 16px 6vw;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .lp-logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .lp-logo-badge {
            width: 34px; height: 34px;
            border-radius: 9px;
            background: linear-gradient(135deg, #f97316, #fbbf24);
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: 15px; color: #fff;
            box-shadow: 0 4px 12px rgba(249,115,22,0.4);
        }
        .lp-logo-text { font-size: 20px; font-weight: 800; letter-spacing: -0.8px; color: var(--ink); }
        .lp-logo-text span { color: var(--brand); }

        .lp-topbar-actions { display: flex; align-items: center; gap: 10px; }
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

        /* ── HERO ── */
        .lp-hero {
            position: relative;
            overflow: hidden;
            padding: 90px 6vw 100px;
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
        .lp-btn-lg { padding: 15px 30px; font-size: 15px; }

        /* ── SECTION WRAPPER ── */
        .lp-section { padding: 70px 6vw; max-width: 1180px; margin: 0 auto; }
        .lp-section-head { text-align: center; max-width: 560px; margin: 0 auto 44px; }
        .lp-section-head h2 { font-size: 28px; font-weight: 800; letter-spacing: -0.6px; margin-bottom: 12px; }
        .lp-section-head p { color: var(--ink-secondary); font-size: 14.5px; }

        /* ── KATEGORI ── */
        .lp-kategori-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        .lp-kategori-card {
            display: flex; align-items: center; gap: 18px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 28px;
            text-decoration: none;
            transition: transform var(--transition), border-color var(--transition), box-shadow var(--transition);
        }
        .lp-kategori-card:hover { transform: translateY(-4px); border-color: rgba(255,255,255,0.15); box-shadow: var(--shadow-md); }
        .lp-kategori-icon {
            width: 56px; height: 56px; flex-shrink: 0;
            border-radius: var(--radius-md);
            background: var(--brand-subtle);
            color: var(--brand);
            display: flex; align-items: center; justify-content: center;
            font-size: 22px;
        }
        .lp-kategori-card h3 { font-size: 16.5px; font-weight: 700; color: var(--ink); margin-bottom: 4px; }
        .lp-kategori-card p { font-size: 12.5px; color: var(--ink-secondary); }
        .lp-kategori-arrow { margin-left: auto; color: var(--ink-muted); transition: transform var(--transition), color var(--transition); }
        .lp-kategori-card:hover .lp-kategori-arrow { transform: translateX(4px); color: var(--brand); }

        /* ── KENAPA KAMI ── */
        .lp-fitur-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        .lp-fitur-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 30px 24px;
            text-align: center;
        }
        .lp-fitur-icon {
            width: 54px; height: 54px; margin: 0 auto 18px;
            border-radius: 50%;
            background: var(--brand-subtle);
            color: var(--brand);
            display: flex; align-items: center; justify-content: center;
            font-size: 21px;
        }
        .lp-fitur-card h3 { font-size: 15.5px; font-weight: 700; margin-bottom: 8px; color: var(--ink); }
        .lp-fitur-card p { font-size: 13px; color: var(--ink-secondary); line-height: 1.7; }

        /* ── PRODUK PREVIEW ── */
        .lp-produk-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }
        .lp-produk-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            overflow: hidden;
            text-decoration: none;
            transition: transform var(--transition), border-color var(--transition), box-shadow var(--transition);
        }
        .lp-produk-card:hover { transform: translateY(-4px); border-color: rgba(255,255,255,0.15); box-shadow: var(--shadow-md); }
        .lp-produk-img { aspect-ratio: 1/1; background: var(--surface-raised); overflow: hidden; }
        .lp-produk-img img { width: 100%; height: 100%; object-fit: cover; }
        .lp-produk-body { padding: 14px 16px 16px; }
        .lp-produk-name {
            font-size: 13.5px; font-weight: 700; color: var(--ink);
            margin-bottom: 6px;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
        }
        .lp-produk-price { font-size: 15px; font-weight: 800; color: var(--brand); }

        /* ── CTA BAWAH ── */
        .lp-cta {
            background: linear-gradient(135deg, #ea580c 0%, #c2410c 45%, #991b1b 100%);
            border-radius: var(--radius-xl);
            margin: 0 6vw 80px;
            padding: 56px 6vw;
            text-align: center;
            box-shadow: 0 12px 40px rgba(249,115,22,0.22);
        }
        .lp-cta h2 { font-size: 26px; font-weight: 800; letter-spacing: -0.6px; margin-bottom: 12px; }
        .lp-cta p { color: rgba(255,255,255,0.85); font-size: 14.5px; margin-bottom: 28px; }
        .lp-cta .lp-btn-brand { background: #fff; color: var(--brand-dark); }
        .lp-cta .lp-btn-brand:hover { background: #f1f5f9; }

        /* ── FOOTER ── */
        .lp-footer {
            border-top: 1px solid var(--border);
            padding: 28px 6vw;
            text-align: center;
            color: var(--ink-muted);
            font-size: 12.5px;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 900px) {
            .lp-fitur-grid { grid-template-columns: 1fr; }
            .lp-produk-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 640px) {
            .lp-topbar { padding: 14px 20px; }
            .lp-hero { padding: 60px 20px 70px; }
            .lp-hero h1 { font-size: 32px; }
            .lp-hero p { font-size: 14px; }
            .lp-section { padding: 50px 20px; }
            .lp-kategori-grid { grid-template-columns: 1fr; }
            .lp-cta { margin: 0 20px 60px; padding: 40px 24px; }
            .lp-btn span.txt-full { display: none; }
        }
    </style>
</head>
<body>

    <!-- TOPBAR -->
    <header class="lp-topbar">
        <a href="<?= base_url('/') ?>" class="lp-logo">
            <div class="lp-logo-badge">S</div>
            <span class="lp-logo-text">SPORT<span>.</span></span>
        </a>
        <div class="lp-topbar-actions">
            <a href="<?= base_url('auth') ?>" class="lp-btn lp-btn-ghost">
                <i class="fa-solid fa-right-to-bracket"></i>
                <span class="txt-full">Masuk</span>
            </a>
            <a href="<?= base_url('pelanggan/dashboard') ?>" class="lp-btn lp-btn-brand">
                <i class="fa-solid fa-bag-shopping"></i>
                Mulai Belanja
            </a>
        </div>
    </header>

    <!-- HERO -->
    <section class="lp-hero">
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
        </div>
    </section>

    <!-- KATEGORI -->
    <section class="lp-section">
        <div class="lp-section-head">
            <h2>Kategori Pilihan</h2>
            <p>Temukan celana sport sesuai kebutuhan aktivitasmu.</p>
        </div>
        <div class="lp-kategori-grid">
            <a href="<?= base_url('pelanggan/dashboard') ?>#kategori-1" class="lp-kategori-card">
                <div class="lp-kategori-icon"><i class="fa-solid fa-socks"></i></div>
                <div>
                    <h3>Celana Sport Pendek</h3>
                    <p>Ringan &amp; sejuk untuk lari, gym, dan olahraga harian</p>
                </div>
                <i class="fa-solid fa-arrow-right lp-kategori-arrow"></i>
            </a>
            <a href="<?= base_url('pelanggan/dashboard') ?>#kategori-2" class="lp-kategori-card">
                <div class="lp-kategori-icon"><i class="fa-solid fa-shirt"></i></div>
                <div>
                    <h3>Celana Training Panjang</h3>
                    <p>Nyaman dipakai untuk latihan maupun dipakai sehari-hari</p>
                </div>
                <i class="fa-solid fa-arrow-right lp-kategori-arrow"></i>
            </a>
        </div>
    </section>

    <!-- KENAPA KAMI -->
    <section class="lp-section">
        <div class="lp-section-head">
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

    <!-- PRODUK TERBARU -->
    <?php if (!empty($produk_preview)) : ?>
    <section class="lp-section">
        <div class="lp-section-head">
            <h2>Produk Terbaru</h2>
            <p>Koleksi yang baru saja kami tambahkan ke katalog.</p>
        </div>
        <div class="lp-produk-grid">
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
        </div>
    </section>
    <?php endif; ?>

    <!-- CTA BAWAH -->
    <section class="lp-cta">
        <h2>Siap Belanja Perlengkapan Olahraga?</h2>
        <p>Daftar sekarang dan nikmati kemudahan belanja di Sport Center.</p>
        <a href="<?= base_url('auth/register') ?>" class="lp-btn lp-btn-brand lp-btn-lg">
            <i class="fa-solid fa-user-plus"></i>
            Daftar Akun Baru
        </a>
    </section>

    <!-- FOOTER -->
    <footer class="lp-footer">
        &copy; <?= date('Y') ?> Sport Center Pemalang. Semua hak dilindungi.
    </footer>

</body>
</html>