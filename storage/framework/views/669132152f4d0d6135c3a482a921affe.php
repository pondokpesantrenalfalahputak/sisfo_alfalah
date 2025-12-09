<?php $__env->startSection('title', 'Data User'); ?>
<?php $__env->startSection('page_title', 'Daftar Pengguna Sistem'); ?>


<?php $__env->startSection('header_actions'); ?>
    <a href="<?php echo e(route('admin.user.create')); ?>" class="btn btn-primary shadow-lg rounded-pill d-none d-md-flex align-items-center fw-bold px-4">
        <i class="fas fa-user-plus me-2"></i>
        Tambah User Baru
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            
            
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                
                
                <div class="card-header bg-white border-bottom p-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                        
                        
                        <div class="w-100 w-md-auto">
                            
                            
                            <form action="<?php echo e(route('admin.user.index')); ?>" method="GET" class="d-flex input-group input-group-sm rounded-pill overflow-hidden shadow-sm mb-3 mb-md-0">
                                <input type="text" name="search" class="form-control border-0 ps-3" placeholder="Cari Nama/Email..." value="<?php echo e(request('search')); ?>">
                                <button type="submit" class="btn btn-primary px-3" title="Cari Data"><i class="fas fa-search"></i></button>
                                <?php if(request('search')): ?>
                                    <a href="<?php echo e(route('admin.user.index')); ?>" class="btn btn-danger px-3" title="Hapus Pencarian"><i class="fas fa-times"></i></a>
                                <?php endif; ?>
                            </form>

                            
                            <a href="<?php echo e(route('admin.user.create')); ?>" class="btn btn-primary btn-block shadow-sm rounded-pill d-md-none fw-bold w-100">
                                <i class="fas fa-user-plus me-1"></i> Tambah User Baru
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    
                    
                    
                    
                    <div class="table-responsive d-none d-md-block">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light text-nowrap">
                                <tr>
                                    <th style="width: 5%;" class="text-center">No</th>
                                    <th style="width: 25%;">Nama</th>
                                    <th style="width: 30%;">Email</th>
                                    <th style="width: 15%;">Role</th>
                                    <th style="width: 25%;" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php
                                    $badgeClass = match($user->role) {
                                        'admin' => 'danger',
                                        'wali_santri' => 'primary',
                                        default => 'secondary',
                                    };
                                ?>
                                <tr>
                                    <td class="text-center text-muted"><?php echo e($loop->iteration); ?></td>
                                    <td class="fw-bold text-dark"><?php echo e($user->name); ?></td>
                                    <td class="text-muted"><?php echo e($user->email); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo e($badgeClass); ?> fw-bold p-2 rounded-pill">
                                            <?php echo e(ucfirst(str_replace('_', ' ', $user->role))); ?>

                                        </span>
                                    </td>
                                    <td class="text-center text-nowrap">
                                        
                                        <div class="d-flex justify-content-center gap-2" role="group">
                                            <a href="<?php echo e(route('admin.user.show', $user)); ?>" class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('admin.user.edit', $user)); ?>" class="btn btn-sm btn-outline-warning" title="Edit Data">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            
                                            <form action="<?php echo e(route('admin.user.destroy', $user)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Data" onclick="return confirm('Apakah Anda yakin ingin menghapus user: <?php echo e($user->name); ?>? Tindakan ini tidak dapat dibatalkan.')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted bg-light">
                                            <i class="fas fa-user-times me-2 fa-3x mb-3 text-secondary"></i>
                                            <h5 class="mb-0 fw-bold">Tidak ada data pengguna yang ditemukan.</h5>
                                            <p class="mb-0 mt-2">Silakan klik tombol Tambah User Baru di atas.</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    
                    
                    
                    <div class="d-md-none p-4">
                        <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $badgeClass = match($user->role) {
                                    'admin' => 'danger',
                                    'wali_santri' => 'primary',
                                    default => 'secondary',
                                };
                                $roleDisplay = ucfirst(str_replace('_', ' ', $user->role));
                                
                                $borderColor = match($user->role) {
                                    'admin' => 'danger',
                                    'wali_santri' => 'primary',
                                    default => 'secondary',
                                };
                            ?>
                            <div class="card mb-3 shadow-sm rounded-4 border-start border-4 border-<?php echo e($borderColor); ?>">
                                <div class="card-body p-3">
                                    
                                    
                                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom border-dashed">
                                        <div>
                                            <h6 class="text-muted mb-0 small fw-semibold">PENGGUNA <?php echo e($loop->iteration); ?></h6>
                                        </div>
                                        <span class="badge bg-<?php echo e($badgeClass); ?> p-2 fw-bold rounded-pill"><?php echo e($roleDisplay); ?></span>
                                    </div>
                                    
                                    
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-user-circle me-3 text-primary fs-6"></i>
                                            <div>
                                                <span class="d-block small text-muted">Nama Lengkap</span>
                                                <span class="fw-bold text-dark fs-6"><?php echo e($user->name); ?></span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-envelope me-3 text-primary fs-6"></i>
                                            <div>
                                                <span class="d-block small text-muted">Email</span>
                                                <span class="fw-bold text-secondary small"><?php echo e($user->email); ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    
                                    <div class="d-flex gap-2 justify-content-end pt-2 border-top">
                                        
                                        <a href="<?php echo e(route('admin.user.show', $user)); ?>" class="btn btn-sm btn-outline-primary fw-semibold px-3" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?php echo e(route('admin.user.edit', $user)); ?>" class="btn btn-sm btn-outline-warning fw-semibold px-3" title="Edit Data">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <form action="<?php echo e(route('admin.user.destroy', $user)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger fw-semibold px-3" title="Hapus Data" onclick="return confirm('Apakah Anda yakin ingin menghapus user: <?php echo e($user->name); ?>? Tindakan ini tidak dapat dibatalkan.')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="text-center py-5 text-muted bg-light rounded-4 shadow-sm">
                                <i class="fas fa-user-times me-2 fa-3x mb-3 text-secondary"></i>
                                <h5 class="mb-0 fw-bold">Tidak ada data pengguna yang ditemukan.</h5>
                                <p class="mb-0 mt-2 small">Silakan gunakan tombol Tambah User Baru di atas.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    
                    
                    <?php if($users instanceof \Illuminate\Pagination\LengthAwarePaginator): ?>
                        <div class="card-footer bg-white border-top p-3 rounded-bottom-4">
                            <div class="d-flex justify-content-center justify-content-md-end">
                                <?php echo e($users->links()); ?>

                            </div>
                        </div>
                    <?php endif; ?>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/admin/master/user/index.blade.php ENDPATH**/ ?>