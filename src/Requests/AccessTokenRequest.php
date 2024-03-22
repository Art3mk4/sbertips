<?php

namespace SushiMarket\Sbertips\Requests;
use SushiMarket\Sbertips\Requests\BaseAjaxRequest;

class AccessTokenRequest extends BaseAjaxRequest
{
    /**
     * @return bool
     */
    public function authorize():bool
    {
        return true;
    }

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'accessToken' => 'required|string'
        ];
    }
}
