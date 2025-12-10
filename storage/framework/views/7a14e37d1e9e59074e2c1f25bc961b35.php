<?php $__env->startSection('title', 'Edit Tagihan'); ?>
<?php $__env->startSection('page_title', 'Edit Data Tagihan Pembayaran'); ?>

<?php $__env->startSection('header_actions'); ?>
    
    <a href="<?php echo e(route('admin.tagihan.index')); ?>" class="btn btn-outline-secondary shadow-sm rounded-pill d-flex align-items-center fw-semibold px-3">
        <i class="fas fa-list-alt me-2"></i>
        Daftar Tagihan
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">


            <div class="card shadow-lg border-0 rounded-4 border-start border-5 border-warning">
                
                
                <div class="card-header bg-primary text-white p-4 rounded-top-4">
                    <h4 class="mb-0 fw-bold fs-5"><i class="fas fa-edit me-2"></i> Edit Tagihan: <?php echo e($tagihan->jenis_tagihan); ?></h4>
                    <p class="text-white-50 small mb-0">Perbarui detail tagihan untuk santri <?php echo e($tagihan->santri->nama_lengkap ?? 'N/A'); ?>.</p>
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
                    
                    
                    <form action="<?php echo e(route('admin.tagihan.update', $tagihan)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        
                        <div class="row g-4">
                            
                            
                            <div class="col-md-6">
                                <label for="santri_id" class="form-label fw-semibold">Pilih Santri <span class="text-danger">*</span></label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
                                    <select name="santri_id" id="santri_id" 
                                            class="form-select <?php $__errorArgs = ['santri_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                        <option value="">-- Pilih Santri --</option>
                                        
                                        <?php $__currentLoopData = $santris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $santri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($santri->id); ?>" 
                                                    <?php echo e(old('santri_id', $tagihan->santri_id) == $santri->id ? 'selected' : ''); ?>>
                                                <?php echo e($santri->nama_lengkap); ?> (Kelas: <?php echo e($santri->kelas->nama_kelas ?? 'N/A'); ?>)
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
                            
                            
                            <div class="col-md-6">
                                <label for="jenis_tagihan" class="form-label fw-semibold">Jenis Tagihan <span class="text-danger">*</span></label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text"><i class="fas fa-file-invoice"></i></span>
                                    <select name="jenis_tagihan" id="jenis_tagihan" 
                                            class="form-select <?php $__errorArgs = ['jenis_tagihan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                        <option value="">-- Pilih Jenis Tagihan --</option>
                                        
                                        <?php $__currentLoopData = $jenisTagihan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jenis): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($jenis); ?>" 
                                                    <?php echo e(old('jenis_tagihan', $tagihan->jenis_tagihan) == $jenis ? 'selected' : ''); ?>>
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

                            
                            <div class="col-md-6">
                                <label for="jumlah_tagihan" class="form-label fw-semibold">Jumlah Tagihan (Rp) <span class="text-danger">*</span></label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="jumlah_tagihan" id="jumlah_tagihan" 
                                           class="form-control <?php $__errorArgs = ['jumlah_tagihan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           placeholder="Contoh: 550000" 
                                           value="<?php echo e(old('jumlah_tagihan', $tagihan->jumlah_tagihan)); ?>" 
                                           required min="0" step="1000">
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
                            
                            
                            <div class="col-md-6">
                                <label for="tanggal_jatuh_tempo" class="form-label fw-semibold">Tanggal Jatuh Tempo <span class="text-danger">*</span></label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    <input type="date" name="tanggal_jatuh_tempo" id="tanggal_jatuh_tempo" 
                                           class="form-control <?php $__errorArgs = ['tanggal_jatuh_tempo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           value="<?php echo e(old('tanggal_jatuh_tempo', \Carbon\Carbon::parse($tagihan->tanggal_jatuh_tempo)->format('Y-m-d'))); ?>" 
                                           required>
                                    <?php $__errorArgs = ['tanggal_jatuh_tempo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            
                            
                            
                            <input type="hidden" name="tanggal_tagihan" value="<?php echo e($tagihan->tanggal_tagihan); ?>">

                            
                            <div class="col-md-6">
                                <label for="status" class="form-label fw-semibold">Status Pembayaran <span class="text-danger">*</span></label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text"><i class="fas fa-check-double"></i></span>
                                    <select name="status" id="status" 
                                            class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                        <option value="Belum Lunas" <?php echo e(old('status', $tagihan->status) == 'Belum Lunas' ? 'selected' : ''); ?>>Belum Lunas</option>
                                        <option value="Lunas" <?php echo e(old('status', $tagihan->status) == 'Lunas' ? 'selected' : ''); ?>>Lunas</option>
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

                            
                            <div class="col-md-12">
                                <label for="keterangan" class="form-label fw-semibold">Keterangan (Opsional)</label>
                                <div class="input-group input-group-lg">
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
                                              placeholder="Contoh: Pembayaran SPP bulan lalu yang belum dibayar" 
                                              rows="3"><?php echo e(old('keterangan', $tagihan->keterangan)); ?></textarea>
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
                        
                        
                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?php echo e(route('admin.tagihan.index')); ?>" class="btn btn-outline-secondary px-4 shadow-sm fw-semibold rounded-pill">
                                <i class="fas fa-times me-2"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-warning px-4 shadow-lg fw-bold text-dark rounded-pill">
                                <i class="fas fa-save me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/admin/tagihan/edit.blade.php ENDPATH**/ ?>