<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Country extends Model
{
    use SoftDeletes;
    protected $table = 'countries';
    protected $fillable = ['name','is_active','deleted_at'];

    public static function getListForDropdown(){
        $return = []; 
        $data = self::where('is_active','1')->select('name','id')->get();
        foreach ($data as $key => $value) {
            $return[] = ['key'=>$value->id,'value'=>$value->name];
        }
        return $return;
    }

    public static function getCountryName($id){
        $data = self::where('id',$id)->select('name')->pluck('name');
        return $data;
    }
    
}
