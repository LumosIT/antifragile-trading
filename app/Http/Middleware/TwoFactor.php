<?php

namespace App\Http\Middleware;

use App\Utilits\Api\ApiError;
use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactor
{

    protected function checkTwoFactory(Request $request, Model $user) : bool
    {

        $data = $request->validate([
            'code' => ['required', 'string', 'size:6']
        ], [
            'code.required' => 'Вы не указали код 2FA',
            'code.size' => 'Неверный код 2FA'
        ]);

        return $user->verifyTFACode($data['code']);

    }

    public function handle(Request $request, Closure $next, string $guard)
    {

        $guard = Auth::guard($guard);

        if($guard->check()){

            if($guard->user()->tfa_enabled){

                if($this->checkTwoFactory($request, $guard->user())){
                    return $next($request);
                }

                throw new ApiError('Неверный код 2FA');

            }

            throw new ApiError('Необходимо подключить 2FA');

        }

        throw new ApiError('Вы не авторизованы');

    }



}
