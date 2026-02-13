<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {

            Route::middleware('public')
                ->as('public')
                ->namespace($this->namespace)
                ->group(base_path('routes/public.php'));

            Route::middleware('api')
                ->as('admin.api')
                ->prefix('/admin/api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('admin')
                ->as('admin')
                ->prefix('/admin')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));

            Route::middleware('services')
                ->as('services.')
                ->prefix('/services')
                ->group(base_path('routes/services.php'));

        });

    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
//        RateLimiter::for('api', function (Request $request) {
//            return Limit::perMinute(60);
//        });
    }
}
