@props(['name', 'label', 'required' => 'false', 'cssContainer' => '', 'cssLabel' => '', 'cssInput' => '', 'value' => '', 'useModel' => 'true'])

@php
$required = $required==='true';
$cssLabel = trim(($required ? 'font-bold required ' : '').$cssLabel);
$cssInput = trim(($required ? 'required ' : '').$cssInput);
@endphp

<div class="{{ $cssContainer }}">
    <label class="{{ $cssLabel }} " for="{{ $name }}">{{ $label }}</label>
    <select class="{{ $cssInput }} " id="{{ $name }}" name="{{ $name }}" aria-label="{{ $label }}" {!! $required==='true' ? 'required=""' : '' !!} value="{{ $value }}"  {!! $useModel==='true' ? 'wire:model="'.$name.'"' : '' !!}>
    {{ $slot }}
    </select>
    @error($name) <span role="alert">{!! $message !!}</span> @enderror
</div>
