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
    public static function getMerchantLogin():string
    {
        return config('sbertips.merchantLogin');
    }

    /**
     * @return string
     */
    public static function getPassword():string
    {
        return config('sbertips.merchantPassword');
    }

    /**
     * @return array[]
     */
    public static function getData(): array
    {
        return [
            'credentials' => [
                'login'     => self::getMerchantLogin(),
                'password'  => self::getPassword()
            ]
        ];
    }
}