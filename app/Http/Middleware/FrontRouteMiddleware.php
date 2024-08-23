<?php

namespace App\Http\Middleware;

use App\Models\CompanyPermission;
use App\Models\CompanyUser;
use App\Models\CompanyUserPermission;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontRouteMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    // public function handle(Request $request, Closure $next)
    // {
    //     return $next($request);
    // }

    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $isOwner = CompanyUser::checkIsOwner($user_id);
            if (!$isOwner) {
                if (request()->id) {
                    $path = str_replace(request()->id, '*', $request->path());
                } elseif (request()->token) {
                    $path = str_replace(request()->token, '*', $request->path());
                } elseif (request()->lang_id) {
                    $path = str_replace(request()->lang_id, '*', $request->path());
                } else {
                    $path = $request->path();
                }
                $existPermission = CompanyPermission::select('id')->where('permission_route', $path)->first();
                if ($existPermission) {
                    $userHasPermission = CompanyUserPermission::select('id')->where('company_permission_id', $existPermission->id)
                        ->where('user_id', $user_id)->first();
                    if ($userHasPermission) {
                        return $next($request);
                    }else{
                        abort(404, 'Page not found');
                    }
                }
        
                return $next($request);
            }
            return $next($request);
        }
        return $next($request);
    }
}
