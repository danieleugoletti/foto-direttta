{{ __('foto-diretta.notification-on-live-soon') }}

⏰ {{ __('foto-diretta.notification-time', ['time' => $event->time]) }}
@if($event->organizer)
{{ $event->organizer }}: {{ $event->title }}
@else
{{ $event->title }}
@endif
@if($event->description)
{{ $event->description }}
@endif
{{ $event->url }}


