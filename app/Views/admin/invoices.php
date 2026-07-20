<?= $this->extend('layout/admin/main') ?>

<?= $this->section('content') ?>

<style>
    /* ============================================================
       INVOICES — Dark theme, selaras pelanggan_layout.php
       ============================================================ */

    /* ===== PRINT ===== */
    @media print {
        .sidebar, .admin-topbar, .no-print { display: none !important; }
        body, .main-content { background: #fff !important; color: #000 !important; }
        .table-wrapper { box-shadow: none !important; border: 1px solid #ddd !important; }
        .table-wrapper th, .table-wrapper td { border: 1px solid #eee !important; color: #000 !important; }
        .invoice-cards { display: none !important; }
        .table-wrapper { display: block !important; }

        /* saat mencetak SATU invoice (mode single-print),
           sembunyikan tabel utama dan hanya tampilkan konten invoice
           yang sedang dicetak. */
        body.printing-single .table-wrapper,
        body.printing-single .invoice-cards,
        body.printing-single .page-header {
            display: none !important;
        }
        body.printing-single .print-single-area {
            display: block !important;
        }
    }
    .print-single-area { display: none; }

    .table-wrapper table { min-width: 760px; }

    .inv-number { font-weight: 700; color: var(--ink); }
    .inv-date   { font-size: 13px; color: var(--ink-secondary); }
    .inv-total  { font-weight: 700; color: var(--ink); }
    .inv-user   { font-size: 14px; color: var(--ink-secondary); font-weight: 600; }
    .inv-user.muted { color: var(--ink-muted); font-style: italic; font-weight: 400; }

    .status-lunas   { color: #4ade80; font-weight: 700; font-size: 12.5px; }
    .status-pending { color: #facc15; font-weight: 700; font-size: 12.5px; }
    .status-batal   { color: #f87171; font-weight: 700; font-size: 12.5px; }

    .aksi-group { display: flex; justify-content: center; gap: 8px; }
    .aksi-group button, .aksi-group a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px; height: 34px;
        border-radius: var(--radius-sm);
        text-decoration: none;
        font-size: 14px;
        background: var(--surface-raised);
        color: var(--ink-secondary);
        border: none;
        cursor: pointer;
        transition: background var(--transition), color var(--transition);
        font-family: 'Outfit', sans-serif;
    }
    .aksi-group button:hover, .aksi-group a:hover { background: var(--surface-high); color: var(--ink); }
    .aksi-group button.lihat:hover { color: #60a5fa; }
    .aksi-group button.cetak:hover { color: var(--brand); }

    /* ===== CARD MOBILE ===== */
    .invoice-cards { display: none; }

    .inv-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 16px;
        margin-bottom: 12px;
        box-shadow: var(--shadow-sm);
    }

    .inv-card-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
    }

    .inv-card-number { font-weight: 800; color: var(--ink); font-size: 15px; }
    .inv-card-date { font-size: 12px; color: var(--ink-muted); margin-top: 3px; }

    .inv-card-meta {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-bottom: 14px;
        font-size: 13px;
    }

    .inv-meta-label {
        font-size: 10px;
        font-weight: 800;
        color: var(--ink-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 3px;
    }

    .inv-meta-value { font-weight: 600; color: var(--ink); }

    .inv-card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 12px;
        border-top: 1px solid var(--border-light);
    }

    .inv-card-aksi button {
        background: none;
        border: none;
        color: var(--ink-secondary);
        margin-left: 12px;
        font-size: 16px;
        cursor: pointer;
        text-decoration: none;
        transition: color var(--transition);
        font-family: 'Outfit', sans-serif;
    }
    .inv-card-aksi button:hover { color: var(--brand); }

    .empty-row { padding: 40px; text-align: center; color: var(--ink-secondary); }

    /* ============================================================
       MODAL DETAIL INVOICE
       ============================================================ */
    .inv-modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.6);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    .inv-modal-overlay.active { display: flex; }

    .inv-modal-box {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        max-width: 480px;
        width: 100%;
        max-height: 85vh;
        overflow-y: auto;
        box-shadow: var(--shadow-lg);
    }

    .inv-modal-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 18px 20px;
        border-bottom: 1px solid var(--border);
        position: sticky;
        top: 0;
        background: var(--surface);
        z-index: 1;
    }
    .inv-modal-title { font-size: 16px; font-weight: 800; color: var(--ink); }
    .inv-modal-close {
        width: 32px; height: 32px;
        border-radius: 50%;
        background: var(--surface-raised);
        border: 1px solid var(--border);
        color: var(--ink-secondary);
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        transition: background var(--transition), color var(--transition);
        font-size: 13px;
    }
    .inv-modal-close:hover { background: var(--surface-high); color: var(--ink); }

    .inv-modal-body { padding: 20px; }

    .inv-modal-meta-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 18px;
        padding-bottom: 18px;
        border-bottom: 1px solid var(--border-light);
    }
    .inv-modal-meta-label {
        font-size: 10px; font-weight: 800; color: var(--ink-muted);
        text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;
    }
    .inv-modal-meta-value { font-size: 13.5px; font-weight: 600; color: var(--ink); }

    .inv-modal-items-label {
        font-size: 12px; font-weight: 700; color: var(--ink-secondary);
        text-transform: uppercase; letter-spacing: 0.6px;
        margin-bottom: 10px;
    }
    .inv-modal-item-row {
        display: flex; justify-content: space-between; align-items: center;
        padding: 9px 0; border-bottom: 1px solid var(--border-light);
        font-size: 13px;
    }
    .inv-modal-item-row:last-child { border-bottom: none; }
    .inv-modal-item-name { color: var(--ink); font-weight: 600; }
    .inv-modal-item-qty { color: var(--ink-muted); font-size: 11.5px; margin-top: 2px; }
    .inv-modal-item-sub { color: var(--ink); font-weight: 700; white-space: nowrap; }

    .inv-modal-empty-items {
        text-align: center; padding: 20px; color: var(--ink-muted); font-size: 13px; font-style: italic;
    }

    .inv-modal-total-row {
        display: flex; justify-content: space-between; align-items: center;
        margin-top: 16px; padding-top: 16px; border-top: 1px solid var(--border);
        font-size: 15px; font-weight: 800; color: var(--ink);
    }
    .inv-modal-total-value { color: var(--brand); }

    .inv-modal-foot {
        padding: 16px 20px;
        border-top: 1px solid var(--border);
        display: flex;
        gap: 10px;
    }
    .inv-modal-foot button {
        flex: 1;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        padding: 11px;
        border-radius: var(--radius-md);
        font-size: 13px; font-weight: 700;
        cursor: pointer;
        border: none;
        font-family: 'Outfit', sans-serif;
        transition: background var(--transition);
    }
    .inv-modal-foot .btn-print-modal {
        background: var(--brand); color: #fff;
    }
    .inv-modal-foot .btn-print-modal:hover { background: var(--brand-dark); }
    .inv-modal-foot .btn-close-modal {
        background: var(--surface-raised); color: var(--ink);
        border: 1px solid var(--border);
    }
    .inv-modal-foot .btn-close-modal:hover { background: var(--surface-high); }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .table-wrapper { display: none; }
        .invoice-cards { display: block; }
    }
</style>

<!-- HEADER -->
<div class="page-header">
    <div>
        <h1 class="page-title">Daftar Invoice</h1>
        <p class="page-subtitle">Kelola dan cetak invoice transaksi pelanggan.</p>
    </div>
    <div class="page-header-actions">
        <button onclick="window.print()" class="btn btn-primary no-print">
            <i class="fas fa-print"></i> Cetak Laporan
        </button>
    </div>
</div>

<!-- TABEL (desktop) -->
<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>No. Invoice</th>
                <th>Pelanggan</th>
                <th>Tanggal</th>
                <th>Total Tagihan</th>
                <th>Status</th>
                <th style="text-align:center;" class="no-print">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($invoices) && is_array($invoices)) : ?>
                <!-- ✅ FIX: hapus array_reverse() — controller sudah
                     mengurutkan orderBy('orders.tgl_pesan', 'DESC') supaya
                     pesanan terbaru tampil paling atas. array_reverse()
                     sebelumnya membalik urutan itu lagi, sehingga pesanan
                     TERLAMA yang justru muncul di atas. -->
                <?php foreach ($invoices as $inv) :
                    $statusBayar = $inv['status_pembayaran'] ?? '';
                    $lunas       = ($statusBayar == 'sudah_bayar');
                    $batal       = ($statusBayar == 'dibatalkan');
                    $namaPelanggan = $inv['username'] ?? null;
                ?>
                <tr>
                    <td class="inv-number">#INV-<?= str_pad($inv['id'], 4, '0', STR_PAD_LEFT) ?></td>
                    <td>
                        <span class="inv-user <?= empty($namaPelanggan) ? 'muted' : '' ?>">
                            <?= !empty($namaPelanggan) ? esc($namaPelanggan) : 'Pengguna #' . $inv['user_id'] ?>
                        </span>
                    </td>
                    <td class="inv-date"><?= date('d M Y', strtotime($inv['tgl_pesan'])) ?></td>
                    <td class="inv-total">Rp <?= number_format($inv['total_harga'], 0, ',', '.') ?></td>
                    <td>
                        <?php if ($batal) : ?>
                            <span class="status-batal">DIBATALKAN</span>
                        <?php else : ?>
                            <span class="<?= $lunas ? 'status-lunas' : 'status-pending' ?>">
                                <?= strtoupper(str_replace('_', ' ', $statusBayar)) ?>
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="no-print">
                        <div class="aksi-group">
                            <button type="button" class="lihat" title="Lihat Detail"
                                    onclick='bukaModalInvoice(<?= json_encode([
                                        "id"        => $inv["id"],
                                        "tanggal"   => date("d M Y, H:i", strtotime($inv["tgl_pesan"])),
                                        "pelanggan" => $namaPelanggan ?? ("Pengguna #" . $inv["user_id"]),
                                        "metode"    => $inv["metode_pembayaran"] ?? "-",
                                        "status"    => $batal ? "Dibatalkan" : ($lunas ? "Sudah Bayar" : strtoupper(str_replace("_"," ",$statusBayar))),
                                        "total"     => (float) $inv["total_harga"],
                                        "items"     => $inv["items"] ?? []
                                    ]) ?>)'>
                                <i class="fas fa-eye"></i>
                            </button>
                            <button type="button" class="cetak" title="Cetak Invoice Ini"
                                    onclick='bukaModalInvoice(<?= json_encode([
                                        "id"        => $inv["id"],
                                        "tanggal"   => date("d M Y, H:i", strtotime($inv["tgl_pesan"])),
                                        "pelanggan" => $namaPelanggan ?? ("Pengguna #" . $inv["user_id"]),
                                        "metode"    => $inv["metode_pembayaran"] ?? "-",
                                        "status"    => $batal ? "Dibatalkan" : ($lunas ? "Sudah Bayar" : strtoupper(str_replace("_"," ",$statusBayar))),
                                        "total"     => (float) $inv["total_harga"],
                                        "items"     => $inv["items"] ?? []
                                    ]) ?>, true)'>
                                <i class="fas fa-print"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="6" class="empty-row">Belum ada data invoice yang tersedia.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- CARD (mobile) -->
<div class="invoice-cards no-print">
    <?php if (!empty($invoices) && is_array($invoices)) : ?>
        <!-- ✅ FIX: hapus array_reverse() di sini juga, konsisten dengan tabel desktop -->
        <?php foreach ($invoices as $inv) :
            $statusBayar   = $inv['status_pembayaran'] ?? '';
            $lunas         = ($statusBayar == 'sudah_bayar');
            $batal         = ($statusBayar == 'dibatalkan');
            $namaPelanggan = $inv['username'] ?? null;
        ?>
        <div class="inv-card">
            <div class="inv-card-top">
                <div>
                    <div class="inv-card-number">#INV-<?= str_pad($inv['id'], 4, '0', STR_PAD_LEFT) ?></div>
                    <div class="inv-card-date"><?= date('d M Y', strtotime($inv['tgl_pesan'])) ?></div>
                </div>
                <?php if ($batal) : ?>
                    <span class="status-batal">DIBATALKAN</span>
                <?php else : ?>
                    <span class="<?= $lunas ? 'status-lunas' : 'status-pending' ?>">
                        <?= strtoupper(str_replace('_', ' ', $statusBayar)) ?>
                    </span>
                <?php endif; ?>
            </div>

            <div class="inv-card-meta">
                <div>
                    <div class="inv-meta-label">Pelanggan</div>
                    <div class="inv-meta-value"><?= !empty($namaPelanggan) ? esc($namaPelanggan) : 'Pengguna #' . $inv['user_id'] ?></div>
                </div>
                <div>
                    <div class="inv-meta-label">Total Tagihan</div>
                    <div class="inv-meta-value">Rp <?= number_format($inv['total_harga'], 0, ',', '.') ?></div>
                </div>
            </div>

            <div class="inv-card-footer">
                <span style="font-size:12px; color:var(--ink-muted);">Invoice #<?= str_pad($inv['id'], 4, '0', STR_PAD_LEFT) ?></span>
                <div class="inv-card-aksi">
                    <button type="button" title="Lihat Detail"
                            onclick='bukaModalInvoice(<?= json_encode([
                                "id"        => $inv["id"],
                                "tanggal"   => date("d M Y, H:i", strtotime($inv["tgl_pesan"])),
                                "pelanggan" => $namaPelanggan ?? ("Pengguna #" . $inv["user_id"]),
                                "metode"    => $inv["metode_pembayaran"] ?? "-",
                                "status"    => $batal ? "Dibatalkan" : ($lunas ? "Sudah Bayar" : strtoupper(str_replace("_"," ",$statusBayar))),
                                "total"     => (float) $inv["total_harga"],
                                "items"     => $inv["items"] ?? []
                            ]) ?>)'>
                        <i class="fas fa-eye"></i>
                    </button>
                    <button type="button" title="Cetak Invoice Ini"
                            onclick='bukaModalInvoice(<?= json_encode([
                                "id"        => $inv["id"],
                                "tanggal"   => date("d M Y, H:i", strtotime($inv["tgl_pesan"])),
                                "pelanggan" => $namaPelanggan ?? ("Pengguna #" . $inv["user_id"]),
                                "metode"    => $inv["metode_pembayaran"] ?? "-",
                                "status"    => $batal ? "Dibatalkan" : ($lunas ? "Sudah Bayar" : strtoupper(str_replace("_"," ",$statusBayar))),
                                "total"     => (float) $inv["total_harga"],
                                "items"     => $inv["items"] ?? []
                            ]) ?>, true)'>
                        <i class="fas fa-print"></i>
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php else : ?>
        <div class="empty-row">Belum ada data invoice yang tersedia.</div>
    <?php endif; ?>
</div>

<!-- Modal Detail Invoice (dipakai untuk Lihat & Cetak per invoice) -->
<div class="inv-modal-overlay no-print" id="invModalOverlay">
    <div class="inv-modal-box">
        <div class="inv-modal-head">
            <span class="inv-modal-title" id="invModalTitle">Detail Invoice</span>
            <button class="inv-modal-close" onclick="tutupModalInvoice()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="inv-modal-body">
            <div class="inv-modal-meta-grid">
                <div>
                    <div class="inv-modal-meta-label">Pelanggan</div>
                    <div class="inv-modal-meta-value" id="invModalPelanggan">-</div>
                </div>
                <div>
                    <div class="inv-modal-meta-label">Tanggal</div>
                    <div class="inv-modal-meta-value" id="invModalTanggal">-</div>
                </div>
                <div>
                    <div class="inv-modal-meta-label">Metode Bayar</div>
                    <div class="inv-modal-meta-value" id="invModalMetode">-</div>
                </div>
                <div>
                    <div class="inv-modal-meta-label">Status</div>
                    <div class="inv-modal-meta-value" id="invModalStatus">-</div>
                </div>
            </div>

            <div class="inv-modal-items-label">Item Dibeli</div>
            <div id="invModalItems">
                <div class="inv-modal-empty-items">Tidak ada rincian item.</div>
            </div>

            <div class="inv-modal-total-row">
                <span>Total Tagihan</span>
                <span class="inv-modal-total-value" id="invModalTotal">Rp 0</span>
            </div>
        </div>
        <div class="inv-modal-foot">
            <button class="btn-close-modal" onclick="tutupModalInvoice()">Tutup</button>
            <button class="btn-print-modal" onclick="cetakInvoiceTunggal()">
                <i class="fa-solid fa-print"></i> Cetak
            </button>
        </div>
    </div>
</div>

<!-- Area khusus untuk mode cetak satu invoice -->
<div class="print-single-area" id="printSingleArea">
    <h2 style="margin-bottom:4px;">Invoice #<span id="printInvId"></span></h2>
    <p style="margin-bottom:16px; color:#555;">Sport Center Pemalang</p>
    <table style="width:100%; border-collapse:collapse; margin-bottom:16px;">
        <tr><td style="padding:4px 0;"><strong>Pelanggan</strong></td><td id="printPelanggan"></td></tr>
        <tr><td style="padding:4px 0;"><strong>Tanggal</strong></td><td id="printTanggal"></td></tr>
        <tr><td style="padding:4px 0;"><strong>Metode Bayar</strong></td><td id="printMetode"></td></tr>
        <tr><td style="padding:4px 0;"><strong>Status</strong></td><td id="printStatus"></td></tr>
    </table>
    <table style="width:100%; border-collapse:collapse;" border="1" cellpadding="6">
        <thead>
            <tr><th>Produk</th><th>Qty</th><th>Subtotal</th></tr>
        </thead>
        <tbody id="printItemsBody"></tbody>
    </table>
    <h3 style="text-align:right; margin-top:16px;">Total: Rp <span id="printTotal"></span></h3>
</div>

<script>
    function formatRupiah(angka) {
        return 'Rp ' + Math.round(angka).toLocaleString('id-ID');
    }

    function bukaModalInvoice(data, langsungCetak) {
        document.getElementById('invModalTitle').textContent = 'Invoice #INV-' + String(data.id).padStart(4, '0');
        document.getElementById('invModalPelanggan').textContent = data.pelanggan;
        document.getElementById('invModalTanggal').textContent = data.tanggal;
        document.getElementById('invModalMetode').textContent = (data.metode || '-').toUpperCase();
        document.getElementById('invModalStatus').textContent = data.status;
        document.getElementById('invModalTotal').textContent = formatRupiah(data.total);

        const itemsWrap = document.getElementById('invModalItems');
        if (data.items && data.items.length > 0) {
            itemsWrap.innerHTML = data.items.map(it => `
                <div class="inv-modal-item-row">
                    <div>
                        <div class="inv-modal-item-name">${it.nama_produk || 'Produk'}</div>
                        <div class="inv-modal-item-qty">Qty: ${it.jumlah}</div>
                    </div>
                    <div class="inv-modal-item-sub">${formatRupiah(it.subtotal)}</div>
                </div>
            `).join('');
        } else {
            itemsWrap.innerHTML = '<div class="inv-modal-empty-items">Tidak ada rincian item untuk invoice ini.</div>';
        }

        window._currentInvoiceData = data;

        document.getElementById('invModalOverlay').classList.add('active');

        if (langsungCetak) {
            cetakInvoiceTunggal();
        }
    }

    function tutupModalInvoice() {
        document.getElementById('invModalOverlay').classList.remove('active');
    }

    document.getElementById('invModalOverlay').addEventListener('click', function(e) {
        if (e.target === this) tutupModalInvoice();
    });

    function cetakInvoiceTunggal() {
        const data = window._currentInvoiceData;
        if (!data) return;

        document.getElementById('printInvId').textContent = String(data.id).padStart(4, '0');
        document.getElementById('printPelanggan').textContent = data.pelanggan;
        document.getElementById('printTanggal').textContent = data.tanggal;
        document.getElementById('printMetode').textContent = (data.metode || '-').toUpperCase();
        document.getElementById('printStatus').textContent = data.status;
        document.getElementById('printTotal').textContent = Math.round(data.total).toLocaleString('id-ID');

        const body = document.getElementById('printItemsBody');
        if (data.items && data.items.length > 0) {
            body.innerHTML = data.items.map(it => `
                <tr>
                    <td>${it.nama_produk || 'Produk'}</td>
                    <td style="text-align:center;">${it.jumlah}</td>
                    <td style="text-align:right;">Rp ${Math.round(it.subtotal).toLocaleString('id-ID')}</td>
                </tr>
            `).join('');
        } else {
            body.innerHTML = '<tr><td colspan="3" style="text-align:center; color:#888;">Tidak ada rincian item.</td></tr>';
        }

        document.body.classList.add('printing-single');
        window.print();

        window.onafterprint = function() {
            document.body.classList.remove('printing-single');
            window.onafterprint = null;
        };
    }
</script>

<?= $this->endSection() ?>