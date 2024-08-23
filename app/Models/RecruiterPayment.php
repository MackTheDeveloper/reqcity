<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RecruiterBankDetail;
use DB;

class RecruiterPayment extends Model
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
                        ->where('company_job_commission.flag_paid',0)
                        ->where('company_job_commission.type',1)
                        ->whereNull('company_job_commission.deleted_at')->pluck('name','id');

        return $company;
    }


    public static function getRecruiterList(){
        $recruiter = self::select(DB::raw("CONCAT(first_name,' ',last_name) AS name"),'recruiters.id')
                         ->leftJoin("recruiters","company_job_commission.recruiter_id","recruiters.id")
                         ->where('company_job_commission.flag_paid',0)
                         ->where('company_job_commission.type',1)
                         ->whereNull('company_job_commission.deleted_at')->pluck('name','id');
 
         return $recruiter;
     }

    public static function getRecruiterBankDetail($id){
        $details = RecruiterBankDetail::where('recruiter_id',$id)->first();
        return $details;
    }

    public static function getJobApplicationId($id){
        $JobIds = RecruiterPayment::whereIn('id',$id)->pluck('company_job_application_id')->toArray();
        return $JobIds;
    }

    //change payment flag to paid
    public static function changePaymentFlag($id){
        $flag = RecruiterPayment::whereIn('id',$id)->update(['flag_paid'=>1]);
        return $flag;
    }

    public static function getJobCommission($companyJobId,$recruiterId){
        $return = 0;
        $data = self::selectRaw('sum(amount) as total')->where('company_job_id', $companyJobId)->where('recruiter_id', $recruiterId)->first()->toArray();
        if ($data) {
            $return = $data['total'];
        }
        return $return;
    }


}


