<?php

namespace App\Console\Notification\Gateways;

use App\Event;
use Illuminate\Database\Eloquent\Collection;

class DebugGateway extends AbstractGateway
{
    /**
     * {@inheritdoc}
     */
    public function post($message)
    {
        echo $message;
    }
}
