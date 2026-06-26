<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div style="padding: 20px;">
    <h2>Koleksi Celana Sport</h2>
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 20px;">
        <?php foreach ($products as $p) : ?>
            <div style="background: #f9f9f9; padding: 10px; border-radius: 15px;">
                <img src="<?= base_url('img/' . $p['gambar']) ?>" style="width: 100%; border-radius: 10px;">
                <h4 style="margin: 10px 0 5px;"><?= $p['nama_produk'] ?></h4>
                <p style="color: #FF8C00; font-weight: bold;">Rp <?= number_format($p['harga'], 0, ',', '.') ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?= $this->endSection() ?>