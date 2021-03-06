<?php

return [
    'driver' => 'currency_layer',

    'drivers' => [
        'currency_layer' => [
            'url' => env('DRACMA_CURRENCY_LAYER_URL', 'http://api.currencylayer.com'),
            'access_key' => env('DRACMA_CURRENCY_LAYER_ACCESS_KEY'),
        ],
    ],

    'source' => 'USD',
];
