<?php $__env->startSection('title', 'Data Kelas'); ?>
<?php $__env->startSection('page_title', 'Daftar Kelas'); ?>

<?php $__env->startSection('header_actions'); ?>
    <a href="<?php echo e(route('admin.kelas.create')); ?>" class="btn btn-primary btn-sm px-3 shadow-sm rounded-pill d-none d-md-flex align-items-center fw-semibold">
        <i class="fas fa-plus me-2"></i>
        Tambah Kelas Baru
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0" role="alert">
                    <i class="fas fa-check-circle me-2"></i>Berhasil! <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                
                
                <div class="card-header bg-white border-bottom p-4">
                    
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">

                        
                        <div class="w-100 w-md-auto">
                            <form action="<?php echo e(route('admin.kelas.index')); ?>" method="GET" class="d-flex input-group input-group-sm">
                                <input type="text" name="search" class="form-control shadow-none" placeholder="Cari Nama Kelas..." value="<?php echo e(request('search')); ?>">
                                <button type="submit" class="btn btn-outline-secondary" title="Cari Data"><i class="fas fa-search"></i></button>
                                <?php if(request('search')): ?>
                                    <a href="<?php echo e(route('admin.kelas.index')); ?>" class="btn btn-outline-danger" title="Hapus Pencarian"><i class="fas fa-times"></i></a>
                                <?php endif; ?>
                            </form>
                        </div>
                        
                        
                        <div class="w-100 d-md-none">
                            <a href="<?php echo e(route('admin.kelas.create')); ?>" class="btn btn-primary btn-sm w-100 shadow-sm rounded-pill d-flex align-items-center justify-content-center fw-semibold">
                                <i class="fas fa-plus me-2"></i>
                                Tambah Kelas Baru
                            </a>
                        </div>
                    </div>
                    
                    
                    <?php
                        $totalData = ($kelas instanceof \Illuminate\Pagination\LengthAwarePaginator) ? $kelas->total() : $kelas->count();
                    ?>
                    <p class="text-muted small mb-0 mt-3">Total <?php echo e($totalData); ?> data kelas terdaftar.</p>
                </div>
                
                <div class="card-body p-0">

                    
                    
                    
                    <div class="table-responsive d-none d-md-block">
                        <table class="table table-striped table-hover align-middle mb-0">
                            <thead class="table-light text-nowrap">
                                <tr class="fw-bold text-uppercase small">
                                    <th style="width: 5%;" class="text-center">No</th>
                                    <th style="width: 40%;">Nama Kelas</th>
                                    <th style="width: 30%;">Tingkat</th>
                                    <th style="width: 25%;" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $kelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="text-center text-muted small">
                                        <?php if($kelas instanceof \Illuminate\Pagination\LengthAwarePaginator): ?>
                                            <?php echo e($loop->iteration + ($kelas->currentPage() - 1) * $kelas->perPage()); ?>

                                        <?php else: ?>
                                            <?php echo e($loop->iteration); ?>

                                        <?php endif; ?>
                                    </td>
                                    <td class="fw-semibold text-dark">
                                        <?php echo e($k->nama_kelas); ?>

                                        <div class="small text-muted mt-1">ID:<?php echo e($k->id); ?></div>
                                    </td>
                                    <td><span class="badge bg-info text-dark p-2 fw-semibold text-nowrap"><i class="fas fa-layer-group me-1"></i> Level <?php echo e($k->tingkat); ?></span></td>
                                    <td class="text-center text-nowrap">
                                        
                                        <div class="d-flex justify-content-center gap-2" role="group">
                                            <a href="<?php echo e(route('admin.kelas.show', ['kela' => $k])); ?>" class="btn btn-primary btn-sm" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('admin.kelas.edit', ['kela' => $k])); ?>" class="btn btn-warning btn-sm" title="Edit Data">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            
                                            <form action="<?php echo e(route('admin.kelas.destroy', ['kela' => $k])); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus Data" onclick="return confirm('APAKAH YAKIN? Anda akan menghapus kelas <?php echo e($k->nama_kelas); ?>? Tindakan ini tidak dapat dibatalkan.')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        
                                        <td colspan="4" class="text-center py-5 text-muted bg-light border-0">
                                            <i class="fas fa-box-open me-2 fa-3x mb-3 text-secondary"></i>
                                            <h5 class="mb-0 fw-bold">Data kelas kosong.</h5>
                                            <p class="mb-0 mt-2">Belum ada kelas yang ditambahkan ke dalam sistem.</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    
                    
                    
                    <div class="d-md-none p-3">
                        <?php $__empty_1 = true; $__currentLoopData = $kelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="card mb-3 shadow-sm rounded-3 border">
                                <div class="card-body p-3">
                                    
                                    
                                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                                        <div class="me-2">
                                            <h6 class="card-title fw-bold text-dark mb-0 fs-6"><?php echo e($k->nama_kelas); ?></h6>
                                            <p class="text-muted small mb-0 mt-1">
                                                No.<?php echo e(($kelas instanceof \Illuminate\Pagination\LengthAwarePaginator) 
                                                        ? $loop->iteration + ($kelas->currentPage() - 1) * $kelas->perPage() 
                                                        : $loop->iteration); ?>

                                            </p>
                                        </div>
                                        
                                        <span class="badge bg-info text-dark p-2 fw-bold text-nowrap flex-shrink-0"><i class="fas fa-layer-group me-1"></i> Level <?php echo e($k->tingkat); ?></span>
                                    </div>
                                    
                                    <div class="d-flex gap-2 w-100 pt-2">
                                        
                                        
                                        <a href="<?php echo e(route('admin.kelas.show', ['kela' => $k])); ?>" class="btn btn-primary btn-sm w-100 fw-semibold">
                                            <i class="fas fa-eye me-1"></i> Detail
                                        </a>

                                        
                                        <a href="<?php echo e(route('admin.kelas.edit', ['kela' => $k])); ?>" class="btn btn-warning btn-sm fw-semibold">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        
                                        <form action="<?php echo e(route('admin.kelas.destroy', ['kela' => $k])); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus kelas <?php echo e($k->nama_kelas); ?>?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="text-center py-5 text-muted bg-light rounded-3 shadow-sm">
                                <i class="fas fa-frown fa-3x mb-3 text-secondary opacity-75"></i>
                                <h5 class="mb-0 fw-bold">Data kelas kosong.</h5>
                                <p class="mb-0 mt-2">Silakan klik tombol Tambah Kelas Baru di atas.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    
                    
                    <?php if($kelas instanceof \Illuminate\Pagination\LengthAwarePaginator): ?>
                        <div class="card-footer bg-light border-top py-3 rounded-bottom-4">
                            <div class="d-flex justify-content-center justify-content-md-end">
                                <?php echo e($kelas->onEachSide(1)->links('pagination::bootstrap-5')); ?>

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