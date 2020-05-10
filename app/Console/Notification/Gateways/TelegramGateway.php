<?php

namespace App\Console\Notification\Gateways;

use App\Event;
use App\Console\Notification\NotificationTasks;
use App\Presenters\EventPresenter;
use Abraham\TwitterOAuth\TwitterOAuth;
use Abraham\TwitterOAuth\TwitterOAuthException;

class TelegramGateway extends AbstractGateway
{
    /**
     * {@inheritdoc}
     */
    public function post($message)
    {
        $apiToken = config('foto-diretta.notification.gateway.telegram.api_token', '');

        $data = [
            'chat_id' => config('foto-diretta.notification.gateway.telegram.chat_id', ''),
            'text' => $message
        ];

        try {
            file_get_contents('https://api.telegram.org/bot'.$apiToken.'/sendMessage?' . http_build_query($data) );
        } catch(\Exception $e) {
            logger('Telegram returned an error: ' . $e->getMessage());
            report($e);
            exit;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function transform(Event $event, $taskName) : EventPresenter
    {
        return $event->getPresenter();
    }
}
