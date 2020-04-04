<?php

namespace App\Http\Livewire;

use App\Event;
use Livewire\Component;
use Carbon\Carbon;

class EventCard extends Component
{
    public $event;
    public $day;
    public $month;
    public $time;

    public function mount(Event $event)
    {
        $this->event = $event;
        Carbon::setLocale(config('app.locale'));
        $date = Carbon::create($event->date);
        $this->day = $date->isoFormat('dddd D');
        $this->month = $date->isoFormat('MMMM');
        $this->time = $date->isoFormat('HH:mm');
    }

    public function render()
    {
        return view('livewire.event-card');
    }
}
