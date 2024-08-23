<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Route;

class CompanyQuestionnaires extends Model
{
    use SoftDeletes;
    protected $table = 'company_questionnaires';
    protected $fillable = ['cqt_id', 'question', 'question_type'];

    public function Options()
    {
        return $this->hasMany(CompanyQuestionnaireOptions::class, 'cq_id', 'id');
    }

    public static function addData($data)
    {
        $return = 0;
        $success = true;
        $authId = User::getLoggedInId();
        // $data['dob'] = date('Y-m-d',strtotime($data['dob']));
        // pre($data);
        $data['created_by'] = $authId;
        //$data['company_id'] = CompanyUser::getCompanyIdByUserId($authId);
        $allowed = ['cqt_id', 'question', 'question_type'];
        $data = array_intersect_key($data, array_flip($allowed));
        $newEntry = new CompanyQuestionnaires();
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
        $authId = User::getLoggedInId();
        // $data['dob'] = date('Y-m-d',strtotime($data['dob']));
        // pre($data);
        $data['created_by'] = $authId;
        //$data['company_id'] = CompanyUser::getCompanyIdByUserId($authId);
        $allowed = ['cqt_id', 'question', 'question_type'];
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

    public static function addUpdateData($templateId, $data, $choices=[])
    {
        $updatedIds = [];
        $typeChoices = CompanyQuestionnaireType::getHasChoicesType();
        // pre($data);
        foreach ($data as $key => $value) {
            $value['cqt_id'] = $templateId;
            if (!empty($value['id'])) {
                $result1 = self::editData($value['id'],$value);
                if($result1['success']){
                    $updatedIds[] =  $result1['data'];
                    if (!empty($choices[$key])) {
                        if (in_array($value['question_type'], $typeChoices)) {
                            CompanyQuestionnaireOptions::addUpdateData($result1['data'], $choices[$key]);
                        }
                    }
                }else{
                    pre('1','1');
                    pre($result1);
                }
            }else{
                $result1 = self::addData($value);
                if($result1['success']){
                    $updatedIds[] =  $result1['data'];
                    if (!empty($choices[$key])) {
                        if (in_array($value['question_type'], $typeChoices)) {
                            CompanyQuestionnaireOptions::addUpdateData($result1['data'], $choices[$key]);
                        }
                    }
                }else{
                    pre('2','1');
                    pre($result1);
                }
            }
        }
        self::where('cqt_id', $templateId)->whereNotIn('id', $updatedIds)->delete();
        return true;
    }
}
