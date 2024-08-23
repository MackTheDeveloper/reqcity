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
use Response;
use Agent;
use Illuminate\Support\Facades\Session;
use App\Traits\ReuseFunctionTrait;
use App\Models\Candidate;
use App\Models\Country;
use App\Models\EmailTemplates;
use Redirect;

class CandidateAuthController extends Controller
{
    use ReuseFunctionTrait;

    /* ###########################################
    // Function: showCandidateSignup
    // Description: Display candidate registration page
    // Parameter: No Parameter
    // ReturnType: view
    */ ###########################################
    public function showCandidateSignup()
    {
        if (!Auth::check()) {
            $countries = Country::getListForDropdown();
            $model = new User;
            $email = Session::get('candidate_signup.email');
            $candidateId = Session::get('candidate_signup.candidate_id');
            if (isset($email)) {
                $model = User::where('email', $email)->first();
            }
            return view('frontend.auth.candidate.signup', compact('countries', 'model', 'candidateId', 'email'));
        } else {
            return redirect()->route('home');
        }
    }

    /* ###########################################
    // Function: showCandidateSecondSignup
    // Description: Display candidate registration page
    // Parameter: No Parameter
    // ReturnType: view
    */ ###########################################
    public function showCandidateSecondSignup()
    {
        $email = Session::get('candidate_signup.email');
        $candidateId = Session::get('candidate_signup.candidate_id');
        if (!isset($candidateId)) {
            return redirect()->route('login');
        } else {
            $countries = Country::getListForDropdown();
            $candidate = Candidate::find($candidateId);
            return view('frontend.auth.candidate.signupTwo', compact('countries', 'candidate', 'candidateId', 'email'));
        }
    }

    /* ###########################################
    // Function: candidateSignup
    // Description: Get customer information and store into database
    // Parameter: firstname: String, lastname: String, emial: String, password: string, confirm_password: string
    // ReturnType: view
    */ ###########################################

    public function candidateSignup(Request $request)
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
            $uniqueId = User::getNextUniqueId('5');
            $input['unique_id'] = $uniqueId;
            $user = User::create($input);
            $input['user_id'] = $user->id;
            $input['first_name'] =  $input['firstname'];
            $input['last_name'] =  $input['lastname'];
            $input['status'] =  1;
            $candidate = Candidate::create($input);
            $candidateSignup = [
                'candidate_id' => $candidate->id,
                'email' => $candidate->email,
                'step' => $user->step
            ];
            Session::put('candidate_signup', $candidateSignup);

            //Send a verification email
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
            return redirect()->route('showSecondCandidateSignup')->with($notification);
        }
    }

    /* ###########################################
    // Function: candidateSecondSignup
    // Description: Get customer information and store into database
    // Parameter: address_line_one: String, address_line_two: String, city: String, country: string, w9file: string
    // ReturnType: view
    */ ###########################################
    public function candidateSecondSignup(Request $request)
    {
        try {
            $candidateId = $request->candidate_id;
            $candidateEmail = $request->candidate_email;
            $model = Candidate::findOrFail($candidateId);
            $input = $request->all();
            $input['phone_ext'] = $request->phoneField1_phoneCode;
            if ($request->hasFile('resume')) {
                $fileObject = $request->file('resume');
                $file = Candidate::uploadResume($candidateId, $fileObject);
            }
            $user = User::where('email', $candidateEmail)->firstOrFail();
            $user->step = 'second';
            $user->registration_complete = 1;
            $user->update();
            $input['password'] = $user->password;
            $input['user_id'] = $user->id;
            $model->update($input);

            Session::forget(['candidate_signup.candidate_id', 'candidate_signup.email', 'candidate_signup.step']);
            $notification = array(
                'message' => config('message.AuthMessages.AccountCreate'),
                'alert-type' => 'success'
            );
            return redirect()->route('login')->with($notification);
        } catch (\Exception $e) {
            return redirect()->route('login');
        }
    }

    /* ###########################################
    // Function: candidateSignupUpdate
    // Description: Update Details when it comes from first signup page
    // Parameter: firstname: String, lastname: String, emial: String, password: string, confirm_password: string
    // ReturnType: view
    */ ###########################################
    public function candidateSignupUpdate(Request $request)
    {
        try {
            $candidateId = $request->candidate_id;
            $candidateEmail = $request->candidate_email;
            $model = Candidate::findOrFail($candidateId);
            $input = $request->all();
            $user = User::where('email', $candidateEmail)->firstOrFail();
            if ($input['password']) {
                $input['password'] = Hash::make($input['password']);
            } else {
                $input['password'] = $user->password;
            }
            $input['user_id'] = $user->id;
            $input['first_name'] =  $input['firstname'];
            $input['last_name'] =  $input['lastname'];
            $model->update($input);
            $user->update($input);
            $candidateSignup = [
                'candidate_id' => $model->id,
                'email' => $model->email,
                'step' => $user->step
            ];
            Session::put('candidate_signup', $candidateSignup);
            $notification = array(
                'message' => config('message.AuthMessages.AccountUpdate'),
                'alert-type' => 'success'
            );
            return redirect()->route('candidateSignupSecond')->with($notification);
        } catch (\Exception $e) {
            return redirect()->route('home');
        }
    }

    public function candidateUniqueEmail(Request $request)
    {
        if ($request->can_id) {
            $candidate = Candidate::findOrFail($request->can_id);
            if ($candidate->email == $request->email) {
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
        // $email  = User::checkUniqueEmail('frontend',$request->email);
        // $json_data = array(
        //     "data" => $email,
        // );
        // return Response::json($json_data);
    }
}
