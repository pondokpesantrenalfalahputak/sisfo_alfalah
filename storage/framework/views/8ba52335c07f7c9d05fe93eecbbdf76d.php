<?php $__env->startSection('title', 'Detail Guru'); ?>
<?php $__env->startSection('page_title', 'Detail Data Guru'); ?>

<?php $__env->startSection('content'); ?>
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                
                
                <div class="card-header bg-white border-bottom p-4">
                    <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-id-card me-2 text-primary"></i> Detail Informasi Pendidik</h5>
                </div>
                
                
                <div class="card-body p-4 p-md-5">
                    
                    <div class="row g-5"> 
                        
                        
                        <div class="col-lg-6">
                            <h6 class="fw-bold mb-4 text-primary"><i class="fas fa-user-circle me-2"></i> Data Identitas</h6>
                            
                            
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted fw-semibold">NUPTK</span>
                                <span class="fw-bolder text-dark"><?php echo e($guru->nuptk); ?></span>
                            </div>

                            
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted fw-semibold">Nama Lengkap</span>
                                <span class="fw-bolder text-dark"><?php echo e($guru->nama_lengkap); ?></span>
                            </div>
                        </div>

                        
                        <div class="col-lg-6 border-start border-lg ps-lg-5 pt-4 pt-lg-0"> 
                            <h6 class="fw-bold mb-4 text-warning"><i class="fas fa-briefcase me-2"></i> Posisi dan Kontak</h6>

                            
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted fw-semibold">Jabatan</span>
                                <span class="badge bg-warning text-dark p-2 fw-bold"><?php echo e($guru->jabatan); ?></span>
                            </div>

                            
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted fw-semibold">Nomor HP</span>
                                <span class="fw-bolder text-success"><?php echo e($guru->no_hp); ?></span>
                            </div>
                        </div>
                        
                    </div>
                    
                    
                    <div class="row mt-5 pt-4 border-top">
                        <h6 class="fw-bold text-secondary mb-3"><i class="fas fa-history me-1"></i> Riwayat Pencatatan</h6>
                        
                        
                        <div class="col-md-6 mb-3">
                            <div class="p-3 border-start border-primary border-4 rounded bg-light">
                                <small class="text-muted fw-semibold d-block mb-1">Dibuat Pada</small>
                                <span class="text-dark fw-semibold small"><?php echo e($guru->created_at->translatedFormat('d F Y, H:i')); ?></span>
                                <small class="text-secondary d-block mt-1">(<?php echo e($guru->created_at->diffForHumans()); ?>)</small>
                            </div>
                        </div>
                        
                        
                        <div class="col-md-6 mb-3">
                             <div class="p-3 border-start border-warning border-4 rounded bg-light">
                                <small class="text-muted fw-semibold d-block mb-1">Terakhir Diperbarui</small>
                                <span class="text-dark fw-semibold small"><?php echo e($guru->updated_at->translatedFormat('d F Y, H:i')); ?></span>
                                <small class="text-secondary d-block mt-1">(<?php echo e($guru->updated_at->diffForHumans()); ?>)</small>
                            </div>
                        </div>
                    </div>
                    
                </div>

                
                <div class="card-footer bg-light border-0 rounded-bottom-4 p-4">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        
                        
                        <a href="<?php echo e(route('admin.guru.edit', $guru)); ?>" class="btn btn-warning shadow-sm fw-bold w-100 w-md-auto text-dark rounded-pill px-4 order-1">
                            <i class="fas fa-edit me-2"></i> Edit Data
                        </a>
                        
                        
                        <a href="<?php echo e(route('admin.guru.index')); ?>" class="btn btn-outline-secondary shadow-sm fw-bold w-100 w-md-auto rounded-pill px-4 order-2">
                            <i class="fas fa-list me-2"></i> Daftar Guru
                        </a>

                        
                        <form action="<?php echo e(route('admin.guru.destroy', $guru)); ?>" method="POST" class="d-inline w-100 w-md-auto order-3">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-outline-danger shadow-sm fw-bold w-100 rounded-pill px-4" onclick="return confirm('APAKAH ANDA YAKIN ingin menghapus data guru: <?php echo e($guru->nama_lengkap); ?>? Tindakan ini tidak dapat dibatalkan.')">
                                <i class="fas fa-trash me-2"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/admin/master/guru/show.blade.php ENDPATH**/ ?>