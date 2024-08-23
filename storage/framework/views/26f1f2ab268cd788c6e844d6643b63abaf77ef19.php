<?php $__env->startSection('title','Company Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="dashboard-compnay">
        <div class="dash-heads">
            <div class="dash-headrow">
                <div class="dash-titlelogo">
                    <div class="dash-compnaylogo">
                        <img src="<?php echo e($companyData['logo']); ?>" />
                    </div>
                    <div class="dash-compnaytitle">
                        <h5><?php echo e($companyData['companyName']); ?></h5>
                    </div>
                </div>
                <div class="dash-postjob">
                    <?php if(whoCanCheckFront('company_job_post')): ?>
                        <a href="<?php echo e(route('jobDetailsShow')); ?>" class="fill-btn">Post a Job</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="dashboards-main">
            <div class="row">
                <div class="col-md-12 col-lg-8 col-xl-9">
                <?php if(whoCanCheckFront('company_job_view')): ?>
                      <?php echo $__env->make('frontend.company.dashboard.components.active-jobs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                      <?php echo $__env->make('frontend.company.dashboard.components.active-jobs-box', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
                    <div class="copm-performance-dash">
                        <div class="copm-perform-head">
                            <h6>Company Performance</h6>
                            <!-- <a href="">View All</a> -->
                        </div>
                        <span class="full-hr"></span>
                        <?php echo $__env->make('frontend.company.dashboard.components.company-performance', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4 col-xl-3">
                    <div class="dashboard-sidebar">
                      <?php echo $__env->make('frontend.company.dashboard.components.getting-started', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                      <?php echo $__env->make('frontend.company.dashboard.components.updates', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/company/dashboard/dashboard.blade.php ENDPATH**/ ?>