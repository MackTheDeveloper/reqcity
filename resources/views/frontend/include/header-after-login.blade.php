<?php

use App\Models\UserProfilePhoto;
use App\Models\LocationGroup;

?>
<header class="{{ Route::current()->getName() != 'home' ? 'top-shadow' : '' }}">
    <div class="container">
        <nav class="navbar navbar-expand">
            <img src="{{ asset('public/assets/frontend/img/menu.svg') }}" class="menu-icon show-991">
            <a class="navbar-brand" href="{{url('/')}}">
                <img src="{{ asset('public/assets/frontend/img/Logo.svg') }}" alt="" />
            </a>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav mr-auto">
                    @if(Auth::user()->role_id == 4)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="navbardrop" data-toggle="dropdown">
                            Jobs
                        </a>
                        <div class="dropdown-menu left-menu">
                            <a class="dropdown-item" href="{{url('/recruiter-jobs/all')}}">All Jobs</a>
                            <a class="dropdown-item" href="{{url('/recruiter-jobs/favorites')}}">Favorites</a>
                            <a class="dropdown-item" href="{{url('/recruiter-jobs/submitted')}}">Submitted</a>
                            <a class="dropdown-item" href="{{url('/recruiter-jobs/similar')}}">Similar</a>
                        </div>
                    </li>
                    @elseif(Auth::user()->role_id == 5)
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="{{route('findJobs')}}" id="navbardrop">
                            Find Jobs
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="navbardrop" data-toggle="dropdown">
                            Jobs
                        </a>
                        <div class="dropdown-menu left-menu">
                            <a class="dropdown-item" href="{{url('/candidate-jobs/all')}}">All Jobs</a>
                            <a class="dropdown-item" href="{{url('/candidate-jobs/favorites')}}">Favorites</a>
                            <a class="dropdown-item" href="{{url('/candidate-jobs/applied')}}">Applied</a>
                            <a class="dropdown-item" href="{{url('/candidate-jobs/similar')}}">Similar</a>
                        </div>
                    </li>
                    @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="navbardrop" data-toggle="dropdown">
                            Jobs
                        </a>
                        <div class="dropdown-menu left-menu">
                            <a class="dropdown-item" href="#">Active Jobs</a>
                            <a class="dropdown-item" href="#">All Job Posts</a>
                            <a class="dropdown-item" href="#">Post a Job</a>
                        </div>
                    </li>
                    @endif
                    @if(Auth::user()->role_id != 5)
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="{{route('recruiterCandidates')}}" id="navbardrop">
                            Candidates
                        </a>
                        {{--<div class="dropdown-menu left-menu">
                            <a class="dropdown-item" href="#">Active Jobs</a>
                            <a class="dropdown-item" href="#">All Job Posts</a>
                            <a class="dropdown-item" href="#">Post a Job</a>
                        </div>--}}
                    </li>
                    @endif
                </ul>
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                      <form id="searchFront" method="GET" action="{{ route('searchFront') }}" autocomplete="off">
                      <div class="header-search">
                          <input placeholder="Search" class="input" name="search"/>
                          <button><img src="{{ asset('public/assets/frontend/img/search.svg') }}" alt="" /></button>
                      </div>
                    </form>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto after-login">
                    <li class="nav-item dropdown notification-dropdown">
                        <a class="nav-link dropdown-toggle notification" href="{{route('notifications')}}">
                          @php $activeClass=''; @endphp
                          @if(getUnreadNotificationCount() >0)
                          @php $activeClass='active';@endphp
                          @endif
                            <div class="noti-wrapper  {{$activeClass}}">
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
                            @elseif(Auth::user()->role_id == 5)
                            <img src="{{ Auth::user()->getCandidateImage() }}" alt="" />
                            @else
                            <img src="{{ asset('public/assets/frontend/img/user-img.svg') }}" alt="" />
                            @endif

                        </a>
                        <div class="dropdown-menu right-menu">
                            @if (Auth::user()->role_id == 4)
                            <a class="dropdown-item" href="{{route('showRecruiterDashboard')}}">Dashboard</a>
                            @else
                            <a class="dropdown-item" href="{{route('showCandidateDashboard')}}">Dashboard</a>
                            @endif

                            @if(Auth::user()->role_id == 5)
                            <a class="dropdown-item" href="{{route('showMyInfoCandidate')}}">My Profile</a>
                            @else
                            <a class="dropdown-item" href="{{route('showMyInfoRecruiter')}}">My Profile</a>
                            @endif
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
