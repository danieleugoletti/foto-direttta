<?php

namespace App\Console\Notification\Gateways;

use App\Event;
use Illuminate\Database\Eloquent\Collection;

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
    public function formatDailyFullsss(Collection $events, $searchLink)
    {
       return $this->renderView('notifications.dailyFull'.$this->viewSuffix, $events, $searchLink);
    }

    /**
     * @param  Illuminate\Database\Eloquent\Collection $events
     * @param  string     $searchLink
     * @return string
     */
    public function formatDailyShort(Collection $events, $searchLink)
    {
       return $this->renderView('notifications.dailyShort'.$this->viewSuffix, $events, $searchLink);
    }

    /**
     * @param  App\Event  $event
     * @return string
     */
    public function formatBeforeStart(Event $event)
    {
        return (string)view('notifications.beforeStart'.$this->viewSuffix, [
            'event' => $event
        ]);
    }

    /**
     * @param  string $message
     * @return string
     */
    abstract public function post($message);

    /**
     * @param  string     $viewName
     * @param  Collection $events
     * @param  string     $searchLink
     * @return string
     */
    private function renderView($viewName, Collection $events, $searchLink)
    {
        return (string)view($viewName, [
            'events' => $events,
            'searchLink' => $searchLink
        ]);
    }
}
