<?php
namespace SushiMarket\Sbertips\Controllers;

use Illuminate\Routing\Controller;
use SushiMarket\Sbertips\Requests\TransferPaymentRequest;
use SushiMarket\Sbertips\Requests\TransferSecureFinishRequest;
use SushiMarket\Sbertips\Requests\TransferSecureRegisterRequest;
use SushiMarket\Sbertips\Requests\SbertipsPaymentRequest;
use SushiMarket\Sbertips\Services\SbertipsService\PaymentTip;

class TransferController extends Controller
{

    /**
     * secureRegister
     *
     * @param TransferSecureRegisterRequest $request
     * @return array|mixed
     */
    public function secureRegister(TransferSecureRegisterRequest $request)
    {
        return PaymentTip::transferSecureRegister($request->all())->json();
    }

    /**
     * secureFinish
     *
     * @param TransferSecureFinishRequest $request
     * @return array|mixed
     */
    public function secureFinish(TransferSecureFinishRequest $request)
    {
        return PaymentTip::transferSecureFinish($request->all())->json();
    }

    /**
     * payment
     *
     * @param TransferPaymentRequest $request
     * @return array|mixed
     */
    public function payment(TransferPaymentRequest $request)
    {
        return PaymentTip::transferPayment($request->all())->json();
    }

    public function sbertipsPayment(SbertipsPaymentRequest $request)
    {
        $data = PaymentTip::prepareData($request->all());
        PaymentTip::sbertipsPaymentDispatch($data);
        return PaymentTip::fakeResponse($data['transactionNumber']);
    }
}
