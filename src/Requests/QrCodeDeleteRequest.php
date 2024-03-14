<?php

namespace SushiMarket\Sbertips\Requests;
use SushiMarket\Sbertips\Requests\AccessTokenRequest;

class QrCodeDeleteRequest extends AccessTokenRequest
{

    /**
     * @return string[]
     */
    public function rules():array
    {
        return array_merge(
            ['uuid' => 'required|string'],
            parent::rules()
        );
    }
}
