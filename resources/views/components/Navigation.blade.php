@php
    $headerLinks = config('foto-diretta.navigation')();
@endphp
@foreach ($headerLinks as $link)
    <a href="{{ $link['url'] }}">{{ $link['label'] }}</a>
@endforeach

