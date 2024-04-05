<?php

return [
    'url'              => env('SBERTIPS_URL'),
    'merchantLogin'    => env('SBERTIPS_MERCHANT_LOGIN'),
    'merchantPassword' => env('SBERTIPS_MERCHANT_PASSWORD'),
    'version'          => '1.3.8',
    'auth'             => [
        'bearerToken'  => env('SBERTIPS_API_TOKEN')
    ],
    'models' => [
        'Rider'   => env('SBERTIPS_RIDER_MODEL'),
        'Order'   => env('SBERTIPS_ORDER_MODEL'),
        'Card'    => env('SBERTIPS_CARD_MODEL'),
        'Client'  => env('SBERTIPS_CLIENT_MODEL')
    ]
];
