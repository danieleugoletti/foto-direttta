<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class EventPresenterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_will_format_date_in_parts()
    {
        Carbon::setLocale('en');
        $presenter = $this->eventFactory(['date' => '2020-02-02 02:02'])->getPresenter();
        $this->assertEquals('Sunday 2', $presenter->day);
        $this->assertEquals('February', $presenter->month);
        $this->assertEquals('2:02 AM', $presenter->time);
    }

    /**
     * @test
     */
    public function it_will_format_description_in_html()
    {
        $presenter = $this->eventFactory(['description' => 'http://acme.com'])->getPresenter();
        $this->assertEquals('<p><a href="http://acme.com">http://acme.com</a></p>'.PHP_EOL, $presenter->descriptionHtml);
    }

    /**
     * @test
     */
    public function it_will_guess_event_type()
    {
        $presenter1 = $this->eventFactory(['url' => 'http://facebook.com'])->getPresenter();
        $presenter2 = $this->eventFactory(['url' => 'http://instagram.com'])->getPresenter();
        $this->assertEquals(__('foto-diretta.event-type-facebook'), $presenter1->type);
        $this->assertEquals(__('foto-diretta.event-type-instagram'), $presenter2->type);
    }
}
