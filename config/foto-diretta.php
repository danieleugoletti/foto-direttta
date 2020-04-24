<?php

return [
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
