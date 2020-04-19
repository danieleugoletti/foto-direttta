@props(['type' => 'text', 'name', 'label', 'placeholder', 'required' => 'false', 'cssContainer' => '', 'cssLabel' => '', 'cssInput' => '', 'value' => '', 'useModel' => 'true'])

@php
$required = $required==='true';
$cssLabel = trim(($required ? 'font-bold required ' : '').$cssLabel);
$cssInput = trim(($required ? 'required ' : '').$cssInput);
@endphp

<div class="{{ $cssContainer }}">
  <label class="{{ $cssLabel }} " for="{{ $name }}">{{ $label }}</label>
  <input class="{{ $cssInput }} " id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" placeholder="{{ $placeholder }}" aria-label="{{ $label }}" {!! $required==='true' ? 'required=""' : '' !!} value="{{ $value }}"  {!! $useModel==='true' ? 'wire:model="'.$name.'"' : '' !!} autocomplete="off">
  {{ $slot }}
  @error($name) <span role="alert">{!! $message !!}</span> @enderror
</div>
