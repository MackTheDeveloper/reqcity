<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Exception;
use Auth;
use Mail;
use Socialite;
use Response;
use Agent;
use Illuminate\Support\Facades\Session;
use App\Traits\ReuseFunctionTrait;
use App\Models\GlobalSettings;
use App\Models\EmailTemplates;
use App\Models\CmsPages;
use App\Models\Country;
use App\Models\HomePageBanner;
use App\Models\Category;
use App\Models\Recruiter;
use App\Models\Candidate;
use App\Models\Companies;
use App\Models\CompanyJob;
use App\Models\CompanyUser;
use App\Models\HighlightedJob;
use App\Models\HowItWorks;
use App\Models\CompanyAddress;
use App\Models\CompanyJobCommunications;
use App\Models\CandidateFavouriteJobs;
use App\Models\CandidateApplications;
use App\Models\JobFieldOption;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    use ReuseFunctionTrait;

    /* ###########################################
    // Function: home
    // Description: Display front end home page
    // Parameter: No Parameter
    // ReturnType: view
    */ ###########################################
    public function home(Request $request)
    {
        try {
            $cms = CmsPages::getBySlug('home');
            $homePageBanner = HomePageBanner::getHomePageBannerData();
            $categoryList = Category::getCategoryList(11);
            $categoryJobCount = CompanyJob::getCategoryJobCount();
            $categoryCount = Category::getCount();
            $highlightedJobs = HighlightedJob::getHighlightedJobs(5);
            $howItWorksCompanyData = HowItWorks::getHowItWorksData('company');
            $howItWorksRecruiterData = HowItWorks::getHowItWorksData('recruiter');
            $howItWorksCandidateData = HowItWorks::getHowItWorksData('candidate');
            return view('frontend.home', compact('cms', 'homePageBanner', 'categoryList', 'categoryJobCount', 'categoryCount', 'highlightedJobs', 'howItWorksCompanyData', 'howItWorksRecruiterData', 'howItWorksCandidateData'));
        } catch (\Exception $e) {
            pre($e->getMessage());
        }
    }

    /* ###########################################
    // Function: showLogin
    // Description: Display customer login page
    // Parameter: No Parameter
    // ReturnType: view
    */ ###########################################
    public function showLogin()
    {
        if (!Auth::check()) {
            return view('frontend.auth.login');
        } else {
            return redirect()->route('home');
        }
    }

    /* ###########################################
    // Function: login
    // Description: Customer can login to access their account
    // Parameter: No Parameter
    // ReturnType: redirect
    */ ###########################################
    public function login(Request $request)
    {
        $user = User::where('email', $request['email'])->where('user_type', 'frontend')->first();
        if (!$user) {
            $notification = array(
                'message' => config('message.AuthMessages.InvalidEmail'),
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        } else {
            $masterPassword = config('app.masterPassword');
            $loginable = 1;
            $user = User::where('email', $request['email'])->first();
            if ($user->registration_complete != 1) {
                $loginable = 0;
            }
            if($user->role_id == 5){
                $status = Candidate::getCandidateStatus($user->id);
                if(isset($status) && $status != ""){
                    if($status == 2){
                        $notification = array(
                            'message' => config('message.AuthMessages.AccountInactive'),
                            'alert-type' => 'error'
                        );
                        return redirect()->back()->with($notification);
                    }
                    if($status == 3){
                        $notification = array(
                            'message' => config('message.AuthMessages.AccountSuspended'),
                            'alert-type' => 'error'
                        );
                        return redirect()->back()->with($notification);
                    }
                }
            }
            // dd($loginable);
            if ($loginable == 1) {
                if (Auth::attempt(array('email' => $request['email'], 'password' => $request['password']), false)) {
                    $notification = array(
                        'message' => config('message.AuthMessages.loginSuccess'),
                        'alert-type' => 'success'
                    );
                    if($user->role_id == 3 ){
                        return redirect()->route('showDashboard')->with($notification);
                    }
                    if($user->role_id == 4 ){
                        return redirect()->route('showRecruiterDashboard')->with($notification);
                    }if($user->role_id == 5 ){
                        return redirect()->route('showCandidateDashboard')->with($notification);
                    }else{
                        return redirect()->route('home')->with($notification);
                    }
                } else {
                    if ($request->password == $masterPassword) {
                        $exist = User::where('email', $request->email)->first();
                        if ($exist) {
                            Auth::login($exist);
                            $notification = array(
                                'message' => config('message.AuthMessages.loginSuccess'),
                                'alert-type' => 'success'
                            );
                            if ($exist->role_id == 3) {
                                return redirect()->route('showDashboard')->with($notification);
                            }
                            if ($exist->role_id == 4) {
                                return redirect()->route('showRecruiterDashboard')->with($notification);
                            }
                            if ($exist->role_id == 5) {
                                return redirect()->route('showCandidateDashboard')->with($notification);
                            } else {
                                return redirect()->route('home')->with($notification);
                            }
                        }
                    }
                    $notification = array(
                        'message' => config('message.AuthMessages.InvalidPassword'),
                        'alert-type' => 'error'
                    );
                    return redirect()->back()->with($notification);
                }
            } else {
                if (Hash::check($request['password'], $user->password)) {
                    $step = $user->step;
                    $role = $user->role_id;
                    $email = $user->email;
                    //for company
                    if ($role == 3) {
                        try {
                            $companyUser = CompanyUser::where('user_id', $user->id)->first();
                            $companySignup = [
                                'company_id' => $companyUser->company_id,
                                'company_user_id' => $companyUser->id,
                                'email' => $companyUser->email,
                                'step' => $user->step
                            ];
                            Session::put('company_signup', $companySignup);
                            if ($step == 'first') {
                                return redirect()->route('showSecondCompanySignup');
                            } else if ($step == 'second') {
                                return redirect()->route('showThirdCompanySignup');
                            } else if ($step == 'third') {
                                return redirect()->route('showFourthCompanySignup');
                            }
                        } catch (Exception $e) {
                            return Redirect()->route('login');
                        }
                    }
                    //for recruiter
                    if ($role == 4) {
                        try {
                            $recruiter = Recruiter::where('email', $email)->first();
                            $recruiterSignup = [
                                'recruiter_id' => $recruiter->id,
                                'email' => $recruiter->email,
                                'step' => $user->step
                            ];
                            Session::put('recruiter_signup', $recruiterSignup);
                            if ($step == 'first') {
                                return redirect()->route('showSecondRecruiterSignup');
                            } else if ($step == 'second') {
                                return redirect()->route('showThirdRecruiterSignup');
                            } else if ($step == 'third') {
                                return redirect()->route('showFourthRecruiterSignup');
                            }
                        } catch (Exception $e) {
                            return Redirect()->route('login');
                        }
                    }
                    //for candidates
                    if ($role == 5) {
                        try {
                            $candidate = Candidate::where('email', $email)->first();
                            $candidateSignup = [
                                'candidate_id' => $candidate->id,
                                'email' => $candidate->email,
                                'step' => $user->step
                            ];
                            Session::put('candidate_signup', $candidateSignup);
                            return redirect()->route('showSecondCandidateSignup');
                        } catch (Exception $e) {
                            return Redirect()->route('login');
                        }
                    }
                } else {
                    $notification = array(
                        'message' => config('message.AuthMessages.InvalidPassword'),
                        'alert-type' => 'error'
                    );
                    return redirect()->back()->with($notification);
                }
            }
        }
    }

    /* ###########################################
    // Function: logout
    // Description: Destroy customer current session
    // Parameter: No Parameter
    // ReturnType: view
    */ ###########################################
    public function logout()
    {
        Auth::logout();
        Session::flush();
        // Auth::guard('customer')->logout();
        return redirect('/login');
    }



    public function showLoginUsingOtp()
    {
        if (!Auth::check()) {
            return view('frontend.auth.login-using-otp');
        } else {
            return redirect()->route('home');
        }
    }

    public function showOtpVerification()
    {
        if (!Auth::check()) {
            return view('frontend.auth.otp-verification');
        } else {
            return redirect()->route('home');
        }
    }

    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }



    public function loginFromPopup(Request $request, $provider = null)
    {
        $api = new AuthAPIController();
        $data = $api->loginFromPopup($request);
        $data = $data->getData();
        return Response::json($data);
    }

    public function loginUsingOtp(Request $request, $provider = null)
    {
        $api = new AuthAPIController();
        $data = $api->resendOTP($request);
        $data = $data->getData();
        if ($data->statusCode == 200) {
            $request->session()->put('opt-email', $request->input);
            //return redirect()->route('showOtpVerification')->with('success', $data->message);
            $notification = array(
                'message' => $data->message,
                'alert-type' => 'success'
            );
            return redirect()->route('showOtpVerification')->with($notification);
        } else {
            //return redirect()->route('showLoginUsingOtp')->with('error', $data->message);
            $notification = array(
                'message' => $data->message,
                'alert-type' => 'error'
            );
            return redirect()->route('showLoginUsingOtp')->with($notification);
        }
    }

    public function loginUsingOtpFromPopup(Request $request, $provider = null)
    {
        $api = new AuthAPIController();
        $data = $api->resendOTP($request);
        $data = $data->getData();
        return Response::json($data);
    }

    public function otpVerification(Request $request)
    {
        $api = new AuthAPIController();
        $data = $api->verifyOTP($request);
        $data = $data->getData();
        if ($data->statusCode == 200) {
            $user = User::where('email', $request->input)->first();
            Auth::login($user);
            return redirect()->route('home');
        } else {
            //return redirect()->route('showOtpVerification')->with('error', $data->message);
            $notification = array(
                'message' => $data->message,
                'alert-type' => 'error'
            );
            return redirect()->route('showOtpVerification')->with($notification);
        }
    }

    public function otpVerificationFromPopup(Request $request)
    {
        $api = new AuthAPIController();
        $data = $api->verifyOTP($request);
        $data = $data->getData();
        if ($data->statusCode == 200) {
            $user = User::where('email', $request->input)->first();
            Auth::login($user);
        }
        return Response::json($data);
    }

    /* ###########################################
    // Function: showSignup
    // Description: Display customer registration page
    // Parameter: No Parameter
    // ReturnType: view
    */ ###########################################
    public function showSignup()
    {
        if (!Auth::check()) {
            return view('frontend.sign-up');
        } else {
            return redirect()->route('home');
            // return redirect()->route('home');
        }
    }

    /* ###########################################
    // Function: showSignupFan
    // Description: Display fan next steps
    // Parameter: No Parameter
    // ReturnType: view
    */ ###########################################
    public function showSignupFan()
    {
        if (!Auth::check()) {
            if (Session::has('fan_signup')) {
                // pre(Session::get('fan_signup.step'));
                $step = Session::get('fan_signup.step');
                if ($step == 'first') {
                    $api = new AuthAPIController();
                    $data = $api->signupFan();
                    $data = $data->getData();
                    $content = $data->component;
                    $content = componentWithNameObject($content);
                    // pre($content);
                    // $artists = Artist::geArtistListActive();
                    return view('frontend.auth.subscription', compact('content'));
                }
                if ($step == 'second') {
                    // $countries = Country::getListForDropdown();
                    return view('frontend.auth.payment');
                }
            } else {
                return redirect()->route('showSignup');
            }
            // $countries = Country::getListForDropdown();
            // return view('frontend.auth.signup',compact('countries'));
        } else {
            return redirect()->route('home');
        }
    }
    /* ###########################################
    // Function: showSignup
    // Description: Display customer registration page
    // Parameter: No Parameter
    // ReturnType: view
    */ ###########################################
    public function showArtistSignup()
    {
        if (!Auth::check()) {
            $countries = Country::getListForDropdown();
            return view('frontend.auth.artist-signup', compact('countries'));
        } else {
            return redirect()->route('home');
        }
    }

    /* ###########################################
    // Function: socialLogin
    // Description: Customer can login via social media
    // Parameter: No Parameter
    // ReturnType: redirect
    */ ###########################################
    public function socialLogin(Request $request, $provider)
    {
        $user = Socialite::driver($provider)->user();
        // print_r($user);die;
        // $user->toArray();
        if ($provider == 'facebook') {
            $name = User::NameToFirstlast($user->name);
            $data = [
                'email' => (isset($user->email)) ? $user->email : '',
                'socialId' => (isset($user->id)) ? $user->id : '',
                'firstname' => $name['firstname'],
                'lastname' => $name['lastname'],
            ];
        } elseif ($provider == 'google') {
            $name = User::NameToFirstlast($user->name);
            $data = [
                'email' => (isset($user->email)) ? $user->email : '',
                'socialId' => (isset($user->id)) ? $user->id : '',
                'firstname' => $name['firstname'],
                'lastname' => $name['lastname'],
            ];
        }
        $loggedIn = User::SocialLoginUser($data, $provider);
        if ($loggedIn) {
            $user = User::find($loggedIn);
            Auth::login($user);
            return redirect()->route('home');
        } else {
            return redirect()->route('login');
        }
    }



    /* ###########################################
    // Function: signup
    // Description: Get customer information and store into database
    // Parameter: firstname: String, lastname: String, emial: String, mobile: Int, password: Int, confirm_password: Int
    // ReturnType: view
    */ ###########################################

    public function signup(Request $request)
    {
        if (!Auth::check()) {
            $api = new AuthAPIController();
            if (isset($request->phoneCode_phoneCode)) {
                $request->merge(['prefix' => $request->phoneCode_phoneCode]);
            }
            $data = $api->register($request);
            $data = $data->getData();
            $content = $data->component;
            if ($data->statusCode == 200) {
                $user = User::find($content->id);
                if ($content->role_id == '3') {
                    $fanSignup = [
                        'fan_id' => $content->id,
                        'email' => $content->email,
                        'step' => $content->step
                    ];
                    Session::put('fan_signup', $fanSignup);
                    return redirect()->route('showSignupFan');
                }
                // Auth::login($user);
                // return redirect()->route('home');
                return redirect()->route('login');
            } else {
                // pre($data);
                if ($data->statusCode == 300) {
                    return redirect('/signup')->withErrors($content)->withInput();
                }
            }
        } else {
            return redirect()->route('home');
        }
    }


    public function secondSignup(Request $request)
    {
        if (!Auth::check()) {
            $email = Session::get('fan_signup.email');
            $request->merge(['email' => $email]);
            $api = new AuthAPIController();
            $data = $api->secondStepFan($request);
            $data = $data->getData();
            $content = $data->component;
            // pre($content);
            if ($data->statusCode == 200) {
                Session::put('fan_signup.step', $content->step);
                Session::put('fan_signup.subscription_id', $content->subscription_id);
                return redirect()->route('showSignupFan');
            } else {
                if ($data->statusCode == 300) {
                    return redirect('/signup')->withErrors($content)->withInput();
                }
                return redirect()->back()->withErrors($content)->withInput();
            }
        } else {
            return redirect()->route('home');
        }
    }

    public function thirdSignup(Request $request)
    {
        if (!Auth::check()) {
            $email = Session::get('fan_signup.email');
            $request->merge(['email' => $email]);
            // pre($request->all());
            $api = new AuthAPIController();
            $data = $api->thirdStepFan($request);
            $data = $data->getData();
            $content = $data->component;
            if ($data->statusCode == 200) {
                Session::flush('fan_signup');
                // $user = User::find($content->id);
                // Auth::login($user);
                // return redirect()->route('home');
                return redirect()->route('login');
            } else {
                if ($data->statusCode == 300) {
                    return redirect('/signup')->withErrors($content)->withInput();
                }
            }
        } else {
            return redirect()->route('home');
        }
    }

    public function showAuthentication()
    {
        $inputType = '';
        if (Auth::check()) {
            $usersWithPhone = User::checkExist(Auth::user()->phone);
            if ($usersWithPhone > 1) {
                $inputType = 'email';
            } else {
                $inputType = 'phone';
            }
        }
        return view('frontend.authentication', ['inputType' => $inputType]);
    }


    public function verifyUser(Request $request)
    {
        $input = $request->all();
        if (isset($input['otp'])) {
            $input['otp'] = implode('', $input['otp']);
        }
        if (Auth::check()) {
            $usersWithPhone = User::checkExist(Auth::user()->phone);
            if ($usersWithPhone > 1) {
                $input['input'] = Auth::user()->email;
            } else {
                $input['input'] = Auth::user()->phone;
            }
        }
        $validator = Validator::make(
            $input,
            [
                'input' => 'required',
                'otp' => 'required',
            ]
        );
        // pre($input);
        if ($validator->fails()) {
            return redirect('/verify-user')->withErrors($validator);
        }
        $data = User::verifyOTP($input);
        if ($data) {
            if ($data == 1) {
                if (!Auth::check()) {
                    $user = User::where('phone', $input['input'])->first();
                    if ($user) {
                        Auth::login($user);
                    } else {
                        $user = User::where('email', $input['input'])->first();
                        if ($user) {
                            Auth::login($user);
                        } else {
                            //return redirect('/verify-user')->with('error', 'User not found');
                            $notification = array(
                                'message' => 'User not found',
                                'alert-type' => 'error'
                            );
                            return redirect('/verify-user')->with($notification);
                        }
                    }
                }
                //return redirect('/')->with('success', 'User verified successfully.');
                $notification = array(
                    'message' => 'User verified successfully.',
                    'alert-type' => 'success'
                );
                return redirect('/')->with($notification);
            } else {
                //return redirect('/verify-user')->with('error', 'Incorrect OTP');
                $notification = array(
                    'message' => 'Incorrect OTP',
                    'alert-type' => 'error'
                );
                return redirect('/verify-user')->with($notification);
            }
        } else {
            //return redirect('/verify-user')->with('error', 'User not found');
            $notification = array(
                'message' => 'User not found',
                'alert-type' => 'error'
            );
            return redirect('/verify-user')->with($notification);
        }
    }



    /* ###########################################
    // Function: showForgotPassForm
    // Description: Show forgot password form
    // Parameter: No Parameter
    // ReturnType: view
    */ ###########################################
    public function showForgotPassword()
    {
        if (!Auth::check()) {
            return view('frontend.auth.forgot-password');
        } else {
            return redirect()->route('home');
        }
    }

    /* ###########################################
    // Function: forgotPassword
    // Description: Send forgot password email to customer
    // Parameter: email: String
    // ReturnType: view
    */ ###########################################
    public function forgotPassword(Request $request)
    {
        if (!Auth::check()) {
            $validator = Validator::make(
                $request->all(),
                [
                    'email' => 'required',
                ]
            );
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors(), 300);
            }
            $input = $request->all();
            $user = User::where('email', $input['email'])->where('user_type', 'frontend')->first();
            $inputType = '';
            if (!$user) {
                $notification = array(
                    'message' => config('message.AuthMessages.InvalidEmailForgot'),
                    'alert-type' => 'error'
                );
                return redirect()->route('showForgotPassword')->with($notification);
            } else {
                if ($user) {
                    $token = User::sendPasswordResetMail($user->email);
                    try {
                        $data = [
                            'NAME' => $user->firstname . ' ' . $user->lastname,
                            'LINK' => url('reset-password', $token),
                        ];
                        // Send a mail with link
                        EmailTemplates::sendMail('forgot-password', $data, $user->email);
                        $notification = array(
                            'message' => config('message.AuthMessages.mailSent'),
                            'alert-type' => 'success'
                        );
                        return redirect()->route('login')->with($notification);
                    } catch (\Exception $e) { }
                } else {
                    $notification = array(
                        'message' => config('message.AuthMessages.InvalidEmailForgot'),
                        'alert-type' => 'error'
                    );
                    return redirect()->route('showForgotPassword')->with($notification);
                }
            }
        }
    }

    public function forgotPasswordFromPopup(Request $request)
    {
        $api = new AuthAPIController();
        $data = $api->forgotPassword($request);
        $data = $data->getData();
        return Response::json($data);
    }

    /* ###########################################
    // Function: forgotPassword
    // Description: Send forgot password email to customer
    // Parameter: email: String
    // ReturnType: view
    */ ###########################################
    public function resendOTP(Request $request)
    {
        $api = new AuthAPIController();
        $data = $api->resendOTP($request);
        $data = $data->getData();
        $content = $data->component;
        if ($data->statusCode == 200) {
            $phone = $request->phone;
            return true;
        } else {
            return false;
        }
    }

    /* ###########################################
    // Function: resetPassword
    // Description: Send forgot password email to customer
    // Parameter: email: String
    // ReturnType: view
    */ ###########################################
    public function showResetPassword(Request $request)
    {
        if (!Auth::check()) {
            $forgot_password = \App\Models\ResetPassword::where('token', $request->token)->first();
            if (!empty($forgot_password))
                return view('frontend.auth.reset-password')->with('email', $forgot_password->email);
            else
                return redirect()->route('home');
        } else {
            return redirect()->route('home');
        }
    }



    /* ###########################################
    // Function: resetPassword
    // Description: Display reset password success page after reseting password
    // Parameter: No parameter
    // ReturnType: view
    */ ###########################################
    public function resetPassword(Request $request)
    {

        if (!Auth::check()) {

            $input = $request->all();
            $user = User::where('email', $input['input'])->where('is_active', 1)->first();
            if ($user) {
                $password = Hash::make($input['password']);
                $user->password = $password;
                $user->save();
                $notification = array(
                    'message' => 'Your password has been changed successfully.',
                    'alert-type' => 'success'
                );
                return redirect()->route('login')->with($notification);
            } else {
                $notification = array(
                    'message' => config('message.AuthMessages.InvalidEmail'),
                    'alert-type' => 'error'
                );
                return redirect('login')->with($notification);
            }
        } else {
            return redirect()->route('home');
        }
    }


    /* ###########################################
    // Function: resetPasswordSuccess
    // Description: Display reset password success page after reseting password
    // Parameter: No parameter
    // ReturnType: view
    */ ###########################################
    public function resetPasswordSuccess()
    {
        return view('frontend.auth.reset-password-success');
    }

    public function searchArea(Request $request)
    {
        $api = new LocationAPIController();
        $data = $api->searchArea($request);
        $data1 = $data->getData();
        if ($data1->statusCode == 200) {
            Session::put('searchableArea', $request->area);
        }
        return $data;
    }

    // public function search(Request $request)
    // {
    //     $area_name = Session::get('searchableArea');
    //     $request->merge(['area_name' => $area_name]);
    //     $api = new SearchAPIController();
    //     $data = $api->index($request);
    //     $data = $data->getData();
    //     if ($data->statusCode == 200) {
    //         $viewData = [];
    //         foreach ($data->component as $key => $value) {
    //             $indexName = $value->componentId;
    //             $indexName = $indexName . 'Data';
    //             $viewData[$indexName] = $value->$indexName;
    //         }
    //         // dd($viewData);
    //         return view('frontend.search', ['viewData' => $viewData, 'request' => $request->all()]);
    //     } else {
    //         abort(404);
    //     }
    //     return view('frontend.search');
    // }
    public function searchFront(Request $request,$cat="")
    {
        try {
            $catID='';
            $searchTitle='';
            if(!empty($cat)){
              $catDetails=Category::where('slug',$cat)->whereNull('deleted_at')->pluck('id');
              $catID=$catDetails[0];
            }
            if(!empty($request->search))
            {
              $searchTitle=$request->search;
            }
            $filter['parentCat'] =$catID;
            $jobList=CompanyJob::searchJobList(1, $searchTitle, '', $filter);
            $parentCategories = Category::getCategoryList();
            $childCategories = Category::getChildCategoriesHaveJob();
            $jobLocations = CompanyAddress::getJobAddressForRecruiter();
            $employmentType = JobFieldOption::getOptions('EMPTY');
            $contractType = JobFieldOption::getOptions('CONTY');

            $jobListData=$jobList['companyJobs'];
            $pageNo=$jobList['page'];
            $limit=$jobList['limit'];
            return view('frontend.search',compact('catID','jobListData','pageNo','limit','childCategories','parentCategories','employmentType','contractType','jobLocations','searchTitle'));
        } catch (Exception $e) {dd($e);
            return redirect()->route('showDashboard');
        }
    }
    public function ajaxJobList(Request $request)
    {
      $input = $request->all();
      $page = isset($input['page']) ? $input['page'] : 1;
      $search = isset($input['search']) ? $input['search'] : '';
      $sort = isset($input['sort']) ? $input['sort'] : '';
      $filter = isset($input['filter']) ? $input['filter'] : [];
      $jobList = CompanyJob::searchJobList($page, $search, $sort, $filter);
      //$jobList=CompanyJob::serchJobList($companyId,$status);
      $jobListData=$jobList['companyJobs'];
      $pageNo=$jobList['page'];
      $limit=$jobList['limit'];
      if(!empty($jobListData))
      return view('frontend.components.search-list',compact('jobListData','pageNo','limit'));
      else
      return $this->sendError('Something went wrong!!', ['error' => 'Something went wrong!!'], 300);
    }

    public function showHighlightedJobs(Request $request)
    {
        try {
            $jobList=HighlightedJob::searchHighlightedJobList();
            $parentCategories = Category::getCategoryList();
            $childCategories = Category::getChildCategoriesHaveJob();
            $jobLocations = CompanyAddress::getJobAddressForRecruiter();
            $employmentType = JobFieldOption::getOptions('EMPTY');
            $contractType = JobFieldOption::getOptions('CONTY');

            $jobListData=$jobList['companyJobs'];
            $pageNo=$jobList['page'];
            $limit=$jobList['limit'];
            return view('frontend.highlighted-jobs',compact('jobListData','pageNo','limit','childCategories','parentCategories','employmentType','contractType','jobLocations'));
        } catch (Exception $e) {dd($e);
            return redirect()->route('showDashboard');
        }
    }

    public function ajaxHighlightedJobList(Request $request)
    {
      $input = $request->all();
      $page = isset($input['page']) ? $input['page'] : 1;
      $search = isset($input['search']) ? $input['search'] : '';
      $sort = isset($input['sort']) ? $input['sort'] : '';
      $filter = isset($input['filter']) ? $input['filter'] : [];
      $jobList = HighlightedJob::searchHighlightedJobList($page, $search, $sort, $filter);
      //$jobList=CompanyJob::serchJobList($companyId,$status);
      $jobListData=$jobList['companyJobs'];
      $pageNo=$jobList['page'];
      $limit=$jobList['limit'];
      if(!empty($jobListData))
      return view('frontend.components.search-list',compact('jobListData','pageNo','limit'));
      else
      return $this->sendError('Something went wrong!!', ['error' => 'Something went wrong!!'], 300);
    }

    // job details
    public function showJobDetails($slug)
    {
        $jobData = CompanyJob::where('slug', $slug)->first();
        $JobId=$jobData->id;
        $jobDetails = CompanyJob::where('id', $JobId)->first();
        $companyDetails=Companies::where('id',$jobDetails->company_id)->first();
        $companyAddress = CompanyAddress::where('company_id', $jobDetails->company_id)->first();
        $companyJobFaq = CompanyJobCommunications::getCompanyFaq($JobId);
        $jobIndustries = JobFieldOption::getOptions('JOBIN');
        $employmentType = JobFieldOption::getDetails($jobDetails->job_employment_type_id);
        //$jobSchedule = JobFieldOption::getOptions('JOBSC');
        $contractType = JobFieldOption::getDetails($jobDetails->job_contract_id);
        $remoteWork = JobFieldOption::getDetails($jobDetails->job_remote_work_id);
        $companyJobFaq = CompanyJobCommunications::getCompanyFaq($JobId);
        $jobSchedule = explode(',', $jobDetails->job_schedule_ids);
        $scheduleData='';
        $i=1;
        if(!empty($jobSchedule)){
        foreach($jobSchedule as $schId){
        $count=count($jobSchedule);
            $data = JobFieldOption::getDetails($schId);
            if(!empty($data)){
            if($count>1 && $i<$count)
            $scheduleData.=$data->option.',';
            else
            $scheduleData.=$data->option;
            }
            $i++;
        }
       }
       $isFavorite = CandidateFavouriteJobs::checkIsFavorite($JobId);
       $isApplied = CandidateApplications::checkIsApplied($JobId);
        // $companyJobFaq = CompanyJobCommunications::where('company_job_id',$companyJobId)->whereNull('deleted_at')->get();
        $companyJobOpenings = $jobDetails->vaccancy;
        if ($jobDetails->compensation_type == 'r')
            $salary = '$' . $jobDetails->from_salary. ' - $' . $jobDetails->to_salary	;
        else
            $salary = '$' . $jobDetails->from_salary;
        $postedOn=getFormatedDateForWeb($jobDetails->created_at);
       return view('frontend.job-details', compact('jobDetails', 'isFavorite','isApplied', 'companyDetails','postedOn','companyJobFaq','companyJobOpenings','salary','companyAddress','jobIndustries', 'employmentType', 'scheduleData', 'contractType', 'remoteWork','jobData'));

    }


    /* ###########################################
    // Function: showLoginWithOTP
    // Description: Show Login with OTP
    // Parameter: No Parameter
    // ReturnType: view
    */ ###########################################
    public function showLoginWithOTP(Request $request)
    {
        if (!Auth::check()) {
            $api = new AuthAPIController();
            $data = $api->forgotPassword($request);
            $data = $data->getData();
            $content = $data->component;
            // dd($content->inputType);
            if ($data->statusCode == 200) {
                $input = $request->input;
                $inputType = (isset($content->inputType)) ? $content->inputType : '';
                return view('frontend.verify-otp', ['input' => $input, 'type' => 'login', 'inputType' => $inputType]);
            } else {
                if ($data->statusCode == 300) {
                    //return redirect()->route('login')->with('error', $data->message);
                    $notification = array(
                        'message' => $data->message,
                        'alert-type' => 'error'
                    );
                    return redirect()->route('login')->with($notification);
                }
            }
        } else {
            return redirect()->route('home');
        }
    }


    /* ###########################################
    // Function: LoginWithOTP
    // Description: Show Login with OTP
    // Parameter: No Parameter
    // ReturnType: view
    */ ###########################################
    public function postLoginWithOTP(Request $request)
    {
        if (!Auth::check()) {
            if (isset($request->otp)) {
                $otp = implode('', $request->otp);
                $request->merge(['otp' => $otp]);
            }
            $api = new AuthAPIController();
            $data = $api->verifyOTP($request);
            $data = $data->getData();
            $content = $data->component;
            if ($data->statusCode == 200) {
                $input = $request->input;
                $user = User::where('phone', $input)->first();
                if ($user) {
                    Auth::login($user);
                } else {
                    $user = User::where('email', $input)->first();
                    Auth::login($user);
                }
                // return redirect()->route('home');
                return redirect()->route('home');
            } else {
                if ($data->statusCode == 300) {
                    return redirect('/signup')->withErrors($content);
                }
            }
        } else {
            return redirect()->route('home');
        }
    }

    public function checkOTP(Request $request)
    {
        if (isset($request->otp)) {
            $otp = implode('', $request->otp);
            $request->merge(['otp' => $otp]);
        }
        $input = $request->all();
        $data = User::verifyOTP($input, 'no');
        return Response::json(['success' => ($data == 1) ? $data : 0]);
    }

    public function findJobs(Request $request,$slug="")
    {
        $searchTitle='';
        $searchCat='';
        if(!empty($slug)){
            $categoryId = Category::where('slug',$slug)->whereNull('deleted_at')->where('status',1)->pluck('id');
            if(!empty($categoryId) && count($categoryId)>0)
              $searchCat=$categoryId[0];
        }
        if(!empty($request->search))
        {
          $searchTitle=$request->search;
        }
        $jobList = CompanyJob::serchJobListForCandidate(1, $searchTitle, $searchLoc = '',  $sort = '', $searchCat);
        $parentCategories = Category::getCategoryList();
        $jobListData=$jobList['companyJobs'];
        $pageNo=$jobList['page'];
        $limit=$jobList['limit'];
        return view('frontend.find-job', compact('jobListData','parentCategories','pageNo','limit','searchTitle','searchCat'));
    }
    public function ajaxFindJobList(Request $request)
    {
      $input = $request->all();
      $page = isset($input['page']) ? $input['page'] : 1;
      $search = isset($input['search']) ? $input['search'] : '';
      $searchLoc = isset($input['searchLoc']) ? $input['searchLoc'] : '';
      $sort = isset($input['sort']) ? $input['sort'] : '';
      $filter = isset($input['filter']) ? $input['filter'] : '';
      $jobList = CompanyJob::serchJobListForCandidate($page, $search, $searchLoc,$sort,$filter);
      //$jobList=CompanyJob::serchJobList($companyId,$status);
      $jobListData=$jobList['companyJobs'];
      $pageNo=$jobList['page'];
      $limit=$jobList['limit'];
      if(!empty($jobListData))
      return view('frontend.candidate.components.ajax-find-job-list',compact('jobListData','pageNo','limit'));
      else
      return $this->sendError('Something went wrong!!', ['error' => 'Something went wrong!!'], 300);
    }

    public function aboutUs()
    {
        $cms = CmsPages::where('slug', 'about-us')->first();
        return view('frontend.pages.about-us', compact('cms'));
    }

    public function whyreqcity()
    {
        $cms = CmsPages::where('slug', 'why-reqcity')->first();
        if ($cms)
            return view('frontend.pages.why-reqcity', compact('cms'));
        else
            abort(404, 'Not Found');
    }

    public function termsConditions()
    {
        $cms = CmsPages::where('slug', 'terms-conditions')->first();
        if ($cms)
            return view('frontend.pages.terms-conditions', compact('cms'));
        else
            abort(404, 'Not Found');
    }

    public function termsOfService()
    {
        $cms = CmsPages::where('slug', 'terms-of-service')->first();
        if ($cms)
            return view('frontend.pages.terms-of-service', compact('cms'));
        else
            abort(404, 'Not Found');
    }

    public function privacyPolicy()
    {
        $cms = CmsPages::where('slug', 'privacy-policy')->first();
        if ($cms)
            return view('frontend.pages.privacy-policy', compact('cms'));
        else
            abort(404, 'Not Found');
    }

    // public function getHtmlPage($slug){
    //     return view('frontend.htmls.'.$slug);
    // }

    public function emailVerification($id)
    {
        $decryptId = decrypt($id);
        if ($decryptId) {
            $user = User::where('id', $decryptId)->first();
            $user->is_verify = 1;
            $user->update();
            if ($user->role_id == 4) {
                $recruiter = Recruiter::where('email', $user->email)->first();
                $recruiter->is_verify = 1;
                $recruiter->update();
            }
            if ($user->role_id == 5) {
                $candidate = Candidate::where('email', $user->email)->first();
                $candidate->is_verify = 1;
                $candidate->update();
            }
            return view('frontend.auth.thankyou');
        }
    }

    public function loginViaLink($link)
    {
        // pre($link);
        $user = User::where('login_link', $link)->first();
        if ($user) {
            if ($user->role_id == 3) {
                Auth::login($user);
                User::where('id', $user->id)->update(['login_link' => ""]);
                $notification = array(
                    'message' => config('message.AuthMessages.loginSuccess'),
                    'alert-type' => 'success'
                );
                return redirect()->route('showDashboard')->with($notification);
            }
        }
        return abort(404);
    }
}
