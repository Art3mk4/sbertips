<?php

namespace SushiMarket\Sbertips\Services\SbertipsService;

use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Http;
use SushiMarket\Sbertips\Models\RiderTip;

class RegisterTip extends SberServiceRequest
{

    public static function clientsCreate($data)
    {
        $response = Http::post(self::getUrl() . 'clients/create', $data);
        if ($response->json('status') === "SUCCESS") {
            try {
                RiderTip::create([
                    'courier_id' => $data['courier_id'],
                    'uuid'       => $response->json('client.uuid')
                ]);
            } catch (UniqueConstraintViolationException $e) {
                RiderTip::where(['courier_id' => $data['courier_id']])->update([
                    'uuid'       => $response->json('client.uuid')
                ]);
            }
        }

        return response($response);
    }

    public static function authOtp($data)
    {
        return response(Http::post(self::getUrl() . 'auth/otp', $data));
    }

    public static function authToken($data)
    {
        $response = Http::post(self::getUrl() . 'auth/token', $data);
        if ($response->json('status') === 'SUCCESS') {
            RiderTip::where([
                'courier_id' => $data['courier_id']
            ])->update([
                'access_token' => $response->json('accessToken')
            ]);
        }

        return response($response);
    }

    public static function clientsInfo($accessToken)
    {
        return response(Http::withToken($accessToken)->post(self::getUrl() . 'clients/info'));
    }
}
