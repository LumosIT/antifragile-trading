<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Utilits\Api\ApiError;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function login(Request $request) : bool
    {
        $data = $request->validate([
            'login' => ['required', 'string', 'min:1', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'size:6']
        ], [
            'login.required' => 'Вы не указали логин',
            'login.regex' => 'Неверный логин или пароль',
            'login.max' => 'Неверный логин или пароль',
            'login.min' => 'Неверный логин или пароль',
            'password.required' => 'Неверный логин или пароль',
            'password.max' => 'Неверный логин или пароль',
            'code.size' => 'Неверный код 2FA'
        ]);

        $admin = Admin::query()->where('login', $data['login'])->first();

        if(!$admin || !Hash::check($data['password'], $admin->password)){
            throw new ApiError('Неверный логин или пароль', 403);
        }

        //Проверка 2FA
        if($admin->tfa_enabled){

            $code = Arr::get($data, 'code') ?: null;

            if(!$code){
                throw new ApiError('Введите код 2FA', 401);
            }

            if(!$admin->verifyTFACode($code)){
                throw new ApiError('Неверный код 2FA', 405);
            }

        }

        $this->adminGuard()->login($admin);

        return true;

    }

    public function logout(Request $request) : RedirectResponse
    {
        $this->adminGuard()->logout();

        return redirect()->back();
    }

}
