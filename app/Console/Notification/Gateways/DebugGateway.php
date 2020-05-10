<?php

namespace App\Console\Notification\Gateways;

use App\Event;
use App\Console\Notification\NotificationTasks;
use App\Presenters\EventPresenter;

class DebugGateway extends AbstractGateway
{
    /**
     * {@inheritdoc}
     */
    public function post($message)
    {
        echo $message;
    }

    /**
     * {@inheritdoc}
     */
    public function transform(Event $event, $taskName) : EventPresenter
    {
        return $event->getPresenter();
    }
}
