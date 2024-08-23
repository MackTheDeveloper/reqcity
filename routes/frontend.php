<?php

use Illuminate\Support\Facades\Route;

//Middleware
//
use App\Http\Controllers\FrontEnd\LandingController;
use App\Http\Controllers\FrontEnd\HomeController;
use App\Http\Controllers\FrontEnd\ContactUsController;
use App\Http\Controllers\FrontEnd\SiteController;
use App\Http\Controllers\FrontEnd\ArtistEventFrontController;
use App\Http\Controllers\FrontEnd\ArtistNewsFrontController;
use App\Http\Controllers\FrontEnd\ChatFrontController;
use App\Http\Controllers\FrontEnd\UserSecurityQuestionController;
use App\Http\Controllers\FrontEnd\MusicGenresController;
use App\Http\Controllers\FrontEnd\CategoryFrontController;
use App\Http\Controllers\FrontEnd\CandidateAuthController;
use App\Http\Controllers\FrontEnd\RecruiterAuthController;
use App\Http\Controllers\FrontEnd\CompanyAuthController;
use App\Http\Controllers\FrontEnd\BookDemoRequestsController;
use App\Http\Controllers\FrontEnd\Candidate\CandidateDashboardController;
use App\Http\Controllers\FrontEnd\Candidate\CandidateFrontController;
use App\Http\Controllers\FrontEnd\Company\CompanyCandidateController;
use App\Http\Controllers\FrontEnd\Company\CompanyFaqsTemplatesController;
use App\Http\Controllers\FrontEnd\StripeController;
use App\Http\Controllers\FrontEnd\Company\CompanyFrontController;
use App\Http\Controllers\FrontEnd\Company\CompanyPermissionController;
use App\Http\Controllers\FrontEnd\CompanyUserController;
use App\Http\Controllers\FrontEnd\Recruiter\RecruiterFrontController;
use App\Http\Controllers\FrontEnd\Company\CompanyQuestionnaireController;
use App\Http\Controllers\FrontEnd\Company\CompanySubscriptionFrontController;
use App\Http\Controllers\FrontEnd\Recruiter\RecruiterPaymentController;
use App\Http\Controllers\FrontEnd\NotificationController;
use App\Http\Controllers\FrontEnd\Company\CompanyDashboardController;
use App\Http\Controllers\FrontEnd\Company\CompanyJobsController;
use App\Http\Controllers\FrontEnd\Recruiter\RecruiterSubscriptionFrontController;
use App\Http\Controllers\FrontEnd\Company\CompanyJobController;
use App\Http\Controllers\FrontEnd\Recruiter\CompanyJobApplicationsController;
use App\Http\Controllers\FrontEnd\Recruiter\RecruiterCandidatesController;
use App\Http\Controllers\FrontEnd\Recruiter\RecruiterJobController;
use App\Http\Controllers\FrontEnd\Recruiter\RecruiterDashboardController;
use App\Http\Controllers\FrontEnd\Candidate\CandidateJobsController;
use App\Http\Controllers\FrontEnd\Company\CompanyAddressController;

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

//---------- Front without Logged In Routes

//Front Category
Route::get('/category/{slug}', [CategoryFrontController::class, 'showDetails'])->name('categoryDetail');
Route::get('/category-list', [CategoryFrontController::class, 'index'])->name('categoryList');

// search jobs
Route::get('/search/{cat?}', [HomeController::class, 'searchFront'])->name('searchFront');
Route::post('/ajax-search', [HomeController::class, 'ajaxJobList'])->name('ajaxsearchFront');
Route::get('/job-details/{slug}', [HomeController::class, 'showJobDetails'])->name('showJobDetails');

//highlighted job list
Route::get('/highlighted-jobs', [HomeController::class, 'showHighlightedJobs'])->name('highlightedJobs');
Route::post('/ajax-highlighted-jobs', [HomeController::class, 'ajaxHighlightedJobList'])->name('ajaxHighlightedJobs');

//Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/', [HomeController::class, 'home'])->name('home');

// Login
Route::get('/login', ['as' => 'login', HomeController::class, 'showLogin'])->name('login');
Route::post('/login', [HomeController::class, 'login']);
Route::get('/login-via-link/{link}', [HomeController::class, 'loginViaLink'])->name('loginViaLink');
Route::get('/logout', [HomeController::class, 'logout'])->name('logout');

//forgot password
Route::get('/forgot-password', [HomeController::class, 'showForgotPassword'])->name('showForgotPassword');
Route::post('/forgot-password', [HomeController::class, 'forgotPassword'])->name('forgotPassword');

//reset password
Route::get('/reset-password/{token}', [HomeController::class, 'showResetPassword'])->name('showResetPassword');
Route::post('/reset-password', [HomeController::class, 'resetPassword'])->name('resetPassword');
Route::get('/reset-password-success', [HomeController::class, 'resetPasswordSuccess'])->name('resetPasswordSuccess');

Route::get('/signup', [HomeController::class, 'showSignup'])->name('showSignup');
//Company Sign up
Route::get('/company-signup', [CompanyAuthController::class, 'showCompanySignup'])->name('showCompanySignup');
Route::post('/company-signup', [CompanyAuthController::class, 'companySignup'])->name('companySignup');
Route::post('/company-unique-email', [CompanyAuthController::class, 'companyUniqueEmail'])->name('companyUniqueEmail');
Route::get('/company-signup-2', [CompanyAuthController::class, 'showCompanySecondSignup'])->name('showSecondCompanySignup');
Route::post('/company-signup-2', [CompanyAuthController::class, 'companySecondSignup'])->name('companySignupSecond');
Route::get('/company-signup-3', [CompanyAuthController::class, 'showCompanyThirdSignup'])->name('showThirdCompanySignup');
Route::post('/company-signup-3', [CompanyAuthController::class, 'companyThirdSignup'])->name('companySignupThird');
Route::get('/company-signup-4', [CompanyAuthController::class, 'showCompanyFourthSignup'])->name('showFourthCompanySignup');
Route::post('/company-signup-4', [CompanyAuthController::class, 'companyFourthSignup'])->name('companySignupFourth');
Route::get('/company-signup-success', [CompanyAuthController::class, 'showCompanySuccessSubscribe'])->name('companySignupSuccess');
Route::post('/company-signup-update', [CompanyAuthController::class, 'companySignupUpdate'])->name('companySignupUpdate');
Route::post('/company-add-branches', [CompanyAuthController::class, 'companyAddBranches'])->name('companyAddBranches');


//candidate Sign up
Route::get('/candidate-signup', [CandidateAuthController::class, 'showCandidateSignup'])->name('showCandidateSignup');
Route::post('/candidate-signup', [CandidateAuthController::class, 'candidateSignup'])->name('candidateSignup');
Route::post('/candidate-unique-email', [CandidateAuthController::class, 'candidateUniqueEmail'])->name('candidateUniqueEmail');
Route::get('/candidate-signup-2', [CandidateAuthController::class, 'showCandidateSecondSignup'])->name('showSecondCandidateSignup');
Route::post('/candidate-signup-2', [CandidateAuthController::class, 'candidateSecondSignup'])->name('candidateSignupSecond');
Route::post('/candidate-signup-update', [CandidateAuthController::class, 'candidateSignupUpdate'])->name('candidateSignupUpdate');

//recruiter Sign up
Route::get('/recruiter-signup', [RecruiterAuthController::class, 'showRecruiterSignup'])->name('showRecruiterSignup');
Route::post('/recruiter-signup', [RecruiterAuthController::class, 'recruiterSignup'])->name('recruiterSignup');
Route::post('/recruiter-unique-email', [RecruiterAuthController::class, 'recruiterUniqueEmail'])->name('recruiterUniqueEmail');
Route::get('/recruiter-signup-2', [RecruiterAuthController::class, 'showRecruiterSecondSignup'])->name('showSecondRecruiterSignup');
Route::post('/recruiter-signup-2', [RecruiterAuthController::class, 'recruiterSecondSignup'])->name('recruiterSignupSecond');
Route::get('/recruiter-signup-3', [RecruiterAuthController::class, 'showRecruiterThirdSignup'])->name('showThirdRecruiterSignup');
Route::post('/recruiter-signup-3', [RecruiterAuthController::class, 'recruiterThirdSignup'])->name('recruiterSignupThird');
Route::get('/recruiter-signup-4', [RecruiterAuthController::class, 'showRecruiterFourthSignup'])->name('showFourthRecruiterSignup');
Route::post('/recruiter-signup-4', [RecruiterAuthController::class, 'recruiterFourthSignup'])->name('recruiterSignupFourth');
Route::get('/recruiter-signup-success', [RecruiterAuthController::class, 'showRecruiterSuccessSubscribe'])->name('recruiterSignupSuccess');
Route::post('/recruiter-signup-update', [RecruiterAuthController::class, 'recruiterSignupUpdate'])->name('recruiterSignupUpdate');

Route::get('/email-verification/{id}', [HomeController::class, 'emailVerification'])->name('emailVerification');

Route::get('/about-us', [HomeController::class, 'aboutUs'])->name('aboutUs');
Route::get('/terms-conditions', [HomeController::class, 'termsConditions'])->name('termsConditions');
Route::get('/terms-of-service', [HomeController::class, 'termsOfService'])->name('termsOfService');
Route::get('/privacy-policy', [HomeController::class, 'privacyPolicy'])->name('privacyPolicy');
Route::get('/why-reqcity', [HomeController::class, 'whyreqcity'])->name('whyreqcity');
Route::any('/book-request', [BookDemoRequestsController::class, 'bookRequest'])->name('bookRequest');

Route::get('/contact-us', [ContactUsController::class, 'showContactUs'])->name('showContactUs');
Route::post('/contact-us', [ContactUsController::class, 'store']);

// Stripe Routes
Route::any('/stripe-webhook', [StripeController::class, 'webhook'])->name('stripeWebhook');
// Route::get('/stripe-test',[StripeController::class,'index']);



//----------END Front without Logged In Routes

// For All role Verified routes
Route::group(['middleware' => ['auth', 'verifiedUser']], function () { });

// ROLE =>1 = Admin , 2 = Candidate Specialists, 3 = Company, 4 = Recruiter, 5 = Candidate
//Company Logedin Routes
Route::group(['middleware' => ['auth', 'roleUser:3', 'frontRoute']], function () {
    Route::get('/company-myinfo', [CompanyFrontController::class, 'showMyInfo'])->name('showMyInfoCompany');
    Route::get('/company-myinfo-edit', [CompanyFrontController::class, 'editMyInfo'])->name('editMyInfoCompany');
    Route::post('/company-myinfo-update', [CompanyFrontController::class, 'updateMyInfo'])->name('updateMyInfoCompany');

    Route::get('/company-password-security', [CompanyFrontController::class, 'showPasswordSecurity'])->name('showPasswordSecurityCompany');
    Route::get('/company-password-security-reset', [CompanyFrontController::class, 'showPasswordSecurityForm'])->name('showPasswordSecurityFormCompany');
    Route::post('/company-password-security-reset', [CompanyFrontController::class, 'changePassword'])->name('changeCompanyUserPassword');

    Route::get('/company-payment', [CompanyFrontController::class, 'companyPayment'])->name('companyPayment');
    Route::get('/company-payment-list', [CompanyFrontController::class, 'list'])->name('companyPaymentList');
    Route::get('/company-payment-approval-list', [CompanyFrontController::class, 'companyPaymentApprovalList'])->name('companyPaymentApprovalList');

    Route::get('/company-user-index', [CompanyUserController::class, 'index'])->name('companyUserIndex');
    Route::get('/company-user-create', [CompanyUserController::class, 'create'])->name('companyUserCreate');
    Route::get('/company-user-edit', [CompanyUserController::class, 'edit'])->name('companyUserEdit');
    Route::post('/company-user-update', [CompanyUserController::class, 'update'])->name('companyUserUpdate');
    Route::post('/company-user-store', [CompanyUserController::class, 'store'])->name('companyUserStore');
    Route::post('/company-user/delete/{id}', [CompanyUserController::class, 'delete'])->name('companyUserDelete');
    Route::get('/company-user-list', [CompanyUserController::class, 'companyUserList'])->name('companyUserList');
    Route::post('/company-user-unique-email', [CompanyUserController::class, 'companyUserUniqueEmail'])->name('companyUserUniqueEmail');
    Route::get('/company-user-dropdown', [CompanyUserController::class, 'getCompanyUserList'])->name('companyUserDropdown');

    Route::get('/company-user-permission', [CompanyPermissionController::class, 'getPermissions'])->name('companyUserPermission');
    Route::get('/company-user-change-permission', [CompanyPermissionController::class, 'changePermissions'])->name('companyUserChangePermission');



    Route::get('/company-communication-management', [CompanyFaqsTemplatesController::class, 'index'])->name('companyCommunicationManagment');
    Route::get('/company-communication-management/list', [CompanyFaqsTemplatesController::class, 'getList'])->name('companyCommunicationManagmentList');
    Route::get('/company-communication-management/add', [CompanyFaqsTemplatesController::class, 'create'])->name('createCompanyCommunicationManagment');
    Route::post('/company-communication-management/add', [CompanyFaqsTemplatesController::class, 'store'])->name('storeCompanyCommunicationManagment');
    Route::get('/company-communication-management/edit/{id}', [CompanyFaqsTemplatesController::class, 'edit'])->name('editCompanyCommunicationManagment');
    Route::post('/company-communication-management/edit/{id}', [CompanyFaqsTemplatesController::class, 'update'])->name('updateCompanyCommunicationManagment');
    Route::post('/company-add-faqs', [CompanyFaqsTemplatesController::class, 'addFaqs'])->name('addFaqs');
    Route::post('/company-communication-management/delete/{id}', [CompanyFaqsTemplatesController::class, 'delete'])->name('deleteCompanyCommunicationManagment');

    // company questionnaire managment
    Route::get('/company-questionnaire-management', [CompanyQuestionnaireController::class, 'index'])->name('companyQuestionnaireManagment');
    Route::get('/company-questionnaire-management/list', [CompanyQuestionnaireController::class, 'list'])->name('companyQuestionnaireTemplateList');
    Route::get('/company-questionnaire-management/add', [CompanyQuestionnaireController::class, 'create'])->name('companyQuestionnaireManagmentAdd');
    Route::post('/company-questionnaire-management/add', [CompanyQuestionnaireController::class, 'store'])->name('companyQuestionnaireManagmentStore');
    Route::get('/company-questionnaire-management/edit/{id}', [CompanyQuestionnaireController::class, 'edit'])->name('companyQuestionnaireManagmentEdit');
    Route::post('/company-questionnaire-management/edit/{id}', [CompanyQuestionnaireController::class, 'update'])->name('companyQuestionnaireManagmentUpdate');
    Route::post('/company-questionnaire-management/delete/{id}', [CompanyQuestionnaireController::class, 'delete'])->name('companyQuestionnaireManagmentDelete');


    Route::get('/company-subscription-plan', [CompanySubscriptionFrontController::class, 'index'])->name('getSubscriptionPlanView');
    Route::post('/company-subscription-plan/cancel', [CompanySubscriptionFrontController::class, 'cancel'])->name('SubscriptionPlanCancel');
    Route::post('/company-subscription-plan/cancel-schedule', [CompanySubscriptionFrontController::class, 'cancelScheduled'])->name('SubscriptionPlanCancelSchedule');
    Route::post('/company-subscription-plan/upgrade', [CompanySubscriptionFrontController::class, 'upgrade'])->name('SubscriptionPlanUpgrade');

    //company dashboard route
    Route::get('/company-dashboard', [CompanyDashboardController::class, 'showDashboard'])->name('showDashboard');
    Route::get('/company-dashboard/monthly-graph/{duration}', [CompanyDashboardController::class, 'monthlyGraph']);

    Route::get('/company-candidate', [CompanyCandidateController::class, 'index'])->name('showCompanyCandidate');
    Route::get('/company-candidate-list', [CompanyCandidateController::class, 'list'])->name('showCompanyCandidateList');

    // Jobs
    // Job details
    Route::get('/company-job/add-edit-job-details', [CompanyJobsController::class, 'showJobDetails'])->name('jobDetailsShow');
    Route::post('/company-job/add-job-details', [CompanyJobsController::class, 'addJobDetails'])->name('jobDetailsAdd');
    Route::post('/company-job/edit-job-details/{id}', [CompanyJobsController::class, 'updateJobDetails'])->name('jobDetailsUpdate');
    Route::post('/company-job/get-subcat', [CompanyJobsController::class, 'getSubCategories'])->name('getSubCategories');
    Route::post('/company-job/edit-job-description', [CompanyJobsController::class, 'getJobDescription'])->name('getJobDescription');
    Route::post('/company-job/update-job-description', [CompanyJobsController::class, 'changeJobDescription'])->name('changeJobDescription');

    Route::get('/company-jobs/{status?}', [CompanyJobController::class, 'index'])->name('companyJobs');
    Route::get('/company-jobs-list', [CompanyJobController::class, 'getList'])->name('companyJobsList');
    Route::post('/balance-transfer-request', [CompanyJobController::class, 'submitBalanceTransferRequest'])->name('balanceTransferRequest');
    Route::post('/company-job-change-status', [CompanyJobController::class, 'companyJobChangeStatus'])->name('companyJobChangeStatus');
    Route::get('/company-job-details/{slug?}', [CompanyJobController::class, 'showCompanyJobDetails'])->name('showCompanyJobDetails');
    Route::get('/company-job-details/monthly-graph/{jobId}', [CompanyJobController::class, 'monthlyGraph']);
    Route::post('/company-jobs/ajax-job-list', [CompanyJobController::class, 'ajaxJobList'])->name('ajaxJobList');

    // Job communications
    Route::get('/company-job/add-edit-job-communication', [CompanyJobsController::class, 'showJobCommunication'])->name('jobCommunicationShow');
    Route::post('/company-job/add-edit-job-communication', [CompanyJobsController::class, 'updateJobCommunication'])->name('jobCommunicationAddUpdate');
    Route::post('/company-job-add-faqs', [CompanyJobsController::class, 'addJobFaqs'])->name('addJobFaqs');
    Route::post('/company-job/get-communication-templates', [CompanyJobsController::class, 'getCommunicationTemplateData'])->name('getCommunicationTemplateData');

    Route::get('/company-job/payment-confirmation', [CompanyJobsController::class, 'showJobPaymentConfirm'])->name('jobPaymentConfirmShow');
    Route::post('/company-job/payment-confirmation', [CompanyJobsController::class, 'postJobPaymentConfirm'])->name('jobPaymentConfirmPost');
    Route::get('/company-job/payment-success', [CompanyJobsController::class, 'jopPostSuccessPayment'])->name('jopPostSuccessPayment');

    // Job review
    Route::get('/company-job/review-and-payment', [CompanyJobsController::class, 'showJobReviewAndPayment'])->name('jobJobReviewAndPaymentShow');
    Route::post('/company-job/add-job-pay', [CompanyJobsController::class, 'addJobPay'])->name('jobPayAdd');
    //-- Jobs

    Route::get('/company-job/add-edit-job-questionnaire', [CompanyJobsController::class, 'showJobQuestionnaire'])->name('jobQuestionnaireShow');
    Route::post('/company-job/get-questionnaire', [CompanyJobsController::class, 'getQuestionnaireData'])->name('getQuestionnaireData');
    Route::post('/company-job/add-edit-job-questionnaire', [CompanyJobsController::class, 'updateJobQuestionnaire'])->name('jobQuestionnairePost');

    Route::get('/company-candidate-view', [CompanyCandidateController::class, 'view'])->name('viewCandidate');
    Route::get('/company-candidate-check-job-balance', [CompanyCandidateController::class, 'checkJobBalance'])->name('checkJobBalance');
    Route::post('/company-candidate-reject', [CompanyCandidateController::class, 'reject'])->name('rejectCandidate');
    Route::post('/company-candidate-approve', [CompanyCandidateController::class, 'approve'])->name('approveCandidate');

    //notification-settings
    Route::get('/company-notification-settings', [CompanyFrontController::class, 'notificationSetting'])->name('notificationSettingCompany');
    Route::get('/company-notification-update', [CompanyFrontController::class, 'updateNotificationSetting'])->name('updateNotificationSettingCompany');

     // company questionnaire managment
     Route::get('/company-address-management', [CompanyAddressController::class, 'index'])->name('companyAddressManagment');
     Route::get('/company-address-management/list', [CompanyAddressController::class, 'list'])->name('companyAddressList');
     Route::get('/company-address-management/add', [CompanyAddressController::class, 'create'])->name('companyAddressAdd');
     Route::post('/company-address-management/add', [CompanyAddressController::class, 'store'])->name('companyAddressStore');
     Route::get('/company-address-management/edit/{id}', [CompanyAddressController::class, 'edit'])->name('companyAddressEdit');
     Route::post('/company-address-management/edit/{id}', [CompanyAddressController::class, 'update'])->name('companyAddressUpdate');
     Route::post('/company-address-management/delete/{id}', [CompanyAddressController::class, 'delete'])->name('companyAddressDelete');
});

//Recruiter Logedin Routes
Route::group(['middleware' => ['auth', 'roleUser:4']], function () {
    //my-info
    Route::get('/recruiter-myinfo', [RecruiterFrontController::class, 'showMyInfo'])->name('showMyInfoRecruiter');
    Route::get('/recruiter-myinfo-edit', [RecruiterFrontController::class, 'editMyInfo'])->name('editMyInfoRecruiter');
    Route::post('/recruiter-myinfo-update', [RecruiterFrontController::class, 'updateMyInfo'])->name('updateMyInfoRecruiter');

    //notification-setting
    Route::get('/recruiter-notification-settings', [RecruiterFrontController::class, 'notificationSetting'])->name('notificationSettingRecruiter');
    Route::get('/recruiter-notification-update', [RecruiterFrontController::class, 'updateNotificationSetting'])->name('updateNotificationSettingRecruiter');

    //password-security
    Route::get('/recruiter-password-security', [RecruiterFrontController::class, 'showPasswordSecurity'])->name('showPasswordSecurityRecruiter');
    Route::get('/recruiter-password-security-reset', [RecruiterFrontController::class, 'showPasswordSecurityForm'])->name('showPasswordSecurityFormRecruiter');
    Route::post('/recruiter-password-security-reset', [RecruiterFrontController::class, 'changePassword'])->name('changeRecruiterPassword');

    //payments
    Route::get('/recruiter-payment', [RecruiterPaymentController::class, 'index'])->name('recruiterPaymentIndex');
    Route::get('/recruiter-payment-list', [RecruiterPaymentController::class, 'list'])->name('recruiterPaymentList');
    Route::get('/recruiter-payout-list', [RecruiterPaymentController::class, 'recruiterPayoutList'])->name('recruiterPayoutList');

    //subscription plan
    Route::get('/recruiter-subscription-plan', [RecruiterSubscriptionFrontController::class, 'index'])->name('getRecruiterSubscriptionPlanView');
    Route::post('/recruiter-subscription-plan/cancel', [RecruiterSubscriptionFrontController::class, 'cancel'])->name('RecruiterSubscriptionPlanCancel');
    Route::post('/recruiter-subscription-plan/cancel-schedule', [RecruiterSubscriptionFrontController::class, 'cancelScheduled'])->name('RecruiterSubscriptionPlanCancelSchedule');
    Route::post('/recruiter-subscription-plan/upgrade', [RecruiterSubscriptionFrontController::class, 'upgrade'])->name('RecruiterSubscriptionPlanUpgrade');

    Route::get('/recruiter-jobs/{status?}', [RecruiterJobController::class, 'index'])->name('recruiteryJobs');
    Route::get('/recruiter-jobs-list', [RecruiterJobController::class, 'getList'])->name('recruiterJobsList');
    Route::post('/recruiter-jobs/make-favorite', [RecruiterJobController::class, 'makeFavorite'])->name('recruiterJobsMakeFavorite');
    Route::post('/recruiter-jobs/ajax-job-list-recruiter', [RecruiterJobController::class, 'ajaxJobList'])->name('ajaxJobListForRecruiter');
    Route::get('/recruiter-jobs-detail/{slug}', [RecruiterJobController::class, 'detail'])->name('recruiterJobsDetail');
    Route::get('/recruiter-candidate-application-detail/{id}/{jobId}', [RecruiterJobController::class, 'candidateDetail'])->name('recruiterCandidateDetail');


    Route::get('/recruiter/submit-candidate-start/{slug}', [CompanyJobApplicationsController::class, 'index'])->name('recruiterCandidateSubmitStart');
    Route::get('/recruiter/submit-candidate/{candidate?}', [CompanyJobApplicationsController::class, 'candidateSubmit'])->name('recruiterCandidateSubmit');
    Route::post('/recruiter/submit-candidate', [CompanyJobApplicationsController::class, 'postCandidateSubmit'])->name('postRecruiterCandidateSubmit');
    Route::post('/recruiter/search-candidate', [CompanyJobApplicationsController::class, 'candidateSearch'])->name('candidateSearch');
    Route::get('/recruiter/candidate-questionnaire', [CompanyJobApplicationsController::class, 'candidateQuestionnaire'])->name('recruiterCandidateQuestionnaire');
    Route::post('/recruiter/candidate-questionnaire', [CompanyJobApplicationsController::class, 'postCandidateQuestionnaire'])->name('postRecruiterCandidateQuestionnaire');
    Route::get('/recruiter/candidate-review', [CompanyJobApplicationsController::class, 'candidateSubmitReview'])->name('recruiterCandidateSubmitReview');
    Route::post('/recruiter/candidate-review', [CompanyJobApplicationsController::class, 'postCandidateSubmitReview'])->name('postRecruiterCandidateSubmitReview');
    Route::get('/recruiter/candidate-submit-success', [CompanyJobApplicationsController::class, 'candidateSubmitSuccess'])->name('recruiterCandidateSubmitSuccess');
    Route::post('/recruiter/candidate-email-unique', [CompanyJobApplicationsController::class, 'candidateSubmitUniqueEmail'])->name('candidateSubmitUniqueEmail');
    //recruiter dashboard route
    Route::get('/recruiter-dashboard', [RecruiterDashboardController::class, 'showDashboard'])->name('showRecruiterDashboard');

    // Add candidate
    Route::get('/recruiter/candidates', [RecruiterCandidatesController::class, 'index'])->name('recruiterCandidates');
    Route::get('/recruiter/candidates/list', [RecruiterCandidatesController::class, 'getList'])->name('recruiterCandidatesList');
    Route::get('/recruiter/candidates/add', [RecruiterCandidatesController::class, 'create'])->name('createRecruiterCandidates');
    Route::post('/recruiter/candidates/add', [RecruiterCandidatesController::class, 'store'])->name('storeRecruiterCandidates');
    Route::get('/recruiter/candidates/edit/{id}', [RecruiterCandidatesController::class, 'edit'])->name('editRecruiterCandidates');
    Route::post('/recruiter/candidates/delete/{id}', [RecruiterCandidatesController::class, 'delete'])->name('deleteRecruiterCandidates');
    Route::post('/recruiter/candidates/candidate-email-unique', [RecruiterCandidatesController::class, 'checkUniqueEmail'])->name('checkUniqueEmailRecruiterCandidates');
});


//Candidate Logedin Routes
Route::group(['middleware' => ['auth', 'roleUser:5']], function () {
    Route::get('/candidate-myinfo', [CandidateFrontController::class, 'showMyInfo'])->name('showMyInfoCandidate');
    Route::post('/candidate-myinfo-update', [CandidateFrontController::class, 'updateMyInfo'])->name('updateMyInfoCandidate');

    Route::get('/candidate-password-security', [CandidateFrontController::class, 'showPasswordSecurity'])->name('showPasswordSecurityCandidate');
    Route::get('/candidate-password-security-reset', [CandidateFrontController::class, 'showPasswordSecurityForm'])->name('showPasswordSecurityFormCandidate');
    Route::post('/candidate-password-security-reset', [CandidateFrontController::class, 'changePassword'])->name('changeCandidatePassword');

    // Route::get('/recruiter-payment',[RecruiterPaymentController::class, 'index'])->name('recruiterPaymentIndex');
    // Route::get('/recruiter-payment-list',[RecruiterPaymentController::class, 'list'])->name('recruiterPaymentList');
    // Route::get('/recruiter-payout-list',[RecruiterPaymentController::class, 'recruiterPayoutList'])->name('recruiterPayoutList');

    //notification-settings
    Route::get('/candidate-notification-settings', [CandidateFrontController::class, 'notificationSetting'])->name('notificationSettingCandidate');
    Route::get('/candidate-notification-update', [CandidateFrontController::class, 'updateNotificationSetting'])->name('updateNotificationSettingCandidate');

    Route::get('/candidate-dashboard', [CandidateDashboardController::class, 'showDashboard'])->name('showCandidateDashboard');
    Route::post('/candidate-jobs/make-favorite', [CandidateDashboardController::class, 'makeFavorite'])->name('candidateJobsMakeFavorite');
    Route::post('/candidate/apply-job/{jobId?}', [CandidateDashboardController::class, 'applyJob'])->name('candidateApplyJob');


    // candidate job list
    Route::get('/candidate-jobs/{tab?}', [CandidateJobsController::class, 'index'])->name('candidateJobs');
    Route::get('/candidate-jobs-list', [CandidateJobsController::class, 'getList'])->name('candidateJobsList');
    Route::post('/candidate/applied-job/', [CandidateJobsController::class, 'applyForJob'])->name('candidateAppliedJob');
    //Route::post('/candidate-jobs/make-favorite', [CandidateJobsController::class, 'makeFavorite'])->name('recruiterJobsMakeFavorite');
    Route::post('/candidate-jobs/ajax-job-list-recruiter', [CandidateJobsController::class, 'ajaxJobList'])->name('ajaxJobListForCandidate');
    //find candidate jobs
    Route::get('/find-jobs/{slug?}', [CandidateJobsController::class, 'findJobs'])->name('findJobs');
    Route::post('/find-jobs/ajax-find-job-list', [CandidateJobsController::class, 'ajaxFindJobList'])->name('ajaxFindJobList');
});

//for all logged in users  Routes
Route::group(['middleware' => ['auth']], function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::get('/notifications-list', [NotificationController::class, 'getList'])->name('notificationsList');
    Route::post('/notifications/delete/{id}', [NotificationController::class, 'delete'])->name('notificationDelete');
    Route::get('/notifications/readunread', [NotificationController::class, 'notificationReadUnread'])->name('notificationReadunread');
});
