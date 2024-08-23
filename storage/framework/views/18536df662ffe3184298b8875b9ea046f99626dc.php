<div class="job-descripation">
  <div class="jd-header">
    <p class="tl">Job Description</p>
    <!-- <p class="bm"><?php echo $jobDetails->job_description; ?></p> -->
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
  <?php if(!empty($companyJobFaq) && count($companyJobFaq)>0): ?>
    <?php echo $__env->make('frontend.company.jobs.components.job-faqs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <?php endif; ?>
</div>
<?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/company/jobs/components/job-description.blade.php ENDPATH**/ ?>