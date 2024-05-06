<?php

namespace SushiMarket\Sbertips\Requests;

use SushiMarket\Sbertips\Requests\BaseAjaxRequest;
use SushiMarket\Sbertips\Services\SbertipsService\RegisterTip;

class ClientRegisterRequest extends BaseAjaxRequest
{

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
        $this->merge(RegisterTip::prepareClient($this->request->all()));
    }
}
