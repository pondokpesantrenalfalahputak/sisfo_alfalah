<?php $__env->startSection('title', 'Daftar Santri'); ?>
<?php $__env->startSection('page_title', 'Santri Asuhan'); ?>

<?php $__env->startSection('content'); ?>

    <div class="card shadow-lg border-0 mb-4 rounded-4">
        
        
        <div class="card-header bg-primary text-white fw-bold d-flex align-items-center p-3 rounded-top-4 header-themed-primary">
            <i class="fas fa-users me-2 fs-4"></i> Daftar Santri yang Anda Asuh
        </div>
        
        <div class="card-body p-3 p-md-4">
            
            <?php if($santris->isEmpty()): ?>
                
                <div class="text-center py-5 text-muted bg-light rounded border-primary border-2 border-dashed">
                    <h5 class="mb-2"><i class="fas fa-exclamation-circle me-2 fa-2x text-primary"></i></h5>
                    <p class="mb-0 fw-bold fs-6">Saat ini Anda belum memiliki santri yang terdaftar sebagai asuhan Anda.</p>
                    <p class="small text-secondary mb-0">Silakan hubungi administrator jika ini adalah kesalahan.</p>
                </div>
            <?php else: ?>
                
                
                <div class="table-responsive d-none d-md-block">
                    <table class="table table-striped table-hover align-middle mb-0 small">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 5%;">#</th>
                                <th style="width: 35%;">NAMA SANTRI</th>
                                <th style="width: 15%;">NIS</th>
                                <th style="width: 25%;">KELAS</th>
                                <th style="width: 20%;" class="text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $santris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $santri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="align-middle">
                                    <td class="text-muted"><?php echo e($index + 1); ?></td>
                                    
                                    
                                    <td>
                                        <span class="fw-bolder text-dark"><?php echo e(strtoupper($santri->nama)); ?></span>
                                    </td>
                                    
                                    
                                    <td>
                                        <span class="text-secondary small"><?php echo e($santri->nis ?? 'N/A'); ?></span>
                                    </td>
                                    
                                    
                                    <td>
                                        <span class="badge bg-info-subtle text-info-emphasis fw-bold p-2 rounded-pill">
                                            <?php echo e($santri->kelas->nama_kelas ?? 'Belum Ada Kelas'); ?>

                                        </span>
                                    </td>
                                    
                                    
                                    <td class="text-center">
                                        <a href="<?php echo e(route('wali.santri.show', $santri)); ?>" class="btn btn-sm btn-primary shadow-sm rounded-pill px-3" title="Lihat Detail Santri">
                                            <i class="fas fa-address-card me-1"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                
                
                <div class="list-group d-block d-md-none">
                    <?php $__currentLoopData = $santris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $santri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        
                        <div class="list-group-item list-group-item-action **my-4** shadow-sm border border-2 border-primary rounded-3 card-mobile-santri-detail">
                            <div class="d-flex w-100 justify-content-between align-items-start">
                                <h6 class="mb-1 fw-bolder text-dark text-truncate">
                                    <?php echo e($index + 1); ?>. <?php echo e(strtoupper($santri->nama)); ?>

                                </h6>
                                <span class="badge bg-info-subtle text-info-emphasis fw-bold py-1 px-2 rounded-pill flex-shrink-0"> 
                                    <?php echo e($santri->kelas->nama_kelas ?? 'N/A'); ?>

                                </span>
                            </div>
                            
                            <hr class="my-2">
                            
                            <p class="mb-1 small text-muted d-flex justify-content-between">
                                <span class="fw-semibold"><i class="fas fa-id-card-alt me-1 text-primary"></i> NIS:</span> 
                                <span class="fw-bold text-dark"><?php echo e($santri->nis ?? '-'); ?></span>
                            </p>
                            
                            <div class="text-end mt-3">
                                 <a href="<?php echo e(route('wali.santri.show', $santri)); ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold">
                                    <i class="fas fa-search me-1"></i> Lihat Detail Santri
                                </a>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
    <style>
        .header-themed-primary {
            padding-top: 1rem !important; 
            padding-bottom: 1rem !important;
            font-size: 1.1rem;
        }

        /* CSS Tambahan untuk pemisah dashed (jika ada pesan kosong) */
        .border-dashed {
            border-style: dashed !important;
        }

        /* Hover effect pada list group item di mobile */
        .card-mobile-santri-detail:hover {
            background-color: #f8f9fa;
        }

        /* Peningkatan visibility Nama Santri */
        .card-mobile-santri-detail h6.fw-bolder {
            font-size: 1.0rem; 
        }
        
        /* Penyesuaian font utama Mobile Card */
        @media (max-width: 767.98px) {
            /* Menyesuaikan tombol outline agar terlihat lebih lembut */
            .btn-outline-primary {
                border-width: 1.5px !important; 
            }
        }
    </style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.wali', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/wali/santri/index.blade.php ENDPATH**/ ?>