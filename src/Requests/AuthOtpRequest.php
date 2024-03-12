<?php

namespace SushiMarket\Sbertips\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthOtpRequest extends FormRequest
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