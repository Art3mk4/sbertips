<?php

namespace SushiMarket\Sbertips\Requests;
use Illuminate\Http\Request;
use SushiMarket\Sbertips\Requests\BaseAjaxRequest;
use SushiMarket\Sbertips\Services\SbertipsService\ModelFactory;
use SushiMarket\Sbertips\Services\SbertipsService\RegisterTip;

class AuthTokenRequest extends BaseAjaxRequest
{

    public function __construct(public Request $baseRequest)
    {
    }

    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return string[]
     */
    public function rules()
    {
        return [
            'accessCode' => 'required|string',
            'otp'        => 'required|string|size:4',
            'courier_id' => 'required|integer'
        ];
    }

    /**
     * prepareForValidation
     *
     * @return void
     */
    public function prepareForValidation(): void
    {
        $riderToken = ModelFactory::getRiderAccessTokenModel()::where(
            'token', $this->baseRequest->bearerToken()
        )->first(['rider_id']);
        if (!$riderToken) {
            return;
        }
        $this->request->add(['courier_id' => $riderToken->rider_id]);
        $this->merge(RegisterTip::prepareClient($this->request->all()));
    }
}
