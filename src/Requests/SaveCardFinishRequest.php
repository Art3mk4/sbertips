<?php

namespace SushiMarket\Sbertips\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SushiMarket\Sbertips\Models\RiderTip;
use SushiMarket\Sbertips\Requests\BaseAjaxRequest;

class SaveCardFinishRequest extends BaseAjaxRequest
{

    public function __construct(public Request $baseRequest)
    {
    }

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
            "paRes"               => "string"
        ];
    }

    /**
     * prepareForValidation
     *
     * @return void
     */
    public function prepareForValidation(): void
    {
        $riderToken = ModelFactory::getRiderAccessTokenModel()::where(
            'token', $this->baseRequest->bearerToken()
        )->first(['rider_id']);
        $riderTip = RiderTip::where('courier_id', $riderToken->rider_id)->get()->first();
        if ($riderTip) {
            $this->merge([
                'accessToken' => $this->input('accessToken', $riderTip->access_token)
            ]);
        }
    }
}
