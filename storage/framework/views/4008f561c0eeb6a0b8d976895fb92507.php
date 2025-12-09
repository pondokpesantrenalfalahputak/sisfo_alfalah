 

<?php $__env->startSection('title', 'Rekapitulasi Absensi Bulanan'); ?>
<?php $__env->startSection('page_title', 'Rekapitulasi Absensi Bulanan'); ?>

<?php $__env->startSection('content'); ?>

    <?php
        // Bulan & Tahun dari Query String
        $bulanFilter = request('bulan', \Carbon\Carbon::now()->month);
        $tahunFilter = request('tahun', \Carbon\Carbon::now()->year);
        $isFiltered = request()->has('bulan') || request()->has('tahun');
        $carbonClass = \Carbon\Carbon::class; 
    ?>

    <div class="row">
        
        <div class="col-12 mb-5">
            <div class="card border-0 shadow-lg rounded-4 bg-white filter-card-custom">
                <div class="card-body p-4">
                    <form method="GET" action="<?php echo e(route('wali.absensi.index')); ?>" class="row g-3 align-items-center">
                        <div class="col-12 mb-2">
                            <h5 class="mb-0 fw-bold text-dark">
                                <i class="fas fa-filter me-2 text-primary"></i> Filter Periode Absensi
                            </h5>
                        </div>
                        
                        <div class="col-sm-4 col-6">
                            <label for="bulan" class="form-label small text-muted mb-1 d-none d-sm-block">Bulan</label>
                            <select name="bulan" id="bulan" class="form-select form-select-sm rounded-pill shadow-sm">
                                <?php for($m = 1; $m <= 12; $m++): ?>
                                    <option value="<?php echo e($m); ?>" <?php echo e((string)$m === (string)$bulanFilter ? 'selected' : ''); ?>>
                                        <?php echo e($carbonClass::create()->month($m)->translatedFormat('F')); ?>

                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-sm-3 col-6">
                            <label for="tahun" class="form-label small text-muted mb-1 d-none d-sm-block">Tahun</label>
                            <select name="tahun" id="tahun" class="form-select form-select-sm rounded-pill shadow-sm">
                                <?php for($y = $carbonClass::now()->year; $y >= 2020; $y--): ?>
                                    <option value="<?php echo e($y); ?>" <?php echo e((string)$y === (string)$tahunFilter ? 'selected' : ''); ?>><?php echo e($y); ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        
                        <div class="col-sm-5 col-12 d-flex justify-content-end align-items-end">
                            <button type="submit" class="btn btn-primary btn-sm me-2 flex-fill rounded-pill shadow-md fw-semibold">
                                <i class="fas fa-check me-1"></i> Terapkan Filter
                            </button>
                            <?php if($isFiltered): ?>
                                <a href="<?php echo e(route('wali.absensi.index')); ?>" class="btn btn-outline-secondary btn-sm rounded-pill shadow-sm reset-btn">Reset</a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
    <?php $__empty_1 = true; $__currentLoopData = $santriList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $santri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="col-lg-12 mb-5">
            
            
            <div class="card border-0 shadow-lg mb-4 rounded-4 card-santri-rekap">
                
                <div class="card-header bg-primary text-white d-flex flex-column flex-md-row align-items-md-center py-3 px-4 rounded-top-4">
                    <div class="d-flex align-items-center mb-2 mb-md-0">
                        <i class="fas fa-user-graduate me-3 fs-3 flex-shrink-0"></i>
                        <div>
                            <h5 class="mb-0 fw-bolder text-uppercase"><?php echo e($santri->nama_lengkap); ?></h5> 
                            <small class="badge bg-light text-primary fw-semibold rounded-pill mt-1"><?php echo e($santri->kelas->nama_kelas ?? 'Kelas N/A'); ?> | NIS: <?php echo e($santri->nisn); ?></small>
                        </div>
                    </div>
                    
                    
                    <a href="<?php echo e(route('wali.absensi.show', $santri->id)); ?>" class="btn btn-md btn-light text-primary ms-md-auto fw-bold rounded-pill shadow-sm mt-2 mt-md-0 action-link">
                        <i class="fas fa-calendar-day me-1"></i> Absensi Harian
                    </a>
                </div>
                
                <div class="card-body p-4">

                    
                    <?php
                        $absensiRiwayat = $santri->absensiRekapitulasi; 
                        
                        // Menghitung total Alpha (sesuai filter bulan/tahun yang diterapkan di Controller)
                        $totalAlphaKumulatif = $absensiRiwayat->sum('ngaji_alpha') + 
                                               $absensiRiwayat->sum('sholat_alpha') + 
                                               $absensiRiwayat->sum('roan_alpha');
                        
                        // Menentukan status berdasarkan jumlah Alpha
                        $statusClass = $totalAlphaKumulatif >= 5 ? 'danger' : ($totalAlphaKumulatif > 0 ? 'warning' : 'success');
                        $statusIcon = $totalAlphaKumulatif >= 5 ? 'fas fa-exclamation-triangle' : ($totalAlphaKumulatif > 0 ? 'fas fa-exclamation-circle' : 'fas fa-check-circle');
                        $statusText = $totalAlphaKumulatif >= 5 ? 'Perlu Perhatian Mendesak' : ($totalAlphaKumulatif > 0 ? 'Ada Catatan Ketidakhadiran' : 'Disiplin Sangat Baik');
                    ?>

                    <div class="mb-5 p-4 rounded-4 shadow-sm summary-box-<?php echo e($statusClass); ?>">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-4 text-center border-end-md summary-alpha-count">
                                <span class="fw-bolder display-4 text-<?php echo e($statusClass); ?>"><?php echo e($totalAlphaKumulatif); ?></span>
                                <p class="mb-0 small text-uppercase fw-bold text-muted mt-1">
                                    Total Alpha 
                                </p>
                                <span class="badge bg-<?php echo e($statusClass); ?> text-white mt-2 px-3 fw-semibold rounded-pill">
                                    <?php if($isFiltered): ?> Periode Filter <?php else: ?> Data Kumulatif <?php endif; ?>
                                </span>
                            </div>
                            <div class="col-12 col-md-8 mt-4 mt-md-0 ps-md-4">
                                <p class="small mb-0 text-<?php echo e($statusClass); ?> fw-bolder fs-6">
                                    <i class="<?php echo e($statusIcon); ?> me-2"></i> <?php echo e($statusText); ?>

                                </p>
                                <p class="text-secondary small mt-1 mb-0">Rincian ketidakhadiran yang tercatat pada kegiatan wajib pondok dalam periode ini.</p>
                            </div>
                        </div>
                    </div>
                    
                    
                    <h5 class="fw-bold mb-4 text-dark border-bottom pb-2">
                        <i class="fas fa-list-alt me-2 text-primary"></i> Riwayat Absensi Bulanan Santri
                    </h5>

                    
                    
                    <?php if($absensiRiwayat->count() > 0): ?>
                        
                        
                        <div class="table-responsive d-none d-md-block">
                             <table class="table table-bordered table-sm small table-hover align-middle rounded-3 overflow-hidden table-rekap-desktop" width="100%" cellspacing="0">
                                <thead class="table-dark text-center">
                                    <tr>
                                        <th rowspan="2" style="width: 15%;">PERIODE</th>
                                        <th colspan="3" class="bg-danger">ALPHA (Hari)</th>
                                        <th rowspan="2" class="bg-primary text-white text-center" style="width: 8%;">TOTAL</th>
                                        <th rowspan="2" style="width: 35%;">KETERANGAN PENGURUS</th> 
                                        <th rowspan="2" style="width: 15%;">INPUT OLEH</th>
                                    </tr>
                                    <tr>
                                        <th class="p-1 bg-danger text-white">Ngaji</th>
                                        <th class="p-1 bg-danger text-white">Sholat</th>
                                        <th class="p-1 bg-danger text-white">Roan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $absensiRiwayat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rekap): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $totalAlpha = $rekap->total_alpha;
                                            $rowClass = ($totalAlpha >= 5) ? 'table-danger' : ''; 
                                            $totalBadgeClass = ($totalAlpha >= 5) ? 'bg-danger' : (($totalAlpha > 0) ? 'bg-primary' : 'bg-success-subtle text-success-emphasis');
                                        ?>
                                        <tr class="<?php echo e($rowClass); ?>">
                                            <td class="fw-semibold text-dark"><?php echo e($carbonClass::createFromDate($rekap->tahun, $rekap->bulan, 1)->translatedFormat('F Y')); ?></td>
                                            
                                            
                                            <td class="text-center">
                                                <?php if($rekap->ngaji_alpha > 0): ?>
                                                    <span class="badge bg-danger fw-semibold"><?php echo e($rekap->ngaji_alpha); ?></span>
                                                <?php else: ?>
                                                    <span class="text-secondary small">0</span>
                                                <?php endif; ?>
                                            </td>
                                            
                                            
                                            <td class="text-center">
                                                <?php if($rekap->sholat_alpha > 0): ?>
                                                    <span class="badge bg-danger fw-semibold"><?php echo e($rekap->sholat_alpha); ?></span>
                                                <?php else: ?>
                                                    <span class="text-secondary small">0</span>
                                                <?php endif; ?>
                                            </td>

                                            
                                            <td class="text-center">
                                                <?php if($rekap->roan_alpha > 0): ?>
                                                    <span class="badge bg-danger fw-semibold"><?php echo e($rekap->roan_alpha); ?></span>
                                                <?php else: ?>
                                                    <span class="text-secondary small">0</span>
                                                <?php endif; ?>
                                            </td>

                                            
                                            <td class="text-center">
                                                <span class="badge <?php echo e($totalBadgeClass); ?> py-2 px-3 fs-6 fw-bold">
                                                    <?php echo e($totalAlpha); ?>

                                                </span>
                                            </td>

                                            <td class="small text-muted text-wrap">
                                                <?php if($rekap->keterangan): ?>
                                                    <?php echo e(Str::limit($rekap->keterangan, 70)); ?>

                                                <?php else: ?>
                                                    <em class="text-secondary">- Tidak ada catatan -</em>
                                                <?php endif; ?>
                                            </td>

                                            <td class="small text-muted text-center"><?php echo e($rekap->waliInput->name ?? 'Sistem'); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        
                        
                        <div class="list-group d-block d-md-none list-group-rekap-mobile">
                            <?php $__currentLoopData = $absensiRiwayat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rekap): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $cardBorderClass = ($rekap->total_alpha >= 5) ? 'border-danger' : (($rekap->total_alpha > 0) ? 'border-primary' : 'border-success');
                                    $alphaIcon = ($rekap->total_alpha >= 5) ? 'fas fa-frown text-danger' : (($rekap->total_alpha > 0) ? 'fas fa-exclamation-triangle text-warning' : 'fas fa-check-circle text-success');
                                    $totalBadgeClass = ($rekap->total_alpha >= 5) ? 'bg-danger' : (($rekap->total_alpha > 0) ? 'bg-primary' : 'bg-success');
                                ?>
                                
                                <div class="list-group-item list-group-item-action mb-3 p-3 shadow-sm rounded-4 border <?php echo e($cardBorderClass); ?> list-item-custom" aria-current="true">
                                    <div class="d-flex w-100 justify-content-between align-items-center mb-2">
                                        <h6 class="mb-0 fw-bold text-dark">
                                            <i class="<?php echo e($alphaIcon); ?> me-2"></i> 
                                            <?php echo e($carbonClass::createFromDate($rekap->tahun, $rekap->bulan, 1)->translatedFormat('F Y')); ?>

                                        </h6>
                                        <span class="badge <?php echo e($totalBadgeClass); ?> fs-6 py-2 px-3 rounded-pill shadow-sm">
                                            Total: <?php echo e($rekap->total_alpha); ?>

                                        </span>
                                    </div>
                                    <hr class="my-2">
                                    
                                    
                                    <div class="row row-cols-3 text-center small fw-semibold mb-3 detail-alpha-grid">
                                        <div class="col">
                                            Ngaji: 
                                            <span class="badge bg-<?php echo e($rekap->ngaji_alpha > 0 ? 'danger' : 'success-subtle text-success-emphasis'); ?> fw-semibold"><?php echo e($rekap->ngaji_alpha); ?></span>
                                        </div>
                                        <div class="col">
                                            Sholat: 
                                            <span class="badge bg-<?php echo e($rekap->sholat_alpha > 0 ? 'danger' : 'success-subtle text-success-emphasis'); ?> fw-semibold"><?php echo e($rekap->sholat_alpha); ?></span>
                                        </div>
                                        <div class="col">
                                            Roan: 
                                            <span class="badge bg-<?php echo e($rekap->roan_alpha > 0 ? 'danger' : 'success-subtle text-success-emphasis'); ?> fw-semibold"><?php echo e($rekap->roan_alpha); ?></span>
                                        </div>
                                    </div>
                                    
                                    <hr class="my-2">

                                    
                                    <div class="small text-muted">
                                        <p class="mb-1 fw-semibold text-dark">
                                            <i class="fas fa-comment-dots me-1 text-primary"></i> Catatan:
                                        </p>
                                        <p class="mb-0 text-wrap ms-3 fst-italic text-secondary">
                                            <?php echo e($rekap->keterangan ?? 'Tidak ada catatan.'); ?>

                                        </p>
                                        <p class="mb-0 mt-2 text-end small">
                                            <i class="fas fa-user-tag me-1"></i> Input Oleh: <strong class="text-dark"><?php echo e($rekap->waliInput->name ?? 'Sistem'); ?></strong>
                                        </p>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                    <?php else: ?>
                        
                        <div class="alert alert-light text-center py-4 border rounded-4">
                            <i class="fas fa-search-minus me-2 fs-5 text-secondary"></i> 
                            <p class="mb-0 mt-2 fw-semibold">Tidak ditemukan data rekapitulasi Alpha untuk periode ini.</p>
                            <small class="text-muted">Pastikan periode Bulan/Tahun yang dipilih sudah benar.</small>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        
        <div class="col-12">
            <div class="alert alert-danger text-center py-5 shadow-lg rounded-4">
                <i class="fas fa-user-times me-2 fs-3"></i> 
                <p class="mb-0 mt-3 fw-bold fs-5">Tidak ada data santri yang terdaftar di bawah perwalian akun Anda.</p>
                <p class="mb-0 small">Hubungi Admin jika ini adalah kesalahan.</p>
            </div>
        </div>
    <?php endif; ?>
    </div>

    <?php $__env->startPush('css'); ?>
    <style>
        /* Global & Typography */
        body { font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; color: #34495e; background-color: #f4f6f9; }
        :root {
            --bs-primary: #1e88e5; 
            --bs-danger: #e53935;  
            --bs-warning: #ffb300; 
            --bs-success: #43a047; 
            --bs-border-radius: 0.75rem; 
        }
        
        /* General Card & Shadow */
        .card { 
            border: none; 
            border-radius: var(--bs-border-radius); 
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); 
            transition: box-shadow 0.3s ease-in-out; 
        }
        .card-header { 
            border-bottom: none; 
            padding: 1rem 1.5rem; 
            font-size: 1.1rem; 
            font-weight: 700;
        }

        /* Filter Card Styling */
        .filter-card-custom {
             box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08) !important;
        }
        .filter-card-custom .form-select {
            border-color: #ddd;
        }
        .filter-card-custom .reset-btn {
            white-space: nowrap;
        }

        /* Santri Card Specific */
        .card-santri-rekap {
            border-left: 6px solid var(--bs-primary);
        }
        .card-santri-rekap .card-header {
            background-color: var(--bs-primary);
        }
        .card-santri-rekap .action-link:hover {
            background-color: #f0f0f0;
        }

        /* Summary Box Styling */
        .summary-box-danger {
            background-color: #ffebee; /* danger-subtle */
            border: 1px solid #e53935;
        }
        .summary-box-warning {
            background-color: #fff8e1; /* warning-subtle */
            border: 1px solid #ffb300;
        }
        .summary-box-success {
            background-color: #e8f5e9; /* success-subtle */
            border: 1px solid #43a047;
        }
        .summary-alpha-count {
            border-color: rgba(0, 0, 0, 0.1) !important; /* Border pemisah pada desktop */
        }

        /* Table Styling (Desktop) */
        .table-rekap-desktop {
            border: 1px solid #dee2e6;
        }
        .table-rekap-desktop thead th {
            border-color: #343a40 !important;
        }
        .table-rekap-desktop tbody td {
            border-color: #dee2e6;
        }
        .table-rekap-desktop .badge.bg-danger {
            min-width: 25px; /* Kerapian badge angka alpha */
        }
        .bg-success-subtle { background-color: #e8f5e9 !important; } 
        .text-success-emphasis { color: #43a047 !important; }

        /* List Group Styling (Mobile) */
        .list-group-rekap-mobile .list-item-custom {
            border-width: 2px !important;
            transition: transform 0.2s;
        }
        .list-group-rekap-mobile .list-item-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .detail-alpha-grid .badge {
            min-width: 30px;
        }


        /* MEDIA QUERIES */
        @media (min-width: 768px) {
            .border-end-md { border-right: 1px solid !important; }
        }
        
        @media (max-width: 767.98px) {
            .card-header {
                flex-direction: column;
                align-items: flex-start !important;
            }
            .card-santri-rekap .action-link {
                width: 100%;
                margin-top: 1rem !important;
                margin-left: 0 !important;
            }
            .summary-box-danger, .summary-box-warning, .summary-box-success {
                padding: 1rem !important;
            }
            .summary-alpha-count {
                padding-bottom: 1rem;
                border-bottom: 1px solid rgba(0, 0, 0, 0.1) !important;
            }
            .filter-card-custom .btn {
                 font-size: 0.85rem;
            }
        }
    </style>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.wali', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/wali/absensi/index.blade.php ENDPATH**/ ?>