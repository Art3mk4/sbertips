<?php

namespace SushiMarket\Sbertips\Requests;
use Illuminate\Foundation\Http\FormRequest;

class TransferSecureFinishRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "transactionNumber"    => "required|string",
            "mdOrder"              => "required|string",
            "paRes"                => "required|string"
        ];
    }
}
