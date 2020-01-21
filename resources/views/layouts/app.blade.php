<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
            'baseUrl' => url('/'),
            'routes' => collect(\Route::getRoutes())->mapWithKeys(function ($route) { return [$route->getName() => $route->uri()]; })
        ]) !!};
    </script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom-style.css') }}" rel="stylesheet">
    @yield('styles')
</head>
<body>
    <div id="app"> 
        <nav class="navbar">
            <a class="nav-brand" href="{{ route('welcome') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            {{-- <div id="search">
                <form action="" method="get">
                    <input type="text" name="search_text" id="search_text" placeholder="Search"/>
                    <input type="button" name="search_button" id="search_button"></a>
                </form>
                <ul class="subnav">
                    <li><a href="#">Settings</a></li>
                    <li><a href="#">Application</a></li>
                    <li><a href="#">Board</a></li>
                    <li><a href="#">Options</a></li>
                </ul>
            </div> --}}
            <div class="nav-content">
                
            </div>
            <ul class="nav-auto"></ul>
        </nav>

        {{-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="{{ route('welcome') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div id="search">
                    <form action="" method="get">
                        <input type="text" name="search_text" id="search_text" placeholder="Search"/>
                        <input type="button" name="search_button" id="search_button"></a>
                    </form>
                    <ul class="subnav">
                        <li><a href="#">Settings</a></li>
                        <li><a href="#">Application</a></li>
                        <li><a href="#">Board</a></li>
                        <li><a href="#">Options</a></li>
                    </ul>
                </div>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        
                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <button type="button" class="btn btn-dark" v-on:click="$refs.create_room.toggleCreateRoomWindow()">Create Room</button>
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item highlight" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <a class="dropdown-item highlight" href="{{ route('settings') }}">Settings</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav> --}}

        <create-room-form ref="create_room"></create-room-form>
        <room-authorization-form ref="auth_room"></room-authorization-form>
        @if(session('auth-error'))
            <div class="alert alert-danger screen-middle alert-dismissible" role="alert">
                {{ $errors->first('auth-error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="contener">
            <div class="left-box">
                @yield('content')
            </div>
            <div class="right-box">

            </div>
        </div>
        <div style="clear: both;"></div>
    </div>
    @yield('scripts')
</body>
</html>
