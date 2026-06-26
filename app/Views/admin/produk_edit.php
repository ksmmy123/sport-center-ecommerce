<?= $this->extend('layout/admin/main') ?>

<?= $this->section('content') ?>

<style>
    /* ============================================================
       FORM EDIT PRODUK — Dark theme, selaras pelanggan_layout.php
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

    .upload-preview {
        display: flex;
        align-items: center;
        gap: 20px;
        border: 2px dashed var(--border);
        padding: 20px;
        border-radius: var(--radius-md);
        margin-bottom: 24px;
        margin-top: 4px;
        flex-wrap: wrap;
        transition: border-color var(--transition);
    }
    .upload-preview:hover { border-color: var(--brand); }

    .preview-img {
        width: 80px; height: 80px;
        border-radius: var(--radius-sm);
        overflow: hidden;
        background: var(--surface-raised);
        flex-shrink: 0;
    }
    .preview-img img { width: 100%; height: 100%; object-fit: cover; }

    .upload-info { flex: 1; min-width: 200px; }
    .upload-info input[type="file"] { color: var(--ink-secondary); font-family: 'Outfit', sans-serif; }
    .upload-info p { font-size: 12px; color: var(--ink-muted); margin-top: 6px; }

    .form-actions { display: flex; gap: 12px; flex-wrap: wrap; margin-top: 8px; }

    @media (max-width: 768px) {
        .form-card { padding: 20px; }
        .form-grid-2 { grid-template-columns: 1fr; gap: 0; }
        .upload-preview { flex-direction: column; align-items: flex-start; gap: 12px; }
        .upload-info { min-width: unset; width: 100%; }
        .form-actions { flex-direction: column; }
        .form-actions .btn { width: 100%; justify-content: center; }
    }
</style>

<!-- HEADER -->
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Produk</h1>
        <p class="page-subtitle">Perbarui informasi produk <strong><?= $product['nama_produk'] ?></strong></p>
    </div>
</div>

<div class="form-card">
    <?php if (session()->getFlashdata('error')) : ?>
        <div style="background: rgba(239,68,68,0.12); border: 1px solid rgba(239,68,68,0.3); color: #f87171; padding: 12px 16px; border-radius: var(--radius-md); margin-bottom: 18px; font-size: 13.5px; font-weight: 600; display:flex; align-items:center; gap:8px;">
            <i class="fa-solid fa-circle-exclamation"></i>
            <?= session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/produk/update/' . $product['id']) ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Nama Produk</label>
                <input type="text" name="nama_produk" class="form-control"
                       value="<?= $product['nama_produk'] ?>" required>
            </div>
            <div class="form-group">
                <label class="form-label">Kategori</label>
                <select name="category_id" class="form-control">
                    <option value="1" <?= ($product['category_id'] == 1) ? 'selected' : '' ?>>Celana Sport Pendek</option>
                    <option value="2" <?= ($product['category_id'] == 2) ? 'selected' : '' ?>>Celana Training Panjang</option>
                </select>
            </div>
        </div>

        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Harga (Rp)</label>
                <input type="number" name="harga" class="form-control" min="0"
                       value="<?= $product['harga'] ?>" required>
            </div>
            <div class="form-group">
                <label class="form-label">Jumlah Stok</label>
                <input type="number" name="stok" class="form-control" min="0"
                       value="<?= isset($product['stok_gabungan']) ? $product['stok_gabungan'] : ($product['stok'] ?? 0) ?>" required>
                <small style="color:var(--ink-muted); font-size:11.5px;">Stok tidak boleh bernilai negatif.</small>
            </div>
        </div>

        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Merk</label>
                <input type="text" name="merk" class="form-control" placeholder="Contoh: Adidas, Nike"
                       value="<?= esc($product['merk'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Warna</label>
                <input type="text" name="warna" class="form-control" placeholder="Contoh: Hitam"
                       value="<?= esc($product['warna'] ?? '') ?>">
            </div>
        </div>

        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Bahan</label>
                <input type="text" name="bahan" class="form-control" placeholder="Contoh: Dri-FIT Premium"
                       value="<?= esc($product['bahan'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Berat (gram)</label>
                <input type="number" name="berat" class="form-control" placeholder="0" min="0"
                       value="<?= esc($product['berat'] ?? 0) ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Deskripsi Produk</label>
            <textarea name="deskripsi" class="form-control" style="min-height:90px; resize:vertical;" placeholder="Deskripsi singkat produk..."><?= esc($product['deskripsi'] ?? '') ?></textarea>
        </div>

        <div>
            <label class="form-label">Foto Produk</label>
            <div class="upload-preview">
                <div class="preview-img">
                    <img src="<?= base_url('images/' . $product['gambar']) ?>"
                         onerror="this.src='https://via.placeholder.com/80'">
                </div>
                <div class="upload-info">
                    <input type="file" name="gambar" accept="image/*">
                    <p>Biarkan kosong jika tidak ingin mengubah foto.</p>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan</button>
            <a href="<?= base_url('admin/produk') ?>" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>