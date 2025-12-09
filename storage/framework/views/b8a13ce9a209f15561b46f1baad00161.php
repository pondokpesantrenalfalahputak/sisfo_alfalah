<?php $__env->startSection('title', 'Detail Santri'); ?>
<?php $__env->startSection('page_title', 'Detail Santri: ' . $santri->nama_lengkap); ?>


<?php $__env->startSection('header_actions'); ?>
    <div class="d-none d-md-flex align-items-center gap-2">
        <a href="<?php echo e(route('admin.santri.edit', $santri)); ?>" class="btn btn-warning shadow-sm fw-semibold rounded-pill px-3">
            <i class="fas fa-edit me-2"></i>
            Edit Data
        </a>
        <a href="<?php echo e(route('admin.santri.index')); ?>" class="btn btn-outline-secondary shadow-sm fw-semibold rounded-pill px-3">
            <i class="fas fa-arrow-left me-2"></i>
            Daftar Santri
        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            
            
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            
            <div class="d-flex d-md-none justify-content-between mb-3 gap-2">
                <a href="<?php echo e(route('admin.santri.edit', $santri)); ?>" class="btn btn-warning btn-sm shadow-sm flex-fill fw-bold rounded-pill">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="<?php echo e(route('admin.santri.index')); ?>" class="btn btn-outline-secondary btn-sm shadow-sm flex-fill fw-bold rounded-pill">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="card shadow-lg border-0 rounded-4">
                
                
                <div class="card-header bg-primary text-white p-4 rounded-top-4">
                    <h4 class="mb-0 fw-bold fs-5"><i class="fas fa-user-check me-2"></i> Detail Profil Santri</h4>
                    <p class="text-white-50 small mb-0">Informasi lengkap dan terperinci mengenai <?php echo e($santri->nama_lengkap); ?>.</p>
                </div>
                
                <div class="card-body p-4 p-md-5"> 
                    
                    
                    
                    <h5 class="fw-bold text-dark mb-1 text-primary"><i class="fas fa-id-card me-2"></i> Data Identitas Utama</h5>
                    <hr class="mt-2 mb-4 border-primary opacity-25">
                    
                    <div class="row g-4 mb-5">
                        
                        
                        <div class="col-lg-7">
                            <div class="card card-body shadow-sm border-0 border-start border-5 border-primary p-3 bg-white h-100 d-flex justify-content-center">
                                <label class="fw-semibold text-muted small mb-0">NAMA LENGKAP</label>
                                <p class="mb-0 fs-5 fs-lg-3 text-dark fw-bolder lh-sm"><?php echo e($santri->nama_lengkap); ?></p>
                            </div>
                        </div>

                        
                        <div class="col-lg-5">
                            <div class="card card-body shadow-sm border-0 border-start border-5 border-info p-3 bg-white h-100 d-flex flex-column justify-content-center">
                                <label class="fw-semibold text-muted small mb-0">NISN</label>
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="mb-0 fs-6 fs-lg-4 fw-bold text-info lh-sm"><?php echo e($santri->nisn); ?></p>
                                    <span class="badge bg-<?php echo e($santri->status == 'Aktif' ? 'success' : 'secondary'); ?> p-2 fw-bold fs-6">
                                        <?php echo e($santri->status); ?>

                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <h5 class="fw-bold text-dark mb-1 pt-3 text-secondary"><i class="fas fa-info-circle me-2"></i> Detail Pribadi</h5>
                    <hr class="mt-2 mb-4 border-secondary opacity-25">

                    <div class="row g-4">
                        
                        
                        <div class="col-md-4">
                            <label class="form-label fw-medium text-muted mb-1 d-block"><i class="fas fa-map-marker-alt me-1 text-secondary opacity-75"></i> Tempat Lahir</label>
                            
                            <span class="text-dark fw-semibold fs-6"><?php echo e($santri->tempat_lahir ?? '-'); ?></span>
                        </div>
                        
                        
                        <div class="col-md-4">
                            <label class="form-label fw-medium text-muted mb-1 d-block"><i class="far fa-calendar-alt me-1 text-secondary opacity-75"></i> Tanggal Lahir</label>
                            <span class="text-dark fw-semibold fs-6"><?php echo e($santri->tanggal_lahir ? $santri->tanggal_lahir->translatedFormat('d F Y') : '-'); ?></span>
                        </div>

                        
                        <div class="col-md-4">
                            <label class="form-label fw-medium text-muted mb-1 d-block"><i class="fas fa-venus-mars me-1 text-secondary opacity-75"></i> Jenis Kelamin</label>
                            <span class="text-dark fw-semibold fs-6"><?php echo e($santri->jenis_kelamin ?? '-'); ?></span>
                        </div>
                    </div>
                    
                    <hr class="my-5 border-light opacity-50"> 
                    
                    
                    <h5 class="fw-bold text-dark mb-1 text-warning"><i class="fas fa-link me-2"></i> Data Akademik & Wali</h5>
                    <hr class="mt-2 mb-4 border-warning opacity-25">

                    <div class="row g-4 mb-4">
                        
                        <div class="col-md-6">
                            <label class="form-label fw-medium text-muted mb-1 d-block"><i class="fas fa-school me-1 text-warning opacity-75"></i> Kelas Aktif</label>
                            <span class="badge bg-info text-dark p-2 fw-bold fs-6 shadow-sm"><?php echo e($santri->kelas->nama_kelas ?? 'N/A'); ?></span>
                        </div>

                        
                        <div class="col-md-6">
                            <label class="form-label fw-medium text-muted mb-1 d-block"><i class="fas fa-user-tie me-1 text-warning opacity-75"></i> Wali Santri</label>
                            <span class="text-dark fw-semibold fs-6"><?php echo e($santri->waliSantri->name ?? '-'); ?></span>
                        </div>
                    </div>

                    <div class="row g-4">
                        
                        <div class="col-12">
                            <label class="form-label fw-medium text-muted mb-2 d-block"><i class="fas fa-map-marked-alt me-1 text-warning opacity-75"></i> Alamat Lengkap</label>
                            <div class="p-3 rounded-3 bg-light shadow-sm text-dark fw-medium border border-light fs-6"><?php echo e($santri->alamat ?? 'Belum ada alamat'); ?></div>
                        </div>
                    </div>


                    <hr class="mt-5 mb-4 border-dark opacity-10"> 

                    
                    <h6 class="fw-bold text-secondary mb-3"><i class="fas fa-history me-1"></i> Log Data Sistem</h6>

                    <div class="row g-3">
                        
                        <div class="col-md-6">
                            <div class="p-3 rounded-3 bg-light shadow-sm border border-light">
                                <small class="text-muted d-block fw-semibold mb-1">Dibuat Pada</small>
                                <i class="far fa-calendar-alt me-2 text-primary opacity-75"></i>
                                <span class="text-dark fw-semibold"><?php echo e($santri->created_at->translatedFormat('d F Y')); ?></span>
                                <span class="text-muted small">pukul <?php echo e($santri->created_at->format('H:i')); ?></span>
                            </div>
                        </div>
                        
                        
                        <div class="col-md-6">
                             <div class="p-3 rounded-3 bg-light shadow-sm border border-light">
                                <small class="text-muted d-block fw-semibold mb-1">Terakhir Diperbarui</small>
                                <i class="far fa-clock me-2 text-warning opacity-75"></i>
                                <span class="text-dark fw-semibold"><?php echo e($santri->updated_at->translatedFormat('d F Y')); ?></span>
                                <span class="text-muted small">pukul <?php echo e($santri->updated_at->format('H:i')); ?></span>
                            </div>
                        </div>
                    </div>
                    
                </div>

                
                <div class="card-footer bg-light border-0 rounded-bottom-4 p-4">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        
                        
                        <a href="<?php echo e(route('admin.santri.edit', $santri)); ?>" class="btn btn-warning shadow-sm fw-bold w-100 w-md-auto text-dark rounded-pill px-4 order-md-1">
                            <i class="fas fa-edit me-2"></i> Edit Data
                        </a>
                        
                        
                        <form action="<?php echo e(route('admin.santri.destroy', $santri)); ?>" method="POST" class="d-inline w-100 w-md-auto order-md-2">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger shadow-sm fw-bold w-100 rounded-pill px-4" onclick="return confirm('APAKAH ANDA YAKIN ingin menghapus santri <?php echo e($santri->nama_lengkap); ?>? Tindakan ini tidak dapat dibatalkan.')">
                                <i class="fas fa-trash me-2"></i> Hapus Santri
                            </button>
                        </form>

                        
                        <a href="<?php echo e(route('admin.santri.index')); ?>" class="btn btn-secondary shadow-sm fw-bold w-100 w-md-auto rounded-pill px-4 order-md-3">
                            <i class="fas fa-list me-2"></i> Daftar Santri
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/admin/master/santri/show.blade.php ENDPATH**/ ?>