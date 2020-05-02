{{ trans_choice('foto-diretta.notification-today', $events->count(), ['count' => $events->count()]) }}

{!! __('foto-diretta.notification-link', ['link' => $searchLink, 'site' => config('app.name')]) !!}
