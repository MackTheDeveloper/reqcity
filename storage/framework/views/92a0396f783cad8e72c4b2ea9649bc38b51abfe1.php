<div class="accounts-boxlayouts d-none" id="account-edit-form">
    <div class="ac-boclayout-header">
        <div class="boxheader-title">
            <h6>Account Info</h6>
            <!-- <span>R01532</span> -->
        </div>
        <div class="boxlayouts-edit">
            <a href="<?php echo e(url('/recruiter-myinfo')); ?>"><img src="<?php echo e(asset('public/assets/frontend/img/close.svg')); ?>" alt="" /></a>
        </div>
    </div>
    <span class="full-hr-ac"></span>
    <div class="ac-boxlayouts-desc group-margin">
        <form id="updateMyInfo1" method="POST" action="<?php echo e(url('/recruiter-myinfo-update')); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-md-12 col-lg-6">
                    <div class="input-groups">
                        <span>First name</span>
                        <input type="hidden" id="rec_id" value="<?php echo e($data->id); ?>">
                        <input type="text" name="User[firstname]" value="<?php echo e($data->user->firstname); ?>">
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div class="input-groups">
                        <span>Last name</span>
                        <input type="text" name="User[lastname]" value="<?php echo e($data->user->lastname); ?>">
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div class="input-groups">
                        <span>Email</span>
                        <input type="text" value="<?php echo e($data->user->email); ?>" id="email" name="User[email]">
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div class="number-groups">
                        <span>Phone number</span>
                        <div class="number-fields">
                            <input type="text" id="phoneField1" name="Recruiter[phone_ext]" class="phone-field" value="<?php echo e($data->phone_ext); ?>" />
                            <input type="number" class="mobile-number" value="<?php echo e($data->phone); ?>" name="Recruiter[phone]">
                        </div>
                    </div>
                </div>
        </form>
        <div class="col-md-12 col-lg-6">
            <div class="save-cancel-edit">
                <button class="fill-btn" type="submit" value="Save">Save</button>
                <a href="<?php echo e(url('/recruiter-myinfo')); ?>">
                    <button class="border-btn" type="button" name="cancel" value="Cancel">Cancel</button>
                </a>
            </div>
        </div>
    </div>
</div>
</div><?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/recruiter/my-info/components/edit-account-info.blade.php ENDPATH**/ ?>