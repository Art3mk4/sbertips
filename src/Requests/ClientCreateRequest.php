<?php

namespace SushiMarket\Sbertips\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientCreateRequest extends FormRequest
{

    /**
     * @return true
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
            'firstName'     => 'required|string',
            'lastName'      => 'required|string',
            'gender'        => 'required|string|in:MALE,FEMALE',
            'email'         => 'required|email',
            'phone'         => 'numeric|min:11|max:11'
        ];
    }
}