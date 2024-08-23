<?php

use App\Models\UserProfilePhoto;
use App\Models\LocationGroup;

?>
<header class="{{ Route::current()->getName() != 'home' ? 'top-shadow' : '' }}">
    <!--------------------------
    WEB HEADER START
--------------------------->
    <div class="container">
        <nav class="navbar navbar-expand">
            <img src="{{ asset('public/assets/frontend/img/menu.svg') }}" class="menu-icon show-991">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('public/assets/frontend/img/Logo.svg') }}" alt="" />
            </a>
            <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
      </button> -->
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0)" data-toggle="modal"
                            data-target="#bookADemo">Book a Demo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/why-reqcity') }}">Why ReqCity</a>
                    </li>
                </ul>
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <form class="header-search" id="searchFront" method="GET" action="{{ route('searchFront') }}"
                            autocomplete="off">
                            <input placeholder="Search" class="input" name="search" />
                            <button><img src="{{ asset('public/assets/frontend/img/search.svg') }}" alt="" /></button>
                        </form>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item hide-991">
                        <a href="{{ route('login') }}" class="text-btn">Log In</a>
                    </li>
                    <li class="nav-item hide-991 mr-0">
                        <a href="{{ url('/signup') }}" class="fill-btn">Sign Up</a>
                    </li>

                    {{-- <li class="nav-item show-991">
                        <a href="javascript:void(0)" class="header-icons">
                            <img src="{{ asset('public/assets/frontend/img/only-search.svg') }}" svg" alt="" />
                        </a>
                    </li>
                    <li class="nav-item show-991">
                        <a href="javascript:void(0)" class="header-icons">
                            <img src="{{ asset('public/assets/frontend/img/user.svg') }}" alt="" />
                        </a>
                    </li> --}}
                    <li class="nav-item show-991">
                        <a href="javascript:void(0)" class="header-icons search-open">
                            <img src="{{ asset('public/assets/frontend/img/only-search.svg') }}" svg" alt="" />
                        </a>
                    </li>
                    <li class="nav-item dropdown user-dropdown show-991">
                        <a class="nav-link dropdown-toggle user-img" href="javascript:void(0)" data-toggle="dropdown">
                            <img src="{{ asset('public/assets/frontend/img/user.svg') }}" alt="" />
                        </a>
                        <div class="dropdown-menu right-menu">
                            <a class="dropdown-item" href="{{ route('login') }}">Log In</a>
                            <a class="dropdown-item" href="{{ url('/signup') }}">Sign Up</a>
                        </div>
                    </li>

                </ul>
            </div>
        </nav>
    </div>

    @include('frontend.include.sidebar')
    <div class="backBg"></div>
</header>
<!--------------------------
    WEB HEADER END
--------------------------->
