<?php

namespace SushiMarket\Sbertips\Requests;
use SushiMarket\Sbertips\Requests\BaseAjaxRequest;

class TransferSecureFinishRequest extends BaseAjaxRequest
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
