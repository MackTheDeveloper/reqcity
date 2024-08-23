<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class States extends Model
{
    // use SoftDeletes;
    protected $table = 'states';
    protected $fillable = ['name','is_active'];

    public static function getListForDropdown(){
        $return = [];
        $data = self::selectRaw('name, CONCAT(name," (",code,")") as name_code')->where('status','1')->get();
        foreach ($data as $key => $value) {
            $return[] = ['key'=>$value->name,'value'=>$value->name_code];
        }
        return $return;
    }
    public static function getListForDropdownByCountry($coutryId){
        $return = [];
        $data = self::selectRaw('name, CONCAT(name," (",code,")") as name_code')->where('status','1')->where('country_id',$coutryId)->get();
        foreach ($data as $key => $value) {
            $return[] = ['key'=>$value->name,'value'=>$value->name_code];
        }
        return $return;
    }

}
