<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('page_title', 'Dashboard Wali Santri'); ?>

<?php $__env->startSection('content'); ?>

    
    <div class="row g-4 mb-5">
        
        
        <div class="col-12 d-block d-md-none">
            
            
            <div class="row row-cols-2 g-3 mb-3">
                
                
                <div class="col">
                    
                    <div class="card shadow-sm rounded-4 card-modern-summary h-100 bg-primary-subtle">
                        <div class="card-body p-3 d-flex flex-column justify-content-between text-center">
                            
                            <div class="info-top text-center flex-grow-1">
                                
                                <h6 class="mb-1 fw-semibold text-primary mobile-headline">Santri Asuhan</h6>
                                
                                <p class="mb-2 text-primary fw-bolder fs-3"><?php echo e($santriCount); ?></p> 
                            </div>
                            
                            <a href="<?php echo e(route('wali.santri.index')); ?>" class="btn btn-primary w-100 fw-bold rounded-pill action-mobile-btn">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
                
                
                <div class="col">
                    <div class="card shadow-sm rounded-4 card-modern-summary h-100 bg-danger-subtle">
                        <div class="card-body p-3 d-flex flex-column justify-content-between text-center">
                            
                            <div class="info-top text-center flex-grow-1">
                                <h6 class="mb-1 fw-semibold text-danger mobile-headline">Tagihan Belum Lunas</h6>
                                <p class="mb-2 text-danger fw-bolder fs-3"><?php echo e($tagihanBelumLunasCount); ?></p>
                            </div>
                            
                            <a href="<?php echo e(route('wali.tagihan.index')); ?>" class="btn btn-danger w-100 fw-bold rounded-pill action-mobile-btn">
                                Cek Tagihan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            
            <div class="row"> 
                <div class="col-12">
                    <div class="card shadow-lg rounded-4 card-modern-summary bg-warning-subtle">
                        <div class="card-body p-3 text-center">
                            <div class="d-flex align-items-center justify-content-center mb-1">
                                <div>
                                    <p class="text-uppercase text-warning mb-0 small fw-bold">Menunggu Konfirmasi</p>
                                    <h2 class="fw-bolder mb-0 fs-3 <?php echo e($pembayaranMenungguCount > 0 ? 'text-warning' : 'text-dark'); ?>">
                                        <?php echo e($pembayaranMenungguCount); ?>

                                    </h2>
                                </div>
                            </div>
                            <hr class="my-2">
                            <a href="<?php echo e(route('wali.tagihan.index')); ?>#riwayat-content" class="small fw-semibold text-warning text-decoration-none d-flex align-items-center justify-content-center stretched-link">
                                Lihat Riwayat Pembayaran <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-12 d-none d-md-block">
            <div class="row g-4">
                
                
                <div class="col-sm-6 col-lg-4">
                    <div class="card shadow-lg rounded-4 card-modern-summary bg-primary-subtle">
                        <div class="card-body d-flex flex-column justify-content-between text-center"> 
                            <div class="desktop-content-top flex-grow-1">
                                <p class="text-uppercase text-primary mb-1 small fw-bold">Santri Asuhan</p> 
                                <h2 class="fw-bolder mb-0 fs-1 text-primary"><?php echo e($santriCount); ?></h2> 
                                <span class="small text-muted d-block mt-2">Santri yang Anda asuh</span>
                            </div>
                            <hr class="my-3">
                            <a href="<?php echo e(route('wali.santri.index')); ?>" class="small fw-semibold text-primary text-decoration-none d-flex align-items-center justify-content-center stretched-link">
                                Lihat Detail Santri <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                
                <div class="col-sm-6 col-lg-4">
                    <div class="card shadow-lg rounded-4 card-modern-summary bg-danger-subtle">
                        <div class="card-body d-flex flex-column justify-content-between text-center">
                             <div class="desktop-content-top flex-grow-1">
                                <p class="text-uppercase text-danger mb-1 small fw-bold">Tagihan Belum Lunas</p>
                                <h2 class="fw-bolder mb-0 fs-1 <?php echo e($tagihanBelumLunasCount > 0 ? 'text-danger' : 'text-dark'); ?>"><?php echo e($tagihanBelumLunasCount); ?></h2>
                                <span class="small text-muted d-block mt-2">Tagihan Mendesak</span>
                            </div>
                            <hr class="my-3">
                            <a href="<?php echo e(route('wali.tagihan.index')); ?>" class="small fw-semibold text-danger text-decoration-none d-flex align-items-center justify-content-center stretched-link">
                                Cek Tagihan Sekarang <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                
                <div class="col-sm-6 col-lg-4">
                    <div class="card shadow-lg rounded-4 card-modern-summary bg-warning-subtle">
                        <div class="card-body d-flex flex-column justify-content-between text-center">
                             <div class="desktop-content-top flex-grow-1">
                                <p class="text-uppercase text-warning mb-1 small fw-bold">Konfirmasi Pembayaran</p>
                                <h2 class="fw-bolder mb-0 fs-1 <?php echo e($pembayaranMenungguCount > 0 ? 'text-warning' : 'text-dark'); ?>"><?php echo e($pembayaranMenungguCount); ?></h2>
                                <span class="small text-muted d-block mt-2">Bukti Menunggu Verifikasi</span>
                            </div>
                            <hr class="my-3">
                            <a href="<?php echo e(route('wali.tagihan.index')); ?>#riwayat-content" class="small fw-semibold text-warning text-decoration-none d-flex align-items-center justify-content-center stretched-link">
                                Lihat Riwayat Pembayaran <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    <hr class="d-none d-md-block divider-line">
    <div class="d-block d-md-none mobile-divider" style="margin-bottom: 2rem;"></div>

    
    
    <?php if($santris->count() > 0): ?>
        <div class="card shadow-lg border-0 mt-4 mb-5 rounded-4">
            <div class="card-header bg-primary text-white fw-bold d-flex align-items-center rounded-top-4">
                <i class="fas fa-user-graduate me-2 fa-lg"></i> Ringkasan Santri yang Anda Asuh
            </div>
            <div class="card-body p-0 p-md-4">
                
                
                <div class="table-responsive d-none d-md-block">
                    <table class="table table-hover mb-0 align-middle small"> 
                        <thead class="table-light">
                            <tr>
                                <th scope="col" style="width: 5%;">#</th>
                                <th scope="col" style="width: 40%;">Nama Santri</th>
                                <th scope="col" style="width: 25%;">Kelas</th>
                                <th scope="col" style="width: 15%;">Status</th>
                                <th scope="col" class="text-center" style="width: 15%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $santris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $santri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="text-muted"><?php echo e($index + 1); ?></td>
                                    <td><span class="fw-semibold text-dark"><?php echo e($santri->nama); ?></span></td>
                                    <td>
                                        <span class="badge bg-info-subtle text-info-emphasis fw-semibold"><?php echo e($santri->kelas->nama_kelas ?? 'N/A'); ?></span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success-subtle text-success-emphasis fw-semibold"><?php echo e($santri->status ?? 'Aktif'); ?></span>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?php echo e(route('wali.santri.show', $santri)); ?>" class="btn btn-sm btn-primary rounded-pill px-3" title="Lihat Data <?php echo e($santri->nama); ?>">
                                            <i class="fas fa-eye me-1"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                
                <div class="list-group d-block d-md-none p-3">
                    <?php $__currentLoopData = $santris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $santri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="list-group-item list-group-item-action mb-3 shadow-sm border-left-primary rounded-3 card-mobile-santri">
                            <div class="d-flex w-100 justify-content-between align-items-center mb-2">
                                <h6 class="mb-0 fw-bold text-dark"><?php echo e($index + 1); ?>. <?php echo e($santri->nama); ?></h6>
                                <span class="badge bg-success-subtle text-success-emphasis fw-semibold"><?php echo e($santri->status ?? 'Aktif'); ?></span>
                            </div>
                            
                            <hr class="my-2">
                            
                            <p class="mb-1 small text-muted d-flex justify-content-between">
                                <span><i class="fas fa-school me-2 text-primary"></i> Kelas:</span> 
                                <span class="fw-bold text-dark"><?php echo e($santri->kelas->nama_kelas ?? 'N/A'); ?></span>
                            </p>
                            
                            <div class="mt-3 text-end">
                                <a href="<?php echo e(route('wali.santri.show', $santri)); ?>" class="btn btn-sm btn-primary w-100 rounded-pill">
                                    <i class="fas fa-eye me-1"></i> Lihat Profil
                                </a>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

            </div>
        </div>
    <?php endif; ?>


    
    <?php if($santris->count() > 0): ?>
        
        <div class="card shadow-lg border-0 mt-4 mb-5 rounded-4">
            <div class="card-header bg-warning text-dark fw-bold d-flex align-items-center rounded-top-4 header-absensi-wrapper">
                <i class="fas fa-calendar-day me-2 fa-lg flex-shrink-0"></i> 
                <span class="header-absensi-text">
                    Ringkasan Ketidakhadiran Harian
                    <span class="text-secondary d-block fw-normal small">(<?php echo e(\Carbon\Carbon::now()->translatedFormat('l, d M Y') . ''); ?>)</span>
                </span>
            </div>
            
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <?php
                        $totalKetidakhadiranGlobal = 0;
                    ?>

                    <?php $__currentLoopData = $santris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $santri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $totalKetidakhadiran = $santri->totalKetidakhadiranHariIni ?? 0; 
                            $badgeClass = ($totalKetidakhadiran > 0) ? 'bg-danger text-white' : 'bg-success text-white';
                            $icon = ($totalKetidakhadiran > 0) ? 'fas fa-exclamation-triangle' : 'fas fa-check-circle';
                            $label = ($totalKetidakhadiran > 0) ? 'Total Tidak Hadir' : 'Hadir Penuh';
                            $totalKetidakhadiranGlobal += $totalKetidakhadiran;
                        ?>

                        
                        <div class="list-group-item list-group-item-action py-3 border-left-<?php echo e($totalKetidakhadiran > 0 ? 'danger' : 'success'); ?> d-flex align-items-center justify-content-between absensi-item">
                            
                            
                            <div class="info-santri flex-grow-1 me-2 me-md-4">
                                <h6 class="mb-0 fw-bold text-dark">
                                    <?php echo e($index + 1); ?>. <?php echo e($santri->nama); ?>

                                </h6>
                                <p class="mb-1 small text-muted d-none d-sm-block">
                                    <i class="fas fa-school me-1"></i> Kelas: <?php echo e($santri->kelas->nama_kelas ?? 'N/A'); ?>

                                </p>
                            </div>

                            
                            <div class="d-flex align-items-center flex-shrink-0">
                                
                                
                                <div class="status-badge text-center me-3 flex-shrink-0">
                                    <span class="badge <?php echo e($badgeClass); ?> fw-bold px-3 py-2 fs-6 shadow-sm d-block mb-1">
                                        <i class="<?php echo e($icon); ?> me-1"></i> <?php echo e($totalKetidakhadiran); ?>

                                    </span>
                                    <span class="small text-muted d-none d-sm-block"><?php echo e($label); ?></span>
                                </div>

                                
                                <a href="<?php echo e(route('wali.absensi.show', $santri)); ?>" class="btn btn-sm btn-outline-primary rounded-pill py-1 px-3 flex-shrink-0" title="Lihat Detail Absensi">
                                    <i class="fas fa-eye d-sm-none"></i> <span class="d-none d-sm-inline">Detail</span>
                                </a>
                            </div>

                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

            </div>
            
            
            <div class="card-footer bg-light p-3 rounded-bottom-4">
                <div class="text-center">
                    <a href="<?php echo e(route('wali.absensi.index')); ?>" class="btn btn-sm btn-link text-primary fw-bold text-decoration-none">
                        Lihat Semua Riwayat Kehadiran <i class="fas fa-external-link-alt ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>

    
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-info text-white fw-bold d-flex align-items-center rounded-top-4">
                    <i class="fas fa-bullhorn me-2 fa-lg"></i> Pengumuman Terbaru
                </div>
                <div class="card-body p-0">
                    
                    <?php $__empty_1 = true; $__currentLoopData = $pengumumanTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="list-group-item list-group-item-action border-top-0 border-end-0 border-start-0 py-4 px-4 pengumuman-item">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="fw-bold text-dark me-3 mb-0 flex-grow-1">
                                <span class="badge bg-primary me-2 small"><?php echo e($p->kategori ?? 'Umum'); ?></span> 
                                <?php echo e($p->judul); ?>

                            </h6>
                            <span class="text-muted py-1 px-2 flex-shrink-0 text-nowrap small fw-normal ms-auto"> 
                                <i class="fas fa-calendar-alt me-1 d-none d-sm-inline"></i> <?php echo e(\Carbon\Carbon::parse($p->tanggal_publikasi)->translatedFormat('d M Y')); ?>

                            </span>
                        </div>
                        
                        <p class="text-secondary small mb-3">
                            <?php echo e(Str::limit(strip_tags($p->isi), 150, '...')); ?> 
                        </p>
                        
                        <a href="<?php echo e(route('wali.pengumuman.show', $p)); ?>" class="btn btn-sm btn-outline-primary rounded-pill">
                            Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="alert alert-info text-center py-4 rounded-3 border-0 m-4 shadow-sm">
                        <h5 class="mb-2"><i class="fas fa-info-circle me-2"></i> Belum Ada Pengumuman Aktif</h5>
                        <p class="mb-0">Mohon cek kembali di lain waktu untuk informasi terbaru.</p>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="card-footer text-center bg-light p-3 rounded-bottom-4">
                    <a href="<?php echo e(route('wali.pengumuman.index')); ?>" class="btn btn-sm btn-link text-primary fw-bold text-decoration-none">
                        Lihat Semua Pengumuman <i class="fas fa-external-link-alt ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    
    <?php $__env->startPush('css'); ?>
    <style>
        /* Tipografi & Warna */
        body { font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol"; color: #34495e; background-color: #f4f6f9; }
        :root {
            --bs-primary: #1e88e5; /* Biru */
            --bs-danger: #e53935;  /* Merah */
            --bs-warning: #ffb300; /* Kuning/Amber */
            --bs-success: #43a047; /* Hijau */
            --bs-info: #00acc1;    /* Cyan */
            --bs-border-radius: 0.75rem; 
        }
        
        /* WARNA SUBTLE BARU (untuk Kartu Ringkasan) */
        .bg-primary-subtle { background-color: #e3f2fd !important; } 
        .bg-danger-subtle { background-color: #ffebee !important; } 
        .bg-warning-subtle { background-color: #fff8e1 !important; } 

        /* Global Card Style */
        .card { 
            border: none; 
            border-radius: var(--bs-border-radius); 
            /* Soft Shadow */
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05); 
            transition: box-shadow 0.3s ease-in-out, transform 0.3s; 
        }
        .card:hover { 
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1); 
            transform: translateY(-2px);
        }
        .card-header { 
            border-bottom: none; 
            padding: 1rem 1.5rem; 
            font-size: 1.1rem; 
            font-weight: 700;
        }
        
        /* Hilangkan Border Kiri yang Kaku pada Summary Card */
        .card-modern-summary {
            border-left: none !important; 
        }
        
        /* Border Kiri Tebal Kustom (Tersisa untuk List/Absensi) */
        .border-left-primary { border-left: 6px solid var(--bs-primary) !important; }
        .border-left-danger { border-left: 6px solid var(--bs-danger) !important; }
        .border-left-warning { border-left: 6px solid var(--bs-warning) !important; }
        .border-left-success { border-left: 6px solid var(--bs-success) !important; } 
        
        /* Badge Status Kustom */
        .badge { font-weight: 600 !important; padding: 0.5em 0.75em; border-radius: 0.5rem; white-space: nowrap; }

        /* Warna Subtle untuk Tabel/List */
        .bg-info-subtle { background-color: #e0f7fa !important; } 
        .text-info-emphasis { color: #00acc1 !important; } 
        .bg-success-subtle { background-color: #e8f5e9 !important; } 
        .text-success-emphasis { color: #43a047 !important; }
        
        /* List Group/Cards Clean Look */
        .list-group-flush > .list-group-item {
            border-right: 0;
            border-left: 0;
            transition: background-color 0.2s;
        }
        .list-group-item:hover {
            background-color: #f9f9f9;
        }

        /* Desktop Summary Card (Fix Centering and Typography) */
        .card-summary-desktop .desktop-content-top {
            flex-grow: 1;
            text-align: center; 
            padding-top: 1rem; 
            padding-bottom: 0.5rem;
        }
        .card-summary-desktop h2.fs-1 {
            font-size: 2.2rem !important; 
            letter-spacing: -0.5px;
        }
        .card-summary-desktop .card-body > a {
            justify-content: center !important; 
            font-size: 0.85rem !important;
        }
        .table-hover tbody tr:hover {
            background-color: #f5f5f5;
        }

        /* Divider */
        .divider-line {
            border-top: 1px solid #e0e0e0;
            margin-top: 2rem;
            margin-bottom: 2rem;
        }
        .mobile-divider {
             border-top: 1px solid #e0e0e0;
        }


        /* MEDIA QUERIES (Perhalusan Mobile) */
        @media (max-width: 767.98px) {

            /* == KARTU RINGKASAN MOBILE HORIZONTAL == */
            .card-modern-summary {
                height: 100%;
            }
            .card-summary-mobile .card-body {
                padding: 1rem !important; 
            }
            
            .card-summary-mobile .info-top {
                margin-bottom: 0.8rem; 
            }

            .card-summary-mobile p.fs-3 {
                font-size: 1.8rem !important; 
                margin-bottom: 0.4rem !important; 
            }
            .card-summary-mobile .mobile-headline {
                font-size: 0.85rem; 
                font-weight: 600 !important;
            }
            
            /* Tombol Aksi Mobile Full Width (Rounded Pill) */
            .card-summary-mobile .action-mobile-btn {
                font-size: 0.85rem !important; 
                padding: 0.35rem 0.5rem !important; 
                font-weight: 600;
            }

            /* Header Absensi Mobile */
            .header-absensi-wrapper {
                padding: 0.75rem 1rem !important;
                font-size: 0.95rem !important; 
            }
            .header-absensi-text > span.small {
                font-size: 0.8rem; 
            }
            
            /* Absensi List Item Mobile (Kerapian Horizontal) */
            .absensi-item {
                flex-direction: column; 
                align-items: stretch !important; 
                padding: 1rem !important; 
            }
            .absensi-item .info-santri {
                margin-bottom: 0.75rem; 
            }
            .absensi-item > .d-flex.align-items-center.flex-shrink-0 {
                justify-content: space-between; 
            }
            .absensi-item .status-badge {
                text-align: left !important;
                flex-grow: 1;
                display: flex; 
                align-items: center;
            }
            .absensi-item .status-badge .badge {
                flex-shrink: 0; 
            }
            .absensi-item .status-badge .small.text-muted {
                display: inline !important; 
                font-size: 0.8rem;
                flex-grow: 1; 
            }
            
            /* Pengumuman Mobile */
            .pengumuman-item {
                 padding: 1rem 1.5rem !important;
            }
            .pengumuman-item .d-flex.justify-content-between {
                flex-direction: column;
                align-items: flex-start !important;
            }
            .pengumuman-item .text-nowrap {
                margin-top: 0.5rem;
                margin-left: 0 !important; 
            }
            .pengumuman-item .text-nowrap .fa-calendar-alt {
                display: none !important;
            }
        }
    </style>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.wali', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/wali/dashboard.blade.php ENDPATH**/ ?>