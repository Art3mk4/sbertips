<?php

namespace SushiMarket\Sbertips\Services\SbertipsService;

class RegisterTips extends SberServiceRequest
{

    public static function clientsCreate($data)
    {
        return response(Http::post(self::getUrl() . 'clients/create', $data));
    }

    public static function authOtp($data)
    {
        return response(Http::post(self::getUrl() . 'auth/otp', $data));
    }

    public static function clientsInfo()
    {
        return response(Http::withToken(self::getAccessToken())->post(self::getUrl() . 'clients/info'));
    }
}