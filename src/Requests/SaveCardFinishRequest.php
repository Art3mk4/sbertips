<?php

namespace SushiMarket\Sbertips\Requests;
use SushiMarket\Sbertips\Requests\BaseAjaxRequest;

class SaveCardFinishRequest extends BaseAjaxRequest
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
