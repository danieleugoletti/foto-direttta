<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class CalendarTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_will_return_a_calendar_with_alarm()
    {
        $presenter = $this->eventFactory(['title' => 'Test', 'description' => 'Test', 'organizer' => 'Test'])->getPresenter();

        $response = $this->get($presenter->calendarUrl);
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'text/calendar; charset=UTF-8');

        $content = $response->streamedContent();

        $this->assertStringContainsString('SUMMARY:'.$presenter->title, $content);
        $this->assertStringContainsString('ORGANIZER:'.$presenter->organizer, $content);
        $this->assertStringContainsString('DESCRIPTION:'.$presenter->description, $content);
        $this->assertStringContainsString('TRIGGER:-PT10M', $content);
    }

}
