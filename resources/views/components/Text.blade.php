@props(['name', 'label', 'placeholder', 'required' => 'false', 'cssContainer' => '', 'cssLabel' => '', 'cssInput' => '', 'value' => ''])

@php
$required = $required==='true';
$cssLabel = trim(($required ? 'font-bold required ' : '').$cssLabel);
$cssInput = trim(($required ? 'required ' : '').$cssInput);
@endphp

<div class="{{ $cssContainer }}">
  <label class="{{ $cssLabel }} " for="{{ $name }}">{{ $label }}</label>
  <textarea class="{{ $cssInput }} " id="{{ $name }}" name="{{ $name }}" placeholder="{{ $placeholder }}" aria-label="{{ $label }}" {!! $required==='true' ? 'required=""':'' !!} wire:model="{{ $name }}"
>{{ $value }}</textarea>
  @error($name) <span role="alert">{!! $message !!}</span> @enderror
</div>
