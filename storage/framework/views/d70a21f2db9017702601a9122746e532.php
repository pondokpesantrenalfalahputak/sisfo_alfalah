<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - SIAP AL-FALAH</title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F3F4F6; /* Mirip bg-gray-100 */
        }
        .bg-login-image {
            /* Ganti path image sesuai lokasi file Anda */
            background-image: url('<?php echo e(asset('images/1728115006026 copy.png')); ?>');
            background-size: cover;
            background-position: center 30%;
            min-height: 250px;
        }
        @media (min-width: 768px) {
            .bg-login-image {
                min-height: auto;
                background-position: center;
            }
        }
        .card-register {
            border: none;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .hero-text-overlay {
            position: absolute;
            inset: 0;
            background-color: rgba(17, 24, 39, 0.7); /* Overlay Biru Gelap */
        }
        .password-input-container {
            position: relative;
        }
        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6B7280;
            z-index: 10;
        }
        .btn-primary-custom {
            background-color: #2563EB;
            border-color: #2563EB;
            transition: background-color 0.2s;
        }
        .btn-primary-custom:hover {
            background-color: #1D4ED8;
            border-color: #1D4ED8;
        }
    </style>
</head>
<body>
    <div class="d-flex align-items-center justify-content-center min-vh-100 p-3">
        <div class="card card-register w-100 mx-auto" style="max-width: 1200px;">
            <div class="row g-0">
                
                <div class="col-md-6 bg-login-image d-flex flex-column justify-content-end position-relative text-white p-4 p-md-5">
                    <div class="hero-text-overlay"></div>
                    <div class="position-relative z-1">
                        <span class="bg-warning text-black fw-bold badge px-3 py-1 rounded-pill mb-3">
                            SELAMAT DATANG
                        </span>
                        <h1 class="h3 fw-bold lh-sm mb-2">Sistem Informasi Akademik</h1>
                        <p class="h5">PONPES AL-FALAH PUTAK</p>
                    </div>
                </div>

                
                <div class="col-md-6 bg-white p-4 p-md-5">
                    <div class="text-center mb-4">
                        <img src="<?php echo e(asset('images/kop pondok.png')); ?>" alt="Logo pesantren" style="width: 80px; height: 80px;">
                    </div>

                    <h2 class="h4 fw-bold text-center text-gray-800">Buat Akun Wali Santri</h2>
                    <p class="text-center text-secondary mb-4 small">
                        Daftarkan akun Anda (Wali Santri) dan data Santri yang diasuh.
                    </p>

                    
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger py-2" role="alert">
                            <h4 class="alert-heading small fw-bold mb-1">Pendaftaran Gagal!</h4>
                            <ul class="mb-0 small ps-3">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    
                    
                    <form action="<?php echo e(route('register')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        
                        <h5 class="fs-6 fw-bold text-dark border-bottom pb-2 mb-3 mt-4">Data Wali Santri</h5>
                        
                        
                        <div class="mb-3">
                            <label for="name" class="form-label small fw-medium text-gray-700">Nama Lengkap Wali*</label>
                            <input type="text" id="name" name="name" placeholder="Nama lengkap Wali/Orang Tua"
                                class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                value="<?php echo e(old('name')); ?>" required autocomplete="name" autofocus>
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback small"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="mb-3">
                            <label for="email" class="form-label small fw-medium text-gray-700">Email*</label>
                            <input type="email" id="email" name="email" placeholder="Alamat email aktif (untuk login)"
                                class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                value="<?php echo e(old('email')); ?>" required autocomplete="email">
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback small"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <h5 class="fs-6 fw-bold text-dark border-bottom pb-2 mb-3 mt-4">Data Santri</h5>
                        
                        
                        <div class="mb-3">
                            <label for="nama_santri" class="form-label small fw-medium text-gray-700">Nama Lengkap Santri*</label>
                            <input type="text" id="nama_santri" name="nama_santri" placeholder="Nama lengkap calon santri"
                                class="form-control <?php $__errorArgs = ['nama_santri'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                value="<?php echo e(old('nama_santri')); ?>" required>
                            <?php $__errorArgs = ['nama_santri'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback small"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <div class="row">
                            
                            
                            <div class="col-md-6 mb-3">
                                <label for="nis" class="form-label small fw-medium text-gray-700">NISN (Opsional)</label>
                                <input type="text" id="nis" name="nis" placeholder="Nomor Induk Siswa Nasional (jika ada)"
                                    class="form-control <?php $__errorArgs = ['nis'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    value="<?php echo e(old('nis')); ?>">
                                <?php $__errorArgs = ['nis'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback small"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_lahir_santri" class="form-label small fw-medium text-gray-700">Tgl. Lahir Santri*</label>
                                <input type="date" id="tanggal_lahir_santri" name="tanggal_lahir_santri"
                                    class="form-control <?php $__errorArgs = ['tanggal_lahir_santri'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    value="<?php echo e(old('tanggal_lahir_santri')); ?>" required>
                                <?php $__errorArgs = ['tanggal_lahir_santri'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback small"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <h5 class="fs-6 fw-bold text-dark border-bottom pb-2 mb-3 mt-4">Buat Password Akun</h5>

                        
                        <div class="mb-3">
                            <label for="password" class="form-label small fw-medium text-gray-700">Password*</label>
                            <div class="password-input-container">
                                <input type="password" id="password" name="password" placeholder="Buat password Anda"
                                    class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    required autocomplete="new-password">
                                <span class="toggle-password" data-target="password">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback small d-block"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label small fw-medium text-gray-700">Konfirmasi Password*</label>
                            <div class="password-input-container">
                                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password Anda"
                                    class="form-control" required autocomplete="one-time-code">
                                <span class="toggle-password" data-target="password_confirmation">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>

                        <button type="submit" class="w-100 btn btn-lg btn-primary-custom fw-bold">
                            <i class="fas fa-user-plus me-2"></i> Daftarkan Akun Wali
                        </button>
                    </form>

                    <div class="mt-4 text-center">
                        <p class="small text-secondary">
                            Sudah punya akun?
                            <a href="<?php echo e(route('login')); ?>" class="fw-medium text-decoration-none" style="color: #2563EB;">Masuk</a>
                        </p>
                    </div>

                    <div class="mt-4 text-center">
                        <p class="small text-muted">Powered by <span class="fw-bold" style="color: #1E40AF;">SANTRI_LOCAL</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleButtons = document.querySelectorAll('.toggle-password');

            toggleButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const targetId = button.getAttribute('data-target');
                    const targetInput = document.getElementById(targetId);
                    const icon = button.querySelector('i');

                    // Toggle tipe input
                    const type = targetInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    targetInput.setAttribute('type', type);

                    // Toggle ikon mata
                    if (type === 'password') {
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    } else {
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    }
                });
            });
        });
    </script>
</body>
</html><?php /**PATH /home/u746452968/domains/sisfoalfalahputak.online/sisfo-laravel/resources/views/auth/register.blade.php ENDPATH**/ ?>