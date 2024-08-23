<div class="candidates">
  <p class="tl">Candidates</p>
  <div class="row">
    <div class="col-6 col-sm-3 col-md-3">
      <div class="candidates-box">
        <h5><?php echo e($companyJobOpenings); ?></h5>
        <p class="tm blur-color">Openings</p>
      </div>
    </div>
    <div class="col-6 col-sm-3 col-md-3">
      <div class="candidates-box">
        <h5><a href="<?php echo e(route('showCompanyCandidate',['jobid'=>$jobDetails->id])); ?>"><?php echo e($companyJobPending); ?></a></h5>
        <p class="tm blur-color"><a href="<?php echo e(route('showCompanyCandidate',['jobid'=>$jobDetails->id])); ?>" class="tm blur-color">Pending</a></p>
      </div>
    </div>
    <div class="col-6 col-sm-3 col-md-3">
      <div class="candidates-box">
        <h5><a href="<?php echo e(route('showCompanyCandidate',['jobid'=>$jobDetails->id])); ?>"><?php echo e($companyJobApproved); ?></a></h5>
        <p class="tm blur-color"><a href="<?php echo e(route('showCompanyCandidate',['jobid'=>$jobDetails->id])); ?>" class="tm blur-color">Approved</a></p>
      </div>
    </div>
    <div class="col-6 col-sm-3 col-md-3">
      <div class="candidates-box">
        <h5><a href="<?php echo e(route('showCompanyCandidate',['jobid'=>$jobDetails->id])); ?>"><?php echo e($companyJobRejected); ?></a></h5>
        <p class="tm blur-color"><a href="<?php echo e(route('showCompanyCandidate',['jobid'=>$jobDetails->id])); ?>" class="tm blur-color">Rejected</a></p>
      </div>
    </div>
  </div>
</div>
<?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/company/jobs/components/candidate-data.blade.php ENDPATH**/ ?>