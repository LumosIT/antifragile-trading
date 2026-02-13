<?php

namespace App\Auth;

use App\Services\UsersService;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;

class UserAccessHashGuard implements Guard
{
    protected $user;
    protected $provider;
    protected $request;
    protected $usersService;

    public function __construct(
        UserProvider $provider,
        Request $request,
        UsersService $usersService
    ){
        $this->provider = $provider;
        $this->request = $request;
        $this->usersService = $usersService;
    }

    public function user()
    {
        if (! $this->user) {

            $user = (int)$this->request->get('user');
            $user = $this->provider->retrieveById($user);

            $hash = (string)$this->request->get('hash');

            if($user && $hash && $this->usersService->getPublicAccessHash($user) === $hash) {
                $this->user = $user;
            }

        }

        return $this->user;
    }

    public function check() : bool
    {
        return (bool) $this->user();
    }

    public function guest() : bool
    {
        return ! $this->check();
    }

    public function id() {
        return optional($this->user())->getAuthIdentifier();
    }

    public function validate(array $credentials = [])  : bool
    {
        return false;
    }

    public function setUser($user) : self
    {
        $this->user = $user;

        return $this;
    }
}
