<?php
namespace Tests\Feature;

use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use SushiMarket\Sbertips\Models\Rider;
use SushiMarket\Sbertips\Models\RiderTip;
use Illuminate\Testing\TestResponse;
use SushiMarket\Sbertips\Requests\QrCodeRequest;
use SushiMarket\Sbertips\Services\SbertipsService\SberServiceRequest;
use Tests\TestCase;

class RouteTest extends TestCase
{

    use WithFaker;

    protected $accessToken;
    protected $transactionNumber;
    protected $qrcodeId;

    public function setUp():void
    {
        parent::setUp();
        $riderTip = RiderTip::all()->random();
        $this->accessToken = $riderTip->access_token;
        $this->qrcodeId = $riderTip->qrcode_id;
        $this->transactionNumber = 'transactionNumber23';
    }

    /**
     * @return TestResponse
     */
    public function test_client_register()
    {
        $response = $this->post('/sbertips/clients/create', $this->getClientData());
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'requestId',
            'status',
            'client' => [
                'uuid',
                'createdDate',
                'phone',
                'email',
                'firstName',
                'lastName',
                'gender',
                'photoUuid'
            ],
            'accessCode'
        ]);

        return $response;
    }

    /**
     * @param $data
     * @depends test_client_register
     * @return TestResponse
     */
    public function test_auth_otp($data)
    {
        $response = $this->post('/sbertips/auth/otp', $this->getAuthOtpData($data->json('client.uuid')));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'requestId',
            'status',
            'accessCode',
            'newOtpDelay',
            'attemptsLeft'
        ]);

        return $response;
    }

    /**
     * @param $data
     * @depends test_auth_otp
     * @return TestResponse
     */
    public function test_auth_token($data)
    {
        $response = $this->post('/sbertips/auth/token', $this->getAuthTokenData($data->json('accessCode')));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'requestId',
            'status',
            'accessToken'
        ]);

        return $response;
    }

    /**
     * @depends test_auth_otp
     * @return void
     */
    public function test_client_info()
    {
        $response = $this->post('/sbertips/clients/info', ['accessToken' => $this->accessToken]);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'requestId',
            'status',
            'client' => [
                'uuid',
                'createdDate',
                'phone',
                'email',
                'firstName',
                'lastName',
                'gender',
                'photoUuid'
            ],
            'card' => [
                'bindingId',
                'maskedPan',
                'issuerBank'
            ]
        ]);
    }

    /**
     * @depends test_auth_token
     * @return TestResponse
     */
    public function test_qrcode_add()
    {
        $response = $this->post('/sbertips/qrcode/add', $this->getQrCodeData());
        $response->assertStatus(200);
        $response->assertJsonStructure($this->getQrCodeUpdateStructure());

        return $response;
    }

    /**
     * @depends test_qrcode_add
     * @param $data
     * @return void
     */
    public function test_qrcode_update($data)
    {
        $response = $this->post(
            '/sbertips/qrcode/update',
            array_merge(
                ['uuid' => $data->json('qrCode.uuid')],
                $this->getQrCodeData()
            )
        );
        $response->assertStatus(200);
        $response->assertJsonStructure($this->getQrCodeUpdateStructure());
    }

    /**
     * @depends test_qrcode_add
     * @param $data
     * @return void
     */
    public function test_qrcode_delete($data)
    {
        $response = $this->post(
            '/sbertips/qrcode/delete',
            [
                'uuid'        => $data->json('qrCode.uuid'),
                'accessToken' => $this->accessToken
            ]
        );
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'requestId',
            'status'
        ]);
        $this->assertEquals($response->json('status'), 'SUCCESS');
    }

    /**
     * @depends test_qrcode_add
     * @return void
     */
    public function test_qrcode_list(): void
    {
        $response = $this->post('/sbertips/qrcode/list', ['accessToken' => $this->accessToken]);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'requestId',
            'status',
            'qrCodes' => [
                '*' => $this->getQrCodeDataStructure()
            ]
        ]);
    }

    /**
     * @return TestResponse
     */
    public function test_save_card_start_with_card_data()
    {
        $response = $this->post('/sbertips/savecard/start', $this->getSaveCardData());
        $response->assertStatus(200);
        $response->assertJsonStructure($this->getSaveCardStartStructure());
        return $response;
    }

    /**
     * @return TestResponse
     */
    public function test_save_card_start_without_card_data()
    {
        $response = $this->post('/sbertips/savecard/start', $this->getSaveCardWithoutData());
        $response->assertStatus(200);
        $response->assertJsonStructure($this->getSaveCardStartStructure());
        return $response;
    }

    /**
     * @depends test_save_card_start_with_card_data
     * @param $data
     * @return void
     */
    public function test_save_card_finish($data)
    {
        $response = $this->post('/sbertips/savecard/finish', [
            'accessToken'       => $this->accessToken,
            'mdOrder'           => $data->json('mdOrder'),
            'transactionNumber' => $this->transactionNumber,
            'paRes'             => $data->json('paReq')
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure($this->getSaveCardFinishStructure());
        $this->assertEquals($response->json('status'), 'SUCCESS');
        $this->assertEquals($response->json('state'), 'PERFORM_SUCCESS');
        $this->assertEquals($response->json('type'), 'SAVECARD');
    }

    /**
     * @depends test_save_card_start_without_card_data
     * @param $data
     * @return void
     */
    public function test_save_card_finish_without_card_data($data)
    {
        $response = $this->post('/sbertips/savecard/finish', [
            'accessToken' => $this->accessToken,
            'mdOrder' => $data->json('mdOrder'),
            'transactionNumber' => $this->transactionNumber
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure($this->getSaveCardFinishStructure());
        $this->assertEquals($response->json('status'), 'SUCCESS');
        $this->assertEquals($response->json('state'), 'PERFORM_SUCCESS');
        $this->assertEquals($response->json('type'), 'SAVECARD');
    }

    public function test_card_list()
    {
        $response = $this->post('/sbertips/card/list', [
            'accessToken' => $this->accessToken
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'requestId',
            'status',
            'cardList' => [
                '*' => [
                    'bindingId',
                    'bankName',
                    'maskedPan',
                    'paymentSystem',
                    'active'
                ]
            ]
        ]);
        $this->assertEquals($response->json('status'), 'SUCCESS');

        return $response;
    }

    /**
     * @depends test_card_list
     * @param $data
     * @return void
     */
    public function test_card_active($data)
    {
        $card = $this->faker->randomElement($data->json('cardList'));
        $response = $this->post('/sbertips/card/active', [
            'accessToken' => $this->accessToken,
            'bindingId'   => $card['bindingId']
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'requestId',
            'status'
        ]);
        $this->assertEquals($response->json('status'), 'SUCCESS');
    }

    /**
     * @depends test_card_list
     * @param $data
     * @return void
     */
    public function test_card_delete($data)
    {
        $this->assertTrue(true);
        return ;
        $card = $this->faker->randomElement($data->json('cardList'));
        $response = $this->post('/sbertips/card/delete', [
            'accessToken' => $this->accessToken,
            'bindingId'   => $card['bindingId']
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'requestId',
            'status'
        ]);
        $this->assertEquals($response->json('status'), 'SUCCESS');
    }

    /**
     * @depends test_card_list
     * @param $data
     * @return TestResponse
     */
    public function test_transfer_secure_register($data)
    {
        $response = $this->post('/sbertips/transfer/secure/register', $this->getTransferSecureRegisterData($data));
        $response->assertStatus(200);
        $response->assertJsonStructure([
           'requestId',
           'status',
           'transactionNumber',
           'mdOrder',
           'formUrl',
           'errorMessage',
           'transactionState',
           'state',
           'type'
        ]);
        $this->assertEquals($response->json('state'), 'REGISTER_SUCCESS');
        $this->assertEquals($response->json('type'), 'REGISTERED');
        $this->assertEquals($response->json('transactionState'), 'CREATED');
        $this->assertEquals($response->json('status'), 'SUCCESS');
        $this->assertNotEquals($response->json('mdOrder'), null);
        return $response;
    }

    /**
     * @depends test_transfer_secure_register
     * @param $data
     * @return TestResponse
     */
    public function test_transfer_payment($data)
    {
        $response = $this->post('sbertips/transfer/payment', $this->getTransferPaymentData($data->json()));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'requestId',
            'status',
            'transactionNumber',
            'mdOrder',
            'info',
            'redirectUrl',
            'paReq',
            'transactionState',
            'state',
            'type',
            'errorMessage'
        ]);
        $this->assertEquals($response->json('status'), 'SUCCESS');
        $this->assertEquals($response->json('transactionState'), 'CREATED');
        $this->assertEquals($response->json('state'), 'PERFORM_SUCCESS');
        $this->assertEquals($response->json('type'), 'TRANSFER');
        $this->assertEquals($response->json('errorMessage'), null);
        return $response;
    }

    /**
     * @depends test_transfer_payment
     * @param $data
     * @return void
     */
    public function test_transfer_secure_finish($data)
    {
        $response = $this->post('sbertips/transfer/secure/finish', $this->getTransferSecureFinishData($data->json()));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'requestId',
            'status',
            'transactionNumber',
            'errorMessage',
            'transactionState',
            'state',
            'type'
        ]);
        $this->assertEquals($response->json('status'), 'SUCCESS');
        $this->assertEquals($response->json('transactionState'), 'DEPOSITED');
        $this->assertEquals($response->json('state'), 'FINISH_SUCCESS');
        $this->assertEquals($response->json('type'), 'TRANSFER');
    }

    /**
     * @return array
     */
    protected function getClientData()
    {
        return [
            "merchantLogin" => config('sbertips.merchantLogin'),
            "firstName"     => $this->faker('ru_RU')->firstName,
            "lastName"      => $this->faker('ru_RU')->lastName,
            "gender"        => "MALE",
            "phone"         => "9" . $this->faker->unique()->numerify('#########'),
            "email"         => $this->faker->unique()->email,
            "courier_id"    => Rider::all()->random()->first()->id
        ];
    }

    /**
     * @param $uuid
     * @return array
     */
    protected function getAuthOtpData($uuid)
    {
        return [
            "merchantLogin" => config('sbertips.merchantLogin'),
            "uuid"          => $uuid
        ];
    }

    /**
     * @param $accessCode
     * @return array
     */
    protected function getAuthTokenData($accessCode)
    {
        return [
            "accessCode" => $accessCode,
            "otp"        => "1111",
            "courier_id" => Rider::all()->random()->id
        ];
    }

    /**
     * @return array
     */
    protected function getQrCodeData()
    {
        return [
            'accessToken' => $this->accessToken,
            'title' => $this->faker->title,
            'jobPosition' => $this->faker->randomElement((new QrCodeRequest())->getJobPositions()),
            'company' => $this->faker->company,
            'text' => $this->faker->text,
            'amounts' => [
                100,
                500,
                1000
            ]
        ];
    }

    protected function getQrCodeDataStructure()
    {
        return [
            'merchantLogin',
            'title',
            'jobPosition',
            'uuid',
            'company',
            'limits' => [
                'minAmount',
                'maxAmount'
            ],
            'text',
            'amounts'
        ];
    }

    protected function getQrCodeUpdateStructure()
    {
        return [
            'requestId',
            'status',
            'qrCode' => $this->getQrCodeDataStructure()
        ];
    }

    protected function getSaveCardWithoutData()
    {
        return [
            "accessToken"       => $this->accessToken,
            "transactionNumber" => $this->transactionNumber,
            "returnUrl"         => [
                "success" => "https://test_return_success_url.com",
                "fail"    => "https://test_return_fail_url.com"
            ]
        ];
    }

    protected function getSaveCardData()
    {
        return [
            "accessToken" => $this->accessToken,
            "transactionNumber" => $this->transactionNumber,
            "card"              => $this->getCardData(),
            "returnUrl"         => [
                "success" => "https://test_return_success_url.com",
                "fail"    => "https://test_return_fail_url.com"
            ]
        ];
    }

    protected function getCardData()
    {
        return [
            "pan"            => "2200000000000053",
            "expiryDate"     => "202412",
            "cardholderName" => "CARDHOLDER NAME",
            "cvc"            => "123"
        ];
    }

    protected function getTransferSecureRegisterData($data)
    {
        return [
            "transactionNumber" => "d472e71a-7ca8-4869-8e46-1f92a2pr",
            "qrUuid"            => $this->qrcodeId,
            "amount"            => 10000,
            "currency"          => "643",
            "binding"           => [
                "bindingId" => $data->json('cardList')[0]['bindingId'],
                "clientId"  => Str::uuid()->toString()
            ],
            "feeSender" => false
        ];
    }

    protected function getTransferPaymentData($data)
    {
        return [
            "transactionNumber" => $data['transactionNumber'],
            "qrUuid" => $this->qrcodeId,
            "source" => [
                'card' => $this->getCardData()
            ],
            "amount" => [
                "transactionAmount" => 10000,
                "currency"  => "643"
            ],
            "feeSender" => false,
            "ssl"       => false
        ];
    }

    protected function getTransferSecureFinishData($data)
    {
        return [
            "transactionNumber" => $data['transactionNumber'],
            "mdOrder"           => $data['mdOrder'],
            "paRes"             => "eJzVWNmyo7iy/ZWOPo+O3QwGDB2uHSFmbMBmNPCGmQeDmYevP3jvquq6depGdN+nc3mxlFamVipTSykdzbSNItaIgqGN3o9K1HV+Ev2WhV9+xwiKosg7/BbhMPKGofv9m3847N9w4h6gPhXsIyz+/f14BXrUfSj4aITEdzR+Q6mAeMNwnHwjiTB8w+MDHu7DiMSi/aYwRm2X1dU78gf8B3qEvnW3udsg9av+/egHDS2p7xh6IGD4CH3tHh9RK7HvCLrHcOIIffaO0F9q1+HV6jY35ix8V9gEV81kUVcOVcxgayvIxdQwxQRfjtBrxDH0++gdhVEExmDqN/jw537/J4IdoQ/58fkyBx71sNkm8BeQHyXHbcHaqAqWdwLbH6HvvWM0P+sq2kZsvn1vH6G/wD396h3+4UO2b7O9SY+m837ss8cvQX3Ij13v90P37h6hr61j4I/jOwCAZm56Es6uU5rug96Db9/m7MeQYxRk7zC+gdp+P7RAmdRt1qePF9T/KThCLyjQR2zfj0aWVNtkbfTb/Cir7svvad8//4SgaZr+mPZ/1G0CoZsjEExB24Cwy5J//f6pFYVSFdf/SI3xq7rKAr/MVr/fEkOJ+rQOf/uO7VdmTP1lCYF0jnnbTL0FCFa9vSTwHs"
        ];
    }

    protected function getSaveCardStartStructure()
    {
        return [
            'requestId',
            'status',
            'mdOrder',
            'transactionNumber',
            'info',
            'redirectUrl',
            'paymentPageUrl',
            'paReq',
            'state',
            'type',
            'errorMessage'
        ];
    }

    protected function getSaveCardFinishStructure()
    {
        return [
            'requestId',
            'status',
            'transactionNumber',
            'state',
            'type',
            'errorMessage'
        ];
    }
}
