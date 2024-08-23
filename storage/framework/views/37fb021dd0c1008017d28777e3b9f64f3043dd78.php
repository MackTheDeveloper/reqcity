<div class="action-block">
    <?php if($isDeletable): ?>
    <a href="javascript:void(0)" class="delete-module-item" id="delete-btn" data-id="<?php echo e($id); ?>" data-module="<?php echo e($module); ?>">
        <img src="<?php echo e(asset('public/assets/frontend/img/delete.svg')); ?>" alt="" />
    </a>
    <?php endif; ?>
    <?php if($isEditable): ?>
        <?php if($isRead==1): ?>
        <a href="javascript:void(0)" class="readunread-module-item" id="readunread-btn" data-id="<?php echo e($id); ?>" data-module="<?php echo e($module); ?>">
            <img src="<?php echo e(asset('public/assets/frontend/img/read.svg')); ?>" alt="" />
        </a>
        <?php else: ?>
        <a href="javascript:void(0)" class="readunread-module-item" id="readunread-btn" data-id="<?php echo e($id); ?>" data-module="<?php echo e($module); ?>">
            <img src="<?php echo e(asset('public/assets/frontend/img/unread.svg')); ?>" alt="" />
        </a>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/notifications/components/action.blade.php ENDPATH**/ ?>