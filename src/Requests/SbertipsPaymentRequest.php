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
            'order_id'   => 'required|integer',
            'binding_id' => 'string',
            'amount'     => 'required|integer',
            'feeSender'  => 'boolean'
        ];
    }
}
