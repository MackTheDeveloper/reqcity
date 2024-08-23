<div class="accounts-boxlayouts d-none" id="about-edit-form">
    <div class="ac-boclayout-header">
        <div class="boxheader-title">
            <h6>About</h6>
            <!-- <span>R01532</span> -->
        </div>
        <div class="boxlayouts-edit">
            <a href="<?php echo e(url('/recruiter-myinfo')); ?>"><img src="<?php echo e(asset('public/assets/frontend/img/close.svg')); ?>" alt="" /></a>
        </div>
    </div>
    <span class="full-hr-ac"></span>
    <div class="ac-boxlayouts-desc group-margin">
        <form id="updateMyInfo2" method="POST" action="<?php echo e(url('/recruiter-myinfo-update')); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-md-6">
                        <div class="input-groups">
                            <span>website</span>
                            <input type="text" name="Recruiter[website]" value="<?php echo e($data->website); ?>">
                        </div>
                </div>
                <div class="col-md-6">
                    <div class="input-groups">
                                <span>Country</span>
                                <select name="Recruiter[country]" id="country">
                                    <?php if($data->country): ?>
                                    <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($row['key']); ?>" <?php echo e($row['key'] == $data->country ? "selected" : ""); ?>><?php echo e($row['value']); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                    <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($row['key']); ?>" <?php echo e($row['value'] == "United States" ? "selected" : ""); ?>><?php echo e($row['value']); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                </div>
                <div class="col-md-6">
                    <div class="input-groups">
                            <span>Address line 1</span>
                            <input type="text" value="<?php echo e($data->address_1); ?>" name="Recruiter[address_1]">
                        </div>
                </div>
                <div class="col-md-6">
                    <div class="input-groups">
                            <span>Address line 2</span>
                            <input type="text" value="<?php echo e($data->address_2); ?>" name="Recruiter[address_2]">
                        </div>
                </div>
                <div class="col-md-6">
                    <div class="input-groups">
                            <span>City</span>
                            <input type="text" value="<?php echo e($data->city); ?>" name="Recruiter[city]">
                        </div>
                </div>
                <div class="col-md-6">
                    <div class="input-groups">
                            <span>Zip code</span>
                            <input type="text" value="<?php echo e($data->postcode); ?>" name="Recruiter[postcode]">
                        </div>
                </div>
        </form>
        <div class="col-md-6">
            <div class="save-cancel-edit">
                <button class="fill-btn" type="submit" value="Save">Save</button>
                <a href="<?php echo e(url('/recruiter-myinfo')); ?>">
                    <button class="border-btn" type="button" name="cancel" value="Cancel">Cancel</button>
                </a>
            </div>
        </div>
    </div>
</div>
</div><?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/recruiter/my-info/components/edit-about-info.blade.php ENDPATH**/ ?>