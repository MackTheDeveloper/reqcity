<?php 
use App\Models\UserProfilePhoto;
use App\Models\LocationGroup;

?>
<!--------------------------
    WEB HEADER START
--------------------------->

<header class="desktop-header " style="width: 100%;">
    <nav class="main-nav navbar navbar-expand-sm bg-dark navbar-dark">
        <div class="container">
            <a class="navbar-brand d-not-991" href="{{url('/')}}">
                <img src="{{asset('public/assets/frontend/img/Logo-1.svg')}}" alt="logo">
            </a>
            <ul class="navbar-nav m-auto">
                <li class="nav-item">
                    <form class="header-search" action="{{ route('search') }}" id="searchForm">
                        <div class="location">
                            <a href="javascript:void(0)">
                                <img src="{{asset('public/assets/frontend/img/map-pin.svg')}}">
                            </a>
                            <input type="text" placeholder="Search" value="{{ LocationGroup::getCurrentArea() }}" id="autocomplete_search" style="width: 100%;">
                        </div>
                        <input type="text" name="search" value="{{ request()->get('search') }}" placeholder="Search" id="searchText">
                        <button id="searchBtn"><img src="{{asset('public/assets/frontend/img/search.svg')}}"></button>
                    </form>
                    <div id="error-content" class="px-3"></div>
                </li>
            </ul>

            @if(Auth::check())
                <!-----------------------------------
                   after login use this code start  
                ------------------------------------>

                <ul class="navbar-nav myac-dropdown d-not-991">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{UserProfilePhoto::getProfilePhoto(Auth::user()->id)}}" class="nav-profile">
                            {{-- <img src="{{asset('public/assets/frontend/img/pp.png')}}" class="nav-profile"> --}}
                            <strong>{{Auth::user()->firstname.' '.Auth::user()->lastname }}</strong>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                            <a class="dropdown-item" href="{{ url('account/profile') }}">
                                <img src="{{asset('public/assets/frontend/img/acc-order.svg')}}" class="nav-ac-img">
                                My Account
                            </a>
                        </div>
                    </li>
                </ul>
                <!-----------------------------------
                   after login use this code start  
                ------------------------------------>
            @else
                <!-----------------------------------
                   Before login use this code star  
                ----------------------------------->
            <ul class="navbar-nav d-not-991">
                <li class="nav-item center-line">
                    <a class="nav-link" href="{{url('login')}}">SIGN IN</a>
                </li>
                <li class="nav-item center-line">
                    <a class="nav-link" href="{{url('signup')}}">REGISTER</a>
                </li>
            </ul>
                <!-----------------------------------
                   Before login use this code end  
                ----------------------------------->
            @endif

        </div>
    </nav>

    <nav class="navbar-menu d-not-991">
        <ul>
            <li class="nav-items pblur {{Route::currentRouteName() == 'professional.list' ? 'active' : ''}}">
                <a href="{{route('professional.list')}}">PROFESSIONAL</a>
            </li>
            <li class="nav-items pblur {{Route::currentRouteName() == 'product.list' ? 'active' : ''}}">
                <a href="{{route('product.list')}}">PRODUCTS</a>
            </li>
            <li class="nav-items pblur {{Route::currentRouteName() == 'getDiscoverListing' ? 'active' : ''}}">
                <a href="{{route('getDiscoverListing')}}">DISCOVER</a>
            </li>
            <li class="nav-items pblur {{Route::currentRouteName() == 'getBlogListing' ? 'active' : ''}}">
                <a href="{{route('getBlogListing')}}">BLOG</a>
            </li>
        </ul>
    </nav>

</header>


<!--------------------------
    WEB HEADER END
--------------------------->





<!--------------------------
    MOBILE HEADER START
--------------------------->

<header class="Mobile-header d-show-991">
    <div class="container">
        <a href="{{url('/')}}" class="mobile-logo">
            <img src="{{asset('public/assets/frontend/img/Logo-1.svg')}}" alt="logo">
        </a>
        <div class="menu-icons">
            <div class="menus">
                <img src="{{asset('public/assets/frontend/img/Menu.svg')}}" class="menuIcons" alt="menu">
            </div>
            <div class="side-icons">
                <a href="{{ (Auth::check()) ? route('getMyProfile') : route('login') }}">
                    <img src="{{asset('public/assets/frontend/img/User.svg')}}" class="cart-icon" alt="user-icon">
                </a>
            </div>
        </div>
    </div>
    <div class="sideMenu">
        <div class="side-top-fixed">
            <img src="{{asset('public/assets/frontend/img/Close.svg')}}" class="closeIcons" alt="close">
        </div>
        <div class="sidebar-navigation">
            <ul>
                <li class="nav-items {{Route::currentRouteName() == 'professional.list' ? 'active' : ''}}">
                    <a href="{{route('professional.list')}}">PROFESSIONAL</a>
                </li>
                <li class="nav-items {{Route::currentRouteName() == 'product.list' ? 'active' : ''}}">
                    <a href="{{route('product.list')}}">PRODUCTS</a>
                </li>
                <li class="nav-items {{Route::currentRouteName() == 'getDiscoverListing' ? 'active' : ''}}">
                    <a href="{{route('getDiscoverListing')}}">DISCOVER</a>
                </li>
                <li class="nav-items {{Route::currentRouteName() == 'getBlogListing' ? 'active' : ''}}">
                    <a href="{{route('getBlogListing')}}">BLOG</a>
                </li>
            </ul>
        </div>
    </div>
</header>
<!--------------------------
    MOBILE HEADER END
--------------------------->