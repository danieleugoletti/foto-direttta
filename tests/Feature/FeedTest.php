<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class FeedTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_will_return_a_feed()
    {
        $event = $this->eventFactory(['title' => 'Test', 'description' => 'Test']);

        $response = $this->get('/feed');
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/xml;charset=UTF-8');
        $response->assertSee('<title><![CDATA['.$event->title.']]></title>', false);
    }

}
