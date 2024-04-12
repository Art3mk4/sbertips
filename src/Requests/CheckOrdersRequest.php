<?php

namespace SushiMarket\Sbertips\Requests;
use SushiMarket\Sbertips\Requests\BaseAjaxRequest;

class CheckOrdersRequest extends BaseAjaxRequest
{
    /**
     * @return bool
     */
    public function authorize():bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_id' => 'required|integer'
        ];
    }
}
