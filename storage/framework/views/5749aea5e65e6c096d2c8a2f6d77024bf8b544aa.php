<?php if($data->is_owner): ?>
<div class="accounts-boxlayouts d-none" id="company-info-edit">
    <form id="updateMyInfo2" method="POST" action="<?php echo e(url('/company-myinfo-update')); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <div class="ac-boclayout-header">
            <div class="boxheader-title">
                <h6>Company info</h6>
                <!-- <span>R01532</span> -->
            </div>
            <div class="boxlayouts-edit">
                <a href="<?php echo e(url('/company-myinfo')); ?>"><img src="<?php echo e(asset('public/assets/frontend/img/close.svg')); ?>" alt="" /></a>
            </div>

        </div>
        <span class="full-hr-ac"></span>
        <div class="ac-boxlayouts-desc group-margin">
            <div class="row">
                <div class="col-md-12">
                    <div class="myinfo-compnaylogo">
                        <div class="avatar-upload">
                            <div class="avatar-edit drop-zone">
                                <input type="file" name="myFile" class="drop-zone__input image">
                                <input type="hidden" class="hiddenPreviewImg" name="hiddenPreviewImg" value="" />
                                <label></label>
                            </div>
                            <div class="avatar-preview">
                                <img class="open-icon-select <?php echo e($logo && $logo ? '' : 'd-none'); ?>" src="<?php echo e($logo ? $logo : ''); ?>" alt="" />
                                <?php if(!$logo || empty($logo)): ?>
                                <span class="drop-zone__prompt">Attach or <br> drop logo <br> here</span>
                                <?php endif; ?>
                            </div>
                            <label id="myFile-error" class="error" for="myFile"></label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-groups">
                            <span>Website</span>
                            <input type="hidden" value="<?php echo e($data->companyId); ?>" id="company_id">
                            <input type="text" value="<?php echo e($data->website); ?>" name="company[website]">
                        </div>
                </div>
                <div class="col-md-6">
                    <div class="input-groups">
                            <span>Company size</span>
                            <select name="company[strength]" id="company_stregth">
                                <?php if($data): ?>
                                <?php $__currentLoopData = $companySize; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($row['key']); ?>" <?php echo e($row['value'] == $data->strength ? 'selected' : ''); ?>>
                                    <?php echo e($row['value']); ?>

                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                <?php $__currentLoopData = $companySize; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($row['key']); ?>">
                                    <?php echo e($row['value']); ?>

                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                        </div>
                </div>
                <div class="col-md-6">
                    <div class="input-groups">
                            <span>Email</span>
                            <input type="text" id="email_company" name="company[email]" value="<?php echo e($data->companyEmail); ?>">
                        </div>
                </div>
                <div class="col-md-6">
                    <div class="input-groups">
                            <span>Country</span>
                            <select name="companyAddress[country]" id="country">
                                <?php if($data->countryId): ?>
                                <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($row['key']); ?>" <?php echo e($row['key'] == $data->countryId ? "selected" : ""); ?>><?php echo e($row['value']); ?></option>
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
                            <span>City</span>
                            <input type="text" name="companyAddress[city]" value="<?php echo e($data->city); ?>">
                        </div>
                </div>
                <div class="col-md-6">
                    <div class="input-groups">
                        <span>State</span>
                        <input type="text" value="<?php echo e($data->state); ?>" name="companyAddress[state]">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-groups">
                            <span>Zip code</span>
                            <input type="text" name="companyAddress[postcode]" value="<?php echo e($data->postcode); ?>">
                        </div>
                </div>
                <div class="col-md-12">
                    <div class="input-groups">
                            <span>About company</span>
                            <textarea value="<?php echo e($data->about); ?>" name="company[about]"><?php echo e($data->about); ?></textarea>
                        </div>
                        <div class="input-groups">
                            <span>Why work here?</span>
                            <textarea value="<?php echo e($data->why_work_here); ?>" name="company[why_work_here]"><?php echo e($data->why_work_here); ?></textarea>
                        </div>
                </div>
    </form>
    <div class="col-md-12">
        <div class="save-cancel-edit mt-24">
            <button class="fill-btn" type="submit" value="Save">Save</button>
            <a href="<?php echo e(url('/company-myinfo')); ?>">
                <button class="border-btn" type="button" name="cancel" value="Cancel">Cancel</button>
            </a>
        </div>
    </div>
</div>
</div>
</div>
<?php endif; ?><?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/company/my-info/components/company-info-edit.blade.php ENDPATH**/ ?>