<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <meta name="description" content="Application mecano Alcis">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Mecalcis') }}</title>

    <!-- Styles -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" />
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @yield('extra-css')
</head>

<body class="layout bg-blue light-4">
    <header>
        <div class="navbar-fixed">
            <nav class="navbar bg-blue3 txt-white shadow-1">
                @if(Auth()->check())
                <a href="{{ route('verif.index') }}" class="navbar-brand hide-sm-down">Accueil</a>

                @endif
                <button data-target="sidenav" class="txt-white btn rounded-1 transparent sidenav-trigger hide-md-up"><i class="fas fa-bars mr-1"></i>Menu</button>
                <div class="navbar-menu ml-auto hide-sm-down">
                    <a href="{{ route('verif.index') }}" class="navbar-link">Interventions</a>
                    <a href="{{ route('piecesList.index') }}" class="sidenav-link">Gestion pièces</a>
                    <a href="{{ route('verifFull') }}" class="navbar-link">Liste complète</a>
                </div>
                <div class="ml-auto d-flex fx-row">
                    @guest
                    <a class="navbar-link {{ Request::routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">{{ __('Login') }}</a>

                    @if (Route::has('register'))
                    <a class="navbar-link {{ Request::routeIs('register') ? 'active' : '' }}" href="{{ route('register') }}">{{ __('Register') }}</a>
                    @endif

                    @else
                    <span class="mr-2">{{ Auth::user()->name }}</span>

                    <a href="{{ route('logout') }}" class="navbar-link red rounded-2 px-2" onclick="event.preventDefault(); document.getElementById('form-logout').submit();">
                        {{ __('Déconnexion') }}
                    </a>

                    <form id="form-logout" action="{{ route('logout') }}" method="POST" class="hide">
                        @csrf
                    </form>
                    @endguest
                </div>
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="https://rawgit.com/sitepoint-editors/jsqrcode/master/src/qr_packed.js"></script>
    <script type="text/javascript" src="{{ mix('js/qrCodeScanner.js') }}"></script>
    </script>
    @yield('extra-js')
</body>

</html>