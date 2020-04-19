<?php

namespace App\Http\Livewire;

use App\Event;
use Livewire\Component;
use Carbon\Carbon;

class AddEventForm extends Component
{
    public $title;
    public $url;
    public $date;
    public $time;
    public $description;
    public $organizer;
    public $image_url;
    public $success = false;

    public function updated($field)
    {
        $this->validateRequest($field);
    }

    public function submit()
    {
        $this->success = false;
        $this->validateRequest();

        $dt = Carbon::createFromFormat(__('foto-diretta.date-format'),
                        sprintf('%s %s', $this->date, $this->time));
        $dt->second = 0;

        if (!$this->isValidateDate($dt)) {
            return;
        }

        Event::create([
            'title' => $this->title,
            'organizer' => $this->organizer,
            'description' => $this->description,
            'url' => $this->url,
            'image_url' => $this->image_url,
            'date' => $dt->toDateTimeString(),
            'approved' => 0
        ]);
        $this->resetAttributes();
        $this->success = true;
    }


    public function render()
    {
        return view('livewire.add-event-form');
    }

    /**
     * Validate request
     */
    private function validateRequest($field=null)
    {
        $fieldsDefinition = [
            'title' => ['required', 'min:6'],
            'url' => ['required', 'url'],
            'date' => ['required'],
            'time' => ['required', 'regex:/^\d{1,2}:\d{1,2}( AM| PM)?$/i'],
            'image_url' => ['nullable', 'url'],
        ];
        $attributes = [
            'title' => $this->localeLabelAndWrapInBold('foto-diretta.event_title'),
            'url' => $this->localeLabelAndWrapInBold('foto-diretta.url'),
            'date' => $this->localeLabelAndWrapInBold('foto-diretta.date'),
            'time' => $this->localeLabelAndWrapInBold('foto-diretta.time'),
            'image_url' => $this->localeLabelAndWrapInBold('foto-diretta.image_url'),
        ];

        if ($field) {
            $this->validateOnly($field, $fieldsDefinition, [], $attributes);
        } else {
            $this->validate($fieldsDefinition, [], $attributes);
        }
    }

    /**
     * Validate the date, must be after now
     * @param  \Carbon $dt
     * @return boolean
     */
    private function isValidateDate($dt)
    {
        $dtNow = Carbon::now();

        if ($dtNow->diffInDays($dt, false) >= 0) {
            return true;
        }

        $this->addError('date',
                str_replace([':attribute', ':date'],
                            [
                                $this->localeLabelAndWrapInBold('foto-diretta.date'),
                                $dtNow->locale(config('app.locale'))->isoFormat('LLL')
                            ],
                            __('validation.after')));
        return false;
    }

    /**
     * Return the locale string wrapperd with bold tad
     * @param  string $key
     * @return string
     */
    private function localeLabelAndWrapInBold($key)
    {
        return sprintf('<b>%s</b>', __($key));
    }

    /**
     * Reset the public attributes
     */
    private function resetAttributes()
    {
        $this->title = '';
        $this->organizer = '';
        $this->description = '';
        $this->url = '';
        $this->image_url = '';
        $this->date = '';
        $this->time = '';
    }
}
