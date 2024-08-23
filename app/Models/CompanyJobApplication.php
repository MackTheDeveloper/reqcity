<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyJobApplication extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'company_job_applications';
    protected $fillable = [
        'id',
        'company_id',
        'company_job_id',
        'applied_type',
        'candidate_id',
        'related_id',
        'cv',
        'status',
        'rejection_reason',
        'latest_exp_start_year',
        'latest_exp_start_month',
        'latest_exp_end_year',
        'latest_exp_end_month',
        'is_current_working',
        'created_at',
        'approved_at',
        'rejected_at',
    ];

    // if applied_type = 1 then recruiter_candidates, recruiter_candidate_experience
    // if applied_type = 2 then candidates, candidate_experience

    public function RecruiterCandidateExperience()
    {
        return $this->hasMany(RecruiterCandidateExperience::class, 'candidate_id', 'candidate_id')->orderBy('id', 'DESC');
    }

    public function CandidateExperience()
    {
        return $this->hasMany(CandidateExperience::class, 'candidate_id', 'candidate_id')->orderBy('id', 'DESC');
    }

    public function Company()
    {
        return $this->hasOne(Companies::class, 'id', 'company_id');
    }

    public function RecruiterCandidate()
    {
        return $this->hasOne(RecruiterCandidate::class, 'id', 'candidate_id')->where('applied_type', 1);
    }

    public function RecruiterCandidateData()
    {
        return $this->hasOne(RecruiterCandidate::class, 'id', 'candidate_id');
    }

    public function Candidate()
    {
        return $this->hasOne(Candidate::class, 'id', 'candidate_id')->where('applied_type', 2);
    }

    public static function getTotalCandidates($companyJobId, $recruiterId)
    {
        $return = ['total' => 0, 'approved' => 0, 'rejected' => 0];
        $data = self::has('RecruiterCandidateData')->selectRaw('count(id) as total,COUNT(IF(status = "3", id, NULL)) AS approved,COUNT(IF(status = "4", id, NULL)) AS rejected')->where('company_job_id', $companyJobId)->where('related_id', $recruiterId)->where('applied_type', 1)->first()->toArray();
        if ($data) {
            $return = $data;
        }
        return $return;
    }

    public static function getCandidates($companyJobId, $recruiterId)
    {
        $return = [];
        $data = self::has('recruiterCandidateData')->where('company_job_id', $companyJobId)->where('related_id', $recruiterId)->where('applied_type', 1)->get();
        // pre($data);
        if ($data) {
            foreach ($data as $key => $value) {
                $latestCv = $experience = $experience_title = "";
                $latestExp = RecruiterCandidateExperience::latestExperience($value->candidate_id);

                if ($latestExp) {
                    $experience = $latestExp['company'] . " | " . getMonth($latestExp['start_month']) . " " . $latestExp['start_year'] . " - ";
                    if ($latestExp['is_current_working']) {
                        $experience .= "Present";
                    } else {
                        $experience .= getMonth($latestExp['end_month']) . " " . $latestExp['end_year'];
                    }
                    $experience_title = $latestExp['job_title'];
                }

                $latestResume = RecruiterCandidateResume::getLatestResume($value->candidate_id);
                if ($latestResume) {
                    $latestCv = $latestResume->cv;
                }
                $single = [
                    "id" => $value->candidate_id,
                    "name" => $value->recruiterCandidateData->name,
                    "is_diverse_candidate" => $value->recruiterCandidateData->is_diverse_candidate,
                    "linkedin_profile" => $value->recruiterCandidateData->linkedin_profile,
                    "status" => CompanyJob::getStatusText($value->status),
                    "created_at" => $value->created_at,
                    "experience_title" => $experience_title,
                    "experience" => $experience,
                    "latest_cv" => $latestCv,
                    "email" => $value->recruiterCandidateData->email,
                    "phone" => $value->recruiterCandidateData->phone_ext . ' ' . $value->recruiterCandidateData->phone,
                    "address" => $value->recruiterCandidateData->city . ', ' . $value->recruiterCandidateData->countrydata->name,
                ];
                $return[] = $single;
            }
            // pre($data);
            // $latestExp = RecruiterCandidateExperience::latestExperience($candidate)
            // $return = $data;
        }
        // pre($return);
        return $return;
    }

    public static function getApprovedCandidates($recruiterId)
    {
        return self::where('related_id', $recruiterId)->where('applied_type', 1)->whereNull('deleted_at')->count();
    }

    public static function getCountDashboard($status = 0, $from = "", $to = "")
    {
        $count = 0;
        $data = self::selectRaw('count(*) as total')->whereNull('deleted_at')->where('status', $status);
        if ($from != "" && $to != "") {
            $data->whereBetween('created_at', [$from, $to]);
        } else {
            $data->whereDate('created_at', Carbon::today());
        }
        $data = $data->first();
        if ($data) {
            $count = $data->total;
        }
        return $count;
    }

    public static function topRecruiters($limit = 5)
    {
        $return = [];
        $data = self::where('applied_type', 1)
            ->where('company_job_applications.status', 3)
            ->whereNull('company_job_applications.deleted_at')
            // ->selectRaw('related_id,count(*) as total')
            ->whereNull('recruiters.deleted_at')
            ->selectRaw('related_id,count(*) as total,CONCAT(recruiters.first_name," ",recruiters.last_name) as name')
            ->leftjoin('recruiters', 'recruiters.id', 'company_job_applications.related_id')
            ->groupBy('related_id')
            ->orderBy('total', 'DESC')
            ->limit($limit)
            ->get()->toArray();
        if ($data) {
            $return = $data;
        }
        return $return;
    }

    public static function topCompanies($limit = 5)
    {
        $return = [];
        $data = self::whereNull('deleted_at')
            ->selectRaw('company_id,count(*) as total')
            // ->with('company')
            ->with(['company' => function ($query) {
                $query->select('id', 'name', 'logo');
            }])
            ->has('company')
            ->groupBy('company_id')
            ->orderBy('total', 'DESC')
            ->limit($limit)
            ->get()->toArray();
        if ($data) {
            $return = $data;
        }
        return $return;
    }
}
