<?php

namespace App\Console\Notification\Tasks;

use App\Event;
use Carbon\Carbon;

class DailyFullTask
{
    use ProcessEventsTrait;


    public function __invoke(Carbon $now=null)
    {
        $now = $this->nowDate($now);
        $events = Event::daily($now->toDateString())->get();

        $this->processEvents('dailyFull', function($gatewayInstance, $searchLink) use ($events) {
            if (!$events->count()) return;
            $gatewayInstance->post($gatewayInstance->formatDailyFull($events, $searchLink));
        });
    }
}


