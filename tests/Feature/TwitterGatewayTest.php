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

}
