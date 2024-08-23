<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class CompanyJobApplications extends Model
{
    use HasFactory;
    protected $table = 'company_job_applications';
    protected $fillable = [
        'id',
        'company_id',
        'company_job_id',
        'applied_type',
        'related_id',
        'candidate_id',
        'cv',
        'status',
        'rejection_reason',
        'deleted',
        'created_at',
        'updated_at',
        'deleted_at',
        'approved_at',
        'rejected_at',
    ];

    public static function getTotalJobOpening($id)
    {
        return self::where('company_job_id', $id)->where('status', 1)->whereNull('deleted_at')->count();
    }
    public static function getTotalJobRejected($id)
    {
        return self::where('company_job_id', $id)->where('status', 4)->whereNull('deleted_at')->count();
    }
    public static function getTotalJobApproved($id)
    {
        return self::where('company_job_id', $id)->where('status', 3)->whereNull('deleted_at')->count();
    }
    public static function getTotalJobPending($id)
    {
        return self::where('company_job_id', $id)->where('status', 1)->whereNull('deleted_at')->count();
    }
    public static function getTotalJobMyApproved($id, $recuriterId)
    {
        return self::where('company_job_id', $id)->where('status', 3)->where('applied_type', 1)->where('related_id', $recuriterId)->whereNull('deleted_at')->count();
    }
    public static function getTotalJobMyApprovedList($id, $recuriterId)
    {
        $data = self::select(DB::raw("recruiter_candidates.name AS full_name"))->where('company_job_id', $id)->where('status', 3)->where('applied_type', 1)->where('related_id', $recuriterId)
            ->join('recruiter_candidates', 'recruiter_candidates.id', '=', 'company_job_applications.candidate_id')
            ->whereNull('company_job_applications.deleted_at')->get()->toArray();
        return $data;
    }
    public static function getTotalJobMyRejected($id, $recuriterId)
    {
        return self::where('company_job_id', $id)->where('status', 4)->where('applied_type', 1)->where('related_id', $recuriterId)->whereNull('deleted_at')->count();
    }
    public static function getTotalJobMyRejectedList($id, $recuriterId)
    {
        $data = self::select(DB::raw("recruiter_candidates.name AS full_name"))->where('company_job_id', $id)->where('status', 4)->where('applied_type', 1)->where('related_id', $recuriterId)
            ->join('recruiter_candidates', 'recruiter_candidates.id', '=', 'company_job_applications.candidate_id')
            ->whereNull('company_job_applications.deleted_at')->get()->toArray();
        return $data;
    }
    public static function getTotalJobMyPending($id, $recuriterId)
    {
        return self::where('company_job_id', $id)->where('status', 1)->where('applied_type', 1)->where('related_id', $recuriterId)->whereNull('deleted_at')->count();
    }
    public static function getTotalJobMyPendingList($id, $recuriterId)
    {
        $data = self::select(DB::raw("recruiter_candidates.name AS full_name"))->where('company_job_id', $id)->where('status', 1)->where('applied_type', 1)->where('related_id', $recuriterId)
            ->join('recruiter_candidates', 'recruiter_candidates.id', '=', 'company_job_applications.candidate_id')
            ->whereNull('company_job_applications.deleted_at')->get()->toArray();
        return $data;
    }
    public static function getTotalJobByRecruiter($recuriterId)
    {
        return self::where('applied_type', 1)->where('related_id', $recuriterId)->whereNull('deleted_at')->count();
    }
    public static function getTotalJobApprovedByRecruiter($recuriterId)
    {
        return self::where('status', 3)->where('applied_type', 1)->where('related_id', $recuriterId)->whereNull('deleted_at')->count();
    }
    public static function getTotalJobRejectedByRecruiter($recuriterId)
    {
        return self::where('status', 4)->where('applied_type', 1)->where('related_id', $recuriterId)->whereNull('deleted_at')->count();
    }
    public static function getMonthwiseJobApplicationCount($companyId, $month, $year, $status)
    {
        return self::where('company_id', $companyId)->where('status', $status)->whereMonth('created_at', $month)->whereYear('created_at', $year)->whereNull('deleted_at')->count();;
    }
    public static function getYearwiseJobApplicationCount($companyId, $year, $status)
    {
        return self::where('company_id', $companyId)->where('status', $status)->whereYear('created_at', $year)->whereNull('deleted_at')->count();
    }
    public static function getJobApplicationCount($companyId, $status)
    {
        return self::where('company_id', $companyId)->where('status', $status)->whereNull('deleted_at')->count();
    }
    public static function getCantidateCountByStatus($companyId, $companyJobId, $status = "")
    {
        if ($status != '')
            return self::where('company_id', $companyId)->where('company_job_id', $companyJobId)->where('status', $status)->whereNull('deleted_at')->count();
        else
            return self::where('company_id', $companyId)->where('company_job_id', $companyJobId)->whereNull('deleted_at')->count();
    }
    public static function getMonthwiseCompanyJobApplicationCount($companyId, $jobId, $month, $year, $status)
    {
        return self::where('company_id', $companyId)->where('company_job_id', $jobId)->where('status', $status)->whereMonth('created_at', $month)->whereYear('created_at', $year)->whereNull('deleted_at')->count();;
    }
}
