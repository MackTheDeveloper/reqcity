<div class="sideMenu">
    <div class="side-menu-profile">
        <img src="{{ asset('public/assets/frontend/img/close.svg') }}" class="closeIcons">
    </div>
    {{-- <div class="first-menu">
        <ul>
            <li>
                <a href="index.html">
                    <p class="s2">Book a Demo</p>
                </a>
            </li>
            <li>
                <a href="my-collection.html">
                    <p class="s2">Why ReqCity</p>
                </a>
            </li>
        </ul>
    </div> --}}
    <div class="side-menu-content">
        <ul>
            @if (Auth::check())
                @if (Auth::user()->role_id == '3')
                    <li class="side-menu-dropdown">
                        <p class="tm">Jobs</p>
                        <div class="menu-collapse-wrapper">
                            <div class="menu-collapse">
                                <a class="dropdown-item" href="{{ url('/company-jobs/open') }}">Active Jobs</a>
                                <a class="dropdown-item" href="{{ url('/company-jobs/') }}">All Job Posts</a>
                                <a class="dropdown-item" href="{{ route('showCompanyJobDetails', 'newPost') }}">Post
                                    a Job</a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <a href="{{ route('showCompanyCandidate') }}">
                            <p class="tm">Candidates</p>
                        </a>
                    </li>
                @else
                    <li class="side-menu-dropdown">
                        <p class="tm">Jobs</p>
                        <div class="menu-collapse-wrapper">
                            <div class="menu-collapse">
                                <a class="dropdown-item" href="{{ url('/recruiter-jobs/all') }}">All Jobs</a>
                                <a class="dropdown-item" href="{{ url('/recruiter-jobs/favorites') }}">Favorites</a>
                                <a class="dropdown-item" href="{{ url('/recruiter-jobs/submitted') }}">Submitted</a>
                                <a class="dropdown-item" href="{{ url('/recruiter-jobs/similar') }}">Similar</a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <a href="{{route('recruiterCandidates')}}">
                            <p class="tm">Candidates</p>
                        </a>
                    </li>
                @endif
            @else
                <li>
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#bookADemo">
                        <p class="tm">Book a Demo</p>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/why-reqcity') }}">
                        <p class="tm">Why ReqCity</p>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</div>
<div class="mobile-search-bar">
    <div class="container">
        <form class="searchbar-close" id="searchFront" method="GET" action="{{ route('searchFront') }}"
            autocomplete="off">
            <button class="this-search-btn">
                <img src="{{ asset('public/assets/frontend/img/search.svg') }}" alt="" />
            </button>
            <input placeholder="Search" class="input" />
            <button class="this-close-btn">
                <img src="{{ asset('public/assets/frontend/img/close.svg') }}" alt="" />
            </button>
        </form>
    </div>
</div>
