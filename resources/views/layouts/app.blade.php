<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ 'PICAMO GAMES' }}</title>
    <link rel="icon" type="image/png" href="../logos/picamonegro.png">
    <!-- Scripts   -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!--P5-->
    <script src="https://cdn.jsdelivr.net/npm/p5@1.0.0/lib/p5.min.js"></script>

    <!--jquery-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    

    <script type="text/javascript" src="../resources/js/Final/Ajedrez.js"></script>
    <script type="text/javascript" src="../resources/js/Final/AjedrezIA.js"></script>
    <script type="text/javascript" src="../resources/js/Final/AjedrezMP.js"></script>
    <script type="text/javascript" src="../resources/js/ControladorAjedrez.js"></script>

    <script type="text/javascript" src="../resources/js/Amigos.js"></script>
    <script type="text/javascript" src="../resources/js/Admin.js"></script>


    
    <style>
        html, body {
            background-color: #6C3483;
            color: black;
            font-family: Impact, Charcoal,sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }
        .links > a {
            color: black;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }    
        table {
            border-collapse: collapse;
            margin: 0 auto;
        }
        td {
            width: 75px;
            height: 75px;
            text-align: center;
            vertical-align: middle;
            font-size: 24px;
        }
        .white {
            background-color: #f0d9b5;
        }
        .black {
            background-color: #b58863;
        }     
    </style>
</head>
<body>

    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="../logos/picamolargonegro.png" width="180px" height="50px" >
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item links">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Iniciar Sesion') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item links">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Registrarse') }}</a>
                                </li>
                            @endif
                        @else
                            @include('Amigos')
                            <li class="nav-item dropdown links">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right links" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href=""  data-toggle="modal" data-target="#Amigos" onclick="event.preventDefault();">
                                        {{ __('Amigos') }}
                                    </a>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Cerrar Sesión') }}
                                    </a>
                                    
                                    
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                   
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>


        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
