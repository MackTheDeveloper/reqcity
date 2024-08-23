<?php

namespace App\Http\Controllers\FrontEnd\Recruiter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Companies;
use App\Models\CompanyAddress;
use App\Models\CompanyTransaction;
use App\Models\CompanyUser;
use App\Models\Country;
use App\Models\JobFieldOption;
use App\Models\NotificationSetting;
use App\Models\Recruiter;
use App\Models\RecruiterBankDetail;
use App\Models\RecruiterTaxForms;
use App\Models\UserNotificationSetting;
use Exception;
use Auth;
use Response;
use Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\URL;

class RecruiterFrontController extends Controller
{

    public function showMyInfo(Request $request)
    {
        $userId = Auth::user()->id;
        if ($userId) {
            try {
                $data = Recruiter::with('RecruiterBankDetail', 'User','Country')
                    ->where('user_id', $userId)->first();
                $countries = Country::getListForDropdown();
                $w9Form = RecruiterTaxForms::where('recruiter_id',$data->id)->orderBy('id','DESC')->first();
                $w9FormLink = ""; 
                if($w9Form){
                    $w9FormLink = RecruiterTaxForms::getFormFile($w9Form->id);
                }
                return view('frontend.recruiter.my-info.myinfo', compact('data','countries','w9FormLink'));
            }catch (Exception $e) {
                return redirect()->route('showMyInfoRecruiter');
            }
        }
    }

    public function updateMyInfo(Request $request)
    {
        try{
            $userId = Auth::user()->id;
            $user = "";
            $recruiter = "";
            $recruiterBank = "";
            $recruiterData = Recruiter::where('user_id',$userId)->first(); 
            $recruiterId = $recruiterData->id;
            if($request['User'])
            {
                $user = User::createOrUpdate($userId,$request['User']);
                $recruiterArr=array('first_name'=>$request['User']['firstname'],
                                    'last_name'=>$request['User']['lastname'],
                                    'email'=>$request['User']['email'],
                                    );

                $recruiter = Recruiter::createOrUpdate($recruiterId,$recruiterArr);
            }
            if($request['Recruiter'])
            {    
                $recruiter = Recruiter::createOrUpdate($recruiterId,$request['Recruiter']);
            }
            if($request['RecruiterBank'])
            {
                $bankDetails = $request['RecruiterBank'];
                $bankDetails['recruiter_id'] = $recruiterId;
                $recruiterBankData = RecruiterBankDetail::where('recruiter_id',$recruiterId)->first(); 
                $recruiter = RecruiterBankDetail::createOrUpdate($recruiterBankData ? $recruiterBankData->id : '',$bankDetails);
            }
            if ($request->hasFile('w9File')) {
                $fileObject = $request->file('w9File');
                $file = Recruiter::uploadTaxForm($recruiterId, $fileObject);
            }
            return redirect()->route('showMyInfoRecruiter');
        }catch(Exception $e){
            //pre($e->getMessage());
            return redirect()->route('showMyInfoRecruiter');
        }
    }


    public function showPasswordSecurity(Request $request)
    {
        return view('frontend.recruiter.password-security.password-security');
    }

    public function showPasswordSecurityForm(Request $request)
    {
        return view('frontend.recruiter.password-security.form');
    }

    public function changePassword(Request $request)
    {
        $authId = Auth::user()->id;
        $returnData = User::changePassword($request, $authId);
        if ($returnData) {
            $notification = array(
                'message' => 'Your password has been changed successfully.',
                'alert-type' => 'success'
            );
            $user = User::find($authId);
            Auth::login($user);
            return redirect()->route('showPasswordSecurityRecruiter')->with($notification);
        } else {
            $notification = array(
                'message' => 'Please enter correct old password',
                'alert-type' => 'error'
            );
            return redirect()->route('showPasswordSecurityFormRecruiter')->with($notification);
        }
    }

    public function notificationSetting(Request $request)
    {
        try{
            $email = Auth::user()->email;
            $email = get_starred($email,'email');
            $userId = Auth::user()->id;
            $notifications = NotificationSetting::getNotificationLabels('4');
            $userNotification = UserNotificationSetting::getUserNotification($userId);
            return view('frontend.recruiter.notification-setting.index',compact('email','notifications','userNotification'));
        }catch(Exception $e){
            return redirect()->route('showMyInfoRecruiter');
        }
    }

    public function updateNotificationSetting(Request $request)
    {
        $notificationId = $request->notificationId;
        $userId = Auth::user()->id;
        $userNotification = UserNotificationSetting::where('user_id',$userId)
                                ->where('notification_ids',$notificationId)->first();
        if($userNotification){
            $userNotification->delete();
            return 'success';
        }else{
            $userNotification = new UserNotificationSetting();
            $userNotification->notification_ids = $notificationId;
            $userNotification->user_id = $userId;
            $userNotification->type = 4;
            $userNotification->save();
            return 'success';
        }
    }

}
