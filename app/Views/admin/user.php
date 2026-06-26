<?= $this->extend('layout/admin/main') ?>

<?= $this->section('content') ?>

<style>
    /* ============================================================
       USER — Dark theme, selaras pelanggan_layout.php
       ============================================================ */
    .user-avatar {
        width: 42px; height: 42px;
        background: var(--surface-raised);
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        display: flex; align-items: center; justify-content: center;
        margin-right: 14px;
        font-weight: 800;
        font-size: 15px;
        color: var(--brand);
        flex-shrink: 0;
    }
    .user-info { display: flex; align-items: center; }
    .user-name { display: block; font-weight: 700; color: var(--ink); font-size: 14px; }
    .user-id { color: var(--ink-muted); font-size: 12px; }

    .role-admin { color: var(--brand); }
    .role-user  { color: var(--ink-secondary); }

    .aksi-group { display: flex; gap: 10px; }
    .aksi-group a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px; height: 34px;
        border-radius: var(--radius-sm);
        text-decoration: none;
        font-size: 14px;
        transition: background var(--transition), color var(--transition);
    }
    .aksi-view  { background: var(--surface-raised); color: var(--ink-secondary); }
    .aksi-view:hover  { background: var(--surface-high); color: var(--ink); }
    .aksi-block { background: rgba(239,68,68,0.12); color: #f87171; }
    .aksi-block:hover { background: rgba(239,68,68,0.22); }

    .table-wrapper table { min-width: 600px; }
</style>

<!-- HEADER -->
<div class="page-header">
    <div>
        <h1 class="page-title">Daftar User</h1>
        <p class="page-subtitle">Kelola data pengguna dan akses akun pada sistem.</p>
    </div>
</div>

<!-- TABEL -->
<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>Info Pengguna</th>
                <th>Role</th>
                <th>Status Akun</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)) : ?>
                <?php foreach ($users as $u) : ?>
                <tr>
                    <td>
                        <div class="user-info">
                            <div class="user-avatar">
                                <?= strtoupper(substr($u['username'], 0, 1)) ?>
                            </div>
                            <div>
                                <span class="user-name"><?= $u['username'] ?></span>
                                <span class="user-id">ID Pengguna: #<?= $u['id'] ?></span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="<?= ($u['role'] == 'admin') ? 'role-admin' : 'role-user' ?>" style="font-weight:600; font-size:13px;">
                            <?= strtoupper($u['role']) ?>
                        </span>
                    </td>
                    <td>
                        <span style="color:#4ade80; font-weight:700; font-size:13px;">Aktif</span>
                    </td>
                    <td>
                        <div class="aksi-group">
                            <a href="#" class="aksi-view" title="Lihat"><i class="fas fa-eye"></i></a>
                            <?php if($u['role'] != 'admin'): ?>
                                <a href="#" class="aksi-block" title="Blokir"><i class="fas fa-user-slash"></i></a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="4" style="padding:40px; text-align:center; color:var(--ink-secondary);">Belum ada data pengguna.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>