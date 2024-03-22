<?php

namespace SushiMarket\Sbertips\Requests;
use SushiMarket\Sbertips\Requests\BaseAjaxRequest;

class AuthOtpRequest extends BaseAjaxRequest
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
            'merchantLogin' => 'required|string',
            'uuid'          => 'required|string|min:32'
        ];
    }
}
