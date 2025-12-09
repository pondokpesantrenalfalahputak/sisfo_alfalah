<?php $__env->startSection('page_title', 'Rekapitulasi Absensi Bulanan'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* Styling Card Modern */
    .card-modern {
        border: none;
        border-radius: 1rem !important;
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08);
    }
    
    /* Warna Aksen */
    .bg-dark-blue { background-color: #0d47a1 !important; } 
    /* Mengubah nama kelas ini agar lebih generik untuk latar merah */
    .bg-danger-alpha-header { background-color: #dc3545 !important; } 
    
    /* Mobile Styling (Sudah Baik) */
    @media (max-width: 767.98px) {
        .table-responsive table { border: 0; }
        .table-responsive table thead { display: none; }
        .table-responsive table tr { display: block; margin-bottom: 0.8rem; border: 1px solid #dee2e6; border-radius: 0.5rem; }
        .table-responsive table td { display: block; text-align: right !important; padding-left: 50% !important; position: relative; }
        .table-responsive table td:before { content: attr(data-label); position: absolute; left: 0; width: 50%; padding-left: 1rem; font-weight: 600; text-align: left; color: #495057; }
        .mobile-label-alpha { background-color: #f8d7da; font-weight: bold !important; }
        .mobile-label-total { background-color: #ffc107; color: #212529; font-weight: bold !important; }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<?php
    use Carbon\Carbon;
    $alphaWarningLimit = 3; 

    // Mendefinisikan fungsi helper untuk Action Buttons (Refactored untuk penataan)
    function renderActionButtons($absensi) {
        $santriName = optional($absensi->santri)->nama_lengkap ?? 'Santri Tidak Dikenal'; 
        
        // URL Edit
        $editUrl = route('admin.absensi_rekap.create_multi', [
            'bulan' => $absensi->bulan, 
            'tahun' => $absensi->tahun, 
            'kelas_id' => $absensi->kelas_id,
            'santri_id' => $absensi->santri_id 
        ]);

        // URL Delete
        $deleteUrl = route('admin.absensi_rekap.destroy', $absensi->id);

        echo "
        <a href=\"{$editUrl}\" class=\"btn btn-sm btn-warning rounded-pill px-3 shadow-sm\" title=\"Edit Data Satuan\">
            <i class=\"fas fa-pencil-alt\"></i>
        </a>
        <form action=\"{$deleteUrl}\" method=\"POST\" class=\"d-inline\" onsubmit=\"return confirm('Yakin ingin menghapus REKAPITULASI ALPHA SANTRI {$santriName} bulan ini? Tindakan ini tidak dapat dibatalkan.');\">
            " . csrf_field() . method_field('DELETE') . "
            <button type=\"submit\" class=\"btn btn-sm btn-danger rounded-pill px-3 shadow-sm\" title=\"Hapus Data Satuan\">
                <i class=\"fas fa-trash-alt\"></i>
            </button>
        </form>
        ";
    }
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <div class="card card-modern mb-4">
                
                
                <div class="card-header py-4 bg-white border-bottom-0 rounded-top-4">
                    
                    
                    <h4 class="m-0 font-weight-bold text-dark text-center pb-3 border-bottom border-light">
                        <i class="fas fa-calendar-alt text-primary me-2"></i> Rekap Alpha: <span class="text-primary"><?php echo e(Carbon::createFromDate($tahun, $bulan)->translatedFormat('F Y')); ?></span>
                    </h4>
                    
                    
                    <div class="d-flex justify-content-between align-items-center flex-column flex-lg-row pt-3 gap-3">
                        
                        
                        <form method="GET" action="<?php echo e(route('admin.absensi_rekap.index')); ?>" class="d-flex flex-wrap justify-content-center align-items-center gap-2 p-0 w-100 w-lg-auto">
                            
                            <strong class="me-lg-1 text-dark small text-nowrap d-none d-lg-block">Filter Bulan:</strong>
                            
                            <select name="bulan" class="form-select form-select-sm fw-semibold flex-grow-1">
                                <?php for($m = 1; $m <= 12; $m++): ?>
                                    <option value="<?php echo e($m); ?>" <?php echo e($m == $bulan ? 'selected' : ''); ?>>
                                        <?php echo e(Carbon::create()->month($m)->translatedFormat('F')); ?>

                                    </option>
                                <?php endfor; ?>
                            </select>
                            <select name="tahun" class="form-select form-select-sm fw-semibold" style="width: 100px;">
                                <?php for($y = Carbon::now()->year; $y >= 2020; $y--): ?>
                                    <option value="<?php echo e($y); ?>" <?php echo e($y == $tahun ? 'selected' : ''); ?>><?php echo e($y); ?></option>
                                <?php endfor; ?>
                            </select>
                            <button type="submit" class="btn btn-primary btn-sm px-3 flex-shrink-0"><i class="fas fa-search"></i> Cari</button>
                        </form>

                        
                        <a href="<?php echo e(route('admin.absensi_rekap.create_multi', ['bulan' => $bulan, 'tahun' => $tahun])); ?>" class="btn btn-success btn-icon-split shadow rounded-pill px-4 flex-shrink-0 w-100 w-lg-auto">
                            <span class="text fw-bold">
                                <i class="fas fa-edit me-1"></i> Input/Edit Massal
                            </span>
                        </a>
                    </div>
                </div>
                

                <div class="card-body p-4">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success rounded-3 shadow-sm"><i class="fas fa-check-circle me-1"></i> <?php echo e(session('success')); ?></div>
                    <?php endif; ?>
                    <?php if(session('error')): ?>
                        <div class="alert alert-danger rounded-3 shadow-sm"><i class="fas fa-times-circle me-1"></i> <?php echo e(session('error')); ?></div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        
                        
                        <table class="table table-striped table-bordered align-middle d-none d-md-table" width="100%" cellspacing="0">
                            <thead class="bg-dark-blue text-white text-center shadow-sm">
                                <tr>
                                    <th rowspan="2" class="align-middle text-nowrap" style="width: 5%;">No</th>
                                    <th rowspan="2" class="align-middle text-start text-nowrap" style="min-width: 180px;">Nama Santri</th>
                                    <th rowspan="2" class="align-middle text-center text-nowrap" style="width: 8%;">Kelas</th>
                                    <th colspan="4" class="text-center bg-danger-alpha-header">Jumlah Alpha (Hari)</th>
                                    <th rowspan="2" class="align-middle text-center" style="width: 15%;">Keterangan</th>
                                    <th rowspan="2" class="align-middle text-center text-nowrap" style="width: 10%;">Aksi</th>
                                </tr>
                                <tr>
                                    <th class="align-middle text-start text-nowrap" title="Alpha Ngaji (Tidak Hadir)"><i class="fas fa-book-open me-1"></i> Ngaji</th>
                                    <th class="align-middle text-start text-nowrap" title="Alpha Sholat (Tidak Ikut Sholat Wajib/Sunnah)"><i class="fas fa-mosque me-1"></i> Sholat</th>
                                    <th class="align-middle text-start text-nowrap" title="Alpha Roan (Tidak Ikut Kerja Bakti)"><i class="fas fa-broom me-1"></i> Roan</th>
                                    <th class="text-center p-2 bg-warning text-dark fw-bolder text-nowrap" style="width: 8%;"><i class="fas fa-star me-1"></i> Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $absensis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $absensi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php
                                    $totalAlpha = $absensi->ngaji_alpha + $absensi->sholat_alpha + $absensi->roan_alpha;
                                    // Highlight hanya total alpha cell, bukan seluruh baris (table-striped yang bekerja)
                                    $totalCellClass = ($totalAlpha >= $alphaWarningLimit) ? 'bg-danger-subtle fw-bolder text-danger' : 'bg-warning-subtle fw-bolder text-dark'; 
                                    $nameCellClass = ($totalAlpha >= $alphaWarningLimit) ? 'fw-bold text-danger' : 'fw-semibold text-dark'; 
                                ?>
                                <tr>
                                    <td class="text-center align-middle"><?php echo e($absensis->firstItem() + $index); ?></td>
                                    <td class="align-middle <?php echo e($nameCellClass); ?>">
                                        <?php echo e(optional($absensi->santri)->nama_lengkap ?? 'N/A'); ?>

                                        <?php if($totalAlpha >= $alphaWarningLimit): ?>
                                            
                                            <span class="badge bg-danger rounded-pill ms-1 p-1" title="Perlu Peringatan Keras (Alpha >= <?php echo e($alphaWarningLimit); ?>)">
                                                <i class="fas fa-bell"></i> Peringatan
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center align-middle"><?php echo e(optional($absensi->kelas)->nama_kelas ?? '-'); ?></td>
                                    
                                    
                                    <td class="text-center align-middle">
                                        <?php if($absensi->ngaji_alpha > 0): ?>
                                            <span class="badge rounded-pill bg-danger p-2"><?php echo e($absensi->ngaji_alpha); ?></span>
                                        <?php else: ?>
                                            <span class="badge rounded-pill text-success border border-success px-2 py-1 small fw-normal">0</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center align-middle">
                                        <?php if($absensi->sholat_alpha > 0): ?>
                                            <span class="badge rounded-pill bg-danger p-2"><?php echo e($absensi->sholat_alpha); ?></span>
                                        <?php else: ?>
                                            <span class="badge rounded-pill text-success border border-success px-2 py-1 small fw-normal">0</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center align-middle">
                                        <?php if($absensi->roan_alpha > 0): ?>
                                            <span class="badge rounded-pill bg-danger p-2"><?php echo e($absensi->roan_alpha); ?></span>
                                        <?php else: ?>
                                            <span class="badge rounded-pill text-success border border-success px-2 py-1 small fw-normal">0</span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    
                                    <td class="text-center align-middle <?php echo e($totalCellClass); ?>">
                                        <span class="fs-6"><?php echo e($totalAlpha); ?></span>
                                    </td>

                                    
                                    <td class="small align-middle text-muted"><?php echo e($absensi->keterangan ?? '-'); ?></td>

                                    
                                    <td class="text-center align-middle text-nowrap">
                                        <div class="d-flex justify-content-center gap-1">
                                            <?php renderActionButtons($absensi) ?> 
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="9" class="text-center p-4 bg-light">
                                        <i class="fas fa-search-minus me-1 fa-3x text-info mb-2"></i><br>
                                        <h6 class="fw-bold">Data rekapitulasi Alpha tidak ditemukan.</h6>
                                        <p class="small mb-0">Silakan periksa filter bulan/tahun atau input data menggunakan tombol Input/Edit Massal.</p>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        
                        
                        <div class="d-md-none">
                            <?php $__empty_1 = true; $__currentLoopData = $absensis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $absensi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $totalAlpha = $absensi->ngaji_alpha + $absensi->sholat_alpha + $absensi->roan_alpha;
                                $cardClass = ($totalAlpha >= $alphaWarningLimit) ? 'border-danger shadow-lg' : 'border-light shadow-sm';
                                $alphaBg = ($totalAlpha >= $alphaWarningLimit) ? 'bg-danger text-white' : 'bg-warning text-dark';
                            ?>
                            <div class="card <?php echo e($cardClass); ?> mb-3 rounded-3 border-start border-5 p-2">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2 border-bottom pb-2">
                                        <h6 class="mb-0 fw-bold text-dark">
                                            <?php echo e($absensis->firstItem() + $index); ?>. <?php echo e(optional($absensi->santri)->nama_lengkap ?? 'N/A'); ?>

                                            <?php if($totalAlpha >= $alphaWarningLimit): ?>
                                                <i class="fas fa-exclamation-circle text-danger ms-1" title="Perlu Peringatan"></i>
                                            <?php endif; ?>
                                        </h6>
                                        <span class="badge bg-primary rounded-pill fw-bold"><?php echo e(optional($absensi->kelas)->nama_kelas ?? 'Non-Kelas'); ?></span>
                                    </div>

                                    <div class="row g-2">
                                        
                                        <div class="col-4">
                                            <div class="p-2 text-center rounded <?php echo e($alphaBg); ?>">
                                                <small class="d-block text-uppercase fw-semibold opacity-75">Total</small>
                                                <span class="fw-bolder fs-5"><?php echo e($totalAlpha); ?></span>
                                            </div>
                                        </div>
                                        
                                        <div class="col-8">
                                            <div class="d-flex justify-content-around text-center h-100 align-items-center">
                                                <div class="flex-fill border-end pe-2">
                                                    <small class="d-block fw-semibold text-muted small"><i class="fas fa-book-open"></i></small>
                                                    <span class="badge bg-danger"><?php echo e($absensi->ngaji_alpha); ?></span>
                                                </div>
                                                <div class="flex-fill border-end px-2">
                                                    <small class="d-block fw-semibold text-muted small"><i class="fas fa-mosque"></i></small>
                                                    <span class="badge bg-danger"><?php echo e($absensi->sholat_alpha); ?></span>
                                                </div>
                                                <div class="flex-fill ps-2">
                                                    <small class="d-block fw-semibold text-muted small"><i class="fas fa-broom"></i></small>
                                                    <span class="badge bg-danger"><?php echo e($absensi->roan_alpha); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <p class="small text-muted mt-3 mb-2 border-top pt-2">
                                        <span class="fw-semibold"><i class="fas fa-comment-dots me-1"></i> Ket:</span> <?php echo e($absensi->keterangan ?? '-'); ?>

                                    </p>
                                    
                                    
                                    <div class="d-flex justify-content-end gap-2 mt-2">
                                        <?php renderActionButtons($absensi) ?>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="p-4 text-center text-muted bg-light rounded-4 border border-dashed border-secondary">
                                <i class="fas fa-info-circle me-1 fa-3x text-info mb-2"></i><br>
                                <h6 class="fw-bold">Tidak ada data rekapitulasi Alpha.</h6>
                                <p class="small mb-0">Silakan pilih bulan/tahun lain atau klik tombol Input/Edit Rekap Massal di atas.</p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end mt-3">
                        <?php echo e($absensis->links()); ?>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/admin/absensi_rekap/index.blade.php ENDPATH**/ ?>