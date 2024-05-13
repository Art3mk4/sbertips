<?php
namespace SushiMarket\Sbertips\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use SushiMarket\Sbertips\Models\ResponseStatus;
use SushiMarket\Sbertips\Services\SbertipsService\PaymentTip;

class PaymentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $response;

    public function __construct(protected array $data)
    {
    }

    public function handle()
    {
        $registerResponse = PaymentTip::transferSecureRegister($this->data);
        if ($registerResponse->json('status') == ResponseStatus::FAIL->value) {
            $this->logMessage($registerResponse);
        }

        $paymentResponse = PaymentTip::transferPayment([
            'transactionNumber' => $this->data['transactionNumber'],
            'qrUuid'            => $this->data['qrUuid'],
            'source'            => [
                'binding' => $this->data['binding']
            ],
            'amount' => [
                'transactionAmount' => $this->data['amount'],
                'currency' => $this->data['currency']
            ],
            'feeSender' => isset($this->data['feeSender']) ? $this->data['feeSender'] : false,
            'ssl' => isset($this->data['ssl']) ? $this->data['ssl'] : false
        ]);
        $this->logMessage($paymentResponse);
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param $response
     * @return void
     */
    protected function logMessage($response)
    {
        $this->response = $response;
        if ($response->json('status') == ResponseStatus::FAIL->value) {
            Log::error(
                $response->json('error.message'),
                [
                    'error' => $response->json(),
                    'data'  => $this->data
                ]
            );
        } else {
            Log::info('payment status: ' . $response->json('status'),
                [
                    'response'  => $response->json(),
                    'data'      => $this->data
                ]
            );
        }
    }
}
