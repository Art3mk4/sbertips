<?php

namespace SushiMarket\Sbertips\Requests;
use Illuminate\Foundation\Http\FormRequest;

class SaveCardFinishRequest extends FormRequest
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
    public function rules()
    {
        return [
            "accessToken"         => "required|string",
            "mdOrder"             => "required|string",
            "transactionNumber"   => "required|string|min:0|max:32",
            "paRes"               => "string"
        ];
    }
}
