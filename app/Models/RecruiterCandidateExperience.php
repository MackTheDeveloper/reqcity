<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecruiterCandidateExperience extends Model
{
    use HasFactory;
    protected $table = 'recruiter_candidate_experience';
    protected $fillable = [
        'id',
        'recruiter_id',
        'candidate_id',
        'company_job_id',
        'job_title',
        'company',
        'start_year',
        'start_month',
        'end_year',
        'end_month',
        'job_responsibilities',
        'is_current_working',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static function addData($candidate,$data)
    {
        $return = 0;
        $success = true;
        $authId = User::getLoggedInId();
        $data['recruiter_id'] = $authId;
        $allowed = ['recruiter_id', 'candidate_id', 'company_job_id', 'job_title', 'company', 'start_year', 'start_month', 'end_year', 'end_month', 'job_responsibilities', 'is_current_working'];
        $data = array_intersect_key($data, array_flip($allowed));
        $newEntry = new RecruiterCandidateExperience();
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

    public static function latestExperience($candidate)
    {
        $data = self::where('candidate_id', $candidate)->orderBy('start_year','desc')->orderBy('start_month', 'desc')->first();
        if ($data) {
            $data = $data->toArray();
        }
        return $data;
    }
}
