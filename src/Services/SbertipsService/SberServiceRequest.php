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
        return config('sbertips.url');
    }

    /**
     * @return string
     */
    public static function getAccessToken():string
    {
        return config('sbertips.accessToken');
    }

    /**
     * @return string
     */
    public static function getMerchantLogin():string
    {
        return config('sbertips.merchantLogin');
    }
}