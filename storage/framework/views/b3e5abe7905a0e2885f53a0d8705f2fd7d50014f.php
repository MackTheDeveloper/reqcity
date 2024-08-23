<div class="sideMenu">
    <div class="side-menu-profile">
        <img src="<?php echo e(asset('public/assets/frontend/img/close.svg')); ?>" class="closeIcons">
    </div>
    
    <div class="side-menu-content">
        <ul>
            <?php if(Auth::check()): ?>
                <?php if(Auth::user()->role_id == '3'): ?>
                    <li class="side-menu-dropdown">
                        <p class="tm">Jobs</p>
                        <div class="menu-collapse-wrapper">
                            <div class="menu-collapse">
                                <a class="dropdown-item" href="<?php echo e(url('/company-jobs/open')); ?>">Active Jobs</a>
                                <a class="dropdown-item" href="<?php echo e(url('/company-jobs/')); ?>">All Job Posts</a>
                                <a class="dropdown-item" href="<?php echo e(route('showCompanyJobDetails', 'newPost')); ?>">Post
                                    a Job</a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <a href="<?php echo e(route('showCompanyCandidate')); ?>">
                            <p class="tm">Candidates</p>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="side-menu-dropdown">
                        <p class="tm">Jobs</p>
                        <div class="menu-collapse-wrapper">
                            <div class="menu-collapse">
                                <a class="dropdown-item" href="<?php echo e(url('/recruiter-jobs/all')); ?>">All Jobs</a>
                                <a class="dropdown-item" href="<?php echo e(url('/recruiter-jobs/favorites')); ?>">Favorites</a>
                                <a class="dropdown-item" href="<?php echo e(url('/recruiter-jobs/submitted')); ?>">Submitted</a>
                                <a class="dropdown-item" href="<?php echo e(url('/recruiter-jobs/similar')); ?>">Similar</a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <a href="<?php echo e(route('recruiterCandidates')); ?>">
                            <p class="tm">Candidates</p>
                        </a>
                    </li>
                <?php endif; ?>
            <?php else: ?>
                <li>
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#bookADemo">
                        <p class="tm">Book a Demo</p>
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(url('/why-reqcity')); ?>">
                        <p class="tm">Why ReqCity</p>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</div>
<div class="mobile-search-bar">
    <div class="container">
        <form class="searchbar-close" id="searchFront" method="GET" action="<?php echo e(route('searchFront')); ?>"
            autocomplete="off">
            <button class="this-search-btn">
                <img src="<?php echo e(asset('public/assets/frontend/img/search.svg')); ?>" alt="" />
            </button>
            <input placeholder="Search" class="input" />
            <button class="this-close-btn">
                <img src="<?php echo e(asset('public/assets/frontend/img/close.svg')); ?>" alt="" />
            </button>
        </form>
    </div>
</div>
<?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/include/sidebar.blade.php ENDPATH**/ ?>