<?php
namespace SushiMarket\Sbertips\Services\SbertipsService;

use Illuminate\Support\Facades\Http;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Http\JsonResponse;
use SushiMarket\Sbertips\Models\ResponseStatus;
use SushiMarket\Sbertips\Models\RiderTip;

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
        return self::class::withToken($data['accessToken'])->post(self::getUrl() . 'savecard/start', $data);
    }

    /**
     * saveFinish
     *
     * @param $data
     * @return PromiseInterface|Response
     */
    public static function saveFinish($data)
    {
        $response = self::class::withToken($data['accessToken'])->post(self::getUrl() . 'savecard/finish', $data);
        if ($response->json('status') === ResponseStatus::SUCCESS->value) {
            RiderTip::where('access_token', $data['accessToken'])->update(['saved_card' => true]);
        }
        return $response;
    }

    /**
     * active
     *
     * @param $data
     * @return PromiseInterface|Response
     */
    public static function active($data)
    {
        return self::class::withToken($data['accessToken'])->post(self::getUrl() . 'card/active', $data);
    }

    /**
     * delete
     *
     * @param $data
     * @return PromiseInterface|Response
     */
    public static function delete($data)
    {
        return self::class::withToken($data['accessToken'])->post(self::getUrl() . 'card/delete', $data);
    }

    /**
     * list
     *
     * @param $accessToken
     * @return PromiseInterface|Response
     */
    public static function list($accessToken)
    {
        return self::class::withToken($accessToken)->post(self::getUrl() . 'card/list');
    }
}
