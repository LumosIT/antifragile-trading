<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    protected function isLocalHost(): bool
    {
        $url = redirect()->to('/')->getTargetUrl();

        return stripos($url, 'localhost:') !== false ||
            stripos($url, '127.0.0.1') !== false;
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        if(!$this->isLocalHost()){
            URL::forceScheme('https');
        }

        Blade::if('permission', function (string $permission) {
            return auth('admin')->user()->hasPermission($permission);
        });


    }
}
