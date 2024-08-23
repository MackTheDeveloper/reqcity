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
use App\Models\Recruiter;
use App\Models\Country;
use App\Models\JobField;
use App\Models\JobFieldOption;
use App\Models\EmailTemplates;
use Redirect;
use App\Models\PlanFeatures;
use App\Models\RecruiterSubscription;
use App\Models\RecruiterTaxForms;
use App\Models\SubscriptionPlan;

class RecruiterAuthController extends Controller
{
    use ReuseFunctionTrait;



    /* ###########################################
    // Function: showRecruiterSignup
    // Description: Display candidate registration page
    // Parameter: No Parameter
    // ReturnType: view
    */ ###########################################
    public function showRecruiterSignup()
    {
        if (!Auth::check()) {
            $countries = Country::getListForDropdown();
            $model = new User;
            $email = Session::get('recruiter_signup.email');
            $recruiterId = Session::get('recruiter_signup.recruiter_id');
            if (isset($email)) {
                $model = User::where('email', $email)->first();
            }
            return view('frontend.auth.recruiter.signup', compact('countries', 'model', 'recruiterId', 'email'));
        }else{
            return redirect()->route('home');
        }
    }

    /* ###########################################
    // Function: showRecruiterSecondSignup
    // Description: Display candidate registration page
    // Parameter: No Parameter
    // ReturnType: view
    */ ###########################################
    public function showRecruiterSecondSignup()
    {
        //get options by code
        $areaOfExpertise = JobFieldOption::getOptions('AREAE');
        $email = Session::get('recruiter_signup.email');
        $recruiterId = Session::get('recruiter_signup.recruiter_id');
        if (!isset($recruiterId)) {
            return redirect()->route('login');
        } else {

            $w9Form = RecruiterTaxForms::where('recruiter_id',$recruiterId)->first();
            $w9FormLink = ""; 
            if($w9Form){
               $w9FormLink = RecruiterTaxForms::getFormFile($w9Form->id);
            }
            $countries = Country::getListForDropdown();
            $recruiter = Recruiter::find($recruiterId);
            $selectedExpertise = (isset($recruiter->expertise)) ? explode(',', $recruiter->expertise) : "";
            return view('frontend.auth.recruiter.signupTwo', compact('countries', 'areaOfExpertise', 'email', 'recruiterId', 'recruiter', 'selectedExpertise','w9FormLink'));
        }
    }

    /* ###########################################
    // Function: showRecruiterThirdSignup
    // Description: Display recruiter registration page
    // Parameter: No Parameter
    // ReturnType: view
    */ ###########################################
    public function showRecruiterThirdSignup()
    {
        $email = Session::get('recruiter_signup.email');
        $recruiterId = Session::get('recruiter_signup.recruiter_id');
        if (!isset($recruiterId)) {
            return redirect()->route('login');
        } else {
            $model = User::where('email', $email)->first();
            $subscriptionPlanYearly = SubscriptionPlan::getPlan('recruiter', 'yearly');
            $subscriptionPlanMonthly = SubscriptionPlan::getPlan('recruiter', 'monthly');
            $subscriptionPlanFeatures = PlanFeatures::getList('Recruiter');
            $getCurrentSubscription = SubscriptionPlan::getDetails($model->current_subscription);
            return view('frontend.auth.recruiter.signupThree', compact('subscriptionPlanYearly', 'subscriptionPlanMonthly', 'subscriptionPlanFeatures','recruiterId', 'email', 'model', 'getCurrentSubscription'));
        }
    }

    /* ###########################################
    // Function: showRecruiterFourthSignup
    // Description: Display recruiter registration page
    // Parameter: No Parameter
    // ReturnType: view
    */ ###########################################
    public function showRecruiterFourthSignup()
    {
        $email = Session::get('recruiter_signup.email');
        $recruiterId = Session::get('recruiter_signup.recruiter_id');
        if (!isset($recruiterId)) {
            return redirect()->route('login');
        } else {
            $model = User::where('email', $email)->first();
            $getCurrentSubscription = SubscriptionPlan::getDetails($model->current_subscription);
            $untilDate = SubscriptionPlan::getUntildate($getCurrentSubscription->plan_type,$getCurrentSubscription->trial_period);
            $trialDates = SubscriptionPlan::getTrialEnddate($getCurrentSubscription->trial_period);
            return view('frontend.auth.recruiter.signupFour', compact('recruiterId', 'email', 'model', 'getCurrentSubscription','untilDate','trialDates'));
        }
    }

    /* ###########################################
    // Function: showRecruiterSuccessSubscribe
    // Description: Display recruiter registration page
    // Parameter: No Parameter
    // ReturnType: view
    */ ###########################################
    public function showRecruiterSuccessSubscribe()
    {
        $email = Session::get('recruiter_signup.email');
        $recruiterId = Session::get('recruiter_signup.recruiter_id');
        if (!isset($recruiterId)) {
            return redirect()->route('login');
        } else {
            $model = User::where('email', $email)->first();
            // $model->registration_complete = 1;
            // $model->save();
            $subscription = RecruiterSubscription::getLastSubscription($model->id);
            // pre($subscription);
            $subscriptionNumber = $subscription->subscription_number;
            Session::forget('recruiter_signup');
            return view('frontend.auth.recruiter.success',compact('subscriptionNumber'));
        }
    }


    /* ###########################################
    // Function: recruiterSignup
    // Description: Get customer information and store into database
    // Parameter: firstname: String, lastname: String, emial: String, password: string, confirm_password: string
    // ReturnType: view
    */ ###########################################

    public function recruiterSignup(Request $request)
    {
        if (!Auth::check()) {
            $validator = Validator::make(
                $request->all(),
                [
                    'firstname' => 'required',
                    'lastname' => 'required',
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
            $input['is_active'] = 1;
            $input['step'] = 'first';
            $ip = $_SERVER['SERVER_ADDR'] ?: '';
            $input['ip_address'] = $ip;
            $uniqueId = User::getNextUniqueId('4');
            $input['unique_id'] = $uniqueId;
            $user = User::create($input);
            $input['first_name'] =  $input['firstname'];
            $input['last_name'] =  $input['lastname'];
            $input['user_id'] = $user->id;
            $recruiter = Recruiter::create($input);
            $recruiterSignup = [
                'recruiter_id' => $recruiter->id,
                'email' => $recruiter->email,
                'step' => $user->step
            ];
            Session::put('recruiter_signup', $recruiterSignup);
            
            //Send a verefication email 
            $encId =  encrypt($user->id);
            $link = route('emailVerification', ['id' => $encId]);
            try {
                $data = ['FIRST_NAME' => $user->firstname, 'LAST_NAME' => $user->lastname, 'LINK' => $link,];
                EmailTemplates::sendMail('email-verification', $data, $user->email);
            } catch (\Exception $e) {
                //pre($e->getMessage());
            }
            
            $notification = array(
                'message' => config('message.AuthMessages.AccountCreate'),
                'alert-type' => 'success'
            );
            return redirect()->route('showSecondRecruiterSignup')->with($notification);
        }
    }

    /* ###########################################
    // Function: recruiterSecondSignup
    // Description: Get customer information and store into database
    // Parameter: address_line_one: String, address_line_two: String, city: String, country: string, w9file: string
    // ReturnType: view
    */ ###########################################
    public function recruiterSecondSignup(Request $request)
    {
        try {
            $recruiterId = $request->recruiter_id;
            $recruiterEmail = $request->recruiter_email;
            $model = Recruiter::findOrFail($recruiterId);
            $input = $request->all();
            if ($request->expertise) {
                $input['expertise'] = implode(",", $request->expertise);
            }
            $input['phone_ext'] = $request->phoneCode_phoneCode;
            if ($request->hasFile('w9File')) {
                $fileObject = $request->file('w9File');
                $file = Recruiter::uploadTaxForm($recruiterId, $fileObject);
            }
            if($request->w9_file == "0"){
                $oldForm = Recruiter::deleteTaxForm($recruiterId); 
            }
            $user = User::where('email', $recruiterEmail)->firstOrFail();
            $user->step = 'second';
            $input['password'] = $user->password;
            $input['user_id'] = $user->id;
            $model->update($input);
            $user->update();

            $notification = array(
                'message' => config('message.AuthMessages.AccountUpdate'),
                'alert-type' => 'success'
            );
            return redirect()->route('showThirdRecruiterSignup')->with($notification);
        } catch (\Exception $e) {
            return redirect()->route('login');
        }
    }

    public function recruiterThirdSignup(Request $request)
    {
        try {
            $email = Session::get('recruiter_signup.email');
            $input = $request->all();

            $user = User::where('email', $email)->firstOrFail();
            $user->step = 'third';
            $user->current_subscription = $input['current_subscription'];
            $user->update();
            
            $notification = array(
                'message' => config('message.AuthMessages.AccountUpdate'),
                'alert-type' => 'success'
            );
            return redirect()->route('showFourthRecruiterSignup')->with($notification);
            //return redirect()->back()->with($notification);
        } catch (\Exception $e) {
            //pre($e->getMessage());
            return redirect()->route('login');
        }
        //Session::forget(['candidate_signup.candidate_id','candidate_signup.email','candidate_signup.step']);
        //return redirect()->route('login');
    }

    public function recruiterFourthSignup(Request $request)
    {
        try {
            $input = $request->all();
            $email = Session::get('recruiter_signup.email');

            $user = User::where('email', $email)->firstOrFail();
            if ($user && !empty($input)) {
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
                            return redirect()->route('recruiterSignupSuccess')->with($notification);
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
            pre($e->getMessage());
            return redirect()->route('login');
        }
        //Session::forget(['candidate_signup.candidate_id','candidate_signup.email','candidate_signup.step']);
        //return redirect()->route('login');
    }
    

    /* ###########################################
    // Function: recruiterSignupUpdate
    // Description: Update Details when it comes from first signup page
    // Parameter: firstname: String, lastname: String, emial: String, password: string, confirm_password: string
    // ReturnType: view
    */ ###########################################
    public function recruiterSignupUpdate(Request $request)
    {
        try {
            $recruiterId = $request->recruiter_id;
            $recruiterEmail = $request->recruiter_email;
            $model = Recruiter::findOrFail($recruiterId);
            $input = $request->all();
            $user = User::where('email', $recruiterEmail)->firstOrFail();
            if ($input['password']) {
                $input['password'] = Hash::make($input['password']);
            } else {
                $input['password'] = $user->password;
            }
            $input['first_name'] =  $input['firstname'];
            $input['last_name'] =  $input['lastname'];
            $input['user_id'] = $user->id;
            $model->update($input);
            $user->update($input);

            $recruiterSignup = [
                'recruiter_id' => $model->id,
                'email' => $model->email,
                'step' => $user->step
            ];
            Session::put('recruiter_signup', $recruiterSignup);
            
            $notification = array(
                'message' => config('message.AuthMessages.AccountUpdate'),
                'alert-type' => 'success'
            );
            return redirect()->route('recruiterSignupSecond')->with($notification);
        } catch (\Exception $e) {
            return redirect()->route('home');
        }
    }




    public function recruiterUniqueEmail(Request $request)
    {
        if ($request->rec_id) {
            $recruiter = Recruiter::findOrFail($request->rec_id);
            $email = "";
            if ($recruiter->email == $request->email) {
                $email = true;
            } else {
                $email  = User::checkUniqueEmail('frontend', $request->email);
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
    }
}
