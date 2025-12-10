<?php $__env->startSection('title', 'Edit Data Guru'); ?>
<?php $__env->startSection('page_title', 'Edit Data Guru' ); ?>

<?php $__env->startSection('styles'); ?>
<style>
    /* Global Card Style Consistency */
    .card-master {
        border-radius: 0.75rem !important;
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1) !important;
        border: none !important;
    }
    /* Style untuk form-label agar seragam */
    .form-label {
        margin-bottom: 0.3rem;
        font-size: 0.9rem;
    }

    /* ------------------------------------------- */
    /* MOBILE ADJUSTMENTS (FOKUS TOMBOL AKSI) */
    /* ------------------------------------------- */
    @media (max-width: 767.98px) {
        .card-body {
            padding: 1rem !important;
        }
        
        /* Heading Section mobile */
        h6.text-warning {
            font-size: 0.95rem !important;
            margin-top: 1.5rem !important;
            margin-bottom: 0.75rem !important;
        }

        /* Input Group lebih kecil di mobile */
        .input-group-text {
            padding: 0.4rem 0.75rem !important;
        }
        .form-control {
            padding: 0.4rem 0.75rem !important;
        }
        
        /* Tombol Aksi Footer Mobile (DIBUAT SEJAJAR DAN SANGAT KECIL) */
        .card-body .action-buttons {
            justify-content: space-between !important; /* Agar merata */
            gap: 0.5rem !important;
        }
        .card-body .action-buttons .btn {
            width: auto !important; /* Biarkan lebar mengikuti konten */
            font-size: 0.75rem !important; /* Font tombol sangat kecil */
            padding: 0.3rem 0.6rem !important; /* Padding sangat minimal */
            border-radius: 50rem !important; /* Pastikan tetap kapsul */
        }
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            
            <h5 class="mb-4 text-dark fw-bold d-none d-md-block">✏️ Edit Data Guru</h5>

            <div class="card card-master shadow-lg border-0 rounded-4">
                
                
                <div class="card-header bg-warning text-dark p-3 rounded-top-4">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-edit me-2"></i> Formulir Edit Data Guru</h5>
                    <p class="text-secondary small mb-0">Lakukan perubahan pada data guru **<?php echo e($guru->nama_lengkap); ?>** di formulir di bawah ini.</p>
                </div>
                
                <div class="card-body p-4">
                    
                    
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                            <h6 class="alert-heading fw-bold"><i class="fas fa-exclamation-triangle me-2"></i> Mohon koreksi kesalahan berikut:</h6>
                            <ul class="mb-0 ps-3 small">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('admin.guru.update', $guru)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        
                        
                        <h6 class="fw-bold text-dark mb-4 mt-2 border-bottom pb-2 text-primary"><i class="fas fa-id-card me-2"></i> Informasi Identitas</h6>
                        
                        <div class="row g-3">
                            
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama_lengkap" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-light text-primary"><i class="fas fa-user"></i></span>
                                        <input type="text" name="nama_lengkap" id="nama_lengkap" 
                                               class="form-control <?php $__errorArgs = ['nama_lengkap'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               placeholder="Nama Lengkap Guru" value="<?php echo e(old('nama_lengkap', $guru->nama_lengkap)); ?>" required>
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
                            </div>
                            
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nuptk" class="form-label fw-semibold">NUPTK <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-light text-primary"><i class="fas fa-fingerprint"></i></span>
                                        <input type="text" name="nuptk" id="nuptk" 
                                               class="form-control <?php $__errorArgs = ['nuptk'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               placeholder="Nomor Unik Pendidik" value="<?php echo e(old('nuptk', $guru->nuptk)); ?>" required>
                                        <?php $__errorArgs = ['nuptk'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <small class="text-muted d-block mt-1">Nomor Unik Pendidik dan Tenaga Kependidikan.</small>
                                </div>
                            </div>
                        </div>

                        
                        <h6 class="fw-bold text-dark mb-4 mt-4 border-bottom pb-2 text-success"><i class="fas fa-briefcase me-2"></i> Detail Tugas & Kontak</h6>
                        
                        <div class="row g-3">
                            
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="jabatan" class="form-label fw-semibold">Jabatan <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-light text-success"><i class="fas fa-graduation-cap"></i></span>
                                        <input type="text" name="jabatan" id="jabatan" 
                                               class="form-control <?php $__errorArgs = ['jabatan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               placeholder="Contoh: Guru Kelas, Kepala Sekolah" value="<?php echo e(old('jabatan', $guru->jabatan)); ?>" required>
                                        <?php $__errorArgs = ['jabatan'];
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
                            
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="no_hp" class="form-label fw-semibold">Nomor HP <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-light text-success"><i class="fas fa-phone"></i></span>
                                        <input type="text" name="no_hp" id="no_hp" 
                                               class="form-control <?php $__errorArgs = ['no_hp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               placeholder="Contoh: 08123456789" value="<?php echo e(old('no_hp', $guru->no_hp)); ?>" required>
                                        <?php $__errorArgs = ['no_hp'];
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
                        
                        <hr class="mt-4 mb-4 border-secondary opacity-25">

                        
                        <div class="d-flex justify-content-end gap-3 pt-2 action-buttons">
                            
                            
                            <a href="<?php echo e(route('admin.guru.index')); ?>" class="btn btn-outline-secondary btn-sm shadow-sm fw-semibold rounded-pill">
                                <i class="fas fa-arrow-left me-2"></i> Kembali
                            </a>

                            
                            <button type="submit" class="btn btn-warning btn-sm shadow-lg fw-bold text-dark rounded-pill">
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
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/admin/master/guru/edit.blade.php ENDPATH**/ ?>