@php
use App\Models\CompanyUser;
    $user = CompanyUser::where('user_id',Auth::user()->id)->first();
    $is_owner = $user->is_owner;
@endphp

<div class="col-12 col-sm-12 col-md-4 col-lg-3">
    <div class="left-sides-bar">
        <div class="dropdowns">...</div>
        <ul class="dropdowns-toggles">
            <li class="{{ request()->is('company-dashboard')  ? 'active' : '' }}">
                <a class="dashboard-link" href="{{ route('showDashboard') }}">Dashboard</a>
            </li>
            <li class="{{ request()->is('company-myinfo') || request()->is('company-myinfo-edit') ? 'active' : '' }}">
                <a class="myinfo-link" href="{{ route('showMyInfoCompany') }}">My Info</a>
            </li>
            @if(whoCanCheckFront('company_payment_view'))
            <li class="{{ request()->is('company-payment') ? 'active' : '' }}">
                <a class="payments-link" href="{{ route('companyPayment')}}">Payments</a>
            </li>
            @endif
            <li class="{{ request()->is('company-password-security') ||request()->is('company-password-security-reset') ? 'active' : '' }}">
                <a class="passsecuri-link" href="{{ route('showPasswordSecurityCompany') }}">Password &
                    Security</a>
            </li>
            @if($is_owner)
            <li class="{{ request()->is('company-subscription-plan') ? 'active' : '' }}">
                <a class="subsc-link" href="{{ route('getSubscriptionPlanView')}}">Subscription Plan</a>
            </li>
            @endif
            @if(whoCanCheckFront('company_user_management_view'))
            <li class="{{ request()->is('company-user-index') ? 'active' : '' }}">
                <a class="userm-link" href="{{ route('companyUserIndex')}}">User Management</a>
            </li>
            @endif
            @if(whoCanCheckFront('company_questionnaire_view'))
            <li class="{{ (request()->is('company-questionnaire-management/*')) ||(request()->is('company-questionnaire-management')) ? 'active' : '' }}">
                <a class="quem-link" href="{{ route('companyQuestionnaireManagment') }}">Questionnaire Management</a>
            </li>
            @endif
            @if(whoCanCheckFront('company_communication_management_view'))
            <li class="{{ request()->is('company-communication-management') ||request()->is('company-communication-management/*') ? 'active' : '' }}">
                <a class="commu-link" href="{{route('companyCommunicationManagment')}}">Communication Management</a>
            </li>
            @endif
            @if(whoCanCheckFront('company_address_management_view'))
            <li class="{{ request()->is('company-address-management') ||request()->is('company-address-management/*') ? 'active' : '' }}">
                <a class="addr-mgmt-link" href="{{route('companyAddressManagment')}}">Address Management</a>
            </li>
            @endif
            @if(whoCanCheckFront('company_notification_settings_view'))
            <li class="{{ request()->is('company-notification-settings') ? 'active' : '' }}">
                <a class="noti-setting-link" href="{{route('notificationSettingCompany')}}">Notification
                    Settings</a>
            </li>
            @endif
            @if(whoCanCheckFront('company_notifications_view'))
            <li class="{{ request()->is('notifications') ? 'active' : '' }}">
                <a class="noti-link" href="{{route('notifications')}}">Notifications</a>
            </li>
            @endif
        </ul>
    </div>
</div>
