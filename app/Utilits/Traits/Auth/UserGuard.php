<?php
namespace App\Utilits\Traits\Auth;

use App\Models\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;

trait UserGuard
{

    protected function user() : ?User
    {
        return $this->userGuard()->user();
    }

    protected function userGuard() : Guard
    {
        return Auth::guard('user');
    }

}
