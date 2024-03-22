<?php

namespace SushiMarket\Sbertips\Requests;
use SushiMarket\Sbertips\Requests\BaseAjaxRequest;

class SaveCardStartRequest extends BaseAjaxRequest
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
            "transactionNumber"   => "required|string|min:0|max:32",
            "card"                => "array",
            "card.pan"            => "required_with:card|string",
            "card.expiryDate"     => "required_with:card|string",
            "card.cardholderName" => "required_with:card|string",
            "card.cvc"            => "required_with:card|string",
            "returnUrl"           => "required|array",
            "returnUrl.success"   => "required|string",
            "returnUrl.fail"      => "string"
        ];
    }
}
