<?php $__env->startSection('title', 'Buat Tagihan Baru'); ?>
<?php $__env->startSection('page_title', 'Formulir Tagihan Baru'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* === MOBILE OPTIMIZATION (Max 767.98px) - DIPERBAIKI === */
    @media (max-width: 767.98px) {
        /* Mengurangi ukuran font judul dan header di mobile */
        h2 { font-size: 1.4rem !important; } /* Sedikit lebih kecil */
        .card-header h4 { font-size: 1.0rem !important; }
        
        /* Mengurangi ukuran font label */
        .form-label { font-size: 0.8rem !important; } /* Dibuat lebih kecil */
        
        /* Override input-group-lg ke ukuran SANGAT RINGKAS di mobile */
        .input-group-lg .form-control, 
        .input-group-lg .form-select,
        .input-group-lg .input-group-text,
        .input-group-lg textarea {
            padding: 0.4rem 0.75rem !important; /* Padding vertikal dikurangi */
            font-size: 0.8rem !important; /* Font dikurangi agar lebih ringkas */
        }
        
        /* Ukuran Font Pesan Bantuan */
        .small, small { font-size: 0.7rem !important; } /* Dibuat lebih kecil */
        
        /* Menyesuaikan padding dan font tombol aksi agar ringkas */
        .btn {
            font-size: 0.8rem !important; 
            padding: 0.4rem 1rem !important; /* Padding tombol dikurangi */
        }
        
        /* Menyesuaikan estetika card */
        .card {
             border-left: none !important;
             border-bottom: 5px solid var(--bs-primary) !important;
        }
        .card-header {
             padding: 0.5rem 1rem !important; /* Padding header card dikurangi */
             border-radius: 0.75rem 0.75rem 0 0 !important;
        }

        /* Memastikan gap antar elemen formulir tetap baik */
        .g-4 {
            --bs-gutter-x: 1.5rem;
            --bs-gutter-y: 1rem; /* Gap vertikal sedikit dikurangi juga */
        }
    }
    
    /* Global Card Style Improvement (Optional) */
    .card {
        border-radius: 0.75rem !important;
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08) !important;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <div class="card shadow-lg border-0 rounded-4 border-start border-2 border-primary">
                
                
                <div class="card-header bg-primary text-white p-3 rounded-top-4">
                    <h4 class="mb-0 fw-bold fs-5"><i class="fas fa-plus-circle me-2"></i> Isi Detail Tagihan</h4>
                    <p class="text-white-50 small mb-0 d-none d-sm-block">Lengkapi formulir di bawah untuk membuat tagihan pembayaran baru.</p>
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
                    
                    
                    <form action="<?php echo e(route('admin.tagihan.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        
                        
                        <div class="row g-3">
                            
                            
                            <div class="col-md-6">
                                
                                
                                <div>
                                    <label for="santri_id" class="form-label fw-semibold">Pilih Santri Penerima <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-lg"> 
                                        <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
                                        <select name="santri_id" id="santri_id" class="form-select <?php $__errorArgs = ['santri_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> select2-enabled" required>
                                            <option value="">-- Pilih Santri --</option>
                                            <?php $__currentLoopData = $santris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $santri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($santri->id); ?>" 
                                                    <?php echo e(old('santri_id') == $santri->id ? 'selected' : ''); ?>>
                                                    <?php echo e($santri->nama_lengkap ?? $santri->nama); ?> (Kelas: <?php echo e($santri->kelas->nama_kelas ?? 'N/A'); ?>)
                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php $__errorArgs = ['santri_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                
                                
                                <div class="mt-4">
                                    <label for="jenis_tagihan" class="form-label fw-semibold">Jenis Tagihan <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text"><i class="fas fa-file-invoice"></i></span>
                                        <select name="jenis_tagihan" id="jenis_tagihan" class="form-select <?php $__errorArgs = ['jenis_tagihan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                            <option value="">-- Pilih Jenis --</option>
                                            <?php $__currentLoopData = $jenisTagihan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jenis): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($jenis); ?>" 
                                                    <?php echo e(old('jenis_tagihan') == $jenis ? 'selected' : ''); ?>>
                                                    <?php echo e($jenis); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php $__errorArgs = ['jenis_tagihan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                
                                <div class="mt-4">
                                    <label for="jumlah_tagihan" class="form-label fw-semibold">Nominal Tagihan (Rp) <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" name="jumlah_tagihan" id="jumlah_tagihan" class="form-control <?php $__errorArgs = ['jumlah_tagihan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                            placeholder="Contoh: 550000"
                                            value="<?php echo e(old('jumlah_tagihan')); ?>" required min="0" step="1000">
                                        <?php $__errorArgs = ['jumlah_tagihan'];
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
                                
                                
                                <div>
                                    <label for="tanggal_tagihan_info" class="form-label fw-semibold">Tanggal Dibuat</label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                                        <input type="text" id="tanggal_tagihan_info" class="form-control bg-light" 
                                                value="<?php echo e(\Carbon\Carbon::now()->translatedFormat('d F Y')); ?>" readonly>
                                    </div>
                                    <small class="text-info fst-italic">Tanggal tagihan akan otomatis dicatat hari ini.</small>
                                </div>

                                
                                <div class="mt-4">
                                    <label for="tanggal_jatuh_tempo" class="form-label fw-semibold">Tanggal Jatuh Tempo <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        <input type="date" name="tanggal_jatuh_tempo" id="tanggal_jatuh_tempo" class="form-control <?php $__errorArgs = ['tanggal_jatuh_tempo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                            value="<?php echo e(old('tanggal_jatuh_tempo', \Carbon\Carbon::now()->addDays(7)->format('Y-m-d'))); ?>" required>
                                    </div>
                                    <?php $__errorArgs = ['tanggal_jatuh_tempo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                
                                <div class="mt-4">
                                    <label for="keterangan" class="form-label fw-semibold">Keterangan (Opsional)</label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text align-items-start pt-3 pb-3"><i class="fas fa-comment-dots"></i></span>
                                        <textarea name="keterangan" id="keterangan" class="form-control <?php $__errorArgs = ['keterangan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                    placeholder="Contoh: SPP Bulan Januari 2026" 
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
                        </div> 
                        
                        <hr class="mt-5 mb-4 border-dark opacity-25">
                        
                        
                        <div class="d-flex justify-content-end gap-2 flex-wrap">
                            <button type="submit" class="btn btn-primary px-4 shadow-sm fw-semibold rounded-pill">
                                <i class="fas fa-save me-2"></i> Simpan Tagihan
                            </button>
                            <a href="<?php echo e(route('admin.tagihan.index')); ?>" class="btn btn-outline-secondary px-4 shadow-sm fw-semibold rounded-pill">
                                <i class="fas fa-times me-2"></i> Batal
                            </a>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>


<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/admin/tagihan/create.blade.php ENDPATH**/ ?>