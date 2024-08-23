<div class="col-12 col-sm-12 col-md-4 col-lg-3">
    <div class="left-sides-bar">
        <div class="dropdowns">...</div>
        <ul class="dropdowns-toggles">
            <li class="{{ request()->is('candidate-dashboard')  ? 'active' : '' }}">
                <a class="dashboard-link" href="{{ route('showCandidateDashboard') }}">Dashboard</a>
            </li>
            <li class="{{ request()->is('candidate-myinfo') ? 'active' : '' }}">
                <a class="myinfo-link" href="{{route('showMyInfoCandidate')}}">My Info</a>
            </li>
            <li class="{{ request()->is('candidate-password-security') ||request()->is('candidate-password-security-reset') ? 'active' : '' }}">
                <a class="passsecuri-link" href="{{route('showPasswordSecurityCandidate')}}">Password &
                    Security</a>
            </li>
            <li class="{{ request()->is('candidate-notification-settings') ? 'active' : '' }}">
                <a class="noti-setting-link" href="{{route('notificationSettingCandidate')}}">Notification
                    Settings</a>
            </li>
            <li class="{{ request()->is('notifications') ? 'active' : '' }}">
                <a class="noti-link" href="{{route('notifications')}}">Notifications</a>
            </li>
        </ul>
    </div>
</div>