<?php

namespace App\Console\Notification\Tasks;

use Carbon\Carbon;
use App\Console\Notification\Gateways\AbstractGateway;

trait ProcessEventsTrait
{
    /**
     * @param  string $taskName
     * @param  callable $callback
     */
    private function processEvents($taskName, callable $callback)
    {
        $now = Carbon::now()->toDateString();
        $searchLink = route_qs('index', [], true, ['date' => $now]);
        $gateways = config('foto-diretta.notification.'.$taskName.'.gateway');

        collect($gateways)->map(function($gatewayName) use ($searchLink, $callback) {
            $gatewayClass = config('foto-diretta.notification.gateway.'.$gatewayName.'.class');

            $gatewayInstance = $gatewayClass instanceof AbstractGateway ?
                                    $gatewayClass :
                                    new $gatewayClass(config('foto-diretta.notification.gateway.'.$gatewayName.'.viewSuffix'));

            $callback($gatewayInstance, $searchLink);
        });
    }
}

