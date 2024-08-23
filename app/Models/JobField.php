<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use File;
use Image;

class JobField extends Model
{
    use HasFactory;
    protected $table = 'job_fields';
    protected $fillable = [
        'id',
        'code',
        'field_name',
        'filterable',
        'status',
    ];
    public static function getDetails($id){
        return self::find($id);
    }

    public static function getList(){
        return self::pluck('code','id','field_name');
    }    
}
