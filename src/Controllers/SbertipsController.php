<?php

namespace SushiMarket\Sbertips\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SbertipsController extends Controller
{
	public function index()
    {
		return response('test index test hoho', 200)->header('Content-Type', 'text/plain');
	}
}
