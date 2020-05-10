<?php

namespace App\Console\Notification\Tasks;

use App\Event;
use Carbon\Carbon;

class DailyShortTask
{
    use ProcessEventsTrait;

    /**
     * @param  Carbon|null $now
     */
    public function __invoke(Carbon $now=null)
    {
        $now = $this->nowDate($now);
        $events = Event::daily($now->toDateString())->get();

        $this->processEvents('dailyShort', function($gatewayInstance, $searchLink) use ($events) {
            if (!$events->count()) return;
            $gatewayInstance->post($gatewayInstance->formatDailyShort($events, $searchLink));
        });
    }
}

