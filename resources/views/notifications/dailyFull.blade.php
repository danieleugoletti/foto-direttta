{{ trans_choice('foto-diretta.notification-today', $events->count(), ['count' => $events->count()]) }}

@foreach ($events as $event)
⏰ {{ __('foto-diretta.notification-time', ['time' => $event->time]) }}
@if($event->organizer)
{{ $event->organizer }}: {{ $event->title }}
@else
{{ $event->title }}
@endif
<a href="{{ $event->url }}">{{ $event->type }}</a>

@endforeach
