<div class="leading-loose">
  <form class="max-w-xl m-4 py-5 px-10 bg-white rounded shadow-xl">
    @if ($success)
      <div class="bg-green-100 border-l-4 border-green-800 text-orange-dark p-4" role="alert">
        <p class="font-bold">{{ __('foto-diretta.operation-complete') }}</p>
        <p>{!! nl2br(__('foto-diretta.operation-complete-note')) !!}</p>
      </div>
    @endif

    <p class="text-gray-800 text-2xl font-semibold">{{ __('foto-diretta.enter-the-live-data') }}</p>
    <p class="text-gray-800 text-sm italic">* {{ __('foto-diretta.required-fields') }}</p>
    <x-input name="title" :label="__('foto-diretta.event_title')" :placeholder="__('foto-diretta.event_title')" required="true" />
    <x-input name="url" :label=" __('foto-diretta.url')" :placeholder=" __('foto-diretta.live_web_address')" required="true" />
    <div class="flex items-start">
      <x-input name="date" type="date" :label=" __('foto-diretta.date')" :placeholder=" __('foto-diretta.live_day')" required="true" css-container="inline-block mt-2 w-1/2 pr-1" />
      <x-select name="time" :label="__('foto-diretta.time')" required="true" css-container="inline-block mt-2 -mx-1 pl-1 w-1/2">
        <option>{{ __('foto-diretta.live_time') }}</option>
        @php
        $timeRange = explode(',', __('foto-diretta.time-range'));
        @endphp
        @foreach ($timeRange as $time)
          <option value="{{$time}}">{{$time}}</option>
        @endforeach
      </x-select>

    </div>
    <x-text name="description" :label=" __('foto-diretta.description')" :placeholder=" __('foto-diretta.description')" />
    <x-input name="organizer" :label=" __('foto-diretta.organizer')" :placeholder=" __('foto-diretta.name_of_the_organizer')" />
    <x-input name="image_url" :label=" __('foto-diretta.image_url')" :placeholder=" __('foto-diretta.web_address_of_the_image')" />
    <div class="mt-4">
      <button id="btnSubmit" class="bg-red-600 hover:bg-red-700 text-white text-sm px-4 py-2 border rounded-full font-bold" type="button" onClick="submitEvent()">{{ __('foto-diretta.send') }}</button>
      <div class="loader" wire:loading></div>
      <div class="ui-blocker" wire:loading></div>
    </div>
  </form>
  <script>
    document.addEventListener("livewire:load", (event) => {
      let isSubmited = false;
      let timeId;

      function alignToAlert() {
        let element = document.querySelector('[role="alert"]');
        if (!element) {
          return;
        }
        element.parentNode.scrollIntoView();
      }

      window.livewire.hook('afterDomUpdate', () => {
        btnSubmit.disabled = false;
        if (!isSubmited) {
          return;
        }
        isSubmited = false;
        clearTimeout(timeId);
        timeId = setTimeout(alignToAlert, 1000);
      });

      window.submitEvent = () => {
        isSubmited = true;
        btnSubmit.disabled = true;
        window.livewire.emit('submit');
      }
    });
  </script>
</div>

