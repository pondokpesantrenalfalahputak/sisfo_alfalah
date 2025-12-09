<?php
    use Illuminate\Support\Facades\Session;
    use Illuminate\Support\Facades\Storage;
    use Carbon\Carbon;

    // Set locale Carbon
    Carbon::setLocale('id');

    // Hitungan Tagihan
    $status_lunas = $tagihan->isLunas();
    $sisaTagihan = $tagihan->jumlah_tagihan - $tagihan->total_bayar_terkonfirmasi;
?>

<?php $__env->startSection('title', 'Detail Tagihan'); ?>
<?php $__env->startSection('page_title', 'Faktur Tagihan: ' . ($tagihan->keterangan ?? $tagihan->jenis_tagihan)); ?>

<?php $__env->startPush('css'); ?>
<style>
/* CSS khusus untuk tampilan Riwayat Pembayaran di Mobile */
@media (max-width: 767.98px) {
    /* Sembunyikan Header Tabel di Mobile */
    .riwayat-table thead {
        display: none;
    }

    /* Ubah Baris Tabel menjadi Blok Card di Mobile */
    .riwayat-table tbody, 
    .riwayat-table tr {
        display: block;
        width: 100%;
    }

    /* Styling setiap data cell */
    .riwayat-table td {
        display: block;
        text-align: right !important; /* Data rata kanan */
        padding: 8px 15px;
        position: relative;
        border: none;
    }

    /* Tambahkan Label untuk Setiap Data Cell (Pseudo-element) */
    .riwayat-table td::before {
        content: attr(data-label); /* Mengambil label dari atribut data-label di HTML */
        position: absolute;
        left: 15px;
        font-weight: 600;
        text-align: left;
        color: #6c757d; /* Warna abu-abu muted */
    }
    
    /* Beri sedikit jarak antar entri (baris) */
    .riwayat-table tr {
        margin-bottom: 15px;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    /* Hapus border atas untuk entri pertama di baris */
    .riwayat-table tr:first-child {
        border-top: none;
    }
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    
    <?php if(session('success')): ?>
        <?php
            $displayMessage = is_array(Session::get('success')) ? Session::get('success')[0] : Session::get('success');
        ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-3" role="alert">
            <i class="fas fa-check-circle me-2"></i> <strong>Berhasil!</strong> <?php echo e($displayMessage); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 rounded-3" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i> <strong>Kesalahan!</strong> <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        
        
        <div class="col-lg-7 mb-4">
            <div class="card shadow-lg h-100 border-0 rounded-4 border-top border-5 border-primary">
                <div class="card-header bg-primary text-white fw-bold d-flex align-items-center p-3 rounded-top-4">
                    <i class="fas fa-file-invoice me-2 fa-lg"></i> Faktur Tagihan #<?php echo e($tagihan->id); ?>

                </div>
                <div class="card-body p-4">
                    
                    
                    <div class="text-end mb-4">
                        <?php if($status_lunas): ?>
                            <span class="badge bg-success py-2 px-3 fw-bolder rounded-pill fs-6"><i class="fas fa-check-circle me-1"></i> LUNAS</span>
                        <?php else: ?>
                            <span class="badge bg-danger py-2 px-3 fw-bolder rounded-pill fs-6"><i class="fas fa-exclamation-triangle me-1"></i> BELUM LUNAS</span>
                        <?php endif; ?>
                    </div>
                    
                    
                    <h5 class="fw-bold text-dark mb-3 pb-2 border-bottom"><i class="fas fa-info-circle me-2 text-primary"></i> Rincian Tagihan</h5>
                    
                    <dl class="row mb-4 small">
                        <dt class="col-5 text-muted">Untuk Santri:</dt>
                        <dd class="col-7 text-end fw-bolder"><?php echo e($tagihan->santri->nama ?? 'N/A'); ?></dd>
                        
                        <dt class="col-5 text-muted">Kelas:</dt>
                        <dd class="col-7 text-end fw-semibold"><?php echo e($tagihan->santri->kelas->nama_kelas ?? 'N/A'); ?></dd>
                        
                        <dt class="col-5 text-muted">Deskripsi Tagihan:</dt>
                        <dd class="col-7 text-end text-wrap"><?php echo e($tagihan->keterangan ?? $tagihan->jenis_tagihan); ?></dd>

                        <dt class="col-5 text-muted">Jatuh Tempo:</dt>
                        <dd class="col-7 text-end text-danger fw-bolder"><?php echo e($tagihan->tanggal_jatuh_tempo->translatedFormat('d F Y')); ?></dd>
                    </dl>
                    
                    <hr>

                    
                    <h5 class="fw-bold text-dark mt-4 mb-3 pb-2 border-bottom"><i class="fas fa-calculator me-2 text-primary"></i> Ringkasan Pembayaran</h5>
                    
                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item d-flex justify-content-between px-0 py-2 bg-light rounded-top">
                            <span class="fw-semibold">Total Tagihan:</span>
                            <span class="fw-bolder text-dark">Rp <?php echo e(number_format($tagihan->jumlah_tagihan, 0, ',', '.')); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0 py-2 border-bottom">
                            <span class="fw-semibold text-success">Terkonfirmasi:</span>
                            <span class="fw-bolder text-success">Rp <?php echo e(number_format($tagihan->total_bayar_terkonfirmasi, 0, ',', '.')); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0 py-3 bg-light-subtle rounded-bottom">
                            <span class="fw-bold fs-6 text-uppercase <?php echo e($sisaTagihan > 0 ? 'text-danger' : 'text-success'); ?>">Sisa Tagihan</span>
                            <span class="fw-bolder fs-7 <?php echo e($sisaTagihan > 0 ? 'text-danger' : 'text-success'); ?>">
                                Rp <?php echo e(number_format($sisaTagihan, 0, ',', '.')); ?>

                            </span>
                        </li>
                    </ul>

                </div>
            </div>
        </div>

        
        <div class="col-lg-5 mb-4">
            
            <?php if($status_lunas): ?>
                
                <div class="card shadow-lg h-100 border-0 rounded-4">
                    <div class="card-body text-center py-5 bg-success text-white rounded-4">
                        <i class="fas fa-check-circle fa-4x mb-3"></i>
                        <h4 class="fw-bolder">TAGIHAN INI SUDAH LUNAS</h4>
                        <p class="mb-0 fs-6">Terima kasih. Pembayaran telah selesai.</p>
                        <hr class="text-white-50 my-4">
                        
                        <a href="<?php echo e(route('wali.tagihan.index')); ?>" class="btn btn-light btn-md rounded-pill">
                             <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            <?php else: ?>
                
                <div class="card shadow-lg mb-4 border-0 rounded-4 border-top border-5 border-info">
                    <div class="card-header bg-info text-white fw-bolder d-flex align-items-center p-3 rounded-top-4">
                        <i class="fas fa-university me-2 fa-lg"></i> Instruksi Transfer
                    </div>
                    <div class="card-body p-4">
                        <p class="mb-3 fw-bold">Transfer sebesar <span class="text-danger fw-bolder">Rp <?php echo e(number_format($sisaTagihan, 0, ',', '.')); ?></span> ke salah satu rekening:</p>
                        
                        <ul class="list-group list-group-flush mb-3 border rounded bg-light p-3">
                            
                            <?php $__empty_1 = true; $__currentLoopData = $rekenings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rekening): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <li class="list-group-item px-0 d-flex flex-column align-items-start border-start-0 border-end-0 py-3">
                                    <span class="fw-bold text-dark mb-1"><?php echo e($rekening->nama_bank); ?></span>
                                    <div class="d-flex align-items-center justify-content-between w-100">
                                        
                                        <span class="fw-bolder text-primary fs-5 rekening-number" id="rek-<?php echo e($rekening->id); ?>">
                                            <?php echo e($rekening->nomor_rekening); ?>

                                        </span>
                                        
                                        <button type="button" class="btn btn-sm btn-outline-primary copy-btn flex-shrink-0"
                                                data-rek-number="<?php echo e($rekening->nomor_rekening); ?>"
                                                onclick="copyToClipboard('<?php echo e($rekening->nomor_rekening); ?>', this)">
                                            <i class="fas fa-copy me-1"></i> Salin
                                        </button>
                                    </div>
                                    <small class="text-muted mt-1">A.N. <?php echo e($rekening->atas_nama); ?></small>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <li class="list-group-item text-center text-muted">Data rekening tujuan tidak tersedia.</li>
                            <?php endif; ?>
                        </ul>
                        <p class="small text-muted mb-0"><i class="fas fa-info-circle me-1"></i> Klik tombol Salin untuk menghindari kesalahan pengetikan.</p>
                    </div>
                </div>
                
                
                <div class="card shadow-lg border-0 border-top border-5 border-danger rounded-4">
                    <div class="card-header bg-danger text-white fw-bolder d-flex align-items-center p-3 rounded-top-4">
                        <i class="fas fa-paperclip me-2 fa-lg"></i> Konfirmasi Pembayaran
                    </div>
                    <div class="card-body p-4">
                        <form action="<?php echo e(route('wali.tagihan.bayar', $tagihan)); ?>" method="POST" enctype="multipart/form-data" id="form-bayar"> 
                            <?php echo csrf_field(); ?>
                            
                            
                            <div class="mb-3">
                                <label for="jumlah_bayar" class="form-label fw-semibold">Nominal Dibayarkan</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light fw-bold">Rp</span>
                                    <input type="number" name="jumlah_bayar" id="jumlah_bayar" class="form-control <?php $__errorArgs = ['jumlah_bayar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                        value="<?php echo e(old('jumlah_bayar', $sisaTagihan)); ?>" required min="1" max="<?php echo e($sisaTagihan); ?>" placeholder="Masukkan jumlah...">
                                </div>
                                <div class="form-text text-danger fw-semibold mt-2">Wajib: Rp <?php echo e(number_format($sisaTagihan, 0, ',', '.')); ?></div>
                                <?php $__errorArgs = ['jumlah_bayar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            
                            <div class="mb-3">
                                <label for="rekening_id" class="form-label fw-semibold">Pilih Rekening Tujuan Transfer</label>
                                <select name="rekening_id" id="rekening_id" class="form-select <?php $__errorArgs = ['rekening_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                    <option value="">-- Pilih Rekening --</option>
                                    <?php $__currentLoopData = $rekenings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rekening): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($rekening->id); ?>" <?php echo e(old('rekening_id') == $rekening->id ? 'selected' : ''); ?>>
                                            [<?php echo e($rekening->nama_bank); ?>] A/N: <?php echo e($rekening->atas_nama); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['rekening_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            
                            <div class="mb-4">
                                <label for="bukti_pembayaran" class="form-label fw-semibold">Upload Bukti Pembayaran (JPG/PNG)</label>
                                <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="form-control <?php $__errorArgs = ['bukti_pembayaran'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required accept="image/jpeg, image/png">
                                <div class="form-text">Maksimal 2MB.</div>
                                <?php $__errorArgs = ['bukti_pembayaran'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <button type="submit" id="btn-konfirmasi" class="btn btn-danger w-100 mt-2 btn-lg shadow rounded-pill">
                                <i class="fas fa-paper-plane me-2"></i> Konfirmasi Pembayaran
                            </button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <hr class="my-4">

    
    <div class="row mt-4 mb-5">
        <div class="col-lg-12">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-info text-white fw-bold d-flex align-items-center p-3 rounded-top-4">
                    <i class="fas fa-receipt me-2 fa-lg"></i> Riwayat Pembayaran Anda
                </div>
                <div class="card-body p-4">
                    <?php if($pembayarans->isEmpty()): ?>
                         <div class="text-center py-4 text-muted bg-light rounded border-0">
                            <i class="fas fa-box-open me-2 fs-4"></i>
                            <p class="mb-0 mt-2">Belum ada riwayat pembayaran untuk tagihan ini.</p>
                        </div>
                    <?php else: ?>
                        
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0 align-middle small riwayat-table">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Bayar</th>
                                        <th class="text-end">Jumlah</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Bukti</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $pembayarans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $pembayaran): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $statusBadge = [
                                                'Menunggu' => 'bg-warning text-dark',
                                                'Dikonfirmasi' => 'bg-success-subtle text-success-emphasis',
                                                'Ditolak' => 'bg-danger-subtle text-danger-emphasis',
                                            ][$pembayaran->status_konfirmasi] ?? 'bg-secondary';
                                        ?>
                                        <tr>
                                            
                                            <td class="text-muted" data-label="No. Transaksi">#<?php echo e($index + 1); ?></td> 
                                            <td class="text-nowrap small text-muted" data-label="Tanggal Bayar"><?php echo e($pembayaran->created_at->translatedFormat('d M Y H:i')); ?></td>
                                            <td class="text-end fw-bolder text-dark" data-label="Jumlah Bayar">Rp <?php echo e(number_format($pembayaran->jumlah_bayar, 0, ',', '.')); ?></td>
                                            <td class="text-center" data-label="Status Konfirmasi">
                                                <span class="badge <?php echo e($statusBadge); ?> py-1 px-2 fw-bold"><?php echo e($pembayaran->status_konfirmasi); ?></span>
                                            </td>
                                            
                                            <td class="text-center" data-label="Bukti Transfer">
                                                <?php if($pembayaran->bukti_pembayaran): ?>
                                                <a href="<?php echo e(Storage::url($pembayaran->bukti_pembayaran)); ?>" target="_blank" class="btn btn-sm btn-outline-info rounded-pill px-2" title="Lihat Bukti Pembayaran">
                                                    <i class="fas fa-eye"></i> 
                                                </a>
                                                <?php else: ?>
                                                <span class="text-muted small">N/A</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    
    <div class="row mt-4 mb-5">
        <div class="col-12 text-center">
            
            <a href="<?php echo e(route('wali.tagihan.index')); ?>" class="btn btn-secondary btn-md rounded-pill px-4">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Tagihan
            </a>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
    <script>
        // Fungsi Salin (Copy-to-Clipboard) - Diletakkan di scope global
        function copyToClipboard(text, button) {
            // Hilangkan spasi jika ada, untuk memastikan nomor rekening yang disalin benar
            const textToCopy = text.trim().replace(/\s/g, ''); 
            
            if (navigator.clipboard) {
                // Metode modern (Async Clipboard API)
                navigator.clipboard.writeText(textToCopy).then(function() {
                    const originalIcon = button.querySelector('i').className;
                    const originalText = button.innerHTML;

                    // Feedback visual
                    button.innerHTML = '<i class="fas fa-check me-1"></i> Tersalin!';
                    button.classList.remove('btn-outline-primary');
                    button.classList.add('btn-success');

                    // Kembalikan ke kondisi awal setelah 2 detik
                    setTimeout(() => {
                        button.innerHTML = originalText; // Mengembalikan innerHTML penuh untuk menjaga struktur
                        button.querySelector('i').className = originalIcon; // Mengembalikan ikon
                        button.classList.remove('btn-success');
                        button.classList.add('btn-outline-primary');
                        button.innerHTML = '<i class="fas fa-copy me-1"></i> Salin'; // Memastikan teks kembali benar
                    }, 2000);

                }).catch(function(err) {
                    console.error('Gagal menyalin teks: ', err);
                    alert('Gagal menyalin. Silakan salin manual: ' + text);
                });
            } else {
                // Fallback untuk browser lama (Sync Command)
                const textarea = document.createElement('textarea');
                textarea.value = textToCopy;
                textarea.style.position = 'fixed'; 
                textarea.style.top = 0; 
                textarea.style.left = 0; 
                document.body.appendChild(textarea);
                textarea.focus();
                textarea.select();
                try {
                    document.execCommand('copy');
                    // Tidak perlu alert karena sudah ada feedback di tombol, tapi di fallback ini kita pakai alert
                } catch (err) {
                    alert('Gagal menyalin. Silakan salin manual: ' + text);
                }
                document.body.removeChild(textarea);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const formBayar = document.getElementById('form-bayar');
            const btnKonfirmasi = document.getElementById('btn-konfirmasi');

            if (btnKonfirmasi && formBayar) {
                // Fungsi untuk menonaktifkan tombol dan menampilkan loading
                function disableButton() {
                    btnKonfirmasi.disabled = true;
                    btnKonfirmasi.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...';
                }

                // Listener saat form disubmit
                formBayar.addEventListener('submit', function(e) {
                    // Hanya matikan tombol jika validasi form berhasil
                    // (Browser akan menjalankan validasi native HTML5 sebelum ini)
                    if (formBayar.checkValidity()) {
                        disableButton();
                    }
                });
            }
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.wali', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/wali/tagihan/show.blade.php ENDPATH**/ ?>