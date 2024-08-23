<?php

namespace App\Http\Controllers\FrontEnd\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Companies;
use App\Models\CompanyAddress;
use App\Models\CompanyJob;
use App\Models\CompanyJobFunding;
use App\Models\CompanyPermission;
use App\Models\CompanyTransaction;
use App\Models\CompanyUser;
use App\Models\CompanyUserPermission;
use App\Models\Country;
use App\Models\JobFieldOption;
use Exception;
use Auth;
use Faker\Provider\zh_TW\Company;
use Response;
use Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\URL;

class CompanyPermissionController extends Controller
{
    public function getPermissions(Request $request)
    {
        $companyUserId = $request->id;
        $companyUser = CompanyUser::where('id',$companyUserId)->first();
        $userId = $companyUser->user_id;
        $permissions = CompanyPermission::get();
        $arrPermissions = array();
        $userPermissions = CompanyUserPermission::getUserPermissions($userId);
        foreach ($permissions as $key => $permission) {
            // if (in_array($permission->permission_group, $arr_modules)) {
                $arrPermissions[$permission->permission_group][$key] = $permission;
            // }
        }
        return view('frontend.company.permission.permission',compact('arrPermissions','userId','userPermissions'));

    }


    public function changePermissions(Request $request)
    {
        $permissionId = $request->permissionId;
        $userId = $request->userId;
        $userPermission = CompanyUserPermission::where('company_permission_id',$permissionId)
                                ->where('user_id',$userId)->first();
        if($userPermission){
            $userPermission->delete();
            return 'success';
        }else{
            $userPermission = new CompanyUserPermission();
            $userPermission->company_permission_id = $permissionId;
            $userPermission->user_id = $userId;
            $userPermission->save();
            return 'success';
        }

    }
    
}
