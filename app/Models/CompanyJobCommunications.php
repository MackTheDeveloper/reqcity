<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Session;

class CompanyJobCommunications extends Model
{
    use HasFactory;
    protected $table = 'company_job_communications';
    protected $fillable = [
        'company_job_id',
        'company_faq_id',
        'question',
        'answer',
    ];

    public static function getSelectedQuestions($companyJobId)
    {
        return self::where('company_job_id', $companyJobId)->where('company_faq_id', '!=', 0)->pluck('company_faq_id')->toArray();
    }

    public function CompanyFaq()
    {
        return $this->hasOne(CompanyFaqs::class, 'id', 'company_faq_id');
    }

    public static function getPkFromFaqId($faqId)
    {
        $companyJobId = Session::get('company_job.id');
        $data = self::where('company_job_id', $companyJobId)->where('company_faq_id', $faqId)->first();
        return $data->id;
    }


    public static function addData($data)
    {
        $return = 0;
        $success = true;
        $allowed = [
            'company_job_id',
            'company_faq_id',
            'question',
            'answer',
        ];
        $data = array_intersect_key($data, array_flip($allowed));
        $newEntry = new CompanyJobCommunications();
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

    public static function editData($id, $data)
    {
        $return = 0;
        $success = true;
        $allowed = [
            'company_job_id',
            'company_faq_id',
            'question',
            'answer',
        ];
        $data = array_intersect_key($data, array_flip($allowed));
        $exist = self::where('id', $id)->first();
        if ($exist) {
            try {
                foreach ($data as $key => $value) {
                    $exist->$key = $value;
                }
                $exist->save();
                $return = $exist->id;
            } catch (\Exception $e) {
                $return = $e->getMessage();
                $success = false;
            }
        }
        return ['data' => $return, 'success' => $success];
    }

    public static function addUpdateData($companyJobId, $data)
    {
        $updatedIds = [];
        foreach ($data as $k => $v) {

            foreach ($v as $key => $value) {
                if (count($value) == 1)
                    continue;
                $value['company_job_id'] = $companyJobId;
                if (isset($value['company_faq_id'])) {
                    $existFaq = CompanyFaqs::find($value['company_faq_id']);
                    if ($existFaq) {
                        $value['question'] = $existFaq->question;
                        $value['answer'] = $existFaq->answer;
                    }
                }
                if (!empty($value['id'])) {
                    $result1 = self::editData($value['id'], $value);
                    if ($result1['success']) {
                        $updatedIds[] =  $result1['data'];
                    }
                } else {
                    $result1 = self::addData($value);
                    $updatedIds[] =  $result1['data'];
                }
            }
        }
        self::where('company_job_id', $companyJobId)->whereNotIn('id', $updatedIds)->delete();
        return true;
    }

    public static function getCompanyFaq($companyJobId)
    {
        $return = [];
        $data = CompanyJobCommunications::where('company_job_id', $companyJobId)->get();
        if ($data) {
            foreach ($data as $key => $value) {
                // if ($value->company_faq_id) {
                //     $return[] = ['question' => $value->companyFaq->question, 'answer' => $value->companyFaq->answer];
                // }else{
                //     $return[] = ['question'=> $value->question, 'answer' => $value->answer];
                // }
                $return[] = ['question'=> $value->question, 'answer' => $value->answer];
            }
        }
        return $return;
    }
}
