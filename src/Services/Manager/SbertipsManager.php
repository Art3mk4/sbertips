<?php

namespace SushiMarket\Sbertips\Services\Manager;

use Closure;
use http\Exception\InvalidArgumentException;
use Illuminate\Support\Manager;
use SushiMarket\Sbertips\Driver\SbertipsDriver;

class SbertipsManager extends Manager
{

    public function driver($driver = null)
    {
        $driver = $driver ?: $this->getDefaultDriver();
        if (is_null($driver)) {
            throw new InvalidArgumentException('Driver not specified.');
        }

        return $this->get($driver);
    }

    protected function get($driver)
    {
        return new SbertipsDriver();
    }

    public function getDefaultDriver()
    {
        return 'sbertips';
    }
}
