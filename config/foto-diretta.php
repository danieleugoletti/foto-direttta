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
