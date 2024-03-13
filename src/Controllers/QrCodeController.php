<?php

namespace SushiMarket\Sbertips\Controllers;

use App\Http\Controllers\Controller;
use SushiMarket\Sbertips\Requests\AccessTokenRequest;
use SushiMarket\Sbertips\Services\SbertipsService\QrCodeTips;

class QrCodeController extends Controller
{
    public function list(AccessTokenRequest $request)
    {
        return QrCodeTips::list($request->input('accessToken'));
    }
}
