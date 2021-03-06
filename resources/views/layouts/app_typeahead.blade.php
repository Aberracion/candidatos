<!DOCTYPE html>
{{ app()->setLocale(session('language', 'en')) }}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Candidatos') }}</title>

        <!-- Scripts -->

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>


        <!-- Fonts -->
        <link rel="dns-prefetch" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/dropdown.css') }}" rel="stylesheet">
        <link href="{{ asset('css/layouts.css') }}" rel="stylesheet">

    </head>
    <body>
        <div id="app">
            <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
                <div class="container">
                    @if(Auth::check() && app('request')->user()->hasAnyRole(['user', 'admin', 'super']))
                    <a class="navbar-brand" href="{{ url('/maps') }}">
                        @lang('texts.layout.map')
                    </a>
                    @endif
                    @if(Auth::check() && app('request')->user()->hasAnyRole(['admin', 'super']))
                    <a class="navbar-brand" href="{{ url('/candidatos') }}">
                        @lang('texts.layout.candidate')
                    </a>
                    <a class="navbar-brand" href="{{ url('/peticiones') }}">
                        @lang('texts.layout.petition')
                    </a>
                    @endif
                    @if(Auth::check() && app('request')->user()->hasAnyRole(['super']))
                    <a class="navbar-brand" href="{{ url('/reactivacion') }}">
                        @lang('texts.layout.reactivation')
                    </a>
                    <a class="navbar-brand" href="{{ url('/permisos') }}">
                        @lang('texts.layout.permits')
                    </a>
                    @endif
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">

                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <a href="{{ route('language', 'locate=es') }}">
                               <img src="{{ asset('images/es.png') }}" class="banderas 
                                     @if(app()->getLocale() == 'es') activo @endif" 
                                     />
                            </a>
                            <a href="{{ route('language', 'locate=en') }}">
                                <img src="{{ asset('images/uk.png') }}" class="banderas
                                     @if(app()->getLocale() == 'en') activo @endif" />
                            </a>
                            <!-- Authentication Links -->
                            @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('auth.Login') }}</a>
                            </li>
                            <li class="nav-item">
                                @if (Route::has('register'))
                                <a class="nav-link" href="{{ route('register') }}">{{ __('auth.Register') }}</a>
                                @endif
                            </li>
                            @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
    document.getElementById('logout-form').submit();">
                                        {{ __('auth.Logout') }}
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

            <main class="container">
                @yield('content')
            </main>
        </div>
    </body>
</html>
