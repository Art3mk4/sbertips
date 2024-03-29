<?php

namespace SushiMarket\Sbertips\Requests;
use SushiMarket\Sbertips\Requests\BaseAjaxRequest;

class TransferSecureRegisterRequest extends BaseAjaxRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "transactionNumber"    => "required|string",
            "qrUuid"               => "required|string",
            "amount"               => "required|integer",
            "currency"             => "required|string",
            "binding"              => "array",
            "binding.bindingId"    => "required_with:binding|string",
            "binding.clientId"     => "required_with:bindging|string",
            "feeSender"            => "boolean"
        ];
    }
}
