<?= $this->extend('layout/pelanggan_layout') ?>
<?= $this->section('content') ?>

<style>
    .ub-topbar {
        display: flex; align-items: center; gap: 14px;
        margin-bottom: 28px; padding-bottom: 20px;
        border-bottom: 1px solid var(--border);
    }
    .ub-back {
        width: 38px; height: 38px; border-radius: 50%;
        background: var(--surface-raised); border: 1px solid var(--border);
        display: flex; align-items: center; justify-content: center;
        color: var(--ink); text-decoration: none; font-size: 14px;
        transition: background var(--transition);
    }
    .ub-back:hover { background: var(--surface-high); }
    .ub-page-title { font-size: 20px; font-weight: 800; letter-spacing: -0.5px; color: var(--ink); }

    .ub-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        overflow: hidden;
        max-width: 560px;
        margin: 0 auto;
    }

    .ub-section { padding: 20px; }
    .ub-section + .ub-section { border-top: 1px solid var(--border); }

    .ub-label-section {
        display: flex; align-items: center; gap: 8px;
        font-size: 12px; font-weight: 700;
        color: var(--ink-secondary);
        text-transform: uppercase; letter-spacing: 0.8px;
        margin-bottom: 14px;
    }
    .ub-ico {
        width: 24px; height: 24px;
        border-radius: 6px;
        display: flex; align-items: center; justify-content: center;
        font-size: 11px; flex-shrink: 0;
    }
    .ub-ico.yellow { background: rgba(234,179,8,0.15); color: #fde047; }
    .ub-ico.blue   { background: rgba(59,130,246,0.12); color: #60a5fa; }

    /* Instruksi Transfer */
    .bank-box {
        background: var(--surface-raised);
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        padding: 16px;
    }
    .bank-row {
        display: flex; justify-content: space-between;
        align-items: center; font-size: 13.5px;
        padding: 7px 0;
        border-bottom: 1px solid var(--border);
    }
    .bank-row:last-child { border-bottom: none; padding-bottom: 0; }
    .bank-row-label { color: var(--ink-secondary); }
    .bank-row-val   { font-weight: 700; color: var(--ink); }
    .bank-row-val.highlight { color: var(--brand); font-size: 16px; }
    .copy-btn {
        background: none; border: none; cursor: pointer;
        color: #60a5fa; font-size: 12px; padding: 3px 6px;
        border-radius: 4px; transition: background var(--transition);
        font-family: 'Outfit', sans-serif;
    }
    .copy-btn:hover { background: rgba(59,130,246,0.1); }

    /* Upload area */
    .upload-area {
        border: 2px dashed var(--border);
        border-radius: var(--radius-md);
        padding: 32px 20px;
        text-align: center;
        cursor: pointer;
        transition: border-color var(--transition), background var(--transition);
        position: relative;
    }
    .upload-area:hover, .upload-area.drag-over {
        border-color: var(--brand);
        background: var(--brand-subtle);
    }
    .upload-area input[type="file"] {
        position: absolute; inset: 0; width: 100%; height: 100%;
        opacity: 0; cursor: pointer;
    }
    .upload-icon { font-size: 36px; color: var(--ink-muted); margin-bottom: 10px; }
    .upload-text { font-size: 14px; font-weight: 600; color: var(--ink); margin-bottom: 4px; }
    .upload-hint { font-size: 12px; color: var(--ink-muted); }

    /* Preview */
    #preview-wrap { display: none; margin-top: 14px; text-align: center; }
    #preview-wrap img {
        max-width: 100%; max-height: 260px;
        border-radius: var(--radius-md);
        border: 1px solid var(--border);
        object-fit: contain;
    }
    .preview-name {
        font-size: 12px; color: var(--ink-muted); margin-top: 6px;
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
        padding: 14px;
        border-radius: var(--radius-md);
        font-family: 'Outfit', sans-serif; font-size: 14px; font-weight: 700;
        cursor: pointer;
        box-shadow: 0 4px 16px rgba(249,115,22,0.35);
        transition: background var(--transition), transform var(--transition);
        margin-top: 16px;
    }
    .btn-submit-bukti:hover { background: var(--brand-dark); transform: translateY(-1px); }
    .btn-submit-bukti:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }
</style>

<!-- TOP NAV -->
<div class="ub-topbar">
    <a href="<?= base_url('pelanggan/orders') ?>" class="ub-back">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <h1 class="ub-page-title">Upload Bukti Transfer</h1>
</div>

<div class="ub-card">

    <!-- Instruksi Transfer -->
    <div class="ub-section">
        <div class="ub-label-section">
            <span class="ub-ico yellow"><i class="fa-solid fa-building-columns"></i></span>
            Instruksi Transfer
        </div>
        <div class="bank-box">
            <div class="bank-row">
                <span class="bank-row-label">No. Order</span>
                <span class="bank-row-val">#ORD-<?= str_pad($order['id'], 3, '0', STR_PAD_LEFT) ?></span>
            </div>
            <div class="bank-row">
                <span class="bank-row-label">Bank</span>
                <span class="bank-row-val">BRI</span>
            </div>
            <div class="bank-row">
                <span class="bank-row-label">No. Rekening</span>
                <span class="bank-row-val">
                    1234-567-890
                    <button class="copy-btn" onclick="copyText('1234567890')">
                        <i class="fa-regular fa-copy"></i> Salin
                    </button>
                </span>
            </div>
            <div class="bank-row">
                <span class="bank-row-label">Atas Nama</span>
                <span class="bank-row-val">Sport Center</span>
            </div>
            <div class="bank-row">
                <span class="bank-row-label">Jumlah Transfer</span>
                <span class="bank-row-val highlight">
                    Rp <?= number_format($order['total_harga'], 0, ',', '.') ?>
                    <button class="copy-btn" onclick="copyText('<?= $order['total_harga'] ?>')">
                        <i class="fa-regular fa-copy"></i> Salin
                    </button>
                </span>
            </div>
        </div>
    </div>

    <!-- Form Upload -->
    <div class="ub-section">
        <div class="ub-label-section">
            <span class="ub-ico blue"><i class="fa-solid fa-image"></i></span>
            Bukti Transfer
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
                <div class="upload-icon"><i class="fa-solid fa-cloud-arrow-up"></i></div>
                <div class="upload-text">Klik atau seret foto ke sini</div>
                <div class="upload-hint">JPG / PNG · Maks. 2 MB</div>
            </div>

            <!-- Preview gambar -->
            <div id="preview-wrap">
                <img id="preview-img" src="" alt="Preview">
                <div class="preview-name" id="preview-name"></div>
            </div>

            <button type="submit" class="btn-submit-bukti" id="btnSubmit" disabled>
                <i class="fa-solid fa-paper-plane"></i>
                Kirim Bukti Transfer
            </button>
        </form>

        <p style="text-align:center; font-size:11.5px; color:var(--ink-muted); margin-top:10px; line-height:1.6;">
            Pembayaran akan diverifikasi admin dalam 1×24 jam.<br>
            Status pesanan akan diperbarui otomatis.
        </p>
    </div>
</div>

<script>
    const fileInput = document.getElementById('fileInput');
    const previewWrap = document.getElementById('preview-wrap');
    const previewImg  = document.getElementById('preview-img');
    const previewName = document.getElementById('preview-name');
    const btnSubmit   = document.getElementById('btnSubmit');
    const uploadArea  = document.getElementById('uploadArea');

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

        // Tampilkan preview
        const reader = new FileReader();
        reader.onload = e => {
            previewImg.src = e.target.result;
            previewName.textContent = file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
            previewWrap.style.display = 'block';
            btnSubmit.disabled = false;
        };
        reader.readAsDataURL(file);
    });

    // Drag & drop styling
    uploadArea.addEventListener('dragover', e => { e.preventDefault(); uploadArea.classList.add('drag-over'); });
    uploadArea.addEventListener('dragleave', () => uploadArea.classList.remove('drag-over'));
    uploadArea.addEventListener('drop', () => uploadArea.classList.remove('drag-over'));

    function copyText(text) {
        navigator.clipboard.writeText(text).then(() => {
            alert('Disalin!');
        });
    }
</script>

<?= $this->endSection() ?>