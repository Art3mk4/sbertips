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
        if (!isset($data['teamUuid'])) {
            $data['teamUuid'] = self::getTeamUuid();
        }
        $response = self::class::withToken($data['accessToken'])->post(self::getUrl() . 'qrcode/add', $data);
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
        $response = self::class::withToken($data['accessToken'])->post(self::getUrl() . 'qrcode/update', $data);
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
        return self::class::withToken($data['accessToken'])->post(
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
        return self::class::withToken($data['accessToken'])->post(
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
        return self::class::withToken($accessToken)->post(self::getUrl() . 'qrcode/list');
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


    /**
     * settings
     *
     * @param $data
     * @return mixed
     */
    public static function settings($id)
    {
        $order = ModelFactory::getOrderModel()::select([
            'id as order_id',
            'CourierID'
        ])->with('sbertip')->findOrFail($id);

        $settings = self::get([
            'accessToken' => $order->sbertip->access_token,
            'uuid' => $order->sbertip->qrcode_id
        ]);

        return response()->json([
            'status' => $settings->json('status'),
            'payments' => $settings->json('qrCode.amounts')
        ], $settings->status());
    }
}
