<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Route;

class CompanyJobQuestionnaires extends Model
{
    use SoftDeletes;
    protected $table = 'company_job_questionnaires';
    protected $fillable = ['id', 'company_job_id', 'company_questionnaire_id', 'question', 'question_type', 'options_JSON'];

    public static function getQuestionAnsers($company_job_id,$company_job_application_id)
    {
        $return = []; 
        $data = self::where('company_job_id',$company_job_id)
                     ->where('company_job_application_id',$company_job_application_id)->select('question','answer')->get();
        foreach ($data as $key => $value) {
            $return[] = ['key'=>$value->question,'value'=>$value->answer];
        }
        return $return;
    }

    public static function addUpdateQuestion($companyJobId, $questionId,$hasExtra,$questions=[], $options=[]){
        $deleteExcept = [];
        if ($questionId) {
            foreach ($questionId as $key => $value) {
                $existQuestion = CompanyQuestionnaires::find($value);
                if ($existQuestion) {
                    $model = CompanyJobQuestionnaires::where('company_job_id' ,$companyJobId)->where('company_questionnaire_id', $value)->first();
                    if (!$model) {
                        $model = new CompanyJobQuestionnaires();
                    }
                    $model->company_job_id = $companyJobId;
                    $model->company_questionnaire_id = $value;
                    $model->question = $existQuestion['question'];
                    $model->question_type = $existQuestion['question_type'];
                    $model->options_JSON = self::makeOptionsJsonExist($value);
                    $model->save();
                    $deleteExcept[] = $model->id;
                }
            }
        }

        if ($hasExtra && $questions) {
            foreach ($questions as $key => $value) {
                if (isset($value['id'])) {
                    $model = CompanyJobQuestionnaires::find($value['id']);
                }else{
                    $model = new CompanyJobQuestionnaires();
                }
                $model->company_job_id = $companyJobId;
                $model->company_questionnaire_id = 0;
                $model->question = $value['question'];
                $model->question_type = $value['question_type'];
                if (isset($options) && isset($options[$key])) {
                    $model->options_JSON = self::makeOptionsJson($options[$key]);
                }
                $model->save();
                $deleteExcept[] = $model->id;
            }
        }

        self::where('company_job_id', $companyJobId)->whereNotIn('id', $deleteExcept)->delete();
    }

    public static function makeOptionsJson($options)
    {
        $return = [];
        foreach ($options as $key => $value) {
            $single['sort_order'] = $key+1;
            $single['option_value'] = $value['option_value'];
            $return[] = $single;
        }
        return json_encode($return);
    }

    public static function makeOptionsJsonExist($questionId)
    {
        $return = [];
        $options = CompanyQuestionnaireOptions::where('cq_id', $questionId)->get();
        if ($options) {
            foreach ($options as $key => $value) {
                $single['sort_order'] = $value->sort_order;
                $single['option_value'] = $value->option_value;
                $return[] = $single;
            }
        }
        return json_encode($return);
    }
}
