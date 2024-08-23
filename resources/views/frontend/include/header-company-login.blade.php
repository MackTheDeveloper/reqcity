<?php

use App\Models\UserProfilePhoto;
use App\Models\LocationGroup;

?>
<header class="{{ Route::current()->getName() != 'home' ? 'top-shadow' : '' }}">
    <div class="container">
        <nav class="navbar navbar-expand">
            <img src="{{ asset('public/assets/frontend/img/menu.svg') }}" class="menu-icon show-991">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('public/assets/frontend/img/Logo.svg') }}" alt="" />
            </a>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav mr-auto">
                    @if (whoCanCheckFront('company_job_view') || whoCanCheckFront('company_job_post'))
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="navbardrop"
                                data-toggle="dropdown">
                                Jobs
                            </a>
                            <div class="dropdown-menu left-menu">
                                @if (whoCanCheckFront('company_job_view'))
                                    <a class="dropdown-item" href="{{ url('/company-jobs/open') }}">Active Jobs</a>
                                    <a class="dropdown-item" href="{{ url('/company-jobs/') }}">All Job Posts</a>
                                @endif
                                @if (whoCanCheckFront('company_job_post'))
                                    <!-- <a class="dropdown-item" href="{{ route('jobDetailsShow') }}">Post a Job</a> -->
                                    <a class="dropdown-item" href="{{ route('showCompanyJobDetails', 'newPost') }}">Post
                                        a Job</a>
                                @endif
                            </div>
                        </li>
                    @endif
                    @if (whoCanCheckFront('company_candidate_view') || whoCanCheckFront('company_candidate_post'))
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="{{ route('showCompanyCandidate') }}"
                                id="navbardrop">
                                Candidates
                            </a>
                        </li>
                    @endif
                </ul>
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <form class="header-search" id="searchFront" method="GET" action="{{ route('searchFront') }}"
                            autocomplete="off">
                            <input placeholder="Search" class="input" name="search" />
                            <button><img src="{{ asset('public/assets/frontend/img/search.svg') }}"
                                    alt="" /></button>
                        </form>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto after-login">
                    <li class="nav-item show-991">
                        <a href="javascript:void(0)" class="header-icons search-open">
                            <img src="{{ asset('public/assets/frontend/img/only-search.svg') }}" svg" alt="" />
                        </a>
                    </li>
                    <li class="nav-item dropdown notification-dropdown">
                        <a class="nav-link dropdown-toggle notification" href="{{ route('notifications') }}">
                            @php $activeClass=''; @endphp
                            @if (getUnreadNotificationCount() > 0)
                                @php $activeClass='active';@endphp
                            @endif
                            <div class="noti-wrapper {{ $activeClass }}">
                                <img src="{{ asset('public/assets/frontend/img/notification-icon.svg') }}" alt="" />
                            </div>
                        </a>
                        <!-- <div class="dropdown-menu right-menu">
                            <a class="dropdown-item" href="#">Active Jobs</a>
                            <a class="dropdown-item" href="#">All Job Posts</a>
                            <a class="dropdown-item" href="#">Post a Job</a>
                        </div> -->
                    </li>
                    <li class="nav-item dropdown user-dropdown">
                        <a class="nav-link dropdown-toggle user-img" href="javascript:void(0)" data-toggle="dropdown">
                            @if (Auth::user()->role_id == 3)
                                <img src="{{ Auth::user()->getCompanyLogo() }}" alt="" />
                            @else
                                <img src="{{ asset('public/assets/frontend/img/user-img.svg') }}" alt="" />
                            @endif

                        </a>
                        <div class="dropdown-menu right-menu">
                            <a class="dropdown-item" href="{{ route('showDashboard') }}">Dashboard</a>
                            <a class="dropdown-item" href="{{ route('showMyInfoCompany') }}">My Profile</a>
                            <a class="dropdown-item" href="{{ route('logout') }}">Log out</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>




    @include('frontend.include.sidebar')
    <div class="backBg"></div>
    <!--------------------------
    WEB HEADER END
--------------------------->
</header>
