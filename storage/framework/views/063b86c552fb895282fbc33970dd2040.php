<?php $__env->startSection('title', 'Data Santri'); ?>
<?php $__env->startSection('page_title', 'Daftar Santri'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    /* Transisi untuk elemen dinamis */
    .smooth-transition {
        transition: all 0.3s ease-in-out;
    }
    /* Efek hover pada baris tabel */
    .table-hover tbody tr:hover {
        background-color: #f8f9fa !important;
        transform: scale(1.005);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    }
    /* Tombol Aksi di mobile lebih kecil dan ringkas */
    @media (max-width: 767.98px) {
        /* Memperkecil tombol Tambah Santri di header mobile */
        .btn-header-mobile {
            padding: 0.5rem 1rem !important;
            font-size: 0.875rem !important;
        }
        .btn-header-mobile i {
            font-size: 0.8rem;
        }
        /* Mengubah tata letak header_actions di mobile agar rapi */
        .header-action-container {
            width: 100%;
            display: flex;
            justify-content: flex-end;
            margin-top: 1rem; /* Memberi jarak dari page title */
        }
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('header_actions'); ?>
    
    
    <div class="header-action-container d-none d-md-block">
        <a href="<?php echo e(route('admin.santri.create')); ?>" class="btn btn-primary d-flex align-items-center fw-semibold px-4 py-2 border-0 shadow-sm rounded-3 smooth-transition">
            <i class="fas fa-plus me-2"></i>
            Tambah Santri Baru
        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            
            <div class="d-flex justify-content-end mb-3 d-md-none">
                <a href="<?php echo e(route('admin.santri.create')); ?>" class="btn btn-primary btn-header-mobile d-flex align-items-center fw-semibold border-0 shadow-sm rounded-3 smooth-transition">
                    <i class="fas fa-plus me-1"></i> Tambah Baru
                </a>
            </div>

            <?php
                $perPage = $santris instanceof \Illuminate\Pagination\LengthAwarePaginator ? $santris->perPage() : 10;
                $currentPage = $santris instanceof \Illuminate\Pagination\LengthAwarePaginator ? $santris->currentPage() : 1;
                $startIndex = ($currentPage - 1) * $perPage;
            ?>

            <div class="card shadow-lg border-0 rounded-4 smooth-transition">
                
                
                <div class="card-header bg-white border-bottom-0 p-4 rounded-top-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                        
                        
                        <div class="w-100 w-md-auto mt-2 mt-md-0">
                            <form action="<?php echo e(route('admin.santri.index')); ?>" method="GET" class="d-flex input-group input-group-sm rounded-pill overflow-hidden shadow-sm border border-light-subtle">
                                <input type="text" name="search" class="form-control border-0 ps-3" placeholder="Cari NISN atau Nama..." value="<?php echo e(request('search')); ?>">
                                <button type="submit" class="btn btn-primary text-white border-0" title="Cari Data"><i class="fas fa-search"></i></button>
                                <?php if(request('search')): ?>
                                    
                                    <a href="<?php echo e(route('admin.santri.index')); ?>" class="btn btn-secondary text-white border-0" title="Hapus Pencarian"><i class="fas fa-times"></i></a>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    
                    
                    
                    
                    <div class="table-responsive d-none d-md-block">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-primary-subtle text-primary fw-bold">
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
                                <?php $__empty_1 = true; $__currentLoopData = $santris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $santri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="border-bottom-0 smooth-transition">
                                    <td class="text-center text-muted small"><?php echo e($startIndex + $index + 1); ?></td>
                                    <td class="fw-bold text-dark"><?php echo e($santri->nisn); ?></td>
                                    <td class="fw-semibold text-primary"><?php echo e($santri->nama_lengkap); ?></td>
                                    <td>
                                        <span class="badge rounded-pill bg-info-subtle text-info fw-bold px-3 py-1"><?php echo e($santri->kelas?->nama_kelas ?? 'Tanpa Kelas'); ?></span>
                                    </td>
                                    <td><span class="text-muted small"><?php echo e($santri->waliSantri?->name ?? '-'); ?></span></td>
                                    <td><?php echo e($santri->jenis_kelamin); ?></td>
                                    <td>
                                        <span class="badge rounded-pill bg-<?php echo e($santri->status == 'Aktif' ? 'success' : 'secondary'); ?> text-white fw-bold px-3 py-1">
                                            <?php echo e($santri->status); ?>

                                        </span>
                                    </td>
                                    <td class="text-center text-nowrap">
                                        
                                        <div class="d-flex justify-content-center smooth-transition gap-1"> 
                                            <a href="<?php echo e(route('admin.santri.show', $santri)); ?>" class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('admin.santri.edit', $santri)); ?>" class="btn btn-sm btn-outline-warning" title="Edit Data">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            
                                            <form action="<?php echo e(route('admin.santri.destroy', $santri)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-outline-danger delete-confirm" title="Hapus Data" data-santri="<?php echo e($santri->nama_lengkap); ?>">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="8" class="text-center py-5 text-muted bg-light">
                                            <i class="fas fa-box-open me-2 fa-4x mb-3 text-secondary"></i>
                                            <h4 class="mb-0 fw-bold">Data santri tidak ditemukan.</h4>
                                            <p class="mb-0 mt-2">Silakan <a href="<?php echo e(route('admin.santri.create')); ?>" class="text-primary fw-semibold">tambah santri baru</a>.</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    
                    
                    
                    <div class="d-md-none p-3">
                        <?php $__empty_1 = true; $__currentLoopData = $santris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $santri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="card mb-3 shadow-sm rounded-3 border-0 smooth-transition">
                                <div class="card-body p-3">
                                    
                                    <div class="d-flex justify-content-between align-items-start mb-3 border-bottom pb-2">
                                        <div>
                                            <h6 class="text-muted mb-0 small">
                                                #<?php echo e($startIndex + $index + 1); ?> | NISN: 
                                                <span class="fw-bold text-dark"><?php echo e($santri->nisn); ?></span>
                                            </h6>
                                            <h5 class="card-title fw-bold text-primary mb-1 mt-1"><?php echo e($santri->nama_lengkap); ?></h5>
                                        </div>
                                        <span class="badge rounded-pill bg-<?php echo e($santri->status == 'Aktif' ? 'success' : 'secondary'); ?> text-white p-2 fw-bold align-self-center">
                                            <?php echo e($santri->status); ?>

                                        </span>
                                    </div>
                                    
                                    
                                    <div class="row small g-2 mb-4">
                                        
                                        <div class="col-12 mb-2"> 
                                            <span class="text-muted d-block fw-normal small">Kelas</span>
                                            <span class="badge rounded-pill bg-info-subtle text-info fw-bold"><?php echo e($santri->kelas?->nama_kelas ?? 'Tanpa Kelas'); ?></span>
                                        </div>
                                        
                                        
                                        <div class="col-12">
                                            <span class="text-muted d-block fw-normal small">Jenis Kelamin</span>
                                            <span class="fw-semibold text-dark"><?php echo e($santri->jenis_kelamin); ?></span>
                                        </div>
                                        
                                        
                                        <div class="col-12 mt-2">
                                            <span class="text-muted d-block fw-normal small">Wali Santri</span>
                                            <span class="fw-bold text-secondary"><?php echo e($santri->waliSantri?->name ?? '-'); ?></span>
                                        </div>
                                    </div>

                                    
                                    <div class="d-flex gap-2 pt-2 border-top">
                                        
                                        <a href="<?php echo e(route('admin.santri.show', $santri)); ?>" class="btn btn-sm btn-outline-primary fw-semibold w-100 smooth-transition" title="Lihat Detail">
                                            <i class="fas fa-eye me-1"></i> Detail
                                        </a>
                                        <a href="<?php echo e(route('admin.santri.edit', $santri)); ?>" class="btn btn-sm btn-outline-warning fw-semibold w-100 smooth-transition" title="Edit Data">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </a>
                                        
                                        <form action="<?php echo e(route('admin.santri.destroy', $santri)); ?>" method="POST" class="d-inline w-100">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger w-100 fw-semibold delete-confirm smooth-transition" title="Hapus Data" data-santri="<?php echo e($santri->nama_lengkap); ?>">
                                                <i class="fas fa-trash me-1"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="text-center py-5 text-muted bg-white rounded-4 shadow-sm border">
                                <i class="fas fa-box-open me-2 fa-3x mb-3 text-secondary"></i>
                                <h5 class="mb-0 fw-bold">Tidak ada data santri.</h5>
                                <p class="mb-0 mt-2">Silakan klik tombol "Tambah Santri Baru".</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    
                    
                    <?php if($santris instanceof \Illuminate\Pagination\LengthAwarePaginator): ?>
                        <div class="card-footer bg-light border-0 pt-3 rounded-bottom-4">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center small text-muted">
                                <div class="mb-2 mb-md-0">
                                    Menampilkan <?php echo e($santris->firstItem() ?? 0); ?> hingga <?php echo e($santris->lastItem() ?? 0); ?> dari <?php echo e($santris->total()); ?> data
                                </div>
                                <div>
                                    <?php echo e($santris->appends(request()->query())->links('pagination::bootstrap-5')); ?>

                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Konfirmasi Hapus untuk konsistensi
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.delete-confirm').forEach(button => {
            button.addEventListener('click', function(e) {
                const santriName = this.getAttribute('data-santri');
                
                if (!confirm(`Apakah Anda yakin ingin menghapus santri: ${santriName}? Tindakan ini tidak dapat dibatalkan.`)) {
                    e.preventDefault();
                }
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/admin/master/santri/index.blade.php ENDPATH**/ ?>