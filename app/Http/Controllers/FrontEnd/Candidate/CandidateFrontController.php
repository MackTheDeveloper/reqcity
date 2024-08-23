<?php

namespace App\Http\Controllers\FrontEnd\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\CandidateResume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Country;
use App\Models\NotificationSetting;
use App\Models\UserNotificationSetting;
use App\Models\CandidateFavouriteJobs;
use Exception;
use Auth;
use Response;
use Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\URL;

class CandidateFrontController extends Controller
{

    public function showMyInfo(Request $request)
    {
        $userId = Auth::user()->id;
        if ($userId) {
            try {
                $candidate = Candidate::with('User', 'Country')
                    ->where('user_id', $userId)->first();
                $countries = Country::getListForDropdown();
                $resume = CandidateResume::getLatestResumeNew($candidate->id);
                $resume = (isset($resume->resume))?$resume->resume:Null;
                $resumeLink = "";
                if ($resume) {
                    $resumeLink = $resume;
                }
                $image = $candidate->profile_pic;
                return view('frontend.candidate.my-info.myinfo', compact('candidate', 'countries', 'resumeLink','image'));
            } catch (Exception $e) {
                return redirect()->route('showCandidateDashboard');
            }
        }
    }

    public function updateMyInfo(Request $request)
    {
        try {
            $userId = Auth::user()->id;
            $input = $request->all();
            $candidateImage = "";
            if ($request->phone_ext_phoneCode) {
                $input['phone_ext'] = $request->phone_ext_phoneCode;
            }
            $candidate = Candidate::where('user_id', $userId)->first();
            $candidateId =  $candidate->id;
            if ($request->hasFile('myFile')) {
                if (isset($request->hiddenPreviewImg)) {
                    $candidateImage = Candidate::uploadCandidateImage($request->hiddenPreviewImg);
                    unset($request->hiddenPreviewImg);
                }
            }
            if ($request['User']) {
                $user = User::createOrUpdate($userId, $request['User']);
                $input['first_name'] = $input['User']['firstname'];
                $input['last_name'] = $input['User']['lastname'];
                $input['email'] = $input['User']['email'];
            }
            if (isset($candidateImage) && $candidateImage != "") {
                $candidate->profile_pic = $candidateImage;
            }
            $candidate->update($input);
            if ($request->hasFile('resume')) {
                $fileObject = $request->file('resume');
                $file = Candidate::uploadResume($candidateId, $fileObject);
            }
            return redirect()->route('showMyInfoCandidate');
        } catch (Exception $e) {
            return redirect()->route('showMyInfoCandidate');
        }
    }


    public function showPasswordSecurity(Request $request)
    {
        return view('frontend.candidate.password-security.password-security');
    }

    public function showPasswordSecurityForm(Request $request)
    {
        return view('frontend.candidate.password-security.form');
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
            return redirect()->route('showPasswordSecurityCandidate')->with($notification);
        } else {
            $notification = array(
                'message' => 'Please enter correct old password',
                'alert-type' => 'error'
            );
            return redirect()->route('showPasswordSecurityFormCandidate')->with($notification);
        }
    }

    public function notificationSetting(Request $request)
    {
        try {
            $email = Auth::user()->email;
            $email = get_starred($email, 'email');
            $userId = Auth::user()->id;
            $notifications = NotificationSetting::getNotificationLabels('5');
            $userNotification = UserNotificationSetting::getUserNotification($userId);
            return view('frontend.candidate.notification-setting.index', compact('email', 'notifications', 'userNotification'));
        } catch (Exception $e) {
            return redirect()->route('showMyInfoCompany');
        }
    }

    public function updateNotificationSetting(Request $request)
    {
        $notificationId = $request->notificationId;
        $userId = Auth::user()->id;
        $userNotification = UserNotificationSetting::where('user_id', $userId)
            ->where('notification_ids', $notificationId)->first();
        if ($userNotification) {
            $userNotification->delete();
            return 'success';
        } else {
            $userNotification = new UserNotificationSetting();
            $userNotification->notification_ids = $notificationId;
            $userNotification->user_id = $userId;
            $userNotification->type = 5;
            $userNotification->save();
            return 'success';
        }
    }    
}
