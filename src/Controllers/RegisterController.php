<?php
namespace SushiMarket\Sbertips\Controllers;

use Illuminate\Routing\Controller;
use SushiMarket\Sbertips\Requests\AccessTokenRequest;
use SushiMarket\Sbertips\Requests\AuthOtpRequest;
use SushiMarket\Sbertips\Requests\ClientCreateRequest;
use SushiMarket\Sbertips\Requests\AuthTokenRequest;
use SushiMarket\Sbertips\Services\SbertipsService\RegisterTip;

class RegisterController extends Controller
{

    /**
     * clientsCreate
     *
     * @param ClientCreateRequest $request
     * @return mixed
     */
    public function clientsCreate(ClientCreateRequest $request)
    {
        return RegisterTip::clientsCreate($request->all())->json();
    }

    /**
     * authOtp
     *
     * @param AuthOtpRequest $request
     * @return mixed
     */
    public function authOtp(AuthOtpRequest $request)
    {
        return RegisterTip::authOtp($request->all())->json();
    }

    /**
     * authToken
     *
     * @param AuthTokenRequest $request
     * @return mixed
     */
    public function authToken(AuthTokenRequest $request)
    {
        return RegisterTip::authToken($request->all())->json();
    }

    /**
     * clientsInfo
     *
     * @param AccessTokenRequest $request
     * @return mixed
     */
    public function clientsInfo(AccessTokenRequest $request)
    {
        return RegisterTip::clientsInfo($request->input('accessToken'))->json();
    }
}
