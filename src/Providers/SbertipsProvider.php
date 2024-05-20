<?php

namespace SushiMarket\Sbertips\Providers;
use App\Models\RiderAccessToken;
use Illuminate\Support\ServiceProvider;
use Sbertips\Driver\SbertipsDriver;
use SushiMarket\Sbertips\Models\RiderTip;
use SushiMarket\Sbertips\Services\Manager\TipsManager;
use SushiMarket\Sbertips\Services\SbertipsService\ModelFactory;

class SbertipsProvider extends ServiceProvider
{

    /**
     * @return void
     */
	public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/auth.php', 'sbertips');
        app()->register(SbertipsRouteServiceProvider::class);
        app()->singleton('sbertips', function ($app) {
            return new TipsManager($app);
        });

        app()->singleton('sbertips.driver', function ($app) {
            return $app['sbertips']->driver();
        });

        app()->alias('sbertips.driver', SbertipsDriver::class);
        app()->alias('sbertips', TipsManager::class);
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
        $this->loadRelations();
	}

    protected function loadRelations()
    {
        ModelFactory::getRiderModel()::class::resolveRelationUsing('sbertip', function($riderTipModel) {
            return $riderTipModel->hasOne(RiderTip::class, 'courier_id', 'id');
        });

        ModelFactory::getRiderAccessTokenModel()::class::resolveRelationUsing('rider', function($riderModel) {
            return $riderModel->hasOne(ModelFactory::getRiderModel()::class, 'id', 'rider_id');
        });

        ModelFactory::getOrderModel()::class::resolveRelationUsing('sbertip', function($orderModel) {
            return $orderModel->hasOne(RiderTip::class, 'courier_id', 'CourierID');
        });

        ModelFactory::getOrderModel()::class::resolveRelationUsing('sbercard', function($orderModel) {
            return $orderModel->hasOne(ModelFactory::getCardModel()::class, 'client_id', 'ClientID');
        });
    }
}
