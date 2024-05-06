<?php

namespace SushiMarket\Sbertips\Requests;
use Illuminate\Support\Str;
use SushiMarket\Sbertips\Models\RiderTip;
use SushiMarket\Sbertips\Requests\BaseAjaxRequest;
use SushiMarket\Sbertips\Services\SbertipsService\ModelFactory;

class SaveCardStartRequest extends BaseAjaxRequest
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
            "transactionNumber"   => "required|string|min:0|max:32",
            "card"                => "array",
            "card.pan"            => "required_with:card|string",
            "card.expiryDate"     => "required_with:card|string",
            "card.cardholderName" => "required_with:card|string",
            "card.cvc"            => "required_with:card|string",
            "returnUrl"           => "required|array",
            "returnUrl.success"   => "required|string",
            "returnUrl.fail"      => "string",
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
                'accessToken' => $this->input('accessToken', $riderTip->access_token),
                'transactionNumber' => $this->input('transactionNumber', Str::random(32)),
            ]);
        }
    }
}
