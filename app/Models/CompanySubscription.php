<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanySubscription extends Model
{
    use HasFactory;
    protected $table = 'company_subscription';
    protected $fillable = [
        'plan_id',
        'company_id', // here we store user_id
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
        return self::whereNull('company_subscription.deleted_at')->select(
            'company_subscription.*',
            'companies.name',
            'companies.phone as phone',
            'payment_id'
        )
            ->leftJoin("subscription_plans", "company_subscription.plan_id","subscription_plans.id")
            ->leftJoin("companies","company_subscription.company_id","companies.user_id")
            ->whereNull('company_subscription.deleted_at');
    }

    public static function getSearchData($search = '', $limit = 0, $operation = '')
    {
        $return = self::selectRaw('company_subscription.id,name,companies.email,company_subscription.payment_id')->leftjoin('companies', 'companies.id', 'company_subscription.company_id')
            ->where('status', '1')
            ->whereNull('companies.deleted_at')
            ->whereNull('company_subscription.deleted_at')
            ->where(function ($query2) use ($search) {
                $query2->where('name', 'like', '%' . $search . '%')
                    ->orWhere('company_subscription.email', 'like', '%' . $search . '%')
                    ->orWhere('company_subscription.payment_id', 'like', '%' . $search . '%');
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

    public static function getNewSubscriptionNumber()
    {
        $thisYear = date('Y');
        $newNumber = 1;
        $lastSubscription =  self::whereYear("created_at", $thisYear)->first();
        if ($lastSubscription) {
            $subscriptionNumber = substr($lastSubscription->subscription_number, 12);
            $newNumber = intval($subscriptionNumber) + 1;
        }
        $newInvoiceNumber = "RQCTCMPN" . $thisYear . sprintf("%04d", $newNumber);
        return $newInvoiceNumber;
    }

    public static function getLastSubscription($userId)
    {
        return self::where("company_id", $userId)->orderBy('id','DESC')->first();
    }

    public static function getSubscriptionById($id)
    {
        $return = self::where('id', $id)->first();
        return $return;
    }


    public function company()
    {
        return $this->hasOne(Companies::class, 'id', 'company_id');
    }
}
