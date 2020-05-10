<?php

namespace App\Console\Notification\Gateways;

use App\Event;
use App\Console\Notification\NotificationTasks;
use App\Presenters\EventPresenter;
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

class FacebookGateway extends AbstractGateway
{
    /**
     * {@inheritdoc}
     */
    public function post($message)
    {
        $pageId = config('foto-diretta.notification.gateway.facebook.page_id', '');
        $token = config('foto-diretta.notification.gateway.facebook.app_token', '');
        $fb = $this->createConnection();

        try {
            $response = $fb->post(
                '/'.$pageId.'/feed',
                ['message' => $message],
                $token
            );
        } catch(FacebookResponseException $e) {
            logger('Graph returned an error: ' . $e->getMessage());
            report($e);
            exit;
        } catch(FacebookSDKException $e) {
            logger('Facebook SDK returned an error: ' . $e->getMessage());
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
        $eventPresenter->organizer = $this->replaceMentions('facebook', $eventPresenter->organizer);
        return $eventPresenter;
    }

    /**
     * @return Facebook\Facebook
     */
    private function createConnection()
    {
        return new Facebook([
          'app_id' => config('foto-diretta.notification.gateway.facebook.app_id', ''),
          'app_secret' => config('foto-diretta.notification.gateway.facebook.app_secret', ''),
          'default_graph_version' => 'v2.10',
        ]);
    }
}
