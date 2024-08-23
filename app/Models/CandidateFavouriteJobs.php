<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class CandidateFavouriteJobs extends Model
{

    protected $table = 'candidate_favourite_jobs';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'candidate_id', 'company_job_id', 'created_at'
    ];

    public static function checkIsFavorite($id)
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
