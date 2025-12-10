<?php $__env->startSection('page_title', 'Rekapitulasi Absensi Bulanan'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* Styling Card Modern (General) */
    .card-modern {
        border: none;
        border-radius: 1rem !important;
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08);
    }
    
    /* Warna Aksen Desktop */
    .bg-dark-blue { background-color: #0d47a1 !important; } 
    .bg-danger-alpha-header { background-color: #dc3545 !important; } 
    
    /* --- CUSTOM STYLING UNTUK DESKTOP (Minimalis) --- */
    @media (min-width: 992px) {
        /* Memastikan tombol aksi massal memiliki lebar yang cukup, tidak memanjang */
        .btn-input-massal-desktop {
            min-width: 180px; 
            width: auto !important; 
        }
        
        /* Set lebar spesifik untuk filter */
        .filter-bulan-desktop { width: 150px !important; }
        .filter-tahun-desktop { width: 90px !important; }
    }
    
    /* --- MOBILE STYLING (RESPONSIVE - TABLE TO CARD) --- */
    @media (max-width: 767.98px) {
        /* Menyembunyikan tampilan tabel di bawah 768px */
        .table-responsive table { border: 0; }
        .table-responsive table thead { display: none; }
        
        /* Setiap baris (TR) menjadi blok data terpisah */
        .table-responsive table tr { 
            display: block; 
            margin-bottom: 1rem; 
            border: 1px solid #dee2e6; 
            border-radius: 0.5rem; 
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.03);
            overflow: hidden;
        }
        
        /* Setiap sel (TD) diatur untuk responsif */
        .table-responsive table td { 
            display: block; 
            text-align: right !important; 
            padding-left: 50% !important; 
            position: relative;
            border: none;
            border-bottom: 1px solid #f0f0f0; 
            padding-top: 0.6rem !important;
            padding-bottom: 0.6rem !important;
        }
        
        /* Label Kolom */
        .table-responsive table td:before { 
            content: attr(data-label); 
            position: absolute; 
            left: 0; 
            width: 50%; 
            padding-left: 1rem; 
            font-weight: 600; 
            text-align: left; 
            color: #495057; 
            white-space: nowrap;
            font-size: 0.85rem;
        }
        
        /* Styling Khusus Baris NAMA */
        .td-name {
            background-color: #f8f9fa;
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
            font-weight: 700;
        }
        
        /* Styling Khusus Baris TOTAL ALPHA */
        .td-total-alpha {
            background-color: #fffae0; 
            font-weight: bold;
            color: #212529;
            border-top: 1px solid #ffeeba !important;
            border-bottom: none; 
            font-size: 1.1rem;
        }
        
        /* Styling Khusus Baris Aksi */
        .td-action {
            text-align: center !important;
            border-top: 1px solid #f0f0f0 !important;
            padding: 0.75rem 1rem !important;
            padding-left: 1rem !important;
        }
        .td-action:before {
            content: "";
        }
        .td-keterangan {
            font-style: italic;
            font-size: 0.8rem;
            color: #6c757d;
        }
        
        /* Memastikan tombol aksi massal mengambil lebar penuh di mobile */
        .btn-input-massal-desktop {
             width: 100% !important;
             min-width: auto !important;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<?php
    use Carbon\Carbon;
    $alphaWarningLimit = 3; 

    // Mendefinisikan fungsi helper untuk Action Buttons
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
        <div class=\"d-flex justify-content-end justify-content-md-center gap-1\">
            <a href=\"{$editUrl}\" class=\"btn btn-sm btn-warning rounded-pill px-3 shadow-sm\" title=\"Edit Data Satuan\">
                <i class=\"fas fa-pencil-alt\"></i>
            </a>
            <form action=\"{$deleteUrl}\" method=\"POST\" class=\"d-inline\" onsubmit=\"return confirm('Yakin ingin menghapus REKAPITULASI ALPHA SANTRI {$santriName} bulan ini? Tindakan ini tidak dapat dibatalkan.');\">
                " . csrf_field() . method_field('DELETE') . "
                <button type=\"submit\" class=\"btn btn-sm btn-danger rounded-pill px-3 shadow-sm\" title=\"Hapus Data Satuan\">
                    <i class=\"fas fa-trash-alt\"></i>
                </button>
            </form>
        </div>
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
                        
                        
                        <form method="GET" action="<?php echo e(route('admin.absensi_rekap.index')); ?>" class="w-100 w-lg-auto order-lg-1">
                            
                            <div class="d-flex align-items-center">
                                
                                
                                <select name="bulan" class="form-select form-select-sm fw-semibold me-3 filter-bulan-desktop">
                                    <?php for($m = 1; $m <= 12; $m++): ?>
                                        <option value="<?php echo e($m); ?>" <?php echo e($m == $bulan ? 'selected' : ''); ?>>
                                            <?php echo e(Carbon::create()->month($m)->translatedFormat('F')); ?>

                                        </option>
                                    <?php endfor; ?>
                                </select>
                                
                                
                                <select name="tahun" class="form-select form-select-sm fw-semibold me-3 filter-tahun-desktop">
                                    <?php for($y = Carbon::now()->year; $y >= 2020; $y--): ?>
                                        <option value="<?php echo e($y); ?>" <?php echo e($y == $tahun ? 'selected' : ''); ?>><?php echo e($y); ?></option>
                                    <?php endfor; ?>
                                </select>
                                
                                
                                <button type="submit" class="btn btn-primary btn-sm px-3 flex-shrink-0"><i class="fas fa-search"></i> Cari</button>
                            </div>
                        </form>

                        
                        <a href="<?php echo e(route('admin.absensi_rekap.create_multi', ['bulan' => $bulan, 'tahun' => $tahun])); ?>" class="btn btn-success btn-icon-split shadow rounded-pill px-4 flex-shrink-0 w-lg-auto btn-input-massal-desktop order-lg-2">
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
                        
                        
                        <table class="table table-striped table-bordered align-middle" width="100%" cellspacing="0">
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
                                    $totalCellClass = ($totalAlpha >= $alphaWarningLimit) ? 'bg-danger-subtle fw-bolder text-danger' : 'bg-warning-subtle fw-bolder text-dark'; 
                                    $nameCellClass = ($totalAlpha >= $alphaWarningLimit) ? 'fw-bold text-danger' : 'fw-semibold text-dark'; 
                                ?>
                                <tr>
                                    
                                    <td data-label="No" class="text-center align-middle"><?php echo e($absensis->firstItem() + $index); ?></td>
                                    
                                    
                                    <td data-label="Nama Santri" class="align-middle td-name <?php echo e($nameCellClass); ?>">
                                        <?php echo e(optional($absensi->santri)->nama_lengkap ?? 'N/A'); ?>

                                        <?php if($totalAlpha >= $alphaWarningLimit): ?>
                                            <span class="badge bg-danger rounded-pill ms-1 p-1" title="Perlu Peringatan Keras (Alpha >= <?php echo e($alphaWarningLimit); ?>)">
                                                <i class="fas fa-bell"></i> Peringatan
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    
                                    <td data-label="Kelas" class="text-center align-middle"><?php echo e(optional($absensi->kelas)->nama_kelas ?? '-'); ?></td>
                                    
                                    
                                    <td data-label="Alpha Ngaji" class="text-center align-middle">
                                        <?php if($absensi->ngaji_alpha > 0): ?>
                                            <span class="badge rounded-pill bg-danger p-2"><?php echo e($absensi->ngaji_alpha); ?></span>
                                        <?php else: ?>
                                            <span class="badge rounded-pill text-success border border-success px-2 py-1 small fw-normal">0</span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    
                                    <td data-label="Alpha Sholat" class="text-center align-middle">
                                        <?php if($absensi->sholat_alpha > 0): ?>
                                            <span class="badge rounded-pill bg-danger p-2"><?php echo e($absensi->sholat_alpha); ?></span>
                                        <?php else: ?>
                                            <span class="badge rounded-pill text-success border border-success px-2 py-1 small fw-normal">0</span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    
                                    <td data-label="Alpha Roan" class="text-center align-middle">
                                        <?php if($absensi->roan_alpha > 0): ?>
                                            <span class="badge rounded-pill bg-danger p-2"><?php echo e($absensi->roan_alpha); ?></span>
                                        <?php else: ?>
                                            <span class="badge rounded-pill text-success border border-success px-2 py-1 small fw-normal">0</span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    
                                    <td data-label="TOTAL ALPHA" class="text-center align-middle td-total-alpha <?php echo e($totalCellClass); ?>">
                                        <span class="fs-6"><?php echo e($totalAlpha); ?></span>
                                    </td>

                                    
                                    <td data-label="Keterangan" class="small align-middle text-muted td-keterangan"><?php echo e($absensi->keterangan ?? '-'); ?></td>

                                    
                                    <td data-label="Aksi" class="align-middle text-nowrap td-action">
                                        <?php renderActionButtons($absensi) ?> 
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