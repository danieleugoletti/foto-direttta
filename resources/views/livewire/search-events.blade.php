<div class="my-6 max-w-screen-xl m-auto">
    @foreach ($events as $event)
      <livewire:event-card :event="$event" />
    @endforeach
</div>
<div>
    {{ $events->links('livewire/pagination') }}
</div>
