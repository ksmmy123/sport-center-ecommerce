<?= $this->extend('layout/admin/main') ?>

<?= $this->section('content') ?>

<style>
    /* ============================================================
       FEEDBACK / ULASAN — Dark theme, selaras pelanggan_layout.php
       ============================================================ */
    .feedback-list { display: flex; flex-direction: column; gap: 18px; }

    .feedback-card-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 14px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .feedback-user { display: flex; align-items: center; gap: 14px; }
    .feedback-avatar {
        width: 44px; height: 44px;
        background: var(--surface-raised);
        border: 1px solid var(--border);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-weight: 800;
        font-size: 16px;
        color: var(--brand);
        flex-shrink: 0;
    }
    .feedback-name { font-size: 15px; font-weight: 700; color: var(--ink); margin: 0; }
    .feedback-order-id { color: var(--ink-muted); font-size: 12px; }

    .feedback-stars { color: #facc15; font-size: 14px; }

    .feedback-text {
        color: var(--ink-secondary);
        line-height: 1.6;
        font-style: italic;
        margin-bottom: 18px;
        font-size: 14px;
    }

    .feedback-reply {
        padding: 14px 16px;
        background: var(--brand-subtle);
        border-left: 4px solid var(--brand);
        border-radius: var(--radius-sm);
        margin-bottom: 14px;
    }
    .feedback-reply-label {
        font-weight: 800;
        font-size: 12.5px;
        margin: 0 0 5px 0;
        color: var(--brand);
    }
    .feedback-reply-text {
        color: var(--ink-secondary);
        font-size: 13.5px;
        margin: 0;
    }

    .empty-row {
        text-align: center;
        padding: 60px 20px;
        color: var(--ink-secondary);
    }
    .empty-row i { font-size: 40px; color: var(--ink-muted); margin-bottom: 14px; display: block; }
</style>

<!-- HEADER -->
<div class="page-header">
    <div>
        <h1 class="page-title">Ulasan Pelanggan</h1>
        <p class="page-subtitle">Lihat dan balas ulasan dari pelanggan atas pesanan mereka.</p>
    </div>
</div>

<div class="feedback-list">
    <?php if (!empty($ulasan_pelanggan)) : ?>
        <?php foreach ($ulasan_pelanggan as $o) : ?>
        <div class="card">
            <div class="feedback-card-top">
                <div class="feedback-user">
                    <div class="feedback-avatar">
                        <?= substr($o['nama_pelanggan'] ?? 'P', 0, 1) ?>
                    </div>
                    <div>
                        <h4 class="feedback-name"><?= esc($o['nama_pelanggan'] ?? 'Pelanggan Tidak Dikenal') ?></h4>
                        <span class="feedback-order-id">Order ID: #ORD-<?= str_pad($o['id'], 3, '0', STR_PAD_LEFT); ?></span>
                    </div>
                </div>
                <div class="feedback-stars">
                    <?php for($i=1; $i<=$o['rating']; $i++): ?><i class="fas fa-star"></i><?php endfor; ?>
                </div>
            </div>

            <p class="feedback-text">"<?= esc($o['ulasan']) ?>"</p>

            <?php if (!empty($o['balasan_admin'])) : ?>
                <div class="feedback-reply">
                    <p class="feedback-reply-label">Balasan Anda:</p>
                    <p class="feedback-reply-text"><?= esc($o['balasan_admin']) ?></p>
                </div>
            <?php endif; ?>

            <div>
                <button class="btn btn-primary">
                    <i class="fa-solid fa-reply"></i>
                    <?= empty($o['balasan_admin']) ? 'Balas Ulasan' : 'Edit Balasan' ?>
                </button>
            </div>
        </div>
        <?php endforeach; ?>
    <?php else : ?>
        <div class="card">
            <div class="empty-row">
                <i class="fa-solid fa-comment-slash"></i>
                <p>Belum ada ulasan dari pelanggan.</p>
            </div>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>