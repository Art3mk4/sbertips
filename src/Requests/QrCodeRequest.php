<?php

namespace SushiMarket\Sbertips\Requests;
use Illuminate\Foundation\Http\FormRequest;

class QrCodeRequest extends FormRequest
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
            'accessToken' => 'required|string',
            'title'       => 'required|string',
            'jobPosition' => 'in:' . implode(',', $this->getJobPositions()),
            'company'     => 'required|string',
            'text'        => 'string',
            'amounts'     => 'array',
            'amounts.*'   => 'integer',
            'teamUuid'    => 'string'
        ];
    }

    /**
     * @return string[]
     */
    public function getJobPositions()
    {
        return [
            "jobPosition.waiter", "jobPosition.courier", "jobPosition.streamer",
            "jobPosition.employee", "jobPosition.beautyMaster", "jobPosition.admin",
            "jobPosition.barber", "jobPosition.barista", "jobPosition.barman",
            "jobPosition.cleaner", "jobPosition.cook", "jobPosition.driver",
            "jobPosition.fitness", "jobPosition.gasStation", "jobPosition.maid",
            "jobPosition.musician", "jobPosition.universal", "jobPosition.assembler",
            "jobPosition.other"
        ];
    }
}
