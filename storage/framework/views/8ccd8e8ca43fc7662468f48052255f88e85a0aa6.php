<div class="action-block">
    <?php if($editInPopup == 1): ?>
    <a href="javascript:void(0)" data-title="Edit Candidate" data-id="<?php echo e($id); ?>" value="<?php echo e(route('editRecruiterCandidates',$id)); ?>" id="btnAddRecruiterCandidate">
        <img src="<?php echo e(asset('public/assets/frontend/img/pencil.svg')); ?>" alt="" />
    </a>
    <?php endif; ?>

    <a href="javascript:void(0)" id="delete-btn" class="delete-module-item" data-id="<?php echo e($id); ?>" data-module="<?php echo e($module); ?>"><img src="<?php echo e(asset('public/assets/frontend/img/delete.svg')); ?>" alt="" /></a>

</div>
<div class="mobile-action show-991">
    <div class="dropdown c-dropdown my-playlist-dropdown">
        <button class="dropdown-toggle" data-bs-toggle="dropdown">
            <img src="<?php echo e(asset('public/assets/frontend/img/more-vertical.svg')); ?>" class="c-icon" />
        </button>
        <div class="dropdown-menu">
            <?php if($editInPopup == 1): ?>
            <a class="dropdown-item" id="edit-btn" data-target="#reqEidtUser" data-id="<?php echo e($id); ?>" href="javascript:void(0)">
                <img src="<?php echo e(asset('public/assets/frontend/img/pencil.svg')); ?>" alt="" />
                <span>Edit</span>
            </a>
            <?php endif; ?>

            <a class="dropdown-item delete-module-item" id="delete-btn" data-id="<?php echo e($id); ?>" data-module="<?php echo e($module); ?>" href="javascript:void(0)">
                <img src="<?php echo e(asset('public/assets/frontend/img/delete.svg')); ?>" alt="" />
                <span>Delete</span>
            </a>

        </div>
    </div>
</div><?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/recruiter/components/action.blade.php ENDPATH**/ ?>