<div class="accounts-boxlayouts d-none" id="account-edit-form">
    <div class="ac-boclayout-header">
        <div class="boxheader-title">
            <h6>Account Info</h6>
            <!-- <span>R01532</span> -->
        </div>
        <div class="boxlayouts-edit">
            <a href="<?php echo e(url('/company-myinfo')); ?>"><img src="<?php echo e(asset('public/assets/frontend/img/close.svg')); ?>" alt="" /></a>
        </div>
    </div>
    <span class="full-hr-ac"></span>
    <div class="ac-boxlayouts-desc group-margin">
        <form id="updateMyInfo1" method="POST" action="<?php echo e(url('/company-myinfo-update')); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-md-12 col-lg-6">
                        <div class="input-groups">
                            <span>Your name</span>
                            <input type="text" name="companyUser[yourName]" value="<?php echo e($data->companyUserName); ?> <?php echo e($data->lastname); ?>">
                        </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    
                            <div class="input-groups">
                                <span>Email</span>
                                <input type="hidden" value="<?php echo e($data->companyUserId); ?>" id="company_user_id" >
                                <input type="email" id="email" name="companyUser[email]" value="<?php echo e($data->userEmail); ?>">
                            </div>
                        
                </div>
                <div class="col-md-12 col-lg-6">
                    
                        <div class="input-groups">
                            <span>Company name</span>
                            <?php if($data->is_owner): ?>
                            <input type="text" value="<?php echo e($data->companyName); ?>" name="company[name]">
                            <?php else: ?>
                            <label for="companyName"><?php echo e($data->companyName); ?></label>
                            <?php endif; ?>
                        </div>
                   
                </div>
                <div class="col-md-12 col-lg-6">
                    
                        <div class="number-groups">
                            <span>Phone number</span>
                            <div class="number-fields">
                                <input type="text" id="phoneField1" name="companyUser[phoneField1]" class="phone-field" value="<?php echo e($data->companyUserPhoneExt); ?>" />
                                <input type="number" class="mobile-number" value="<?php echo e($data->companyUserPhone); ?>" name="companyUser[phoneNumber]">
                            </div>
                        </div>
                    
                </div>
        </form>
        <div class="col-md-12 col-lg-6">
            <div class="save-cancel-edit">
                <button class="fill-btn" type="submit" value="Save">Save</button>
                <a href="<?php echo e(url('/company-myinfo')); ?>">
                    <button class="border-btn" type="button" name="cancel" value="Cancel">Cancel</button>
                </a>
            </div>
        </div>
    </div>
</div>
</div><?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/company/my-info/components/account-info-edit.blade.php ENDPATH**/ ?>