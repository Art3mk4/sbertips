<?php
namespace SushiMarket\Sbertips\Services\SbertipsService;

use Illuminate\Support\Facades\Http;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;

class CourierCardTip extends SberServiceRequest
{

    /**
     * saveStart
     *
     * @param $data
     * @return PromiseInterface|Response
     */
    public static function saveStart($data)
    {
        return Http::withToken($data['accessToken'])->post(self::getUrl() . 'savecard/start', $data);
    }

    /**
     * saveFinish
     *
     * @param $data
     * @return PromiseInterface|Response
     */
    public static function saveFinish($data)
    {
        return Http::withToken($data['accessToken'])->post(self::getUrl() . 'savecard/finish', $data);
    }

    /**
     * active
     *
     * @param $data
     * @return PromiseInterface|Response
     */
    public static function active($data)
    {
        return Http::withToken($data['accessToken'])->post(self::getUrl() . 'card/active', $data);
    }

    /**
     * delete
     *
     * @param $data
     * @return PromiseInterface|Response
     */
    public static function delete($data)
    {
        return Http::withToken($data['accessToken'])->post(self::getUrl() . 'card/delete', $data);
    }

    /**
     * list
     *
     * @param $accessToken
     * @return PromiseInterface|Response
     */
    public static function list($accessToken)
    {
        return Http::withToken($accessToken)->post(self::getUrl() . 'card/list');
    }
}
