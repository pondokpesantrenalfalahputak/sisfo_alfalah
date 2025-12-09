<?php $__env->startSection('title', 'Konfirmasi Pembayaran'); ?>
<?php $__env->startSection('page_title', 'Konfirmasi Pembayaran'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* CSS KUSTOM UNTUK PERHALUS TAMPILAN MOBILE */
    @media (max-width: 767.98px) {
        .mobile-card-item {
            /* Border dan shadow lebih minimalis di mobile */
            border: 1px solid #e5e7eb !important; 
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            transition: all 0.2s;
        }
        .mobile-card-item:hover {
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -2px rgba(0,0,0,0.06);
        }
        .mobile-header-text {
            /* Font Santri di header mobile sedikit lebih kecil */
            font-size: 0.9rem !important; 
        }
        .mobile-detail-text {
            /* Detail info lebih halus */
            font-size: 0.75rem !important; 
        }
        .mobile-amount-text {
             /* Jumlah bayar lebih dominan tapi tidak terlalu besar */
            font-size: 1.25rem !important; 
        }
        .mobile-action-btn {
            /* Tombol aksi mobile sedikit lebih kecil */
            padding: 0.375rem 0.5rem !important; 
            font-size: 0.8rem !important;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            
            
            
            

            <div class="card shadow-lg border-0 rounded-4">
                
                
                <div class="card-header bg-warning text-dark p-4 rounded-top-4">
                    <h7 class="mb-2 fw-bolder fs-5"><i class="fas fa-check-double me-2"></i> Transaksi Menunggu Konfirmasi</h7>
                    <p class="mb-0 small fw-semibold">
                        Anda memiliki <span class="badge bg-danger text-white fs-6 fw-bolder"><?php echo e(count($pembayarans) ?? 0); ?></span> transaksi yang memerlukan persetujuan.
                    </p>
                </div>
                
                <div class="card-body p-4">

                    
                    
                    <div class="d-none d-md-block">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle mb-0">
                                <thead class="table-dark text-nowrap">
                                    <tr>
                                        <th style="width: 5%;" class="text-center">No</th>
                                        <th style="width: 15%;">Pembayar & Tanggal</th>
                                        <th style="width: 15%;">Untuk Santri</th>
                                        <th style="width: 20%;">Detail Tagihan</th>
                                        <th style="width: 15%;" class="text-end">Jumlah Bayar</th>
                                        <th style="width: 30%;" class="text-center">Aksi Konfirmasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $pembayarans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pembayaran): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr class="fw-semibold">
                                        <td class="text-center"><?php echo e($loop->iteration); ?></td>
                                        
                                        <td>
                                            <p class="mb-0 fw-bold text-dark"><?php echo e($pembayaran->user->name); ?></p>
                                            <span class="text-muted small text-nowrap">
                                                <i class="fas fa-calendar-alt me-1"></i> Tgl Bayar: <?php echo e(\Carbon\Carbon::parse($pembayaran->tanggal_pembayaran)->format('d M Y')); ?>

                                            </span>
                                        </td>
                                        
                                        <td>
                                            <p class="mb-0 fw-bold text-primary"><?php echo e($pembayaran->tagihan->santri->nama_lengkap); ?></p>
                                            <span class="badge bg-info text-dark fw-bold"><?php echo e($pembayaran->tagihan->santri->kelas->nama_kelas ?? 'N/A'); ?></span>
                                        </td>
                                        
                                        <td>
                                            <span class="badge bg-secondary mb-1 fw-bold"><?php echo e($pembayaran->tagihan->jenis_tagihan); ?></span>
                                            <p class="text-muted small mb-0"><?php echo e(Str::limit($pembayaran->tagihan->keterangan ?? 'Tanpa keterangan.', 40)); ?></p>
                                        </td>
                                        
                                        <td class="fw-bolder text-success fs-5 text-end text-nowrap"> 
                                            Rp <?php echo e(number_format($pembayaran->jumlah_bayar, 0, ',', '.')); ?>

                                        </td>
                                        
                                        <td class="text-center text-nowrap">
                                            <div class="d-flex justify-content-center gap-1"> 
                                                
                                                
                                                <a href="<?php echo e(Storage::url($pembayaran->bukti_pembayaran)); ?>" target="_blank" class="btn btn-sm btn-outline-primary fw-bold" data-bs-toggle="tooltip" title="Lihat Bukti Pembayaran">
                                                    <i class="fas fa-image"></i>
                                                </a>

                                                
                                                <form action="<?php echo e(route('admin.tagihan.konfirmasi.proses', $pembayaran)); ?>" method="POST" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <input type="hidden" name="status" value="Dikonfirmasi">
                                                    <button type="submit" class="btn btn-sm btn-success fw-bold" title="Setujui Pembayaran" onclick="return confirm('KONFIRMASI? Anda yakin ingin menyetujui pembayaran ini?')" style="min-width: 80px;">
                                                        Setujui
                                                    </button>
                                                </form>
                                                
                                                <form action="<?php echo e(route('admin.tagihan.konfirmasi.proses', $pembayaran)); ?>" method="POST" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <input type="hidden" name="status" value="Ditolak">
                                                    <button type="submit" class="btn btn-sm btn-outline-danger fw-bold" title="Tolak Pembayaran" onclick="return confirm('TOLAK? Anda yakin ingin menolak pembayaran ini?')" style="min-width: 80px;">
                                                        Tolak
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted bg-light">
                                            <i class="fas fa-thumbs-up me-2 fa-3x mb-3 text-success"></i>
                                            <h5 class="mb-1 fw-bold">Semua Selesai!</h5>
                                            <p class="mb-0">Tidak ada transaksi yang menunggu konfirmasi saat ini.</p>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    
                    <div class="d-md-none">
                        <div class="list-group">
                            <?php $__empty_1 = true; $__currentLoopData = $pembayarans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pembayaran): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                
                                <div class="list-group-item list-group-item-action mb-3 shadow-sm rounded-3 mobile-card-item">
                                    
                                    
                                    <div class="d-flex w-100 justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                        <span class="badge bg-warning text-dark fw-bolder me-2">#<?php echo e($loop->iteration); ?></span>
                                        <h6 class="mb-0 fw-bold text-primary mobile-header-text"><?php echo e($pembayaran->tagihan->santri->nama_lengkap); ?></h6>
                                        <span class="badge bg-info text-dark fw-bold mobile-detail-text"><?php echo e($pembayaran->tagihan->santri->kelas->nama_kelas ?? 'N/A'); ?></span>
                                    </div>

                                    
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="small text-muted fw-normal">Jumlah Dibayar:</span>
                                        <span class="fw-bolder text-success mobile-amount-text">Rp <?php echo e(number_format($pembayaran->jumlah_bayar, 0, ',', '.')); ?></span>
                                    </div>
                                    
                                    
                                    <div class="mb-3">
                                        <span class="badge bg-secondary mb-1 fw-normal mobile-detail-text"><?php echo e($pembayaran->tagihan->jenis_tagihan); ?></span>
                                        <p class="text-muted mb-0 mobile-detail-text fw-normal">Tgl Bayar: <?php echo e(\Carbon\Carbon::parse($pembayaran->tanggal_pembayaran)->format('d M Y')); ?></p>
                                        <p class="text-muted mb-0 mobile-detail-text fw-normal">Pembayar: <?php echo e($pembayaran->user->name); ?></p>
                                        <p class="text-muted mb-0 mobile-detail-text fw-normal">Ket. Tagihan: <?php echo e(Str::limit($pembayaran->tagihan->keterangan ?? 'Tanpa keterangan.', 50)); ?></p>
                                    </div>

                                    
                                    <div class="d-grid gap-2 d-flex justify-content-between pt-2 border-top">
                                        
                                        <a href="<?php echo e(Storage::url($pembayaran->bukti_pembayaran)); ?>" target="_blank" class="btn btn-sm btn-outline-primary fw-bold flex-fill mobile-action-btn">
                                            <i class="fas fa-image me-1"></i> Bukti
                                        </a>

                                        
                                        <form action="<?php echo e(route('admin.tagihan.konfirmasi.proses', $pembayaran)); ?>" method="POST" class="d-inline flex-fill">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="status" value="Dikonfirmasi">
                                            <button type="submit" class="btn btn-sm btn-success w-100 fw-bold mobile-action-btn" onclick="return confirm('KONFIRMASI? Anda yakin ingin menyetujui pembayaran ini?')">
                                                <i class="fas fa-check"></i> Setujui
                                            </button>
                                        </form>
                                        
                                        <form action="<?php echo e(route('admin.tagihan.konfirmasi.proses', $pembayaran)); ?>" method="POST" class="d-inline flex-fill">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="status" value="Ditolak">
                                            <button type="submit" class="btn btn-sm btn-outline-danger w-100 fw-bold mobile-action-btn" onclick="return confirm('TOLAK? Anda yakin ingin menolak pembayaran ini?')">
                                                <i class="fas fa-times"></i> Tolak
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="alert alert-success text-center py-5 rounded-3">
                                    <i class="fas fa-thumbs-up me-2 fa-3x mb-3 text-success"></i>
                                    <h5 class="mb-1 fw-bold">Semua Selesai!</h5>
                                    <p class="mb-0">Tidak ada transaksi yang menunggu konfirmasi saat ini.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                </div>
            </div>

        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Inisialisasi Tooltip Bootstrap (Hanya digunakan di tampilan desktop/tabel)
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/admin/konfirmasi/index.blade.php ENDPATH**/ ?>