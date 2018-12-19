<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Maps -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css"
              integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
              crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"
                integrity="sha512-nMMmRyTVoLYqjP9hrbed9S+FzjZHW5gY1TWCHA5ckwXZBadntCNs8kEqAWdrb9O7rxbCaA4lKTIWjDXZxflOcA=="
        crossorigin=""></script>   
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>


        <title>{{ config('app.name', 'Laravel') }}</title>



        <!-- Fonts -->
        <link rel="dns-prefetch" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/dropdown.css') }}" rel="stylesheet">

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
                            <!-- Authentication Links -->
                            @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            <li class="nav-item">
                                @if (Route::has('register'))
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
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
                                        {{ __('Logout') }}
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

                <div id="mapid" style="width: 100%; height: 500px; margin:5px;"></div>


                @include('mapas.filtros')
                @include('mapas.gridview')
                <script type="text/javascript">
                    var map = L.map('mapid').setView([40.23754, - 3.7], 6);
                    var peticionIconpres = L.icon({
                    iconUrl: 'images/peticion-icon.png',
                            iconSize: [42, 42],
                            iconAnchor: [22, 41],
                            popupAnchor: [ - 3, - 42]
                    });
                    var peticionIconnop = L.icon({
                    iconUrl: 'images/peticion-no-icon.png',
                            iconSize: [42, 42],
                            iconAnchor: [22, 41],
                            popupAnchor: [ - 3, - 42]
                    });
                    var candidatoIcon = L.icon({
                    iconUrl: 'images/candidato-icon.png',
                            iconSize: [42, 42],
                            iconAnchor: [22, 41],
                            popupAnchor: [ - 3, - 42]

                    });
                    @foreach($ubicaciones_m as $ubicacion_m)
                            var {{ $ubicacion_m['ubicacion'] }} = L.marker([{{ $ubicacion_m['latitud'] }}, {{ $ubicacion_m['longitud'] }}], {icon: candidatoIcon}).addTo(map).bindPopup('{{ $ubicacion_m['name'] }}');
                    @endforeach
                            @foreach($ubicaciones_p as $ubicacion_p)
                            var {{ $ubicacion_p['ubicacion'] }} = L.marker([{{ $ubicacion_p['latitud'] }}, {{ $ubicacion_p['longitud'] }}], {icon: peticionIconpres}).addTo(map).bindPopup('{{ $ubicacion_p['name'] }}');
                    @endforeach
                            @foreach($ubicaciones_n as $ubicacion_n)
                            var {{ $ubicacion_n['ubicacion'] }} = L.marker([{{ $ubicacion_n['latitud'] }}, {{ $ubicacion_n['longitud'] }}], {icon: peticionIconnop}).addTo(map).bindPopup('{{ $ubicacion_n['name'] }}');
                    @endforeach
                            L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
                            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                                    maxZoom: 18,
                                    id: 'mapbox.streets',
                                    accessToken: 'pk.eyJ1IjoiaW55aSIsImEiOiJjanBpNjgyM3EwZ3l1M3Zxd3RwM2FuZzl5In0.R8lSRxOXyhHy4SHGccoKow'
                            }).addTo(map);

                </script>
            </main>
        </div>
    </body>
</html>