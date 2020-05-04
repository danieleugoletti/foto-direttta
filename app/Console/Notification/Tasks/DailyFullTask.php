<?php

namespace App\Console\Notification\Tasks;

use App\Event;
use Carbon\Carbon;

class DailyFullTask
{
    use ProcessEventsTrait;

    public function __invoke()
    {
        $events = Event::searchApproved('', Carbon::now()->toDateString())->get();

        $this->processEvents('dailyFull', function($gatewayInstance, $searchLink) use ($events) {
            $gatewayInstance->post($gatewayInstance->formatDailyFull($events, $searchLink));
        });
    }
}


