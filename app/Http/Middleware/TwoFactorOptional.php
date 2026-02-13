<?php

namespace App\Http\Middleware;

use App\Utilits\Api\ApiError;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorOptional extends TwoFactor
{

    public function handle(Request $request, Closure $next, string $guard)
    {

        $guard = Auth::guard($guard);

        if($guard->check()){

            if(
                !$guard->user()->tfa_enabled ||
                $this->checkTwoFactory($request, $guard->user())
            ){
                return $next($request);
            }

            throw new ApiError('Неверный код 2FA');

        }

        throw new ApiError('Вы не авторизованы 2FA');

    }



}
