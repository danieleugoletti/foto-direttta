<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:title" content="{{ config('app.name', 'Laravel') }}">
    <meta property="og:description" content="">
    <meta property="og:image" content="">
    <meta property="og:url" content="">
    <meta name="twitter:card" content="summary_large_image">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <livewire:styles/>
    @yield('head')
</head>
<body>
    <header>
        <div class="container">
            <h3><a href="/">{{ config('app.name', 'Laravel') }}</a></h3>
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
<livewire:scripts/>
</body>
</html>
