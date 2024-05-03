<?php

return [
    'url'              => env('SBERTIPS_URL'),
    'merchantLogin'    => env('SBERTIPS_MERCHANT_LOGIN'),
    'merchantPassword' => env('SBERTIPS_MERCHANT_PASSWORD'),
    'teamUuid'         => env('SBERTIPS_TEAM_UUID'),
    'fakePayment'      => env('SBERTIPS_FAKE_PAYMENT'),
    'version'          => '1.4.3',
    'auth'             => [
        'bearerToken'  => env('SBERTIPS_API_TOKEN'),
        'enableLog'    => env('SBERTIPS_API_ENABLE_LOG', false),
    ],
    'models' => [
        'Rider'   => env('SBERTIPS_RIDER_MODEL'),
        'Order'   => env('SBERTIPS_ORDER_MODEL'),
        'Card'    => env('SBERTIPS_CARD_MODEL'),
        'Client'  => env('SBERTIPS_CLIENT_MODEL')
    ]
];