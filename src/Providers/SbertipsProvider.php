<?php

namespace SushiMarket\Sbertips\Providers;
use Illuminate\Support\ServiceProvider;
use SushiMarket\Sbertips\Models\RiderTip;
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
            return $riderTipModel->hasOne(RiderTip::class);
        });

        ModelFactory::getOrderModel()::class::resolveRelationUsing('sbertip', function($riderTipModel) {
            return $riderTipModel->hasOne(RiderTip::class, 'courier_id', 'CourierID');
        });

        ModelFactory::getClientModel()::class::resolveRelationUsing('sbercard', function($clientModel) {
            return $clientModel->hasOne(ModelFactory::getCardModel()::class, 'client_id', 'id');
        });
    }
}
