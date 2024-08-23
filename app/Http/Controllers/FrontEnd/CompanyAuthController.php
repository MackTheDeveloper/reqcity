<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Artist;
use App\Http\Controllers\API\V1\AuthAPIController;
use App\Http\Controllers\API\V1\LocationAPIController;
use App\Http\Controllers\API\V1\SearchAPIController;
use Exception;
use Auth;
use Mail;
use Socialite;
use Response;
use Agent;
use Illuminate\Support\Facades\Session;
use App\Traits\ReuseFunctionTrait;
use App\Http\Controllers\API\V1\BlogsAPIController;
use App\Http\Controllers\API\V1\HomePageAPIController;
use App\Http\Controllers\API\V1\PagesAPIController;
use App\Models\Candidate;
use App\Models\GlobalSettings;
use App\Models\CmsPages;
use App\Models\Companies;
use App\Models\CompanyAddress;
use App\Models\CompanySubscription;
use App\Models\CompanyUser;
use App\Models\Country;
use App\Models\EmailTemplates;
use App\Models\JobFieldOption;
use App\Models\PlanFeatures;
use App\Models\SubscriptionPlan;
use Redirect;

class CompanyAuthController extends Controller
{
    use ReuseFunctionTrait;



    /* ###########################################
    // Function: showCompanySignup
    // Description: Display company registration page
    // Parameter: No Parameter
    // ReturnType: view
    */ ###########################################
    public function showCompanySignup()
    {
        if (!Auth::check()) {
            $countries = Country::getListForDropdown();
            $model = new User;
            $email = Session::get('company_signup.email');
            $companyId = Session::get('company_signup.company_id');
            $companyUserId = Session::get('company_signup.company_user_id');
            if (isset($email)) {
                $model = User::where('email', $email)->first();
            }
            return view('frontend.auth.company.signup', compact('countries', 'model', 'companyId', 'email', 'companyUserId'));
        } else {
            return redirect()->route('home');
            // return redirect()->route('home');
        }
    }

    /* ###########################################
    // Function: showCompanySecondSignup
    // Description: Display company registration page
    // Parameter: No Parameter
    // ReturnType: view
    */ ###########################################
    public function showCompanySecondSignup()
    {
        $companyId = Session::get('company_signup.company_id');
        $email = Session::get('company_signup.email');
        $companyUserId = Session::get('company_signup.company_user_id');
        if (!isset($companyId)) {
            return redirect()->route('login');
        } else {
            $companySize = JobFieldOption::getOptions('CMPSZ');
            $countries = Country::getListForDropdown();
            $company = Companies::find($companyId);
            $companyUser = CompanyUser::find($companyUserId);
            $companyAddress = CompanyAddress::where('company_id', $companyId)->get();
            return view('frontend.auth.company.signupTwo', compact('countries', 'company', 'companyUser', 'companyId', 'email', 'companySize', 'companyAddress', 'companyUserId'));
        }
    }

    /* ###########################################
    // Function: showCompanyThirdSignup
    // Description: Display company registration page
    // Parameter: No Parameter
    // ReturnType: view
    */ ###########################################
    public function showCompanyThirdSignup()
    {
        $companyId = Session::get('company_signup.company_id');
        $email = Session::get('company_signup.email');
        $companyUserId = Session::get('company_signup.company_user_id');
        if (!isset($companyId)) {
            return redirect()->route('login');
        } else {
            $model = User::where('email', $email)->first();
            $subscriptionPlanYearly = SubscriptionPlan::getPlan('company', 'yearly');
            $subscriptionPlanMonthly = SubscriptionPlan::getPlan('company', 'monthly');
            $subscriptionPlanFeatures = PlanFeatures::getList('Company');
            $getCurrentSubscription = SubscriptionPlan::getDetails($model->current_subscription);
            return view('frontend.auth.company.signupThree', compact('subscriptionPlanYearly', 'subscriptionPlanMonthly', 'subscriptionPlanFeatures','companyId', 'email', 'companyUserId', 'model', 'getCurrentSubscription'));
        }
    }

    /* ###########################################
    // Function: showCompanyThirdSignup
    // Description: Display company registration page
    // Parameter: No Parameter
    // ReturnType: view
    */ ###########################################
    public function showCompanyFourthSignup()
    {
        $companyId = Session::get('company_signup.company_id');
        $email = Session::get('company_signup.email');
        $companyUserId = Session::get('company_signup.company_user_id');
        if (!isset($companyId)) {
            return redirect()->route('login');
        } else {
            $model = User::where('email', $email)->first();
            $getCurrentSubscription = SubscriptionPlan::getDetails($model->current_subscription);
            $untilDate = SubscriptionPlan::getUntildate($getCurrentSubscription->plan_type,$getCurrentSubscription->trial_period);
            $trialDates = SubscriptionPlan::getTrialEnddate($getCurrentSubscription->trial_period);
            return view('frontend.auth.company.signupFour', compact('companyId', 'email', 'companyUserId', 'model', 'getCurrentSubscription','untilDate','trialDates'));
        }
    }


    /* ###########################################
    // Function: showCompanySuccessSubscribe
    // Description: Display recruiter registration page
    // Parameter: No Parameter
    // ReturnType: view
    */ ###########################################
    public function showCompanySuccessSubscribe()
    {
        $email = Session::get('company_signup.email');
        $companyId = Session::get('company_signup.company_id');
        if (!isset($companyId)) {
            return redirect()->route('login');
        } else {
            $model = User::where('email', $email)->first();
            // $model->registration_complete = 1;
            // $model->save();
            $subscription = CompanySubscription::getLastSubscription($model->id);
            // pre($subscription);
            $subscriptionNumber = $subscription->subscription_number;
            Session::forget('company_signup');
            return view('frontend.auth.company.success',compact('subscriptionNumber'));
        }
    }

    /* ###########################################
    // Function: companySignup
    // Description: Get company information and store into database
    // Parameter: firstname: String, lastname: String, emial: String, password: string, confirm_password: string
    // ReturnType: view
    */ ###########################################
    public function companySignup(Request $request)
    {
        if (!Auth::check()) {
            $validator = Validator::make(
                $request->all(),
                [
                    'firstname' => 'required',
                    'country' => 'required',
                    'email' => 'required|email|max:255',
                    'password' => 'required',
                    'role_id' => 'required',
                ]
            );
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator);
            }

            $input = $request->all();

            $input['password'] = Hash::make($input['password']);
            $input['user_type'] = "frontend";
            $input['is_verify'] = 0;
            // $input['is_owner'] = 1; 
            $input['step'] = 'first';
            $user = User::create($input);

            // Save Company Details
            $companyData = [
                'name' => $input['firstname'],
                'email' => $input['email'],
                'user_id' => $user->id
            ];
            $company = Companies::createOrUpdate($input['company_id'], $companyData);

            // Save Company User Details
            $companyUserData = [
                'company_id' => $company->id,
                'name' => $company->name,
                'email' => $company->email,
                'user_id' => $user->id,
                'is_owner' => 1,
            ];
            $companyUser = CompanyUser::createOrUpdate($input['company_user_id'], $companyUserData);

            $companySignup = [
                'company_id' => $company->id,
                'company_user_id' => $companyUser->id,
                'email' => $company->email,
                'step' => $user->step
            ];
            Session::put('company_signup', $companySignup);

            //Send a verification email
            $encId =  encrypt($user->id);
            $link = route('emailVerification', ['id' => $encId]);
            try {
                $data = ['FIRST_NAME' => $user->firstname, 'LAST_NAME' => '' , 'LINK' => $link];
                EmailTemplates::sendMail('email-verification', $data, $user->email);
            } catch (\Exception $e) {
                //pre($e->getMessage());
            }

            $notification = array(
                'message' => config('message.AuthMessages.AccountCreate'),
                'alert-type' => 'success'
            );
            return redirect()->route('showSecondCompanySignup')->with($notification);
        }
    }

    /* ###########################################
    // Function: companySecondSignup
    // Description: Get company information and store into database
    // Parameter: address_line_one: String, address_line_two: String, city: String, country: string, w9file: string
    // ReturnType: view
    */ ###########################################
    public function companySecondSignup(Request $request)
    {
        try {
            $input = $request->all();

            $user = User::where('email', $input['company_email'])->firstOrFail();
            $user->step = 'second';
            $user->update();

            if ($request->hasFile('myFile')) {
                if (isset($input['hiddenPreviewImg'])) {
                    $input['company']['logo'] = Companies::uploadIconEncoded($input['hiddenPreviewImg']);
                    unset($input['hiddenPreviewImg']);
                }
            }
            // Save Company Details
            $companyData = $input['company'];
            $company = Companies::createOrUpdate($input['company_id'], $companyData);

            // Save Company User Details
            $companyUserData = $input['company_user'];
            $companyUserData['prefix'] = $companyData['phone_ext'];
            $companyUserData['phone'] = $companyData['phone'];
            $companyUser = CompanyUser::createOrUpdate($input['company_user_id'], $companyUserData);


            // Save Company Address Details
            $companyAddressData = isset($input['company_address']) ? $input['company_address'] : array();
            $companyUser = CompanyAddress::createOrUpdate($input['company_id'], $companyAddressData);


            $notification = array(
                'message' => config('message.AuthMessages.AccountUpdate'),
                'alert-type' => 'success'
            );
            return redirect()->route('showThirdCompanySignup')->with($notification);
            //return redirect()->back()->with($notification);
        } catch (\Exception $e) {
            //pre($e->getMessage());
            return redirect()->route('login');
        }
        //Session::forget(['candidate_signup.candidate_id','candidate_signup.email','candidate_signup.step']);
        //return redirect()->route('login');
    }


    public function companyThirdSignup(Request $request)
    {
        try {
            $email = Session::get('company_signup.email');
            $input = $request->all();

            $user = User::where('email', $email)->firstOrFail();
            $user->step = 'third';
            $user->current_subscription = $input['current_subscription'];
            $user->update();
            
            $notification = array(
                'message' => config('message.AuthMessages.AccountUpdate'),
                'alert-type' => 'success'
            );
            return redirect()->route('showFourthCompanySignup')->with($notification);
            //return redirect()->back()->with($notification);
        } catch (\Exception $e) {
            //pre($e->getMessage());
            return redirect()->route('login');
        }
        //Session::forget(['candidate_signup.candidate_id','candidate_signup.email','candidate_signup.step']);
        //return redirect()->route('login');
    }

    public function companyFourthSignup(Request $request)
    {
        try {
            $input = $request->all();
            $email = Session::get('company_signup.email');

            $user = User::where('email', $email)->firstOrFail();
            if ($user) {
                $userId = $user->id;
                $stripe = new StripeController;
                $customer = $stripe->addCustomer($userId);
                // pre('stopped');
                if ($customer=='true' && !$user->current_subscription_id) {
                    $card = $input;
                    $card['card_no'] = removeWhiteSpaces($card['card_no']);
                    $card['expiry_date'] = explode("/", $card['expiry_date']);
                    $card['expiry_month'] = $card['expiry_date'][0];
                    $card['expiry_year'] = $card['expiry_date'][1];
                    unset($card['_token']);
                    unset($card['expiry_date']);
                    $cardToken = $stripe->addCardToCustomer($card, $userId);
                    if ($cardToken == 'true') {
                        // current_subscription_id
                        $subscription = $stripe->addPlanToCustomer($userId);
                        if ($subscription == 'true') {

                            $user->step = 'fourth';
                            $user->registration_complete = 1;
                            $user->update();
                            
                            $notification = array(
                                'message' => config('message.AuthMessages.subscribeSuccessfully'),
                                'alert-type' => 'success'
                            );

                            Auth::login($user);
                            return redirect()->route('companySignupSuccess')->with($notification);
                        }else{
                            // pre('first');
                            $notification = array(
                                'message' => $subscription,
                                'alert-type' => 'success'
                            );
                            return redirect()->back()->with($notification);
                        }
                    }else{
                        // pre('second');
                        $notification = array(
                            'message' => $cardToken,
                            'alert-type' => 'success'
                        );
                        return redirect()->back()->with($notification);
                    }
                }else{
                    if ($user->current_subscription) {
                        $notification = array(
                            'message' => "You are already subscribed to our service. Please Login to continue.",
                            'alert-type' => 'success'
                        );
                        return redirect()->back()->with($notification);
                    }
                    // pre('third');
                    $notification = array(
                        'message' => $customer,
                        'alert-type' => 'success'
                    );
                    return redirect()->back()->with($notification);
                }
            }else{
                $notification = array(
                    'message' => 'User not found.',
                    'alert-type' => 'success'
                );
                return redirect()->back()->with($notification);
            }
            //return redirect()->back()->with($notification);
        } catch (\Exception $e) {
            //pre($e->getMessage());
            return redirect()->route('login');
        }
        //Session::forget(['candidate_signup.candidate_id','candidate_signup.email','candidate_signup.step']);
        //return redirect()->route('login');
    }

    /* ###########################################
    // Function: companySignupUpdate
    // Description: Update Details when it comes from first signup page
    // Parameter: firstname: String, lastname: String, emial: String, password: string, confirm_password: string
    // ReturnType: view
    */ ###########################################
    public function companySignupUpdate(Request $request)
    {
        try {
            $input = $request->all();
            $companyId = $request->company_id;
            $companyEmail = $request->company_email;
            $user = User::where('email', $companyEmail)->firstOrFail();
            if ($input['password']) {
                $input['password'] = Hash::make($input['password']);
            } else {
                $input['password'] = $user->password;
            }

            $user->update($input);
            // Save Company Details
            $companyData = [
                'name' => $input['firstname'],
                'email' => $input['email'],
                'user_id' => $user->id
            ];
            $company = Companies::createOrUpdate($input['company_id'], $companyData);

            // Save Company User Details
            $companyUserData = [
                'company_id' => $company->id,
                'name' => $company->name,
                'email' => $company->email
            ];
            $companyUser = CompanyUser::createOrUpdate($input['company_user_id'], $companyUserData);


            $companySignup = [
                'company_id' => $company->id,
                'company_user_id' => $companyUser->id,
                'email' => $company->email,
                'step' => $user->step
            ];
            
            Session::put('company_signup', $companySignup);

            $notification = array(
                'message' => config('message.AuthMessages.AccountUpdate'),
                'alert-type' => 'success'
            );
            return redirect()->route('showSecondCompanySignup')->with($notification);
        } catch (\Exception $e) {
            return redirect()->route('home');
        }
    }

    public function companyUniqueEmail(Request $request)
    {
        if ($request->company_id) {
            $company = Companies::findOrFail($request->company_id);
            if ($company->email == $request->email) {
                $email = true;
            } else {
                $company = CompanyUser::where('company_id',$request->company_id)->where('email', $request->email)->first();
                if ($company) {
                    $email = true;
                } else {
                    $email  = User::checkUniqueEmail('frontend', $request->email);
                }                
            }
            $json_data = array(
                "data" => $email,
            );
            return Response::json($json_data);
        } else {
            $email  = User::checkUniqueEmail('frontend', $request->email);
            $json_data = array(
                "data" => $email,
            );
            return Response::json($json_data);
        }
        // $email  = User::checkUniqueEmail('frontend',$request->email);
        // $json_data = array(
        //     "data" => $email,
        // );
        // return Response::json($json_data);
    }

    public function companyAddBranches()
    {
        $countAddresses = $_POST['countAddresses'];
        $countries = Country::getListForDropdown();
        return view('frontend.auth.company.components.company_branches', compact('countries', 'countAddresses'));
    }
}
