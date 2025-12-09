<?php $__env->startSection('title', 'Tambah Rekening'); ?>
<?php $__env->startSection('page_title', 'Tambah Rekening Pembayaran Baru'); ?>

<?php $__env->startSection('header_actions'); ?>
    
    <a href="<?php echo e(route('admin.rekening.index')); ?>" class="btn btn-outline-secondary shadow-sm rounded-pill d-flex align-items-center fw-semibold px-3">
        <i class="fas fa-list-alt me-2"></i>
        Daftar Rekening
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            
            <h2 class="mb-4 text-dark fw-bold">➕ Tambah Rekening Baru</h2>

            <div class="card shadow-lg border-0 rounded-4 border-start border-5 border-success">
                
                
                <div class="card-header bg-primary text-white p-4 rounded-top-4">
                    <h4 class="mb-0 fw-bold fs-5"><i class="fas fa-plus-circle me-2"></i> Formulir Tambah Rekening</h4>
                    <p class="text-white-50 small mb-0">Masukkan detail rekening yang akan digunakan untuk penerimaan pembayaran tagihan.</p>
                </div>
                
                <div class="card-body p-4">
                    
                    
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                            <h6 class="alert-heading fw-bold"><i class="fas fa-exclamation-triangle me-2"></i> Mohon koreksi kesalahan berikut:</h6>
                            <ul class="mb-0 ps-3">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    
                    <form action="<?php echo e(route('admin.rekening.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        
                        <div class="row g-4">
                            
                            
                            <div class="col-md-6">
                                <label for="nama_bank" class="form-label fw-semibold">Nama Bank <span class="text-danger">*</span></label>
                                
                                <div class="input-group"> 
                                    <span class="input-group-text"><i class="fas fa-university"></i></span>
                                    <input type="text" name="nama_bank" id="nama_bank" 
                                           class="form-control <?php $__errorArgs = ['nama_bank'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           placeholder="Contoh: BRI, Mandiri, BNI" value="<?php echo e(old('nama_bank')); ?>" required>
                                    <?php $__errorArgs = ['nama_bank'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            
                            
                            <div class="col-md-6">
                                <label for="nomor_rekening" class="form-label fw-semibold">Nomor Rekening <span class="text-danger">*</span></label>
                                
                                <div class="input-group"> 
                                    <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                                    <input type="text" name="nomor_rekening" id="nomor_rekening" 
                                           class="form-control <?php $__errorArgs = ['nomor_rekening'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           placeholder="Masukkan Nomor Rekening Tanpa Spasi" 
                                           value="<?php echo e(old('nomor_rekening')); ?>" 
                                           required
                                           inputmode="numeric" 
                                           pattern="[0-9]+"> 
                                    <?php $__errorArgs = ['nomor_rekening'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            
                            
                            <div class="col-md-6">
                                <label for="atas_nama" class="form-label fw-semibold">Atas Nama Pemilik Rekening <span class="text-danger">*</span></label>
                                
                                <div class="input-group"> 
                                    <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                                    <input type="text" name="atas_nama" id="atas_nama" 
                                           class="form-control <?php $__errorArgs = ['atas_nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           placeholder="Masukkan Nama Lengkap Sesuai Rekening" value="<?php echo e(old('atas_nama')); ?>" required>
                                    <?php $__errorArgs = ['atas_nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            
                            
                            <div class="col-md-6">
                                <label for="keterangan" class="form-label fw-semibold">Keterangan (Opsional)</label>
                                
                                <div class="input-group"> 
                                    <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                                    <textarea name="keterangan" id="keterangan" 
                                            class="form-control <?php $__errorArgs = ['keterangan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                            placeholder="Contoh: Rekening khusus pembayaran SPP" 
                                            rows="3"><?php echo e(old('keterangan')); ?></textarea>
                                    <?php $__errorArgs = ['keterangan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            
                        </div>
                        
                        <hr class="mt-5 mb-4 border-dark opacity-25">
                        
                        
                        
                        <div class="d-block d-md-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-success px-4 shadow-sm fw-semibold rounded-pill mb-2 mb-md-0">
                                <i class="fas fa-save me-2"></i> Simpan Rekening
                            </button>
                            <a href="<?php echo e(route('admin.rekening.index')); ?>" class="btn btn-outline-secondary px-4 shadow-sm fw-semibold rounded-pill mb-2 mb-md-0">
                                <i class="fas fa-arrow-left me-2"></i> Batal
                            </a>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/admin/rekening/create.blade.php ENDPATH**/ ?>