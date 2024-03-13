<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use SushiMarket\Sbertips\Models\Riders;
use Tests\TestCase;

class RouteTest extends TestCase
{

    use WithFaker;

    /**
     * @return void
     */
    /*public function test_qrcode_list_route(): void
    {
        $response = $this->get('/qrcode/list');
        $response->assertStatus(200);
    }*/

    /**
     * @return \Illuminate\Testing\TestResponse
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
     * @param $response
     * @depends test_client_register
     * @return \Illuminate\Testing\TestResponse
     */
    public function test_auth_otp($response)
    {
        $response = $this->post('/sbertips/auth/otp', $this->getAuthOtpData($response->json('client.uuid')));
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
     * @param $response
     * @depends test_auth_otp
     * @return \Illuminate\Testing\TestResponse
     */
    public function test_auth_token($response)
    {
        $response = $this->post('/sbertips/auth/token', $this->getAuthTokenData($response->json('accessCode')));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'requestId',
            'status',
            'accessToken'
        ]);

        return $response;
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
}
