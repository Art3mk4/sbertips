<?php

namespace SushiMarket\Sbertips\Requests;
use SushiMarket\Sbertips\Requests\BaseAjaxRequest;

class SbertipsPaymentRequest extends BaseAjaxRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'order_id'             => 'required|integer',
            "transactionNumber"    => "required|string",
            "amount"               => "required|integer",
            "currency"             => "required|string",
            "binding"              => "array",
            "binding.bindingId"    => "required_with:binding|string",
            "binding.clientId"     => "required_with:bindging|string",
            "feeSender"            => "boolean"
        ];
    }
}
