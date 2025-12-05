<?php $__env->startSection('title', 'Notifikasi Anda'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <h2 class="mb-4">Notifikasi Terbaru Anda</h2>
    
    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    
    <?php if($notifikasis->isEmpty()): ?>
        <div class="alert alert-info">
            Anda tidak memiliki notifikasi baru saat ini.
        </div>
    <?php else: ?>
        <div class="list-group">
            <?php $__currentLoopData = $notifikasis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notifikasi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e($notifikasi->link ?? '#'); ?>" 
                   class="list-group-item list-group-item-action 
                   <?php if(!$notifikasi->is_read): ?> list-group-item-light fw-bold shadow-sm <?php endif; ?>"
                   onclick="event.preventDefault(); document.getElementById('read-form-<?php echo e($notifikasi->id); ?>').submit();">
                    
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">
                            <?php echo e($notifikasi->title); ?>

                        </h5>
                        <small class="<?php if(!$notifikasi->is_read): ?> text-primary <?php else: ?> text-muted <?php endif; ?>">
                            <?php echo e($notifikasi->created_at->diffForHumans()); ?>

                        </small>
                    </div>
                    
                    <p class="mb-1 text-truncate text-secondary"><?php echo e($notifikasi->body); ?></p>
                    
                    <?php if(!$notifikasi->is_read): ?>
                        <small class="text-danger fw-bold">Belum Dibaca</small>
                    <?php else: ?>
                        <small class="text-success">Dibaca</small>
                    <?php endif; ?>
                </a>
                
                
                <form id="read-form-<?php echo e($notifikasi->id); ?>" 
                      action="<?php echo e(route('wali.notifikasi.mark_read', $notifikasi->id)); ?>" 
                      method="POST" style="display: none;">
                    <?php echo csrf_field(); ?>
                </form>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        
        <div class="mt-4">
            <?php echo e($notifikasis->links()); ?>

        </div>
        
        
        <form action="<?php echo e(route('wali.notifikasi.mark_all_read')); ?>" method="POST" class="mt-3">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-primary btn-sm">
                Tandai Semua Sudah Dibaca
            </button>
        </form>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.wali', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/wali/notifikasi/index.blade.php ENDPATH**/ ?>