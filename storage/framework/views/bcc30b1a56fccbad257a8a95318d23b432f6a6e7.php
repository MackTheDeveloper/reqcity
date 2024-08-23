<?php $__env->startSection('title','Job Details'); ?>

<?php $__env->startSection('content'); ?>
<?php if(Auth::check()): ?>
    <?php ($authenticateClass = ' applyNowCandidate'); ?>
<?php else: ?>
    <?php ($authenticateClass = ' loginBeforeGo'); ?>
<?php endif; ?>
<div class="recruiter-job-details candidate-job-details">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-lg-8 col-xl-9 order-2 order-lg-1">
        <div class="req-job-header">
          <a href="<?php echo e(route('searchFront')); ?>" class="back-to-link bm">
            <img src="<?php echo e(asset('public/assets/frontend/img/arrow-left.svg')); ?>" alt="" />Back to all jobs
          </a>
          <div class="candidate-img-content">
            <img src="<?php echo e($companyDetails->logo); ?>" alt="" />
            <div>
              <p class="tm"><?php echo e($companyDetails->name); ?></p>
              <?php if($jobData->CompanyAddress): ?>
              <span class="ts"><?php echo e($jobData->CompanyAddress->city); ?><?php echo e($jobData->CompanyAddress->state ? ', '.$jobData->CompanyAddress->state :''); ?><?php echo e($jobData->CompanyAddress->countries->name ? ', '.$jobData->CompanyAddress->countries->name :''); ?></span>
              <?php endif; ?>
            </div>
          </div>
          <h6><?php echo e($jobDetails->title); ?></h6>
          <?php if($jobDetails->hide_compensation_details_to_candidates=='no'): ?>
          <p class="ll"><?php echo e($salary); ?> a <?php echo e($jobDetails->salary_type); ?></p>
          <?php endif; ?>
          <span class="bs blur-color"><?php echo e($postedOn); ?></span>

          <hr class="hr">

          <div class="req-job-descripation">
            <div class="jd-header">
              <p class="tl">Job Description</p>
              <?php echo $jobDetails->job_description; ?>

            </div>
              <table class="table-content-data">
                <tr>
                  <td>Employment type</td>
                  <td><?php if(!empty($employmentType)): ?><?php echo e($employmentType->option ? $employmentType->option :''); ?><?php endif; ?></td>
                </tr>
                <tr>
                  <td>Schedule</td>
                  <td><?php echo e($scheduleData ? $scheduleData :''); ?></td>
                </tr>
                <tr>
                  <td>Contract type</td>
                  <td><?php if(!empty($contractType)): ?><?php echo e($contractType->option ? $contractType->option :''); ?><?php endif; ?></td>
                </tr>
                <tr>
                  <td>Contract duration</td>
                  <td><?php echo e($jobDetails->contract_duration ? $jobDetails->contract_duration :''); ?> <?php echo e(($jobDetails->contract_duration_type == '1') ? 'Months' : 'Years'); ?></td>
                </tr>
                <?php if(!empty($remoteWork)): ?>
                <tr>
                  <td>Remote work</td>
                  <td><?php echo e($remoteWork->option ? $remoteWork->option:''); ?></td>
                </tr>
                <?php endif; ?>
              </table>

              <div class="frequent-question">
                <p class="tl">Frequently asked questions</p>
                <?php $__currentLoopData = $companyJobFaq; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faqs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="que-ans">
                  <p class="tm"><?php echo e($faqs['question']); ?></p>
                  <span class="bm"><?php echo e($faqs['answer']); ?></span>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>

          </div>
        </div>
      </div>
      <div class="col-md-12 col-lg-4 col-xl-3 order-1 order-lg-2">
        <div class="req-job-post-box">
          <?php if(!Auth::check() || Auth::user()->role_id == 5): ?>
          <div class="job-post-status">
            <?php if($isApplied!=1): ?>

                <a data-job-id="<?php echo e($jobDetails->id); ?>" class="fill-btn  <?php echo e($authenticateClass); ?>" data-type="applyJob" >Apply Now</a>

            <?php else: ?>
            <button class="fill-btn" disabled>Applied</button>
            <?php endif; ?>
            <label class="bk">
                <input data-job-id="<?php echo e($jobDetails->id); ?>" data-type="favJob" class="makeFavourite" type="checkbox" <?php echo e($isFavorite == 1 ? 'checked' : ''); ?> />
              <span class="bk-checkmark"></span>
            </label>
          </div>
            <hr class="hr">
          <?php endif; ?>
          <!-- <div class="job-post-status">
            <button class="fill-btn">Apply Now</button>
            <label class="bk">
              <input type="checkbox" />
              <span class="bk-checkmark"></span>
            </label>
          </div> -->

          <table class="table-content-data last-blur">
            <tr>
              <td>Opening</td>
              <td><?php echo e($companyJobOpenings); ?></td>
            </tr>
          </table>
        </div>
        <?php if(!empty($companyDetails->why_work_here) || !empty($companyDetails->about)): ?>
        <div class="why-about hide-991">
          <?php if(!empty($companyDetails->why_work_here)): ?>
          <div class="this-key-value">
            <p class="tl">Why work here</p>
            <span class="bm"><?php echo e($companyDetails->why_work_here); ?></span>
          </div>
          <?php endif; ?>
          <?php if(!empty($companyDetails->about)): ?>
          <div class="this-key-value">
            <p class="tl">About Us</p>
            <span class="bm"><?php echo e($companyDetails->about); ?></span>
          </div>
          <?php endif; ?>
        </div>
        <?php endif; ?>
      </div>
      <div class="col-12 show-991 order-3">
        <div class="why-about">
          <div class="this-key-value">
            <p class="tl">Why work here</p>
            <span class="bm"><?php echo e($companyDetails->why_work_here); ?></span>
          </div>
          <div class="this-key-value">
            <p class="tl">About Us</p>
            <span class="bm"><?php echo e($companyDetails->about); ?></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.candidate.jobs.components.apply-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->startSection('footscript'); ?>
<script type="text/javascript">

  $(document).on("click", ".makeFavourite", function(e) {
      var jobId = $(this).attr('data-job-id');
      $.ajax({
          url: "<?php echo e(url('/candidate-jobs/make-favorite')); ?>",
          type: "POST",
          data: {
              jobId: jobId,
              _token: '<?php echo e(csrf_token()); ?>'
          },
          success: function(response) {
              toastr.clear();
              toastr.options.closeButton = true;
              toastr.success(response.message);
          },
      });
  });

  $(document).on('click','.applyNowCandidate',function (e) {
          e.preventDefault();
          var jobId = $(this).attr('data-job-id');
          $("#applyJob #applyConfirmed input#jobId").val(jobId);
          $("#applyJob").modal('show');
  });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/job-details.blade.php ENDPATH**/ ?>