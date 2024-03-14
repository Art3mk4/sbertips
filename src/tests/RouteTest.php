<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use SushiMarket\Sbertips\Models\Riders;
use SushiMarket\Sbertips\Models\RiderTips;
use Illuminate\Testing\TestResponse;
use SushiMarket\Sbertips\Requests\QrCodeRequest;
use Tests\TestCase;

class RouteTest extends TestCase
{

    use WithFaker;

    protected $accessToken;
    protected $transactionNumber;

    public function setUp():void
    {
        parent::setUp();
        $this->accessToken = RiderTips::all()->random()->access_token;
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
            "courier_id"    => Riders::all()->random()->first()->id
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
            "courier_id" => Riders::all()->random()->id
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
