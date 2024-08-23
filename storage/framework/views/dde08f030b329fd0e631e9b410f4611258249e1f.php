<?php
use App\Models\CompanyUser;
    $user = CompanyUser::where('user_id',Auth::user()->id)->first();
    $is_owner = $user->is_owner;
?>

<div class="col-12 col-sm-12 col-md-4 col-lg-3">
    <div class="left-sides-bar">
        <div class="dropdowns">...</div>
        <ul class="dropdowns-toggles">
            <li class="<?php echo e(request()->is('company-dashboard')  ? 'active' : ''); ?>">
                <a class="dashboard-link" href="<?php echo e(route('showDashboard')); ?>">Dashboard</a>
            </li>
            <li class="<?php echo e(request()->is('company-myinfo') || request()->is('company-myinfo-edit') ? 'active' : ''); ?>">
                <a class="myinfo-link" href="<?php echo e(route('showMyInfoCompany')); ?>">My Info</a>
            </li>
            <?php if(whoCanCheckFront('company_payment_view')): ?>
            <li class="<?php echo e(request()->is('company-payment') ? 'active' : ''); ?>">
                <a class="payments-link" href="<?php echo e(route('companyPayment')); ?>">Payments</a>
            </li>
            <?php endif; ?>
            <li class="<?php echo e(request()->is('company-password-security') ||request()->is('company-password-security-reset') ? 'active' : ''); ?>">
                <a class="passsecuri-link" href="<?php echo e(route('showPasswordSecurityCompany')); ?>">Password &
                    Security</a>
            </li>
            <?php if($is_owner): ?>
            <li class="<?php echo e(request()->is('company-subscription-plan') ? 'active' : ''); ?>">
                <a class="subsc-link" href="<?php echo e(route('getSubscriptionPlanView')); ?>">Subscription Plan</a>
            </li>
            <?php endif; ?>
            <?php if(whoCanCheckFront('company_user_management_view')): ?>
            <li class="<?php echo e(request()->is('company-user-index') ? 'active' : ''); ?>">
                <a class="userm-link" href="<?php echo e(route('companyUserIndex')); ?>">User Management</a>
            </li>
            <?php endif; ?>
            <?php if(whoCanCheckFront('company_questionnaire_view')): ?>
            <li class="<?php echo e((request()->is('company-questionnaire-management/*')) ||(request()->is('company-questionnaire-management')) ? 'active' : ''); ?>">
                <a class="quem-link" href="<?php echo e(route('companyQuestionnaireManagment')); ?>">Questionnaire Management</a>
            </li>
            <?php endif; ?>
            <?php if(whoCanCheckFront('company_communication_management_view')): ?>
            <li class="<?php echo e(request()->is('company-communication-management') ||request()->is('company-communication-management/*') ? 'active' : ''); ?>">
                <a class="commu-link" href="<?php echo e(route('companyCommunicationManagment')); ?>">Communication Management</a>
            </li>
            <?php endif; ?>
            <?php if(whoCanCheckFront('company_address_management_view')): ?>
            <li class="<?php echo e(request()->is('company-address-management') ||request()->is('company-address-management/*') ? 'active' : ''); ?>">
                <a class="addr-mgmt-link" href="<?php echo e(route('companyAddressManagment')); ?>">Address Management</a>
            </li>
            <?php endif; ?>
            <?php if(whoCanCheckFront('company_notification_settings_view')): ?>
            <li class="<?php echo e(request()->is('company-notification-settings') ? 'active' : ''); ?>">
                <a class="noti-setting-link" href="<?php echo e(route('notificationSettingCompany')); ?>">Notification
                    Settings</a>
            </li>
            <?php endif; ?>
            <?php if(whoCanCheckFront('company_notifications_view')): ?>
            <li class="<?php echo e(request()->is('notifications') ? 'active' : ''); ?>">
                <a class="noti-link" href="<?php echo e(route('notifications')); ?>">Notifications</a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</div>
<?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/company/include/sidebar.blade.php ENDPATH**/ ?>