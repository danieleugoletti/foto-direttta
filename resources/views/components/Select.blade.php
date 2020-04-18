@props(['name', 'label', 'required' => 'false', 'cssContainer' => '', 'cssLabel' => '', 'cssInput' => '', 'value' => '', 'useModel' => 'true'])

@php
$required = $required==='true';
$cssLabel = trim('block text-sm text-gray-00 '.($required ? 'font-bold required' : '').$cssLabel);
$cssInput = trim('w-full px-5 py-2 text-gray-700 bg-gray-200 border border-gray-200 rounded focus:outline-none focus:bg-white focus:border-gray-500 '.($required ? 'required' : '').$cssInput);
@endphp


<div class="{{ $cssContainer }}">
    <label class="{{ $cssLabel }} " for="{{ $name }}">{{ $label }}</label>
    <select class="{{ $cssInput }} " id="{{ $name }}" name="{{ $name }}" aria-label="{{ $label }}" {!! $required==='true' ? 'required=""' : '' !!} value="{{ $value }}"  {!! $useModel==='true' ? 'wire:model.lazy="'.$name.'"' : '' !!}>
    {{ $slot }}
    </select>
    @error($name) <span class="text-red-500 text-xs italic" role="alert">{!! $message !!}</span> @enderror
</div>
