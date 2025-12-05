<?php $__env->startSection('title', 'Detail Tagihan'); ?>
<?php $__env->startSection('page_title', 'Detail Tagihan: ' . ($tagihan->keterangan ?? $tagihan->jenis_tagihan)); ?>

<?php $__env->startSection('content'); ?>

    
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i> <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        
        
        <div class="col-lg-7 mb-4">
            <div class="card shadow-lg h-100 border-0 rounded-4">
                <div class="card-header bg-primary text-white fw-bold d-flex align-items-center p-3 rounded-top-4">
                    <i class="fas fa-file-invoice me-2 fa-lg"></i> Informasi Tagihan
                </div>
                <div class="card-body p-4">
                    
                    
                    <h5 class="fw-bold text-dark mb-4 pb-2 border-bottom"><i class="fas fa-user-graduate me-2 text-primary"></i> Data Santri & Tagihan</h5>
                    
                    
                    <div class="list-group list-group-flush mb-4">
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted small">Santri</span>
                            <span class="fw-bolder text-dark"><?php echo e($tagihan->santri->nama ?? 'N/A'); ?></span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted small">Kelas</span>
                            <span class="badge bg-info-subtle text-info-emphasis fw-bold"><?php echo e($tagihan->santri->kelas->nama_kelas ?? 'N/A'); ?></span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted small">Deskripsi Tagihan</span>
                            <span class="fw-semibold text-wrap text-end" style="max-width: 60%;"><?php echo e($tagihan->keterangan ?? $tagihan->jenis_tagihan); ?></span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted small">Tanggal Tagihan</span>
                            <span class="small"><?php echo e($tagihan->created_at->translatedFormat('d F Y')); ?></span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0 border-bottom-0">
                            <span class="text-muted small">Batas Pembayaran</span>
                            <span class="text-danger fw-bolder">
                                <i class="fas fa-clock me-1"></i> <?php echo e($tagihan->tanggal_jatuh_tempo->translatedFormat('d F Y')); ?>

                            </span>
                        </div>
                    </div>
                    
                    
                    <h5 class="fw-bold text-dark mt-4 mb-3 pb-2 border-bottom"><i class="fas fa-calculator me-2 text-primary"></i> Rincian Keuangan</h5>
                    
                    <div class="row g-2">
                        <div class="col-12">
                            <div class="card bg-light shadow-sm border-start border-primary border-4 py-2 px-3">
                                <div class="d-flex justify-content-between">
                                    <div class="small text-muted">Jumlah Tagihan</div>
                                    <div class="fw-bolder text-primary fs-6">Rp <?php echo e(number_format($tagihan->jumlah_tagihan, 0, ',', '.')); ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card bg-success-subtle border-start border-success border-4 py-2 px-3">
                                <div class="d-flex justify-content-between">
                                    <div class="small text-success fw-semibold">Total Dibayar (Terkonfirmasi)</div>
                                    <div class="fw-bolder text-success fs-6">Rp <?php echo e(number_format($tagihan->total_bayar_terkonfirmasi, 0, ',', '.')); ?></div> 
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="card bg-white shadow-lg border-start border-4 <?php echo e($sisaTagihan > 0 ? 'border-danger' : 'border-success'); ?> py-3 px-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="fw-bold fs-5 text-dark">Sisa Pembayaran</div>
                                    <div class="fw-bolder fs-4 <?php echo e($sisaTagihan > 0 ? 'text-danger' : 'text-success'); ?>">
                                        Rp <?php echo e(number_format($sisaTagihan, 0, ',', '.')); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        
        <div class="col-lg-5 mb-4">
            <?php if($tagihan->isLunas()): ?>
                <div class="card shadow-lg h-100 border-0 rounded-4">
                    <div class="card-body text-center py-5 bg-success text-white rounded-4">
                        <i class="fas fa-check-circle fa-4x mb-3"></i>
                        <h4 class="fw-bolder">TAGIHAN INI SUDAH LUNAS</h4>
                        <p class="mb-0 fs-6">Pembayaran telah dikonfirmasi dan selesai. Terima kasih.</p>
                        <hr class="text-white-50 my-4">
                        <a href="<?php echo e(route('wali.tagihan.index')); ?>" class="btn btn-light btn-lg rounded-pill">
                             <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Tagihan
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <div class="card shadow-lg border-0 border-top border-5 border-danger h-100 rounded-4">
                    <div class="card-header bg-danger text-white fw-bolder d-flex align-items-center p-3 rounded-top-4">
                        <i class="fas fa-hand-holding-usd me-2 fa-lg"></i> Form Konfirmasi Pembayaran
                    </div>
                    <div class="card-body p-4">
                        <form action="<?php echo e(route('wali.tagihan.bayar', $tagihan)); ?>" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            
                            
                            <div class="mb-3">
                                <label for="jumlah_bayar" class="form-label fw-semibold">Jumlah yang Dibayarkan</label>
                                <div class="input-group input-group-lg">
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
                                <div class="form-text text-danger fw-semibold mt-2">Maksimal yang harus dibayar: <span class="fs-6 fw-bolder">Rp <?php echo e(number_format($sisaTagihan, 0, ',', '.')); ?></span></div>
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
                                <label for="rekening_id" class="form-label fw-semibold">Transfer ke Rekening Tujuan</label>
                                <select name="rekening_id" id="rekening_id" class="form-select <?php $__errorArgs = ['rekening_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                    <option value="">Pilih Rekening Tujuan...</option>
                                    <?php $__currentLoopData = $rekenings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rekening): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($rekening->id); ?>" <?php echo e(old('rekening_id') == $rekening->id ? 'selected' : ''); ?>>
                                            [<?php echo e($rekening->nama_bank); ?>] A/N: <?php echo e($rekening->atas_nama); ?> (<?php echo e($rekening->nomor_rekening); ?>)
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <div class="form-text">Pastikan Anda memilih rekening tujuan yang benar.</div>
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
                                <div class="form-text">Maksimal 2MB. Bukti ini wajib untuk verifikasi Admin.</div>
                                <?php $__errorArgs = ['bukti_pembayaran'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <button type="submit" class="btn btn-success w-100 mt-2 btn-lg shadow rounded-pill">
                                <i class="fas fa-paper-plane me-2"></i> Konfirmasi Pembayaran
                            </button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-info text-white fw-bold d-flex align-items-center p-3 rounded-top-4">
                    <i class="fas fa-receipt me-2 fa-lg"></i> Riwayat Pembayaran (untuk tagihan ini)
                </div>
                <div class="card-body p-0 p-md-4">
                    
                    <?php if($pembayarans->isEmpty()): ?>
                         <div class="text-center py-4 text-muted bg-light rounded border-0">
                            <i class="fas fa-box-open me-2 fs-4"></i>
                            <p class="mb-0 mt-2">Belum ada riwayat pembayaran untuk tagihan ini.</p>
                        </div>
                    <?php else: ?>
                        
                        
                        <div class="table-responsive d-none d-md-block">
                            <table class="table table-striped table-hover mb-0 align-middle small">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 5%;">#</th>
                                        <th style="width: 20%;">Tanggal Bayar</th>
                                        <th style="width: 25%;" class="text-end">Jumlah Bayar</th>
                                        <th style="width: 30%;" class="text-center">Status Konfirmasi</th>
                                        <th style="width: 20%;" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $pembayarans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $pembayaran): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $statusClass = [
                                                'Menunggu' => 'bg-warning text-dark',
                                                'Dikonfirmasi' => 'bg-success-subtle text-success-emphasis',
                                                'Ditolak' => 'bg-danger-subtle text-danger-emphasis',
                                            ][$pembayaran->status_konfirmasi] ?? 'bg-secondary';
                                        ?>
                                        <tr>
                                            <td class="text-muted"><?php echo e($index + 1); ?></td>
                                            <td class="text-nowrap small text-muted"><?php echo e($pembayaran->created_at->translatedFormat('d M Y H:i')); ?></td>
                                            <td class="text-end fw-bolder text-dark fs-6">Rp <?php echo e(number_format($pembayaran->jumlah_bayar, 0, ',', '.')); ?></td>
                                            <td class="text-center">
                                                <span class="badge <?php echo e($statusClass); ?> py-2 px-3 fw-bold"><?php echo e($pembayaran->status_konfirmasi); ?></span>
                                            </td>
                                            <td class="text-center">
                                                <a href="<?php echo e(Storage::url($pembayaran->bukti_pembayaran)); ?>" target="_blank" class="btn btn-sm btn-outline-info rounded-pill" title="Lihat Bukti Pembayaran">
                                                    <i class="fas fa-image me-1"></i> Bukti
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        
                        
                        <div class="list-group d-block d-md-none p-3">
                            <?php $__currentLoopData = $pembayarans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $pembayaran): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $statusColor = [
                                        'Menunggu' => 'border-warning',
                                        'Dikonfirmasi' => 'border-success',
                                        'Ditolak' => 'border-danger',
                                    ][$pembayaran->status_konfirmasi] ?? 'border-secondary';
                                    $statusBadge = [
                                        'Menunggu' => 'bg-warning text-dark',
                                        'Dikonfirmasi' => 'bg-success-subtle text-success-emphasis',
                                        'Ditolak' => 'bg-danger-subtle text-danger-emphasis',
                                    ][$pembayaran->status_konfirmasi] ?? 'bg-secondary';
                                ?>
                                <div class="list-group-item list-group-item-action mb-3 shadow-sm border border-4 <?php echo e($statusColor); ?> rounded-3">
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <h6 class="mb-1 fw-bold text-dark">Pembayaran ke-<?php echo e($index + 1); ?></h6>
                                        <span class="badge <?php echo e($statusBadge); ?> py-2 px-3 fw-bold flex-shrink-0"><?php echo e($pembayaran->status_konfirmasi); ?></span>
                                    </div>
                                    <hr class="my-2">
                                    <div class="row small text-secondary">
                                        <div class="col-12 mb-2">
                                            <i class="fas fa-calendar-check me-1"></i> Tgl Bayar: <strong class="text-dark"><?php echo e($pembayaran->created_at->translatedFormat('d M Y H:i')); ?></strong>
                                        </div>
                                        <div class="col-12 mb-2">
                                            <i class="fas fa-money-bill-wave me-1"></i> Jumlah: 
                                            <span class="badge bg-primary fs-6 py-1 px-2 fw-bold ms-1">
                                                Rp <?php echo e(number_format($pembayaran->jumlah_bayar, 0, ',', '.')); ?>

                                            </span>
                                        </div>
                                    </div>
                                    <div class="mt-2 text-center">
                                        <a href="<?php echo e(Storage::url($pembayaran->bukti_pembayaran)); ?>" target="_blank" class="btn btn-sm btn-outline-info w-100 rounded-pill">
                                            <i class="fas fa-image me-1"></i> Lihat Bukti Pembayaran
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    
    <div class="row mt-4 mb-5">
        <div class="col-12 text-center text-md-end">
            <a href="<?php echo e(route('wali.tagihan.index')); ?>" class="btn btn-secondary btn-lg rounded-pill px-4">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Tagihan
            </a>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.wali', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/wali/tagihan/show.blade.php ENDPATH**/ ?>