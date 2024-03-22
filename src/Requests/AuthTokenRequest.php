<?php

namespace SushiMarket\Sbertips\Requests;
use SushiMarket\Sbertips\Requests\BaseAjaxRequest;

class AuthTokenRequest extends BaseAjaxRequest
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
    public function rules()
    {
        return [
            'accessCode' => 'required|string',
            'otp'        => 'required|string|size:4',
            'courier_id' => 'required|integer'
        ];
    }
}
