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

        <title>{{ config('app.name', 'Laravel') }}</title>



        <!-- Fonts -->
        <link rel="dns-prefetch" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    </head>
    <body>
        <div id="app">
            <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                    <a class="navbar-brand" href="{{ url('/candidatos') }}">
                        Candidatos
                    </a>
                    <a class="navbar-brand" href="{{ url('/peticiones') }}">
                        Peticiones
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent"></div>
                </div>
            </nav>

            <main class="container">

<div id="mapid" style="width: 100%; height: 500px; margin:5px;"></div>

 @foreach($ubicaciones as $ubicacion)
                    <a href="" class="">{{ $ubicacion }}</a> 
 @endforeach
<script type="text/javascript">
      var map = L.map('mapid').setView([40.23754, -3.7], 6);
      var peticionIconpres = L.icon({
          iconUrl: 'images/peticion-icon.png',
          iconSize: [42, 42],
          iconAnchor: [22, 41],
          popupAnchor: [-3, -42]
      });
      var peticionIconnop = L.icon({
          iconUrl: 'images/peticion-no-icon.png',
          iconSize: [42, 42],
          iconAnchor: [22, 41],
          popupAnchor: [-3, -42]
      });
      var candidatoIcon = L.icon({
          iconUrl: 'images/candidato-icon.png',
          iconSize: [42, 42],
          iconAnchor: [22, 41],
          popupAnchor: [-3, -42]

      });
      var madrid    = L.marker([40.41669, -3.700346], {icon: peticionIconpres}).addTo(map).bindPopup('This is Littleton, CO.'),
          barcelona = L.marker([41.38792, 2.169919], {icon: peticionIconnop}).addTo(map).bindPopup('This is Denver, CO.'),
          barcelona2 = L.marker([41.38792, 2.179919], {icon: candidatoIcon}).addTo(map).bindPopup('This is Denver, CO.'),
          almeria   = L.marker([36.84016 , -2.467922 ]).addTo(map).bindPopup('This is Aurora, CO.');
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