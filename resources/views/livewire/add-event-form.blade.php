<div>
  <form class="form-event" wire:submit.prevent="submit">
    <p class="form-event-title">{{ __('foto-diretta.enter-the-live-data') }}</p>
    <p class="form-event-info">* {{ __('foto-diretta.required-fields') }}</p>
    <x-Input name="title" :label="__('foto-diretta.event_title')" :placeholder="__('foto-diretta.event_title')" required="true" />
    <x-Input name="url" :label=" __('foto-diretta.url')" :placeholder=" __('foto-diretta.live_web_address')" required="true" />
    <div class="flex items-start">
      <x-Input name="date" type="date" :label=" __('foto-diretta.date')" :placeholder=" __('foto-diretta.live_day')" required="true" css-container="inline-block mt-2 w-1/2 pr-1" />
      <x-Select name="time" :label="__('foto-diretta.time')" required="true" css-container="inline-block mt-2 -mx-1 pl-1 w-1/2">
        <option>{{ __('foto-diretta.live_time') }}</option>
        @php
        $timeRange = explode(',', __('foto-diretta.time-range'));
        @endphp
        @foreach ($timeRange as $time)
          <option value="{{$time}}">{{$time}}</option>
        @endforeach
      </x-Select>
    </div>
    <x-Text name="description" :label=" __('foto-diretta.description')" :placeholder=" __('foto-diretta.description')" />
    <x-Input name="organizer" :label=" __('foto-diretta.organizer')" :placeholder=" __('foto-diretta.name_of_the_organizer')" />
    <x-Input name="image_url" :label=" __('foto-diretta.image_url')" :placeholder=" __('foto-diretta.web_address_of_the_image')" />

    @if ($success)
      <div class="alert-success">
        <p class="font-bold">{{ __('foto-diretta.operation-complete') }}</p>
        <p>{!! nl2br(__('foto-diretta.operation-complete-note')) !!}</p>
      </div>
    @endif

    <div class="mt-4">
      <button id="btnSubmit" class="btn" type="submit">{{ __('foto-diretta.send') }}</button>
      <div class="loader" wire:loading></div>
      <div class="ui-blocker" wire:loading></div>
    </div>
  </form>
  <script>
    document.addEventListener("livewire:load", (event) => {
      window.livewire.hook('afterDomUpdate', () => {
        let element = document.querySelector('[role="alert"]');
        if (!element) {
          return;
        }
        if (window.scrollY>element.parentNode.offsetTop) {
          element.parentNode.scrollIntoView();
        }
      });
    });
  </script>
</div>
