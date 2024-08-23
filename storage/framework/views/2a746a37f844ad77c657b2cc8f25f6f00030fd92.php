<?php if(isset($companyUserList)): ?>
<div class="user-permission-section">
    <div class="selectuser-forpermision">
        <div class="input-groups">
            <span>Select User</span>
            <select name="user" id="user-list">
                <option>Select...</option>
                <?php $__currentLoopData = $companyUserList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($user['id']); ?>">
                    <?php echo e($user['name']); ?>

                </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
    </div>
    <div class="user-permisions-detailed">
        <!-- Permission Iteam -->
    </div>
</div>
<?php endif; ?><?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/company/components/user-dropdown.blade.php ENDPATH**/ ?>