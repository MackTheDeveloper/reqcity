<div class="app-sidebar sidebar-shadow">
    <div class="app-header__logo">
        <div class="logo-src"></div>
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
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>
    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">
                <li class="app-sidebar__heading text-secondary">Menu</li>
                <?php if(Auth::guard('admin')->check() && whoCanCheck(config('app.arrWhoCanCheck'), 'admin_dashboard') === true): ?>
                    <li class="<?php echo e(request()->is('securerccontrol/dashboard') ? 'mm-active' : ''); ?>">
                        <a href="<?php echo e(url('/securerccontrol/dashboard')); ?>">
                            <i class="active_icon metismenu-icon pe-7s-rocket"></i>
                            Dashboard
                        </a>
                    </li>
                <?php endif; ?>

                <?php if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_role_listing') === true || whoCanCheck(config('app.arrWhoCanCheck'), 'admin_user_listing') === true || whoCanCheck(config('app.arrWhoCanCheck'), 'admin_candidate_listing') === true): ?>
                    <li>
                        <a href="#">
                            <i class="active_icon metismenu-icon fa-2x fa pe-7s-users"></i>
                            Users
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul>
                            <?php if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_role_listing') === true): ?>
                                <li
                                    class="<?php echo e(request()->is('securerccontrol/user/role/list') || request()->is('securerccontrol/user/role/edit/*') || request()->is('securerccontrol/user/role/add') ? 'mm-active' : ''); ?>">
                                    <a href="<?php echo e(url('securerccontrol/user/role/list')); ?>">
                                        <i class="metismenu-icon"></i>
                                        Roles
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_user_listing') === true): ?>
                                <li
                                    class="<?php echo e(request()->is('securerccontrol/user/list') || request()->is('securerccontrol/user/add') || request()->is('securerccontrol/user/edit/*') ? 'mm-active' : ''); ?>">
                                    <a href="<?php echo e(url('securerccontrol/user/list')); ?>">
                                        <i class="metismenu-icon">
                                        </i>
                                        Users
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_candidate_listing') === true): ?>
                                <li
                                    class="<?php echo e(request()->is('securerccontrol/candidate/index') || request()->is('securerccontrol/user/add') || request()->is('securerccontrol/user/edit/*') ? 'mm-active' : ''); ?>">
                                    <a href="<?php echo e(url('securerccontrol/candidate/index')); ?>">
                                        <i class="metismenu-icon">
                                        </i>
                                        Candidates
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_categories_listing') === true || whoCanCheck(config('app.arrWhoCanCheck'), 'admin_job_field_listing') === true || whoCanCheck(config('app.arrWhoCanCheck'), 'job-field-options') === true || whoCanCheck(config('app.arrWhoCanCheck'), 'admin_job_balance_transfer_requests_listing') === true || whoCanCheck(config('app.arrWhoCanCheck'), 'admin_highlighted_job_listing') === true || whoCanCheck(config('app.arrWhoCanCheck'), 'admin_assigned_job_listing') === true || whoCanCheck(config('app.arrWhoCanCheck'), 'admin_candidate_jobs_listing') === true): ?>
                    <li>
                        <a href="#">
                            <i class="active_icon metismenu-icon pe-7s-portfolio"></i>
                            Job Management
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul>
                            <?php if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_categories_listing') === true): ?>
                                <li
                                    class="<?php echo e(request()->is('securerccontrol/category/index') || request()->is('securerccontrol/category/edit/*') || request()->is('securerccontrol/category/add') ? 'mm-active' : ''); ?>">
                                    <a href="<?php echo e(url('securerccontrol/category/index')); ?>">
                                        <i class="metismenu-icon"></i>
                                        Job Categories
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_job_field_listing') === true): ?>
                                <li
                                    class="<?php echo e(request()->is('securerccontrol/job-fields/index') || request()->is('securerccontrol/job-fields/edit/*') || request()->is('securerccontrol/job-fields/add') ? 'mm-active' : ''); ?>">
                                    <a href="<?php echo e(url('securerccontrol/job-fields/index')); ?>">
                                        <i class="metismenu-icon"></i>
                                        Job Fields
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_job_field_options_listing') === true): ?>
                                <li
                                    class="<?php echo e(request()->is('securerccontrol/job-field-options/index') || request()->is('securerccontrol/job-field-options/edit/*') || request()->is('securerccontrol/job-field-options/add') ? 'mm-active' : ''); ?>">
                                    <a href="<?php echo e(url('securerccontrol/job-field-options/index')); ?>">
                                        <i class="metismenu-icon"></i>
                                        Job Field Options
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_job_balance_transfer_requests_listing') === true): ?>
                                <li
                                    class="<?php echo e(request()->is('securerccontrol/job-balance-transfer-requests/index') ? 'mm-active' : ''); ?>">
                                    <a href="<?php echo e(url('securerccontrol/job-balance-transfer-requests/index')); ?>">
                                        <i class="metismenu-icon"></i>
                                        Balance Transfer Requests
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_highlighted_job_listing') === true): ?>
                                <li
                                    class="<?php echo e(request()->is('securerccontrol/highlighted-jobs/index') ? 'mm-active' : ''); ?>">
                                    <a href="<?php echo e(url('securerccontrol/highlighted-jobs/index')); ?>">
                                        <i class="metismenu-icon"></i>
                                        Highlighted Jobs
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_candidate_jobs_listing') === true): ?>
                                <li
                                    class="<?php echo e(request()->is('securerccontrol/candidate-jobs/index') ? 'mm-active' : ''); ?>">
                                    <a href="<?php echo e(url('securerccontrol/candidate-jobs/index')); ?>">
                                        <i class="metismenu-icon"></i>
                                        Candidate Jobs
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_assigned_job_listing') === true): ?>
                                <li
                                    class="<?php echo e(request()->is('securerccontrol/assigned-jobs/index') ? 'mm-active' : ''); ?>">
                                    <a href="<?php echo e(url('securerccontrol/assigned-jobs/index')); ?>">
                                        <i class="metismenu-icon"></i>
                                        Assigned Jobs
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_recruiter_listing') === true): ?>
                    <li>
                        <a href="#">
                            <i class="active_icon metismenu-icon pe-7s-news-paper"></i>
                            Recruiter Management
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul>
                            <?php if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_recruiter_listing') === true): ?>
                                <li
                                    class="<?php echo e(request()->is('securerccontrol/recruiters/index') ? 'mm-active' : ''); ?>">
                                    <a href="<?php echo e(url('/securerccontrol/recruiters/index')); ?>">
                                        <i class="active_icon metismenu-icon pe-7s-look"></i>
                                        Recruiters
                                    </a>
                                </li>
                            <?php endif; ?>
                                
                                
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_company_listing') === true): ?>
                    <li class="<?php echo e(request()->is('securerccontrol/companies/index') ? 'mm-active' : ''); ?>">
                        <a href="<?php echo e(url('/securerccontrol/companies/index')); ?>">
                            <i class="active_icon metismenu-icon pe-7s-culture"></i>
                            Company Management
                        </a>
                    </li>
                <?php endif; ?>
                
                <?php if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_subscription_plan_listing') === true || whoCanCheck(config('app.arrWhoCanCheck'), 'admin_plan_features_listing') === true || whoCanCheck(config('app.arrWhoCanCheck'), 'admin_email_templates_listing') === true || whoCanCheck(config('app.arrWhoCanCheck'), 'admin_footer_listing') === true || whoCanCheck(config('app.arrWhoCanCheck'), 'admin_general_setting_update') === true): ?>
                    <li>
                        <a href="#">
                            <i class="active_icon metismenu-icon pe-7s-config"></i>
                            Settings
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul>
                            <?php if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_subscription_plan_listing') === true): ?>
                                <li
                                    class="<?php echo e(request()->is('securerccontrol/subscription-plan/index') || request()->is('securerccontrol/subscription-plan/edit/*') || request()->is('securerccontrol/category/add') ? 'mm-active' : ''); ?>">
                                    <a href="<?php echo e(url('securerccontrol/subscription-plan/index')); ?>">
                                        <i class="metismenu-icon"></i>
                                        Subscription Plans
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_plan_features_listing') === true): ?>
                                <li
                                    class="<?php echo e(request()->is('securerccontrol/plan-features/index') || request()->is('securerccontrol/subscription-plan/edit/*') || request()->is('securerccontrol/category/add') ? 'mm-active' : ''); ?>">
                                    <a href="<?php echo e(url('securerccontrol/plan-features/index')); ?>">
                                        <i class="metismenu-icon"></i>
                                        Plan Features
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_email_templates_listing') === true): ?>
                                <li
                                    class="<?php echo e(request()->is('securerccontrol/email-templates/index') || request()->is('securefcbcontrol/email-templates/add') || request()->is('securefcbcontrol/email-templates/edit/*') ? 'mm-active' : ''); ?>">
                                    <a href="<?php echo e(url('securerccontrol/email-templates/index')); ?>">
                                        <i class="active_icon metismenu-icon pe-7s-mail"></i>
                                        Email Templates
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_general_setting_update') === true): ?>
                                <li
                                    class="<?php echo e(request()->is('securerccontrol/settings') || request()->is('securefcbcontrol/faq/addFaq') || request()->is('securefcbcontrol/faq/editFaq/*') ? 'mm-active' : ''); ?>">
                                    <a href="<?php echo e(url('securerccontrol/settings')); ?>">
                                        <i class="metismenu-icon">
                                        </i>
                                        General Settings
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_footer_listing') === true): ?>
                                <li
                                    class="<?php echo e(request()->is('securerccontrol/footer-link/index') ? 'mm-active' : ''); ?>">
                                    <a href="<?php echo e(url('/securerccontrol/footer-link/index')); ?>">
                                        <i class="active_icon metismenu-icon pe-7s-wallet"></i>
                                        Footer
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_company_subscription_listing') === true || whoCanCheck(config('app.arrWhoCanCheck'), 'admin_recruiter_subscription_listing') === true || whoCanCheck(config('app.arrWhoCanCheck'), 'admin_company_transaction_listing') === true || whoCanCheck(config('app.arrWhoCanCheck'), 'admin_recruiter_transaction_listing') === true || 
                whoCanCheck(config('app.arrWhoCanCheck'), 'admin_company_job_funding_listing') === true): ?>
                    <li>
                        <a href="#">
                            <i class="active_icon metismenu-icon pe-7s-cash"></i>
                            Sales
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul>
                            <?php if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_company_subscription_listing') === true): ?>
                                <li
                                    class="<?php echo e(request()->is('securerccontrol/company-subscriptions/index') || request()->is('securefcbcontrol/company-subscriptions/edit/*') || request()->is('securefcbcontrol/company-subscriptions/add') ? 'mm-active' : ''); ?>">
                                    <a href="<?php echo e(url('securerccontrol/company-subscriptions/index')); ?>">
                                        <i class="metismenu-icon"></i>
                                        Company Subscriptions
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_recruiter_subscription_listing') === true): ?>
                                <li
                                    class="<?php echo e(request()->is('securerccontrol/recruiter-subscriptions/index') || request()->is('securefcbcontrol/transaction/edit/*') || request()->is('securefcbcontrol/transaction/add') ? 'mm-active' : ''); ?>">
                                    <a href="<?php echo e(url('securerccontrol/recruiter-subscriptions/index')); ?>">
                                        <i class="metismenu-icon"></i>
                                        Recruiter Subscriptions
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_company_transaction_listing') === true): ?>
                                <li
                                    class="<?php echo e(request()->is('securerccontrol/company-transaction/index') ? 'mm-active' : ''); ?>">
                                    <a href="<?php echo e(url('securerccontrol/company-transaction/index')); ?>">
                                        <i class="metismenu-icon"></i>
                                        Company Transactions
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_recruiter_transaction_listing') === true): ?>
                                <li
                                    class="<?php echo e(request()->is('securerccontrol/recruiter-transaction/index') ? 'mm-active' : ''); ?>">
                                    <a href="<?php echo e(url('securerccontrol/recruiter-transaction/index')); ?>">
                                        <i class="metismenu-icon"></i>
                                        Recruiter Transactions
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_company_job_funding_listing') === true): ?>
                                <li
                                    class="<?php echo e(request()->is('securerccontrol/job-funding/index') ? 'mm-active' : ''); ?>">
                                    <a href="<?php echo e(url('securerccontrol/job-funding/index')); ?>">
                                        <i class="metismenu-icon"></i>
                                        Job Funds

                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_recruiter_payout_listing') === true || whoCanCheck(config('app.arrWhoCanCheck'), 'admin_recruiter_payment_listing') === true || whoCanCheck(config('app.arrWhoCanCheck'), 'admin_admin_commission_listing') === true): ?>
                    <li>
                        <a href="#">
                            <i class="active_icon metismenu-icon pe-7s-timer"></i>
                            Payment History
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul>
                            <?php if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_recruiter_payout_listing') === true): ?>
                                <li
                                    class="<?php echo e(request()->is('securerccontrol/recruiter-payouts/index') ? 'mm-active' : ''); ?>">
                                    <a href="<?php echo e(url('securerccontrol/recruiter-payouts/index')); ?>">
                                        <i class="metismenu-icon"></i>
                                        Recruiter Payouts
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_recruiter_payment_listing') === true): ?>
                                <li
                                    class="<?php echo e(request()->is('securerccontrol/recruiter-payment/index') ? 'mm-active' : ''); ?>">
                                    <a href="<?php echo e(url('securerccontrol/recruiter-payment/index')); ?>">
                                        <i class="metismenu-icon"></i>
                                        Recruiter Payment
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_admin_commission_listing') === true): ?>
                                <li
                                    class="<?php echo e(request()->is('securerccontrol/admin-commission/index') ? 'mm-active' : ''); ?>">
                                    <a href="<?php echo e(url('securerccontrol/admin-commission/index')); ?>">
                                        <i class="metismenu-icon"></i>
                                        Admin Commission
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_cms_page_listing') === true || whoCanCheck(config('app.arrWhoCanCheck'), 'admin_home_page_banner_listing') === true || whoCanCheck(config('app.arrWhoCanCheck'), 'admin_how_it_works_listing') === true): ?>
                    <li>
                        <a href="#">
                            <i class="active_icon metismenu-icon pe-7s-global"></i>
                            Website Management
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul>
                            <?php if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_home_page_banner_listing') === true): ?>
                                <li
                                    class="<?php echo e(request()->is('securerccontrol/home-page-banner/index') ? 'mm-active' : ''); ?>">
                                    <a href="<?php echo e(url('securerccontrol/home-page-banner/index')); ?>">
                                        <i class="metismenu-icon"></i>
                                        Home Page Banner
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_cms_page_listing') === true): ?>
                                <li class="<?php echo e(request()->is('securerccontrol/cms-page/list') ? 'mm-active' : ''); ?>">
                                    <a href="<?php echo e(url('/securerccontrol/cms-page/list')); ?>">
                                        <i class="active_icon metismenu-icon pe-7s-wallet"></i>
                                        CMS Pages
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_how_it_works_listing') === true): ?>
                                <li
                                    class="<?php echo e(request()->is('securerccontrol/how-it-works/index') ? 'mm-active' : ''); ?>">
                                    <a href="<?php echo e(url('/securerccontrol/how-it-works/index')); ?>">
                                        <i class="active_icon metismenu-icon pe-7s-wallet"></i>
                                        How It Works
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_contact_us_listing') === true || whoCanCheck(config('app.arrWhoCanCheck'), 'admin_book_demo_request_listing') === true): ?>
                    <li>
                        <a href="#">
                            <i class="active_icon metismenu-icon pe-7s-headphones"></i>
                            Enquiries
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul>
                            <?php if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_contact_us_listing') === true): ?>
                                <li class="<?php echo e(request()->is('securerccontrol/contactUs') ? 'mm-active' : ''); ?>">
                                    <a href="<?php echo e(url('/securerccontrol/contactUs')); ?>">
                                        <i class="active_icon metismenu-icon pe-7s-headphones"></i>
                                        Contact Us
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(whoCanCheck(config('app.arrWhoCanCheck'), 'admin_book_demo_request_listing') === true): ?>
                                <li
                                    class="<?php echo e(request()->is('securerccontrol/book-demo-requests/index') ? 'mm-active' : ''); ?>">
                                    <a href="<?php echo e(url('/securerccontrol/book-demo-requests/index')); ?>">
                                        <i class="active_icon metismenu-icon pe-7s-wallet"></i>
                                        Book a Demo Requests
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/php/reqcity/resources/views/admin/include/sidebar.blade.php ENDPATH**/ ?>