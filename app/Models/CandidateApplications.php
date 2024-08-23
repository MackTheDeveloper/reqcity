<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Auth;

class CandidateApplications extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'candidate_applications';
    protected $fillable = [
        'id',
        'candidate_id',
        'company_job_id',
        'candidate_cv_id',
        'specialist_user_id',
        'status',
        'rejection_reason',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function companyJob()
    {
        return $this->hasOne(CompanyJob::class, 'id', 'company_job_id');
    }

    public static function changeStatusApprove($candidateId, $jobApplicationId)
    {
        $candidateApplication = CandidateApplications::where('company_job_id', $jobApplicationId)
            ->where('candidate_id', $candidateId)->first();
        if ($candidateApplication) {
            $candidateApplication->status = 3;
            $candidateApplication->approved_at = Carbon::now();
            $candidateApplication->update();
            return $candidateApplication;
        } else {
            return false;
        }
    }

    public static function changeStatusReject($candidateId, $jobApplicationId, $reason)
    {
        $candidateApplication = CandidateApplications::where('company_job_id', $jobApplicationId)
            ->where('candidate_id', $candidateId)->first();
        if ($candidateApplication) {
            $candidateApplication->status = 4;
            $candidateApplication->rejection_reason = $reason;
            $candidateApplication->rejected_at = Carbon::now();
            $candidateApplication->update();
            return $candidateApplication;
        } else {
            return false;
        }
    }

    public static function getAppliedJobs($candidateId, $limit = 0)
    {
        $return = array();
        $data = self::where('candidate_id', $candidateId);
        if ($limit) {
            $data = $data->limit($limit);
        }
        $data = $data->orderBy('id','desc')->get();
        if (!empty($data))
            $return = $data;

        return $return;
    }

    public static function checkFirstJobAppliedOrNot($candidateId)
    {
        return self::where('candidate_id', $candidateId)->count();
    }

    public static function addCandidateApplication($data)
    {
        $return = 0;
        $success = true;
        $allowed = ['candidate_id', 'company_job_id', 'candidate_cv_id', 'specialist_user_id', 'status', 'rejection_reason'];
        $data = array_intersect_key($data, array_flip($allowed));
        $newEntry = new CandidateApplications();
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

    public static function checkIsApplied($id)
    {
        $return = 0;
        if(Auth::check() && Auth::user()->role_id ==5){
        $candidateId = Auth::user()->candidate->id;
          $data = self::where('candidate_id', $candidateId)->where('company_job_id', $id)->count();
          if ($data)
              $return = 1;
        }
        return $return;
    }
}
