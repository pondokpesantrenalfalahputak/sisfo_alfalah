<?php $__env->startSection('title', 'Detail Kelas'); ?>
<?php $__env->startSection('page_title', 'Detail Kelas: ' . $kela->nama_kelas); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <div class="card shadow-lg border-0 rounded-4">
                
                
                <div class="card-header bg-primary text-white p-4 rounded-top-4">
                    <h5 class="mb-0 fw-bold fs-6"><i class="fas fa-school me-2"></i> Informasi Data Kelas</h5>
                    <p class="text-white-50 small mb-0">Rincian lengkap mengenai kelas: <?php echo e($kela->nama_kelas); ?>.</p>
                </div>
                
                <div class="card-body p-4">
                    
                    <div class="row g-4">
                        
                        
                        <div class="col-lg-6">
                            
                            <h7 class="fw-bold text-dark mb-3 border-bottom pb-2 text-primary"><i class="fas fa-tag me-2"></i> Nama Kelas</h7>
                            
                            <div class="p-3 bg-light rounded-3 shadow-sm border-start border-5 border-primary">
                                <label class="form-label fw-semibold text-muted small mb-1">Nama Kelas Lengkap</label>
                                
                                <p class="mb-0 fs-4 text-dark fw-bolder"><?php echo e($kela->nama_kelas); ?></p>
                            </div>
                        </div>

                        
                        <div class="col-lg-6">
                            
                            <h7 class="fw-bold text-dark mb-3 border-bottom pb-2 text-info"><i class="fas fa-layer-group me-2"></i> Tingkat Pendidikan</h7>

                            <div class="p-3 bg-light rounded-3 shadow-sm border-start border-5 border-info">
                                <label class="form-label fw-semibold text-muted small mb-1">Tingkat Kelas</label>
                                <p class="mb-0">
                                    
                                    <span class="badge bg-info p-2 fw-bold text-dark small">Tingkat <?php echo e($kela->tingkat); ?></span>
                                </p>
                            </div>
                        </div>
                        
                    </div>

                    
                    <div class="row mt-5 pt-4">
                        <h6 class="fw-bold text-secondary mb-3"><i class="fas fa-history me-1"></i> Log Data</h6>
                        
                        
                        <div class="col-md-6 mb-3">
                            <div class="p-3 border rounded bg-light shadow-sm">
                                <small class="text-muted d-block fw-semibold mb-1">Dibuat Pada</small>
                                <i class="far fa-calendar-alt me-1 text-primary small"></i>
                                <span class="text-dark fw-semibold small"><?php echo e($kela->created_at->translatedFormat('d F Y')); ?></span>
                                <span class="text-muted small">pukul <?php echo e($kela->created_at->format('H:i')); ?></span>
                            </div>
                        </div>
                        
                        
                        <div class="col-md-6 mb-3">
                            <div class="p-3 border rounded bg-light shadow-sm">
                                <small class="text-muted d-block fw-semibold mb-1">Terakhir Diperbarui</small>
                                <i class="far fa-clock me-1 text-warning small"></i>
                                <span class="text-dark fw-semibold small"><?php echo e($kela->updated_at->translatedFormat('d F Y')); ?></span>
                                <span class="text-muted small">pukul <?php echo e($kela->updated_at->format('H:i')); ?></span>
                            </div>
                        </div>
                    </div>
                    
                </div>

                
                <div class="card-footer bg-light border-0 rounded-bottom-4 p-4">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        
                        
                        <a href="<?php echo e(route('admin.kelas.edit', ['kela' => $kela])); ?>" class="btn btn-warning shadow-sm fw-bold w-100 w-md-auto text-dark rounded-pill px-4 small">
                            <i class="fas fa-edit me-2"></i> Edit Data
                        </a>
                        
                        
                        <form action="<?php echo e(route('admin.kelas.destroy', ['kela' => $kela])); ?>" method="POST" class="d-inline w-100 w-md-auto">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger shadow-sm fw-bold w-100 rounded-pill px-4 small" onclick="return confirm('APAKAH ANDA YAKIN ingin menghapus kelas <?php echo e($kela->nama_kelas); ?>? Tindakan ini tidak dapat dibatalkan.')">
                                <i class="fas fa-trash me-2"></i> Hapus Kelas
                            </button>
                        </form>

                        
                        <a href="<?php echo e(route('admin.kelas.index')); ?>" class="btn btn-secondary shadow-sm fw-bold w-100 w-md-auto rounded-pill px-4 small">
                            <i class="fas fa-list me-2"></i> Daftar Kelas
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/admin/master/kelas/show.blade.php ENDPATH**/ ?>