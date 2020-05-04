<?php

namespace App\Console\Notification\Gateways;

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
