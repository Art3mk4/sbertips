<?php

namespace SushiMarket\Sbertips\Requests;
use Illuminate\Foundation\Http\FormRequest;

class AuthTokenRequest extends FormRequest
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
