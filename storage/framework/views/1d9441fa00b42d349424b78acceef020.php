<?php $__env->startSection('title', 'Kelola Rekening'); ?>
<?php $__env->startSection('page_title', 'Daftar Rekening Pembayaran'); ?>

<?php $__env->startSection('header_actions'); ?>
    
    <a href="<?php echo e(route('admin.rekening.create')); ?>" class="btn btn-success shadow-sm d-none d-md-flex align-items-center fw-semibold">
        <i class="fas fa-plus me-2"></i> Tambah Rekening Baru
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>



<div class="d-block d-md-none mb-3 px-3">
    <a href="<?php echo e(route('admin.rekening.create')); ?>" class="btn btn-success shadow-sm d-flex align-items-center fw-semibold w-100">
        <i class="fas fa-plus me-2"></i> Tambah Rekening Baru
    </a>
</div>
<hr class="d-block d-md-none border-secondary-subtle">
<div class="card shadow border-left-success">
    
    <div class="card-header bg-primary text-white p-4">
        <h5 class="mb-0 fw-bold"><i class="fas fa-university me-2"></i> Daftar Rekening Pembayaran</h5>
        <p class="text-white-50 small mb-0">Kelola daftar rekening yang digunakan untuk penerimaan pembayaran santri.</p>
    </div>
    
    <div class="card-body p-0">
        
        
        
        
        <div class="table-responsive d-none d-md-block">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark"> 
                    <tr>
                        <th style="width: 5%;" class="text-center">#</th>
                        <th style="width: 20%;">Nama Bank</th>
                        <th style="width: 25%;">Nomor Rekening</th>
                        <th style="width: 20%;">Atas Nama</th>
                        <th style="width: 20%;">Keterangan</th>
                        <th style="width: 10%;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $rekenings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rekening): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="text-center"><?php echo e($loop->iteration); ?></td>
                        <td>
                            <strong class="text-primary"><?php echo e($rekening->nama_bank); ?></strong>
                        </td>
                        <td>
                            <span class="fw-bold fs-6 text-dark bg-light p-1 rounded d-inline-block"><?php echo e($rekening->nomor_rekening); ?></span>
                        </td>
                        <td>
                            <span class="fw-semibold text-dark"><?php echo e($rekening->atas_nama); ?></span>
                        </td>
                        <td>
                            <small class="text-muted"><?php echo e(Str::limit($rekening->keterangan ?: 'Tidak ada keterangan', 40)); ?></small>
                        </td>
                        <td class="text-center">
                            
                            <div class="btn-group" role="group">
                                <a href="<?php echo e(route('admin.rekening.edit', $rekening)); ?>" class="btn btn-sm btn-warning" title="Edit Data">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <form action="<?php echo e(route('admin.rekening.destroy', $rekening)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus Rekening" onclick="return confirm('APAKAH YAKIN? Menghapus rekening <?php echo e($rekening->nama_bank); ?> akan memengaruhi pembayaran.')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted bg-light">
                            <i class="fas fa-money-check-alt fa-3x mb-3 text-secondary"></i>
                            <h5 class="mb-0">Belum ada data rekening yang terdaftar.</h5>
                            <p class="mb-0 mt-2">Silakan tambahkan rekening pembayaran untuk menerima tagihan.</p>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        
        
        
        <div class="d-md-none p-3">
            <?php $__empty_1 = true; $__currentLoopData = $rekenings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rekening): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="card mb-3 shadow border-start border-2 border-success">
                    <div class="card-body">
                        
                        
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <h6 class="text-muted mb-0 small"><i class="fas fa-university me-1"></i> REKENING <?php echo e($loop->iteration); ?></h6>
                                <h4 class="card-title fw-bold text-primary mb-0"><?php echo e($rekening->nama_bank); ?></h4>
                            </div>
                            <span class="badge bg-secondary p-2"><?php echo e($rekening->atas_nama); ?></span>
                        </div>
                        <hr class="my-2">
                        
                        
                        <div class="mb-3 p-2 bg-light rounded">
                            <h6 class="text-muted small mb-1">NOMOR REKENING</h6>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bolder fs-5 text-dark"><?php echo e($rekening->nomor_rekening); ?></span>
                                
                                <button class="btn btn-sm btn-outline-success" onclick="copyToClipboard('<?php echo e($rekening->nomor_rekening); ?>', this)" title="Salin Nomor Rekening">
                                    <i class="fas fa-copy"></i> Salin
                                </button>
                            </div>
                        </div>
                        
                        
                        <div class="mb-3">
                            <h6 class="text-muted small mb-1">Keterangan</h6>
                            <p class="small mb-0 fst-italic"><?php echo e($rekening->keterangan ?: 'Tidak ada keterangan spesifik.'); ?></p>
                        </div>
                        
                        <hr class="my-2">

                        
                        <div class="d-flex justify-content-end pt-2 gap-2">
                            <a href="<?php echo e(route('admin.rekening.edit', $rekening)); ?>" class="btn btn-sm btn-warning" title="Edit Data">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            
                            <form action="<?php echo e(route('admin.rekening.destroy', $rekening)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus Rekening" onclick="return confirm('APAKAH YAKIN? Menghapus rekening <?php echo e($rekening->nama_bank); ?> akan memengaruhi pembayaran.')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-center py-5 text-muted bg-light rounded">
                    <i class="fas fa-money-check-alt fa-3x mb-3 text-secondary"></i>
                    <h5 class="mb-0">Belum ada data rekening yang terdaftar.</h5>
                    <p class="mb-0 mt-2">Silakan klik tombol Tambah Rekening Baru di atas untuk menambahkan rekening bank.</p>
                </div>
            <?php endif; ?>
        </div>
        
    </div>
    
    
    <?php if($rekenings instanceof \Illuminate\Pagination\LengthAwarePaginator): ?>
        <div class="card-footer bg-light border-0">
            <div class="d-flex justify-content-center justify-content-md-end">
                <?php echo e($rekenings->links()); ?>

            </div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function copyToClipboard(textToCopy, buttonElement) {
        navigator.clipboard.writeText(textToCopy).then(function() {
            // Perubahan visual sementara
            let originalHtml = buttonElement.innerHTML;
            buttonElement.innerHTML = '<i class="fas fa-check"></i> Disalin!';
            buttonElement.classList.remove('btn-outline-success');
            buttonElement.classList.add('btn-success');
            
            setTimeout(() => {
                buttonElement.innerHTML = originalHtml;
                buttonElement.classList.remove('btn-success');
                buttonElement.classList.add('btn-outline-success');
            }, 1000);

        }, function(err) {
            console.error('Could not copy text: ', err);
            alert('Gagal menyalin nomor rekening.');
        });
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/admin/rekening/index.blade.php ENDPATH**/ ?>