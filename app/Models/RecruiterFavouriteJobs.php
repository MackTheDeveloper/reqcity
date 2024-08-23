<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class RecruiterFavouriteJobs extends Model
{

    protected $table = 'recruiter_favourite_jobs';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'recruiter_id', 'company_job_id', 'created_at'
    ];

    public static function checkIsFavorite($id,$recuriterId)
    {
        $return = 0;
        $data = self::where('recruiter_id', $recuriterId)->where('company_job_id', $id)->count();
        if ($data)
            $return = 1;
        return $return;
    }
}
