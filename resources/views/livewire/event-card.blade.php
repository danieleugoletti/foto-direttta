<div class="card">
  <div class="date">
      <div class="date-month">{{$month}}</div>
      <div class="date-day">{{$day}}</div>
      <div class="date-time">{{$time}}</div>
      <div class="type">{{$type}}</div>
  </div>
  <div class="info">
    @if($event->organizer)
      <div class="info-organizer">{{$event->organizer}}</div>
    @endif
    <a href="{{$event->url}}" target="_blank" class="info-title">{{$event->title}}</a>
    @if($event->description)
      <div class="info-description">{!! $event->description !!}</div>
    @endif
  </div>
  @if($event->image_url)
  <div class="image">
    <img src="{{$event->image_url}}">
  </div>
  @endif
</div>
