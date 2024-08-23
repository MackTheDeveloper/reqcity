<div class="candidate-submittal-sidebar">
    <div class="job-posdetails-first">
        <p class="tm"><?php echo e($companyJob->title); ?></p>
        <span class="grey-span-sidebar"><?php echo e($companyJob->company->name); ?></span>
        <span class="grey-span-sidebar"><?php echo e($companyJob->companyAddress->city); ?>, <?php echo e($companyJob->companyAddress->countries->name); ?></span>
        
        <div class="jobpost-budgeted-salary">
            <?php if($companyJob->to_salary): ?>
                <p class="ll">$<?php echo e($companyJob->from_salary); ?> - $<?php echo e($companyJob->to_salary); ?> a year</p>
            <?php else: ?>
                <p class="ll">$<?php echo e($companyJob->from_salary); ?> a year</p>    
            <?php endif; ?>
            <span><?php echo e(getFormatedDateForWeb($companyJob->created_at)); ?></span>
            
        </div>
    </div>
    <div class="job-postdesc-sec">
        
        <?php echo $companyJob->job_description; ?>

        
    </div>
</div><?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/recruiter/job-application/job-desc-sidebar.blade.php ENDPATH**/ ?>