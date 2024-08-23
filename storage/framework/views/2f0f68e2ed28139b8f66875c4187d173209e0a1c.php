<div class="action-block">
    <?php if($isEditable): ?>
    <a href="javascript:void(0)" data-id="<?php echo e($id); ?>"
    data-target="#reqAddAddress" id="edit-btn-address">
        <img src="<?php echo e(asset('public/assets/frontend/img/pencil.svg')); ?>"
            alt="" />
    </a>
    <?php endif; ?>
    <?php if($isDeletable): ?>
    <a href="javascript:void(0)" id="delete-btn" class="delete-module-item" data-id="<?php echo e($id); ?>" data-module="<?php echo e($module); ?>"><img src="<?php echo e(asset('public/assets/frontend/img/delete.svg')); ?>"
            alt="" /></a>
    <?php endif; ?>
   
</div>
<div class="mobile-action show-991">
    <div
        class="dropdown c-dropdown my-playlist-dropdown">
        <button class="dropdown-toggle"
            data-bs-toggle="dropdown">
            <img src="<?php echo e(asset('public/assets/frontend/img/more-vertical.svg')); ?>"
                class="c-icon" />
        </button>
        <div class="dropdown-menu">
            <?php if($isEditable): ?>
            <a class="dropdown-item"
                id="edit-btn"
                data-target="#reqEidtAddress" data-id="<?php echo e($id); ?>" href="javascript:void(0)">
                <img src="<?php echo e(asset('public/assets/frontend/img/pencil.svg')); ?>"
                    alt="" />
                <span>Edit</span>
            </a>
            <?php endif; ?>
            <?php if($isDeletable): ?>
            <a class="dropdown-item delete-module-item" id="delete-btn" data-id="<?php echo e($id); ?>" data-module="<?php echo e($module); ?>" href="javascript:void(0)">
                <img src="<?php echo e(asset('public/assets/frontend/img/delete.svg')); ?>"
                    alt="" />
                <span>Delete</span>
            </a>
            <?php endif; ?>
            
        </div>
    </div>
</div><?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/company/components/action-address.blade.php ENDPATH**/ ?>