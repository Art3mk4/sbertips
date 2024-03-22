<?php

namespace SushiMarket\Sbertips\Requests;
use SushiMarket\Sbertips\Requests\BaseAjaxRequest;

class TransferPaymentRequest extends BaseAjaxRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "transactionNumber"          => "required|string",
            "qrUuid"                     => "required|string",
            "source"                     => "required|array",
            "source.card"                => "array",
            "source.card.pan"            => "required_with:source.card|string",
            "source.card.expiryDate"     => "required_with:source.card|string",
            "source.card.cardholderName" => "string",
            "source.card.cvc"            => "required_with:source.card|string",
            "source.appleToken"          => "string",
            "source.samsungToken"        => "string",
            "source.seToken"             => "string",
            "source.binding"             => "array",
            "source.binding.bindingId"   => "required_with:source.binding|string",
            "source.binding.clientId"    => "required_with:source.binding|string",
            "amount"                     => "required|array",
            "amount.transactionAmount"   => "required|integer",
            "amount.currency"            => "required|string",
            "feeSender"                  => "boolean",
            "ssl"                        => "boolean"
        ];
    }
}
