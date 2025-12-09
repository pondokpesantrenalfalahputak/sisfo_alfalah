<?php $__env->startSection('title', 'Detail User'); ?>
<?php $__env->startSection('page_title', 'Detail Pengguna: ' . $user->name); ?>


<?php $__env->startSection('header_actions'); ?>
    
    <a href="<?php echo e(route('admin.user.index')); ?>" class="btn btn-outline-secondary shadow-sm rounded-pill d-md-none d-flex align-items-center fw-semibold px-3">
        <i class="fas fa-list me-2"></i>
        Daftar User
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <div class="card shadow-lg border-0 rounded-4 border-start border-5 border-primary">
                
                
                <div class="card-header bg-primary text-white p-4 rounded-top-4">
                    <h4 class="mb-0 fw-bold fs-5"><i class="fas fa-user-circle me-2"></i> Profil Pengguna</h4>
                    <p class="text-white-50 small mb-0">Informasi lengkap mengenai pengguna **<?php echo e($user->name); ?>**.</p>
                </div>
                
                <div class="card-body p-4">
                    
                    
                    <h5 class="fw-bold text-dark mb-3 border-bottom pb-2 text-primary"><i class="fas fa-id-card-alt me-2"></i> Data Akun Utama</h5>
                    
                    
                    <div class="row g-3"> 
                        
                        
                        <div class="col-lg-6">
                            <div class="p-3 bg-light rounded-3 border-start border-5 border-primary shadow-sm">
                                <label class="fw-semibold text-muted small mb-0">Nama Lengkap</label>
                                
                                <p class="mb-0 fw-bolder fs-5 fs-md-4 text-dark"><?php echo e($user->name); ?></p> 
                            </div>
                        </div>

                        
                        <div class="col-lg-6">
                            <?php
                                $badgeClass = match($user->role) {
                                    'admin' => 'danger', 
                                    'wali_santri' => 'primary',
                                    default => 'secondary',
                                };
                                $roleDisplay = ucfirst(str_replace('_', ' ', $user->role));
                            ?>
                            <div class="p-3 bg-light rounded-3 border-start border-5 border-info shadow-sm">
                                <label class="fw-semibold text-muted small mb-0">Email / Peran (Role)</label>
                                <div class="d-flex justify-content-between align-items-center">
                                    
                                    <p class="mb-0 fw-semibold text-secondary text-truncate small"><?php echo e($user->email); ?></p> 
                                    <span class="badge bg-<?php echo e($badgeClass); ?> p-2 fw-bold small rounded-pill ms-3">
                                        <?php echo e($roleDisplay); ?>

                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="row g-3 mt-1"> 
                        <div class="col-12">
                            <label class="form-label fw-semibold text-muted small mb-1 mt-3"><i class="fas fa-envelope-open-text me-1"></i> Status Verifikasi Email</label>
                            <div class="p-3 border rounded bg-white shadow-sm">
                                <?php if($user->email_verified_at): ?>
                                    <span class="text-success fw-bold me-2 small"><i class="fas fa-check-circle me-1"></i> Terverifikasi</span>
                                    
                                    <span class="text-muted small">pada <?php echo e($user->email_verified_at->translatedFormat('d F Y')); ?> pukul <?php echo e($user->email_verified_at->format('H:i')); ?></span>
                                <?php else: ?>
                                    <span class="text-danger fw-bold small"><i class="fas fa-times-circle me-1"></i> Belum Diverifikasi</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="mt-5 mb-4 border-dark opacity-25">

                    
                    <h5 class="fw-bold text-secondary mb-3 border-bottom pb-2"><i class="fas fa-history me-2"></i> Log Data Sistem</h5>

                    <div class="row g-3">
                        
                        <div class="col-md-6">
                            <div class="p-3 border rounded bg-light shadow-sm">
                                <small class="text-muted d-block fw-semibold mb-1">Dibuat Pada</small>
                                <i class="far fa-calendar-alt me-2 text-primary"></i>
                                <span class="text-dark fw-semibold small"><?php echo e($user->created_at->translatedFormat('d F Y')); ?></span>
                                <span class="text-muted small"><?php echo e($user->created_at->format('H:i')); ?></span>
                            </div>
                        </div>
                        
                        
                        <div class="col-md-6">
                             <div class="p-3 border rounded bg-light shadow-sm">
                                <small class="text-muted d-block fw-semibold mb-1">Terakhir Diperbarui</small>
                                <i class="far fa-clock me-2 text-warning"></i>
                                <span class="text-dark fw-semibold small"><?php echo e($user->updated_at->translatedFormat('d F Y')); ?></span>
                                <span class="text-muted small"><?php echo e($user->updated_at->format('H:i')); ?></span>
                            </div>
                        </div>
                    </div>
                    
                </div>

                
                <div class="card-footer bg-light border-0 rounded-bottom-4 p-4">
                    
                    <div class="d-grid gap-3 d-md-flex justify-content-md-end">
                        
                        
                        <a href="<?php echo e(route('admin.user.edit', $user)); ?>" class="btn btn-warning shadow-sm fw-bold text-dark rounded-pill px-4 order-md-1">
                            <i class="fas fa-edit me-2"></i> Edit Data
                        </a>
                        
                        
                        
                        <form action="<?php echo e(route('admin.user.destroy', $user)); ?>" method="POST" class="d-grid order-md-2">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger shadow-sm fw-bold rounded-pill px-4" onclick="return confirm('APAKAH ANDA YAKIN ingin menghapus user <?php echo e($user->name); ?>? Tindakan ini tidak dapat dibatalkan.')">
                                <i class="fas fa-trash me-2"></i> Hapus User
                            </button>
                        </form>

                         
                        <a href="<?php echo e(route('admin.user.index')); ?>" class="btn btn-outline-secondary shadow-sm fw-bold rounded-pill px-4 order-md-3">
                            <i class="fas fa-list me-2"></i> Daftar User
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/admin/master/user/show.blade.php ENDPATH**/ ?>