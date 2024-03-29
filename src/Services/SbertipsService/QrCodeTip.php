<?php

namespace SushiMarket\Sbertips\Services\SbertipsService;

use Illuminate\Support\Facades\Http;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use SushiMarket\Sbertips\Models\RiderTip;

class QrCodeTip extends SberServiceRequest
{

    /**
     * add
     *
     * @param $data
     * @return PromiseInterface|Response
     */
    public static function add($data)
    {
        $response = Http::withToken($data['accessToken'])->post(self::getUrl() . 'qrcode/add', $data);
        self::updateQrCode($response, $data);

        return $response;
    }

    /**
     * update
     *
     * @param $data
     * @return PromiseInterface|Response
     */
    public static function update($data)
    {
        $response = Http::withToken($data['accessToken'])->post(self::getUrl() . 'qrcode/update', $data);
        self::updateQrCode($response, $data);

        return $response;
    }

    /**
     * delete
     *
     * @param $data
     * @return PromiseInterface|Response
     */
    public static function delete($data)
    {
        return Http::withToken($data['accessToken'])->post(
            self::getUrl() . 'qrcode/delete',
            [
                'uuid' => $data['uuid']
            ]
        );
    }

    /**
     * get
     *
     * @param $data
     * @return PromiseInterface|Response
     */
    public static function get($data)
    {
        return Http::withToken($data['accessToken'])->post(
            self::getUrl() . 'qrcode/get',
            [
                'uuid' => $data['uuid']
            ]
        );
    }


    /**
     * list
     *
     * @param $accessToken
     * @return PromiseInterface|Response
     */
    public static function list($accessToken)
    {
        return Http::withToken($accessToken)->post(self::getUrl() . 'qrcode/list');
    }

    /**
     * updateQrCode
     *
     * @param $response
     * @param $data
     * @return void
     */
    protected static function updateQrCode($response, $data)
    {
        if ($response->status() === 200 && $response->json('status') === 'SUCCESS') {
            RiderTip::where('access_token', $data['accessToken'])
                ->update(['qrcode_id' => $response->json('qrCode.uuid')]);
        }
    }
}
