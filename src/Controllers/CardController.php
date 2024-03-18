<?php

namespace SushiMarket\Sbertips\Controllers;

use App\Http\Controllers\Controller;
use SushiMarket\Sbertips\Requests\CardActiveRequest;
use SushiMarket\Sbertips\Requests\SaveCardFinishRequest;
use SushiMarket\Sbertips\Requests\SaveCardStartRequest;
use SushiMarket\Sbertips\Requests\AccessTokenRequest;
use SushiMarket\Sbertips\Services\SbertipsService\CourierCardTip;

class CardController extends Controller
{

    public function saveStart(SaveCardStartRequest $request)
    {
        return CourierCardTip::saveStart($request->all());
    }

    public function saveFinish(SaveCardFinishRequest $request)
    {
        return CourierCardTip::saveFinish($request->all());
    }

    public function active(CardActiveRequest $request)
    {
        return CourierCardTip::active($request->all());
    }

    public function delete(CardActiveRequest $request)
    {
        return CourierCardTip::delete($request->all());
    }

    public function list(AccessTokenRequest $request)
    {
        return CourierCardTip::list($request->input('accessToken'));
    }
}
