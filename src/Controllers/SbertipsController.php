<?php

namespace SushiMarket\Sbertips\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SbertipsController extends Controller
{
	public function index()
    {
		return response(json_encode(config('sbertips')), 200)->header('Content-Type', 'text/plain');
	}
}
