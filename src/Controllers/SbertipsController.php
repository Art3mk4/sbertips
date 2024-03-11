<?php

namespace SushiMarket\Sbertips\Controllers;

use Illuminate\Http\Request;

class SbertipsController
{
	public function index()
    {
		return response('test index', 200)->header('Content-Type', 'text/plain');
	}
}
