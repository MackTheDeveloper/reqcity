<?php if(!empty($similarJobs) && count($similarJobs)>0): ?>
<?php $__currentLoopData = $similarJobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jobs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="activejobs-detaile">
    <div class="job-posts">
        <div class="job-post-data">
            <p class="tm"><?php echo e($jobs['jobTitle']); ?></p>
            <p class="ll blur-color"><?php echo e($jobs['companyName']); ?></p>
            <p class="ll blur-color"><?php echo e($jobs['companyCity']); ?><?php echo e($jobs['companyState'] ?', '.$jobs['companyState'] :''); ?><?php echo e($jobs['companyCountry'] ?', '.$jobs['companyCountry'] :''); ?></p>
            <p class="bm blur-color"><?php echo e($jobs['jobShortDescription']); ?></p>
            <div class="job-table">
                <div class="first-data">
                    <label class="ll"><?php echo e($jobs['salaryText']); ?> a <?php echo e($jobs['salaryType']); ?></label>
                    <span class="bs blur-color"><?php echo e($jobs['postedOn']); ?></span>
                </div>
                <div class="last-data">
                    <div class="job-table-data">
                        <div class="jtd-wrapper">
                            <label class="ll"><?php echo e($jobs['jobOpenings']); ?></label>
                            <span class="bs blur-color">Openings</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="job-post-status">
            <form class="applyNowCandidate" data-type="downgrade" method="POST" action="<?php echo e(route('candidateApplyJob',$jobs['jobId'])); ?>">
                <?php echo csrf_field(); ?>
                <button class="fill-btn">Apply Now</button>
            </form>
            <label class="bk">
                <input data-job-id="<?php echo e($jobs['jobId']); ?>" class="makeFavourite" type="checkbox" <?php echo e($jobs['isFavorite'] == 1 ? 'checked' : ''); ?> />
                <span class="bk-checkmark"></span>
            </label>

        </div>

    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php else: ?>
<div class="activejobs-detaile">
    <div class="job-posts">
        <?php echo e(config('message.frontendMessages.recordNotFound')); ?>

    </div>
</div>
<?php endif; ?><?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/candidate/dashboard/components/similar-jobs.blade.php ENDPATH**/ ?>