<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Route;
use File;

class CompanyJobApplicationQuestionnaire extends Model
{
    use SoftDeletes;
    protected $table = 'company_job_application_questionnaires';
    protected $fillable = ['id', 'company_job_id', 'company_job_application_id', 'company_questionnaire_id', 'question', 'question_type', 'options_JSON', 'answer'];

    public function CompanyQuestionnaire()
    {
        return $this->hasOne(CompanyQuestionnaires::class, 'id', 'company_questionnaire_id');
    }

    public static function getQuestionAnsers($company_job_id,$company_job_application_id)
    {
        $return = []; 
        $data = self::where('company_job_id',$company_job_id)
                     ->where('company_job_application_id',$company_job_application_id)->select('question','answer','question_type')->get();
        foreach ($data as $key => $value) {
            $return[] = ['key'=>$value->question,'value'=>$value->answer,'type'=>$value->question_type];
        }
        return $return;
    }

    public static function uploadFile($fileObject)
    {
        $file = $fileObject;
        $ext = $fileObject->extension();
        // pre($ext);
        $filename = rand() . '_' . time() . '.' . $ext;
        $filePath = public_path() . '/assets/recruiter-candidate/uploads/';
        if (!File::exists($filePath)) {
            File::makeDirectory($filePath);
        }
        $file->move($filePath . '/', $filename);
        $fileUrl = 'public/assets/recruiter-candidate/uploads/';
        $url = url($fileUrl.$filename);
        return $url;
    }

    public static function getQuestionnaire($applicationId, $jobId)
    {
        $return = [];
        $application = self::where('company_job_application_id',$applicationId)->where('company_job_id', $jobId)->get();
        if ($application) {
            foreach ($application as $key => $value) {
                $single['answer']=$value->answer;
                $single['question_type']=$value->question_type;
                if ($value->company_questionnaire_id) {
                    $single['question'] = $value->companyQuestionnaire->question;
                }else{
                    $single['question'] = $value->question;
                }
                $return[] = $single;
            }
        }
        // pre($return);
        return $return;
    }
}
