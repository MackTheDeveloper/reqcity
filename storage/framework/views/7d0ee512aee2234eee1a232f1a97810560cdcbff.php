<div class="accounts-boxlayouts d-none" id="about-edit-form">
    <div class="ac-boclayout-header">
        <div class="boxheader-title">
            <h6>About</h6>
            <!-- <span>R01532</span> -->
        </div>
        <div class="boxlayouts-edit">
            <a href="<?php echo e(url('/candidate-myinfo')); ?>"><img src="<?php echo e(asset('public/assets/frontend/img/close.svg')); ?>" alt="" /></a>
        </div>
    </div>
    <span class="full-hr-ac"></span>
    <div class="ac-boxlayouts-desc group-margin">
        <form id="updateMyInfo2" method="POST" action="<?php echo e(url('/candidate-myinfo-update')); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="myinfo-candidate-profile">
                        <div class="avatar-upload">
                            <div class="avatar-edit drop-zone">
                                <input type="file" name="myFile" accept="image/png, image/jpeg, image/jpg" class="drop-zone__input image">
                                <input type="hidden" class="hiddenPreviewImg" name="hiddenPreviewImg" value="" />
                                <label></label>
                            </div>
                            <div class="avatar-preview">
                                <img class="open-icon-select <?php echo e($image && $image ? '' : 'd-none'); ?>" src="<?php echo e($image ? $image : ''); ?>" alt="" />
                                <?php if(!$image || empty($image)): ?>
                                <span class="drop-zone__prompt">Attach or <br> drop logo <br> here</span>
                                <?php endif; ?>
                            </div>
                            <label id="myFile-error" class="error" for="myFile"></label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-groups">
                            <span>Job title</span>
                            <input type="text" name="job_title" value="<?php echo e($candidate->job_title); ?>">
                        </div>
                </div>
                <div class="col-md-6">
                    <div class="input-groups">
                                <span>Country</span>
                                <select name="country" id="country">
                                    <?php if($candidate->country): ?>
                                    <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($row['key']); ?>" <?php echo e($row['key'] == $candidate->country ? "selected" : ""); ?>><?php echo e($row['value']); ?></option>
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
                            <input type="text" value="<?php echo e($candidate->address_1); ?>" name="address_1">
                        </div>
                </div>
                <div class="col-md-6">
                    <div class="input-groups">
                            <span>Address line 2</span>
                            <input type="text" value="<?php echo e($candidate->address_2); ?>" name="address_2">
                        </div>
                </div>
                <div class="col-md-6">
                    <div class="input-groups">
                            <span>City</span>
                            <input type="text" value="<?php echo e($candidate->city); ?>" name="city">
                        </div>
                </div>
                
                <div class="col-md-6">
                    <div class="input-groups">
                            <span>Zip code</span>
                            <input type="text" value="<?php echo e($candidate->postcode); ?>" name="postcode">
                        </div>
                </div>
                <div class="col-md-6">
                    <div class="boxlayout-infoitem">
                        <span>Resume</span>
                        <div class="upload-form-btn2">
                            <img src="<?php echo e(asset('public/assets/frontend/img/upload-icon.svg')); ?>" id="upload-form-img" alt="" />
                            <div>
                                <p class="tm" id="upload-form-text">Upload resume</p>
                                <span class="bs blur-color">Use a pdf, docx, doc, rtf and txt</span>
                            </div>
                            <input type="file" id="upload-form-file" name="resume" accept="application/pdf, .docx, .doc, .rtf, text/plain" hidden="hidden" />
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-groups">
                            <span>LinkedIn</span>
                            <input type="url" pattern="https://.*" value="<?php echo e($candidate->linkedin_profile_link); ?>" name="linkedin_profile_link">
                        </div>
                </div>
        </form>
        <div class="col-md-6">
            <div class="save-cancel-edit">
                <button class="fill-btn" type="submit" value="Save">Save</button>
                <a href="<?php echo e(url('/candidate-myinfo')); ?>">
                    <button class="border-btn" type="button" name="cancel" value="Cancel">Cancel</button>
                </a>
            </div>
        </div>
    </div>
</div>
</div><?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/candidate/my-info/components/edit-about-info.blade.php ENDPATH**/ ?>