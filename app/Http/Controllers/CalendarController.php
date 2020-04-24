<?php

namespace App\Http\Controllers;

use App\Event;
use App\Helpers\HashidHelper;
use Illuminate\Http\Request;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event as CalendarEvent;
use Spatie\IcalendarGenerator\PropertyTypes\TextPropertyType;
use Carbon\Carbon;

class CalendarController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke($id, HashidHelper $hashids)
    {
        $id = $hashids->decodeId($id);
        abort_unless($event = Event::find($id), 404);

        $calendar = $this->createCalendar($event);

        return response()->streamDownload(
            function() use ($calendar) {
                echo $calendar;
            },
            'calendar.ics',
            ['Content-Type' => 'text/calendar', 'charset' => 'utf-8']
        );
    }

    /**
     * @param  App\Event $event
     * @return string
     */
    private function createCalendar($event)
    {
       $eventItem = CalendarEvent::create($event->title)
                    ->description($event->description)
                    ->startsAt(Carbon::create($event->date));

        $alertMinutesBefore = config('foto-diretta.calendar.alertMinutesBefore');
        if (is_integer($alertMinutesBefore) && $alertMinutesBefore>0) {
            $eventItem->alertMinutesBefore($alertMinutesBefore, $event->title);
        }

        $calendar = Calendar::create(config('app.name'))
                        ->event($eventItem);

        if ($event->organizer) {
            $calendar->appendProperty(
                TextPropertyType::create('ORGANIZER', $event->organizer)
            );
        }

        return $calendar->get();
    }
}
