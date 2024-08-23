<?php $__env->startSection('title','Recruiter Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
  <div class="dashboard-compnay dash-reqruiter">
      <div class="dash-heads">
          <div class="dash-headrow">
              <div class="dash-titlelogo">
                  <!-- <div class="dash-compnaylogo">
                      <img src="assets/img/dashlogo.png" />
                  </div>
                  <div class="dash-compnaytitle">
                      <h5>Nutrify, Inc.</h5>
                  </div> -->
              </div>
              <div class="dash-postjob">
                  <a href="<?php echo e(url('/recruiter-jobs/all')); ?>" class="fill-btn w-auto">Submit Candidate</a>
              </div>
          </div>
      </div>
      <div class="dashboards-main">
          <div class="row">
              <div class="col-md-12 col-lg-8 col-xl-9">

                  <div class="recruiter-candidate-dashbox">
                      <div class="reqstudent-dash-head">
                          <h5><?php echo e($recruiterData['recruiterName']); ?></h5>
                          <span><?php echo e($recruiterData['recruiterCode']); ?></span>
                      </div>
                      <span><?php echo e($recruiterData['recruiterPhone']); ?></span>
                      <span><?php echo e($recruiterData['recruiterEmail']); ?></span>
                      <span><?php echo e($recruiterData['recruiterAddress']); ?></span>
                  </div>

                  <?php echo $__env->make('frontend.recruiter.dashboard.components.recruiter-performance', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                  <div class="active-jobs-dash">
                      <div class="active-job-head">
                          <h6>Favorites</h6>
                          <a href="<?php echo e(url('/recruiter-jobs/favorites')); ?>">View All</a>
                      </div>
                      <span class="full-hr"></span>
                      <?php echo $__env->make('frontend.recruiter.dashboard.components.favorite-jobs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                  </div>
                  <div class="active-jobs-dash">
                      <div class="active-job-head">
                          <h6>Similar Jobs</h6>
                          <a href="<?php echo e(url('/recruiter-jobs/similar')); ?>">View All</a>
                      </div>
                      <span class="full-hr"></span>
                      <?php echo $__env->make('frontend.recruiter.dashboard.components.similar-jobs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                  </div>
              </div>
              <div class="col-md-12 col-lg-4 col-xl-3">
                  <div class="dashboard-sidebar">
                    <?php echo $__env->make('frontend.recruiter.dashboard.components.getting-started', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php echo $__env->make('frontend.recruiter.dashboard.components.updates', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/recruiter/dashboard/dashboard.blade.php ENDPATH**/ ?>