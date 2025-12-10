 

<?php $__env->startSection('title', 'Dashboard Admin'); ?>
<?php $__env->startSection('page_title', 'Dashboard Utama'); ?>

<?php $__env->startSection('content'); ?>

<?php $__env->startPush('css'); ?>
<style>
    /* Efek halus pada kartu */
    .dashboard-card {
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        border: none !important;
        border-radius: var(--border-radius-lg); /* Mengambil dari layout utama */
    }
    .hover-shadow:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
        transform: translateY(-3px);
    }
    .metric-card-text {
        font-weight: 700 !important; /* Membuat angka lebih tebal */
        font-size: 1.75rem !important;
    }
    .hover-bg-light:hover {
        background-color: #f8f9fa; /* Warna light dari Bootstrap */
    }
</style>
<?php $__env->stopPush(); ?>

<div class="container-fluid p-0">
    
    
    <div class="alert alert-white border-start border-0 border-primary shadow-soft py-2 px-4 mb-4 d-flex align-items-center">
        
        <i class="fas fa-hand-wave fa-2x text-primary me-2 d-none d-sm-block"></i>
        <div>
            <h5 class="fw-bold mb-0 text-dark" style="font-size: 1.1rem !important;">Halo, <?php echo e(Auth::user()->name ?? 'Administrator'); ?>!</h5>
            <p class="mb-0 small-text text-muted d-none d-sm-block">Seluruh ringkasan data dan aktivitas harian sistem Al-Falah Putak dapat diakses di sini.</p>
            <p class="mb-0 small-text text-muted d-sm-none">Ringkasan data utama sistem Al-Falah Putak.</p>
        </div>
    </div>

    
    
    
    <div class="row g-4 mb-5">

        
        <div class="col-12 col-md-6 col-lg-3">
            <?php echo $__env->make('admin.components.metric-card-refined', [
                'title' => 'Total Santri',
                'value' => number_format($totalSantri),
                'icon' => 'fas fa-users',
                'bg_class' => 'bg-primary text-white',
            ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

        
        <div class="col-12 col-md-6 col-lg-3">
            <?php echo $__env->make('admin.components.metric-card-refined', [
                'title' => 'Total Tenaga Pengajar',
                'value' => number_format($totalGuru),
                'icon' => 'fas fa-chalkboard-teacher',
                'bg_class' => 'bg-success text-white',
            ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

        
        <div class="col-12 col-md-6 col-lg-3">
            <?php echo $__env->make('admin.components.metric-card-refined', [
                'title' => 'Pengumuman Aktif',
                'value' => number_format($totalPengumuman),
                'icon' => 'fas fa-bullhorn',
                'bg_class' => 'bg-info text-white',
            ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

        
        <div class="col-12 col-md-6 col-lg-3">
            <?php echo $__env->make('admin.components.metric-card-refined', [
                'title' => 'Nilai Tunggakan',
                'value' => 'Rp ' . number_format($totalTagihanBelumLunas, 0, ',', '.'),
                'icon' => 'fas fa-sack-xmark',
                'bg_class' => 'bg-danger text-white',
            ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>

    
    
    
    <div class="row g-4 mb-5">
        
        
        <div class="col-12 col-lg-8">
            <div class="card shadow-soft h-100 dashboard-card">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="card-title fw-bold text-primary mb-0"><i class="fas fa-chart-line me-2"></i> Grafik Pendaftaran Santri Baru Tahun <?php echo e(\Carbon\Carbon::now()->year); ?></h5>
                </div>
                <div class="card-body">
                    <div style="height: 350px;">
                        <canvas id="registrationChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-12 col-lg-4">
            <div class="card shadow-soft h-100 dashboard-card">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="card-title fw-bold text-primary mb-0"><i class="fas fa-wallet me-2"></i> Ringkasan Status Keuangan</h5>
                </div>
                <div class="card-body d-flex flex-column justify-content-between">

                    
                    <div class="p-3 mb-3 border rounded-lg bg-light d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1 small-text text-muted fw-semibold text-uppercase">Persentase Lunas (Tahun Ini)</p>
                            <h4 class="fw-bolder text-primary mb-0"><?php echo e($persentaseLunas); ?>%</h4>
                        </div>
                        <i class="fas fa-check-circle fs-3 text-primary opacity-50"></i>
                    </div>

                    
                    <div class="p-3 mb-3 border rounded-lg bg-light d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1 small-text text-muted fw-semibold text-uppercase">Tagihan Bulan Aktif</p>
                            <h4 class="fw-bolder text-info mb-0"><?php echo e(number_format($tagihanBulanIni)); ?></h4>
                        </div>
                        <i class="fas fa-file-invoice fs-3 text-info opacity-50"></i>
                    </div>

                    
                    <div class="p-3 mb-3 border rounded-lg bg-light d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1 small-text text-muted fw-semibold text-uppercase">Santri Terlambat Bayar</p>
                            <h4 class="fw-bolder text-danger mb-0"><?php echo e(number_format($santriTerlambatBayar)); ?> Orang</h4>
                        </div>
                        <i class="fas fa-user-times fs-3 text-danger opacity-50"></i>
                    </div>
                    
                    <a href="<?php echo e(route('admin.tagihan.index')); ?>" class="btn btn-primary mt-3 w-100 fw-semibold shadow-soft">
                        <i class="fas fa-arrow-circle-right me-2"></i> Kelola Keuangan
                    </a>
                </div>
            </div>
        </div>
    </div>

    
    
    
    <div class="row">
        <div class="col-12">
            <div class="card shadow-soft dashboard-card">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="card-title fw-bold text-primary mb-0"><i class="fas fa-bullhorn me-2"></i> Pengumuman Terbaru</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <?php $__empty_1 = true; $__currentLoopData = $pengumumans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pengumuman): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-4 py-3 hover-bg-light">
                                <div class="me-3">
                                    <a href="<?php echo e(route('admin.pengumuman.show', $pengumuman->id)); ?>" class="fw-semibold text-dark text-decoration-none hover-primary" style="font-size: 1.05rem;">
                                        <?php echo e($pengumuman->judul); ?>

                                    </a>
                                    <p class="mb-0 small-text text-muted mt-1">
                                        Kategori: <span class="fw-medium"><?php echo e($pengumuman->kategori); ?></span>
                                    </p>
                                </div>
                                <span class="badge bg-light text-muted small-text fw-medium py-2 px-3">
                                    <?php echo e(\Carbon\Carbon::parse($pengumuman->tanggal_publikasi)->diffForHumans()); ?>

                                </span>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <li class="list-group-item text-center text-muted py-4">
                                Belum ada pengumuman yang dipublikasikan.
                            </li>
                        <?php endif; ?>
                    </ul>
                    <div class="card-footer bg-white text-center border-top-0">
                        <a href="<?php echo e(route('admin.pengumuman.index')); ?>" class="small-text fw-semibold text-primary text-decoration-none">
                            Lihat Semua Pengumuman <i class="fas fa-chevron-right ms-1 small"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('registrationChart');
        const chartData = <?php echo json_encode($chartData, 15, 512) ?>;

        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: 'Pendaftaran Santri Baru',
                        data: chartData.data,
                        backgroundColor: 'rgba(11, 47, 86, 0.1)', // Primary Color (10% Opacity)
                        borderColor: 'var(--primary-color)',
                        borderWidth: 3,
                        tension: 0.4, 
                        pointRadius: 5, 
                        pointBackgroundColor: 'var(--primary-color)',
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, 
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.08)', 
                                borderDash: [5, 5]
                            },
                            ticks: {
                                precision: 0 
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'var(--primary-color)',
                            titleFont: { weight: 'bold' }
                        }
                    }
                }
            });
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>