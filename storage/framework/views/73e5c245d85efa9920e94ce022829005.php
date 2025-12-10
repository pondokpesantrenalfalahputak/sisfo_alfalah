<div class="rounded-xl shadow-lg overflow-hidden transition duration-300 transform hover:scale-[1.02] <?php echo e($bg_color ?? 'bg-gray-700'); ?>">
    <div class="p-5 flex justify-between items-center">
        <div class="flex flex-col">
            <div class="text-sm font-medium <?php echo e($text_color ?? 'text-gray-200'); ?> opacity-80 mb-1">
                <?php echo e($title); ?>

            </div>
            <div class="text-3xl font-bold <?php echo e($text_color ?? 'text-white'); ?>">
                <?php echo e($value); ?>

            </div>
        </div>
        <div class="p-3 rounded-full <?php echo e($text_color ?? 'text-white'); ?> opacity-70">
            <i class="<?php echo e($icon ?? 'fas fa-info-circle'); ?> text-4xl"></i>
        </div>
    </div>
</div><?php /**PATH /home/axioo/Unduhan/_sisfo-laravel/resources/views/admin/components/metric-card.blade.php ENDPATH**/ ?>