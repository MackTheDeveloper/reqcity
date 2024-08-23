<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Route;

class CompanyQuestionnaireOptions extends Model
{
    use SoftDeletes;
    protected $table = 'company_questionnaire_options';
    protected $fillable = ['cq_id', 'option_value', 'sort_order'];

    public static function addData($data)
    {
        $return = 0;
        $success = true;
        $authId = User::getLoggedInId();
        // $data['dob'] = date('Y-m-d',strtotime($data['dob']));
        // pre($data);
        $data['created_by'] = $authId;
        $allowed = ['cq_id', 'option_value', 'sort_order'];
        $data = array_intersect_key($data, array_flip($allowed));
        $newEntry = new CompanyQuestionnaireOptions();
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
        $allowed = ['cq_id', 'option_value', 'sort_order'];
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

    public static function addUpdateData($queId, $data)
    {
        $updatedIds = [];
        foreach ($data as $key => $value) {
            if (!empty($value['option_value'])) {
                $value['cq_id'] = $queId;
                $value['sort_order'] = $key+1;
                // $value['sort_order'] = (!empty($value['sort_order']))? $value['sort_order']:$key+1;
                if (!empty($value['id'])) {
                    $result1 = self::editData($value['id'],$value);
                    if($result1['success']){
                        $updatedIds[] =  $result1['data'];
                    }else{
                        pre('3','1');
                        pre($result1);
                    }
                }else{
                    $result1 = self::addData($value);
                    if($result1['success']){
                        $updatedIds[] =  $result1['data'];
                    }else{
                        pre('4','1');
                        pre($result1);
                    }
                }
            }
        }
        self::where('cq_id',$queId)->whereNotIn('id', $updatedIds)->delete();
        return true;
    }
}
