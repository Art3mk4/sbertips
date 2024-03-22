<?php

namespace SushiMarket\Sbertips\Providers;
use Illuminate\Support\ServiceProvider;

class SbertipsProvider extends ServiceProvider
{

    /**
     * @return void
     */
	public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/auth.php', 'sbertips');
        app()->register(SbertipsRouteServiceProvider::class);
	}

    /**
     * @return void
     */
	public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/auth.php' => config_path('sbertips.php')
        ]);

        $this->loadMigrationsFrom(__DIR__ . '/../Migrations');
	}
}
