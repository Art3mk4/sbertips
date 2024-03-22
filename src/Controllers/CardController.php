<?php
namespace SushiMarket\Sbertips\Controllers;

use Illuminate\Routing\Controller;
use SushiMarket\Sbertips\Requests\CardActiveRequest;
use SushiMarket\Sbertips\Requests\SaveCardFinishRequest;
use SushiMarket\Sbertips\Requests\SaveCardStartRequest;
use SushiMarket\Sbertips\Requests\AccessTokenRequest;
use SushiMarket\Sbertips\Services\SbertipsService\CourierCardTip;

class CardController extends Controller
{

    /**
     * saveStart
     *
     * @param SaveCardStartRequest $request
     * @return mixed
     */
    public function saveStart(SaveCardStartRequest $request)
    {
        return CourierCardTip::saveStart($request->all())->json();
    }

    /**
     * saveFinish
     *
     * @param SaveCardFinishRequest $request
     * @return mixed
     */
    public function saveFinish(SaveCardFinishRequest $request)
    {
        return CourierCardTip::saveFinish($request->all())->json();
    }

    /**
     * active
     *
     * @param CardActiveRequest $request
     * @return mixed
     */
    public function active(CardActiveRequest $request)
    {
        return CourierCardTip::active($request->all())->json();
    }

    /**
     * delete
     *
     * @param CardActiveRequest $request
     * @return array|mixed
     */
    public function delete(CardActiveRequest $request)
    {
        return CourierCardTip::delete($request->all())->json();
    }

    /**
     * list
     *
     * @param AccessTokenRequest $request
     * @return mixed
     */
    public function list(AccessTokenRequest $request)
    {
        return CourierCardTip::list($request->input('accessToken'))->json();
    }
}
