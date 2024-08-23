<div class="tab-wrapper">
  <div class="container">
    <div class="tab-section" id="navbar-example2">
      <ul>
        <input type="hidden" value="<?php echo e($status); ?>" name="status" id="status" />
        <li><a href="<?php echo e(url('/recruiter-jobs/all')); ?>" id="all" class="tab-link active">All</a></li>
        <li><a href="<?php echo e(url('/recruiter-jobs/favorites')); ?>" id="favorites" data="" class="tab-link">Favorites</a></li>
        <li><a href="<?php echo e(url('/recruiter-jobs/submitted')); ?>" id="submitted" data="" class="tab-link">Submitted</a></li>
        <li><a href="<?php echo e(url('/recruiter-jobs/similar')); ?>" id="similar" data="" class="tab-link">Similar</a></li>
      </ul>
    </div>
  </div>
</div><?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/recruiter/jobs/components/job-tabs.blade.php ENDPATH**/ ?>