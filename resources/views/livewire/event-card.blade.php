<div class="card">
  <div class="date-box">
    <div class="date-bk">
        <div class="month">{{$event->month}}</div>
        <div class="day">{{$event->day}}</div>
        <div class="time">{{$event->time}}</div>
        <div class="type">{{$event->type}}</div>
    </div>
    <a href="{{$event->calendarUrl}}" class="calendar" title="{{__('foto-diretta.add-to-calendar')}}">{{__('foto-diretta.add-to-calendar')}}</a>
  </div>
  <div class="info">
    @if($event->organizer)
      <div class="info-organizer">{{$event->organizer}}</div>
    @endif
    <a href="{{$event->url}}" target="_blank" class="info-title">{{$event->title}}</a>
    @if($event->description)
      <div class="info-description">{!! $event->descriptionHtml !!}</div>
    @endif
  </div>
  @if($event->image_url)
  <div class="image">
    <img src="{{$event->image_url}}">
  </div>
  @endif
</div>
