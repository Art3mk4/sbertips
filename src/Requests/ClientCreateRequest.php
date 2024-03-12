<?php

namespace SushiMarket\Sbertips\Requests;

class ClientCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'phone' => 'required|min:11|max:11'
        ];
    }
}