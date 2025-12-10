<?php $__env->startSection('page_title', 'Input Absensi ' . $kelas_nama . ' - ' . $kegiatan_spesifik); ?>

<?php use Carbon\Carbon; ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            
            <div class="card shadow mb-4 border-start border-primary border-1 rounded-4"> 
                
                
                <div class="card-header bg-primary text-white d-flex flex-column flex-md-row justify-content-between align-items-md-center p-3 rounded-top-4">
                    <div>
                        <h5 class="m-0 font-weight-bold fs-5">
                            Absensi <?php echo e($kegiatan_spesifik); ?> | Kelas <?php echo e($kelas_nama); ?>

                        </h5>
                    </div>
                    <span class="badge bg-light text-dark shadow-sm rounded-pill px-3 py-1 mt-2 mt-md-0 fw-semibold">
                        <i class="fas fa-calendar-alt me-1"></i> Tanggal: <?php echo e($date); ?>

                    </span>
                </div>
                
                <div class="card-body p-4 pt-3">
                    <p class="text-muted small border-bottom pb-2 mb-3 fw-semibold"><i class="fas fa-info-circle me-1 text-primary"></i> Pilih/tap nama santri untuk input kehadiran (H/S/I/A).</p>

                    
                    <form action="<?php echo e(route('admin.absensi_baru.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        
                        
                        <input type="hidden" name="kelas_id" value="<?php echo e($kelas_id); ?>">
                        <input type="hidden" name="kegiatan_spesifik" value="<?php echo e($kegiatan_spesifik); ?>">
                        <input type="hidden" name="tanggal_absensi" value="<?php echo e(Carbon::now()->toDateString()); ?>">

                        
                        <div class="table-responsive d-none d-md-block"> 
                            <table class="table table-bordered table-sm table-striped" id="absensiTable" width="100%" cellspacing="0">
                                <thead class="text-center"> 
                                    <tr class="bg-primary text-white">
                                        <th rowspan="2" class="align-middle border-primary" style="width: 3%;">#</th>
                                        <th rowspan="2" class="align-middle text-start border-primary" style="min-width: 180px;">Nama Santri (NIS)</th>
                                        <th colspan="4" class="align-middle fw-bold border-primary">Pilih Status Kehadiran</th>
                                        <th rowspan="2" class="align-middle border-primary" style="min-width: 200px;">Keterangan (Opsional)</th>
                                    </tr>
                                    <tr class="fw-normal bg-light text-dark">
                                        <th style="width: 10%;">Hadir (H)</th>
                                        <th style="width: 10%;">Sakit (S)</th>
                                        <th style="width: 10%;">Izin (I)</th>
                                        <th style="width: 10%;">Alfa (A)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $santri; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php $defaultKehadiran = 'Hadir'; ?>
                                    <tr class="align-middle">
                                        <td class="text-center small"><?php echo e($index + 1); ?></td>
                                        <td class="fw-semibold small">
                                            <?php echo e($s->nama_lengkap); ?>

                                            <div class="text-muted fw-normal text-xs">NIS: <?php echo e($s->nisn ?? '-'); ?></div>
                                        </td>
                                        
                                        <?php $__currentLoopData = ['Hadir', 'Sakit', 'Izin', 'Alfa']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <td class="text-center">
                                                <?php
                                                    $statusClass = 'btn-outline-secondary'; 
                                                    $statusLabel = match ($status) {
                                                        'Hadir' => 'H',
                                                        'Sakit' => 'S',
                                                        'Izin' => 'I',
                                                        'Alfa' => 'A', 
                                                    };
                                                ?>
                                                <input type="radio" class="btn-check" 
                                                       name="kehadiran[<?php echo e($s->id); ?>]" 
                                                       id="desktop-<?php echo e($s->id); ?>-<?php echo e($status); ?>" 
                                                       value="<?php echo e($status); ?>" 
                                                       <?php echo e(($status == 'Hadir') ? 'checked' : ''); ?> 
                                                       required>
                                                <label class="btn btn-sm <?php echo e($statusClass); ?> btn-toggle-status fw-bold" 
                                                       for="desktop-<?php echo e($s->id); ?>-<?php echo e($status); ?>" 
                                                       title="<?php echo e($status); ?>">
                                                       <?php echo e($statusLabel); ?>

                                                </label>
                                            </td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        
                                        <td>
                                            <input type="text" class="form-control form-control-sm small" 
                                                   name="keterangan[<?php echo e($s->id); ?>]" 
                                                   placeholder="Wajib diisi jika S/I/A..." maxlength="100">
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr><td colspan="7" class="text-center py-4 bg-light small"><i class="fas fa-exclamation-triangle me-2 text-warning"></i> Tidak ada data santri untuk kelas ini.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        
                        <div class="d-md-none">
                            <div class="accordion accordion-flush" id="accordionSantri">
                                <?php $__empty_1 = true; $__currentLoopData = $santri; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php $defaultKehadiran = 'Hadir'; ?>
                                    <div class="accordion-item shadow-sm mb-2 rounded-3 border">
                                        
                                        
                                        <h2 class="accordion-header" id="heading<?php echo e($s->id); ?>">
                                            <button class="accordion-button collapsed py-2 fw-bold text-xs-mobile" 
                                                    type="button" 
                                                    data-bs-toggle="collapse" 
                                                    data-bs-target="#collapse<?php echo e($s->id); ?>" 
                                                    aria-expanded="false" 
                                                    aria-controls="collapse<?php echo e($s->id); ?>">
                                                
                                                <span class="me-2 text-primary-dark"><?php echo e($index + 1); ?>.</span>
                                                <span class="text-dark me-auto"><?php echo e($s->nama_lengkap); ?></span>
                                                
                                                
                                                <span class="badge rounded-pill status-badge text-xs" id="status-badge-<?php echo e($s->id); ?>">
                                                    <?php echo e(($defaultKehadiran == 'Hadir') ? 'H' : '?'); ?>

                                                </span>
                                            </button>
                                        </h2>

                                        
                                        <div id="collapse<?php echo e($s->id); ?>" class="accordion-collapse collapse" aria-labelledby="heading<?php echo e($s->id); ?>" data-bs-parent="#accordionSantri">
                                            <div class="accordion-body p-3 pt-0">
                                                <hr class="mt-0 mb-3 border-secondary opacity-50">
                                                
                                                
                                                <div class="mb-3">
                                                    <p class="mb-2 small fw-semibold text-primary"><i class="fas fa-bullseye me-1"></i> Status Kehadiran:</p>
                                                    
                                                    <div class="btn-group w-100" role="group" data-santri-id="<?php echo e($s->id); ?>">
                                                        <?php $__currentLoopData = ['Hadir', 'Sakit', 'Izin', 'Alfa']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php
                                                                $statusShort = match ($status) {
                                                                    'Hadir' => 'H', 'Sakit' => 'S', 'Izin' => 'I', 'Alfa' => 'A',
                                                                };
                                                            ?>
                                                            <input type="radio" class="btn-check mobile-status-radio" 
                                                                   name="kehadiran[<?php echo e($s->id); ?>]" 
                                                                   id="mobile-<?php echo e($s->id); ?>-<?php echo e($status); ?>" 
                                                                   value="<?php echo e($status); ?>" 
                                                                   data-short="<?php echo e($statusShort); ?>"
                                                                   <?php echo e(($status == $defaultKehadiran) ? 'checked' : ''); ?> 
                                                                   required>
                                                            <label class="btn btn-outline-secondary flex-fill btn-status-mobile fw-bold" 
                                                                   for="mobile-<?php echo e($s->id); ?>-<?php echo e($status); ?>">
                                                                   <?php echo e($statusShort); ?>

                                                            </label>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                </div>

                                                
                                                <div class="mt-2">
                                                    <p class="mb-1 small text-muted"><i class="fas fa-comment-alt me-1"></i> Keterangan (Wajib jika S/I/A):</p>
                                                    <input type="text" class="form-control form-control-sm text-xs" 
                                                           name="keterangan[<?php echo e($s->id); ?>]" 
                                                           placeholder="Cth: Sakit demam, Izin pulang kampung..." 
                                                           maxlength="100">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div class="alert alert-warning text-center py-4 small">Tidak ada data santri untuk kelas ini.</div>
                                <?php endif; ?>
                            </div>
                        </div>


                        
                        <div class="mt-4 p-3 bg-white border-top shadow-lg submit-bar">
                            
                            
                            <div class="d-none d-md-flex justify-content-end align-items-center gap-3">
                                <a href="<?php echo e(route('admin.absensi_baru.select_activity', $kelas_id)); ?>" class="btn btn-md btn-outline-secondary fw-semibold rounded-3">
                                    <i class="fas fa-times me-1"></i> Batalkan
                                </a>
                                <button type="submit" class="btn btn-md btn-primary shadow-sm fw-bold rounded-3"> 
                                    <i class="fas fa-save me-2"></i> SIMPAN ABSENSI
                                </button>
                            </div>

                            
                            <div class="d-grid d-md-none">
                                <button type="submit" class="btn btn-md btn-primary shadow-lg rounded-3 fw-bold mb-2"> 
                                    <i class="fas fa-save me-2"></i> SIMPAN ABSENSI
                                </button>
                                <a href="<?php echo e(route('admin.absensi_baru.select_activity', $kelas_id)); ?>" class="btn btn-sm btn-outline-secondary fw-semibold rounded-3">
                                    <i class="fas fa-times me-1"></i> Batalkan dan Kembali
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('css'); ?>
<style>
    /* Custom utility classes */
    .text-xs { font-size: 0.75rem !important; } 
    .text-xs-mobile { font-size: 0.85rem !important; }
    .text-primary-dark { color: #0056b3 !important; } 
    
    /* Tombol Toggle Status di Desktop */
    .btn-toggle-status {
        width: 35px; 
        height: 30px;
        padding: 0.25rem 0.5rem;
        border-radius: 0.5rem;
    }

    /* Tombol Status Mobile */
    .btn-status-mobile {
        font-size: 0.8rem !important; 
        padding: 0.35rem 0.5rem !important; 
    }
    
    /* === WARNA STATUS UNTUK TOMBOL (Desktop & Mobile) === */
    .status-badge { background-color: #f8f9fa; color: #6c757d; font-weight: 600; padding: 0.35em 0.6em; }

    /* Hadir (H) */
    .btn-check:checked + .btn-outline-secondary[for*="Hadir"],
    .status-hadir { background-color: #28a745; border-color: #28a745; color: #fff !important; }
    /* Sakit (S) */
    .btn-check:checked + .btn-outline-secondary[for*="Sakit"],
    .status-sakit { background-color: #ffc107; border-color: #ffc107; color: #000 !important; }
    /* Izin (I) */
    .btn-check:checked + .btn-outline-secondary[for*="Izin"],
    .status-izin { background-color: #17a2b8; border-color: #17a2b8; color: #fff !important; }
    /* Alfa (A) */
    .btn-check:checked + .btn-outline-secondary[for*="Alfa"],
    .status-alfa { background-color: #dc3545; border-color: #dc3545; color: #fff !important; }

    
    /* === AKORDEON MOBILE KHUSUS === */
    .accordion-item { border-left: 4px solid var(--bs-primary); } 
    .accordion-button:not(.collapsed) { 
        color: var(--bs-primary) !important; 
        background-color: #f7f7f7;
        box-shadow: none;
    }
    .accordion-button:focus { box-shadow: none; }
    .accordion-button { padding: 0.5rem 1.25rem; } 


    /* === PERBAIKAN FINAL: HILANGKAN STICKY DI MOBILE === */
    /* Hapus semua properti yang berhubungan dengan position: fixed untuk menghindari menutupi footer */
    
    .submit-bar {
        position: relative; /* Pastikan ini tidak fixed */
        /* Padding bottom pada card-body yang tadinya di-override di mobile, sekarang dihapus */
    }

    @media (max-width: 767px) {
        /* Hapus semua kelas/properti yang terkait dengan fixed positioning */
        /* .sticky-bottom-custom sudah dihapus dari HTML dan CSS. */
        .card-body {
            /* Hapus padding-bottom yang berlebihan */
            padding-bottom: 1rem !important; /* Gunakan padding default */
        }
        .submit-bar {
            /* Adjust padding untuk mobile */
            padding: 1rem 0 !important; 
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('js'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // Fungsi untuk memperbarui badge status di header akordeon
    function updateStatusBadge(santriId, status, shortStatus) {
        const badge = document.getElementById(`status-badge-${santriId}`);
        if (!badge) return;

        // Reset kelas status
        badge.classList.remove('status-hadir', 'status-sakit', 'status-izin', 'status-alfa');

        // Tambahkan kelas status yang baru
        if (status === 'Hadir') {
            badge.classList.add('status-hadir');
        } else if (status === 'Sakit') {
            badge.classList.add('status-sakit');
        } else if (status === 'Izin') {
            badge.classList.add('status-izin');
        } else if (status === 'Alfa') {
            badge.classList.add('status-alfa');
        } else {
             badge.classList.add('bg-secondary'); // Default jika tidak ada status
        }
        
        // Update teks badge
        badge.textContent = shortStatus;
    }

    // Loop melalui semua tombol radio status di mobile
    document.querySelectorAll('.mobile-status-radio').forEach(radio => {
        const santriId = radio.closest('.accordion-body').parentElement.parentElement.querySelector('.btn-group').dataset.santriId;
        
        // Set status default saat pertama kali dimuat
        if (radio.checked) {
            updateStatusBadge(santriId, radio.value, radio.dataset.short);
        }

        // Tambahkan event listener untuk setiap perubahan
        radio.addEventListener('change', function() {
            if (this.checked) {
                updateStatusBadge(santriId, this.value, this.dataset.short);
            }
        });
    });

    // Menangani perilaku akordeon
    
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/admin/absensi/harian/create.blade.php ENDPATH**/ ?>