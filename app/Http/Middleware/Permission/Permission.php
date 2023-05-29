<?php

namespace App\Http\Middleware\permission;

use App\Models\PermissionConstant;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * 
     */
    public function handle(Request $request, Closure $next): Response
    {
        $datapermissionUser = optional(Auth::user())->permissions() ?? [];
        dd($datapermissionUser);
        // if(Auth::check() && !empty($datapermissionUser)) {
        //     $permissionOnlyUser = $datapermissionUser['permission'] ? json_decode($datapermissionUser['permission']) : '';

        //     if($permissionOnlyUser && $checkPermission = in_array($permission, $permissionOnlyUser)) {
        //         return $next($request);
        //     }
        //     return abort(403);
        // }
        // return abort(404);
    }
}
