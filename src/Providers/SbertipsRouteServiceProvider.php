<?php

namespace SushiMarket\Sbertips\Providers;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use SushiMarket\Sbertips\Middleware\SbertipsAuthMiddleware;
use SushiMarket\Sbertips\Services\Auth\SbertipsApiService;

class SbertipsRouteServiceProvider extends RouteServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        app('router')->aliasMiddleware('sbertips_auth', SbertipsAuthMiddleware::class);
        Config::set('auth.guards.sbertips_auth', [
            'driver' => 'sbertips_auth',
            //'provider' => 'sbertips_auth'
        ]);
    }
}
