<?php

return [
    'metadata' => [
        'title' => env('APP_NAME'),
        'descrition' => '',
        'url' => env('APP_URL'),
        'imageSocial' => '',
        'image' => '',
        'twitterCard' => 'summary',
    ],
    'search' => [
        'timeOffset' => '1h'
    ],
    'navigation' => function(){
        return [
            ['label' => 'About', 'url' => route('page', 'about')],
            ['label' => 'Other page', 'url' => route('page', 'about').'#heading-2'],
        ];
    },
    'calendar' => [
        'alertMinutesBefore' => 10
    ],
    'notification' => [
        'gateway' => [
            'facebook' => [
                'app_id' => env('FACEBOOK_APP_ID', ''),
                'app_secret' => env('FACEBOOK_APP_SECRET', ''),
                'app_token' => env('FACEBOOK_APP_TOKEN', ''),
                'page_id' => env('FACEBOOK_PAGE_ID', ''),
                'class' => App\Console\Notification\Gateways\FacebookGateway::class
            ],
            'twitter' => [
                'consumer_key' => env('TWITTER_CONSUMER_KEY', ''),
                'consumer_secret' => env('TWITTER_CONSUMER_SECRET', ''),
                'access_token' => env('TWITTER_ACCESS_TOKEN', ''),
                'access_token_secret' => env('TWITTER_ACCESS_TOKEN_SECRET', ''),
                'class' => App\Console\Notification\Gateways\TwitterGateway::class
            ],
            'debug' => [
                'viewSuffix' => '',
                'class' => App\Console\Notification\Gateways\DebugGateway::class
            ],
        ],
        'dailyFull' => [
            'gateway' => [],
            'runAt' => '08:00',
        ],
        'dailyShort' => [
            'gateway' => [],
            'runAt' => '08:00',
        ],
        'beforeStart' => [
            'gateway' => [],
            'minutesBeforeStart' => '10',
        ],
    ]
];
