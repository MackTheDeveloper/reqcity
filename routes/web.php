<?php

use App\Http\Controllers\Admin\DemoController;
use App\Http\Controllers\Admin\FooterController;
use App\Http\Controllers\Admin\FooterNewController;
use Illuminate\Support\Facades\Route;

//Controller
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubscriptionPlanController;
use App\Http\Controllers\Admin\JobFieldController;
use App\Http\Controllers\Admin\JobFieldOptionController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\EmailTemplatesController;
use App\Http\Controllers\Admin\PlanFeaturesController;
use App\Http\Controllers\Admin\CmsPagesController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Admin\CompanySubscriptionController;
use App\Http\Controllers\Admin\RecruiterSubscriptionController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\CompanyTransactionController;
use App\Http\Controllers\Admin\RecruiterTransactionController;
use App\Http\Controllers\Admin\CompanyJobFundingController;
use App\Http\Controllers\Admin\RecruiterPayoutController;
use App\Http\Controllers\Admin\RecruiterTaxFormController;
use App\Http\Controllers\Admin\CandidateController;
use App\Http\Controllers\Admin\RecruiterPaymentController;
use App\Http\Controllers\Admin\AdminCommissionController;
use App\Http\Controllers\Admin\HomePageBannerController;
use App\Http\Controllers\Admin\JobBalanceTransferRequestsController;
use App\Http\Controllers\Admin\BookDemoRequestsController;
use App\Http\Controllers\Admin\HighlightedJobController;
use App\Http\Controllers\Admin\HowItWorksController;
use App\Http\Controllers\Admin\AssignedJobController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\CandidateJobController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\RecruiterBankController;
use App\Http\Controllers\Admin\RecruiterController;
//Middleware
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\VerifiedUser;
use App\Http\Middleware\PreventRouteAccessMiddleware;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Frontend
// Route::get('/', [DecoratoHomeController::class, 'home'])->name('home');
// Route::get('/login', ['as' => 'login', DecoratoHomeController::class, 'showLogin'])->name('login');
// Route::post('/login', [DecoratoHomeController::class, 'login']);
// // Route::post('login', [ 'as' => 'login', 'uses' => 'LoginController@do']);
// // Route::post('/login', [DecoratoHomeController::class, 'customerLogin']);
// Route::get('/signup', [DecoratoHomeController::class, 'showSignup'])->name('signup');
// Route::post('/signup', [DecoratoHomeController::class, 'signup']);
// // verifyUser
// Route::get('/verify-user', [DecoratoHomeController::class, 'showAuthentication'])->name('verifyUser');
// Route::post('/verify-user', [DecoratoHomeController::class, 'verifyUser'])->name('postVerifyUser');

// Route::get('/forgot-password', [DecoratoHomeController::class, 'showForgotPassForm'])->name('showForgotPassForm');
// Route::post('/verify-otp', [DecoratoHomeController::class, 'forgotPassword'])->name('verifyOTP');
// Route::post('/resend-otp', [DecoratoHomeController::class, 'resendOTP'])->name('resendOTP');
// Route::post('/reset-password', [DecoratoHomeController::class, 'resetPassword'])->name('resetPassword');
// Route::post('/check-otp', [DecoratoHomeController::class, 'checkOTP'])->name('checkOTP');

// // LOGIN WITH OTP
// Route::post('/otp-login/{type?}', [DecoratoHomeController::class, 'showLoginWithOTP'])->name('showLoginWithOTP');
// Route::post('/verify-otp-login', [DecoratoHomeController::class, 'postLoginWithOTP'])->name('postLoginWithOTP');

// Route::post('/submit-reset-password', [DecoratoHomeController::class, 'resetPasswordPost'])->name('postResetPassword');
// Route::get('/reset-password-success', [DecoratoHomeController::class, 'resetPasswordSuccess'])->name('resetPasswordSuccess');
// Route::get('/verification-success/{code}', [DecoratoHomeController::class, 'emailVerificationSuccess']);
// Route::get('/reset-password/{token}', [DecoratoHomeController::class, 'showResetPassForm']);
// // Route::post('/reset-password', [DecoratoHomeController::class, 'resetPassword']);

// Route::get('oauth/{provider}', [DecoratoHomeController::class, 'redirect']);
// Route::get('oauth/{provider?}/callback', [DecoratoHomeController::class, 'socialLogin']);
// // Route::get('oauth/{provider?}/callback', [DecoratoHomeController::class, 'customerLogin']);

// Route::get('/getLocaleDetailsForLang', [CustomerDashboardController::class, 'getLocalDetailsForLang']);
// Route::get('/getEmailTemplatesForLang', [CustomerDashboardController::class, 'getEmailTemplateForLang']);

// // Route::prefix('customer')->middleware([CustomerMiddleware::class])->group(function () {
// //     Route::get('/logout', [DecoratoHomeController::class, 'logout']);
// //     Route::get('/dashboard', [CustomerDashboardController::class, 'dashboard']);
// // });

// //Clear Cache facade value:

// Route::get('/clear-cache', function () {
//     $exitCode = Artisan::call('cache:clear');
//     return '<h1>Cache facade value cleared</h1>';
// });

// //Reoptimized class loader:
// Route::get('/optimize', function () {
//     $exitCode = Artisan::call('optimize');
//     return '<h1>Reoptimized class loader</h1>';
// });

// //Route cache:
// Route::get('/route-cache', function () {
//     $exitCode = Artisan::call('route:cache');
//     return '<h1>Routes cached</h1>';
// });

// //Clear Route cache:
// Route::get('/route-clear', function () {
//     $exitCode = Artisan::call('route:clear');
//     return '<h1>Route cache cleared</h1>';
// });

// //Clear View cache:
// Route::get('/view-clear', function () {
//     $exitCode = Artisan::call('view:clear');
//     return '<h1>View cache cleared</h1>';
// });

// //Clear Config cache:
// Route::get('/config-cache', function () {
//     $exitCode = Artisan::call('config:cache');
//     return '<h1>Clear Config cleared</h1>';
// });

// Route::get('brands', [ManufacturerController::class, 'getBrands']);

// Admin Group
// Route::prefix('admin')->middleware([AdminMiddleware::class])->group(function () {
Route::prefix('securerccontrol')->middleware([AdminMiddleware::class])->group(function () {

    // Login Routes...
    Route::get('login', [AdminController::class, 'showLoginForm'])->withoutMiddleware([AdminMiddleware::class]);
    Route::post('login', [AdminController::class, 'login'])->withoutMiddleware([AdminMiddleware::class]);
    Route::get('/logout', [AdminController::class, 'logout']);
    Route::get('/toggleSidebar', [AdminController::class, 'toggleSidebar']);

    //Admin Dashboard
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('adminDashboard');
    Route::get('dashboard/listprofessionalrequest', [DashboardController::class, 'listprofessionalrequest']);
    Route::get('dashboard/monthly-graph/{duration}', [DashboardController::class, 'monthlyGraph']);
    Route::get('dashboard/revenue-graph/{duration}', [DashboardController::class, 'revenuePayoutGraph']);
    Route::post('dashboard/dashboard-filter', [DashboardController::class, 'dashboardFilter']);
    Route::post('dashboard/serach-dashboard', [DashboardController::class, 'serachDashboard'])->name('serachDashboard');;


    //Roles & Permissions Routes
    Route::get('user/role/add', [RoleController::class, 'getRoleForm'])->middleware([PreventRouteAccessMiddleware::class]);
    Route::post('user/role/add', [RoleController::class, 'addRole']);
    Route::get('user/role/list', [RoleController::class, 'getListOfRoles'])->middleware([PreventRouteAccessMiddleware::class]);
    Route::get('role/permissions/{id}', [RoleController::class, 'getPermissions'])->middleware([PreventRouteAccessMiddleware::class]);
    Route::post('role/permissions/{id}', [RoleController::class, 'getPermissions']);
    Route::get('user/role/edit/{id}', [RoleController::class, 'editRole'])->middleware([PreventRouteAccessMiddleware::class]);
    Route::post('user/role/update', [RoleController::class, 'updateRole']);
    Route::post('user/role/delete', [RoleController::class, 'deleteRole'])->middleware([PreventRouteAccessMiddleware::class]);
    Route::post('user/search_role', [RoleController::class, 'searchRole']);


    //Users Routes
    Route::get('user/list', [UserController::class, 'getUserList'])->middleware([PreventRouteAccessMiddleware::class]);
    Route::get('user/add', [UserController::class, 'getUserForm'])->middleware([PreventRouteAccessMiddleware::class]);
    Route::post('user/add', [UserController::class, 'addUser']);
    Route::get('user/edit/{id}', [UserController::class, 'editUser'])->middleware([PreventRouteAccessMiddleware::class]);
    Route::post('user/update', [UserController::class, 'updateUser']);
    Route::get('user/export', [UserController::class, 'exportUsers'])->middleware([PreventRouteAccessMiddleware::class]);
    Route::get('user/import', [UserController::class, 'getimportUsersForm'])->middleware([PreventRouteAccessMiddleware::class]);
    Route::post('user/import', [UserController::class, 'importUser']);
    Route::get('user/{id}/delete', [UserController::class, 'deleteUser'])->name('deleteUser')->middleware([PreventRouteAccessMiddleware::class]);
    Route::post('user/activate-deactivate', [UserController::class, 'userActDeaAct'])->middleware([PreventRouteAccessMiddleware::class]);
    // User Permussion
    Route::get('user/permissions/{id}', [UserController::class, 'getPermissions'])->middleware([PreventRouteAccessMiddleware::class]);
    Route::post('user/permissions/{id}', [UserController::class, 'getPermissions']);



    //Profile
    Route::get('/profile', [AdminController::class, 'profile']);
    Route::post('/update-profile', [AdminController::class, 'updateProfile']);

    //Forgot Password
    Route::get('/forgot-password', [AdminController::class, 'showForgotPassForm'])->withoutMiddleware([AdminMiddleware::class]);
    Route::post('/forgot-password', [AdminController::class, 'forgotPassword'])->withoutMiddleware([AdminMiddleware::class]);

    Route::get('/reset-password/{token}', [AdminController::class, 'showResetPassForm'])->withoutMiddleware([AdminMiddleware::class]);
    Route::post('/reset-password', [AdminController::class, 'resetPassword'])->withoutMiddleware([AdminMiddleware::class]);

    //Change Password
    Route::get('/change/password', [AdminController::class, 'changePasswordForm']);
    Route::post('/change/password', [AdminController::class, 'changePassword']);

    //Contact Us backend
    Route::get('/contactUs', [ContactUsController::class, 'getContactUs'])->middleware([PreventRouteAccessMiddleware::class]);
    Route::get('/contactUs/contactUsData', [ContactUsController::class, 'getContactUsData']);
    Route::get('/contactUs/inquiry', [ContactUsController::class, 'getContactUsInquiry']);
    Route::post('/contactUs/reply', [ContactUsController::class, 'postContactUsReply'])->middleware([PreventRouteAccessMiddleware::class]);
    Route::post('/contactUs/deleteInquiry', [ContactUsController::class, 'postDeleteInquiry'])->middleware([PreventRouteAccessMiddleware::class]);


    // Settings - Footer
    Route::get('/footerDetails', [SettingsController::class, 'footerDetailsView']);
    Route::post('/updateFooterDetails', [SettingsController::class, 'updateFooterDetails']);

    // Settings
    Route::get('/settings', [SettingsController::class, 'getSetting']);
    Route::post('/settings', [SettingsController::class, 'setSetting']);

    // Subscription
    Route::any('subscriptions/index', [SubscriptionController::class, 'index'])->middleware([PreventRouteAccessMiddleware::class])->name('subscriptionsListing');
    Route::any('subscriptions/list', [SubscriptionController::class, 'list'])->name('sublist');
    Route::any('subscriptions/export',[SubscriptionController::class,'exportSubscription'])->name('exportSub');

    //Company Subscription
    Route::any('company-subscriptions/index', [CompanySubscriptionController::class, 'index'])->middleware([PreventRouteAccessMiddleware::class])->name('companySubscriptionsListing');
    Route::any('company-subscriptions/list', [CompanySubscriptionController::class, 'list'])->name('companySubscriptionList');
    Route::any('company-subscriptions/export',[CompanySubscriptionController::class,'exportCompanySubscription'])->name('exportCompanySub');

    //Company Subscription
    Route::any('recruiter-subscriptions/index', [RecruiterSubscriptionController::class, 'index'])->middleware([PreventRouteAccessMiddleware::class])->name('recruiterSubscriptionsListing');
    Route::any('recruiter-subscriptions/list', [RecruiterSubscriptionController::class, 'list'])->name('recruiterSubscriptionList');
    Route::any('recruiter-subscriptions/export',[RecruiterSubscriptionController::class,'exportRecruiterSubscription'])->name('exportRecruiterSub');

    // Company Transaction
    Route::any('company-transaction/index', [CompanyTransactionController::class, 'index'])->middleware([PreventRouteAccessMiddleware::class])->name('companyTransactionListing');
    Route::any('company-transaction/list', [CompanyTransactionController::class, 'list'])->name('transactionlist');
    Route::any('company-transaction/export',[CompanyTransactionController::class,'exportCompanyTransaction'])->name('exportCompanyTransaction');
    // Recruiter Transaction
    Route::any('recruiter-transaction/index', [RecruiterTransactionController::class, 'index'])->middleware([PreventRouteAccessMiddleware::class])->name('recruiterTransactionListing');
    Route::any('recruiter-transaction/list', [RecruiterTransactionController::class, 'list'])->name('recruiterTransactionlist');
    Route::any('recruiter-transaction/export',[RecruiterTransactionController::class,'exportRecruiterTransaction'])->name('exportRecruiterTransaction');

    // Plan Features
    Route::get('plan-features/index', [PlanFeaturesController::class, 'index'])->middleware([PreventRouteAccessMiddleware::class]);
    Route::any('plan-features/list', [PlanFeaturesController::class, 'list']);
    Route::any('plan-features/add', [PlanFeaturesController::class, 'add'])->middleware([PreventRouteAccessMiddleware::class]);
    Route::post('plan-features/store', [PlanFeaturesController::class, 'store']);
    Route::post('plan-features/activeInactive', [PlanFeaturesController::class, 'activeInactive'])->middleware([PreventRouteAccessMiddleware::class]);
    Route::post('plan-features/delete/{id}', [PlanFeaturesController::class, 'delete'])->name('deleteEmailTemplate')->middleware([PreventRouteAccessMiddleware::class]);
    Route::get('plan-features/edit/{id}', [PlanFeaturesController::class, 'edit'])->name('editPlanFeatures')->middleware([PreventRouteAccessMiddleware::class]);
    Route::post('plan-features/update/{id}', [PlanFeaturesController::class, 'update']);

    // Email Temlates
    Route::get('email-templates/index', [EmailTemplatesController::class, 'index'])->middleware([PreventRouteAccessMiddleware::class]);
    Route::any('email-templates/list', [EmailTemplatesController::class, 'list']);
    Route::any('email-templates/add', [EmailTemplatesController::class, 'add'])->middleware([PreventRouteAccessMiddleware::class]);
    Route::post('email-templates/store', [EmailTemplatesController::class, 'store']);
    Route::post('email-templates/activeInactive', [EmailTemplatesController::class, 'activeInactive'])->middleware([PreventRouteAccessMiddleware::class]);
    Route::post('email-templates/delete/{id}', [EmailTemplatesController::class, 'delete'])->name('deleteEmailTemplate')->middleware([PreventRouteAccessMiddleware::class]);
    Route::get('email-templates/edit/{id}', [EmailTemplatesController::class, 'edit'])->name('editEmailTemplate')->middleware([PreventRouteAccessMiddleware::class]);
    Route::post('email-templates/update/{id}', [EmailTemplatesController::class, 'update']);
    Route::post('email-templates/upload-image', [EmailTemplatesController::class, 'uploadEmailImage'])->name('ckeditor.upload_email_image');
    // Category
    Route::any('category/index/{catId?}', [CategoryController::class, 'index'])->middleware([PreventRouteAccessMiddleware::class]);
    Route::any('category/list/{catId?}', [CategoryController::class, 'list']);
    Route::any('category/add', [CategoryController::class, 'add'])->middleware([PreventRouteAccessMiddleware::class]);
    Route::post('category/store', [CategoryController::class, 'store']);
    Route::post('category/activeInactive', [CategoryController::class, 'activeInactive'])->middleware([PreventRouteAccessMiddleware::class]);
    Route::post('category/delete/{id}', [CategoryController::class, 'delete'])->name('deleteCategory')->middleware([PreventRouteAccessMiddleware::class]);
    Route::get('category/edit/{id}', [CategoryController::class, 'edit'])->name('editCategory')->middleware([PreventRouteAccessMiddleware::class]);
    Route::post('category/update/{id}', [CategoryController::class, 'update']);
    Route::any('category/import', [CategoryController::class, 'getimportCategoryForm'])->middleware([PreventRouteAccessMiddleware::class]);
    Route::post('category/import', [CategoryController::class, 'importCategory']);

    // Subscription
    Route::any('subscription-plan/index', [SubscriptionPlanController::class, 'index'])->middleware([PreventRouteAccessMiddleware::class]);
    Route::any('subscription-plan/list', [SubscriptionPlanController::class, 'list']);
    Route::any('subscription-plan/add', [SubscriptionPlanController::class, 'add'])->middleware([PreventRouteAccessMiddleware::class]);
    Route::post('subscription-plan/store', [SubscriptionPlanController::class, 'store']);
    Route::post('subscription-plan/activeInactive', [SubscriptionPlanController::class, 'activeInactive'])->middleware([PreventRouteAccessMiddleware::class]);
    Route::post('subscription-plan/delete/{id}', [SubscriptionPlanController::class, 'delete'])->name('deleteSubscriptionPlan')->middleware([PreventRouteAccessMiddleware::class]);
    Route::get('subscription-plan/edit/{id}', [SubscriptionPlanController::class, 'edit'])->name('editSubscriptionPlan')->middleware([PreventRouteAccessMiddleware::class]);
    Route::get('subscription-plan/check', [SubscriptionPlanController::class, 'checkPlan'])->name('checkSubscriptionPlan');
    Route::post('subscription-plan/update/{id}', [SubscriptionPlanController::class, 'update']);


    // JobField
    Route::any('job-fields/index', [JobFieldController::class, 'index'])->middleware([PreventRouteAccessMiddleware::class]);
    Route::any('job-fields/redirect-option', [JobFieldController::class, 'redirectToOption'])->middleware([PreventRouteAccessMiddleware::class]);
    Route::any('job-fields/list', [JobFieldController::class, 'list']);
    Route::any('job-fields/add', [JobFieldController::class, 'add'])->middleware([PreventRouteAccessMiddleware::class]);
    Route::post('job-fields/store', [JobFieldController::class, 'store']);
    Route::post('job-fields/activeInactive', [JobFieldController::class, 'activeInactive'])->middleware([PreventRouteAccessMiddleware::class]);
    Route::post('job-fields/delete/{id}', [JobFieldController::class, 'delete'])->name('deleteJobField')->middleware([PreventRouteAccessMiddleware::class]);
    Route::get('job-fields/edit/{id}', [JobFieldController::class, 'edit'])->name('editJobField')->middleware([PreventRouteAccessMiddleware::class]);
    Route::post('job-fields/update/{id}', [JobFieldController::class, 'update']);

    // JobField option
    Route::any('job-field-options/index', [JobFieldOptionController::class, 'index'])->middleware([PreventRouteAccessMiddleware::class]);
    Route::any('job-field-options/list', [JobFieldOptionController::class, 'list']);
    Route::any('job-field-options/add', [JobFieldOptionController::class, 'add'])->middleware([PreventRouteAccessMiddleware::class]);
    Route::post('job-field-options/store', [JobFieldOptionController::class, 'store']);
    Route::post('job-field-options/activeInactive', [JobFieldOptionController::class, 'activeInactive'])->middleware([PreventRouteAccessMiddleware::class]);
    Route::post('job-field-options/delete/{id}', [JobFieldOptionController::class, 'delete'])->name('deleteJobFieldOption')->middleware([PreventRouteAccessMiddleware::class]);
    Route::get('job-field-options/edit/{id}', [JobFieldOptionController::class, 'edit'])->name('editJobFieldOption')->middleware([PreventRouteAccessMiddleware::class]);
    Route::post('job-field-options/update/{id}', [JobFieldOptionController::class, 'update']);

    // Recruiter Payouts
    Route::any('recruiter-payouts/index', [RecruiterPayoutController::class, 'index'])->middleware([PreventRouteAccessMiddleware::class])->name('recruiterPayoutListing');
    Route::any('recruiter-payouts/list', [RecruiterPayoutController::class, 'list'])->name('recruiterPayoutlist');
    Route::any('recruiter-payouts/export',[RecruiterPayoutController::class,'exportRecruiterPayout'])->name('exportRecruiterPayout');

    // Company Job Funding
    Route::any('job-funding/index', [CompanyJobFundingController::class, 'index'])->middleware([PreventRouteAccessMiddleware::class])->name('companyJobFundingListing');
    Route::any('job-funding/list', [CompanyJobFundingController::class, 'list'])->name('fundinglist');
    Route::any('job-funding/export',[CompanyJobFundingController::class,'exportCompanyJobFunding'])->name('exportCompanyJobFunding');

    // Company Job Funding
    Route::any('candidate/index', [CandidateController::class, 'index'])->middleware([PreventRouteAccessMiddleware::class])->name('candidateListing');
    Route::any('candidate/list', [CandidateController::class, 'list'])->name('candidatelist');
    Route::get('candidate/edit/{id}', [CandidateController::class, 'edit'])->name('candidateEdit');
    Route::post('candidate/update/{id}', [CandidateController::class, 'update'])->name('candidateUpdate');
    Route::any('candidate/export',[CandidateController::class,'exportCandidateList'])->name('exportCandidateList');
    Route::post('candidate/activate-deactivate', [CandidateController::class, 'candidateChangeStatus']);

    //Recruiter Payment
    Route::any('recruiter-payment/index', [RecruiterPaymentController::class, 'index'])->middleware([PreventRouteAccessMiddleware::class])->name('recruiterPaymentListing');
    Route::any('recruiter-payment/list', [RecruiterPaymentController::class, 'list'])->name('recPaymentlist');
    Route::any('recruiter-payment/export',[RecruiterPaymentController::class,'exportRecruiterPayment'])->name('exportRecruiterPayment');
    Route::any('recruiter-payment/bank-detail',[RecruiterPaymentController::class,'getRecruiterBankDetails'])->name('getRecruiterBankDetail');
    Route::any('recruiter-payment/make-payment',[RecruiterPaymentController::class,'makeRecruiterPayout'])->name('getRecruiterBankDetail');
    
    //Recruiter Bankdetails 
    Route::any('recruiter-bank-details/index',[RecruiterBankController::class,'index'])->name('allRecruiterBankDetails');
    Route::any('recruiter-bank-details/list',[RecruiterBankController::class,'list'])->name('allRecruiterBankDetailList');
    Route::any('recruiter-bank-details/export',[RecruiterBankController::class,'exportBankDetails'])->name('exportBankDetails');
    
    //Admin Commission
    Route::any('admin-commission/index', [AdminCommissionController::class, 'index'])->middleware([PreventRouteAccessMiddleware::class])->name('recruiterPaymentListing');
    Route::any('admin-commission/list', [AdminCommissionController::class, 'list'])->name('adminCommissionlist');
    Route::any('admin-commission/export',[AdminCommissionController::class,'exportAdminCommission'])->name('exportAdminCommission');

    // Recruiter tax forms
    Route::any('recruiter-w9-forms/index', [RecruiterTaxFormController::class, 'index'])->middleware([PreventRouteAccessMiddleware::class])->name('recruiterTaxFormsListing');
    Route::any('recruiter-w9-forms/list', [RecruiterTaxFormController::class, 'list'])->name('recruiterTaxFormslist');

    // CMS Pages
    Route::any('/cms-page/list', [CmsPagesController::class, 'index'])->middleware([PreventRouteAccessMiddleware::class])->name('cmsPageListing');
    Route::post('/cms-page/cmsPageActiveInactive', [CmsPagesController::class, 'cmsPageActiveInactive'])->middleware([PreventRouteAccessMiddleware::class]);
    Route::get('/cms-page/create', [CmsPagesController::class, 'create'])->middleware([PreventRouteAccessMiddleware::class]);
    Route::post('/cms-page/store', [CmsPagesController::class, 'store']);
    Route::get('/cms-page/edit/{id}', [CmsPagesController::class, 'edit'])->middleware([PreventRouteAccessMiddleware::class]);
    Route::any('/cms-page/update/{id}', [CmsPagesController::class, 'update']);
    Route::post('/cms-page/delete/{id}', [CmsPagesController::class, 'delete'])->middleware([PreventRouteAccessMiddleware::class]);
    // home page banner
    Route::any('home-page-banner/index', [HomePageBannerController::class, 'index'])->middleware([PreventRouteAccessMiddleware::class])->name('homePageBannerListing');
    Route::any('home-page-banner/list', [HomePageBannerController::class, 'list'])->name('homePageBannerList');
    Route::get('home-page-banner/edit/{id}', [HomePageBannerController::class, 'edit'])->name('editHomePageBanner')->middleware([PreventRouteAccessMiddleware::class]);
    Route::any('home-page-banner/update/{id}', [HomePageBannerController::class, 'update']);

    // General Settings - Footer
    Route::get('/general-settings', [SettingsController::class, 'getSetting'])->middleware(PreventRouteAccessMiddleware::class);
    Route::post('/settings', [SettingsController::class, 'setSetting']);

    // Job Balance Transfer Request
    Route::any('job-balance-transfer-requests/index', [JobBalanceTransferRequestsController::class, 'index'])->middleware([PreventRouteAccessMiddleware::class])->name('jobBalanceTransferRequestListing');
    Route::any('job-balance-transfer-requests/list', [JobBalanceTransferRequestsController::class, 'list'])->name('jobBalanceTransferRequestlist');
    Route::any('job-balance-transfer-requests/approve/{id}', [JobBalanceTransferRequestsController::class, 'approve'])->middleware([PreventRouteAccessMiddleware::class]);
    Route::any('job-balance-transfer-requests/reject/{id}', [JobBalanceTransferRequestsController::class, 'reject'])->middleware([PreventRouteAccessMiddleware::class]);

    // footer new
    Route::get('footer-link/index', [FooterNewController::class, 'index'])->middleware([PreventRouteAccessMiddleware::class]);
    Route::any('footer-link/list', [FooterNewController::class, 'list']);
    Route::any('footer-link/add', [FooterNewController::class, 'add'])->middleware([PreventRouteAccessMiddleware::class]);
    Route::any('footer-link/get-sort-order/{type}', [FooterNewController::class, 'getSortOrder'])->name('howItWorkgetSortOrder');
    Route::post('footer-link/create', [FooterNewController::class, 'store']);
    Route::post('footer-link/activeInactive', [FooterNewController::class, 'activeInactive'])->middleware([PreventRouteAccessMiddleware::class]);
    Route::post('footer-link/delete/{id}', [FooterNewController::class, 'delete'])->name('deleteFooter')->middleware([PreventRouteAccessMiddleware::class]);
    Route::get('footer-link/edit/{id}', [FooterNewController::class, 'edit'])->name('editFooter')->middleware([PreventRouteAccessMiddleware::class]);
    Route::post('footer-link/update/{id}', [FooterNewController::class, 'update']);
    Route::post('/footer-link/updateData',[FooterNewController::class,'getType']);

    //book demo request
    Route::any('book-demo-requests/index', [BookDemoRequestsController::class, 'index'])->middleware([PreventRouteAccessMiddleware::class])->name('bookDemoRequestListing');
    Route::any('book-demo-requests/list', [BookDemoRequestsController::class, 'list'])->name('bookDemoRequestslist');
    Route::any('book-demo-requests/mark-completed', [BookDemoRequestsController::class, 'markAsCompleted'])->middleware([PreventRouteAccessMiddleware::class]);
    Route::any('book-demo-requests/view-details', [BookDemoRequestsController::class, 'view'])->middleware([PreventRouteAccessMiddleware::class]);

    //highlighted-jobs
    Route::any('highlighted-jobs/index', [HighlightedJobController::class, 'index'])->middleware([PreventRouteAccessMiddleware::class])->name('bookDemoRequestListing');
    Route::any('highlighted-jobs/list', [HighlightedJobController::class, 'list'])->name('highlightedJoblist');
    Route::any('highlighted-jobs/add', [HighlightedJobController::class, 'addJob'])->middleware([PreventRouteAccessMiddleware::class])->name('bookDemoRequestListing');
    Route::any('highlighted-jobs/job-list', [HighlightedJobController::class, 'jobList']);
    Route::any('highlighted-jobs/get-job-ids',[HighlightedJobController::class,'getJobIds'])->name('getJobIds');
    Route::any('highlighted-jobs/store-job-ids',[HighlightedJobController::class,'storeHighlightedJob'])->name('storeIds');
    Route::any('highlighted-jobs/remove-job', [HighlightedJobController::class, 'markAsRemove']);



    // How It Works
    Route::get('how-it-works/index', [HowItWorksController::class, 'index'])->middleware([PreventRouteAccessMiddleware::class]);
    Route::any('how-it-works/list', [HowItWorksController::class, 'list']);
    Route::any('how-it-works/add', [HowItWorksController::class, 'add'])->middleware([PreventRouteAccessMiddleware::class]);
    Route::any('how-it-works/get-sort-order/{type}', [HowItWorksController::class, 'getSortOrder'])->name('howItWorkgetSortOrder');
    Route::post('how-it-works/store', [HowItWorksController::class, 'store']);
    Route::post('how-it-works/activeInactive', [HowItWorksController::class, 'activeInactive'])->middleware([PreventRouteAccessMiddleware::class]);
    Route::post('how-it-works/delete/{id}', [HowItWorksController::class, 'delete'])->name('deleteHowItWorks')->middleware([PreventRouteAccessMiddleware::class]);
    Route::get('how-it-works/edit/{id}', [HowItWorksController::class, 'edit'])->name('editHowItWorks')->middleware([PreventRouteAccessMiddleware::class]);
    Route::post('how-it-works/update/{id}', [HowItWorksController::class, 'update']);
    Route::any('how-it-works/checkType', [HowItWorksController::class, 'checkType']);

    // Assigned Jobs
    Route::any('assigned-jobs/index', [AssignedJobController::class, 'index'])->middleware([PreventRouteAccessMiddleware::class])->name('assignedJobListing');
    Route::any('assigned-jobs/list', [AssignedJobController::class, 'list'])->name('assignedJobList');
    Route::any('submit-candidate-start', [AssignedJobController::class, 'submitCandidateStart'])->name('submitCandidateStart');
    Route::post('candidate-email-unique', [AssignedJobController::class, 'candidateSubmitUniqueEmail'])->name('candidateSubmitUniqueEmailAdmin');
    Route::get('submit-candidate', [AssignedJobController::class, 'getCandidateSubmit'])->name('getCandidateSubmit');
    Route::post('submit-candidate', [AssignedJobController::class, 'postCandidateSubmit'])->name('postCandidateSubmit');
    Route::get('submit-candidate-questionnaire', [AssignedJobController::class, 'getJobQuestionnaire'])->name('getJobQuestionnaire');
    Route::post('submit-candidate-questionnaire', [AssignedJobController::class, 'postJobQuestionnaire'])->name('postJobQuestionnaire');
    Route::get('submit-candidate-review', [AssignedJobController::class, 'getCandidateSubmitReview'])->name('getCandidateSubmitReview');
    Route::post('submit-candidate-review', [AssignedJobController::class, 'postCandidateSubmitReview'])->name('postCandidateSubmitReview');
    Route::get('submit-candidate-success', [AssignedJobController::class, 'getCandidateSubmitSuccess'])->name('getCandidateSubmitSuccess');
    // Route::get('/recruiter/submit-candidate-start/{slug}', [CompanyJobApplicationsController::class, 'index'])->name('recruiterCandidateSubmitStart');
    // Route::get('/recruiter/submit-candidate/{candidate?}', [CompanyJobApplicationsController::class, 'candidateSubmit'])->name('recruiterCandidateSubmit');
    // Route::post('/recruiter/submit-candidate', [CompanyJobApplicationsController::class, 'postCandidateSubmit'])->name('postRecruiterCandidateSubmit');
    // Route::post('/recruiter/search-candidate', [CompanyJobApplicationsController::class, 'candidateSearch'])->name('candidateSearch');
    // Route::get('/recruiter/candidate-questionnaire', [CompanyJobApplicationsController::class, 'candidateQuestionnaire'])->name('recruiterCandidateQuestionnaire');
    // Route::post('/recruiter/candidate-questionnaire', [CompanyJobApplicationsController::class, 'postCandidateQuestionnaire'])->name('postRecruiterCandidateQuestionnaire');
    // Route::get('/recruiter/candidate-review', [CompanyJobApplicationsController::class, 'candidateSubmitReview'])->name('recruiterCandidateSubmitReview');
    // Route::post('/recruiter/candidate-review', [CompanyJobApplicationsController::class, 'postCandidateSubmitReview'])->name('postRecruiterCandidateSubmitReview');
    // Route::get('/recruiter/candidate-submit-success', [CompanyJobApplicationsController::class, 'candidateSubmitSuccess'])->name('recruiterCandidateSubmitSuccess');
    // Route::post('/recruiter/candidate-email-unique', [CompanyJobApplicationsController::class, 'candidateSubmitUniqueEmail'])->name('candidateSubmitUniqueEmail');

    //Notification
    Route::get('notifications/index', [NotificationController::class, 'index']);
    Route::any('notifications/list', [NotificationController::class, 'list']);
    Route::any('notifications/notificationReadUnread', [NotificationController::class, 'notificationReadUnread']);

    // candidate Jobs
    Route::any('candidate-jobs/index', [CandidateJobController::class, 'index'])->middleware([PreventRouteAccessMiddleware::class])->name('candidateJobListing');
    Route::any('candidate-jobs/list', [CandidateJobController::class, 'list'])->name('candidateJobList');
    Route::post('candidate-jobs/assign-candidate-specialist', [CandidateJobController::class, 'assignCandidateSpecialist'])->name('assignCandidateSpecialist');
    Route::any('candidate-jobs/job-detail/{id}', [CandidateJobController::class, 'jobDetail'])->name('jobDetail');


    Route::get('candidate-submit-1', [CandidateJobController::class, 'candidateJobOne'])->middleware([PreventRouteAccessMiddleware::class])->name('candidateSubmit1');
    Route::get('candidate-submit-2', [CandidateJobController::class, 'candidateJobTwo'])->middleware([PreventRouteAccessMiddleware::class])->name('candidateSubmit2');
    Route::get('candidate-submit-3', [CandidateJobController::class, 'candidateJobThree'])->middleware([PreventRouteAccessMiddleware::class])->name('candidateSubmit3');
    Route::get('candidate-submit-4', [CandidateJobController::class, 'candidateJobFour'])->middleware([PreventRouteAccessMiddleware::class])->name('candidateSubmit4');
    
    
    Route::get('new-pages/{slug}', [CandidateJobController::class, 'newPageDynamic'])->middleware([PreventRouteAccessMiddleware::class])->name('newPages');

    // Company listing
    Route::get('/companies/index', [CompanyController::class, 'index'])->name('companies');
    Route::post('/companies/company-list', [CompanyController::class, 'getList'])->name('companyList');
    Route::post('/companies/account-managers', [CompanyController::class, 'getSelectedManagerList'])->name('getSelectedManagerList');
    Route::post('/companies/set-account-managers', [CompanyController::class, 'setSelectedManagerList'])->name('setSelectedManagerList');
    Route::post('/companies/get-login-link', [CompanyController::class, 'loginLink'])->name('getLoginLink');
    Route::get('/company/detail/{id?}', [CompanyController::class, 'viewDetails'])->name('companyViewDetails');
    Route::get('/company/cancel-subscription/{id}', [CompanyController::class, 'cancelSubscription'])->name('companyCancelSubscription');
    Route::get('/company/monthly-graph/{duration}/{companyId?}', [CompanyController::class, 'monthlyGraph']);
    Route::get('/company/jobs/{companyId?}/{status?}', [CompanyController::class, 'jobs'])->name('companyJobsByStatus');
    Route::post('/company/jobs-list', [CompanyController::class, 'ajaxJobList'])->name('ajaxJobListByStatus');
    Route::get('/company/job/details/{slug?}', [CompanyController::class, 'companyJobDetails'])->name('companyJobDetails');
    Route::post('/company/job/details-update/{id}', [CompanyController::class, 'companyJobDetailUpdate'])->name('companyJobDetailUpdate');
    Route::get('/company/job/monthly-graph/{jobId}', [CompanyController::class, 'monthlyGraphForJobDetail']);
    Route::post('/companies/delete/{id}', [CompanyController::class, 'delete'])->name('deleteCompany')->middleware([PreventRouteAccessMiddleware::class]);

    // Recruiter listing
    Route::get('/recruiters/index', [RecruiterController::class, 'index'])->name('recruiters');
    Route::post('/recruiters/recruiter-list', [RecruiterController::class, 'getList'])->name('recruiterList');
    Route::get('/recruiter/detail/{id?}', [RecruiterController::class, 'viewDetails'])->name('recruiterViewDetails');
    Route::post('/recruiter/edit/{id?}', [RecruiterController::class, 'editDetails'])->name('recruiterEditInfo');
    Route::get('/recruiter/cancel-subscription/{id}', [RecruiterController::class, 'cancelSubscription'])->name('recruiterCancelSubscription');
    Route::get('/recruiter/candidates/{recruiterId?}', [RecruiterController::class, 'candidates'])->name('recruiterCandidatesInPortal');
    Route::any('/recruiter/candidate/list', [RecruiterController::class, 'getCandidatesList'])->name('recruiterCandidatesListInPortal');
    Route::get('/recruiter/jobs/list/{recruiterId?}/{status?}', [RecruiterController::class, 'getRecruiterJobList'])->name('recruiterJobListInPortal');
    Route::post('/recruiter/jobs/ajax-job-list-recruiter', [RecruiterController::class, 'getRecruiterAjaxJobList'])->name('ajaxJobListForRecruiterInPortal');
    Route::post('/recruiters/delete/{id}', [RecruiterController::class, 'delete'])->name('deleteRecruiter')->middleware([PreventRouteAccessMiddleware::class]);

});



// Front Logged In Routes
