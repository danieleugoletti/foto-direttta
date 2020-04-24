<?php

namespace App\Http\Livewire;

use App\Event;
use App\Helpers\HashidHelper;
use Livewire\Component;
use Carbon\Carbon;

class EventCard extends Component
{
    public $event;
    public $day;
    public $month;
    public $time;
    public $type;
    public $calendarUrl;

    public function mount(Event $event)
    {
        $hashids = resolve('Helpers\HashidHelper');

        $this->event = $event;
        $date = Carbon::create($event->date);
        $this->day = $date->isoFormat('dddd D');
        $this->month = $date->isoFormat('MMMM');
        $this->time = $date->isoFormat('HH:mm');
        $event->description = $event->description_html;
        $this->type = $this->guessEventType($event->url);
        $this->calendarUrl = route('calendar', ['id' => $hashids->encodeId($event->id)]);
    }

    public function render()
    {
        return view('livewire.event-card');
    }

    /**
     * @param  string $url
     * @return string
     */
    private function guessEventType($url)
    {
        if (strpos($url, '.facebook.com')) {
            return __('foto-diretta.event-type-facebook');
        }
        if (strpos($url, '.instagram.com')) {
            return __('foto-diretta.event-type-instagram');
        }

        return __('foto-diretta.event-type-live');
    }
}
