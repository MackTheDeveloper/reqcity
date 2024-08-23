<div class="col-12 col-sm-12 col-md-4 col-lg-3">
    <div class="left-sides-bar">
        <div class="dropdowns">...</div>
        <ul class="dropdowns-toggles">
          <li class="{{ request()->is('recruiter-dashboard')  ? 'active' : '' }}">
              <a class="dashboard-link" href="{{ route('showRecruiterDashboard') }}">Dashboard</a>
          </li>
            <li class="{{ request()->is('recruiter-myinfo') ||request()->is('recruiter-myinfo-edit') ? 'active' : '' }}">
                <a class="myinfo-link" href="{{route('showMyInfoRecruiter')}}">My Info</a>
            </li>
            <li class="{{ request()->is('recruiter-payment')  ? 'active' : '' }}">
                <a class="payments-link" href="{{route('recruiterPaymentIndex')}}">Payments</a>
            </li>
            <li class="{{ request()->is('recruiter-password-security') ||request()->is('recruiter-password-security-reset') ? 'active' : '' }}">
                <a class="passsecuri-link" href="{{route('showPasswordSecurityRecruiter')}}">Password &
                    Security</a>
            </li>
            <li class="{{ request()->is('recruiter-subscription-plan') ? 'active' : '' }}">
                <a class="subsc-link" href="{{route('getRecruiterSubscriptionPlanView')}}">Subscription Plan</a>
            </li>
            <li class="{{ request()->is('recruiter-notification-settings') ? 'active' : '' }}">
                <a class="noti-setting-link" href="{{route('notificationSettingRecruiter')}}">Notification
                    Settings</a>
            </li>
            <li class="{{ request()->is('notifications') ? 'active' : '' }}">
                <a class="noti-link" href="{{route('notifications')}}">Notifications</a>
            </li>
        </ul>
    </div>
</div>
