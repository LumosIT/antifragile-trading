<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{

    private $guard;

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request) : ?string
    {

        if($request->expectsJson()){
            abort(403);
        }

        switch($this->guard){

            case 'admin':
                return route('admin.login');

            case 'user':
                abort(403);

            default:
                return '/';

        }

    }

    public function handle($request, \Closure $next, ...$guards)
    {

        $this->guard = count($guards) ? $guards[0] : null;
        $this->authenticate($request, $guards);

        return $next($request);
    }


}
