<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyJobFunding extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'company_job_funding';
    protected $fillable = [
        'id',
        'company_id',
        'company_job_id',
        'amount',
        'payment_id',
        'status',
        'receipt_url',
        'deleted',
        'deleted_at',
        'created_at',
    ];

    public function companyJob()
    {
        return $this->hasOne(CompanyJob::class, 'id', 'company_job_id');
    }

    public static function addData($data)
    {
        $return = 0;
        $success = true;
        $authId = User::getLoggedInId();
        $data['company_id'] = CompanyUser::getCompanyIdByUserId($authId);
        // $data['dob'] = date('Y-m-d',strtotime($data['dob']));
        // pre($data);
        // $data['created_by'] = $authId;
        $allowed = ['company_id', 'company_job_id', 'amount', 'payment_id', 'status', 'receipt_url'];
        $data = array_intersect_key($data, array_flip($allowed));
        $newEntry = new CompanyJobFunding();
        try {
            foreach ($data as $key => $value) {
                $newEntry->$key = $value;
            }
            $newEntry->save();
            $return = $newEntry->id;
        } catch (\Exception $e) {
            $return = $e->getMessage();
            $success = false;
        }
        return ['data' => $return, 'success' => $success];
    }

    public static function getCountDashboard($from = "", $to = "")
    {
        $count = 0;
        $data = self::selectRaw('sum(amount) as total')->whereNull('deleted_at')->where('status', 1);
        if ($from != "" && $to != "") {
            $data->whereBetween('created_at', [$from, $to]);
        } else {
            $data->whereDate('created_at', Carbon::today());
        }
        $data = $data->first();
        if ($data) {
            $count = $data->total?:0;
        }
        return $count;
    }

    public static function getCountDashboardGraph($type = "daily", $date)
    {
        $return = 0;
        $data = self::selectRaw('sum(amount) as total')->whereNull('deleted_at')->where('status', 1);
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
            $return = floatval($data->total)?:0;
        }
        return $return;
    }
}
