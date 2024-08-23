<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Route;

class CompanyQuestionnaireTemplates extends Model
{
    use SoftDeletes;
    protected $table = 'company_questionnaire_templates';
    protected $fillable = ['title', 'status', 'created_by', 'company_id'];

    public function User()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function Questions()
    {
        return $this->hasMany(CompanyQuestionnaires::class, 'cqt_id', 'id');
    }

    public static function addTemplate($data)
    {
        $return = 0;
        $success = true;
        $authId = User::getLoggedInId();
        $data['company_id'] = CompanyUser::getCompanyIdByUserId($authId);
        // $data['dob'] = date('Y-m-d',strtotime($data['dob']));
        // pre($data);
        $data['created_by'] = $authId;
        $allowed = ['title', 'status', 'created_by', 'company_id'];
        $data = array_intersect_key($data, array_flip($allowed));
        $newEntry = new CompanyQuestionnaireTemplates();
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

    public static function editTemplate($id, $data){
        $return = 0;
        $success = true;
        $authId = User::getLoggedInId();
        $data['company_id'] = CompanyUser::getCompanyIdByUserId($authId);
        // $data['dob'] = date('Y-m-d',strtotime($data['dob']));
        // pre($data);
        $data['created_by'] = $authId;
        $allowed = ['title', 'status', 'created_by', 'company_id'];
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
    public static function getQuestionnaireTemplatesCount($companyId)
    {
      return self::where('company_id',$companyId)->where('status',1)->whereNull('deleted_at')->count();
    }
}
