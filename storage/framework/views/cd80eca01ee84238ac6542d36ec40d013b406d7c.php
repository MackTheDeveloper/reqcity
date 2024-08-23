<div class="tab-wrapper">
  <div class="container">
    <div class="tab-section" id="navbar-example2">
      <ul>
        <input type="hidden" value="<?php echo e($tab); ?>" name="tab" id="tab" />
        <li><a href="<?php echo e(url('/candidate-jobs/all')); ?>" id="all" class="tab-link active">All</a></li>
        <li><a href="<?php echo e(url('/candidate-jobs/favorites')); ?>" id="favorites" data="" class="tab-link">Favorites</a></li>
        <li><a href="<?php echo e(url('/candidate-jobs/applied')); ?>" id="applied" data="" class="tab-link">Applied</a></li>
        <li><a href="<?php echo e(url('/candidate-jobs/similar')); ?>" id="similar" data="" class="tab-link">Similar</a></li>
      </ul>
    </div>
  </div>
</div>
<?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/candidate/jobs/components/job-tabs.blade.php ENDPATH**/ ?>