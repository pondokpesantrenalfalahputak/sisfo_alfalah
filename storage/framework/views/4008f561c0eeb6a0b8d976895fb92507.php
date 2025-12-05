 

<?php $__env->startSection('title', 'Rekapitulasi Absensi Bulanan'); ?>
<?php $__env->startSection('page_title', 'Rekapitulasi Absensi Bulanan'); ?>

<?php $__env->startSection('content'); ?>

    
    <?php
        // Pastikan Carbon sudah di-import/digunakan (asumsi di layout/Controller sudah ada use Carbon\Carbon)
        $bulanFilter = request('bulan', \Carbon\Carbon::now()->month);
        $tahunFilter = request('tahun', \Carbon\Carbon::now()->year);
        $isFiltered = request()->has('bulan') || request()->has('tahun');
        
        // Setup Carbon untuk mendapatkan nama bulan
        $carbonClass = \Carbon\Carbon::class; // Untuk referensi di Blade
    ?>

    <div class="row">
        
        <div class="col-12 mb-5">
            <div class="card border-0 shadow-sm rounded-4 bg-light p-4">
                <form method="GET" action="<?php echo e(route('wali.absensi.index')); ?>" class="row g-3 align-items-center">
                    <div class="col-12">
                        <h6 class="mb-0 fw-bold text-primary">
                            <i class="fas fa-calendar-alt me-2"></i> Filter Periode Absensi
                        </h6>
                    </div>
                    
                    <div class="col-sm-4 col-6">
                        <select name="bulan" class="form-select form-select-sm rounded-pill shadow-sm">
                            <?php for($m = 1; $m <= 12; $m++): ?>
                                <option value="<?php echo e($m); ?>" <?php echo e((string)$m === (string)$bulanFilter ? 'selected' : ''); ?>>
                                    <?php echo e($carbonClass::create()->month($m)->translatedFormat('F')); ?>

                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-sm-3 col-6">
                        <select name="tahun" class="form-select form-select-sm rounded-pill shadow-sm">
                            <?php for($y = $carbonClass::now()->year; $y >= 2020; $y--): ?>
                                <option value="<?php echo e($y); ?>" <?php echo e((string)$y === (string)$tahunFilter ? 'selected' : ''); ?>><?php echo e($y); ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    
                    <div class="col-sm-5 col-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary btn-sm me-2 flex-fill rounded-pill shadow">
                            <i class="fas fa-check me-1"></i> Terapkan
                        </button>
                        <?php if($isFiltered): ?>
                            <a href="<?php echo e(route('wali.absensi.index')); ?>" class="btn btn-outline-secondary btn-sm rounded-pill shadow-sm">Reset</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="row">
    <?php $__empty_1 = true; $__currentLoopData = $santriList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $santri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="col-lg-12 mb-5">
            
            
            <div class="card border-0 shadow-lg mb-4 rounded-4">
                
                <div class="card-header bg-primary text-white d-flex flex-column flex-md-row align-items-md-center py-3 px-4 rounded-top-4">
                    <div class="d-flex align-items-center mb-2 mb-md-0">
                        <i class="fas fa-graduation-cap me-3 fs-3"></i>
                        <div>
                            <h5 class="mb-0 fw-bolder"><?php echo e(strtoupper($santri->nama_lengkap)); ?></h5> 
                            <small class="badge bg-light text-primary fw-semibold rounded-pill"><?php echo e($santri->kelas->nama_kelas ?? 'Kelas N/A'); ?> | NISN: <?php echo e($santri->nisn); ?></small>
                        </div>
                    </div>
                    
                    
                    <a href="<?php echo e(route('wali.absensi.show', $santri->id)); ?>" class="btn btn-md btn-light text-primary ms-md-auto fw-bold rounded-pill shadow-sm">
                        <i class="fas fa-calendar-day me-1"></i> Lihat Absensi Harian
                    </a>
                </div>
                
                <div class="card-body p-4">

                    
                    <?php
                        $absensiRiwayat = $santri->absensiRekapitulasi; 
                        
                        $totalAlphaKumulatif = $absensiRiwayat->sum('ngaji_alpha') + 
                                               $absensiRiwayat->sum('sholat_alpha') + 
                                               $absensiRiwayat->sum('roan_alpha');
                        
                        $statusClass = $totalAlphaKumulatif >= 5 ? 'danger' : ($totalAlphaKumulatif > 0 ? 'warning' : 'success');
                        $statusIcon = $totalAlphaKumulatif >= 5 ? 'fas fa-exclamation-triangle' : ($totalAlphaKumulatif > 0 ? 'fas fa-exclamation-circle' : 'fas fa-check-circle');
                    ?>

                    <div class="mb-5 p-4 rounded-4 border border-<?php echo e($statusClass); ?> bg-<?php echo e($statusClass); ?> bg-opacity-10 shadow-sm">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-4 text-center border-end-md">
                                <span class="fw-bolder display-4 text-<?php echo e($statusClass); ?>"><?php echo e($totalAlphaKumulatif); ?></span>
                                <p class="text-muted mb-0 small text-uppercase mt-1 fw-bold">
                                    Total ALPHA 
                                </p>
                                <p class="badge bg-<?php echo e($statusClass); ?> mt-1 px-3">
                                    <?php if($isFiltered): ?> Bulan Ini <?php else: ?> Kumulatif <?php endif; ?>
                                </p>
                            </div>
                            <div class="col-12 col-md-8 mt-3 mt-md-0">
                                <p class="small mb-0 text-<?php echo e($statusClass); ?> fw-bolder fs-6">
                                    <i class="<?php echo e($statusIcon); ?> me-2"></i> 
                                    <?php if($totalAlphaKumulatif >= 5): ?>
                                        Perlu Tindakan Cepat (Di atas batas toleransi)
                                    <?php elseif($totalAlphaKumulatif > 0): ?>
                                        Ada Catatan Alpha Bulan Ini/Kumulatif
                                    <?php else: ?>
                                        Disiplin Sangat Baik
                                    <?php endif; ?>
                                </p>
                                <p class="text-secondary small mt-1 mb-0">Rincian ketidakdisiplinan yang tercatat pada periode yang dipilih.</p>
                            </div>
                        </div>
                    </div>
                    
                    <h6 class="fw-bold mb-4 mt-3 text-dark border-bottom pb-2">
                        <i class="fas fa-history me-2 text-secondary"></i> Riwayat Absensi Bulanan
                    </h6>

                    
                    
                    <?php if($absensiRiwayat->count() > 0): ?>
                        
                        
                        <div class="table-responsive d-none d-md-block">
                             <table class="table table-bordered table-striped table-sm small table-hover align-middle rounded-3 overflow-hidden" width="100%" cellspacing="0">
                                <thead class="table-dark text-center">
                                    <tr>
                                        <th rowspan="2" style="width: 15%;">PERIODE</th>
                                        <th colspan="3" class="bg-danger">RINCIAN ALPHA (Hari)</th>
                                        <th rowspan="2" class="bg-primary text-white" style="width: 8%;">TOTAL</th>
                                        <th rowspan="2" style="width: 30%;">KETERANGAN PENGURUS</th> 
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
                                            $totalClass = ($rekap->total_alpha > 0) ? 'bg-primary text-white fw-bold' : 'text-success fw-bold';
                                            $rowClass = ($rekap->total_alpha > 5) ? 'table-danger' : ''; 
                                        ?>
                                        <tr class="<?php echo e($rowClass); ?>">
                                            <td class="fw-semibold"><?php echo e($carbonClass::createFromDate($rekap->tahun, $rekap->bulan, 1)->translatedFormat('F Y')); ?></td>
                                            
                                            <td class="text-center">
                                                <?php if($rekap->ngaji_alpha > 0): ?>
                                                    <span class="badge bg-danger p-2"><?php echo e($rekap->ngaji_alpha); ?></span>
                                                <?php else: ?>
                                                    <span class="text-secondary small">0</span>
                                                <?php endif; ?>
                                            </td>
                                            
                                            <td class="text-center">
                                                <?php if($rekap->sholat_alpha > 0): ?>
                                                    <span class="badge bg-danger p-2"><?php echo e($rekap->sholat_alpha); ?></span>
                                                <?php else: ?>
                                                    <span class="text-secondary small">0</span>
                                                <?php endif; ?>
                                            </td>

                                            <td class="text-center">
                                                <?php if($rekap->roan_alpha > 0): ?>
                                                    <span class="badge bg-danger p-2"><?php echo e($rekap->roan_alpha); ?></span>
                                                <?php else: ?>
                                                    <span class="text-secondary small">0</span>
                                                <?php endif; ?>
                                            </td>

                                            <td class="text-center <?php echo e($totalClass); ?> border-start border-white">
                                                <strong class="fs-6"><?php echo e($rekap->total_alpha); ?></strong>
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
                        
                        
                        <div class="list-group d-block d-md-none">
                            <?php $__currentLoopData = $absensiRiwayat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rekap): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $cardBorderClass = ($rekap->total_alpha >= 5) ? 'border-danger' : (($rekap->total_alpha > 0) ? 'border-warning' : 'border-success');
                                    $alphaIcon = ($rekap->total_alpha >= 5) ? 'fas fa-frown text-danger' : (($rekap->total_alpha > 0) ? 'fas fa-exclamation-triangle text-warning' : 'fas fa-star text-success');
                                ?>
                                
                                <div class="list-group-item list-group-item-action mb-3 p-3 shadow-sm rounded-3 border <?php echo e($cardBorderClass); ?>" aria-current="true">
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <h6 class="mb-1 fw-bold">
                                            <i class="<?php echo e($alphaIcon); ?> me-2"></i> 
                                            <?php echo e($carbonClass::createFromDate($rekap->tahun, $rekap->bulan, 1)->translatedFormat('F Y')); ?>

                                        </h6>
                                        <span class="badge bg-primary fs-6 py-2 px-3 rounded-pill shadow-sm">
                                            Total: <?php echo e($rekap->total_alpha); ?>

                                        </span>
                                    </div>
                                    <hr class="my-2">
                                    
                                    
                                    <div class="row row-cols-3 text-center small fw-semibold mb-3">
                                        <div class="col">
                                            Ngaji: 
                                            <span class="badge bg-<?php echo e($rekap->ngaji_alpha > 0 ? 'danger' : 'success'); ?>"><?php echo e($rekap->ngaji_alpha); ?></span>
                                        </div>
                                        <div class="col">
                                            Sholat: 
                                            <span class="badge bg-<?php echo e($rekap->sholat_alpha > 0 ? 'danger' : 'success'); ?>"><?php echo e($rekap->sholat_alpha); ?></span>
                                        </div>
                                        <div class="col">
                                            Roan: 
                                            <span class="badge bg-<?php echo e($rekap->roan_alpha > 0 ? 'danger' : 'success'); ?>"><?php echo e($rekap->roan_alpha); ?></span>
                                        </div>
                                    </div>
                                    
                                    <hr class="my-2">

                                    
                                    <div class="small text-muted">
                                        <p class="mb-1 fw-semibold text-dark">
                                            <i class="fas fa-comment-dots me-1 text-primary"></i> Keterangan Pengurus:
                                        </p>
                                        <p class="mb-0 text-wrap ms-3 fst-italic">
                                            <?php echo e($rekap->keterangan ?? 'Tidak ada catatan.'); ?>

                                        </p>
                                        <p class="mb-0 mt-2 text-end">
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.wali', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/wali/absensi/index.blade.php ENDPATH**/ ?>