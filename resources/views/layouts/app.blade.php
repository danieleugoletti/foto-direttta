<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:title" content="{{ config('foto-diretta.metadata.title') }}">
    <meta property="og:description" content="{{ config('foto-diretta.metadata.descrition') }}">
    <meta property="og:image" content="{{ config('foto-diretta.metadata.imageSocial') }}">
    <meta property="og:url" content="{{ config('foto-diretta.metadata.url') }}">
    <meta name="twitter:card" content="{{ config('foto-diretta.metadata.twitterCard') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('feed::links')
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <livewire:styles/>
    @yield('head')
</head>
<body>
    <header>
        <div class="container">
            <h3><a href="/">
                @php
                    $image = config('foto-diretta.metadata.image', '');
                    $appName = config('app.name', 'Laravel');
                @endphp
                @if ($image)
                    <img src="{{ $image }}" title="{{ $appName }}" alt="{{ $appName }}">
                @else
                    {{ $appName }}
                @endif
            </a></h3>
            <nav class="hidden md:flex text-lg">

                <x-Navigation />
                {{--
                @if(Route::has('login'))
                        @auth
                            <a href="{{ url('/home') }}">{{ __('Home') }}</a>
                            <span class="text-gray-300 text-sm pr-4">{{ Auth::user()->name }}</span>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                {{ csrf_field() }}
                            </form>
                        @else
                            <a href="{{ route('login') }}">{{ __('Login') }}</a>
                        @endauth
                @endif
                --}}
            </nav>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
    <footer>
        <ul>
            <li>
                From an idea by Daniele Ugoletti.
            </li>
            <li>
                Built with <a href="https://github.com/danieleugoletti/foto-direttta" title="GitHub Foto-Diretta Repository">Foto-Diretta</a>.
            </li>
            <li>
                <a href="/feed">RSS Feed</a>
            </li>
        </ul>
    </footer>
<livewire:scripts/>
</body>
</html>
