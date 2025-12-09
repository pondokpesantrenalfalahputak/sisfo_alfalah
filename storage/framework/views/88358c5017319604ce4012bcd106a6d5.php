<?php $__env->startSection('title', 'Data Guru'); ?>
<?php $__env->startSection('page_title', 'Daftar Guru'); ?>


<?php $__env->startSection('header_actions'); ?>
    <a href="<?php echo e(route('admin.guru.create')); ?>" class="btn btn-primary btn-sm px-3 shadow-sm rounded d-flex align-items-center fw-semibold d-none d-md-flex">
        <i class="fas fa-plus me-2"></i>
        Tambah Guru Baru
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0" role="alert">
                    <i class="fas fa-check-circle me-2"></i> Berhasil! <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                
                
                <div class="card-header bg-white border-bottom p-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                        
                        
                        
                        <div class="w-100 w-md-auto mt-2 mt-md-0">
                            <form action="<?php echo e(route('admin.guru.index')); ?>" method="GET" class="d-flex input-group input-group-sm">
                                <input type="text" name="search" class="form-control shadow-none" placeholder="Cari Nama Pendidik..." value="<?php echo e(request('search')); ?>">
                                <button type="submit" class="btn btn-outline-secondary" title="Cari Data"><i class="fas fa-search"></i></button>
                                <?php if(request('search')): ?>
                                    <a href="<?php echo e(route('admin.guru.index')); ?>" class="btn btn-outline-danger" title="Hapus Pencarian"><i class="fas fa-times"></i></a>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                    
                    
                    <?php
                        $totalData = ($gurus instanceof \Illuminate\Pagination\LengthAwarePaginator) ? $gurus->total() : $gurus->count();
                    ?>
                    <p class="text-muted small mb-0 mt-3 d-none d-md-block">Total <?php echo e($totalData); ?> data guru terdaftar.</p>
                </div>
                
                <div class="card-body p-0">
                    
                    
                    <div class="table-responsive d-none d-md-block">
                        <table class="table table-striped table-hover align-middle mb-0">
                            <thead class="table-light text-nowrap">
                                <tr class="fw-bold text-uppercase small">
                                    <th style="width: 5%;" class="text-center">#</th>
                                    <th style="width: 25%;">Nama Lengkap</th>
                                    <th style="width: 15%;">NUPTK</th>
                                    <th style="width: 20%;">Jabatan</th>
                                    <th style="width: 15%;">No HP</th>
                                    <th style="width: 20%;" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $gurus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $guru): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="text-center text-muted small">
                                        <?php if($gurus instanceof \Illuminate\Pagination\LengthAwarePaginator): ?>
                                            <?php echo e($loop->iteration + ($gurus->currentPage() - 1) * $gurus->perPage()); ?>

                                        <?php else: ?>
                                            <?php echo e($loop->iteration); ?>

                                        <?php endif; ?>
                                    </td>
                                    <td class="fw-semibold text-dark"><?php echo e($guru->nama_lengkap); ?></td>
                                    <td><span class="fw-bold text-secondary text-nowrap small"><?php echo e($guru->nuptk); ?></span></td>
                                    <td><span class="badge bg-info text-dark p-2 fw-semibold text-nowrap"><?php echo e($guru->jabatan); ?></span></td>
                                    <td><span class="fw-semibold text-nowrap"><?php echo e($guru->no_hp); ?></span></td>
                                    <td class="text-center text-nowrap">
                                        
                                        <div class="d-flex justify-content-center gap-2" role="group">
                                            <a href="<?php echo e(route('admin.guru.show', $guru)); ?>" class="btn btn-primary btn-sm" title="Lihat Detail"><i class="fas fa-eye"></i></a>
                                            <a href="<?php echo e(route('admin.guru.edit', $guru)); ?>" class="btn btn-warning btn-sm" title="Edit Data"><i class="fas fa-edit"></i></a>
                                            
                                            <form action="<?php echo e(route('admin.guru.destroy', $guru)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus Data" onclick="return confirm('APAKAH YAKIN? Anda akan menghapus data guru: <?php echo e($guru->nama_lengkap); ?>?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted bg-light border-0">
                                            <i class="fas fa-box-open me-2 fa-3x mb-3 text-secondary"></i>
                                            <h5 class="mb-0 fw-bold">Data guru kosong.</h5>
                                            <p class="mb-0 mt-2">Belum ada guru yang ditambahkan ke dalam sistem.</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    
                    <div class="d-md-none p-3">
                        
                        <div class="mb-3">
                            <a href="<?php echo e(route('admin.guru.create')); ?>" class="btn btn-success w-100 fw-semibold shadow-sm">
                                <i class="fas fa-plus me-1"></i> Tambah Guru Baru
                            </a>
                        </div>
                        
                        <?php $__empty_1 = true; $__currentLoopData = $gurus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $guru): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="card mb-3 shadow-sm rounded-3 border">
                                <div class="card-body p-3">
                                    
                                    
                                    <div class="d-flex justify-content-between align-items-start mb-3 pb-2 border-bottom">
                                        <div class="me-2">
                                            <h6 class="card-title fw-bold text-dark mb-1 fs-6"><?php echo e($guru->nama_lengkap); ?></h6>
                                            <h7 class="badge bg-primary text-white p-2 fw-bold text-nowrap flex-shrink-0 mt-1"><i class="fas fa-user-tie me-1"></i> <?php echo e($guru->jabatan); ?></h7>
                                            <p class="text-muted small mb-0">No Urut:<?php echo e($loop->iteration); ?></p>
                                        </div>
                                        
                                    </div>
                                    
                                    
                                    
                                    <ul class="list-unstyled small text-muted mb-3">
                                        <li class="mb-1"><i class="fas fa-fingerprint me-2 text-secondary"></i> NUPTK: <?php echo e($guru->nuptk); ?></li>
                                        <li class="mb-1"><i class="fas fa-phone me-2 text-secondary"></i> No HP: <?php echo e($guru->no_hp); ?></li>
                                    </ul>

                                    
                                    <div class="d-flex justify-content-end pt-2">
                                        <div class="d-flex gap-2 w-100" role="group">
                                            
                                            <a href="<?php echo e(route('admin.guru.show', $guru)); ?>" class="btn btn-primary btn-sm w-100 fw-semibold">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                            
                                            <a href="<?php echo e(route('admin.guru.edit', $guru)); ?>" class="btn btn-warning btn-sm w-100 fw-semibold">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            
                                            
                                            <form action="<?php echo e(route('admin.guru.destroy', $guru)); ?>" method="POST" class="d-inline w-100">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-danger btn-sm w-100" onclick="return confirm('Yakin ingin menghapus guru <?php echo e($guru->nama_lengkap); ?>?')">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="text-center py-5 text-muted bg-light rounded-3 shadow-sm">
                                <i class="fas fa-frown fa-3x mb-3 text-secondary opacity-75"></i>
                                <h5 class="mb-0 fw-bold">Data guru kosong.</h5>
                                <p class="mb-0 mt-2">Silakan klik tombol Tambah Guru Baru di atas.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    
                    
                    <?php if($gurus instanceof \Illuminate\Pagination\LengthAwarePaginator): ?>
                        <div class="card-footer bg-light border-top py-3 rounded-bottom-4">
                            <div class="d-flex justify-content-center justify-content-md-end">
                                <?php echo e($gurus->onEachSide(1)->links('pagination::bootstrap-5')); ?>

                            </div>
                        </div>
                    <?php endif; ?>
                    
                </div>
            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/admin/master/guru/index.blade.php ENDPATH**/ ?>