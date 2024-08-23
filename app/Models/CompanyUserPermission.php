<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyUserPermission extends Model
{
    use HasFactory;
    
    protected $table = 'company_user_permissions';

    protected $fillable = ['company_permission_id', 'user_id'];

    public static function getUserPermissions($userId)
    {
        $permissions = self::where('user_id',$userId)->pluck('company_permission_id')->toArray();
        return $permissions;
    }
    
}
