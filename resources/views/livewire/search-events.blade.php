<div wire:poll.300s>
  <div wire:loading.class="is-loading">
    <form class="form-search" wire:submit.prevent="">
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
      <p class="warning-message">{{ __('foto-diretta.wrong-date') }}</p>
    @else
      <p class="warning-message">{{ __('foto-diretta.no-result') }}</p>
    @endif
  @endif
</div>
<script>
    document.addEventListener("livewire:load", (event) => {
      window.livewire.hook('afterDomUpdate', () => {
        let element = document.querySelector('.form-search');
        if (!element) {
          return;
        }
        if (window.scrollY>element.offsetTop) {
          element.scrollIntoView() - 20;
        }
      });
    });
  </script>
