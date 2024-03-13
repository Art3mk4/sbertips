<?php

namespace SushiMarket\Sbertips\Controllers;

use App\Http\Controllers\Controller;
use SushiMarket\Sbertips\Requests\AuthOtpRequest;
use SushiMarket\Sbertips\Requests\ClientCreateRequest;
use SushiMarket\Sbertips\Requests\AuthTokenRequest;
use SushiMarket\Sbertips\Services\SbertipsService\RegisterTips;

class RegisterController extends Controller
{

    public function clientsCreate(ClientCreateRequest $request)
    {
        return RegisterTips::clientsCreate($request->all());
    }

    public function authOtp(AuthOtpRequest $request)
    {
        return RegisterTips::authOtp($request->all());
    }

    public function authToken(AuthTokenRequest $request)
    {
        return RegisterTips::authToken($request->all());
    }

    public function clientsInfo()
    {
        return RegisterTips::clientsInfo();
    }
}
