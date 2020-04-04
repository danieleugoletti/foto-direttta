<?php

namespace App\Http\Livewire;

use App\Event;
use Livewire\Component;
use Livewire\WithPagination;

class SearchEvents extends Component
{
    use WithPagination;

    public $search = '';

    protected $updatesQueryString = [
        ['search' => ['except' => '']],
        ['page' => ['except' => 1]],
    ];

    public function mount()
    {
        $this->fill(request()->only('search', 'page'));
    }

    public function render()
    {
        return view('livewire.search-events', [
            'events' => $this->doSearch()
        ]);
    }

    private function doSearch()
    {
        return Event::searchApproved($this->search)->paginate(10);
    }
}
