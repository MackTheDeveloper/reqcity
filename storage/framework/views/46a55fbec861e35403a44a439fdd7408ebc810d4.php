<div class="getting-started-dash">
    <h6>Getting started</h6>
    <div class="percentage-done-bar">
        <div class="meter" style="width: 288px;">
            <span style="width: <?php echo e($percentage); ?>%;"></span>
        </div>
        <p class="percent-done-number bs"><?php echo e($percentage); ?>% done</p>
    </div>
    <div class="verify-mail-dash">
        <div class="verify-maindash-item">
            <img src="<?php echo e(asset('public/assets/frontend/img/at-sign.svg')); ?>" />
            <p class="ts">Verify Email</p>
        </div>
        <div class="verify-maindash-item">
            <img src="<?php echo e(asset('public/assets/frontend/img/Create-Questionnaire.svg')); ?>" />
            <p class="ts">Create Questionnaire</p>
        </div>
        <div class="verify-maindash-item">
            <img src="<?php echo e(asset('public/assets/frontend/img/Create-Communication.svg')); ?>" />
            <p class="ts">Create Communication</p>
        </div>
        <div class="verify-maindash-item">
            <img src="<?php echo e(asset('public/assets/frontend/img/Create-first-job-post.svg')); ?>" />
            <p class="ts">Create first job post</p>
        </div>
    </div>
    <div class="copm-taskdesc">
        <p class="ts">Completed tasks</p>
        <?php if($hasVerifiedEmail!=0): ?>
        <span class="bs">Email verified</span>
        <?php endif; ?>
        <?php if($questionnaireTemplatesCount!=0): ?>
        <span class="bs psjob-span">Questionnaire created</span>
        <?php endif; ?>
        <?php if($faqTemplateCount!=0): ?>
        <span class="bs psjob-span">Communication created</span>
        <?php endif; ?>
        <?php if($firstJobCount!=0): ?>
        <span class="bs psjob-span">First job posted</span>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/company/dashboard/components/getting-started.blade.php ENDPATH**/ ?>