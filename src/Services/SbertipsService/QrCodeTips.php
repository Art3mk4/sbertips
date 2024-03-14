<?php

namespace SushiMarket\Sbertips\Services\SbertipsService;

use Illuminate\Support\Facades\Http;

class QrCodeTips extends SberServiceRequest
{

    public static function add($data)
    {
        return response(Http::withToken($data['accessToken'])->post(self::getUrl() . 'qrcode/add', $data));
    }

    public static function update($data)
    {
        return response(Http::withToken($data['accessToken'])->post(self::getUrl() . 'qrcode/update', $data));
    }

    public static function delete($data)
    {
        return response(
            Http::withToken($data['accessToken'])->post(
                self::getUrl() . 'qrcode/delete',
                [
                    'uuid' => $data['uuid']
                ]
            )
        );
    }

    public static function list($accessToken)
    {
        return response(Http::withToken($accessToken)->post(self::getUrl() . 'qrcode/list'));
    }
}
