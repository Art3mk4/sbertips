<?php

return [
    'url'              => env('SBERTIPS_URL'),
    'merchantLogin'    => env('SBERTIPS_MERCHANT_LOGIN'),
    'merchantPassword' => env('SBERTIPS_MERCHANT_PASSWORD'),
    'version'          => '1.2.5',
    'auth'             => [
        'bearerToken'  => env('SBERTIPS_API_TOKEN')
    ]
];
