<?php

namespace SushiMarket\Sbertips\Controllers;

use App\Http\Controllers\Controller;
use SushiMarket\Sbertips\Services\SbertipsService\QrCodeTips;

class QrCodeController extends Controller
{
    public function list()
    {
        return QrCodeTips::list();
    }
}