<?php

namespace SushiMarket\Sbertips\Services\SbertipsService;

use Illuminate\Support\Facades\Http;

class QrCodeTips extends SberServiceRequest
{

    public static function list($accessToken)
    {
        return response(Http::withToken($accessToken)->post(self::getUrl() . 'qrcode/list'));
    }
}
