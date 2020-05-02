<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['foto-diretta.search.timeOffset' => '1h']);
    }

    /**
     * @test
     */
    public function it_will_return_no_results()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSeeText(__('foto-diretta.no-result'));
    }

    /**
     * @test
     */
    public function it_will_return_results()
    {
        $events = $this->eventFactory([], 2);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSeeText($events[0]->title);
        $response->assertSeeText($events[1]->title);
    }

    /**
     * @test
     */
    public function it_will_search_by_title()
    {
        $event1 = $this->eventFactory(['title' => 'Event title']);
        $event2 = $this->eventFactory(['title' => 'Dummy title']);

        $response = $this->get('/?search=Event');
        $response->assertStatus(200);
        $response->assertSeeText($event1->title);
        $response->assertDontSeeText($event2->title);
    }

    /**
     * @test
     */
    public function it_will_no_found_search_by_title()
    {
        $event1 = $this->eventFactory(['title' => 'Event title']);

        $response = $this->get('/?search=abcd1234');
        $response->assertStatus(200);
        $response->assertSeeText(__('foto-diretta.no-result'));
    }

    /**
     * @test
     */
    public function it_will_search_by_description()
    {
        $event1 = $this->eventFactory(['description' => 'Event description']);
        $event2 = $this->eventFactory(['description' => 'Dummy description']);

        $response = $this->get('/?search=Event');
        $response->assertStatus(200);
        $response->assertSeeText($event1->description);
        $response->assertDontSeeText($event2->description);
    }

    /**
     * @test
     */
    public function it_will_search_by_yesterday_and_get_error()
    {
        $yesterday = Carbon::yesterday();

        $response = $this->get('/?date='.$yesterday->toDateString());
        $response->assertStatus(200);
        $response->assertSeeText(__('foto-diretta.wrong-date'));
    }

     /**
     * @test
     */
    public function it_will_search_by_date()
    {
        $tomorrow = Carbon::tomorrow();
        $event1 = $this->eventFactory(['title' => 'Event title 1', 'date' => $tomorrow->toDateString()]);
        $event2 = $this->eventFactory(['title' => 'Event title 2', 'date' => Carbon::now()]);

        $response = $this->get('/?date='.$tomorrow->toDateString());
        $response->assertStatus(200);
        $response->assertSeeText($event1->title);
        $response->assertDontSeeText($event2->title);
    }


    /**
     * @test
     */
    public function it_will_search_hide_past_event_in_a_day()
    {
        config(['foto-diretta.search.timeOffset' => '']);
        $event1 = $this->eventFactory(['title' => 'Event title']);
        $event2 = $this->eventFactory(['title' => 'Dummy title', 'date' => Carbon::now()->sub('1h')]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSeeText($event1->title);
        $response->assertDontSeeText($event2->title);
    }

    /**
     * @test
     */
    public function it_will_search_show_past_event_in_a_day_due_to_config_time_offset()
    {
        $event1 = $this->eventFactory(['title' => 'Event title']);
        $event2 = $this->eventFactory(['title' => 'Dummy title',
                'date' => Carbon::now()->sub(config('foto-diretta.search.timeOffset'))]);

        $response = $this->get('/?search=Event');
        $response->assertStatus(200);
        $response->assertSeeText($event1->title);
        $response->assertDontSeeText($event2->title);
    }

}
