<div class="col-12 col-sm-12 col-md-4 col-lg-3">
    <div class="left-sides-bar">
        <div class="dropdowns">...</div>
        <ul class="dropdowns-toggles">
            <li class="<?php echo e(request()->is('candidate-dashboard')  ? 'active' : ''); ?>">
                <a class="dashboard-link" href="<?php echo e(route('showCandidateDashboard')); ?>">Dashboard</a>
            </li>
            <li class="<?php echo e(request()->is('candidate-myinfo') ? 'active' : ''); ?>">
                <a class="myinfo-link" href="<?php echo e(route('showMyInfoCandidate')); ?>">My Info</a>
            </li>
            <li class="<?php echo e(request()->is('candidate-password-security') ||request()->is('candidate-password-security-reset') ? 'active' : ''); ?>">
                <a class="passsecuri-link" href="<?php echo e(route('showPasswordSecurityCandidate')); ?>">Password &
                    Security</a>
            </li>
            <li class="<?php echo e(request()->is('candidate-notification-settings') ? 'active' : ''); ?>">
                <a class="noti-setting-link" href="<?php echo e(route('notificationSettingCandidate')); ?>">Notification
                    Settings</a>
            </li>
            <li class="<?php echo e(request()->is('notifications') ? 'active' : ''); ?>">
                <a class="noti-link" href="<?php echo e(route('notifications')); ?>">Notifications</a>
            </li>
        </ul>
    </div>
</div><?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/candidate/include/sidebar.blade.php ENDPATH**/ ?>