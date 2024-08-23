<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Route;

class CompanyQuestionnaireType extends Model
{
    use SoftDeletes;
    protected $table = 'company_questionnaire_type';
    protected $fillable = ['type', 'status', 'has_choice'];

    public static function getData()
    {
        $return = [];
        $data = self::where('status','1')->select('has_choice', 'id','type')->get();
        if ($data) {
            foreach ($data as $key => $value) {
                $return[$value->id] = ['type'=> $value->type, 'has_choice' => $value->has_choice];
            }
        }
        return $return;
    }

    public static function getHasChoicesType()
    {
        $return = [];
        $data = self::where('status', '1')->where('has_choice', '1')->pluck('id');
        if ($data) {
            $return = $data->toArray();
        }
        return $return;
    }
}
