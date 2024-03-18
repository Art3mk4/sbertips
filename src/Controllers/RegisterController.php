<?php

namespace SushiMarket\Sbertips\Controllers;

use App\Http\Controllers\Controller;
use SushiMarket\Sbertips\Requests\AccessTokenRequest;
use SushiMarket\Sbertips\Requests\AuthOtpRequest;
use SushiMarket\Sbertips\Requests\ClientCreateRequest;
use SushiMarket\Sbertips\Requests\AuthTokenRequest;
use SushiMarket\Sbertips\Services\SbertipsService\RegisterTip;

class RegisterController extends Controller
{

    public function clientsCreate(ClientCreateRequest $request)
    {
        return RegisterTip::clientsCreate($request->all());
    }

    public function authOtp(AuthOtpRequest $request)
    {
        return RegisterTip::authOtp($request->all());
    }

    public function authToken(AuthTokenRequest $request)
    {
        return RegisterTip::authToken($request->all());
    }

    public function clientsInfo(AccessTokenRequest $request)
    {
        return RegisterTip::clientsInfo($request->input('accessToken'));
    }
}
