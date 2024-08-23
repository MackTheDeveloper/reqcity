<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecruiterSubscription extends Model
{
    use HasFactory;
    protected $table = 'recruiter_subscription';
    protected $fillable = [
        'plan_id',
        'recruiter_id', // here we store user_id
        'email',
        'plan_type',
        'amount',
        'status',
        'payment_id',
        'stripe_subscription_id',
        'stripe_item_id',
        'trial_start',
        'trial_end',
        'stripe_status'
    ];

    public static function getDaywiseCount($date)
    {
        return self::whereDate('created_at', $date)->count();
    }

    public static function getSubscriptionDetails()
    {
        return self::whereNull('recruiter_subscription.deleted_at')->select(
            'recruiter_subscription.*',
            'recruiters.first_name',
            'recruiters.last_name',
            'recruiters.phone as phone',
            'subscription_plans.subscription_name'
        )
        ->leftJoin("subscription_plans", "recruiter_subscription.plan_id","subscription_plans.id")
        ->leftJoin("recruiters","recruiter_subscription.recruiter_id","recruiters.user_id");
    }

    public static function getSearchData($search = '', $limit = 0, $operation = '')
    {
        $return = self::selectRaw('recruiter_subscription.id,recruiters.name,recruiter_subscription.email,recruiter_subscription.payment_id')->leftjoin('companies', 'companies.id', 'company_subscription.company_id')
            ->where('status', '1')
            ->whereNull('recruiter.deleted_at')
            ->whereNull('recruiter_subscription.deleted_at')
            ->where(function ($query2) use ($search) {
                $query2->where('name', 'like', '%' . $search . '%')
                    ->orWhere('recruiter_subscription.email', 'like', '%' . $search . '%')
                    ->orWhere('recruiter_subscription.payment_id', 'like', '%' . $search . '%');
            });
        if ($limit) {
            $return->limit($limit);
        }
        if ($operation == 'getTotal') {
            $return = $return->count();
        } else {
            $return = $return->get();
        }
        return $return;
    }

    public static function getNewSubscriptionNumber(){
        $thisYear = date('Y');
        $newNumber = 1;
        $lastSubscription =  self::whereYear("created_at",$thisYear)->first();
        if ($lastSubscription) {
            $subscriptionNumber = substr($lastSubscription->subscription_number, 12);
            $newNumber = intval($subscriptionNumber) + 1;
        }
        $newInvoiceNumber = "RQCTRCTR" . $thisYear . sprintf("%04d", $newNumber);
        return $newInvoiceNumber;
    }

    public static function getLastSubscription($userId)
    {
        return self::where("recruiter_id", $userId)->orderBy('id','DESC')->first();
    }

    public static function getSubscriptionById($id)
    {
        $return = self::where('id', $id)->first();
        return $return;
    }
}
