<?php $__env->startSection('title', 'Notifikasi Anda'); ?>
<?php $__env->startSection('page_title', 'Notifikasi Anda'); ?> 

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    
    
    <div class="card border-0 shadow-lg mb-4 rounded-4 bg-primary text-white">
        <div class="card-body d-flex align-items-center">
            <i class="fas fa-bell me-3 fs-3 flex-shrink-0"></i>
            <div>
                <h4 class="mb-0 fw-bolder">Pusat Notifikasi</h4>
                <p class="mb-0 small opacity-75">Informasi terbaru terkait aktivitas dan kehadiran santri.</p>
            </div>
        </div>
    </div>
    
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-pill" role="alert">
            <i class="fas fa-check-circle me-1"></i> <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    
    <?php if($notifikasis->isEmpty()): ?>
        <div class="alert alert-light text-center py-5 border rounded-4 shadow-sm">
            <i class="fas fa-box-open me-2 fs-3 text-secondary"></i> 
            <p class="mb-0 mt-3 fw-semibold fs-6">Kotak notifikasi Anda kosong.</p>
            <small class="text-muted">Semua sudah ditinjau. Selamat bekerja\! </small>
        </div>
    <?php else: ?>
        
        
        <div class="d-flex justify-content-end mb-4">
            <form action="<?php echo e(route('wali.notifikasi.mark_all_read')); ?>" method="POST" class="form-mark-all">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-primary btn-sm rounded-pill fw-semibold shadow-sm">
                    <i class="fas fa-check-double me-1"></i> Tandai Semua Sudah Dibaca
                </button>
            </form>
        </div>

        <div class="list-group list-group-notification">
            <?php $__currentLoopData = $notifikasis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notifikasi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    // Logika sederhana penentuan ikon berdasarkan judul/body
                    $icon = 'fas fa-info-circle';
                    $iconClass = 'text-primary';

                    if (stripos($notifikasi->title, 'absen') !== false || stripos($notifikasi->body, 'alfa') !== false) {
                        $icon = 'fas fa-exclamation-triangle';
                        $iconClass = 'text-danger';
                    } elseif (stripos($notifikasi->title, 'pembayaran') !== false || stripos($notifikasi->body, 'tagihan') !== false) {
                        $icon = 'fas fa-receipt';
                        $iconClass = 'text-success';
                    } elseif (stripos($notifikasi->title, 'izin') !== false) {
                        $icon = 'fas fa-shield-alt';
                        $iconClass = 'text-warning';
                    }

                    $readClass = $notifikasi->is_read ? 'list-group-item-light-custom' : 'list-group-item-unread shadow-sm border-primary';
                ?>
                
                <a href="<?php echo e($notifikasi->link ?? '#'); ?>" 
                   class="list-group-item list-group-item-action mb-2 rounded-4 p-3 <?php echo e($readClass); ?>"
                   onclick="event.preventDefault(); document.getElementById('read-form-<?php echo e($notifikasi->id); ?>').submit();">
                    
                    <div class="d-flex w-100 justify-content-between align-items-start">
                        <div class="d-flex align-items-center flex-grow-1 me-3">
                            
                            <i class="<?php echo e($icon); ?> me-3 fs-5 <?php echo e($iconClass); ?> flex-shrink-0"></i>
                            
                            
                            <div>
                                <h6 class="mb-0 fw-bold text-dark text-truncate-custom">
                                    <?php echo e($notifikasi->title); ?>

                                </h6>
                                <p class="mb-1 small text-muted text-wrap description-text"><?php echo e(Str::limit($notifikasi->body, 80)); ?></p>
                            </div>
                        </div>
                        
                        
                        <div class="text-end flex-shrink-0">
                            <small class="text-muted d-block mb-1"><?php echo e($notifikasi->created_at->diffForHumans()); ?></small>
                            <?php if(!$notifikasi->is_read): ?>
                                <span class="badge bg-danger p-1 fw-bold status-badge">Baru</span>
                            <?php else: ?>
                                <span class="badge bg-success-light text-success p-1 status-badge">Dibaca</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </a>
                
                
                <form id="read-form-<?php echo e($notifikasi->id); ?>" 
                      action="<?php echo e(route('wali.notifikasi.mark_read', $notifikasi->id)); ?>" 
                      method="POST" style="display: none;">
                    <?php echo csrf_field(); ?>
                </form>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        
        
        <div class="d-flex justify-content-center mt-4">
            <div class="pagination-area">
                <?php echo e($notifikasis->links()); ?>

            </div>
        </div>

    <?php endif; ?>
</div>

<?php $__env->startPush('css'); ?>
<style>
    /* ... (CSS styling yang sama dari versi sebelumnya) ... */
    :root {
        --bs-primary: #1e88e5; 
        --bs-danger: #e53935;
        --bs-success: #43a047;
    }

    .container-fluid {
        padding-top: 1.5rem;
    }
    
    /* Styling Header Card */
    .bg-primary {
        background-color: var(--bs-primary) !important;
    }

    /* Styling Notifikasi Belum Dibaca */
    .list-group-item-unread {
        background-color: #e9f5ff; /* Latar biru muda untuk notifikasi baru */
        border-left: 5px solid var(--bs-primary) !important;
        transition: all 0.3s ease;
    }

    .list-group-item-unread:hover {
        background-color: #d8ecff;
        transform: translateY(-2px);
    }
    
    /* Styling Notifikasi Sudah Dibaca */
    .list-group-item-light-custom {
        border: 1px solid #e9ecef;
    }
    .list-group-item-light-custom:hover {
        background-color: #f8f9fa;
    }

    .status-badge {
        font-size: 0.65rem;
        min-width: 55px;
        text-align: center;
    }

    .text-truncate-custom {
        display: block;
        max-width: 100%;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .description-text {
        color: #6c757d !important;
    }
    
    /* Warna Badge Sudah Dibaca */
    .bg-success-light {
        background-color: #e6f7e9 !important;
    }

    /* Paginasi */
    .pagination-area .pagination {
        margin-bottom: 0;
    }

    /* Penyesuaian Tombol Mark All di atas */
    .form-mark-all {
        display: inline-block;
    }
    .form-mark-all button {
        /* Mengubah button style menjadi btn-primary */
        min-width: 180px; 
    }

    @media (max-width: 767.98px) {
        .list-group-item-unread {
            border-left-width: 4px !important;
        }
        
        /* Membuat tombol mark all di atas penuh di mobile */
        .d-flex.justify-content-end.mb-4 {
            justify-content: center !important;
        }
        .form-mark-all {
            width: 100%;
        }
        .form-mark-all button {
            width: 100%;
        }
        
        .pagination-area {
            width: 100%;
            display: flex;
            justify-content: center;
        }
        .text-end {
            text-align: left !important;
            margin-top: 0.5rem;
        }
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.wali', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/wali/notifikasi/index.blade.php ENDPATH**/ ?>