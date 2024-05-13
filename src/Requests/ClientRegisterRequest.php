<?php

namespace SushiMarket\Sbertips\Requests;

use Illuminate\Http\Request;
use SushiMarket\Sbertips\Requests\BaseAjaxRequest;
use SushiMarket\Sbertips\Services\SbertipsService\ModelFactory;
use SushiMarket\Sbertips\Services\SbertipsService\RegisterTip;

class ClientRegisterRequest extends BaseAjaxRequest
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
    public function rules(): array
    {
        return [
            'firstName'     => 'string',
            'lastName'      => 'string',
            'gender'        => 'string|in:MALE,FEMALE',
            'email'         => 'required|email',
            'phone'         => 'string|size:10',
            'courier_id'    => 'required|integer'
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
