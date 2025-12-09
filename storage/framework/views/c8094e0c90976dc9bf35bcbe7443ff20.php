<?php $__env->startSection('title', 'Detail Pengumuman'); ?>
<?php $__env->startSection('page_title', 'Pengumuman: ' . $pengumuman->judul); ?>

<?php $__env->startSection('header_actions'); ?>
    
    <div class="d-none d-md-flex align-items-center gap-2">
        <a href="<?php echo e(route('admin.pengumuman.edit', $pengumuman)); ?>" class="btn btn-warning shadow-sm fw-semibold rounded-pill px-3">
            <i class="fas fa-edit me-2"></i>
            Edit Pengumuman
        </a>
        <a href="<?php echo e(route('admin.pengumuman.index')); ?>" class="btn btn-outline-secondary shadow-sm fw-semibold rounded-pill px-3">
            <i class="fas fa-arrow-left me-2"></i>
            Daftar Pengumuman
        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <h2 class="mb-4 text-dark fw-bold">📰 Detail Pengumuman</h2>

            
            <div class="d-flex d-md-none justify-content-between mb-3 gap-2">
                <a href="<?php echo e(route('admin.pengumuman.edit', $pengumuman)); ?>" class="btn btn-warning btn-sm shadow-sm flex-fill fw-bold rounded-pill">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="<?php echo e(route('admin.pengumuman.index')); ?>" class="btn btn-outline-secondary btn-sm shadow-sm flex-fill fw-bold rounded-pill">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="card shadow-lg border-0 rounded-4">
                
                
                <div class="card-header bg-primary text-white p-4 rounded-top-4">
                    <h4 class="mb-0 fw-bold fs-5"><i class="fas fa-bullhorn me-2"></i> Pengumuman Pesantren</h4>
                    <p class="text-white-50 small mb-0">Informasi lengkap mengenai pengumuman: <?php echo e($pengumuman->judul); ?>.</p>
                </div>
                
                <div class="card-body p-4">
                    
                    
                    <h2 class="fw-bolder text-dark mb-4 border-bottom pb-2"><?php echo e($pengumuman->judul); ?></h2>

                    
                    <h6 class="fw-bold text-dark mb-3"><i class="fas fa-info-circle me-1"></i> Informasi Publikasi</h6>
                    <div class="row g-3 mb-5">
                        
                        
                        <div class="col-md-4">
                            <?php
                                $status = $pengumuman->status;
                                $statusClass = $status === 'published' ? 'bg-success text-white' : 'bg-secondary text-white';
                                $statusIcon = $status === 'published' ? 'fa-check-circle' : 'fa-pencil-alt';
                            ?>
                            <div class="p-3 rounded-3 shadow-sm <?php echo e($statusClass); ?>">
                                <small class="d-block fw-semibold mb-1 opacity-75">STATUS</small>
                                <h5 class="mb-0 fw-bold"><i class="fas <?php echo e($statusIcon); ?> me-2"></i> <?php echo e(ucfirst($status)); ?></h5>
                            </div>
                        </div>

                        
                        <div class="col-md-4">
                            <div class="p-3 rounded-3 shadow-sm bg-info-subtle border border-info border-opacity-25">
                                <small class="d-block fw-semibold text-info-emphasis mb-1">KATEGORI</small>
                                <h5 class="mb-0 fw-bold text-info"><i class="fas fa-tag me-2"></i> <?php echo e($pengumuman->kategori ?? 'Umum'); ?></h5>
                            </div>
                        </div>
                        
                        
                        <div class="col-md-4">
                             <div class="p-3 rounded-3 shadow-sm bg-primary-subtle border border-primary border-opacity-25">
                                <small class="d-block fw-semibold text-primary-emphasis mb-1">TANGGAL PUBLIKASI</small>
                                <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-calendar-alt me-2"></i> <?php echo e(\Carbon\Carbon::parse($pengumuman->tanggal_publikasi)->translatedFormat('d F Y')); ?></h5>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="p-4 border border-primary rounded-3 bg-white shadow-sm">
                        <h5 class="fw-bold text-primary mb-3"><i class="fas fa-file-alt me-2"></i> Isi Pengumuman:</h5>
                        <div class="pengumuman-content text-dark fs-6 lh-lg border-top pt-3 mt-3">
                            <?php echo $pengumuman->isi; ?> 
                        </div>
                    </div>
                    
                    
                    <h6 class="fw-bold text-secondary mt-5 mb-3"><i class="fas fa-history me-1"></i> Log Data</h6>
                    <div class="row g-3">
                        
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded border shadow-sm">
                                <small class="text-muted d-block fw-semibold mb-1">Dibuat Pada</small>
                                <i class="far fa-calendar-alt me-2 text-primary"></i>
                                <span class="text-dark fw-semibold"><?php echo e($pengumuman->created_at->translatedFormat('d F Y')); ?></span>
                                <span class="text-muted small">(<?php echo e($pengumuman->created_at->format('H:i')); ?>)</span>
                            </div>
                        </div>
                        
                        
                        <div class="col-md-6">
                             <div class="p-3 bg-light rounded border shadow-sm">
                                <small class="text-muted d-block fw-semibold mb-1">Terakhir Diperbarui</small>
                                <i class="far fa-clock me-2 text-warning"></i>
                                <span class="text-dark fw-semibold"><?php echo e($pengumuman->updated_at->translatedFormat('d F Y')); ?></span>
                                <span class="text-muted small">(<?php echo e($pengumuman->updated_at->format('H:i')); ?>)</span>
                            </div>
                        </div>
                    </div>
                    
                </div>

                
                <div class="card-footer bg-light border-0 rounded-bottom-4 p-4">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        
                        
                        <a href="<?php echo e(route('admin.pengumuman.edit', $pengumuman)); ?>" class="btn btn-warning shadow-sm fw-bold w-100 w-md-auto text-dark rounded-pill px-4 order-md-1">
                            <i class="fas fa-edit me-2"></i> Edit Pengumuman
                        </a>
                        
                        
                        <form action="<?php echo e(route('admin.pengumuman.destroy', $pengumuman)); ?>" method="POST" class="d-inline w-100 w-md-auto order-md-2">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger shadow-sm fw-bold w-100 rounded-pill px-4" onclick="return confirm('APAKAH ANDA YAKIN ingin menghapus pengumuman ini? Tindakan ini tidak dapat dibatalkan.')">
                                <i class="fas fa-trash me-2"></i> Hapus
                            </button>
                        </form>

                        
                        <a href="<?php echo e(route('admin.pengumuman.index')); ?>" class="btn btn-secondary shadow-sm fw-bold w-100 w-md-auto rounded-pill px-4 order-md-3">
                            <i class="fas fa-list me-2"></i> Daftar Pengumuman
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/admin/pengumuman/show.blade.php ENDPATH**/ ?>