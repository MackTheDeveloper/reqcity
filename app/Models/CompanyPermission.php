<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyPermission extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'company_permissions';

    protected $fillable = ['id', 'permission_title', 'permission_slug', 'permission_route', 'permission_group', 'permission_description'];

    /**
     * roles() many-to-many relationship method
     *
     * @return QueryBuilder
     */

    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }

    public static function getIdBySlug($slug){
        return self::where('permission_slug',$slug)->first();
    }
}
