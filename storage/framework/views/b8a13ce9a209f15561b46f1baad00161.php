<?php $__env->startSection('title', 'Detail Santri'); ?>
<?php $__env->startSection('page_title', 'Detail Santri: ' . $santri->nama_lengkap); ?>

<?php $__env->startSection('styles'); ?>
<style>
    /* 1. KONTROL UTAMA & CARD */
    .card-master {
        border-radius: 0.75rem !important;
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1) !important;
    }
    .header-primary {
        background-color: var(--bs-primary);
        color: #fff;
        padding: 1.5rem;
        border-radius: 0.75rem 0.75rem 0 0;
    }
    .card-body {
        padding: 1.5rem !important;
    }

    /* 2. BASE DETAIL LIST GROUP */
    .detail-list-group {
        border-radius: 0.5rem;
        border: 1px solid var(--bs-gray-300); /* Memberi border luar yang bersih */
        overflow: hidden; 
    }
    .detail-list-group .list-group-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.9rem 1.25rem;
        border-left: none;
        border-right: none;
        border-color: var(--bs-gray-200); /* Garis pemisah yang lembut */
    }
    .detail-list-group .detail-label {
        font-weight: 500;
        color: var(--bs-secondary);
        text-transform: uppercase;
        font-size: 0.75rem;
        flex-shrink: 0; /* Penting: Mencegah label menyusut */
        flex-basis: 40%;
    }
    .detail-list-group .detail-value {
        font-weight: 700;
        color: var(--bs-dark);
        text-align: right;
        flex-grow: 1; /* Penting: Nilai mengisi sisa ruang */
        word-break: break-word; /* Mengatasi teks panjang */
        font-size: 0.9rem;
    }
    
    /* MOBILE ADJUSTMENTS (FOKUS DI SINI) */
    @media (max-width: 767.98px) {
        .card-body {
            padding: 1rem !important;
        }
        .header-primary {
            padding: 1rem;
            font-size: 0.9rem;
        }
        .header-primary h4 {
            font-size: 1.2rem !important;
        }
        
        /* KONTROL KETAT PADA LIST DETAIL */
        .detail-list-group .list-group-item {
            padding: 0.7rem 1rem; /* Padding lebih kecil */
        }
        .detail-list-group .detail-label {
            font-size: 0.65rem; /* Ukuran font label sangat kecil */
            flex-basis: 35%; /* Mengurangi ruang label, memaksimalkan nilai */
        }
        .detail-list-group .detail-value {
            font-size: 0.8rem; /* Ukuran font nilai kecil */
        }

        /* Penyesuaian Highlight Cards untuk mobile */
        .main-highlight-card .card-body {
            padding: 0.75rem !important;
        }
        .main-highlight-card p.fs-5 {
            font-size: 1.2rem !important;
        }
        .main-highlight-card p.fs-6 {
             font-size: 0.9rem !important;
        }
        .main-highlight-card .badge {
            font-size: 0.7rem !important;
            padding: 0.3rem 0.5rem !important;
        }
        .main-highlight-card label.small {
            font-size: 0.6rem !important;
        }

        /* Log Data Mobile Tight */
        .p-3.rounded-3.bg-light {
            padding: 0.75rem !important;
        }
    }
</style>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-master border-0 rounded-4">
                
                
                <div class="card-header bg-primary text-white rounded-top-4 header-primary">
                    <h4 class="mb-0 fw-bold fs-5"><i class="fas fa-user-check me-2"></i> Detail Profil Santri</h4>
                    <p class="text-white-50 small mb-0">Informasi lengkap dan terperinci mengenai <?php echo e($santri->nama_lengkap); ?>.</p>
                </div>
                
                <div class="card-body p-4 p-md-5"> 
                    
                    
                    <h5 class="fw-bold text-dark mb-1 text-primary"><i class="fas fa-id-card me-2"></i> Data Identitas Utama</h5>
                    <hr class="mt-2 mb-4 border-primary opacity-25">
                    
                    <div class="row g-4 mb-5">
                        
                        
                        <div class="col-lg-7">
                            <div class="card card-body shadow-sm border-0 border-start border-5 border-primary p-3 bg-white h-100 d-flex justify-content-center main-highlight-card">
                                <label class="fw-semibold text-muted small mb-0">NAMA LENGKAP</label>
                                <p class="mb-0 fs-5 fs-lg-3 text-dark fw-bolder lh-sm"><?php echo e($santri->nama_lengkap); ?></p>
                            </div>
                        </div>

                        
                        <div class="col-lg-5">
                            <div class="card card-body shadow-sm border-0 border-start border-5 border-info p-3 bg-white h-100 d-flex flex-column justify-content-center main-highlight-card">
                                <label class="fw-semibold text-muted small mb-0">NISN</label>
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="mb-0 fs-6 fs-lg-4 fw-bold text-info lh-sm"><?php echo e($santri->nisn); ?></p>
                                    <span class="badge bg-<?php echo e($santri->status == 'Aktif' ? 'success' : 'secondary'); ?> p-2 fw-bold fs-6">
                                        <?php echo e($santri->status); ?>

                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <h5 class="fw-bold text-dark mb-3 pt-3 text-secondary"><i class="fas fa-info-circle me-2"></i> Detail Pribadi</h5>
                    <ul class="list-group list-group-flush detail-list-group mb-4">
                        
                        <li class="list-group-item bg-white">
                            <span class="detail-label"><i class="fas fa-map-marker-alt me-1"></i> Tempat Lahir</span>
                            <span class="detail-value"><?php echo e($santri->tempat_lahir ?? '-'); ?></span>
                        </li>
                        
                        <li class="list-group-item bg-white">
                            <span class="detail-label"><i class="far fa-calendar-alt me-1"></i> Tanggal Lahir</span>
                            <span class="detail-value"><?php echo e($santri->tanggal_lahir ? $santri->tanggal_lahir->translatedFormat('d F Y') : '-'); ?></span>
                        </li>

                        <li class="list-group-item bg-white">
                            <span class="detail-label"><i class="fas fa-venus-mars me-1"></i> Jenis Kelamin</span>
                            <span class="detail-value"><?php echo e($santri->jenis_kelamin ?? '-'); ?></span>
                        </li>
                    </ul>
                    
                    <hr class="my-5 border-light opacity-50"> 
                    
                    
                    <h5 class="fw-bold text-dark mb-3 text-warning"><i class="fas fa-link me-2"></i> Data Akademik & Wali</h5>
                    
                    <ul class="list-group list-group-flush detail-list-group mb-5">
                        <li class="list-group-item bg-white">
                            <span class="detail-label"><i class="fas fa-school me-1"></i> Kelas Aktif</span>
                            <span class="detail-value">
                                <span class="badge bg-info text-dark p-1 fw-bold"><?php echo e($santri->kelas->nama_kelas ?? 'N/A'); ?></span>
                            </span>
                        </li>

                        <li class="list-group-item bg-white">
                            <span class="detail-label"><i class="fas fa-user-tie me-1"></i> Wali Santri</span>
                            <span class="detail-value"><?php echo e($santri->waliSantri->name ?? '-'); ?></span>
                        </li>
                    </ul>

                    
                    <h5 class="fw-bold text-dark mb-2 text-success"><i class="fas fa-map-marked-alt me-2"></i> Alamat Lengkap</h5>
                    <div class="p-3 rounded-3 bg-light shadow-sm text-dark fw-medium border border-light fs-6 mb-5"><?php echo e($santri->alamat ?? 'Belum ada alamat'); ?></div>


                    <hr class="mt-5 mb-4 border-dark opacity-10"> 

                    
                    <h6 class="fw-bold text-secondary mb-3"><i class="fas fa-history me-1"></i> Log Data Sistem</h6>

                    <div class="row g-3">
                        
                        <div class="col-md-6">
                            <div class="p-3 rounded-3 bg-light shadow-sm border border-light d-flex justify-content-between">
                                <div>
                                    <small class="text-muted d-block fw-semibold mb-1">Dibuat Pada</small>
                                    <i class="far fa-calendar-alt me-2 text-primary opacity-75"></i>
                                </div>
                                <div class="text-end">
                                    <span class="text-dark fw-semibold d-block"><?php echo e($santri->created_at->translatedFormat('d F Y')); ?></span>
                                    <span class="text-muted small">pukul <?php echo e($santri->created_at->format('H:i')); ?></span>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="col-md-6">
                             <div class="p-3 rounded-3 bg-light shadow-sm border border-light d-flex justify-content-between">
                                <div>
                                    <small class="text-muted d-block fw-semibold mb-1">Terakhir Diperbarui</small>
                                    <i class="far fa-clock me-2 text-warning opacity-75"></i>
                                </div>
                                <div class="text-end">
                                    <span class="text-dark fw-semibold d-block"><?php echo e($santri->updated_at->translatedFormat('d F Y')); ?></span>
                                    <span class="text-muted small">pukul <?php echo e($santri->updated_at->format('H:i')); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>

                
                <div class="card-footer bg-light border-0 rounded-bottom-4 p-4">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        
                        
                        <a href="<?php echo e(route('admin.santri.edit', $santri)); ?>" class="btn btn-warning shadow-sm fw-bold w-100 w-md-auto text-dark rounded-pill px-4 order-md-1">
                            <i class="fas fa-edit me-2"></i> Edit Data
                        </a>
                        
                        
                        <form action="<?php echo e(route('admin.santri.destroy', $santri)); ?>" method="POST" class="d-inline w-100 w-md-auto order-md-2">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger shadow-sm fw-bold w-100 rounded-pill px-4" onclick="return confirm('APAKAH ANDA YAKIN ingin menghapus santri <?php echo e($santri->nama_lengkap); ?>? Tindakan ini tidak dapat dibatalkan.')">
                                <i class="fas fa-trash me-2"></i> Hapus Santri
                            </button>
                        </form>

                        
                        <a href="<?php echo e(route('admin.santri.index')); ?>" class="btn btn-secondary shadow-sm fw-bold w-100 w-md-auto rounded-pill px-4 order-md-3">
                            <i class="fas fa-list me-2"></i> Daftar Santri
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/admin/master/santri/show.blade.php ENDPATH**/ ?>