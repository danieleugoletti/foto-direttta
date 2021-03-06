<?php

namespace App\Console\Notification\Gateways;

use App\Event;
use App\Console\Notification\NotificationTasks;
use App\Presenters\EventPresenter;
use Abraham\TwitterOAuth\TwitterOAuth;
use Abraham\TwitterOAuth\TwitterOAuthException;

class TwitterGateway extends AbstractGateway
{
    /**
     * {@inheritdoc}
     */
    public function post($message)
    {
        $consumerKey = config('foto-diretta.notification.gateway.twitter.consumer_key', '');
        $consumerSecret = config('foto-diretta.notification.gateway.twitter.consumer_secret', '');
        $accessToken = config('foto-diretta.notification.gateway.twitter.access_token', '');
        $accessTokenSecret = config('foto-diretta.notification.gateway.twitter.access_token_secret', '');

        try {
            $connection = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);
            $connection->post("statuses/update", ["status" => $message]);
            if ($connection->getLastHttpCode() != 200) {
                logger('Twitter returned an error: '.$connection->getLastBody()->errors[0]->message);
                exit;
            }
        } catch(TwitterOAuthException $e) {
            logger('Twitter SDK returned an error: ' . $e->getMessage());
            report($e);
            exit;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function transform(Event $event, $taskName) : EventPresenter
    {
        $eventPresenter = $event->getPresenter();
        $eventPresenter->description = '';
        $eventPresenter->organizer = $this->replaceMentions('twitter', $eventPresenter->organizer);
        return $eventPresenter;
    }
}
