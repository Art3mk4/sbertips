<?php
namespace SushiMarket\Sbertips\Services\SbertipsService;

use \Illuminate\Config\Repository;
use \Illuminate\Contracts\Foundation\Application as ContractsFoundationApplication;
use \Illuminate\Foundation\Application as FoundationApplication;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ModelFactory
{

    /**
     * @return Repository|ContractsFoundationApplication|FoundationApplication|mixed
     */
    public static function getRiderModel()
    {
        return self::loadModel('sbertips.models.Rider');
    }

    /**
     * @return Repository|ContractsFoundationApplication|FoundationApplication|mixed
     */
    public static function getOrderModel()
    {
        return self::loadModel('sbertips.models.Order');
    }

    public static function getClientModel()
    {
        return self::loadModel('sbertips.models.Client');
    }

    public static function getCardModel()
    {
        return self::loadModel('sbertips.models.Card');
    }

    /**
     * @param $configName
     * @return Repository|ContractsFoundationApplication|FoundationApplication|mixed
     */
    public static function loadModel($configName)
    {
        $class = config($configName);
        if (!class_exists($class)) {
            throw new NotFoundHttpException('Model not found: ' . $configName);
        }

        return new $class();
    }
}
