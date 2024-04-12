<?php
namespace SushiMarket\Sbertips\Services\SbertipsService;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use SushiMarket\Sbertips\Models\ResponseStatus;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Str;

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
        return Http::withHeaders(['X-bank-id' => 'GENERAL'])->post(self::getUrl() . 'transfer/secure/register', array_merge(self::getData(), $data));
    }

    /**
     * transferSecureFinish
     *
     * @param $data
     * @return PromiseInterface|Response
     */
    public static function transferSecureFinish($data)
    {
        return Http::withHeaders(['X-bank-id' => 'GENERAL'])->post(self::getUrl() . 'transfer/secure/finish', array_merge(self::getData(), $data));
    }

    /**
     * transferPayment
     *
     * @param $data
     * @return PromiseInterface|Response
     */
    public static function transferPayment($data)
    {
        return Http::withHeaders(['X-bank-id' => 'GENERAL'])->post(self::getUrl() . 'transfer/payment', array_merge(self::getData(), $data));
    }

    /**
     * sbertipsPayment
     *
     * @param $data
     * @return PromiseInterface|Response
     */
    public static function sbertipsPayment($data)
    {
        $order = ModelFactory::getOrderModel()->findOrFail($data['order_id']);
        $riderTip = $order->sbertip;

        if (is_null($riderTip) || !$riderTip->saved_card) {
            throw new NotFoundHttpException("The courier didn't save the card");
        }

        $client = $order->client;
        if (is_null($client) || !$client->sbercard) {
            throw new NotFoundHttpException("The client didn't save the card: ");
        }

        $data['transactionNumber'] = Str::uuid()->toString();
        $data['currency'] = "643";
        $data['qrUuid'] = $riderTip->qrcode_id;
        $data['binding'] = [
            'bindingId' => isset($data['binding_id']) ? $data['binding_id'] : $client->sbercard->token,
            'clientId'  => $client->external_id
        ];

        unset($data['binding_id']);
        unset($data['order_id']);
        $registerResponse = self::transferSecureRegister($data);
        if ($registerResponse->json('status') == ResponseStatus::FAIL->value) {
            return $registerResponse;
        }

        return self::transferPayment([
            'transactionNumber' => $data['transactionNumber'],
            'qrUuid'            => $data['qrUuid'],
            'source'            => [
                'binding' => $data['binding']
            ],
            'amount' => [
                'transactionAmount' => $data['amount'],
                'currency' => $data['currency']
            ],
            'feeSender' => isset($data['feeSender']) ? $data['feeSender'] : false,
            'ssl' => isset($data['ssl']) ? $data['ssl'] : false
        ]);
    }
}
