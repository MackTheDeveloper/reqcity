<div class="updates-notification-dash">
    <h6>Updates</h6>
    <div class="noti-updates-main">
      <?php if(!empty($notificationData) && count($notificationData)>0): ?>
        <?php $__currentLoopData = $notificationData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notidata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="notiupdates-iteams">
              <p class="ll updte-title"><?php echo e($notidata->message_type); ?></p>
              <span class="updte-desc"><?php echo e($notidata->message); ?></span>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <div class="updte-viewall">
              <a href="<?php echo e(route('notifications')); ?>">View All</a>
          </div>
      <?php else: ?>
      <div class="notiupdates-iteams">
          <span class="updte-desc"><?php echo e(config('message.frontendMessages.notification.noupdates')); ?></span>
      </div>
      <?php endif; ?>
    </div>
</div>
<?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/candidate/dashboard/components/updates.blade.php ENDPATH**/ ?>