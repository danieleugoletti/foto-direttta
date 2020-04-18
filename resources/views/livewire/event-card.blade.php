<div class="card">
  <div class="date">
      <div class="date-day">{{$day}}</div>
      <div class="date-month">{{$month}}</div>
      <div class="date-time">{{$time}}</div>
  </div>
  <div class="info">
    <div class="info-event-type">{{ __('foto-diretta.event-type-live') }}</div>
    <a href="{{$event->url}}" target="_blank" class="info-title">{{$event->title}}</a>
    @if($event->description)
      <p class="info-description">{{$event->description}}</p>
    @endif
  </div>
  @if($event->image_url)
  <div class="image">
    <img src="{{$event->image_url}}">
  </div>
  @endif
</div>
