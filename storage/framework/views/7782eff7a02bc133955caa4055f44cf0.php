<?php $__env->startSection('title', 'Tagihan & Pembayaran'); ?>
<?php $__env->startSection('page_title', 'Daftar Tagihan'); ?>

<?php $__env->startSection('content'); ?>

    
    <?php
        // Filter tagihan: Hanya tampilkan yang BELUM LUNAS (atau Sebagian Lunas)
        $tagihansAktif = $tagihans->filter(function ($tagihan) {
            // Kita asumsikan ada method isLunas() di Model Tagihan
            return !$tagihan->isLunas();
        });
    ?>
    
    
    <ul class="nav nav-pills mb-4 justify-content-center justify-content-md-start p-2 shadow-sm rounded-pill bg-light" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-bold me-2 mb-2 mb-md-0 rounded-pill px-4 text-dark" id="tagihan-tab" data-bs-toggle="tab" data-bs-target="#tagihan-content" type="button" role="tab" aria-controls="tagihan-content" aria-selected="true">
                <i class="fas fa-file-invoice-dollar me-2 text-danger"></i> Tagihan Aktif (<?php echo e($tagihansAktif->count()); ?>)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold rounded-pill px-4 text-dark" id="riwayat-tab" data-bs-toggle="tab" data-bs-target="#riwayat-content" type="button" role="tab" aria-controls="riwayat-content" aria-selected="false">
                <i class="fas fa-history me-2 text-info"></i> Riwayat Pembayaran (<?php echo e($riwayatPembayaran->count()); ?>)
            </button>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        
        
        <div class="tab-pane fade show active" id="tagihan-content" role="tabpanel" aria-labelledby="tagihan-tab">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-danger text-white fw-bold rounded-top-4 p-3"><i class="fas fa-money-check-alt me-2"></i> Tagihan yang Belum Lunas</div>
                <div class="card-body p-3 p-md-4">
            
                    
                    <?php if($tagihansAktif->isEmpty()): ?> 
                        <div class="text-center py-5 text-muted bg-light rounded border-danger border-2 border-dashed">
                            <i class="fas fa-frown me-2 fa-2x text-danger"></i>
                            <h5 class="mb-0 mt-3 fw-bold">Tidak ada tagihan aktif saat ini.</h5>
                            <p class="small mb-0">Semua tagihan Anda telah lunas. Terima kasih!</p>
                        </div>
                    <?php else: ?>
                        
                        <div class="table-responsive d-none d-md-block">
                            <table class="table table-striped table-hover align-middle mb-0 small">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 5%;">#</th>
                                        <th style="width: 25%;">Santri</th>
                                        <th style="width: 25%;">Deskripsi Tagihan</th>
                                        <th style="width: 15%;">Jatuh Tempo</th>
                                        <th style="width: 15%;" class="text-end">Jumlah</th>
                                        <th style="width: 10%;" class="text-center">Status</th>
                                        <th style="width: 10%;" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $tagihansAktif; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $tagihan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="text-muted"><?php echo e($index + 1); ?></td>
                                            
                                            <td>
                                                <span class="fw-semibold text-dark"><?php echo e($tagihan->santri->nama ?? 'Nama Santri Kosong'); ?></span> 
                                                <br>
                                                <small class="text-secondary badge bg-info-subtle text-info-emphasis"><?php echo e($tagihan->santri->kelas->nama_kelas ?? 'Kelas N/A'); ?></small>
                                            </td>
                                            
                                            
                                            <td class="small"><?php echo e($tagihan->keterangan ?? $tagihan->jenis_tagihan); ?></td>
                                            
                                            <td class="text-nowrap small text-muted"><?php echo e($tagihan->tanggal_jatuh_tempo->translatedFormat('d F Y')); ?></td>
                                            
                                            
                                            <td class="fw-bolder text-end text-danger fs-6">Rp <?php echo e(number_format($tagihan->jumlah_tagihan, 0, ',', '.')); ?></td>
                                            
                                            
                                            <td class="text-center">
                                                <?php if($tagihan->total_bayar_terkonfirmasi > 0): ?>
                                                    <span class="badge bg-warning text-dark px-3 py-2 fw-bold"><i class="fas fa-exclamation-triangle me-1"></i> SEBAGIAN</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger-subtle text-danger-emphasis px-3 py-2 fw-bold"><i class="fas fa-times-circle me-1"></i> BELUM BAYAR</span>
                                                <?php endif; ?>
                                            </td>
                                            
                                            
                                            <td class="text-center">
                                                <a href="<?php echo e(route('wali.tagihan.show', $tagihan)); ?>" class="btn btn-sm btn-danger shadow-sm rounded-pill" title="Lihat Detail & Bayar">
                                                    <i class="fas fa-money-bill-wave"></i> Bayar
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        
                        
                        <div class="list-group d-block d-md-none">
                            <?php $__currentLoopData = $tagihansAktif; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tagihan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    // Tentukan warna border berdasarkan status pembayaran
                                    $statusColor = (($tagihan->total_bayar_terkonfirmasi > 0) ? 'warning' : 'danger');
                                    $statusBadgeClass = (($tagihan->total_bayar_terkonfirmasi > 0) ? 'bg-warning text-dark' : 'bg-danger-subtle text-danger-emphasis');
                                ?>
                                <div class="list-group-item list-group-item-action mb-3 shadow-sm border border-4 border-<?php echo e($statusColor); ?> rounded-3">
                                    <div class="d-flex w-100 justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1 fw-bold text-dark"><?php echo e($tagihan->santri->nama ?? 'Santri N/A'); ?></h6>
                                            <p class="mb-1 small text-muted badge bg-info-subtle text-info-emphasis"><?php echo e($tagihan->santri->kelas->nama_kelas ?? 'Kelas N/A'); ?></p>
                                        </div>
                                        <span class="badge bg-danger fs-5 py-2 px-3 fw-bold flex-shrink-0">
                                            Rp <?php echo e(number_format($tagihan->jumlah_tagihan, 0, ',', '.')); ?>

                                        </span>
                                    </div>
                                    <hr class="my-2">
                                    <div class="d-flex w-100 justify-content-between align-items-center small">
                                        <p class="mb-0 text-secondary">
                                            <i class="fas fa-calendar-alt me-1"></i> Jt Tempo: <span class="fw-semibold text-dark"><?php echo e($tagihan->tanggal_jatuh_tempo->translatedFormat('d M Y')); ?></span>
                                        </p>
                                        <span class="badge <?php echo e($statusBadgeClass); ?> fw-bold py-1 px-2">
                                            <?php echo e(($tagihan->total_bayar_terkonfirmasi > 0) ? 'SEBAGIAN' : 'BELUM BAYAR'); ?>

                                        </span>
                                    </div>
                                    <div class="mt-3 text-end">
                                        <a href="<?php echo e(route('wali.tagihan.show', $tagihan)); ?>" class="btn btn-sm btn-danger w-100 rounded-pill">
                                            <i class="fas fa-money-bill-wave me-1"></i> Detail & Bayar Tagihan
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        
        <div class="tab-pane fade" id="riwayat-content" role="tabpanel" aria-labelledby="riwayat-tab">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-info text-white fw-bold rounded-top-4 p-3"><i class="fas fa-receipt me-2"></i> Riwayat Pembayaran Anda</div>
                <div class="card-body p-3 p-md-4">
            
                    <?php if($riwayatPembayaran->isEmpty()): ?>
                        <div class="text-center py-5 text-muted bg-light rounded border-info border-2 border-dashed">
                            <i class="fas fa-box-open me-2 fa-2x text-info"></i>
                            <h5 class="mb-0 mt-3 fw-bold">Belum ada riwayat pembayaran.</h5>
                            <p class="small mb-0">Riwayat akan muncul di sini setelah Anda melakukan pembayaran.</p>
                        </div>
                    <?php else: ?>
                        
                        <div class="table-responsive d-none d-md-block">
                            <table class="table table-striped table-hover align-middle mb-0 small">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 5%;">#</th>
                                        <th style="width: 35%;">Tagihan</th>
                                        <th style="width: 15%;">Tanggal Bayar</th>
                                        <th style="width: 15%;" class="text-end">Jumlah Bayar</th>
                                        <th style="width: 15%;">Metode</th>
                                        <th style="width: 15%;" class="text-center">Status Konfirmasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $riwayatPembayaran; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $pembayaran): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $statusClass = [
                                                'Menunggu' => 'bg-warning text-dark',
                                                'Dikonfirmasi' => 'bg-success-subtle text-success-emphasis',
                                                'Ditolak' => 'bg-danger-subtle text-danger-emphasis',
                                            ][$pembayaran->status_konfirmasi] ?? 'bg-secondary';
                                        ?>
                                        <tr>
                                            <td class="text-muted"><?php echo e($index + 1); ?></td>
                                            <td>
                                                <span class="fw-semibold text-dark"><?php echo e($pembayaran->tagihan->santri->nama ?? 'Santri N/A'); ?></span>
                                                <br>
                                                <small class="text-secondary badge bg-info-subtle text-info-emphasis"><?php echo e($pembayaran->tagihan->keterangan ?? $pembayaran->tagihan->jenis_tagihan ?? 'N/A'); ?></small>
                                            </td>
                                            <td class="text-nowrap small text-muted"><?php echo e($pembayaran->created_at->translatedFormat('d M Y H:i')); ?></td>
                                            <td class="text-end fw-bolder text-dark fs-6">Rp <?php echo e(number_format($pembayaran->jumlah_bayar, 0, ',', '.')); ?></td>
                                            <td><span class="small"><?php echo e($pembayaran->rekening->nama_bank ?? 'Transfer'); ?></span></td>
                                            <td class="text-center">
                                                <span class="badge <?php echo e($statusClass); ?> py-2 px-3 fw-bold"><?php echo e($pembayaran->status_konfirmasi); ?></span>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        
                        
                        <div class="list-group d-block d-md-none">
                            <?php $__currentLoopData = $riwayatPembayaran; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pembayaran): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                        <h6 class="mb-1 fw-bold text-dark"><?php echo e($pembayaran->tagihan->santri->nama ?? 'Santri N/A'); ?></h6>
                                        <span class="badge <?php echo e($statusBadge); ?> py-2 px-3 fw-bold flex-shrink-0"><?php echo e($pembayaran->status_konfirmasi); ?></span>
                                    </div>
                                    <p class="mb-1 small text-muted badge bg-info-subtle text-info-emphasis"><?php echo e($pembayaran->tagihan->keterangan ?? $pembayaran->tagihan->jenis_tagihan ?? 'Tagihan N/A'); ?></p>
                                    
                                    <hr class="my-2">
                                    
                                    <div class="row small text-secondary">
                                        <div class="col-6">
                                            <i class="fas fa-calendar-check me-1"></i> Tgl: <strong class="text-dark"><?php echo e($pembayaran->created_at->translatedFormat('d M Y')); ?></strong>
                                        </div>
                                        <div class="col-6 text-end">
                                            <i class="fas fa-money-check-alt me-1"></i> Met.: <strong class="text-dark"><?php echo e($pembayaran->rekening->nama_bank ?? 'Transfer'); ?></strong>
                                        </div>
                                    </div>
                                    <div class="mt-3 text-center">
                                        <span class="badge bg-primary fs-6 py-2 px-4 fw-bold">
                                            Rp <?php echo e(number_format($pembayaran->jumlah_bayar, 0, ',', '.')); ?>

                                        </span>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    
    <?php $__env->startPush('css'); ?>
    <style>
        .nav-pills .nav-link.active {
            background-color: #f7e6e7; /* Light background for active tab */
            color: #dc3545 !important; /* Text color red */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .nav-pills .nav-link {
            color: #495057; /* Default text color */
            transition: all 0.3s;
        }
        .nav-pills .nav-item:last-child .nav-link.active {
             background-color: #d1ecf1; /* Light cyan for riwayat active */
             color: #0d6efd !important;
        }

        .border-dashed {
            border-style: dashed !important;
        }

        /* Peningkatan estetika pada badge di mobile view */
        .list-group-item .badge {
            font-size: 0.8rem;
        }
    </style>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.wali', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/wali/tagihan/index.blade.php ENDPATH**/ ?>