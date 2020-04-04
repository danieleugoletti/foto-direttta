<?php

namespace App\Http\Livewire;

use App\Event;
use Livewire\Component;
use Livewire\WithPagination;

class SearchEvents extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.search-events', [
            'events' => Event::paginate(5)
        ]);
    }
}
