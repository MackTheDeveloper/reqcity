<?php

use App\Models\UserProfilePhoto;
use App\Models\LocationGroup;

?>
<header class="<?php echo e(Route::current()->getName() != 'home' ? 'top-shadow' : ''); ?>">
    <div class="container">
        <nav class="navbar navbar-expand">
            <img src="<?php echo e(asset('public/assets/frontend/img/menu.svg')); ?>" class="menu-icon show-991">
            <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
                <img src="<?php echo e(asset('public/assets/frontend/img/Logo.svg')); ?>" alt="" />
            </a>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav mr-auto">
                    <?php if(whoCanCheckFront('company_job_view') || whoCanCheckFront('company_job_post')): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="navbardrop"
                                data-toggle="dropdown">
                                Jobs
                            </a>
                            <div class="dropdown-menu left-menu">
                                <?php if(whoCanCheckFront('company_job_view')): ?>
                                    <a class="dropdown-item" href="<?php echo e(url('/company-jobs/open')); ?>">Active Jobs</a>
                                    <a class="dropdown-item" href="<?php echo e(url('/company-jobs/')); ?>">All Job Posts</a>
                                <?php endif; ?>
                                <?php if(whoCanCheckFront('company_job_post')): ?>
                                    <!-- <a class="dropdown-item" href="<?php echo e(route('jobDetailsShow')); ?>">Post a Job</a> -->
                                    <a class="dropdown-item" href="<?php echo e(route('showCompanyJobDetails', 'newPost')); ?>">Post
                                        a Job</a>
                                <?php endif; ?>
                            </div>
                        </li>
                    <?php endif; ?>
                    <?php if(whoCanCheckFront('company_candidate_view') || whoCanCheckFront('company_candidate_post')): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="<?php echo e(route('showCompanyCandidate')); ?>"
                                id="navbardrop">
                                Candidates
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <form class="header-search" id="searchFront" method="GET" action="<?php echo e(route('searchFront')); ?>"
                            autocomplete="off">
                            <input placeholder="Search" class="input" name="search" />
                            <button><img src="<?php echo e(asset('public/assets/frontend/img/search.svg')); ?>"
                                    alt="" /></button>
                        </form>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto after-login">
                    <li class="nav-item show-991">
                        <a href="javascript:void(0)" class="header-icons search-open">
                            <img src="<?php echo e(asset('public/assets/frontend/img/only-search.svg')); ?>" svg" alt="" />
                        </a>
                    </li>
                    <li class="nav-item dropdown notification-dropdown">
                        <a class="nav-link dropdown-toggle notification" href="<?php echo e(route('notifications')); ?>">
                            <?php $activeClass=''; ?>
                            <?php if(getUnreadNotificationCount() > 0): ?>
                                <?php $activeClass='active';?>
                            <?php endif; ?>
                            <div class="noti-wrapper <?php echo e($activeClass); ?>">
                                <img src="<?php echo e(asset('public/assets/frontend/img/notification-icon.svg')); ?>" alt="" />
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
                            <?php if(Auth::user()->role_id == 3): ?>
                                <img src="<?php echo e(Auth::user()->getCompanyLogo()); ?>" alt="" />
                            <?php else: ?>
                                <img src="<?php echo e(asset('public/assets/frontend/img/user-img.svg')); ?>" alt="" />
                            <?php endif; ?>

                        </a>
                        <div class="dropdown-menu right-menu">
                            <a class="dropdown-item" href="<?php echo e(route('showDashboard')); ?>">Dashboard</a>
                            <a class="dropdown-item" href="<?php echo e(route('showMyInfoCompany')); ?>">My Profile</a>
                            <a class="dropdown-item" href="<?php echo e(route('logout')); ?>">Log out</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>




    <?php echo $__env->make('frontend.include.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="backBg"></div>
    <!--------------------------
    WEB HEADER END
--------------------------->
</header>
<?php /**PATH /var/www/html/php/reqcity/resources/views/frontend/include/header-company-login.blade.php ENDPATH**/ ?>