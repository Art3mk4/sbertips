<?php

namespace SushiMarket\Sbertips\Requests;
use Illuminate\Foundation\Http\FormRequest;

class AccessTokenRequest extends FormRequest
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
