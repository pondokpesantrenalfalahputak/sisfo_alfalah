

<div class="card dashboard-card <?php echo e($bg_class ?? 'bg-secondary text-white'); ?> shadow-soft h-100 hover-shadow">
    
    <div class="card-body p-4 metric-card-body">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <div class="small-text opacity-75 mb-1 text-uppercase fw-semibold"><?php echo e($title); ?></div>
                <h4 class="metric-card-text mb-0"><?php echo e($value); ?></h4>
            </div>
            <i class="<?php echo e($icon ?? 'fas fa-info-circle'); ?> fs-1 opacity-75"></i>
        </div>
    </div>
</div><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/admin/components/metric-card-refined.blade.php ENDPATH**/ ?>