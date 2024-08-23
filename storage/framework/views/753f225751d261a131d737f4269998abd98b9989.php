<div class="tab-wrapper">
  <div class="container">
    <div class="tab-section" id="navbar-example2">
      <ul>
        <input type="hidden" value="<?php echo e($status); ?>" name="status" id="status"/>
        <li><a href="<?php echo e(url('/company-jobs/')); ?>" id="all" class="tab-link active">All</a></li>
        <li><a href="<?php echo e(url('/company-jobs/open')); ?>" id="open" class="tab-link">Open</a></li>
        <li><a href="<?php echo e(url('/company-jobs/paused')); ?>" id="paused" class="tab-link">Paused</a></li>
        <li><a href="<?php echo e(url('/company-jobs/closed')); ?>" id="closed" class="tab-link">Closed</a></li>
        <li><a href="<?php echo e(url('/company-jobs/draft')); ?>" id="draft" class="tab-link">Draft</a></li>
      </ul>
    </div>
  </div>
</div>
<?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/company/jobs/components/job-tabs.blade.php ENDPATH**/ ?>