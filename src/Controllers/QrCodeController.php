<?php
namespace SushiMarket\Sbertips\Controllers;

use Illuminate\Routing\Controller;
use SushiMarket\Sbertips\Requests\AccessTokenRequest;
use SushiMarket\Sbertips\Requests\QrCodeDeleteRequest;
use SushiMarket\Sbertips\Requests\QrCodeRequest;
use SushiMarket\Sbertips\Requests\QrCodeUpdateRequest;
use SushiMarket\Sbertips\Services\SbertipsService\QrCodeTip;

class QrCodeController extends Controller
{

    /**
     * add
     *
     * @param QrCodeRequest $request
     * @return array|mixed
     */
    public function add(QrCodeRequest $request)
    {
        return QrCodeTip::add($request->all())->json();
    }

    /**
     * update
     *
     * @param QrCodeUpdateRequest $request
     * @return array|mixed
     */
    public function update(QrCodeUpdateRequest $request)
    {
        return QrCodeTip::update($request->all())->json();
    }

    /**
     * delete
     *
     * @param QrCodeDeleteRequest $request
     * @return array|mixed
     */
    public function delete(QrCodeDeleteRequest $request)
    {
        return QrCodeTip::delete($request->all())->json();
    }

    /**
     * get
     *
     * @param QrCodeGetRequest $request
     * @return array|mixed
     */
    public function get(QrCodeGetRequest $request)
    {
        return QrCodeTip::get($request->all())->json();
    }

    /**
     * list
     *
     * @param AccessTokenRequest $request
     * @return array|mixed
     */
    public function list(AccessTokenRequest $request)
    {
        return QrCodeTip::list($request->input('accessToken'))->json();
    }
}
