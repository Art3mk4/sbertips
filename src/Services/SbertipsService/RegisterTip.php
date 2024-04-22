<?php
namespace SushiMarket\Sbertips\Services\SbertipsService;

use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use SushiMarket\Sbertips\Models\ResponseStatus;
use SushiMarket\Sbertips\Models\RiderTip;
use SushiMarket\Sbertips\Services\SbertipsService\QrCodeTip;
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
        $response = self::class::post(self::getUrl() . 'clients/create', $data);
        if ($response->status() === 200 && $response->json('status') === ResponseStatus::SUCCESS->value) {
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
        return self::class::post(self::getUrl() . 'auth/otp', $data);
    }

    /**
     * authToken
     *
     * @param $data
     * @return Response
     */
    public static function authToken($data)
    {
        $response = self::class::post(self::getUrl() . 'auth/token', $data);
        if ($response->status() === 200 && $response->json('status') === ResponseStatus::SUCCESS->value) {
            try {
                RiderTip::where([
                    'courier_id' => $data['courier_id']
                ])->update([
                    'access_token' => $response->json('accessToken')
                ]);
            } catch (UniqueConstraintViolationException $e) {
                Log::error($e->getMessage(), $data);
            }
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
        return self::class::withToken($accessToken)->post(self::getUrl() . 'clients/info');
    }

    /**
     * registerStart
     * @param $data
     * @return Response
     */
    public static function registerStart($data)
    {
        $clientCreateResponse = self::clientsCreate($data);
        if ($clientCreateResponse['status'] === ResponseStatus::FAIL->value) {
            return $clientCreateResponse;
        }

        return RegisterTip::authOtp([
            'merchantLogin' => config('sbertips.merchantLogin'),
            'uuid'          => $clientCreateResponse['client']['uuid']
        ]);
    }

    /**
     * registerFinish
     * @param $data
     * @return PromiseInterface|Response
     */
    public static function registerFinish($data)
    {
        $authOtpResponse = self::authToken($data);
        if ($authOtpResponse['status'] === ResponseStatus::FAIL->value) {
            return $authOtpResponse;
        }

        return QrCodeTip::add([
            'accessToken' => $authOtpResponse['accessToken'],
            'title'       => $authOtpResponse['accessToken'],
            'jobPosition' => 'jobPosition.courier',
            'company'     => 'sushi-market'
        ]);
    }
}
