<?php

namespace SushiMarket\Sbertips\Requests;

use SushiMarket\Sbertips\Requests\BaseAjaxRequest;

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
}
