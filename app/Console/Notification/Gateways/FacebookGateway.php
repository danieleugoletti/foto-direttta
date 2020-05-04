<?php

namespace App\Console\Notification\Gateways;

use Facebook\Facebook;

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
        } catch(FacebookExceptionsFacebookResponseException $e) {
            logger('Graph returned an error: ' . $e->getMessage());
            report($e);
            exit;
        } catch(FacebookExceptionsFacebookSDKException $e) {
            logger('Facebook SDK returned an error: ' . $e->getMessage());
            report($e);
            exit;
        }
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
