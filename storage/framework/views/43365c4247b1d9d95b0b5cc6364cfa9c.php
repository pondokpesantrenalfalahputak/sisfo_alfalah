<?php $__env->startSection('title', 'Edit Santri'); ?>
<?php $__env->startSection('page_title', 'Edit Data Santri' ); ?>

<?php $__env->startSection('styles'); ?>
<style>
    /* 1. KONTROL UTAMA & CARD */
    .card-master {
        border-radius: 0.75rem !important;
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1) !important;
        border: none !important;
    }
    .header-primary {
        background-color: var(--bs-primary);
        color: #fff;
        padding: 1.5rem;
        border-radius: 0.75rem 0.75rem 0 0;
    }

    /* 2. PENYESUAIAN FONT DAN UKURAN INPUT */
    .form-label.small {
        font-size: 0.75rem; 
        font-weight: 600 !important;
        margin-bottom: 0.2rem;
    }
    .input-group-text {
        font-size: 0.85rem;
    }
    .form-control, .form-select {
        font-size: 0.9rem;
    }
    .invalid-feedback {
        font-size: 0.75rem;
    }
    .alert-heading {
        font-size: 1rem !important;
    }
    .alert-danger .small {
        font-size: 0.75rem !important;
    }
    
    /* 3. MOBILE ADJUSTMENTS (DIPERKETAT) */
    @media (max-width: 767.98px) {
        .card-body {
            padding: 1rem !important;
        }
        .header-primary {
            padding: 1rem;
        }
        .header-primary h4 {
            font-size: 1.2rem !important;
        }
        .header-primary p.small {
            font-size: 0.7rem !important;
        }

        /* Judul Section diperkecil */
        h6.fs-6 {
            font-size: 0.9rem !important;
            margin-top: 1rem !important;
        }

        /* Spasi antar elemen form dikurangi */
        .row.g-4 {
            --bs-gutter-x: 0.75rem;
            --bs-gutter-y: 1rem; 
        }
        
        /* Input dan Label diperkecil lebih lanjut */
        .form-label.small {
            font-size: 0.65rem;
        }
        .input-group-text, .form-control, .form-select {
            font-size: 0.8rem;
            padding: 0.5rem 0.75rem;
        }

        /* Textarea Alamat */
        textarea {
            height: 80px !important;
        }

        /* Tombol Aksi Mobile (FOKUS PERBAIKAN DI SINI) */
        .card-footer {
            padding: 1rem !important;
        }
        .d-flex.justify-content-end {
            flex-direction: column; 
        }
        /* Kelas kustom untuk tombol mobile yang kecil */
        .btn.btn-sm-custom {
            padding: 0.4rem 1rem !important; /* Padding minimal */
            font-size: 0.75rem; /* Font tombol sangat kecil */
            width: 100% !important;
            margin-top: 0.5rem;
        }
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('header_actions'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-master shadow-lg rounded-3"> 
                
                
                <div class="card-header bg-primary text-white rounded-top-4 header-primary">
                    <h4 class="mb-0 fw-bold fs-5"><i class="fas fa-user-edit me-2"></i> Formulir Edit Data Santri</h4>
                    <p class="text-white-50 small mb-0">Lakukan perubahan data untuk santri <?php echo e($santri->nama_lengkap); ?> dengan hati-hati.</p>
                </div>
                
                <div class="card-body p-4 p-md-5">

                    
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm border-0" role="alert">
                            <h6 class="alert-heading fw-bold text-danger"><i class="fas fa-exclamation-circle me-2"></i> Ada Kesalahan Validasi!</h6>
                            <p class="small mb-2">Mohon periksa dan koreksi input Anda:</p>
                            <ul class="mb-0 ps-4 list-unstyled">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="small text-danger"><i class="fas fa-dot-circle fa-xs me-2"></i><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    
                    <form action="<?php echo e(route('admin.santri.update', $santri)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        
                        
                        <h6 class="fw-bold text-dark mb-1 mt-2 text-warning fs-6"><i class="fas fa-id-card me-2"></i> Data Pribadi</h6>
                        <hr class="mt-2 mb-4 border-warning opacity-25">
                        
                        <div class="row g-4">
                            
                            
                            <div class="col-md-6">
                                <label for="nama_lengkap" class="form-label fw-medium text-muted small">Nama Lengkap <span class="text-danger">*</span></label>
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
                                           placeholder="Nama Lengkap Santri" value="<?php echo e(old('nama_lengkap', $santri->nama_lengkap)); ?>" required>
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
                            
                            
                            <div class="col-md-6">
                                <label for="nisn" class="form-label fw-medium text-muted small">NIS <span class="text-danger">*</span></label>
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
                                           placeholder="Nomor Induk Siswa Nasional" value="<?php echo e(old('nisn', $santri->nisn)); ?>" required>
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
                            
                            
                            <div class="col-md-6">
                                <label for="jenis_kelamin" class="form-label fw-medium text-muted small">Jenis Kelamin <span class="text-danger">*</span></label>
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
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="Laki-laki" <?php echo e(old('jenis_kelamin', $santri->jenis_kelamin) == 'Laki-laki' ? 'selected' : ''); ?>>Laki-laki</option>
                                        <option value="Perempuan" <?php echo e(old('jenis_kelamin', $santri->jenis_kelamin) == 'Perempuan' ? 'selected' : ''); ?>>Perempuan</option>
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
                            
                            
                            <div class="col-md-6">
                                <label for="tanggal_lahir" class="form-label fw-medium text-muted small">Tanggal Lahir <span class="text-danger">*</span></label>
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
                                           value="<?php echo e(old('tanggal_lahir', $santri->tanggal_lahir ? $santri->tanggal_lahir->format('Y-m-d') : '')); ?>" required>
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
                        
                        <hr class="mt-5 mb-4 border-secondary opacity-25"> 
                        
                        
                        <h6 class="fw-bold text-dark mb-1 mt-2 text-info fs-6"><i class="fas fa-graduation-cap me-2"></i> Data Akademik & Wali</h6>
                        <hr class="mt-2 mb-4 border-info opacity-25">
                        <div class="row g-4">
                            
                            
                            <div class="col-md-6">
                                <label for="kelas_id" class="form-label fw-medium text-muted small">Kelas <span class="text-danger">*</span></label>
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
                                        <option value="">-- Pilih Kelas --</option>
                                        <?php $__currentLoopData = $kelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($k->id); ?>" <?php echo e(old('kelas_id', $santri->kelas_id) == $k->id ? 'selected' : ''); ?>>
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
                            
                            
                            <div class="col-md-6">
                                <label for="wali_santri_id" class="form-label fw-medium text-muted small">Wali Santri <span class="text-danger">*</span></label>
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
                                        <option value="">-- Pilih Wali Santri --</option>
                                        <?php $__currentLoopData = $walis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wali): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($wali->id); ?>" <?php echo e(old('wali_santri_id', $santri->wali_santri_id) == $wali->id ? 'selected' : ''); ?>>
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
                        
                        <hr class="mt-5 mb-4 border-secondary opacity-25">

                        
                        <h6 class="fw-bold text-dark mb-1 mt-2 text-success fs-6"><i class="fas fa-map-marker-alt me-2"></i> Alamat & Status</h6>
                        <hr class="mt-2 mb-4 border-success opacity-25">
                        <div class="row g-4">
                            
                            
                            <div class="col-md-8">
                                <label for="alamat" class="form-label fw-medium text-muted small">Alamat Lengkap</label>
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
                                            placeholder="Alamat Lengkap Domisili Santri" rows="3"><?php echo e(old('alamat', $santri->alamat)); ?></textarea>
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
                            
                            
                            <div class="col-md-4">
                                <label for="status" class="form-label fw-medium text-muted small">Status Keaktifan <span class="text-danger">*</span></label>
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
                                        <option value="Aktif" <?php echo e(old('status', $santri->status) == 'Aktif' ? 'selected' : ''); ?>>Aktif</option>
                                        <option value="Tidak Aktif" <?php echo e(old('status', $santri->status) == 'Tidak Aktif' ? 'selected' : ''); ?>>Tidak Aktif</option>
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
                        
                        <hr class="mt-5 mb-4 border-dark opacity-10">
                        
                        
                        <div class="d-flex justify-content-end gap-2 pt-3">
                            <a href="<?php echo e(route('admin.santri.index')); ?>" class="btn btn-outline-secondary shadow-sm fw-semibold rounded-pill w-100 w-md-auto btn-sm-custom">
                                <i class="fas fa-times me-2"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-warning shadow-lg fw-bold text-dark rounded-pill w-100 w-md-auto btn-sm-custom">
                                <i class="fas fa-redo me-2"></i> Update Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/admin/master/santri/edit.blade.php ENDPATH**/ ?>