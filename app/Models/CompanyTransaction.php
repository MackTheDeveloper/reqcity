<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SubscriptionPlan;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyTransaction extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'company_transactions';
    protected $fillable = [
        'id',
        'company_id',
        'name',
        'email',
        'phone',
        'subscription_plan_id',
        'amount',
        'status',
        'payment_id',
        'invoice_id',
        'invoice_date',
        'amount_due',
        'amount_paid',
        'billing_reason',
        'currency',
        'charge_id',
        'payment_status',
        'subscription_id',
        'invoice_pdf_url',

    ];

    public function SubscriptionPlan()
    {
        return $this->hasOne(SubscriptionPlan::class, 'id', 'subscription_plan_id');
    }

    public function Subscription()
    {
        return $this->hasOne(CompanySubscription::class, 'stripe_subscription_id', 'subscription_id');
    }

    public static function getCountDashboardGraph($type = "daily", $date)
    {
        $return = 0;
        $data = self::selectRaw('sum(amount) as total')->whereNull('deleted_at')->where('payment_status', 'paid');
        if ($type == "daily") {
            $data->whereDate('created_at', $date);
        } elseif ($type == "monthly") {
            $month = date('m', strtotime($date));
            $year = date('Y', strtotime($date));
            $data->whereMonth('created_at', $month);
            $data->whereYear('created_at', $year);
        } elseif ($type == "yearly") {
            $year = date('Y', strtotime($date));
            $data->whereYear('created_at', $year);
        }
        $data = $data->first();
        if ($data) {
            $return = floatval($data->total) ?: 0;
        }
        return $return;
    }

}
