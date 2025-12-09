<?php $__env->startSection('title', 'Tambah User'); ?>
<?php $__env->startSection('page_title', 'Registrasi User Baru'); ?>

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

            

            <div class="card shadow-lg border-0 rounded-4 border-start border-5 border-primary">
                
                
                <div class="card-header bg-primary text-white p-4 rounded-top-4">
                    <h4 class="mb-0 fw-bold fs-5"><i class="fas fa-user-plus me-2"></i> Formulir Tambah User</h4>
                    <p class="text-white-50 small mb-0">Masukkan detail akun dan tentukan peran (role) untuk user baru.</p>
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

                    <form action="<?php echo e(route('admin.user.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        
                        
                        <h5 class="fw-bold text-dark mb-3 mt-2 border-bottom pb-2 text-primary"><i class="fas fa-user me-2"></i> Data Akun User</h5>
                        
                        <div class="row g-3"> 
                            
                            
                            <div class="col-md-6">
                                
                                <label for="name" class="form-label fw-semibold small">Nama Lengkap/Alias <span class="text-danger">*</span></label> 
                                <div class="input-group">
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
                                           placeholder="Nama Lengkap/Alias" value="<?php echo e(old('name')); ?>" required>
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
                                <div class="input-group">
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
                                           placeholder="Alamat Email" value="<?php echo e(old('email')); ?>" required>
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
                                <div class="input-group">
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
                                        <option value="admin" <?php echo e(old('role') == 'admin' ? 'selected' : ''); ?>>Admin (Pengelola Sistem)</option>
                                        <option value="wali_santri" <?php echo e(old('role') == 'wali_santri' ? 'selected' : ''); ?>>Wali Santri (Akses Portal Wali)</option>
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
                        
                        <hr class="mt-5 mb-4 border-primary opacity-25">
                        
                        
                        <h5 class="fw-bold text-dark mb-3 mt-2 border-bottom pb-2 text-danger"><i class="fas fa-lock me-2"></i> Keamanan (Password)</h5>
                        
                        <div class="row g-3"> 
                            
                            
                            <div class="col-md-6">
                                
                                <label for="password" class="form-label fw-semibold small">Password <span class="text-danger">*</span></label>
                                <div class="input-group">
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
                                           placeholder="Password Baru" required>
                                    
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword" title="Tampilkan/Sembunyikan Password">
                                        <i class="fas fa-eye"></i>
                                    </button>
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
                                
                                <label for="password_confirmation" class="form-label fw-semibold small">Konfirmasi Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-check-double"></i></span>
                                    
                                    <input type="password" name="password_confirmation" id="password_confirmation" 
                                           class="form-control" 
                                           placeholder="Konfirmasi Password" required>
                                    
                                    <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword" title="Tampilkan/Sembunyikan Konfirmasi Password">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            
                        </div>
                        
                        <hr class="mt-5 mb-4 border-dark opacity-25">
                        
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            
                            <a href="<?php echo e(route('admin.user.index')); ?>" class="btn btn-outline-secondary px-4 shadow-sm fw-semibold rounded-pill order-2 order-md-1">
                                <i class="fas fa-times me-2"></i> Batal
                            </a>
                            
                            <button type="submit" class="btn btn-primary px-4 shadow-lg fw-bold rounded-pill order-1 order-md-2">
                                <i class="fas fa-user-plus me-2"></i> Simpan User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Fungsi universal untuk mengaktifkan toggle password (dipertahankan karena ini fitur UX yang baik)
    function setupPasswordToggle(inputId, toggleBtnId) {
        const passwordInput = document.getElementById(inputId);
        const toggleButton = document.getElementById(toggleBtnId);

        if (!passwordInput || !toggleButton) return;

        toggleButton.addEventListener('click', function() {
            // Toggle type input antara 'password' dan 'text'
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Ganti ikon mata
            const icon = toggleButton.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash'); // Gunakan ikon mata dicoret
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Terapkan toggle untuk input Password utama
        setupPasswordToggle('password', 'togglePassword');
        
        // Terapkan toggle untuk input Konfirmasi Password
        setupPasswordToggle('password_confirmation', 'toggleConfirmPassword');
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/admin/master/user/create.blade.php ENDPATH**/ ?>