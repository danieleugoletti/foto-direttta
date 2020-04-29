<?php

namespace App\Http\Livewire;

use App\Presenters\EventPresenter;
use Livewire\Component;

class EventCard extends Component
{
    private $event;

    public function mount(EventPresenter $event)
    {
        $this->event = $event;
    }

    public function render()
    {
        return view('livewire.event-card', [
            'event' => $this->event
        ]);
    }

}
