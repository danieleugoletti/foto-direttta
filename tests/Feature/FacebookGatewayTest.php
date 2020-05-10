<?php

namespace Tests\Feature;

use App\Console\Notification\Gateways\FacebookGateway;
use App\Console\Notification\NotificationTasks;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FacebookGatewayTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_metion_organizer()
    {
        config([
            'foto-diretta.notification.gateway.facebook.mentions' => [
                'Foto Diretta' => '@[fotodiretta]'
            ]]);

        $event = $this->eventFactory(['organizer' => 'Foto Diretta']);
        $gatewway = new FacebookGateway('');
        $presenter = $gatewway->transform($event, NotificationTasks::DAILY_SHORT);
        $this->assertEquals('@[fotodiretta]', $presenter->organizer);
    }
}
