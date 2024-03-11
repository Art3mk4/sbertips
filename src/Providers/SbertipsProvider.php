<?php

namespace SuschiMarket\Sbertips\Providers;

use Illuminate\Support\ServiceProvider;

class SbertipsProvider extends ServiceProvider
{

	public function register()
	{

	}

	public function boot()
	{
		$this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
	}
	
}
