<?php

namespace SushiMarket\Sbertips\Requests;
use SushiMarket\Sbertips\Requests\QrCodeRequest;

class QrCodeUpdateRequest extends QrCodeRequest
{

    /**
     * @return string[]
     */
    public function rules()
    {
        return array_merge(
            ['uuid' => 'required|string'],
            parent::rules()
        );
    }
}
