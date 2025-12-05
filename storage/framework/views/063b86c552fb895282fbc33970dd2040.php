<?php $__env->startSection('title', 'Data Santri'); ?>
<?php $__env->startSection('page_title', 'Daftar Santri'); ?>

<?php $__env->startSection('header_actions'); ?>
    
    <a href="<?php echo e(route('admin.santri.create')); ?>" class="btn btn-primary shadow-sm rounded-pill d-flex align-items-center fw-semibold px-3">
        <i class="fas fa-plus me-2"></i>
        Tambah Santri Baru
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <h2 class="mb-4 text-dark fw-bold">🧑‍🎓 Data Santri</h2>

            
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2"></i> <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card shadow-lg border-0 rounded-4">
                
                
                <div class="card-header bg-primary text-white p-4 rounded-top-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                        <h5 class="mb-2 mb-md-0 fw-bold fs-5"><i class="fas fa-users me-2"></i> Data Seluruh Santri</h5>
                        
                        
                        <div class="w-100 w-md-auto mt-2 mt-md-0">
                            <form action="<?php echo e(route('admin.santri.index')); ?>" method="GET" class="d-flex input-group input-group-sm">
                                <input type="text" name="search" class="form-control" placeholder="Cari Santri/NISN..." value="<?php echo e(request('search')); ?>">
                                <button type="submit" class="btn btn-outline-light" title="Cari Data"><i class="fas fa-search"></i></button>
                                <?php if(request('search')): ?>
                                    <a href="<?php echo e(route('admin.santri.index')); ?>" class="btn btn-outline-danger" title="Hapus Pencarian"><i class="fas fa-times"></i></a>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    
                    
                    
                    
                    <div class="table-responsive d-none d-md-block">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-dark text-nowrap">
                                <tr>
                                    <th style="width: 5%;" class="text-center">#</th>
                                    <th style="width: 10%;">NISN</th>
                                    <th style="width: 20%;">Nama Lengkap</th>
                                    <th style="width: 15%;">Kelas</th>
                                    <th style="width: 15%;">Wali Santri</th>
                                    <th style="width: 10%;">J. Kelamin</th>
                                    <th style="width: 10%;">Status</th>
                                    <th style="width: 15%;" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $santris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $santri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="text-center"><?php echo e($loop->iteration); ?></td>
                                    <td class="fw-bold text-primary"><?php echo e($santri->nisn); ?></td>
                                    <td class="fw-semibold"><?php echo e($santri->nama_lengkap); ?></td>
                                    <td>
                                        <span class="badge bg-info text-dark fw-bold"><?php echo e($santri->kelas->nama_kelas ?? 'Belum Ada Kelas'); ?></span>
                                    </td>
                                    <td><?php echo e($santri->waliSantri->name ?? '-'); ?></td>
                                    <td><?php echo e($santri->jenis_kelamin); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo e($santri->status == 'Aktif' ? 'success' : 'secondary'); ?> text-white fw-bold">
                                            <?php echo e($santri->status); ?>

                                        </span>
                                    </td>
                                    <td class="text-center text-nowrap">
                                        
                                        <div class="btn-group" role="group">
                                            <a href="<?php echo e(route('admin.santri.show', $santri)); ?>" class="btn btn-sm btn-outline-info" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('admin.santri.edit', $santri)); ?>" class="btn btn-sm btn-outline-warning" title="Edit Data">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            
                                            <form action="<?php echo e(route('admin.santri.destroy', $santri)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus Data" onclick="return confirm('Apakah Anda yakin ingin menghapus santri: <?php echo e($santri->nama_lengkap); ?>? Tindakan ini tidak dapat dibatalkan.')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="8" class="text-center py-5 text-muted bg-light">
                                            <i class="fas fa-exclamation-circle me-2 fa-3x mb-3 text-secondary"></i>
                                            <h5 class="mb-0 fw-bold">Tidak ada data santri yang ditemukan.</h5>
                                            <p class="mb-0 mt-2">Silakan klik tombol Tambah Santri Baru untuk memulai.</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    
                    
                    
                    <div class="d-md-none p-3">
                        <?php $__empty_1 = true; $__currentLoopData = $santris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $santri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="card mb-3 shadow-sm rounded-3 border-start border-4 border-primary">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2 pb-2 border-bottom">
                                        <div>
                                            <h6 class="text-muted mb-0 small">NISN: <span class="fw-bold text-primary"><?php echo e($santri->nisn); ?></span></h6>
                                            <h5 class="card-title fw-bold text-dark mb-1"><?php echo e($loop->iteration); ?>. <?php echo e($santri->nama_lengkap); ?></h5>
                                        </div>
                                        <span class="badge bg-<?php echo e($santri->status == 'Aktif' ? 'success' : 'secondary'); ?> text-white p-2 fw-bold">
                                            <?php echo e($santri->status); ?>

                                        </span>
                                    </div>
                                    
                                    <div class="row small g-2 mb-3">
                                        <div class="col-6">
                                            <span class="text-muted d-block fw-semibold">Kelas</span>
                                            <span class="badge bg-info text-dark fw-bold"><?php echo e($santri->kelas->nama_kelas ?? '-'); ?></span>
                                        </div>
                                        <div class="col-6">
                                            <span class="text-muted d-block fw-semibold">Jenis Kelamin</span>
                                            <span class="fw-semibold text-dark"><?php echo e($santri->jenis_kelamin); ?></span>
                                        </div>
                                        <div class="col-12 mt-2">
                                            <span class="text-muted d-block fw-semibold">Wali Santri</span>
                                            <span class="fw-bold text-secondary"><?php echo e($santri->waliSantri->name ?? '-'); ?></span>
                                        </div>
                                    </div>

                                    
                                    <div class="d-grid gap-2 d-sm-flex justify-content-sm-end pt-2">
                                        
                                        <a href="<?php echo e(route('admin.santri.show', $santri)); ?>" class="btn btn-sm btn-info text-white fw-semibold flex-fill" title="Lihat Detail">
                                            <i class="fas fa-eye me-1"></i> Detail
                                        </a>
                                        <a href="<?php echo e(route('admin.santri.edit', $santri)); ?>" class="btn btn-sm btn-warning text-dark fw-semibold flex-fill" title="Edit Data">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </a>
                                        
                                        <form action="<?php echo e(route('admin.santri.destroy', $santri)); ?>" method="POST" class="d-inline flex-fill">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-danger w-100 fw-semibold" title="Hapus Data" onclick="return confirm('Apakah Anda yakin ingin menghapus santri: <?php echo e($santri->nama_lengkap); ?>? Tindakan ini tidak dapat dibatalkan.')">
                                                <i class="fas fa-trash me-1"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="text-center py-5 text-muted bg-light rounded-3 shadow-sm">
                                <i class="fas fa-exclamation-circle me-2 fa-3x mb-3 text-secondary"></i>
                                <h5 class="mb-0 fw-bold">Tidak ada data santri yang ditemukan.</h5>
                                <p class="mb-0 mt-2">Silakan klik tombol Tambah Santri Baru untuk memulai.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    
                    
                    <?php if($santris instanceof \Illuminate\Pagination\LengthAwarePaginator): ?>
                        <div class="card-footer bg-light border-0 pt-3 rounded-bottom-4">
                            <div class="d-flex justify-content-center justify-content-md-end">
                                <?php echo e($santris->links()); ?>

                            </div>
                        </div>
                    <?php endif; ?>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/admin/master/santri/index.blade.php ENDPATH**/ ?>