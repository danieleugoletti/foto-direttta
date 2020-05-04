<?php

namespace App\Console\Notification\Tasks;

use App\Event;
use Carbon\Carbon;


class BeforeStartTask
{
    use ProcessEventsTrait;

    /**
     * @var string
     */
    private $minutesBeforeStart;

    public function __construct($minutesBeforeStart)
    {
        $this->minutesBeforeStart = $minutesBeforeStart;
    }

    public function __invoke()
    {
        $events = Event::onLiveSoon($this->minutesBeforeStart)->get();

        $this->processEvents('beforeStart', function($gatewayInstance, $searchLink) use ($events) {
            $events->map(function($event) use ($gatewayInstance, $searchLink) {
                $gatewayInstance->post($gatewayInstance->formatBeforeStart($event));
            });
        });
    }
}

