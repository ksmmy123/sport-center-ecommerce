<?= $this->extend('layout/pelanggan_layout') ?>
<?= $this->section('content') ?>

<style>
    .ub-wrapper {
        max-width: 600px;
        margin: 0 auto;
    }

    /* ── TOP NAV ── */
    .ub-topbar {
        display: flex; align-items: center; gap: 14px;
        margin-bottom: 24px;
    }
    .ub-back {
        width: 38px; height: 38px; border-radius: 50%;
        background: var(--surface-raised); border: 1px solid var(--border);
        display: flex; align-items: center; justify-content: center;
        color: var(--ink); text-decoration: none; font-size: 14px; flex-shrink: 0;
        transition: background var(--transition);
    }
    .ub-back:hover { background: var(--surface-high); }
    .ub-page-title { font-size: 20px; font-weight: 800; letter-spacing: -0.5px; color: var(--ink); }
    .ub-page-sub { font-size: 12.5px; color: var(--ink-secondary); margin-top: 2px; }

    /* ── STEP INDICATOR ── */
    .ub-steps {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 24px;
        padding: 0 2px;
    }
    .ub-step {
        display: flex; align-items: center; gap: 8px;
        flex: 1;
    }
    .ub-step-circle {
        width: 26px; height: 26px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 11px; font-weight: 800;
        flex-shrink: 0;
        transition: background var(--transition), color var(--transition);
    }
    .ub-step-circle.done   { background: var(--brand); color: #fff; }
    .ub-step-circle.active { background: var(--brand-subtle); color: var(--brand); border: 1.5px solid var(--brand); }
    .ub-step-circle.todo   { background: var(--surface-raised); color: var(--ink-muted); border: 1.5px solid var(--border); }
    .ub-step-label {
        font-size: 11.5px; font-weight: 600;
        color: var(--ink-muted);
        white-space: nowrap;
    }
    .ub-step-label.active-label { color: var(--ink); }
    .ub-step-line {
        flex: 1;
        height: 2px;
        background: var(--border);
        border-radius: 2px;
    }
    .ub-step-line.done { background: var(--brand); }

    /* ── CARD ── */
    .ub-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }

    .ub-section { padding: 22px 20px; }
    .ub-section + .ub-section { border-top: 1px solid var(--border); }

    .ub-label-section {
        display: flex; align-items: center; gap: 10px;
        font-size: 12px; font-weight: 700;
        color: var(--ink-secondary);
        text-transform: uppercase; letter-spacing: 0.8px;
        margin-bottom: 16px;
    }
    .ub-ico {
        width: 28px; height: 28px;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 12px; flex-shrink: 0;
    }
    .ub-ico.yellow { background: rgba(234,179,8,0.15); color: #fde047; }
    .ub-ico.blue   { background: rgba(59,130,246,0.12); color: #60a5fa; }
    .ub-ico.green  { background: rgba(34,197,94,0.12);  color: #4ade80; }

    /* ── INSTRUKSI TRANSFER: kartu bank bergaya "kartu ATM" ── */
    .bank-card {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 22px 20px;
        position: relative;
        overflow: hidden;
        margin-bottom: 14px;
    }
    .bank-card::before {
        content: '';
        position: absolute;
        top: -50px; right: -40px;
        width: 160px; height: 160px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(249,115,22,0.14) 0%, transparent 70%);
        pointer-events: none;
    }
    .bank-card-top {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 22px;
        position: relative; z-index: 1;
    }
    .bank-card-brand {
        font-size: 13px; font-weight: 800; letter-spacing: 1px;
        color: #fff;
        display: flex; align-items: center; gap: 8px;
    }
    .bank-card-brand i { color: var(--brand); }
    .bank-card-order {
        font-size: 11px; font-weight: 700; color: var(--ink-muted);
        background: rgba(255,255,255,0.06);
        padding: 3px 10px; border-radius: var(--radius-pill);
    }
    .bank-card-number {
        font-size: 22px; font-weight: 800; letter-spacing: 3px;
        color: #fff; margin-bottom: 18px;
        position: relative; z-index: 1;
        display: flex; align-items: center; gap: 12px;
    }
    .bank-card-bottom {
        display: flex; justify-content: space-between; align-items: flex-end;
        position: relative; z-index: 1;
        flex-wrap: wrap; gap: 12px;
    }
    .bank-card-field-label {
        font-size: 9.5px; font-weight: 700; color: var(--ink-muted);
        text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 4px;
    }
    .bank-card-field-value {
        font-size: 13.5px; font-weight: 700; color: #f1f5f9;
    }
    .bank-card-amount .bank-card-field-value {
        font-size: 18px; color: var(--brand);
    }

    .copy-btn {
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.12);
        cursor: pointer;
        color: #e2e8f0; font-size: 11px; font-weight: 600;
        padding: 5px 10px;
        border-radius: var(--radius-sm);
        transition: background var(--transition);
        font-family: 'Outfit', sans-serif;
        display: inline-flex; align-items: center; gap: 5px;
        flex-shrink: 0;
    }
    .copy-btn:hover { background: rgba(255,255,255,0.16); }
    .copy-btn.copied { background: rgba(34,197,94,0.25); color: #4ade80; }

    .bank-note {
        display: flex; align-items: flex-start; gap: 10px;
        background: rgba(234,179,8,0.08);
        border: 1px solid rgba(250,204,21,0.2);
        border-radius: var(--radius-md);
        padding: 12px 14px;
        font-size: 12px; color: #fde68a; line-height: 1.6;
    }
    .bank-note i { color: #facc15; margin-top: 1px; flex-shrink: 0; }

    /* ============================================================
       UPLOAD AREA — preview foto tampil DI DALAM kotak dashed ini,
       menggantikan ikon+teks placeholder, bukan section terpisah.
       ============================================================ */
    .upload-area {
        border: 2px dashed var(--border);
        border-radius: var(--radius-md);
        padding: 34px 20px;
        text-align: center;
        cursor: pointer;
        transition: border-color var(--transition), background var(--transition), padding var(--transition);
        position: relative;
        min-height: 190px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .upload-area:hover, .upload-area.drag-over {
        border-color: var(--brand);
        background: var(--brand-subtle);
    }
    /* ✅ FIX: saat sudah ada preview, kotak tidak lagi wajib setinggi
       min-height 190px — biar mengecil sesuai konten thumbnail */
    .upload-area.has-preview {
        min-height: 0;
        padding: 18px;
    }
    .upload-area input[type="file"] {
        position: absolute; inset: 0; width: 100%; height: 100%;
        opacity: 0; cursor: pointer;
        z-index: 2;
    }
    .upload-icon-circle {
        width: 60px; height: 60px;
        border-radius: 50%;
        background: var(--brand-subtle);
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 14px;
        transition: transform var(--transition);
    }
    .upload-area:hover .upload-icon-circle { transform: translateY(-3px); }
    .upload-icon { font-size: 24px; color: var(--brand); }
    .upload-text { font-size: 14px; font-weight: 700; color: var(--ink); margin-bottom: 4px; }
    .upload-hint {
        font-size: 11.5px; color: var(--ink-muted);
        display: inline-flex; align-items: center; gap: 6px;
    }
    .upload-hint .sep { opacity: 0.5; }

    /* Placeholder — disembunyikan begitu ada preview */
    .upload-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .upload-area.has-preview .upload-placeholder { display: none; }
    .upload-area.has-preview {
        border-style: solid;
        border-color: rgba(74,222,128,0.35);
        background: rgba(34,197,94,0.05);
    }

    #preview-wrap {
        display: none;
        width: 100%;
        position: relative;
        z-index: 1;
    }
    .upload-area.has-preview #preview-wrap { display: flex; flex-direction: column; align-items: center; }

    /* ✅ FIX: thumbnail bukti transfer dibuat jauh lebih kecil & proporsional
       (kotak tetap, bukan gambar full-size) supaya tidak memenuhi layar */
    #preview-wrap img {
        width: 140px;
        height: 140px;
        max-width: 100%;
        border-radius: var(--radius-md);
        border: 1px solid var(--border);
        object-fit: cover;
        background: var(--surface);
        box-shadow: var(--shadow-sm);
    }
    .preview-name { font-size: 11.5px; color: var(--ink-muted); margin-top: 10px; text-align: center; }
    .preview-badge {
        display: inline-flex; align-items: center; gap: 6px;
        font-size: 11.5px; font-weight: 700; color: #4ade80;
        background: rgba(34,197,94,0.12);
        border: 1px solid rgba(74,222,128,0.2);
        padding: 4px 12px; border-radius: var(--radius-pill);
        margin-bottom: 10px;
    }
    .btn-ganti-foto-hint {
        position: relative; z-index: 3;
        margin-top: 12px;
        font-size: 11.5px; font-weight: 600;
        color: var(--brand);
        display: inline-flex; align-items: center; gap: 6px;
    }

    /* Flash */
    .flash-error {
        background: rgba(239,68,68,0.1);
        border: 1px solid rgba(248,113,113,0.2);
        color: #f87171;
        padding: 12px 16px;
        border-radius: var(--radius-md);
        font-size: 13px; font-weight: 500;
        margin-bottom: 16px;
        display: flex; align-items: center; gap: 10px;
    }

    /* Tombol submit */
    .btn-submit-bukti {
        width: 100%;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        background: var(--brand); color: #fff; border: none;
        padding: 15px;
        border-radius: var(--radius-md);
        font-family: 'Outfit', sans-serif; font-size: 14.5px; font-weight: 700;
        cursor: pointer;
        box-shadow: 0 4px 16px rgba(249,115,22,0.35);
        transition: background var(--transition), transform var(--transition), box-shadow var(--transition);
        margin-top: 18px;
    }
    .btn-submit-bukti:hover:not(:disabled) {
        background: var(--brand-dark);
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(249,115,22,0.45);
    }
    .btn-submit-bukti:disabled { opacity: 0.45; cursor: not-allowed; box-shadow: none; }

    .ub-footnote {
        display: flex; align-items: flex-start; gap: 8px;
        text-align: left;
        font-size: 11.5px; color: var(--ink-muted); margin-top: 14px; line-height: 1.6;
    }
    .ub-footnote i { color: var(--ink-muted); margin-top: 2px; flex-shrink: 0; }

    /* ── RESPONSIVE ── */
    @media (max-width: 600px) {
        .ub-step-label { display: none; }
        .bank-card-number { font-size: 18px; letter-spacing: 2px; }
        .bank-card-bottom { flex-direction: column; align-items: flex-start; }
    }
</style>

<div class="ub-wrapper">

    <!-- TOP NAV -->
    <div class="ub-topbar">
        <a href="<?= base_url('pelanggan/orders') ?>" class="ub-back">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <div class="ub-page-title">Upload Bukti Transfer</div>
            <div class="ub-page-sub">Order #ORD-<?= str_pad($order['id'], 3, '0', STR_PAD_LEFT) ?></div>
        </div>
    </div>

    <!-- STEP INDICATOR -->
    <div class="ub-steps">
        <div class="ub-step">
            <div class="ub-step-circle done"><i class="fa-solid fa-check"></i></div>
            <span class="ub-step-label">Pesanan Dibuat</span>
        </div>
        <div class="ub-step-line done"></div>
        <div class="ub-step">
            <div class="ub-step-circle active">2</div>
            <span class="ub-step-label active-label">Upload Bukti</span>
        </div>
        <div class="ub-step-line"></div>
        <div class="ub-step">
            <div class="ub-step-circle todo">3</div>
            <span class="ub-step-label">Verifikasi Admin</span>
        </div>
    </div>

    <div class="ub-card">

        <!-- Instruksi Transfer -->
        <div class="ub-section">
            <div class="ub-label-section">
                <span class="ub-ico yellow"><i class="fa-solid fa-building-columns"></i></span>
                Instruksi Transfer
            </div>

            <div class="bank-card">
                <div class="bank-card-top">
                    <span class="bank-card-brand"><i class="fa-solid fa-university"></i> BANK BRI</span>
                    <span class="bank-card-order">Order #<?= str_pad($order['id'], 3, '0', STR_PAD_LEFT) ?></span>
                </div>

                <div class="bank-card-number">
                    1234-567-890
                    <button class="copy-btn" onclick="copyText('1234567890', this)" type="button">
                        <i class="fa-regular fa-copy"></i> Salin
                    </button>
                </div>

                <div class="bank-card-bottom">
                    <div>
                        <div class="bank-card-field-label">Atas Nama</div>
                        <div class="bank-card-field-value">Sport Center</div>
                    </div>
                    <div class="bank-card-amount">
                        <div class="bank-card-field-label">Jumlah Transfer</div>
                        <div class="bank-card-field-value">Rp <?= number_format($order['total_harga'], 0, ',', '.') ?></div>
                    </div>
                    <button class="copy-btn" onclick="copyText('<?= $order['total_harga'] ?>', this)" type="button">
                        <i class="fa-regular fa-copy"></i> Salin Nominal
                    </button>
                </div>
            </div>

            <div class="bank-note">
                <i class="fa-solid fa-circle-info"></i>
                Pastikan nominal transfer sesuai persis dengan jumlah di atas agar verifikasi lebih cepat diproses oleh admin.
            </div>
        </div>

        <!-- Form Upload -->
        <div class="ub-section">
            <div class="ub-label-section">
                <span class="ub-ico blue"><i class="fa-solid fa-image"></i></span>
                Unggah Bukti Transfer
            </div>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="flash-error">
                    <i class="fa-solid fa-circle-xmark"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('pelanggan/proses_upload_bukti/' . $order['id']) ?>"
                  method="post" enctype="multipart/form-data" id="formUpload">
                <?= csrf_field() ?>

                <div class="upload-area" id="uploadArea">
                    <input type="file" name="bukti_transfer" id="fileInput"
                           accept=".jpg,.jpeg,.png" required>

                    <div class="upload-placeholder">
                        <div class="upload-icon-circle">
                            <i class="fa-solid fa-cloud-arrow-up upload-icon"></i>
                        </div>
                        <div class="upload-text">Klik atau seret foto ke sini</div>
                        <div class="upload-hint">
                            <span>JPG / PNG</span> <span class="sep">·</span> <span>Maks. 2 MB</span>
                        </div>
                    </div>

                    <div id="preview-wrap">
                        <span class="preview-badge">
                            <i class="fa-solid fa-circle-check"></i> Foto siap diunggah
                        </span>
                        <img id="preview-img" src="" alt="Preview">
                        <div class="preview-name" id="preview-name"></div>
                        <span class="btn-ganti-foto-hint">
                            <i class="fa-solid fa-rotate"></i> Klik untuk ganti foto
                        </span>
                    </div>
                </div>

                <button type="submit" class="btn-submit-bukti" id="btnSubmit" disabled>
                    <i class="fa-solid fa-paper-plane"></i>
                    Kirim Bukti Transfer
                </button>
            </form>

            <div class="ub-footnote">
                <i class="fa-solid fa-clock"></i>
                <span>Pembayaran akan diverifikasi admin dalam 1×24 jam. Status pesanan akan diperbarui otomatis setelah bukti dikonfirmasi.</span>
            </div>
        </div>
    </div>
</div>

<script>
    const fileInput    = document.getElementById('fileInput');
    const uploadArea   = document.getElementById('uploadArea');
    const previewImg   = document.getElementById('preview-img');
    const previewName  = document.getElementById('preview-name');
    const btnSubmit    = document.getElementById('btnSubmit');

    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (!file) return;

        // Validasi client-side (tetap divalidasi ulang di server)
        const allowed = ['image/jpeg', 'image/png'];
        if (!allowed.includes(file.type)) {
            alert('File harus berformat JPG atau PNG.');
            this.value = '';
            return;
        }
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file maksimal 2MB.');
            this.value = '';
            return;
        }

        // Tampilkan preview DI DALAM kotak dashed
        const reader = new FileReader();
        reader.onload = e => {
            previewImg.src = e.target.result;
            previewName.textContent = file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
            uploadArea.classList.add('has-preview');
            btnSubmit.disabled = false;
        };
        reader.readAsDataURL(file);
    });

    // Drag & drop styling
    uploadArea.addEventListener('dragover', e => { e.preventDefault(); uploadArea.classList.add('drag-over'); });
    uploadArea.addEventListener('dragleave', () => uploadArea.classList.remove('drag-over'));
    uploadArea.addEventListener('drop', () => uploadArea.classList.remove('drag-over'));

    function copyText(text, btnEl) {
        navigator.clipboard.writeText(text).then(() => {
            const original = btnEl.innerHTML;
            btnEl.classList.add('copied');
            btnEl.innerHTML = '<i class="fa-solid fa-check"></i> Disalin';
            setTimeout(() => {
                btnEl.classList.remove('copied');
                btnEl.innerHTML = original;
            }, 1500);
        });
    }
</script>

<?= $this->endSection() ?>