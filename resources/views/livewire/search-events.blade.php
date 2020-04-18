<div>
  <div wire:loading.class="is-loading">
    <form class="form-search">
      <input wire:model.debounce.500ms="search" type="text" placeholder="{{ __('foto-diretta.search-text') }}">
      <input wire:model="date" type="date" placeholder="{{ __('foto-diretta.search-date') }}">
      <a href="{{ route('add-event') }}" class="btn"><span class="icon">+</span> {{ __('foto-diretta.add-event') }}</a>
    </form>
  </div>
  @if(count($events))
    <div class="my-6 max-w-screen-xl m-auto">
      @foreach ($events as $event)
        <livewire:event-card :event="$event" :key="$event->id" />
      @endforeach
      <div class="pt-6">
        {{ $events->links('livewire/pagination') }}
      </div>
    </div>
  @else
    @if($showDateErrorMessage)
      <p class="mt-20 text-gray-600 text-lg">{{ __('foto-diretta.wrong-date') }}</p>
    @else
      <p class="mt-20 text-gray-600 text-lg">{{ __('foto-diretta.no-result') }}</p>
    @endif
  @endif
</div>
