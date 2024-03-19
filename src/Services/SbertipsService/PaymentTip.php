<?php

namespace SushiMarket\Sbertips\Services\SbertipsService;

use Illuminate\Support\Facades\Http;

class PaymentTip extends SberServiceRequest
{

    public static function transferSecureRegister($data)
    {
        $data['credentials']['login'] = self::getMerchantLogin();
        $data['credentials']['password'] = self::getPassword();
        return response(Http::withHeaders(['X-bank-id' => 'GENERAL'])->post(self::getUrl() . 'transfer/secure/register', $data));
    }

    public static function transferSecureFinish($data)
    {
        $data['credentials']['login'] = self::getMerchantLogin();
        $data['credentials']['password'] = self::getPassword();
        return response(Http::withHeaders(['X-bank-id' => 'GENERAL'])->post(self::getUrl() . 'transfer/secure/finish', $data));
    }

    public static function transferPayment($data)
    {
        $data['credentials']['login'] = self::getMerchantLogin();
        $data['credentials']['password'] = self::getPassword();
        return response(Http::withHeaders(['X-bank-id' => 'GENERAL'])->post(self::getUrl() . 'transfer/payment', $data));
    }
}
