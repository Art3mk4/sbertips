<?php

namespace SushiMarket\Sbertips\Controllers;

use App\Http\Controllers\Controller;
use SushiMarket\Sbertips\Requests\CardActiveRequest;
use SushiMarket\Sbertips\Requests\SaveCardFinishRequest;
use SushiMarket\Sbertips\Requests\SaveCardStartRequest;
use SushiMarket\Sbertips\Requests\AccessTokenRequest;
use SushiMarket\Sbertips\Services\SbertipsService\CourierCardTips;

class CardController extends Controller
{

    public function saveStart(SaveCardStartRequest $request)
    {
        return CourierCardTips::saveStart($request->all());
    }

    public function saveFinish(SaveCardFinishRequest $request)
    {
        return CourierCardTips::saveFinish($request->all());
    }

    public function active(CardActiveRequest $request)
    {
        return CourierCardTips::active($request->all());
    }

    public function delete(CardActiveRequest $request)
    {
        return CourierCardTips::delete($request->all());
    }

    public function list(AccessTokenRequest $request)
    {
        return CourierCardTips::list($request->input('accessToken'));
    }
}
