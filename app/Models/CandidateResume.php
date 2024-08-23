<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use File;

class CandidateResume extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'candidate_resume';

    protected $fillable = [
        'id',
        'candidate_id',
        'resume',
        'version_num',
        'deleted',
        'created_at',
        'deleted_at',
    ];

    //get latest version resume by candidate id
    public static function getLatestResume($id)
    {
        $return = self::where('candidate_id', $id)
            ->orderBy('version_num', 'DESC')->first();
        if ($return) {
            $resume = $return->resume;
            if ($resume && !empty($resume)) {
                $resumeUrl = url('public/assets/candidate/resume/' .  $resume);
            }
            return ($resumeUrl) ?: [];
        } else {
            return null;
        }
    }
    
    public function getResumeAttribute($image)
    {
        $return = "";
        $path = public_path() . '/assets/candidate/resume/' . $image;
        if (file_exists($path) && $image) {
            $return = url('/public/assets/candidate/resume/' . $image);
        }
        return $return;
    }

    public static function getLatestResumeNew($id)
    {
        return self::where('candidate_id', $id)->orderBy('version_num', 'DESC')->first();
    }

    public static function getResumeById($id)
    {
        $resumeUrl = "";
        $return = self::where('id', $id)->first();
        if ($return && !empty($return)) {
            $resume = $return->resume;
            $resumeUrl = $resume;
        }
        return ($resumeUrl) ?: "";
    }

    public static function checkResumeUploaded($candidateId)
    {
        return self::where('candidate_id', $candidateId)->count();
    }

    public static function getLastestCvId($candidateId)
    {
        $return = self::where('candidate_id', $candidateId)
            ->orderBy('version_num', 'DESC')->first();
        if ($return) {
            return $return->id;
        } else {
            return null;
        }
    }

    public static function uploadResume($candidateId, $fileObject)
    {
        $file = $fileObject;
        //$ext = $fileObject->extension();
        $ext = $fileObject->getClientOriginalExtension();
        // pre($ext);
        $filename = rand() . '_' . time() . '.' . $ext;
        $filePath = public_path() . '/assets/candidate/resume/';
        if (!File::exists($filePath)) {
            File::makeDirectory($filePath);
        }
        $file->move($filePath . '/', $filename);
        if ($candidateId) {
            // pre($candidateId);
            // $oldData = self::where('recruiter_candidate_id', $candidateId)->first();
            // if ($oldData) {
            //     $path = public_path() . '/assets/recruiter-candidate/resume/' . $oldData->resume;
            //     if (file_exists($path)) {
            //         unlink($path);
            //     }
            // }
            $versions = self::where('candidate_id', $candidateId)->orderBy('id', 'DESC')->first();
            $versionNumber = 1;
            if ($versions) {
                $versionNumber = $versions->version_num + 1;
            }
            $resume = new CandidateResume();
            $resume->candidate_id = $candidateId;
            $resume->resume = $filename;
            $resume->version_num = $versionNumber;
            $resume->created_at = Carbon::now();
            $resume->save();
            return $resume->id;
        }
        return $filename;
    }
}