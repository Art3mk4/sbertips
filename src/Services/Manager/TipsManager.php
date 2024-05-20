<?php

namespace SushiMarket\Sbertips\Services\Manager;

use GuzzleHttp\Exception\InvalidArgumentException;
use Illuminate\Support\Manager;
use SushiMarket\Sbertips\Driver\SbertipsDriver;

class TipsManager extends Manager
{

    public function driver($driver = null)
    {
        $driver = $driver ?: $this->getDefaultDriver();
        if (is_null($driver)) {
            throw new InvalidArgumentException('Driver not specified.');
        }

        return $this->get($driver);
    }

    protected function get($index)
    {
        $drivers = $this->drivers();
        if (in_array($index, array_keys($drivers), true)) {
            $driverName = $drivers[$index];
            return new $driverName();
        }

        throw new InvalidArgumentException("Driver {$index} is not supported.");
    }

    public function getDefaultDriver()
    {
        return 'sbertips';
    }

    protected function drivers(): array
    {
        return [
            'sbertips' => SbertipsDriver::class,
        ];
    }
}
