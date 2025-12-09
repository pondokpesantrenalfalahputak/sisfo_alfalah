<?php $__env->startSection('title', 'Kelola Pengumuman'); ?>
<?php $__env->startSection('page_title', 'Daftar Pengumuman Pesantren'); ?>

<?php $__env->startSection('header_actions'); ?>
    
    
    <a href="<?php echo e(route('admin.pengumuman.create')); ?>" class="btn btn-primary shadow-sm rounded-pill d-none d-md-flex align-items-center fw-semibold px-3">
        <i class="fas fa-plus me-2"></i> Tambah Pengumuman Baru
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2"></i> <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

                <div class="d-block d-md-none mb-3 px-3">
                    <a href="<?php echo e(route('admin.rekening.create')); ?>" class="btn btn-primary shadow-sm d-flex align-items-center fw-semibold w-100">
                    <i class="fas fa-plus me-2"></i> Tambah Rekening Baru
                    </a>
                </div>

            <div class="card shadow-lg border-0 rounded-4">
                
                
                <div class="card-header bg-primary text-white p-4 rounded-top-4">
                    <h5 class="mb-0 fw-bold fs-5"><i class="fas fa-bullhorn me-2"></i> Daftar Seluruh Pengumuman</h5>
                    <p class="text-white-50 small mb-0">Kelola dan publikasikan pengumuman penting untuk Wali Santri.</p>
                </div>
                
                <div class="card-body p-0">
                    
                    
                    
                    
                    <div class="table-responsive d-none d-md-block">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-dark text-nowrap">
                                <tr>
                                    <th style="width: 5%;" class="text-center">#</th>
                                    <th style="width: 30%;">Judul Pengumuman</th>
                                    <th style="width: 15%;">Kategori</th>
                                    <th style="width: 15%;">Tanggal Publikasi</th>
                                    <th style="width: 15%;">Status</th>
                                    <th style="width: 20%;" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $pengumumans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pengumuman): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="text-center"><?php echo e($loop->iteration); ?></td>
                                    <td>
                                        <strong class="text-dark"><?php echo e($pengumuman->judul); ?></strong><br>
                                        <small class="text-secondary"><?php echo e(Str::limit(strip_tags($pengumuman->isi), 70, '...')); ?></small>
                                    </td>
                                    <td>
                                         
                                         <span class="badge bg-info-subtle text-info-emphasis fw-semibold p-2">
                                            <?php echo e($pengumuman->kategori ?? 'Umum'); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <span class="fw-semibold text-secondary"><?php echo e(\Carbon\Carbon::parse($pengumuman->tanggal_publikasi)->translatedFormat('d M Y')); ?></span>
                                    </td>
                                    <td>
                                        
                                        <?php if($pengumuman->status === 'published'): ?>
                                            <span class="badge bg-success p-2 fw-bold">
                                                <i class="fas fa-check-circle me-1"></i> Published
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary p-2 fw-bold">
                                                <i class="fas fa-pencil-alt me-1"></i> Draft
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center text-nowrap">
                                        
                                        <div class="btn-group" role="group">
                                            <a href="<?php echo e(route('admin.pengumuman.show', $pengumuman)); ?>" class="btn btn-sm btn-outline-info" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('admin.pengumuman.edit', $pengumuman)); ?>" class="btn btn-sm btn-outline-warning" title="Edit Pengumuman">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            
                                            <form action="<?php echo e(route('admin.pengumuman.destroy', $pengumuman)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus Pengumuman" onclick="return confirm('Apakah Anda yakin ingin menghapus pengumuman: <?php echo e($pengumuman->judul); ?>? Tindakan ini tidak dapat dibatalkan.')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted bg-light">
                                            <i class="fas fa-exclamation-circle me-2 fa-3x mb-3 text-secondary"></i>
                                            <h5 class="mb-0 fw-bold">Belum ada data pengumuman yang tersedia.</h5>
                                            <p class="mb-0 mt-2">Silakan klik tombol Tambah Pengumuman Baru di atas untuk membuat pengumuman.</p>
                                            
                                            <div class="mt-3">
                                                <a href="<?php echo e(route('admin.pengumuman.create')); ?>" class="btn btn-sm btn-primary shadow-sm fw-semibold">
                                                    <i class="fas fa-plus me-2"></i> Tambah Pengumuman Baru
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    
                    
                    
                    <div class="d-md-none p-4 pt-4">
                        <?php $__empty_1 = true; $__currentLoopData = $pengumumans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pengumuman): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            
                            <div class="card mb-3 shadow-sm rounded-3 border-start border-2 <?php echo e($pengumuman->status === 'published' ? 'border-success' : 'border-secondary'); ?>">
                                <div class="card-body p-3">
                                    
                                    
                                    <div class="d-flex justify-content-between align-items-start mb-2 border-bottom pb-2">
                                        <div>
                                            <h6 class="text-muted mb-0 small"><?php echo e($pengumuman->kategori ?? 'UMUM'); ?> | <?php echo e($loop->iteration); ?></h6>
                                            <h5 class="card-title fw-bold text-dark mb-1"><?php echo e($pengumuman->judul); ?></h5>
                                        </div>
                                        
                                        <?php if($pengumuman->status === 'published'): ?>
                                            <span class="badge bg-success p-2 fw-bold">Published</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary p-2 fw-bold">Draft</span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    
                                    <p class="card-text small text-secondary mb-3"><?php echo e(Str::limit(strip_tags($pengumuman->isi), 100, '...')); ?></p>
                                    
                                    
                                    <p class="card-text small text-muted mb-3">
                                        <i class="far fa-calendar-alt me-1"></i>
                                        Publikasi: <span class="fw-semibold"><?php echo e(\Carbon\Carbon::parse($pengumuman->tanggal_publikasi)->translatedFormat('d F Y')); ?></span>
                                    </p>

                                    
                                    <div class="d-grid gap-2 d-sm-flex justify-content-sm-end pt-2">
                                        <a href="<?php echo e(route('admin.pengumuman.show', $pengumuman)); ?>" class="btn btn-sm btn-info text-white fw-semibold flex-fill" title="Lihat Detail">
                                            <i class="fas fa-eye me-1"></i> Detail
                                        </a>
                                        <a href="<?php echo e(route('admin.pengumuman.edit', $pengumuman)); ?>" class="btn btn-sm btn-warning text-dark fw-semibold flex-fill" title="Edit Pengumuman">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </a>
                                        
                                        <form action="<?php echo e(route('admin.pengumuman.destroy', $pengumuman)); ?>" method="POST" class="d-inline flex-fill">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-danger w-100 fw-semibold" title="Hapus Pengumuman" onclick="return confirm('Apakah Anda yakin ingin menghapus pengumuman: <?php echo e($pengumuman->judul); ?>? Tindakan ini tidak dapat dibatalkan.')">
                                                <i class="fas fa-trash me-1"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="text-center py-5 text-muted bg-light rounded-3 shadow-sm">
                                <i class="fas fa-exclamation-circle me-2 fa-3x mb-3 text-secondary"></i>
                                <h5 class="mb-0 fw-bold">Belum ada data pengumuman yang tersedia.</h5>
                                <p class="mb-0 mt-2">Silakan buat pengumuman baru untuk ditampilkan.</p>
                                
                                
                                <div class="mt-3">
                                    <a href="<?php echo e(route('admin.pengumuman.create')); ?>" class="btn btn-primary shadow-sm fw-semibold">
                                        <i class="fas fa-plus me-2"></i> Tambah Pengumuman Baru
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                </div>
                
                
                <?php if($pengumumans instanceof \Illuminate\Pagination\LengthAwarePaginator): ?>
                    <div class="card-footer bg-light border-0 pt-3 rounded-bottom-4">
                        <div class="d-flex justify-content-center justify-content-md-end">
                            <?php echo e($pengumumans->links()); ?>

                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/admin/pengumuman/index.blade.php ENDPATH**/ ?>