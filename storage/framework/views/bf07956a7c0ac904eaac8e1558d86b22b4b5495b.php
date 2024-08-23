<?php $__env->startSection('title', 'Recruiter Jobs'); ?>

<?php $__env->startSection('content'); ?>
<div class="candidate-applied">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
              <img src="<?php echo e(asset('public/assets/frontend/img/Sucess-badge.svg')); ?>" alt="payment success" />
              <h6>Congratulations!</h6>
              <hr class="hr"/>
              <p class="bl blur-color">You have successfully applied to <span><?php echo e($jobTitle); ?></span>.<br> You will hear from us real soon.</p>
              <div class="success-btn-block">
                <a href="<?php echo e(route('showCandidateDashboard')); ?>" class="border-btn">Go to Dashboard</a>
                <a href="<?php echo e(route('searchFront')); ?>" class="fill-btn">Search New Job</a>
              </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/candidate/jobs/applied-job.blade.php ENDPATH**/ ?>