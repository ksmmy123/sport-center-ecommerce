<?= $this->extend('layout/admin/main') ?>

<?= $this->section('content') ?>

<style>
    /* ============================================================
       PRODUK — Dark theme, selaras pelanggan_layout.php
       ============================================================ */

    /* ===== FILTER ===== */
    .filter-box {
        background: var(--surface);
        border: 1px solid var(--border);
        padding: 20px;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        margin-bottom: 24px;
    }
    .filter-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr;
        gap: 12px;
    }
    .filter-grid select { cursor: pointer; }

    /* ===== TABEL ===== */
    .table-wrapper table { table-layout: fixed; }
    .table-wrapper th:nth-child(1), .table-wrapper td:nth-child(1) { width: 32%; }
    .table-wrapper th:nth-child(2), .table-wrapper td:nth-child(2) { width: 18%; }
    .table-wrapper th:nth-child(3), .table-wrapper td:nth-child(3) { width: 15%; }
    .table-wrapper th:nth-child(4), .table-wrapper td:nth-child(4) { width: 20%; }
    .table-wrapper th:nth-child(5), .table-wrapper td:nth-child(5) { width: 15%; white-space: nowrap; }

    .produk-info { display: flex; align-items: center; gap: 14px; }
    .produk-img {
        width: 50px; height: 50px;
        border-radius: var(--radius-sm);
        background: var(--surface-raised);
        overflow: hidden;
        flex-shrink: 0;
    }
    .produk-img img { width: 100%; height: 100%; object-fit: cover; }
    .produk-nama { margin: 0; font-weight: 700; color: var(--ink); font-size: 14px; }
    .produk-sku  { color: var(--brand); font-weight: 600; font-size: 12px; }

    .badge { white-space: normal; max-width: 100%; line-height: 1.5; text-align: center; word-break: break-word; }

    .aksi-group { display: flex; justify-content: center; gap: 8px; }
    .aksi-group a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px; height: 34px;
        border-radius: var(--radius-sm);
        text-decoration: none;
        font-size: 14px;
        transition: background var(--transition), color var(--transition);
        flex-shrink: 0;
    }
    .aksi-edit  { background: rgba(59,130,246,0.12); color: #60a5fa; }
    .aksi-edit:hover  { background: rgba(59,130,246,0.22); }
    .aksi-hapus { background: rgba(239,68,68,0.12); color: #f87171; }
    .aksi-hapus:hover { background: rgba(239,68,68,0.22); }

    /* ===== CARD MOBILE ===== */
    .produk-cards { display: none; }
    .produk-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 16px;
        margin-bottom: 12px;
        box-shadow: var(--shadow-sm);
    }
    .produk-card-top { display: flex; align-items: center; gap: 12px; margin-bottom: 12px; }
    .produk-card-img {
        width: 56px; height: 56px;
        border-radius: var(--radius-sm);
        overflow: hidden;
        flex-shrink: 0;
        background: var(--surface-raised);
    }
    .produk-card-img img { width: 100%; height: 100%; object-fit: cover; }
    .produk-card-nama { font-weight: 700; color: var(--ink); font-size: 15px; margin: 0 0 3px; }
    .produk-card-sku  { color: var(--brand); font-size: 12px; font-weight: 600; }

    .produk-card-meta {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-bottom: 12px;
        font-size: 13px;
    }
    .meta-label { color: var(--ink-muted); font-size: 11px; font-weight: 700; text-transform: uppercase; margin-bottom: 2px; letter-spacing: 0.5px; }
    .meta-value { color: var(--ink); font-weight: 600; }

    .produk-card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        padding-top: 12px;
        border-top: 1px solid var(--border-light);
    }
    .produk-card-footer .btn { flex: 1; justify-content: center; }

    .empty-row { padding: 40px; text-align: center; color: var(--ink-secondary); }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .filter-grid { grid-template-columns: 1fr; }
        .table-wrapper { display: none; }
        .produk-cards  { display: block; }
    }
    @media (min-width: 769px) and (max-width: 1024px) {
        .filter-grid { grid-template-columns: 1fr 1fr; }
    }
</style>

<!-- HEADER -->
<div class="page-header">
    <div>
        <h1 class="page-title">Manajemen Produk</h1>
        <p class="page-subtitle">Kelola inventaris dan stok celana sport secara efisien.</p>
    </div>
    <div class="page-header-actions">
        <a href="<?= base_url('admin/produk/tambah') ?>" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Tambah Produk
        </a>
    </div>
</div>

<!-- FILTER -->
<div class="filter-box">
    <form action="" method="get">
        <div class="filter-grid">
            <input type="text" name="search" class="form-control" placeholder="Cari SKU atau nama produk..." value="<?= $search ?? '' ?>">

            <select name="sort" class="form-control">
                <option value="">Urutkan Berdasarkan</option>
                <option value="stok_asc">Stok Terendah</option>
                <option value="harga_desc">Harga Tertinggi</option>
                <option value="nama_asc">Nama A-Z</option>
            </select>

            <select name="status" class="form-control">
                <option value="">Semua Status</option>
                <option value="kritis">Stok Kritis (&lt; 10)</option>
                <option value="aman">Stok Aman</option>
            </select>

            <button type="submit" class="btn btn-primary" style="justify-content:center;">Terapkan</button>
        </div>
    </form>
</div>

<!-- TABEL (desktop) -->
<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>Produk / SKU</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok (Gabungan)</th>
                <th style="text-align:center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($products)): ?>
                <?php foreach($products as $p): ?>
                <tr>
                    <td>
                        <div class="produk-info">
                            <div class="produk-img">
                                <img src="<?= base_url('images/'.$p['gambar']) ?>" onerror="this.src='https://via.placeholder.com/50'">
                            </div>
                            <div>
                                <p class="produk-nama"><?= $p['nama_produk'] ?></p>
                                <small class="produk-sku">SKU: <?= $p['sku'] ?? 'SPRT-'.$p['id'] ?></small>
                                <?php if (!empty($p['merk'])) : ?>
                                    <br><small style="color:var(--ink-secondary); font-size:11px;"><?= esc($p['merk']) ?></small>
                                <?php endif; ?>
                            </div>
                        </div>
                    </td>
                    <td style="color:var(--ink-secondary); font-size:14px;">
                        <?= ($p['category_id'] == 1) ? 'Celana Sport Pendek' : 'Celana Training Panjang' ?>
                    </td>
                    <td style="font-weight:700; color:var(--ink);">
                        Rp <?= number_format($p['harga'], 0, ',', '.') ?>
                    </td>
                    <td style="font-weight:700; color:var(--ink);">
                        <?php if(($p['total_stok'] ?? 0) < 10): ?>
                            <span style="color:#f87171;"><i class="fa-solid fa-triangle-exclamation"></i> <?= $p['total_stok'] ?? 0 ?></span>
                        <?php else: ?>
                            <?= $p['total_stok'] ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="aksi-group">
                            <a href="<?= base_url('admin/produk/edit/'.$p['id']) ?>" class="aksi-edit" title="Edit"><i class="fa-solid fa-pen"></i></a>
                            <a href="<?= base_url('admin/produk/delete/'.$p['id']) ?>" onclick="return confirm('Hapus produk ini?')" class="aksi-hapus" title="Hapus"><i class="fa-solid fa-trash"></i></a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="empty-row">Data produk tidak ditemukan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- CARD (mobile) -->
<div class="produk-cards">
    <?php if (!empty($products)): ?>
        <?php foreach($products as $p): ?>
        <div class="produk-card">
            <div class="produk-card-top">
                <div class="produk-card-img">
                    <img src="<?= base_url('images/'.$p['gambar']) ?>" onerror="this.src='https://via.placeholder.com/56'">
                </div>
                <div>
                    <p class="produk-card-nama"><?= $p['nama_produk'] ?></p>
                    <span class="produk-card-sku">SKU: <?= $p['sku'] ?? 'SPRT-'.$p['id'] ?></span>
                </div>
            </div>

            <div class="produk-card-meta">
                <div>
                    <div class="meta-label">Kategori</div>
                    <div class="meta-value">
                        <?= ($p['category_id'] == 1) ? 'Celana Pendek' : 'Celana Panjang' ?>
                    </div>
                </div>
                <div>
                    <div class="meta-label">Harga</div>
                    <div class="meta-value">Rp <?= number_format($p['harga'], 0, ',', '.') ?></div>
                </div>
                <div style="grid-column: span 2;">
                    <div class="meta-label">Stok</div>
                    <div style="margin-top:4px;">
                        <?php if(($p['total_stok'] ?? 0) < 10): ?>
                            <span class="badge badge-danger"><i class="fa-solid fa-triangle-exclamation"></i> LOW STOCK: <?= $p['total_stok'] ?? 0 ?></span>
                        <?php else: ?>
                            <span class="badge badge-success">IN STOCK: <?= $p['total_stok'] ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="produk-card-footer">
                <a href="<?= base_url('admin/produk/edit/'.$p['id']) ?>" class="btn btn-secondary"><i class="fa-solid fa-pen"></i> Edit</a>
                <a href="<?= base_url('admin/produk/delete/'.$p['id']) ?>"
                   onclick="return confirm('Hapus produk ini?')" class="btn btn-danger"><i class="fa-solid fa-trash"></i> Hapus</a>
            </div>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="empty-row">Data produk tidak ditemukan.</div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>