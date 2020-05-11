<?php

namespace App\Console\Notification\Gateways;

use App\Event;
use App\Console\Notification\NotificationTasks;
use App\Presenters\EventPresenter;

use Illuminate\Support\Collection;

abstract class AbstractGateway
{
    /**
     * @var string
     */
    protected $viewSuffix = '';

    public function __construct($viewSuffix)
    {
        $this->viewSuffix = $viewSuffix;
    }

    /**
     * @param  Illuminate\Database\Eloquent\Collection $events
     * @param  string     $searchLink
     * @return string
     */
    public function formatDailyFull(Collection $events, $searchLink)
    {
        $trasformedEvents = $events->map(function($event){
            return $this->transform($event, NotificationTasks::DAILY_FULL);
        });
        return $this->renderView(NotificationTasks::DAILY_FULL, $trasformedEvents, $searchLink);
    }

    /**
     * @param  Illuminate\Database\Eloquent\Collection $events
     * @param  string     $searchLink
     * @return string
     */
    public function formatDailyShort(Collection $events, $searchLink)
    {
        $trasformedEvents = $events->map(function($event){
            return $this->transform($event, NotificationTasks::DAILY_SHORT);
        });
        return $this->renderView(NotificationTasks::DAILY_SHORT, $trasformedEvents, $searchLink);
    }

    /**
     * @param  App\Event  $event
     * @return string
     */
    public function formatBeforeStart(Event $event)
    {
        return (string)view('notifications.'.NotificationTasks::BEFORE_START.$this->viewSuffix, [
            'event' => $this->transform($event, NotificationTasks::BEFORE_START)
        ]);
    }

    /**
     * @param  string $message
     * @return string
     */
    abstract public function post($message);

    /**
     * @param  Event  $event
     * @param  string $taskName
     * @return EventPresenter
     */
    abstract public function transform(Event $event, $taskName) : EventPresenter;

    /**
     * @param  string $gatewayName
     * @param  string $value
     * @return string
     */
    protected function replaceMentions($gatewayName, $value)
    {
        $mentions = config('foto-diretta.notification.gateway.'.$gatewayName.'.mentions');
        return str_replace(array_keys($mentions), array_values($mentions), $value);
    }

    /**
     * @param  string     $taskName
     * @param  Collection $events
     * @param  string     $searchLink
     * @return string
     */
    private function renderView($taskName, Collection $events, $searchLink)
    {
        return (string)view('notifications.'.$taskName.$this->viewSuffix, [
            'events' => $events,
            'searchLink' => $searchLink
        ]);
    }
}
