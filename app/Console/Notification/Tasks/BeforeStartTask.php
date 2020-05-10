<?php

namespace App\Console\Notification\Tasks;

use App\Event;
use Carbon\Carbon;


class BeforeStartTask
{
    use ProcessEventsTrait;

    /**
     * @param  Carbon|null $now
     */
    public function __invoke(Carbon $now=null)
    {
        $now = $this->nowDate($now);
        $minutesBeforeStart = config('foto-diretta.notification.beforeStart.minutesBeforeStart');
        $events = Event::onLiveSoon($now, $minutesBeforeStart)->get();

        $this->processEvents('beforeStart', function($gatewayInstance, $searchLink) use ($events) {
            if (!$events->count()) return;
            $events->map(function($event) use ($gatewayInstance, $searchLink) {
                $gatewayInstance->post($gatewayInstance->formatBeforeStart($event));
            });
        });
    }
}

