<div class="frequent-question">
  <p class="tl">Frequently asked questions</p>
  <?php $__currentLoopData = $companyJobFaq; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faqs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <div class="que-ans">
    <p class="tm"><?php echo e($faqs['question']); ?></p>
    <span class="bm"><?php echo e($faqs['answer']); ?></span>
  </div>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/company/jobs/components/job-faqs.blade.php ENDPATH**/ ?>