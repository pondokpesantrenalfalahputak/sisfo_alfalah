<?php $__env->startSection('title', 'Edit User'); ?>
<?php $__env->startSection('page_title', 'Edit Data User: ' . $user->name); ?>

<?php $__env->startSection('header_actions'); ?>
    
    <a href="<?php echo e(route('admin.user.index')); ?>" class="btn btn-outline-secondary shadow-sm rounded-pill d-none d-md-flex align-items-center fw-semibold px-4">
        <i class="fas fa-list me-2"></i>
        Daftar User
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            

            <div class="card shadow-lg border-0 rounded-4 border-start border-5 border-warning">
                
                
                <div class="card-header bg-warning text-dark p-4 rounded-top-4">
                    <h4 class="mb-0 fw-bold fs-5"><i class="fas fa-user-edit me-2"></i> Formulir Edit Data User</h4>
                    <p class="text-secondary small mb-0">Lakukan perubahan pada detail akun dan peran untuk user **<?php echo e($user->name); ?>**.</p>
                </div>
                
                <div class="card-body p-4">

                    
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
                            <h6 class="alert-heading fw-bold"><i class="fas fa-exclamation-triangle me-2"></i> Mohon koreksi kesalahan berikut:</h6>
                            <ul class="mb-0 ps-3 small">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    
                    <form action="<?php echo e(route('admin.user.update', $user)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        
                        
                        <h5 class="fw-bold text-dark mb-3 mt-2 border-bottom pb-2 text-primary"><i class="fas fa-user me-2"></i> Data Akun Utama</h5>
                        <div class="row g-3">
                            
                            
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold small">Nama Lengkap/Alias <span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm-down">
                                    <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                    
                                    <input type="text" name="name" id="name" 
                                           class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           placeholder="Nama Lengkap/Alias" value="<?php echo e(old('name', $user->name)); ?>" required>
                                    <?php $__errorArgs = ['name'];
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
                                <label for="email" class="form-label fw-semibold small">Email <span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm-down">
                                    <span class="input-group-text"><i class="fas fa-at"></i></span>
                                    
                                    <input type="email" name="email" id="email" 
                                           class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           placeholder="Alamat Email" value="<?php echo e(old('email', $user->email)); ?>" required>
                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            
                            
                            <div class="col-12">
                                <label for="role" class="form-label fw-semibold small">Peran (Role) User <span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm-down">
                                    <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                    
                                    <select name="role" id="role" class="form-select <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                        <option value="">-- Pilih Role --</option>
                                        <option value="admin" <?php echo e(old('role', $user->role) == 'admin' ? 'selected' : ''); ?>>Admin (Pengelola Sistem)</option>
                                        <option value="wali_santri" <?php echo e(old('role', $user->role) == 'wali_santri' ? 'selected' : ''); ?>>Wali Santri (Akses Portal Wali)</option>
                                    </select>
                                    <?php $__errorArgs = ['role'];
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
                        
                        <hr class="mt-5 mb-4 border-warning opacity-25">
                        
                        
                        <h5 class="fw-bold text-dark mb-3 mt-2 border-bottom pb-2 text-danger"><i class="fas fa-lock me-2"></i> Ganti Password (Opsional)</h5>
                        <div class="alert alert-info rounded-3 small shadow-sm" role="alert">
                            <i class="fas fa-info-circle me-2"></i> Kosongkan kolom password di bawah ini jika Anda tidak ingin mengubah password user.
                        </div>
                        <div class="row g-3">
                            
                            
                            <div class="col-md-6">
                                <label for="password" class="form-label fw-semibold small">Password Baru</label>
                                <div class="input-group input-group-sm-down">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    
                                    <input type="password" name="password" id="password" 
                                           class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           placeholder="Masukkan Password Baru">
                                    <?php $__errorArgs = ['password'];
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
                                <label for="password_confirmation" class="form-label fw-semibold small">Konfirmasi Password Baru</label>
                                <div class="input-group input-group-sm-down">
                                    <span class="input-group-text"><i class="fas fa-check-double"></i></span>
                                    
                                    <input type="password" name="password_confirmation" id="password_confirmation" 
                                           class="form-control" 
                                           placeholder="Konfirmasi Password Baru">
                                </div>
                            </div>
                            
                        </div>
                        
                        <hr class="mt-5 mb-4 border-dark opacity-25">
                        
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            
                            <a href="<?php echo e(route('admin.user.index')); ?>" class="btn btn-outline-secondary px-4 shadow-sm fw-semibold rounded-pill order-2 order-md-1">
                                <i class="fas fa-times me-2"></i> Batal
                            </a>
                            
                            <button type="submit" class="btn btn-warning px-4 shadow-lg fw-bold text-dark rounded-pill order-1 order-md-2">
                                <i class="fas fa-redo me-2"></i> Update User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/admin/master/user/edit.blade.php ENDPATH**/ ?>