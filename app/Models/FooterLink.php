<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterLink extends Model
{
    use HasFactory;
    protected $table = 'footer_links';

    protected $fillable = ['relation_data','name','type','sort_order','is_active','deleted_at'];

    public static function getSortOrder(){
        $return = self::selectRaw('sort_order')->where('is_active',1)->orderBy('sort_order','desc')->first();
        return $return?$return->sort_order+1:1;
    }
}
