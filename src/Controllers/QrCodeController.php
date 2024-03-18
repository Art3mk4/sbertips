<?php

namespace SushiMarket\Sbertips\Controllers;

use App\Http\Controllers\Controller;
use SushiMarket\Sbertips\Requests\AccessTokenRequest;
use SushiMarket\Sbertips\Requests\QrCodeDeleteRequest;
use SushiMarket\Sbertips\Requests\QrCodeRequest;
use SushiMarket\Sbertips\Requests\QrCodeUpdateRequest;
use SushiMarket\Sbertips\Services\SbertipsService\QrCodeTip;

class QrCodeController extends Controller
{

    public function add(QrCodeRequest $request)
    {
        return QrCodeTip::add($request->all());
    }

    public function update(QrCodeUpdateRequest $request)
    {
        return QrCodeTip::update($request->all());
    }

    public function delete(QrCodeDeleteRequest $request)
    {
        return QrCodeTip::delete($request->all());
    }

    public function list(AccessTokenRequest $request)
    {
        return QrCodeTip::list($request->input('accessToken'));
    }
}
