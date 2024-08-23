<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use File;


class RecruiterCandidateResume extends Model
{
    use HasFactory;
    protected $table = 'recruiter_candidates_cv';
    
    protected $fillable = [
        'id',
        'recruiter_candidate_id',
        'cv',
        'version_num',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getCvAttribute($image)
    {
        $return = "";
        $path = public_path() . '/assets/recruiter-candidate/resume/' . $image;
        if (file_exists($path) && $image) {
            $return = url('/public/assets/recruiter-candidate/resume/' . $image);
        }
        return $return;
    }
    
    //get latest version resume by candidate id
    public static function getLatestResume($id){
        return self::where('recruiter_candidate_id',$id) ->orderBy('version_num','DESC')->first();
    }

    public static function uploadResume($candidateId, $fileObject)
    {
        $file = $fileObject;
        //$ext = $fileObject->extension();
        $ext = $fileObject->getClientOriginalExtension();
        // pre($ext);
        $filename = rand() . '_' . time() . '.' . $ext;
        $filePath = public_path() . '/assets/recruiter-candidate/resume/';
        if (!File::exists($filePath)) {
            File::makeDirectory($filePath);
        }
        $file->move($filePath . '/', $filename);
        // pre('asd2');
        if ($candidateId) {
            // $oldData = self::where('recruiter_candidate_id', $candidateId)->first();
            // if ($oldData) {
            //     $path = public_path() . '/assets/recruiter-candidate/resume/' . $oldData->resume;
            //     if (file_exists($path)) {
            //         unlink($path);
            //     }
            // }
            $versions = self::where('recruiter_candidate_id', $candidateId)->orderBy('id', 'DESC')->first();
            $versionNumber = 1;
            if ($versions) {
                $versionNumber = $versions->version_num + 1;
            }
            $resume = new RecruiterCandidateResume();
            $resume->recruiter_candidate_id = $candidateId;
            $resume->cv = $filename;
            $resume->version_num = $versionNumber;
            $resume->created_at = Carbon::now();
            $resume->save();
            return $resume->id;
        }
        return $filename;
    }
}


