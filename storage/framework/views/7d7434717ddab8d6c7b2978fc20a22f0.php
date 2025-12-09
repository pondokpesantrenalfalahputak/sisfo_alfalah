<?php $__env->startPush('styles'); ?>
<style>
    /* === 1. KUSTOMISASI WARNA UTAMA (SOFT TEAL/BLUE) === */
    :root {
        --primary-accent: #00897b; /* Teal Gelap */
        --primary-light: #e0f2f1; /* Teal Sangat Muda */
        --alpha-color: #d32f2f; /* Merah Alpha */
        --alpha-light: #ffcdd2; /* Merah Muda Alpha */
        --dark-text: #212529;
    }
    
    .bg-primary-custom { background-color: var(--primary-accent) !important; }
    .text-primary-custom { color: var(--primary-accent) !important; }

    /* === 2. STYLE CARD & GENERAL LAYOUT === */
    .card-modern {
        border: 1px solid #e0e0e0; 
        border-radius: 1rem; 
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); 
    }
    
    .card-header-modern {
        background-color: #f7f9fc;
        border-bottom: 1px solid #eeeeee;
        border-radius: 1rem 1rem 0 0;
    }

    /* Input Style Khusus Alpha: Ringkas dan Tegas */
    .alpha-input {
        max-width: 60px !important; 
        padding: 0.2rem 0.1rem;
        height: 30px; 
        font-size: 0.85rem;
        font-weight: 700;
        text-align: center;
        border: 1px solid var(--alpha-color); 
        transition: all 0.2s;
        border-radius: 0.3rem; 
        background-color: #fff8f8; 
    }
    .alpha-input:focus {
        border-color: var(--alpha-color);
        box-shadow: 0 0 0 0.2rem rgba(211, 47, 47, 0.2); 
        background-color: #ffffff;
    }
    
    /* Header Tabel */
    .table thead th {
        border: 1px solid rgba(255, 255, 255, 0.2);
        white-space: nowrap; /* Pastikan header tidak pecah */
    }
    .header-col-alpha {
        background-color: var(--alpha-color) !important; 
    }
    .header-col-main {
        background-color: var(--primary-accent) !important;
    }
    
    /* Notifikasi Alpha Tersimpan */
    .row-alpha-exist {
        background-color: var(--alpha-light);
        border-left: 4px solid var(--alpha-color);
    }
    
    /* Filter Section */
    .filter-card {
        background-color: var(--primary-light);
        border: 1px solid var(--primary-accent);
        border-radius: 0.75rem;
        padding: 1rem !important; 
    }
    
    /* Sticky Footer */
    .sticky-bottom-custom {
        position: sticky;
        bottom: 0;
        z-index: 10;
        box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.15); /* Bayangan lebih tegas */
    }

    /* === 3. MOBILE OPTIMIZATION (V2: MODERNIZED) === */
    @media (max-width: 767.98px) {
        
        /* 3.1 TYPOGRAPHY & SPACING */
        h2 {
            font-size: 1.5rem !important; 
            margin-bottom: 1.5rem !important; /* Spacing lebih baik di bawah judul utama */
            font-weight: 900 !important; /* Lebih tegas */
        }
        .card-body {
            padding: 1rem !important;
        }
        .card-header-modern h4 {
            font-size: 1.1rem !important; 
            font-weight: 700 !important;
        }
        
        /* 3.2 FILTER SECTION (Stacked & Full Width Selects) */
        .filter-card {
            padding: 1rem !important; 
            margin-bottom: 1.5rem !important;
        }
        .filter-card h6 {
             font-size: 0.95rem; 
             margin-bottom: 1rem !important;
        }
        .filter-card .form-label {
            font-size: 0.8rem;
            margin-bottom: 0.2rem;
            font-weight: 600;
            color: var(--dark-text);
        }
        /* Memastikan dropdown filter menggunakan lebar penuh untuk kemudahan klik */
        .filter-card .col-12 {
            margin-bottom: 0.75rem;
        }
        .filter-card .col-lg-4.col-12 { /* Tombol Rekap Induk */
             margin-top: 0.75rem; 
             text-align: right;
        }
        
        /* 3.3 TABLE INPUT OPTIMIZATION */
        
        /* Mengatasi lebar minimum tabel */
        .table-responsive table {
            min-width: 700px; /* Diperluas sedikit untuk menampung teks */
            font-size: 0.85rem; 
        }

        /* Input Alpha: Tegas dan Terpusat */
        .table-responsive .alpha-input {
            max-width: 50px !important; /* Sedikit lebih kecil */
            padding: 0.1rem;
            height: 26px; /* Tinggi input lebih rendah */
            font-size: 0.8rem;
        }
        
        /* Input Keterangan: Lebih Ringkas */
        .col-keterangan input {
             padding: 0.2rem 0.4rem !important;
             font-size: 0.8rem !important;
        }
        
        /* Header Data Santri (Ringkas) */
        h5.mb-3 {
            font-size: 1.1rem !important;
            font-weight: 700 !important;
            margin-bottom: 0.75rem !important;
            padding-bottom: 0.5rem !important;
        }
        h5.mb-3 small {
            font-size: 0.7rem !important; /* Perkecil tanggal/periode */
            display: block !important;
            margin-top: 0.2rem;
            margin-left: 0 !important;
        }

        /* Sticky Footer */
        .sticky-bottom-custom {
            padding: 0.75rem 1rem !important;
            background-color: #ffffff;
        }
        .btn-save-mobile {
            font-size: 0.85rem !important; 
            padding: 0.5rem 1.2rem !important; 
        }
        .btn-filter-mobile {
            font-size: 0.85rem !important;
            padding: 0.5rem 1.2rem !important;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-modern mb-2">
                
                <div class="card-header-modern py-3">
                    <h4 class="m-0 fw-bolder text-dark pb-2 border-bottom border-secondary border-opacity-20">
                        <i class="me-4 text-primary-custom"></i> Rekap Alpha Bulanan
                    </h4>
                </div>

                <div class="card-body p-4">
                    
                    
                    <div class="mb-4 filter-card shadow-sm">
                        <h6 class="fw-bold text-dark mb-3"><i class="fas fa-filter me-2 text-primary-custom"></i> Filter Periode & Kelas</h6>
                        
                        <form method="GET" action="<?php echo e(route('admin.absensi_rekap.create_multi')); ?>" id="filter-form">
                            <div class="row g-3 align-items-end">
                                
                                
                                <div class="col-lg-3 col-md-4 col-12">
                                    <label for="bulan" class="form-label small fw-semibold">Pilih Bulan</label>
                                    <select name="bulan" id="bulan" class="form-select form-select-sm rounded-3" required onchange="this.form.submit()">
                                        <?php for($m = 1; $m <= 12; $m++): ?>
                                            <option value="<?php echo e($m); ?>" <?php echo e($m == $bulan ? 'selected' : ''); ?>>
                                                <?php echo e(\Carbon\Carbon::create()->month($m)->translatedFormat('F')); ?>

                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                
                                
                                <div class="col-lg-2 col-md-3 col-12">
                                    <label for="tahun" class="form-label small fw-semibold">Pilih Tahun</label>
                                    <select name="tahun" id="tahun" class="form-select form-select-sm rounded-3" required onchange="this.form.submit()">
                                        <?php for($y = Carbon\Carbon::now()->year; $y >= 2020; $y--): ?>
                                            <option value="<?php echo e($y); ?>" <?php echo e($y == $tahun ? 'selected' : ''); ?>><?php echo e($y); ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                
                                
                                <div class="col-lg-3 col-md-5 col-12">
                                    <label for="kelas_id" class="form-label small fw-semibold">Pilih Kelas</label>
                                    <select name="kelas_id" id="kelas_id" class="form-select form-select-sm rounded-3" required onchange="this.form.submit()">
                                        <option value="">-- Pilih Kelas --</option>
                                        <?php $__currentLoopData = $kelasOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kelas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($kelas->id); ?>" <?php echo e($kelas->id == $kelasId ? 'selected' : ''); ?>>
                                                <?php echo e($kelas->nama_kelas); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                
                                
                                <div class="col-lg-4 col-12 d-flex justify-content-end justify-content-lg-start mt-lg-0 mt-3">
                                    <a href="<?php echo e(route('admin.absensi_rekap.index')); ?>" class="btn btn-secondary btn-sm rounded-pill px-4 fw-semibold btn-filter-mobile">
                                         <i class="fas fa-list-alt me-1"></i> Rekap Induk
                                    </a>
                                </div>
                            </div>
                            <button type="submit" hidden></button> 
                        </form>
                    </div>
                    

                    <?php if(session('success')): ?>
                        <div class="alert alert-success rounded-3 shadow-sm small"><i class="fas fa-check-circle me-1"></i> <?php echo e(session('success')); ?></div>
                    <?php endif; ?>
                    <?php if(session('error')): ?>
                        <div class="alert alert-danger rounded-3 shadow-sm small"><i class="fas fa-times-circle me-1"></i> <?php echo e(session('error')); ?></div>
                    <?php endif; ?>

                    
                    <?php if($kelasId && isset($santris) && $santris->isNotEmpty()): ?>
                        
                        
                        <h5 class="mb-3 text-dark fw-bold border-bottom pb-2">
                            <i class="fas fa-user-friends me-2 text-primary-custom"></i> Data Santri Kelas 
                            <span class="text-primary-custom"><?php echo e($kelasOptions->find($kelasId)->nama_kelas ?? 'N/A'); ?></span>
                            <small class="text-muted ms-3 fs-6">(<?php echo e(Carbon\Carbon::createFromDate($tahun, $bulan)->translatedFormat('F Y')); ?>)</small>
                        </h5>
                        
                        
                        <div class="alert small p-3 shadow-sm border-start border-1 border-danger bg-light rounded-4 mb-4">
                            <i class="fas fa-exclamation-triangle me-1 text-danger"></i>Perhatian: Isi kolom dengan jumlah hari Alpha. Gunakan 0 jika tidak ada.
                        </div>
                        
                        
                        <form method="POST" action="<?php echo e(route('admin.absensi_rekap.store_multi')); ?>">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="bulan" value="<?php echo e($bulan); ?>">
                            <input type="hidden" name="tahun" value="<?php echo e($tahun); ?>">
                            <input type="hidden" name="kelas_id" value="<?php echo e($kelasId); ?>">

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-sm align-middle w-100" cellspacing="0">
                                    <thead class="text-white text-center">
                                        <tr>
                                            <th rowspan="2" class="align-middle text-center text-nowrap header-col-main col-no">No</th>
                                            <th rowspan="2" class="align-middle text-start text-nowrap header-col-main col-nama">Nama Santri</th>
                                            <th colspan="3" class="text-center text-white header-col-alpha">Alpha (Hari)</th>
                                            <th rowspan="2" class="align-middle text-nowrap header-col-main col-keterangan">Keterangan Tambahan</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center text-white text-nowrap header-col-alpha col-alpha">Ngaji</th>
                                            <th class="text-center text-white text-nowrap header-col-alpha col-alpha">Sholat</th>
                                            <th class="text-center text-white text-nowrap header-col-alpha col-alpha">Roan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $santris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $santri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $absensiSaatIni = $dataAbsensiTersimpan->get($santri->id);
                                                $ngajiA = $absensiSaatIni ? $absensiSaatIni->ngaji_alpha : 0;
                                                $sholatA = $absensiSaatIni ? $absensiSaatIni->sholat_alpha : 0;
                                                $roanA = $absensiSaatIni ? $absensiSaatIni->roan_alpha : 0;
                                                $keterangan = $absensiSaatIni ? $absensiSaatIni->keterangan : '';
                                                
                                                $rowClass = ($ngajiA > 0 || $sholatA > 0 || $roanA > 0) ? 'row-alpha-exist fw-semibold' : 'fw-semibold';
                                            ?>
                                            <tr class="<?php echo e($rowClass); ?>">
                                                <td class="text-center align-middle small col-no"><?php echo e($index + 1); ?></td>
                                                <td class="align-middle text-dark text-nowrap small col-nama">
                                                    <input type="hidden" name="absensi[<?php echo e($index); ?>][santri_id]" value="<?php echo e($santri->id); ?>">
                                                    <?php echo e($santri->nama_lengkap); ?>

                                                </td>
                                                
                                                
                                                <td class="text-center align-middle col-alpha">
                                                    <input type="number" min="0" name="absensi[<?php echo e($index); ?>][ngaji_alpha]" 
                                                           class="form-control form-control-sm alpha-input mx-auto" 
                                                           value="<?php echo e(old('absensi.' . $index . '.ngaji_alpha', $ngajiA)); ?>"
                                                           placeholder="0">
                                                </td>
                                                
                                                
                                                <td class="text-center align-middle col-alpha">
                                                    <input type="number" min="0" name="absensi[<?php echo e($index); ?>][sholat_alpha]" 
                                                           class="form-control form-control-sm alpha-input mx-auto" 
                                                           value="<?php echo e(old('absensi.' . $index . '.sholat_alpha', $sholatA)); ?>"
                                                           placeholder="0">
                                                </td>
                                                
                                                
                                                <td class="text-center align-middle col-alpha">
                                                    <input type="number" min="0" name="absensi[<?php echo e($index); ?>][roan_alpha]" 
                                                           class="form-control form-control-sm alpha-input mx-auto" 
                                                           value="<?php echo e(old('absensi.' . $index . '.roan_alpha', $roanA)); ?>"
                                                           placeholder="0">
                                                </td>
                                                
                                                
                                                <td class="align-middle col-keterangan">
                                                    <input type="text" name="absensi[<?php echo e($index); ?>][keterangan]" 
                                                           class="form-control form-control-sm rounded-3" 
                                                           value="<?php echo e(old('absensi.' . $index . '.keterangan', $keterangan)); ?>" 
                                                           placeholder="Opsional (Sakit/Izin)">
                                                </td>
                                            </tr>
                                            
                                            <?php if($errors->has('absensi.' . $index . '.ngaji_alpha') || $errors->has('absensi.' . $index . '.sholat_alpha') || $errors->has('absensi.' . $index . '.roan_alpha')): ?> 
                                                <tr class="table-danger"><td colspan="6" class="small text-danger fw-bold text-center">⚠️ Error input angka pada baris Santri <?php echo e($santri->nama_lengkap); ?>. Mohon periksa kembali.</td></tr> 
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>

                            
                            <div class="d-grid d-md-flex justify-content-md-end mt-4 sticky-bottom-custom p-3 bg-white border-top">
                                <?php if(isset($santris) && $santris->isNotEmpty()): ?>
                                <button type="submit" class="btn btn-success shadow rounded-pill btn-save-mobile">
                                    <i class="fas fa-database me-2"></i>
                                    <span class="text fw-bold">Simpan Data Alpha (<?php echo e($santris->count()); ?> Santri)</span>
                                </button>
                                <?php endif; ?>
                            </div>
                        </form>

                    <?php elseif($kelasId): ?>
                        
                        <div class="alert alert-warning p-4 text-center rounded-4 border border-dashed-info">
                            <i class="fas fa-users-slash fa-2x mb-2"></i><br>
                            <h5 class="fw-bold">Tidak ditemukan santri aktif.</h5>
                            <p class="mb-0">Mohon periksa data kelas <?php echo e($kelasOptions->find($kelasId)->nama_kelas ?? 'N/A'); ?> atau pilih kelas yang berbeda.</p>
                        </div>
                    <?php else: ?>
                        
                        <div class="alert alert-info p-4 text-center rounded-4 border border-dashed-info">
                            <i class="fas fa-mouse-pointer fa-2x mb-2"></i><br>
                            <h5 class="fw-bold">Menunggu Seleksi Filter</h5>
                            <p class="mb-0">Silakan pilih Bulan, Tahun, dan Kelas pada bagian filter di atas untuk menampilkan daftar santri.</p>
                        </div>
                    <?php endif; ?>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/admin/absensi_rekap/create_multi.blade.php ENDPATH**/ ?>