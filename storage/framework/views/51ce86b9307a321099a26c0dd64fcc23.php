<?php $__env->startSection('title', 'Data Kelas'); ?>
<?php $__env->startSection('page_title', 'Daftar Kelas'); ?>

<?php $__env->startSection('header_actions'); ?>
    
    <a href="<?php echo e(route('admin.kelas.create')); ?>" class="btn btn-primary shadow-sm rounded-pill d-flex align-items-center fw-semibold px-3">
        <i class="fas fa-plus me-2"></i>
        Tambah Kelas Baru
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <h2 class="mb-4 text-dark fw-bold">🏫 Data Kelas</h2>

            
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2"></i> <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card shadow-lg border-0 rounded-4">
                
                
                <div class="card-header bg-primary text-white p-4 rounded-top-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                        <h5 class="mb-2 mb-md-0 fw-bold fs-5"><i class="fas fa-school me-2"></i> Data Kelas Tersedia</h5>
                        
                        
                        <div class="w-100 w-md-auto mt-2 mt-md-0">
                            <form action="<?php echo e(route('admin.kelas.index')); ?>" method="GET" class="d-flex input-group input-group-sm">
                                <input type="text" name="search" class="form-control" placeholder="Cari Nama Kelas..." value="<?php echo e(request('search')); ?>">
                                <button type="submit" class="btn btn-outline-light" title="Cari Data"><i class="fas fa-search"></i></button>
                                <?php if(request('search')): ?>
                                    <a href="<?php echo e(route('admin.kelas.index')); ?>" class="btn btn-outline-danger" title="Hapus Pencarian"><i class="fas fa-times"></i></a>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                    <p class="text-white-50 small mb-0 mt-2 d-none d-md-block">Total <?php echo e($kelas->count() ?? 0); ?> data kelas terdaftar dalam sistem.</p>
                </div>
                
                <div class="card-body p-0">

                    
                    
                    
                    <div class="table-responsive d-none d-md-block">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-dark text-nowrap">
                                <tr>
                                    <th style="width: 5%;" class="text-center">#</th>
                                    <th style="width: 40%;">Nama Kelas</th>
                                    <th style="width: 30%;">Tingkat</th>
                                    <th style="width: 25%;" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $kelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="text-center"><?php echo e($loop->iteration); ?></td>
                                    <td class="fw-semibold text-dark"><?php echo e($k->nama_kelas); ?></td>
                                    
                                    <td><span class="badge bg-info text-dark p-2 fw-bold text-nowrap">Tingkat <?php echo e($k->tingkat); ?></span></td>
                                    <td class="text-center text-nowrap">
                                        
                                        <div class="btn-group" role="group">
                                            <a href="<?php echo e(route('admin.kelas.show', ['kela' => $k])); ?>" class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('admin.kelas.edit', ['kela' => $k])); ?>" class="btn btn-sm btn-outline-warning" title="Edit Data">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            
                                            <form action="<?php echo e(route('admin.kelas.destroy', ['kela' => $k])); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus Data" onclick="return confirm('APAKAH YAKIN? Anda akan menghapus kelas <?php echo e($k->nama_kelas); ?>? Tindakan ini tidak dapat dibatalkan.')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted bg-light">
                                            <i class="fas fa-exclamation-circle me-2 fa-3x mb-3 text-secondary"></i>
                                            <h5 class="mb-0 fw-bold">Belum ada data kelas yang ditambahkan.</h5>
                                            <p class="mb-0 mt-2">Silakan klik tombol Tambah Kelas Baru di atas.</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    
                    
                    
                    <div class="d-md-none p-3">
                        <?php $__empty_1 = true; $__currentLoopData = $kelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="card mb-3 shadow-sm rounded-3 border-start border-4 border-primary">
                                <div class="card-body">
                                    
                                    
                                    <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                        <h5 class="card-title fw-bold text-dark mb-0"><?php echo e($k->nama_kelas); ?></h5>
                                        
                                        <span class="badge bg-info text-dark p-2 fw-bold text-nowrap">Tingkat <?php echo e($k->tingkat); ?></span>
                                    </div>
                                    
                                    <p class="text-muted small mb-3">ID Kelas: #<?php echo e($loop->iteration); ?></p>

                                    
                                    <div class="d-grid gap-2 d-sm-flex justify-content-sm-end pt-2">
                                        
                                        <a href="<?php echo e(route('admin.kelas.show', ['kela' => $k])); ?>" class="btn btn-sm btn-outline-primary fw-semibold flex-fill" title="Lihat Detail">
                                            <i class="fas fa-eye me-1"></i> Detail
                                        </a>
                                        <a href="<?php echo e(route('admin.kelas.edit', ['kela' => $k])); ?>" class="btn btn-sm btn-warning text-dark fw-semibold flex-fill" title="Edit Data">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </a>
                                        
                                        
                                        <form action="<?php echo e(route('admin.kelas.destroy', ['kela' => $k])); ?>" method="POST" class="d-inline flex-fill">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-danger w-100 fw-semibold" title="Hapus Data" onclick="return confirm('APAKAH YAKIN? Anda akan menghapus kelas <?php echo e($k->nama_kelas); ?>?')">
                                                <i class="fas fa-trash me-1"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="text-center py-5 text-muted bg-light rounded-3 shadow-sm">
                                <i class="fas fa-exclamation-circle me-2 fa-3x mb-3 text-secondary"></i>
                                <h5 class="mb-0 fw-bold">Belum ada data kelas yang ditambahkan.</h5>
                                <p class="mb-0 mt-2">Silakan klik tombol Tambah Kelas Baru untuk memulai.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    
                    
                    <?php if($kelas instanceof \Illuminate\Pagination\LengthAwarePaginator): ?>
                        <div class="card-footer bg-light border-0 pt-3 rounded-bottom-4">
                            <div class="d-flex justify-content-center justify-content-md-end">
                                <?php echo e($kelas->links()); ?>

                            </div>
                        </div>
                    <?php endif; ?>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/admin/master/kelas/index.blade.php ENDPATH**/ ?>