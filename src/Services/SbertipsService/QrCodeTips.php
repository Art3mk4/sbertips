<?php

namespace SushiMarket\Sbertips\Services\SbertipsService;

use Illuminate\Support\Facades\Http;

class QrCodeTips extends SberServiceRequest
{

    public static function list()
    {
        return response(Http::withToken(self::getAccessToken())->post(self::getUrl() . 'qrcode/list'));
    }
}