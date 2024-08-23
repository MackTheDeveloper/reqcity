<?php if(!empty($similarJobs) && count($similarJobs)>0): ?>
<?php $__currentLoopData = $similarJobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jobs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="activejobs-detailed">
    <div class="activejob-titlehead">
        <div class="active-jobtitle">
        <a href="<?php echo e(route('recruiterJobsDetail',$jobs['jobSlug'])); ?>"><p class="tm"><?php echo e($jobs['jobTitle']); ?></p></a>
            <span><?php echo e($jobs['companyName']); ?></span>
            <span><?php echo e($jobs['companyCity']); ?> <?php echo e($jobs['companyState'] ? ','.$jobs['companyState'] :''); ?></span>
        </div>
        <div class="mores-dots">
            <div class="dropdown c-dropdown my-playlist-dropdown">
                <button class="dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="<?php echo e(asset('public/assets/frontend/img/more-vertical.svg')); ?>" class="c-icon" />
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?php echo e(route('recruiterJobsDetail',$jobs['jobSlug'])); ?>">
                        <!-- <img src="<?php echo e(asset('public/assets/frontend/img/Hovered-heart.svg')); ?>" alt="" /> -->
                        <span>View Detail</span>
                    </a>
                    <!-- <a class="dropdown-item">
                        <img src="<?php echo e(asset('public/assets/frontend/img/Hovered-heart.svg')); ?>" alt="" />
                        <span>share</span>
                    </a> -->
                </div>
            </div>
        </div>
    </div>
    <span class="actjob-address"><?php echo e($jobs['jobShortDescription']); ?></span>
    <div class="active-jobnumeric">
        <div class="job-table">
            <div class="first-data">
                <label class="ll"><?php echo e($jobs['salaryText']); ?> a <?php echo e($jobs['salaryType']); ?></label>
                <span class="bs blur-color"><?php echo e($jobs['postedOn']); ?> </span>
            </div>
            <div class="last-data">
                <div class="job-table-data">
                    <div class="jtd-wrapper">
                        <label class="ll"><?php echo e($jobs['jobOpenings']); ?></label>
                        <span class="bs blur-color">Openings</span>
                    </div>
                </div>
                <div class="job-table-data">
                    <div class="jtd-wrapper">
                        <label class="ll"><?php echo e($jobs['jobMyApproved']); ?></label>
                        <span class="bs blur-color">Approved</span>
                    </div>
                </div>
                <div class="job-table-data">
                    <div class="jtd-wrapper">
                        <label class="ll"><?php echo e($jobs['jobMyRejected']); ?></label>
                        <span class="bs blur-color">Rejected</span>
                    </div>
                </div>
                <!-- <div class="job-table-data">
                    <div class="jtd-wrapper">
                        <label class="ll"><?php echo e($jobs['jobPayout']); ?></label>
                        <span class="bs blur-color">Payout</span>
                    </div>
                </div> -->
            </div>
        </div>

    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/recruiter/dashboard/components/similar-jobs.blade.php ENDPATH**/ ?>