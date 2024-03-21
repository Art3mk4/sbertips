<?php

namespace SushiMarket\Sbertips\Services\Auth;

class SbertipsApiService
{

    public function checkBearerToken($token)
    {
        if (config('sbertips.auth.bearerToken') !== $token) {
            return null;
        }

        return $this;
    }

    public function getAuthIdentifier()
    {
        return null;
    }
}
