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
        .form-actions { flex-direction: column; }
        .form-actions .btn { width: 100%; justify-content: center; }
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

    <form action="<?= base_url('admin/produk/simpan') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Nama Produk</label>
                <input type="text" name="nama_produk" class="form-control"
                       placeholder="Contoh: Celana Training Adidas" required>
            </div>
            <div class="form-group">
                <label class="form-label">Kategori</label>
                <select name="category_id" class="form-control" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="1">Celana Sport Pendek</option>
                    <option value="2">Celana Training Panjang</option>
                </select>
            </div>
        </div>

        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Harga (Rp)</label>
                <div style="position:relative;">
                    <span style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:var(--ink-secondary); font-size:14px; font-weight:600; pointer-events:none;">Rp</span>
                    <input type="number" name="harga" class="form-control" style="padding-left:40px;" placeholder="0" min="0" step="500" required>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Jumlah Stok</label>
                <input type="number" name="stok" class="form-control" placeholder="0" min="0" required>
                <small style="color:var(--ink-muted); font-size:11.5px;">Stok tidak boleh bernilai negatif.</small>
            </div>
        </div>

        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Merk</label>
                <input type="text" name="merk" class="form-control" placeholder="Contoh: Adidas, Nike">
            </div>
            <div class="form-group">
                <label class="form-label">Warna</label>
                <input type="text" name="warna" class="form-control" placeholder="Contoh: Hitam">
            </div>
        </div>

        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Bahan</label>
                <input type="text" name="bahan" class="form-control" placeholder="Contoh: Dri-FIT Premium">
            </div>
            <div class="form-group">
                <label class="form-label">Berat (gram)</label>
                <input type="number" name="berat" class="form-control" placeholder="0" min="0">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Deskripsi Produk</label>
            <textarea name="deskripsi" class="form-control" style="min-height:90px; resize:vertical;" placeholder="Deskripsi singkat produk..."></textarea>
        </div>

        <div>
            <label class="form-label">Foto Produk</label>
            <div class="upload-box">
                <input type="file" name="gambar" accept="image/*" style="cursor:pointer;">
                <p>Format: JPG, PNG, atau WEBP. Maks 2MB.</p>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan Produk</button>
            <a href="<?= base_url('admin/produk') ?>" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>