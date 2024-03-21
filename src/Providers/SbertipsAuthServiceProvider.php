<?php

namespace SushiMarket\Sbertips\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SushiMarket\Sbertips\Services\Auth\SbertipsApiService;

class SbertipsAuthServiceProvider extends AuthServiceProvider
{
    public function boot()
    {
        $this->registerPolicies();
        Auth::viaRequest('sbertips_auth', function (Request $request) {
            return (new SbertipsApiService())->checkBearerToken($request->bearerToken());
        });
    }
}
