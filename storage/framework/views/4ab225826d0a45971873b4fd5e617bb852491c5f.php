<?php
use App\Models\User;
?>
<div class="app-header header-shadow bg-secondary bg-gradient ">
    <div class="app-header__logo">
        <div class="header__pane ml-auto">
            <div>
                <button type="button"
                    class="hamburger close-sidebar-btn hamburger--elastic <?php echo e(Session::get('toggleSidebar') ? 'is-active' : ''); ?>"
                    data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-secondary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>
    <div class="app-header__content">
        <div class="header-logo">
            <a href="">
                <img src="<?php echo e(url('public/images/Logo.svg')); ?>">
                <!-- <img src="<?php echo e(url('public/images/demo.png')); ?>" width="80px" height="50px"> -->
            </a>
        </div>

        <div class="app-header-right">
            <div class="header-dots">
                <div class="dropdown">
                    <?php
                        //to get loget in users notification type
                        if (User::getBackendRole() == config('app.superAdminRoleId')) {
                            $type = 4;
                        } elseif (User::getBackendRole() == config('app.candidateSpecialistRoleId')) {
                            $type = 5;
                        }else{
                            $type = 6;
                        }
                        
                        //To get count of notification
                        if ($type == 5) {
                            $unreadNotificationCount = getNotificationCount($type, Auth::guard('admin')->user()->id);
                        }elseif ($type == 6) {
                            $unreadNotificationCount = getNotificationCount($type, Auth::guard('admin')->user()->id);
                        } else {
                            $unreadNotificationCount = getNotificationCount($type);
                        }
                        
                        //To check display condition
                        $badegeDanger = '';
                        $pulse = '';
                        if ($unreadNotificationCount > 0) {
                            $badegeDanger = 'badge-danger';
                            $pulse = 'icon-anim-pulse';
                        }
                    ?>
                    <?php if($unreadNotificationCount > 0): ?>
                        <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown"
                            class="p-0 mr-2 btn btn-link">
                            <span class="icon-wrapper icon-wrapper-alt rounded-circle">
                                <span class="icon-wrapper-bg bg-danger"></span>
                                <i class="icon text-danger <?php echo e($pulse); ?> ion-android-notifications"></i>
                                <span class='badge badge-dot badge-dot-sm <?php echo e($badegeDanger); ?>'>Notifications</span>
                            </span>
                        </button>
                        <div tabindex="-1" role="menu" aria-hidden="true"
                            class="dropdown-menu-xl rm-pointers dropdown-menu dropdown-menu-right">
                            <div class="dropdown-menu-header mb-0">
                                <div class="dropdown-menu-header-inner bg-deep-blue">
                                    <div class="menu-header-image opacity-1"
                                        style="background-image: url('../assets/images/dropdown-header/city3.jpg');">
                                    </div>
                                    <div class="menu-header-content text-dark">
                                        <h5 class="menu-header-title">Notifications</h5>
                                        <h6 class="menu-header-subtitle">You have <b><?php echo e($unreadNotificationCount); ?></b>
                                            unread messages</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab-events-header" role="tabpanel">
                                    <div class="scroll-area-sm">
                                        <div class="scrollbar-container">
                                            <div class="p-3">
                                                <div
                                                    class="vertical-without-time vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
                                                    <?php
                                                        if ($type == 5) {
                                                            $notification = getNotifications($type, 3, Auth::guard('admin')->user()->id);
                                                        } else {
                                                            $notification = getNotifications($type, 3);
                                                        }
                                                    ?>
                                                    <?php $__currentLoopData = $notification; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $noti): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="vertical-timeline-item vertical-timeline-element">
                                                            <div><span
                                                                    class="vertical-timeline-element-icon bounce-in"><i
                                                                        class="badge badge-dot badge-dot-xl badge-success">
                                                                    </i></span>
                                                                <div
                                                                    class="vertical-timeline-element-content bounce-in">
                                                                    <h4 class="timeline-title">
                                                                        <?php echo e($noti['message_type']); ?></h4>
                                                                    <p><?php echo e($noti['message']); ?></p><span
                                                                        class="vertical-timeline-element-date"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <ul class="nav flex-column">
                                <li class="nav-item-divider nav-item"></li>
                                <li class="nav-item-btn text-center nav-item">
                                    <a href="<?php echo e(url('securerccontrol/notifications/index')); ?>"><button
                                            class="btn-shadow btn-wide btn-pill btn btn-focus btn-sm">View
                                            All</button></a>
                                </li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo e(url('securerccontrol/notifications/index')); ?>" type="button" aria-haspopup="true"
                            aria-expanded="false" data-toggle="" class="p-0 mr-2 btn btn-link">
                            <span class="icon-wrapper icon-wrapper-alt rounded-circle">
                                <span class="icon-wrapper-bg bg-danger"></span>
                                <i class="icon text-danger <?php echo e($pulse); ?> ion-android-notifications"></i>
                                <span class='badge badge-dot badge-dot-sm <?php echo e($badegeDanger); ?>'>Notifications</span>
                            </span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="header-btn-lg">
                <div class="widget-content">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                            <div class="btn-group">

                                <div tabindex="-1" role="menu" aria-hidden="true"
                                    class="rm-pointers dropdown-menu-lg dropdown-menu dropdown-menu-right">

                                    <div class="scroll-area-xs">
                                        <div class="scrollbar-container">
                                            <ul class="nav flex-column">

                                                <li class="nav-item">
                                                    <a href="<?php echo e(url(config('app.adminPrefix') . '/profile')); ?>"
                                                        class="nav-link">My Profile</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="<?php echo e(url(config('app.adminPrefix') . '/change/password')); ?>"
                                                        class="nav-link">Change Password
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="<?php echo e(url(config('app.adminPrefix') . '/logout')); ?>"
                                                        class="nav-link">Logout

                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">

                            <div class="widget-content-left  ml-3 header-user-info">
                                <div class="widget-heading">
                                    <?php echo e(Session::get('username')); ?>

                                    <i class="fa fa-angle-down ml-2 opacity-8"></i>

                                </div>
                                <div class="widget-subheading">
                                    <!-- VP People Manager -->
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .header-search input {
        padding-top: 5px;
    }

</style>
<?php /**PATH /var/www/html/php/reqcity/resources/views/admin/include/header.blade.php ENDPATH**/ ?>