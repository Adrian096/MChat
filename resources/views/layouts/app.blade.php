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
        <nav class="navbar bg-dark bd-green">
            <a class="nav-brand" href="{{ route('welcome') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            
            <div class="nav-content">
                <room-search :rooms="{{$rooms}}"></room-search>
                <ul class="mr-auto-nav clr-mg-pd"></ul>
                <ul class="nav-auto-right ml-auto-nav clr-mg-pd">
                    <button type="button" class="btn btn-dark wh-nowrap" v-on:click="$refs.create_room.toggleCreateRoomWindow()">Create Room</button>
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
        </nav>

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
                <span class="resizable-border"></span>
            </div>
        </div>
        <div style="clear: both;"></div>
    </div>

    <script>
        var convertToPercent = function(val) {
            if(val.slice(-1) == '%') return parseFloat(val.replace('%', ''));
            if(val.slice(-2) == "px") {
                val = parseFloat(val.replace("px", ''));
                return ((val / window.innerWidth) * 100)
            }
        }

        function makeResizableDiv () {
            const resizer = document.querySelector('.resizable-border');
            const leftBox = document.querySelector('.left-box');
            const parent = resizer.parentElement;
            const min = convertToPercent(window.getComputedStyle(parent, null).getPropertyValue('min-width'));
            const max = convertToPercent(window.getComputedStyle(parent, null).getPropertyValue('max-width'));
            resizer.addEventListener('mousedown', function (e) {
                e.preventDefault();
                window.addEventListener('mousemove', resize);
                window.addEventListener('mouseup', stopResize);
            });

            function resize(e) {
                const parentPercentWidth = 100 - ((e.pageX / window.innerWidth) * 100);
                const widthLeft = 100 - parentPercentWidth;

                if(parentPercentWidth > min && parentPercentWidth < max){
                    parent.style.width = parentPercentWidth + '%';
                    leftBox.style.width = widthLeft + '%';
                }
            }

            function stopResize() {
                window.removeEventListener('mousemove', resize);
            }
        }
        makeResizableDiv();
    </script>
    
    @yield('scripts')
</body>
</html>
