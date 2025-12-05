<?php $__env->startSection('page_title', 'Pilih Kegiatan Absensi'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4 text-dark fw-bold">📋 Pilih Kegiatan Absensi <span class="badge bg-warning fs-6 rounded-pill shadow-sm">Langkah 2</span></h2>
            
            <div class="card shadow mb-4 border-0 rounded-4">
                <div class="card-header py-3 bg-warning text-dark d-flex justify-content-between align-items-center rounded-top-4">
                    <h5 class="m-0 font-weight-bold text-dark fs-5">
                        Pilih Kegiatan untuk Kelas <?php echo e($kelas_nama); ?>

                    </h5>
                    <small class="badge bg-light text-dark shadow-sm rounded-pill px-3 py-2 fw-bold">
                        <i class="fas fa-calendar-alt me-1"></i> Tanggal: <?php echo e($date); ?>

                    </small>
                </div>
                
                <div class="card-body p-4">
                    
                    
                    <a href="<?php echo e(route('admin.absensi_baru.index')); ?>" class="btn btn-outline-primary mb-4 rounded-pill px-4 fw-semibold">
                        <i class="fas fa-arrow-alt-circle-left me-1"></i> Ganti Kelas
                    </a>
                    
                    <p class="text-muted small border-bottom pb-3 mb-4 fw-semibold">Pilih kategori kegiatan, lalu klik pada kegiatan spesifik di bawah ini untuk memulai input absensi.</p>
                    
                    <div class="row g-4">
                        <?php $__empty_1 = true; $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jenis => $kegiatanList): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            
                            <div class="col-lg-4 col-md-6 mb-2">
                                <?php
                                    // SINKRONISASI: Penentuan warna border berdasarkan Jenis Kegiatan (sesuai Controller)
                                    $borderColor = match ($jenis) {
                                        'Sholat' => 'primary', // Warna untuk Kategori Sholat
                                        'Mengaji & Formal' => 'success', // Warna untuk Kategori Mengaji & Formal
                                        'Lainnya' => 'info', // Warna untuk Kategori Lainnya (Roan)
                                        default => 'secondary',
                                    };
                                ?>
                                
                                <div class="card h-100 shadow-lg border-0 border-start border-4 border-<?php echo e($borderColor); ?> card-hover rounded-3">
                                    <div class="card-body p-4">
                                        <h5 class="card-title font-weight-bold text-<?php echo e($borderColor); ?> mb-3 pb-2 border-bottom border-<?php echo e($borderColor); ?>">
                                            <i class="fas fa-layer-group me-2"></i> <?php echo e($jenis); ?>

                                        </h5>
                                        
                                        <div class="list-group list-group-flush">
                                            <?php $__currentLoopData = $kegiatanList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kegiatan_spesifik => $icon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                
                                                <a href="<?php echo e(route('admin.absensi_baru.create', [
                                                            'kelas' => $kelas_id,
                                                            'kegiatan_spesifik' => $kegiatan_spesifik 
                                                        ])); ?>" 
                                                    class="list-group-item list-group-item-action py-3 d-flex justify-content-between align-items-center fw-medium">
                                                    <div>
                                                        <i class="<?php echo e($icon); ?> me-2 text-<?php echo e($borderColor); ?>"></i> 
                                                        <span><?php echo e($kegiatan_spesifik); ?></span>
                                                    </div>
                                                    <i class="fas fa-arrow-right small text-<?php echo e($borderColor); ?>"></i>
                                                </a>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="col-12">
                                <div class="alert alert-warning text-center py-5 rounded-3 border-dashed">
                                    <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                                    <h5 class="fw-bold">Tidak Ada Kegiatan Tersedia</h5>
                                    <p class="mb-0">Mohon pastikan daftar kegiatan sudah dikonfigurasi di sistem.</p>
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
    /* Efek Hover untuk Kartu Kategori */
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15) !important;
        transition: all 0.3s ease-in-out;
    }
    /* Efek Hover untuk Item Kegiatan */
    .list-group-item-action:hover {
        background-color: #e9ecef; /* Slightly darker than default hover */
    }
     /* Dashed border for empty state */
    .border-dashed {
        border: 2px dashed #ffc107 !important;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/admin/absensi/harian/select_activity.blade.php ENDPATH**/ ?>