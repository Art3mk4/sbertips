<?php

namespace SushiMarket\Sbertips\Requests;
use SushiMarket\Sbertips\Requests\AccessTokenRequest;

class CardActiveRequest extends AccessTokenRequest
{

    /**
     * @return string[]
     */
    public function rules():array
    {
        return array_merge(
            ['bindingId' => 'required|string'],
            parent::rules()
        );
    }
}
