<?= $this->extend('layout/admin/main') ?>

<?= $this->section('content') ?>

<style>
    /* ============================================================
       FORM TAMBAH PRODUK — Dark theme, selaras pelanggan_layout.php
       ============================================================ */
    .form-card {
        background: var(--surface);
        border: 1px solid var(--border);
        padding: 32px;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        max-width: 800px;
    }

    .form-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .form-grid-4 {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 20px;
    }

    .form-grid-4 > .form-group {
        min-width: 0;
    }

    .form-grid-4 > .form-group input {
        width: 100%;
        box-sizing: border-box;
    }

    .size-stock-box {
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        padding: 18px 20px;
        margin-bottom: 12px;
        margin-top: 4px;
    }

    .size-stock-box .form-label {
        text-align: center;
        display: block;
    }

    .size-stock-box input[type="number"] {
        text-align: center;
    }

    /* ✅ BARU: kotak total stok otomatis */
    .total-stok-box {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: var(--brand-subtle);
        border: 1.5px solid rgba(249,115,22,0.3);
        border-radius: var(--radius-md);
        padding: 14px 20px;
        margin-bottom: 24px;
    }
    .total-stok-label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13.5px;
        font-weight: 700;
        color: var(--brand);
    }
    .total-stok-label i { font-size: 14px; }
    .total-stok-value {
        font-size: 20px;
        font-weight: 800;
        color: var(--ink);
        letter-spacing: -0.3px;
    }
    .total-stok-value span { font-size: 13px; font-weight: 600; color: var(--ink-secondary); margin-left: 4px; }

    .upload-box {
        border: 2px dashed var(--border);
        padding: 20px;
        border-radius: var(--radius-md);
        text-align: center;
        margin-bottom: 24px;
        margin-top: 4px;
        transition: border-color var(--transition);
    }
    .upload-box:hover { border-color: var(--brand); }
    .upload-box input[type="file"] { color: var(--ink-secondary); font-family: 'Outfit', sans-serif; }
    .upload-box p { font-size: 12px; color: var(--ink-muted); margin-top: 10px; }

    .form-actions { display: flex; gap: 12px; flex-wrap: wrap; margin-top: 8px; }

    @media (max-width: 768px) {
        .form-card { padding: 20px; }
        .form-grid-2 { grid-template-columns: 1fr; gap: 0; }
        .form-grid-4 { grid-template-columns: 1fr 1fr; gap: 14px; }
        .form-actions { flex-direction: column; }
        .form-actions .btn { width: 100%; justify-content: center; }
        .total-stok-box { flex-direction: column; align-items: flex-start; gap: 6px; }
    }
</style>

<!-- HEADER -->
<div class="page-header">
    <div>
        <h1 class="page-title">Tambah Produk Baru</h1>
        <p class="page-subtitle">Masukkan detail celana sport untuk ditambahkan ke inventaris.</p>
    </div>
</div>

<div class="form-card">
    <?php if (session()->getFlashdata('error')) : ?>
        <div style="background: rgba(239,68,68,0.12); border: 1px solid rgba(239,68,68,0.3); color: #f87171; padding: 12px 16px; border-radius: var(--radius-md); margin-bottom: 18px; font-size: 13.5px; font-weight: 600; display:flex; align-items:center; gap:8px;">
            <i class="fa-solid fa-circle-exclamation"></i>
            <?= session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/produk/simpan') ?>" method="post" enctype="multipart/form-data" id="formTambahProduk">
        <?= csrf_field() ?>

        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Nama Produk</label>
                <input type="text" name="nama_produk" class="form-control"
                       placeholder="Contoh: Celana Training Adidas"
                       value="<?= old('nama_produk') ?>" required>
            </div>
            <div class="form-group">
                <label class="form-label">Kategori</label>
                <select name="category_id" class="form-control" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="1" <?= old('category_id') == 1 ? 'selected' : '' ?>>Celana Sport Pendek</option>
                    <option value="2" <?= old('category_id') == 2 ? 'selected' : '' ?>>Celana Training Panjang</option>
                </select>
            </div>
        </div>

        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Harga (Rp)</label>
                <div style="position:relative;">
                    <span style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:var(--ink-secondary); font-size:14px; font-weight:600; pointer-events:none;">Rp</span>
                    <input type="number" name="harga" class="form-control" style="padding-left:40px;"
                           placeholder="0" min="0" step="500" value="<?= old('harga') ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Diskon (%)</label>
                <input type="number" name="diskon" class="form-control" placeholder="0" min="0" max="100"
                       value="<?= old('diskon', 0) ?>">
                <small style="color:var(--ink-muted); font-size:11.5px;">Kosongkan / isi 0 jika tidak ada diskon.</small>
            </div>
        </div>

        <!--
            PENTING: Stok TIDAK disimpan di tabel `products`.
            Stok disimpan per ukuran di tabel `product_sizes`
            (kolom: product_id, ukuran, stok). Form ini mengirim
            stok sebagai array stok[S], stok[M], stok[L], stok[XL].

            Di controller (Admin::simpan()), stok per ukuran ini
            disimpan APA ADANYA ke product_sizes (tidak dibagi rata).
        -->
        <div class="form-group">
            <label class="form-label">Stok per Ukuran</label>
            <div class="size-stock-box">
                <div class="form-grid-4">
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">S</label>
                        <input type="number" name="stok[S]" class="form-control stok-input"
                               min="0" value="<?= old('stok.S', 0) ?>" required>
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">M</label>
                        <input type="number" name="stok[M]" class="form-control stok-input"
                               min="0" value="<?= old('stok.M', 0) ?>" required>
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">L</label>
                        <input type="number" name="stok[L]" class="form-control stok-input"
                               min="0" value="<?= old('stok.L', 0) ?>" required>
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">XL</label>
                        <input type="number" name="stok[XL]" class="form-control stok-input"
                               min="0" value="<?= old('stok.XL', 0) ?>" required>
                    </div>
                </div>
            </div>

            <!-- ✅ BARU: total stok otomatis, dihitung live dari 4 input di atas -->
            <div class="total-stok-box">
                <span class="total-stok-label">
                    <i class="fa-solid fa-boxes-stacked"></i>
                    Total Stok Keseluruhan
                </span>
                <span class="total-stok-value">
                    <span id="totalStokAngka">0</span>
                    <span>pcs</span>
                </span>
            </div>

            <small style="color:var(--ink-muted); font-size:11.5px;">Isi 0 pada ukuran yang tidak tersedia. Stok tidak boleh bernilai negatif. Total di atas otomatis, tidak perlu diisi manual.</small>
        </div>

        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Merk</label>
                <input type="text" name="merk" class="form-control" placeholder="Contoh: Adidas, Nike" value="<?= old('merk') ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Warna</label>
                <input type="text" name="warna" class="form-control" placeholder="Contoh: Hitam" value="<?= old('warna') ?>">
            </div>
        </div>

        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Bahan</label>
                <input type="text" name="bahan" class="form-control" placeholder="Contoh: Dri-FIT Premium" value="<?= old('bahan') ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Berat (gram)</label>
                <input type="number" name="berat" class="form-control" placeholder="0" min="0" value="<?= old('berat') ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Deskripsi Produk</label>
            <textarea name="deskripsi" class="form-control" style="min-height:90px; resize:vertical;" placeholder="Deskripsi singkat produk..."><?= old('deskripsi') ?></textarea>
        </div>

        <div>
            <label class="form-label">Foto Produk</label>
            <div class="upload-box">
                <input type="file" name="gambar" accept="image/*" style="cursor:pointer;" required>
                <p>Format: JPG, PNG, atau WEBP. Maks 2MB.</p>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan Produk</button>
            <a href="<?= base_url('admin/produk') ?>" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
        </div>
    </form>
</div>

<script>
    // ✅ BARU: hitung ulang total stok setiap kali salah satu input
    // ukuran (S/M/L/XL) berubah, tanpa perlu submit form dulu.
    (function () {
        const stokInputs   = document.querySelectorAll('.stok-input');
        const totalStokEl  = document.getElementById('totalStokAngka');

        function hitungTotalStok() {
            let total = 0;
            stokInputs.forEach(input => {
                const nilai = parseInt(input.value, 10);
                total += isNaN(nilai) ? 0 : nilai;
            });
            totalStokEl.textContent = total.toLocaleString('id-ID');
        }

        stokInputs.forEach(input => {
            input.addEventListener('input', hitungTotalStok);
        });

        // Hitung sekali di awal (misalnya saat form terisi ulang dari old())
        hitungTotalStok();
    })();
</script>

<?= $this->endSection() ?>