<?php

namespace App\Console\Notification\Tasks;

use App\Event;
use Carbon\Carbon;

class DailyShortTask
{
    use ProcessEventsTrait;

    public function __invoke()
    {
        $events = Event::searchApproved('', Carbon::now()->toDateString())->get();

        $this->processEvents('dailyShort', function($gatewayInstance, $searchLink) use ($events) {
            $gatewayInstance->post($gatewayInstance->formatDailyShort($events, $searchLink), $searchLink);
        });
    }
}

