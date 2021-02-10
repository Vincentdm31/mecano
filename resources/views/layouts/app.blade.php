<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" />
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ mix('css/home.css') }}" rel="stylesheet">
    @yield('extra-css')
</head>

<body class="layout greyy">
    <header>
        <nav class="navbar greyy txt-white">
            <a href="{{ url('/') }}" class="navbar-brand">Mecalcis</a>

            <div class="navbar-menu ml-auto">
                @guest
                <a class="navbar-link {{ Request::routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">{{ __('Login') }}</a>

                @if (Route::has('register'))
                <a class="navbar-link {{ Request::routeIs('register') ? 'active' : '' }}" href="{{ route('register') }}">{{ __('Register') }}</a>
                @endif

                @else
                <span class="mr-2">{{ Auth::user()->name }}</span>

                <a href="{{ route('logout') }}" class="navbar-link" onclick="event.preventDefault(); document.getElementById('form-logout').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="form-logout" action="{{ route('logout') }}" method="POST" class="hide">
                    @csrf
                </form>
                @endguest
            </div>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>

    @yield('extra-js')
</body>

</html>