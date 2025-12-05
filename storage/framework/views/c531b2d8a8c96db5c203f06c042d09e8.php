<?php $__env->startSection('page_title', 'Pilih Kelas Absensi Harian'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4 text-dark fw-bold">🗓️ Input Absensi Harian <span class="badge bg-primary fs-6 rounded-pill shadow-sm">Langkah 1</span></h2>
            
            
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2"></i> <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i> <?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if(session('warning')): ?>
                <div class="alert alert-warning alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> <?php echo e(session('warning')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <div class="card shadow mb-4 border-0 rounded-4">
                <div class="card-header py-3 bg-primary text-white d-flex justify-content-between align-items-center rounded-top-4">
                    <h5 class="m-0 font-weight-bold text-white fs-5">
                        Pilih Kelas Absensi
                    </h5>
                    <small class="badge bg-light text-dark shadow-sm rounded-pill px-3 py-2 fw-bold">
                         <i class="fas fa-calendar-alt me-1"></i> Tanggal: <?php echo e($date); ?>

                    </small>
                </div>
                
                <div class="card-body p-4">
                    <p class="text-muted small border-bottom pb-3 mb-4 fw-semibold">Silakan pilih kelas yang ingin diinput absensinya untuk melanjutkan ke pemilihan kegiatan.</p>
                    
                    
                    <div class="row g-4">
                        <?php $__empty_1 = true; $__currentLoopData = $kelasListData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kelas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $tingkat = (int) $kelas->tingkat; // Ambil nilai tingkat (7, 8, 9, 10, dst.)
                                
                                // ✅ PERBAIKAN LOGIKA: Sekarang menggunakan kolom 'tingkat', bukan ID
                                $color = match (true) {
                                    $tingkat >= 7 && $tingkat <= 9 => 'success',   // MTs (Tingkat 7, 8, 9)
                                    $tingkat >= 10 && $tingkat <= 12 => 'info',    // MA (Tingkat 10, 11, 12)
                                    $tingkat == 13 => 'danger',                   // Mutakhorijin (Tingkat 13)
                                    default => 'secondary',
                                };
                                
                                $level = match (true) {
                                    $tingkat >= 7 && $tingkat <= 9 => 'MTs (Tsanawiyah)',
                                    $tingkat >= 10 && $tingkat <= 12 => 'MA (Aliyah)',
                                    $tingkat == 13 => 'Mutakhorijin',
                                    default => 'Tingkat Lain',
                                };
                            ?>
                            
                            
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-2">
                                
                                <a href="<?php echo e(route('admin.absensi_baru.select_activity', $kelas->id)); ?>" class="text-decoration-none d-block">
                                    <div class="card card-hover border-0 border-start border-5 border-<?php echo e($color); ?> shadow-lg h-100 rounded-3">
                                        <div class="card-body p-4">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1">
                                                    <div class="font-weight-bold text-uppercase text-<?php echo e($color); ?> mb-1 small">
                                                        <?php echo e($level); ?>

                                                    </div>
                                                    
                                                    <div class="h5 mb-0 font-weight-bold text-dark fs-4"><?php echo e($kelas->nama_kelas); ?></div>
                                                    <p class="small text-muted mt-2 mb-0 fw-semibold">Lanjutkan ke Pilih Kegiatan</p>
                                                </div>
                                                <div class="ms-3 flex-shrink-0">
                                                    
                                                    <i class="fas fa-school fa-3x text-<?php echo e($color); ?> opacity-75"></i>
                                                </div>
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
    /* Custom effect for hover */
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15) !important;
        transition: all 0.3s ease-in-out;
    }
    /* Dashed border for empty state */
    .border-dashed {
        border: 2px dashed #ffc107 !important;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/admin/absensi/harian/index.blade.php ENDPATH**/ ?>