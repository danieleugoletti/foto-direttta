@props(['name', 'label', 'placeholder', 'required' => 'false', 'cssContainer' => '', 'cssLabel' => '', 'cssInput' => '', 'value' => ''])

@php
$required = $required==='true';
$cssLabel = trim('block text-sm text-gray-00 '.($required ? 'font-bold required' : '').$cssLabel);
$cssInput = trim('w-full px-5 py-1 text-gray-700 bg-gray-200 border border-gray-200 h-48 rounded appearance-none no-resize resize-none focus:outline-none focus:bg-white focus:border-gray-500 '.($required ? 'required' : '').$cssInput);
@endphp

<div class="{{ $cssContainer }}">
  <label class="{{ $cssLabel }} " for="{{ $name }}">{{ $label }}</label>
  <textarea class="{{ $cssInput }} " id="{{ $name }}" name="{{ $name }}" placeholder="{{ $placeholder }}" aria-label="{{ $label }}" {!! $required==='true' ? 'required=""':'' !!} wire:model.lazy="{{ $name }}"
>{{ $value }}</textarea>
  @error($name) <span class="text-red-500 text-xs italic" role="alert">{!! $message !!}</span> @enderror
</div>
