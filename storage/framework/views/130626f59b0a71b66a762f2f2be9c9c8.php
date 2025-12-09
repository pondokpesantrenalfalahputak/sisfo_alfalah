<?php $__env->startSection('page_title', 'Input Absensi ' . $kelas_nama . ' - ' . $kegiatan_spesifik); ?>

<?php use Carbon\Carbon; ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            
            
            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show small" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i> <?php echo session('error'); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            
            
            <div class="card shadow mb-4 border-start border-primary border-5 rounded-4"> 
                
                
                
                <div class="card-header bg-primary text-white d-flex flex-column flex-md-row justify-content-between align-items-md-center p-3 rounded-top-4">
                    <div>
                        <h6 class="m-0 font-weight-bold fs-6">
                            Absensi <?php echo e($kegiatan_spesifik); ?> | Kelas <?php echo e($kelas_nama); ?>

                        </h6>
                    </div>
                    <span class="badge bg-light text-dark shadow-sm rounded-pill px-3 py-1 mt-2 mt-md-0 small">
                        <i class="fas fa-calendar-alt me-1"></i> Tanggal: **<?php echo e($date); ?>**
                    </span>
                </div>
                
                <div class="card-body p-4 pt-3">
                    <p class="text-muted small border-bottom pb-2 mb-3"><i class="fas fa-info-circle me-1"></i> Pilih status kehadiran (H/S/I/A) untuk setiap santri.</p>

                    
                    <form action="<?php echo e(route('admin.absensi_baru.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        
                        
                        <input type="hidden" name="kelas_id" value="<?php echo e($kelas_id); ?>">
                        <input type="hidden" name="kegiatan_spesifik" value="<?php echo e($kegiatan_spesifik); ?>">
                        <input type="hidden" name="tanggal_absensi" value="<?php echo e(Carbon::now()->toDateString()); ?>">

                        
                        <div class="table-responsive d-none d-md-block"> 
                            <table class="table table-bordered table-hover table-sm" id="absensiTable" width="100%" cellspacing="0">
                                
                                <thead class="text-center table-primary text-white"> 
                                    <tr>
                                        <th rowspan="2" class="align-middle bg-primary" style="width: 5%;">#</th>
                                        <th rowspan="2" class="align-middle text-start bg-primary" style="min-width: 150px;">Nama Santri (NIS)</th>
                                        <th colspan="4" class="align-middle fw-bold bg-primary">Status Kehadiran</th>
                                        <th rowspan="2" class="align-middle bg-primary" style="min-width: 150px;">Keterangan (Opsional)</th>
                                    </tr>
                                    <tr class="fw-normal bg-light text-dark">
                                        <th style="width: 7%;"><i class="fas fa-check-circle text-success"></i> Hadir</th>
                                        <th style="width: 7%;"><i class="fas fa-bed text-warning"></i> Sakit</th>
                                        <th style="width: 7%;"><i class="fas fa-user-clock text-info"></i> Izin</th>
                                        <th style="width: 7%;"><i class="fas fa-times-circle text-danger"></i> Alfa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $santri; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php $defaultKehadiran = 'Hadir'; ?>
                                    <tr class="align-middle">
                                        <td class="text-center small"><?php echo e($index + 1); ?></td>
                                        <td class="fw-semibold small"><?php echo e($s->nama_lengkap); ?><br><small class="text-muted fw-normal">(<?php echo e($s->nisn ?? '-'); ?>)</small></td>
                                        
                                        <?php $__currentLoopData = ['Hadir', 'Sakit', 'Izin', 'Alfa']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <td class="text-center">
                                                <input class="form-check-input" type="radio" 
                                                       name="kehadiran[<?php echo e($s->id); ?>]" value="<?php echo e($status); ?>" 
                                                       <?php echo e(($status == $defaultKehadiran) ? 'checked' : ''); ?> required>
                                            </td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        
                                        <td>
                                            <input type="text" class="form-control form-control-sm small" 
                                                   name="keterangan[<?php echo e($s->id); ?>]" 
                                                   placeholder="Wajib diisi jika S/I/A..." maxlength="100">
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr><td colspan="7" class="text-center py-4 bg-light small"><i class="fas fa-exclamation-triangle me-2 text-warning"></i> Tidak ada data santri untuk kelas ini.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        
                        <div class="d-md-none">
                            <div class="list-group">
                                <?php $__empty_1 = true; $__currentLoopData = $santri; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php $defaultKehadiran = 'Hadir'; ?>
                                    
                                    <div class="list-group-item mb-2 shadow-sm rounded-3 p-3 border-start border-primary border-4"> 
                                        <div class="d-flex w-100 justify-content-between align-items-center">
                                            <p class="mb-0 fw-bold text-dark small"><?php echo e($index + 1); ?>. <?php echo e($s->nama_lengkap); ?></p>
                                            <span class="badge bg-secondary-subtle text-secondary fw-normal small">NIS: <?php echo e($s->nisn ?? '-'); ?></span>
                                        </div>
                                        <hr class="my-2">
                                        
                                        
                                        <div class="my-2">
                                            
                                            <p class="mb-1 small fw-semibold text-primary"><i class="fas fa-bullseye me-1"></i> Status Kehadiran:</p>
                                            <div class="btn-group btn-group-sm w-100" role="group" aria-label="Status Kehadiran">
                                                <?php $__currentLoopData = ['Hadir', 'Sakit', 'Izin', 'Alfa']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        $statusClass = match ($status) {
                                                            'Hadir' => 'btn-outline-success',
                                                            'Sakit' => 'btn-outline-warning',
                                                            'Izin' => 'btn-outline-info',
                                                            'Alfa' => 'btn-outline-danger', // Tetap Danger untuk Alfa/Absen
                                                        };
                                                        $statusLabel = match ($status) {
                                                            'Hadir' => 'H',
                                                            'Sakit' => 'S',
                                                            'Izin' => 'I',
                                                            'Alfa' => 'A',
                                                        };
                                                    ?>
                                                    <input type="radio" class="btn-check" 
                                                           name="kehadiran[<?php echo e($s->id); ?>]" 
                                                           id="mobile-<?php echo e($s->id); ?>-<?php echo e($status); ?>" 
                                                           value="<?php echo e($status); ?>" 
                                                           <?php echo e(($status == $defaultKehadiran) ? 'checked' : ''); ?> 
                                                           required>
                                                    <label class="btn <?php echo e($statusClass); ?> flex-fill small" 
                                                           for="mobile-<?php echo e($s->id); ?>-<?php echo e($status); ?>"><?php echo e($statusLabel); ?></label>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>

                                        
                                        <div class="my-2">
                                            <p class="mb-1 small text-muted"><i class="fas fa-comment-alt me-1"></i> Keterangan (Opsional):</p>
                                            <input type="text" class="form-control form-control-sm small" 
                                                   name="keterangan[<?php echo e($s->id); ?>]" 
                                                   placeholder="Wajib diisi jika S/I/A..." 
                                                   maxlength="100">
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div class="alert alert-warning text-center py-4 small">Tidak ada data santri untuk kelas ini.</div>
                                <?php endif; ?>
                            </div>
                        </div>


                        
                        <div class="d-grid mt-4 sticky-bottom-custom p-3 bg-white border-top shadow-lg">
                            
                            <button type="submit" class="btn btn-primary shadow-lg rounded-3 fw-bold"> 
                                <i class="fas fa-save me-2"></i> SIMPAN ABSENSI
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('css'); ?>
<style>
    /* Membuat tombol submit tetap terlihat di bagian bawah layar mobile */
    @media (max-width: 767px) {
        .sticky-bottom-custom {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }
        .card-body {
            padding-bottom: 70px !important;
        }
        
        /* === PERHALUSAN WARNA STATUS PADA TOMBOL MOBILE YANG DIPILIH === */
        
        .btn-check:checked + .btn-outline-success,
        .btn-check:checked + .btn-outline-warning,
        .btn-check:checked + .btn-outline-info,
        .btn-check:checked + .btn-outline-danger {
            color: #fff; 
            font-weight: bold; 
        }

        /* Hadir (Success - Hijau) - Dibiarkan */
        .btn-check:checked + .btn-outline-success { 
            background-color: #198754; 
            border-color: #198754; 
        }

        /* Sakit (Warning - Kuning) - Diperhalus */
        .btn-check:checked + .btn-outline-warning { 
            /* Menggunakan warna Amber yang lebih tua dan tidak terlalu neon */
            background-color: #f7a31b; 
            border-color: #f7a31b; 
            color: #000; 
        }

        /* Izin (Info - Biru Muda) - Diperhalus */
        .btn-check:checked + .btn-outline-info { 
            /* Menggunakan warna Cyan yang lebih tua/muted */
            background-color: #0d8ca3; 
            border-color: #0d8ca3; 
            color: #fff; /* Teks putih untuk kontras dengan latar belakang gelap */
        }

        /* Alfa (Danger - Merah) - Dibiarkan */
        .btn-check:checked + .btn-outline-danger { 
            background-color: #dc3545; 
            border-color: #dc3545; 
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/admin/absensi/harian/create.blade.php ENDPATH**/ ?>