<?php $__env->startSection('title', 'Tambah Santri'); ?>
<?php $__env->startSection('page_title', 'Tambah Santri Baru'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    /* Styling Card Utama */
    .form-card {
        border-radius: 1rem !important; /* Sudut lebih membulat */
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05) !important; /* Bayangan halus */
    }
    
    /* Styling Card Section */
    .section-card {
        border: 1px solid var(--bs-gray-300);
        border-radius: 0.75rem;
        margin-bottom: 1.5rem;
    }

    /* Input Field Standardisasi */
    .form-label {
        font-weight: 600;
        font-size: 0.8rem;
        color: var(--bs-gray-700) !important; /* Label lebih gelap */
        margin-bottom: 0.3rem; /* Jarak label ke input */
        text-transform: uppercase;
    }
    .input-group-text {
        background-color: var(--bs-gray-100);
        color: var(--bs-primary);
    }
    .form-control, .form-select {
        border-color: var(--bs-gray-300);
        border-radius: 0.375rem;
        font-size: 0.9rem; /* Mengurangi ukuran font input/select */
    }

    /* Header Section yang Rapi */
    .section-title {
        background-color: var(--bs-light);
        padding: 0.75rem 1.5rem;
        border-bottom: 1px solid var(--bs-gray-300);
        font-size: 0.9rem;
        font-weight: 700;
        border-radius: 0.75rem 0.75rem 0 0;
    }

    /* ========================================= */
    /* PERBAIKAN KHUSUS MOBILE (max-width: 767.98px) */
    /* ========================================= */
    @media (max-width: 767.98px) {
        
        /* Card Utama */
        .card-header {
            padding: 1rem !important; /* Header card utama lebih kecil */
        }
        .card-body {
            padding: 1rem !important; /* Padding body card utama lebih kecil */
        }
        
        /* Section Card */
        .section-card {
            margin-bottom: 1rem; /* Jarak antar section lebih rapat */
        }
        .section-title {
            padding: 0.6rem 1rem; /* Padding header section lebih kecil */
            font-size: 0.85rem;
        }

        /* Card Body di dalam Section */
        .section-card .card-body {
            padding: 1rem !important; /* Padding body section lebih kecil */
        }

        /* Tombol Aksi */
        .btn {
            font-size: 0.8rem !important; /* Ukuran font tombol lebih kecil */
            padding: 0.5rem 1rem !important; /* Padding tombol lebih ramping */
            flex-grow: 1; /* Agar tombol membagi lebar secara merata */
        }
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            
            <h3 class="mb-4 text-dark fw-bold border-bottom pb-2 d-block d-md-none">Pendaftaran Santri Baru</h3> 

            <div class="card form-card border-0">
                
                
                <div class="card-header bg-white p-4 border-bottom rounded-top-4">
                    <h4 class="mb-0 fw-bold text-primary fs-5"><i class="fas fa-user-plus me-2"></i> Formulir Pendaftaran Santri Baru</h4>
                    <p class="text-muted small mb-0 mt-1">Pastikan semua kolom bertanda (<span class="text-danger">*</span>) telah terisi dengan benar.</p>
                </div>
                
                <div class="card-body p-3 p-md-5">
                    
                    
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm border-0 small mb-5" role="alert">
                            <h6 class="alert-heading fw-bold text-danger fs-6"><i class="fas fa-exclamation-circle me-2"></i> Ada Kesalahan Validasi!</h6>
                            <p class="small mb-2">Mohon periksa dan koreksi input Anda:</p>
                            <ul class="mb-0 ps-4 list-unstyled">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="small text-danger"><i class="fas fa-dot-circle fa-xs me-2"></i><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('admin.santri.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        
                        
                        
                        
                        <div class="section-card">
                            <div class="section-title text-primary"><i class="fas fa-id-card me-2"></i> Data Pribadi</div>
                            
                            <div class="card-body p-4 p-md-5">
                                <div class="row g-3 g-md-4">
                                    
                                    
                                    <div class="col-md-6 col-12">
                                        <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" name="nama_lengkap" id="nama_lengkap" 
                                                   class="form-control <?php $__errorArgs = ['nama_lengkap'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                   placeholder="Nama Lengkap Santri" value="<?php echo e(old('nama_lengkap')); ?>" required>
                                            <?php $__errorArgs = ['nama_lengkap'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-md-6 col-12">
                                        <label for="nisn" class="form-label">NISN <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-fingerprint"></i></span>
                                            <input type="text" name="nisn" id="nisn" 
                                                   class="form-control <?php $__errorArgs = ['nisn'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                   placeholder="Nomor Induk Santri Nasional" value="<?php echo e(old('nisn')); ?>" required>
                                            <?php $__errorArgs = ['nisn'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-md-6 col-12">
                                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-select <?php $__errorArgs = ['jenis_kelamin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                                <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                                                <option value="Laki-laki" <?php echo e(old('jenis_kelamin') == 'Laki-laki' ? 'selected' : ''); ?>>Laki-laki</option>
                                                <option value="Perempuan" <?php echo e(old('jenis_kelamin') == 'Perempuan' ? 'selected' : ''); ?>>Perempuan</option>
                                            </select>
                                            <?php $__errorArgs = ['jenis_kelamin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-md-6 col-12">
                                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" 
                                                   class="form-control <?php $__errorArgs = ['tanggal_lahir'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                   value="<?php echo e(old('tanggal_lahir')); ?>" required>
                                            <?php $__errorArgs = ['tanggal_lahir'];
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
                            </div> 
                        </div> 

                        
                        
                        
                        
                        <div class="section-card">
                            <div class="section-title text-warning"><i class="fas fa-graduation-cap me-2"></i> Data Akademik & Wali</div>
                            
                            <div class="card-body p-4 p-md-5">
                                <div class="row g-3 g-md-4">
                                    
                                    
                                    <div class="col-md-6 col-12">
                                        <label for="kelas_id" class="form-label">Kelas <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-school"></i></span>
                                            <select name="kelas_id" id="kelas_id" class="form-select <?php $__errorArgs = ['kelas_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                                <option value="" disabled selected>-- Pilih Kelas --</option>
                                                <?php $__currentLoopData = $kelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($k->id); ?>" <?php echo e(old('kelas_id') == $k->id ? 'selected' : ''); ?>>
                                                        <?php echo e($k->nama_kelas); ?> (Tingkat <?php echo e($k->tingkat); ?>)
                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <?php $__errorArgs = ['kelas_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-md-6 col-12">
                                        <label for="wali_santri_id" class="form-label">Wali Santri <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                            <select name="wali_santri_id" id="wali_santri_id" class="form-select <?php $__errorArgs = ['wali_santri_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                                <option value="" disabled selected>-- Pilih Wali Santri --</option>
                                                <?php $__currentLoopData = $waliSantri; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wali): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                                    <option value="<?php echo e($wali->id); ?>" <?php echo e(old('wali_santri_id') == $wali->id ? 'selected' : ''); ?>>
                                                        <?php echo e($wali->name); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <?php $__errorArgs = ['wali_santri_id'];
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
                            </div> 
                        </div> 
                        

                        
                        
                        
                        <div class="section-card">
                            <div class="section-title text-success"><i class="fas fa-map-marker-alt me-2"></i> Alamat & Status</div>
                            
                            <div class="card-body p-4 p-md-5">
                                <div class="row g-3 g-md-4">
                                    
                                    
                                    <div class="col-md-8 col-12">
                                        <label for="alamat" class="form-label">Alamat Lengkap</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-home"></i></span>
                                            <textarea name="alamat" id="alamat" class="form-control <?php $__errorArgs = ['alamat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                    placeholder="Alamat Lengkap Domisili Santri" rows="3"><?php echo e(old('alamat')); ?></textarea>
                                            <?php $__errorArgs = ['alamat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-md-4 col-12">
                                        <label for="status" class="form-label">Status Keaktifan <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
                                            <select name="status" id="status" class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                                <option value="Aktif" <?php echo e(old('status', 'Aktif') == 'Aktif' ? 'selected' : ''); ?>>Aktif</option>
                                                <option value="Non-aktif" <?php echo e(old('status') == 'Non-aktif' ? 'selected' : ''); ?>>Non-aktif</option>
                                                <option value="Lulus" <?php echo e(old('status') == 'Lulus' ? 'selected' : ''); ?>>Lulus</option>
                                            </select>
                                            <?php $__errorArgs = ['status'];
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
                            </div> 
                        </div> 
                        
                        
                        
                        <div class="d-flex flex-row justify-content-end gap-2 pt-3">
                            <a href="<?php echo e(route('admin.santri.index')); ?>" class="btn btn-outline-secondary shadow-sm fw-semibold rounded-pill">
                                <i class="fas fa-times me-2 d-none d-sm-inline"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary shadow-lg fw-bold rounded-pill">
                                <i class="fas fa-save me-2 d-none d-sm-inline"></i> Simpan Santri
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/admin/master/santri/create.blade.php ENDPATH**/ ?>