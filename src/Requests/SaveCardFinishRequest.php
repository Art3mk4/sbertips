<?php

namespace SushiMarket\Sbertips\Requests;
use Illuminate\Support\Str;
use SushiMarket\Sbertips\Models\RiderTip;
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
            "paRes"               => "string",
            "courier_id"          => "integer"
        ];
    }

    /**
     * prepareForValidation
     *
     * @return void
     */
    public function prepareForValidation(): void
    {
        $riderTip = RiderTip::where('courier_id', $this->input('courier_id'))->get()->first();
        if ($riderTip) {
            $this->merge([
                'accessToken' => $this->input('accessToken', $riderTip->access_token)
            ]);
        }
    }
}
