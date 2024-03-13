<?php

namespace SushiMarket\Sbertips;

class Sbertips
{
    public function __construct()
    {

    }

    public function example()
    {
        return 'Sbertips integration package version is:' . config('sbertips.version');
    }
}