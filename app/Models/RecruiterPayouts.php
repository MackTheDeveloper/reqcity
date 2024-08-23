<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecruiterPayouts extends Model
{
    use HasFactory;
    protected $table = 'recruiter_payouts';
    protected $fillable = [
        'id',
        'recruiter_id',
        'amount',
        'application_ids',
        'payment_id',
        'bank_name',
        'currency_code',
        'account_number',
        'bank_address',
        'swift_code',
        'bank_city',
        'bank_country',
    ];

    public static function getTotalPayout($recruiterId)
    {
        return self::where('recruiter_id',$recruiterId)->whereNull('deleted_at')->sum('amount');
    }

    public static function getCountDashboard($from = "", $to = "")
    {
        $count = 0;
        $data = self::selectRaw('sum(amount) as total')->whereNull('deleted_at');
        if ($from != "" && $to != "") {
            $data->whereBetween('created_at', [$from, $to]);
        } else {
            $data->whereDate('created_at', Carbon::today());
        }
        $data = $data->first();
        if ($data) {
            $count = $data->total ?: 0;
        }
        return $count;
    }

    public static function getCountDashboardGraph($type = "daily", $date)
    {
        $return = 0;
        $data = self::selectRaw('sum(amount) as total')->whereNull('deleted_at');
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
