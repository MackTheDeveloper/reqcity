<div class="actjobs-boxstatus">
    <div class="row">
        <div class="col-6 col-sm-4 col-md-4 col-lg-4 col-xl-3">
            <div class="actjob-status-item">
                <a href="<?php echo e(url('/company-jobs/open')); ?>"><h5><?php echo e($activeJobsCount); ?></h5></a>
                <span>Active jobs</span>
            </div>
        </div>
        <div class="col-6 col-sm-4 col-md-4 col-lg-4 col-xl-3">
            <div class="actjob-status-item">
                <a href="<?php echo e(url('/company-jobs/closed')); ?>"><h5><?php echo e($closedJobsCount); ?></h5></a>
                <span>Closed jobs</span>
            </div>
        </div>
        <div class="col-6 col-sm-4 col-md-4 col-lg-4 col-xl-3">
            <div class="actjob-status-item">
                <a href="<?php echo e(url('/company-jobs/paused')); ?>"><h5><?php echo e($pausedJobsCount); ?></h5></a>
                <span>Paused jobs</span>
            </div>
        </div>
        <div class="col-6 col-sm-4 col-md-4 col-lg-4 col-xl-3">
            <div class="actjob-status-item">
                <a href="<?php echo e(url('/company-jobs/draft')); ?>"><h5><?php echo e($unpublishedJobsCount); ?></h5></a>
                <span>Unpublished Jobs</span>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/company/dashboard/components/active-jobs-box.blade.php ENDPATH**/ ?>