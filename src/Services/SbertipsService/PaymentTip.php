<?php
namespace SushiMarket\Sbertips\Services\SbertipsService;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class PaymentTip extends SberServiceRequest
{

    /**
     * transferSecureRegister
     * 
     * @param $data
     * @return PromiseInterface|Response
     */
    public static function transferSecureRegister($data)
    {
        $data['credentials']['login'] = self::getMerchantLogin();
        $data['credentials']['password'] = self::getPassword();
        return Http::withHeaders(['X-bank-id' => 'GENERAL'])->post(self::getUrl() . 'transfer/secure/register', $data);
    }

    /**
     * transferSecureFinish
     *
     * @param $data
     * @return PromiseInterface|Response
     */
    public static function transferSecureFinish($data)
    {
        $data['credentials']['login'] = self::getMerchantLogin();
        $data['credentials']['password'] = self::getPassword();
        return Http::withHeaders(['X-bank-id' => 'GENERAL'])->post(self::getUrl() . 'transfer/secure/finish', $data);
    }

    /**
     * transferPayment
     *
     * @param $data
     * @return PromiseInterface|Response
     */
    public static function transferPayment($data)
    {
        $data['credentials']['login'] = self::getMerchantLogin();
        $data['credentials']['password'] = self::getPassword();
        return Http::withHeaders(['X-bank-id' => 'GENERAL'])->post(self::getUrl() . 'transfer/payment', $data);
    }
}
