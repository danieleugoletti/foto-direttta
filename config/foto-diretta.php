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
];
