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
    @yield('extra-css')
</head>

<body class="layout">
    <header>
        <nav class="navbar dark txt-white shadow-1">
            <a href="{{ url('/') }}" class="navbar-brand hide-sm-down">Mecalcis</a>
            <button data-target="sidenav" class="txt-white btn rounded-1 transparent sidenav-trigger hide-md-up"><i class="fas fa-bars mr-1"></i>Menu</button>
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

    <div class="sidenav shadow-1 dark-light" id="sidenav" data-ax="sidenav">
        <div class="sidenav-header p-2">
            <p class="mr-auto orange-custom font-s5 bd-b-solid bd-orange bd-light-2 bd-2 pb-4">Alcis Groupe</p>
        </div>
        <div class="txt-white">
            @if(Auth()->check())
            @if(Auth()->user()->is_admin)
            <a href="" class="sidenav-link">Interventions</a>
            <a href="{{ route('users.index') }}" class="sidenav-link">Gestion utilisateurs</a>
            <a href="{{ route('vehicules.index') }}" class="sidenav-link">Gestion véhicules</a>
            <a href="{{ route('pieces.index') }}" class="sidenav-link">Gestion pièces</a>
            <a href="{{ route('categories.index') }}" class="sidenav-link">Gestion catégories</a>
            @else
            <form class="form-material sidenav-link" method="POST" action="{{ route('interventions.store') }}">
                @csrf
                <button type="submit" class="btn txt-orange transparent p-0">Nouvelle</button>
            </form>
            <a href="{{ route('interventions.index') }}" class="sidenav-link txt-white">Liste complète</a>
            <a href="{{ route('joinIntervention') }}" class="sidenav-link">Rejoindre</a>
            <a href="{{ route('resumeIntervention') }}" class="sidenav-link">Reprendre</a>
            <a href="{{ route('test') }}" class="sidenav-link">API</a>
            @endif
            @endif
        </div>

    </div>

    <main>
        @yield('content')
    </main>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/neu-axentix@1.4.0/dist/js/neu-axentix.min.js"></script>
    @yield('extra-js')
</body>

</html>