<?php

namespace App\Http\Middleware;

// use Illuminate\Auth\Middleware\Authenticate as Middleware;

use App\Models\CompanyPermission;
use App\Models\CompanyUser;
use App\Models\CompanyUserPermission;
use Closure;
use Auth;

class RoleUser
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function handle($request, Closure $next, $role)
    {
        if (Auth::user()->role_id == $role) {
            $user_id = Auth::user()->id;
            $isOwner = CompanyUser::checkIsOwner($user_id);
            $access = 0;
            if ($isOwner) {
                $access = 1;
            } else {
                $path = str_replace(request()->id, '*', $request->path());
                $permission = CompanyPermission::where('permission_route', $path)->first();
                if ($permission) {
                    $permission_id = $permission->id;
                    $permission_user = CompanyUserPermission::where('user_id', $user_id)->where('company_permission_id', $permission_id)->first();
                    if ($permission_user) {
                        $access = 1;
                    }
                } else {
                    $access = 1;
                }
            }
            if ($access) {
                return $next($request);
            }
            abort(403, 'Access Denied');
        } else {
            abort(404, 'Page not found');
        }
    }
}
