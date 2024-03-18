<?php

namespace SushiMarket\Sbertips\Services\SbertipsService;

use Illuminate\Support\Facades\Http;

class CourierCardTip extends SberServiceRequest
{

    public static function saveStart($data)
    {
        return response(Http::withToken($data['accessToken'])->post(self::getUrl() . 'savecard/start', $data));
    }

    public static function saveFinish($data)
    {
        return response(Http::withToken($data['accessToken'])->post(self::getUrl() . 'savecard/finish', $data));
    }

    public static function active($data)
    {
        return response(Http::withToken($data['accessToken'])->post(self::getUrl() . 'card/active', $data));
    }

    public static function delete($data)
    {
        return response(Http::withToken($data['accessToken'])->post(self::getUrl() . 'card/delete', $data));
    }

    public static function list($accessToken)
    {
        return response(Http::withToken($accessToken)->post(self::getUrl() . 'card/list'));
    }

    /**
     * @return string
     */
    public static function getUrl():string
    {
        return 'https://pay.mysbertips.ru/sbrftips-proxy/api/';
    }
}
