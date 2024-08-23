<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminCommission extends Model
{
    use HasFactory;

    protected $table = 'company_job_commission';
    protected $fillable = [
        'id',
        'company_job_id',
        'company_job_application_id',
        'amount',
        'type',
        'recruiter_id',
        'flag_paid',
        'created_at',
        'deleted_at',
    ];

    public static function getCompanyList(){
       $company = self::select('companies.id','companies.name')
                        ->leftJoin("company_jobs", "company_job_commission.company_job_id","company_jobs.id")
                        ->leftJoin("companies","company_jobs.company_id","companies.id")
                        ->where('company_job_commission.type',2)
                        ->whereNull('company_job_commission.deleted_at')->pluck('name','id');

        return $company;
    }

    public static function getPayoutTotal($recruiterId,$paidStatus=0){
        $total = self::where('recruiter_id',$recruiterId);
        $total=$total->where('flag_paid',$paidStatus);
        $total=$total->where('type',1)->sum('amount');
        $total = $total? :"0.00";
        return $total;
    }
    public static function getTotalJobByPayout($recruiterId,$jobId){
        $total = self::where('recruiter_id',$recruiterId);
        $total=$total->where('company_job_id',$jobId);
        $total=$total->where('type',1)->sum('amount');
        $total = $total? :"0.00";
        return $total;
    }


    public static function getCountDashboard($from = "", $to = "")
    {
        $count = 0;
        $data = self::selectRaw('sum(amount) as total')->whereNull('deleted_at')->where('type', 1)->where('flag_paid', 0);
        // if ($from != "" && $to != "") {
        //     $data->whereBetween('created_at', [$from, $to]);
        // } else {
        //     $data->whereDate('created_at', Carbon::today());
        // }
        $data = $data->first();
        if ($data) {
            $count = $data->total ?: 0;
        }
        return $count;
    }

    public static function getCountDashboardGraph($type = "daily", $date)
    {
        $return = 0;
        $data = self::selectRaw('sum(amount) as total')->whereNull('deleted_at')->where('type', 2);
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
