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
        $data['merchantLogin'] = self::getMerchantLogin();
        $response = self::class::post(self::getUrl() . 'clients/create', $data);
        if ($response->status() === 200 && $response->json('status') === ResponseStatus::SUCCESS->value) {
            try {
                RiderTip::create([
                    'courier_id' => $data['courier_id'],
                    'uuid' => $response->json('client.uuid'),
                    'access_code' => $response->json('accessCode')
                ]);
            } catch (\Exception $e) {
                RiderTip::where(['courier_id' => $data['courier_id']])->update([
                    'uuid' => $response->json('client.uuid'),
                    'access_code' => $response->json('accessCode'),
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
                    'access_token' => $response->json('accessToken'),
                    'access_code' => null
                ]);
            } catch (\Exception $e) {
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
            'uuid' => $clientCreateResponse['client']['uuid']
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

        $data = [
            'accessToken' => $authOtpResponse['accessToken'],
            'title' => $authOtpResponse['accessToken'],
            'jobPosition' => 'jobPosition.courier',
            'company' => 'sushi-market'
        ];
        $data = self::checkTeamUuid($data);
        return QrCodeTip::add($data);
    }

    /**
     * prepareClient
     *
     * @param $data
     * @return mixed
     */
    public static function prepareClient($data): mixed
    {
        $rider = ModelFactory::getRiderModel()::findOrFail($data['courier_id']);
        if (!isset($data['phone'])) {
            $data['phone'] = self::preparePhone($rider['phone']);
        }
        if (!isset($data['gender'])) {
            $data['gender'] = self::prepareMale($rider['sex']);
        }
        if (!isset($data['firstName'])) {
            $data['firstName'] = $rider['name'];
        }
        if (!isset($data['lastName'])) {
            $data['lastName'] = $rider['famil'];
        }
        if (!isset($data['email'])) {
            $data['email'] = $rider['email'];
        }
        if (!isset($data['accessCode'])) {
            $data['accessCode'] = isset($rider->sbertip) ? $rider->sbertip->access_code : '';
        }

        return $data;
    }

    /**
     * preparePhone
     *
     * @param $phone
     * @return string|null
     */
    protected static function preparePhone($phone): null|string
    {
        if (strlen($phone) === 11) {
            return substr($phone, 1);
        }

        return $phone;
    }

    /**
     * prepareMale
     *
     * @param $sex
     * @return string
     */
    protected static function prepareMale($sex): string
    {
        if ($sex === "female") {
            return strtoupper($sex);
        }

        return "MALE";
    }

    /**
     * checkTeamUuid
     *
     * @param $data
     * @return mixed
     */
    protected static function checkTeamUuid($data)
    {
        $teamUuid = self::getTeamUuid();
        if ($teamUuid) {
            $data['teamUuid'] = $teamUuid;
        }

        return $data;
    }
}
