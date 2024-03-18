<?php

namespace SushiMarket\Sbertips\Controllers;

use Faker\Provider\Payment;
use Illuminate\Routing\Controller;
use SushiMarket\Sbertips\Requests\TransferPaymentRequest;
use SushiMarket\Sbertips\Requests\TransferSecureFinishRequest;
use SushiMarket\Sbertips\Requests\TransferSecureRegisterRequest;
use SushiMarket\Sbertips\Services\SbertipsService\PaymentTip;

class TransferController extends Controller
{
    public function secureRegister(TransferSecureRegisterRequest $request)
    {
        return PaymentTip::transferSecureRegister($request->all());
    }

    public function secureFinish(TransferSecureFinishRequest $request)
    {
        return PaymentTip::transferSecureFinish($request->all());
    }

    public function payment(TransferPaymentRequest $request)
    {
        return PaymentTip::transferPayment($request->all());
    }
}
