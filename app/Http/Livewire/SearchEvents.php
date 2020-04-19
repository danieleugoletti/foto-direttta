<?php

namespace App\Http\Livewire;

use App\Event;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class SearchEvents extends Component
{
    use WithPagination;

    public $search = '';
    public $date = '';
    public $showDateErrorMessage = false;

    protected $updatesQueryString = [
        'search',
        'date',
        ['page' => ['except' => 1]]
    ];

    public function mount()
    {
        $this->fill(request()->only('search', 'date', 'page'));
    }

    public function render()
    {
        return view('livewire.search-events', [
            'events' => $this->doSearch()
        ]);
    }

    private function doSearch()
    {
        $this->showDateErrorMessage = false;
        $searchText = $this->search ? '%'.$this->search.'%' : '';

        if ($this->date) {
            $dt = Carbon::createFromFormat('Y-m-d', $this->date);
            $dtNow = Carbon::now();

            if ($dtNow->diffInDays($dt, false) < 0) {
                $this->showDateErrorMessage = true;
                return [];
            }

//            $isValidDate = $dtNow->diffInDays($dt, false) >= 0;
 //           $searchDate = $isValidDate ? $this->date : null;
        }
        return Event::searchApproved($searchText, $this->date)->paginate(10);
    }
}
