<?php $__env->startSection('page_title', 'Pilih Kelas Absensi Harian'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert">
                    <i class="fas fa-check-circle me-2"></i> <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i> <?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if(session('warning')): ?>
                <div class="alert alert-warning alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> <?php echo e(session('warning')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            
            <div class="card shadow mb-4 border-left-primary rounded-4"> 
                <div class="card-header py-3 bg-primary text-white d-flex flex-column flex-md-row justify-content-between align-items-md-center rounded-top-4">
                    <span class="badge bg-light text-dark shadow-sm rounded-pill px-3 py-2 fw-semibold">
                        <i class="fas fa-calendar-alt me-1"></i> Tanggal: <?php echo e($date); ?>

                    </span>
                </div>
                
                <div class="card-body p-4">
                    <p class="text-info small border-bottom pb-3 mb-4 fw-semibold">
                        <i class="fas fa-info-circle me-1"></i> Silakan pilih kelas yang ingin diinput absensinya untuk melanjutkan ke pemilihan kegiatan.
                    </p>
                    
                    
                    <div class="row g-3 g-md-4"> 
                        <?php $__empty_1 = true; $__currentLoopData = $kelasListData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kelas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $tingkat = (int) $kelas->tingkat; 
                                
                                $color = match (true) {
                                    $tingkat >= 7 && $tingkat <= 9 => 'success',   // MTs
                                    $tingkat >= 10 && $tingkat <= 12 => 'info',    // MA
                                    $tingkat == 13 => 'danger',                   // Mutakhorijin
                                    default => 'secondary',
                                };
                                
                                $level = match (true) {
                                    $tingkat >= 7 && $tingkat <= 9 => 'MTs (Tsanawiyah)',
                                    $tingkat >= 10 && $tingkat <= 12 => 'MA (Aliyah)',
                                    $tingkat == 13 => 'Mutakhorijin',
                                    default => 'Tingkat Lain',
                                };
                            ?>
                            
                            
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 **col-12**"> 
                                <a href="<?php echo e(route('admin.absensi_baru.select_activity', $kelas->id)); ?>" class="text-decoration-none d-block card-link-item">
                                    
                                    <div class="card card-hover border-0 border-end border-5 border-<?php echo e($color); ?> shadow-sm h-100 rounded-4">
                                        <div class="card-body p-4 d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                
                                                <div class="font-weight-bold text-uppercase text-<?php echo e($color); ?> **text-xs** mb-1"> 
                                                    <?php echo e($level); ?>

                                                </div>
                                                
                                                <div class="h5 mb-0 font-weight-bold text-dark **fs-4 text-truncate**"><?php echo e($kelas->nama_kelas); ?></div>
                                                <p class="small text-muted mt-2 mb-0 fw-semibold">
                                                    <i class="fas fa-hand-point-right me-1"></i> Klik untuk Absensi
                                                </p>
                                            </div>
                                            <div class="ms-3 flex-shrink-0">
                                                
                                                <i class="fas fa-arrow-circle-right fa-2x text-<?php echo e($color); ?> opacity-75 card-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="col-12">
                                <div class="alert alert-warning text-center py-5 rounded-3 border-dashed">
                                    <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                                    <h5 class="fw-bold">Tidak Ada Kelas Aktif</h5>
                                    <p class="mb-0">Mohon pastikan data kelas sudah terdaftar dan aktif di sistem.</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('css'); ?>
<style>
    /* Custom utility class untuk teks ekstra kecil (jika tidak ada di template) */
    .text-xs {
        font-size: 0.75rem !important;
    }
    
    /* Custom effect for hover */
    .card-link-item .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15) !important;
        transition: all 0.3s ease-in-out;
    }
    
    /* Ikon dan border color effect on hover */
    .card-link-item:hover .card-icon {
        transform: translateX(5px);
        transition: transform 0.3s ease;
    }

    /* Dashed border for empty state */
    .border-dashed {
        border: 2px dashed #ffc107 !important;
        padding: 2rem;
    }

    /* Penyesuaian tampilan mobile */
    @media (max-width: 767px) {
        /* Kartu di mobile tampil 2 kolom */
        .col-sm-6 {
            flex: 0 0 auto;
            width: 50%;
        }
        /* Jika ingin 1 kolom penuh di mobile, ganti col-sm-6 dengan col-12 */
        
        .card-body {
            padding: 1rem !important; /* Kurangi padding di mobile */
        }
        .fa-2x {
            font-size: 1.5em; /* Perkecil ikon di mobile */
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/admin/absensi/harian/index.blade.php ENDPATH**/ ?>