<?php
namespace SushiMarket\Sbertips\Services\SbertipsService;

use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Http;
use SushiMarket\Sbertips\Models\RiderTip;
use Illuminate\Http\Client\Response;
use GuzzleHttp\Promise\PromiseInterface;

class RegisterTip extends SberServiceRequest
{

    /**
     * clientsCreate
     *
     * @param $data
     * @return Response
     */
    public static function clientsCreate($data)
    {
        $response = Http::post(self::getUrl() . 'clients/create', $data);
        if ($response->status() === 200 && $response->json('status') === "SUCCESS") {
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

        return $response;
    }

    /**
     * authOtp
     *
     * @param $data
     * @return Response
     */
    public static function authOtp($data)
    {
        return Http::post(self::getUrl() . 'auth/otp', $data);
    }

    /**
     * authToken
     *
     * @param $data
     * @return Response
     */
    public static function authToken($data)
    {
        $response = Http::post(self::getUrl() . 'auth/token', $data);
        if ($response->status() === 200 && $response->json('status') === 'SUCCESS') {
            RiderTip::where([
                'courier_id' => $data['courier_id']
            ])->update([
                'access_token' => $response->json('accessToken')
            ]);
        }

        return $response;
    }

    /**
     * clientsInfo
     *
     * @param $accessToken
     * @return PromiseInterface|Response
     */
    public static function clientsInfo($accessToken)
    {
        return Http::withToken($accessToken)->post(self::getUrl() . 'clients/info');
    }
}
