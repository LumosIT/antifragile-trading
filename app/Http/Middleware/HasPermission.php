<?php

namespace App\Http\Middleware;

use App\Exceptions\Admins\DontHavePermissionsException;
use App\Utilits\Traits\Auth\AdminGuard;
use Closure;
use Illuminate\Http\Request;

class HasPermission
{

    use AdminGuard;

    public function handle(Request $request, Closure $next, string $permission)
    {

        if($this->admin() && $this->admin()->hasPermission($permission)){
            return $next($request);
        }

        if($request->isXmlHttpRequest()) {
            throw new DontHavePermissionsException($permission);
        }else{
            return redirect()->route('admin');
        }

    }



}
