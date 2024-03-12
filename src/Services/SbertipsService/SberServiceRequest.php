<?php

namespace SushiMarket\Sbertips\Services\SbertipsService;
use Illuminate\Support\Facades\Http;

class SberServiceRequest extends Http
{

    /**
     * @return array
     */
    public static function getConfig():array
    {
        return config('sbertips');
    }

    /**
     * @return string
     */
    public static function getUrl():string
    {
        return self::getConfig()['url'];
    }

    /**
     * @return string
     */
    public static function getAccessToken():string
    {
        return self::getConfig()['accessToken'];
    }

    /**
     * @return string
     */
    public static function getMerchantLogin():string
    {
        return self::getConfig()['merchantLogin'];
    }
}