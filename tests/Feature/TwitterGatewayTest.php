<?php

namespace Tests\Feature;

use App\Console\Notification\Gateways\TwitterGateway;
use App\Console\Notification\NotificationTasks;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TwitterGatewayTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_remove_description_from_event()
    {
        $event = $this->eventFactory(['title' => 'Test', 'description' => 'Test']);
        $gatewway = new TwitterGateway('');
        $presenter = $gatewway->transform($event, NotificationTasks::DAILY_SHORT);
        $this->assertEquals('', $presenter->description);
    }

    /**
     * @test
     */
    public function it_metion_organizer()
    {
        config([
            'foto-diretta.notification.gateway.twitter.mentions' => [
                'Foto Diretta' => '@fotodiretta'
            ]]);

        $event = $this->eventFactory(['organizer' => 'Foto Diretta']);
        $gatewway = new TwitterGateway('');
        $presenter = $gatewway->transform($event, NotificationTasks::DAILY_SHORT);
        $this->assertEquals('@fotodiretta', $presenter->organizer);
    }
}
