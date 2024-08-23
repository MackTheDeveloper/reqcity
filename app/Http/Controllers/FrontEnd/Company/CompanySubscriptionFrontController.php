<?php

namespace App\Http\Controllers\FrontEnd\Company;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontEnd\StripeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Companies;
use App\Models\CompanyAddress;
use App\Models\CompanyJob;
use App\Models\CompanyJobFunding;
use App\Models\CompanySubscription;
use App\Models\CompanyTransaction;
use App\Models\CompanyUser;
use App\Models\Country;
use App\Models\JobFieldOption;
use App\Models\ScheduledSubscription;
use App\Models\SubscriptionPlan;
use Exception;
use Auth;
use Response;
use Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\URL;

class CompanySubscriptionFrontController extends Controller
{    
    public function index()
    {
        $data = [];
        $upcoming = [];
        $userId = Auth::user()->id;
        $roleId = Auth::user()->role_id;
        $mainUserId = CompanyUser::getCompanyUserMainIdByUserId($userId);
        $subscriptionExpireAt = User::getAttrById($mainUserId, 'subscription_expire_at');
        $hasYearlySubcription = User::getAttrById($mainUserId, 'has_yearly_subscription');
        $currentSubscriptionId = User::getAttrById($mainUserId, 'current_subscription_id');
        $isCancelledSubscription = User::getAttrById($mainUserId, 'is_subscription_cancelled');
        $chooseSubscription = SubscriptionPlan::getSubscriptionNotSubscribed($mainUserId);
        $currentSubscription = CompanySubscription::getSubscriptionById($currentSubscriptionId);
        // pre($currentSubscription);
        // if ($hasYearlySubcription) {
        // }
        $upcoming = ScheduledSubscription::getScheduledSubscriptionByUser($mainUserId);
        // pre($upcoming);
        // pre($currentSubscription);
        return view('frontend.company.payment.subscription', compact('data', 'chooseSubscription', 'currentSubscription', 'hasYearlySubcription', 'subscriptionExpireAt', 'upcoming', 'isCancelledSubscription'));
    }

    public function cancel(){
        $userId = Auth::user()->id;
        $currentSubscriptionId = User::getAttrById($userId, 'current_subscription_id');
        if ($currentSubscriptionId) {
            $currentSubscription = CompanySubscription::getSubscriptionById($currentSubscriptionId);
            if ($currentSubscription) {
                $currentSubscriptionId = $currentSubscription->stripe_subscription_id;
                $stripe = new StripeController;
                $stripe->cancelSubscription($currentSubscriptionId, $userId);
                // 
                $notification = array(
                    'message' => config('message.frontendMessages.subscription.cancel'),
                    'alert-type' => 'success'
                );
                // return redirect()->route('getSubscriptionPlanView')->with($notification);
                return Response::json($notification);
            }
            $notification = array(
                'message' => "Something went wrong.",
                'alert-type' => 'success'
            );
            return Response::json($notification);
        }
        $notification = array(
            'message' => "Something went wrong.",
            'alert-type' => 'success'
        );
        return Response::json($notification);
    }

    public function cancelScheduled()
    {
        $userId = Auth::user()->id;
        $upcoming = ScheduledSubscription::getScheduledSubscriptionByUser($userId);
        if ($upcoming) {
            // cancel upcoming
            $stripe = new StripeController;
            $stripe->cancelScheduledSubscription($upcoming['shed_sub_id']);
            // cancelScheduledSubscription($subscriptionId)
            $notification = array(
                'message' => config('message.frontendMessages.subscription.cancel-scheduled'),
                'alert-type' => 'success'
            );
            // return redirect()->route('getSubscriptionPlanView')->with($notification);
            return Response::json($notification);
        }
        $notification = array(
            'message' => "Something went wrong.",
            'alert-type' => 'success'
        );
        return Response::json($notification);
    }

    public function upgrade(){
        $userId = Auth::user()->id;
        $roleId = Auth::user()->role_id;
        $currentSubscriptionId = User::getAttrById($userId, 'current_subscription_id');
        $yearlySubscription = SubscriptionPlan::getSubscriptionNotSubscribed($userId);
        $planId = $yearlySubscription['stripe_price_id'];
        if ($currentSubscriptionId) {
            $currentSubscription = CompanySubscription::getSubscriptionById($currentSubscriptionId);
            if ($currentSubscription) {
                $currentSubscriptionId = $currentSubscription->stripe_subscription_id;
                $stripe = new StripeController;
                $stripe->updateSubscription($currentSubscriptionId, $userId, $planId);
                // 
                $notification = array(
                    'message' => config('message.frontendMessages.subscription.upgrade'),
                    'alert-type' => 'success'
                );
                return Response::json($notification);
                // return redirect()->route('getSubscriptionPlanView')->with($notification);
            }
            // return abort(404);
            $notification = array(
                'message' => "Something went wrong.",
                'alert-type' => 'success'
            );
            return Response::json($notification);
        }
        // return abort(404);
        $notification = array(
            'message' => "Something went wrong.",
            'alert-type' => 'success'
        );
        return Response::json($notification);
    }
}
