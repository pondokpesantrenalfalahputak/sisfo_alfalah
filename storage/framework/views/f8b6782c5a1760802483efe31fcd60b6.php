<?php $__env->startSection('title', 'Edit Data Kelas'); ?>
<?php $__env->startSection('page_title', 'Edit Kelas: ' . $kela->nama_kelas); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <div class="card shadow-lg border-0 rounded-4">
                
                
                <div class="card-header bg-warning text-dark p-4 rounded-top-4 border-bottom border-light">
                    <h5 class="mb-0 fw-bold fs-6"><i class="fas fa-edit me-2"></i> Formulir Perubahan Data Kelas</h5>
                    <p class="text-dark-50 small mb-0">Sesuaikan Nama Kelas dan Tingkat Pendidikan.</p>
                </div>
                
                <div class="card-body p-4">
                    
                    
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm border-danger" role="alert">
                            <h6 class="alert-heading fw-bold"><i class="fas fa-exclamation-circle me-2"></i> Kesalahan Input Terdeteksi:</h6>
                            <ul class="mb-0 ps-3 small">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    
                    <form action="<?php echo e(route('admin.kelas.update', ['kela' => $kela])); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="row g-4">

                            
                            <div class="col-md-6">
                                
                                <label for="nama_kelas" class="form-label fw-semibold small text-muted mb-1">Nama Kelas <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-primary border-end-0"><i class="fas fa-school"></i></span>
                                    <input type="text" name="nama_kelas" **id="nama_kelas"**
                                           class="form-control <?php $__errorArgs = ['nama_kelas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           placeholder="Contoh: VII A, X IPA 1"
                                           value="<?php echo e(old('nama_kelas', $kela->nama_kelas)); ?>" required>
                                </div>
                                <?php $__errorArgs = ['nama_kelas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                <?php else: ?>
                                    <small class="text-muted d-block mt-1">Masukkan nama kelas secara lengkap.</small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            
                            <div class="col-md-6">
                                
                                <label for="tingkat" class="form-label fw-semibold small text-muted mb-1">Tingkat Kelas <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-info border-end-0"><i class="fas fa-layer-group"></i></span>
                                    <select name="tingkat" **id="tingkat"** 
                                            class="form-select <?php $__errorArgs = ['tingkat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                        <option value="">-- Pilih Tingkat --</option>

                                        
                                        <?php
                                            $tingkatKelas = [7, 8, 9, 10, 11, 12, 13];
                                        ?>

                                        <?php $__currentLoopData = $tingkatKelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tingkatOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($tingkatOption); ?>" <?php echo e(old('tingkat', $kela->tingkat) == $tingkatOption ? 'selected' : ''); ?>>Tingkat <?php echo e($tingkatOption); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </select>
                                </div>
                                <?php $__errorArgs = ['tingkat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                <?php else: ?>
                                    <small class="text-muted d-block mt-1">Pilih tingkat/level kelas yang relevan (7-13).</small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                        </div>
                        
                        <hr class="mt-5 mb-4 border-warning opacity-25">
                        
                        
                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?php echo e(route('admin.kelas.index')); ?>" class="btn btn-outline-secondary px-4 shadow-sm fw-semibold rounded-pill">
                                <i class="fas fa-times me-2"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-warning px-4 shadow-lg fw-bold text-dark rounded-pill">
                                <i class="fas fa-redo me-2"></i> Update Kelas
                            </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/admin/master/kelas/edit.blade.php ENDPATH**/ ?>