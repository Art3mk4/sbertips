<?php

namespace SushiMarket\Sbertips\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientCreateRequest extends FormRequest
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
            'firstName'     => 'required|string',
            'lastName'      => 'required|string',
            'gender'        => 'string|in:MALE,FEMALE',
            'email'         => 'required|email',
            'phone'         => 'required|string|size:10',
            'courier_id'    => 'required|integer'
        ];
    }
}
