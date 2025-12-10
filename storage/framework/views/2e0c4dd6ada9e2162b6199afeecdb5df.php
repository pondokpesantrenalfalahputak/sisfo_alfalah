<?php $__env->startSection('title', 'Riwayat Pembayaran'); ?>
<?php $__env->startSection('page_title', 'Semua Riwayat Pembayaran'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* CSS KUSTOM KHUSUS UNTUK TAMPILAN RINGKAS */
    
    /* Penyesuaian Tabel Desktop (dibiarkan kecil seperti sebelumnya) */
    .table-hover td, .table-hover th {
        font-size: 0.85rem !important; 
    }
    .table-hover small {
        font-size: 0.75rem !important;
    }

    /* Penyesuaian Mobile (D-MD-NONE) - FOKUS UTAMA */
    @media (max-width: 767.98px) {
        /* Card umum */
        .mobile-riwayat-card {
            border: 1px solid #e5e7eb !important; 
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        
        /* Judul/Nama Santri */
        .mobile-riwayat-header {
            font-size: 0.85rem !important; /* Dikecilkan lagi */
        }
        
        /* Teks Detail (Kelas, Tanggal, Label Santri/Status) */
        .mobile-riwayat-detail {
            font-size: 0.6rem !important; /* Sangat kecil */
        }
        
        /* Nominal Bayar (Masih perlu menonjol sedikit) */
        .mobile-riwayat-amount {
             font-size: 0.95rem !important; /* Dikecilkan */
        }
        
        /* Badge Status & Tagihan */
        .mobile-riwayat-status-badge {
            font-size: 0.65rem !important; /* Sangat kecil */
            padding: 0.2em 0.4em !important;
        }
        
        /* Tombol Aksi Mobile */
        .mobile-riwayat-action-btn {
            padding: 0.25rem 0.35rem !important; 
            font-size: 0.7rem !important; /* Sangat kecil */
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0 rounded-4">
                
                
                <div class="card-header bg-primary text-white p-4 rounded-top-4">
                    <h5 class="mb-0 fw-bold fs-5"><i class="fas fa-history me-2"></i> Riwayat Transaksi Pembayaran</h5>
                    <p class="text-white-50 small mb-0">Kelola dan konfirmasi semua riwayat pembayaran santri.</p>
                </div>
                
                
                <div class="card-body p-4 pb-0">
                    <div class="row mb-4 align-items-center g-3">
                        
                        
                        <div class="col-12 col-md-6">
                            <form method="GET" class="d-flex" id="search-form">
                                <input type="hidden" name="status" value="<?php echo e(request('status')); ?>"> 
                                
                                
                                <div class="input-group shadow-sm">
                                    <input type="text" name="search" class="form-control form-control-md" placeholder="Cari berdasarkan nama santri..." value="<?php echo e(request('search')); ?>">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search me-1"></i>
                                        <span class="d-none d-sm-inline">Cari</span>
                                    </button>
                                    <?php if(request('search')): ?>
                                        <a href="<?php echo e(route('admin.pembayaran.riwayat', ['status' => request('status')])); ?>" class="btn btn-outline-danger" title="Hapus Pencarian"><i class="fas fa-times"></i></a>
                                    <?php endif; ?>
                                </div>
                            </form>
                        </div>
                        
                        
                        <div class="col-12 col-md-4 offset-md-2">
                            <form method="GET" id="status-filter-form">
                                <input type="hidden" name="search" value="<?php echo e(request('search')); ?>"> 
                                
                                
                                <select name="status" class="form-select form-select-md shadow-sm" onchange="document.getElementById('status-filter-form').submit()">
                                    <option value="">-- Filter Berdasarkan Status --</option>
                                    <option value="Menunggu" <?php echo e(request('status') == 'Menunggu' ? 'selected' : ''); ?>>Menunggu Konfirmasi</option>
                                    <option value="Dikonfirmasi" <?php echo e(request('status') == 'Dikonfirmasi' ? 'selected' : ''); ?>>Dikonfirmasi</option>
                                    <option value="Ditolak" <?php echo e(request('status') == 'Ditolak' ? 'selected' : ''); ?>>Ditolak</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>

                
                <div class="p-0">
                    
                    
                    
                    
                    
                    <div class="table-responsive d-none d-md-block">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-dark text-nowrap">
                                <tr>
                                    <th style="width: 5%;">#</th>
                                    <th style="width: 15%;">Tanggal Transaksi</th>
                                    <th style="width: 25%;">Santri & Kelas</th>
                                    <th style="width: 20%;">Jenis Tagihan</th>
                                    <th style="width: 15%;" class="text-end">Nominal Bayar</th>
                                    <th style="width: 10%;">Status</th>
                                    <th style="width: 10%;" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $pembayarans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pembayaran): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr> 
                                    <td><small><?php echo e($pembayarans->firstItem() + $loop->index); ?></small></td>
                                    <td>
                                        <span class="fw-semibold"><?php echo e($pembayaran->created_at->translatedFormat('d M Y')); ?></span><br>
                                        <small class="text-muted"><?php echo e($pembayaran->created_at->format('H:i')); ?> WIB</small>
                                    </td>
                                    <td>
                                        <strong class="text-dark"><?php echo e($pembayaran->tagihan->santri->nama_lengkap ?? 'N/A'); ?></strong><br>
                                        <small class="text-secondary">Kelas: <?php echo e($pembayaran->tagihan->santri->kelas->nama_kelas ?? 'N/A'); ?></small>
                                    </td>
                                    <td>
                                         <span class="badge bg-primary p-2 fw-semibold"><small><?php echo e($pembayaran->tagihan->jenis_tagihan ?? 'N/A'); ?></small></span>
                                    </td>
                                    <td class="text-end">
                                        <span class="fw-bolder fs-6 text-success">Rp <?php echo e(number_format($pembayaran->jumlah_bayar, 0, ',', '.')); ?></span>
                                    </td>
                                    <td>
                                        <?php
                                            $status = $pembayaran->status_konfirmasi;
                                            $badgeClass = match($status) {
                                                'Dikonfirmasi' => 'success',
                                                'Ditolak' => 'danger',
                                                default => 'warning text-dark',
                                            };
                                        ?>
                                        <span class="badge bg-<?php echo e($badgeClass); ?> p-2 fw-semibold"><small><?php echo e($status); ?></small></span>
                                    </td>
                                    <td class="text-center text-nowrap">
                                        <div class="btn-group" role="group">
                                            <a href="<?php echo e(route('admin.tagihan.show', $pembayaran->tagihan_id)); ?>" class="btn btn-sm btn-primary small" title="Lihat Detail & Konfirmasi">
                                                <i class="fas fa-clipboard-check"></i> Detail
                                            </a>
                                            <?php if($pembayaran->bukti_pembayaran): ?>
                                                <a href="<?php echo e(Storage::url($pembayaran->bukti_pembayaran)); ?>" target="_blank" class="btn btn-sm btn-info text-white small" title="Lihat Bukti Bayar">
                                                    <i class="fas fa-file-image"></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7" class="text-center py-5 bg-light">
                                        <i class="fas fa-receipt fa-3x text-muted mb-3"></i>
                                        <h5 class="mb-0 fw-bold">Tidak ada riwayat pembayaran yang ditemukan.</h5>
                                        <p class="text-muted">Coba reset filter atau gunakan kata kunci lain.</p>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    
                    
                    
                    
                    <div class="d-md-none p-4 pt-0">
                        <?php $__empty_1 = true; $__currentLoopData = $pembayarans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pembayaran): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $status = $pembayaran->status_konfirmasi;
                                $badgeClass = match($status) {
                                    'Dikonfirmasi' => 'success',
                                    'Ditolak' => 'danger',
                                    default => 'warning text-dark',
                                };
                            ?>
                            
                            <div class="card mb-3 mobile-riwayat-card rounded-3 border-start border-2 border-<?php echo e($badgeClass); ?>">
                                <div class="card-body p-3">
                                    
                                    
                                    <div class="d-flex justify-content-between align-items-start mb-2 border-bottom pb-2">
                                        <div>
                                            <h6 class="text-muted mb-0 mobile-riwayat-detail fw-normal">SANTRI (<?php echo e($pembayarans->firstItem() + $loop->index); ?>)</h6>
                                            <h5 class="card-title fw-bold text-dark mb-1 mobile-riwayat-header"><?php echo e($pembayaran->tagihan->santri->nama_lengkap ?? 'N/A'); ?></h5>
                                            <small class="text-secondary mobile-riwayat-detail fw-normal">Kelas: <?php echo e($pembayaran->tagihan->santri->kelas->nama_kelas ?? 'N/A'); ?></small>
                                        </div>
                                        
                                        <span class="badge bg-primary fw-semibold mobile-riwayat-status-badge"><?php echo e($pembayaran->tagihan->jenis_tagihan ?? 'N/A'); ?></span>
                                    </div>

                                    
                                    
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <span class="text-muted mobile-riwayat-detail d-block fw-normal">STATUS</span>
                                            <span class="badge bg-<?php echo e($badgeClass); ?> fw-bold mobile-riwayat-status-badge"><?php echo e($status); ?></span>
                                        </div>
                                        <div class="text-end">
                                            <span class="text-muted mobile-riwayat-detail d-block fw-normal">NOMINAL BAYAR</span>
                                            <span class="fw-bolder text-success mobile-riwayat-amount">Rp <?php echo e(number_format($pembayaran->jumlah_bayar, 0, ',', '.')); ?></span>
                                        </div>
                                    </div>
                                    
                                    <div class="text-end mobile-riwayat-detail text-muted border-top pt-2 fw-normal">
                                        <i class="fas fa-clock me-1"></i> 
                                        Transaksi: <?php echo e($pembayaran->created_at->translatedFormat('d M Y, H:i')); ?>

                                    </div>
                                    
                                    
                                    <div class="d-grid gap-2 d-sm-flex justify-content-sm-end pt-3">
                                        <a href="<?php echo e(route('admin.tagihan.show', $pembayaran->tagihan_id)); ?>" class="btn btn-sm btn-primary fw-semibold flex-fill mobile-riwayat-action-btn" title="Detail & Konfirmasi">
                                            <i class="fas fa-clipboard-check me-1"></i> Detail & Konfirmasi
                                        </a>
                                        <?php if($pembayaran->bukti_pembayaran): ?>
                                            <a href="<?php echo e(Storage::url($pembayaran->bukti_pembayaran)); ?>" target="_blank" class="btn btn-sm btn-info text-white fw-semibold mobile-riwayat-action-btn" title="Lihat Bukti Bayar">
                                                <i class="fas fa-file-image me-1"></i> Bukti
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="text-center py-5 text-muted bg-light rounded-3 shadow-sm mx-3">
                                <i class="fas fa-receipt fa-3x text-secondary mb-3"></i>
                                <h5 class="mb-0 fw-bold">Tidak ada riwayat pembayaran yang ditemukan.</h5>
                                <p class="text-muted">Coba reset filter atau gunakan kata kunci lain.</p>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>
                
                
                <?php if($pembayarans->hasPages()): ?>
                <div class="card-footer bg-light border-0 pt-3 rounded-bottom-4">
                    <div class="d-flex justify-content-center justify-content-md-end">
                        <?php echo e($pembayarans->links()); ?>

                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/admin/pembayaran/riwayat.blade.php ENDPATH**/ ?>