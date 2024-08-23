<div class="col-12 col-sm-12 col-md-4 col-lg-3">
    <div class="left-sides-bar">
        <div class="dropdowns">...</div>
        <ul class="dropdowns-toggles">
          <li class="<?php echo e(request()->is('recruiter-dashboard')  ? 'active' : ''); ?>">
              <a class="dashboard-link" href="<?php echo e(route('showRecruiterDashboard')); ?>">Dashboard</a>
          </li>
            <li class="<?php echo e(request()->is('recruiter-myinfo') ||request()->is('recruiter-myinfo-edit') ? 'active' : ''); ?>">
                <a class="myinfo-link" href="<?php echo e(route('showMyInfoRecruiter')); ?>">My Info</a>
            </li>
            <li class="<?php echo e(request()->is('recruiter-payment')  ? 'active' : ''); ?>">
                <a class="payments-link" href="<?php echo e(route('recruiterPaymentIndex')); ?>">Payments</a>
            </li>
            <li class="<?php echo e(request()->is('recruiter-password-security') ||request()->is('recruiter-password-security-reset') ? 'active' : ''); ?>">
                <a class="passsecuri-link" href="<?php echo e(route('showPasswordSecurityRecruiter')); ?>">Password &
                    Security</a>
            </li>
            <li class="<?php echo e(request()->is('recruiter-subscription-plan') ? 'active' : ''); ?>">
                <a class="subsc-link" href="<?php echo e(route('getRecruiterSubscriptionPlanView')); ?>">Subscription Plan</a>
            </li>
            <li class="<?php echo e(request()->is('recruiter-notification-settings') ? 'active' : ''); ?>">
                <a class="noti-setting-link" href="<?php echo e(route('notificationSettingRecruiter')); ?>">Notification
                    Settings</a>
            </li>
            <li class="<?php echo e(request()->is('notifications') ? 'active' : ''); ?>">
                <a class="noti-link" href="<?php echo e(route('notifications')); ?>">Notifications</a>
            </li>
        </ul>
    </div>
</div>
<?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/recruiter/include/sidebar.blade.php ENDPATH**/ ?>