<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::resource('candidatos', 'CandidatoController');
Route::resource('perfil', 'PerfilController');
Route::resource('peticiones', 'PeticionController');


Route::get('/', function () {
    return view('welcome');
});

	
//Route::request('/gmaps', ['as ' => 'gmaps', 'uses' => 'GmapsController@index']);

//Route::controller('gmaps', 'GmapsController');

Route::match(array('GET', 'POST'), '/gmaps', ['as ' => 'gmaps', 'uses' => 'GmapsController@index']);

Route::get('/gmaps2', function(){
    $config = array();
    $config['center'] = 'auto';
    $config['onboundschanged'] = 'if (!centreGot) {
            var mapCentre = map.getCenter();
            marker_0.setOptions({
                position: new google.maps.LatLng(mapCentre.lat(), mapCentre.lng())
            });
        }
        centreGot = true;';

    app('map')->initialize($config);

    // set up the marker ready for positioning
    // once we know the users location
    $marker = array();
    app('map')->add_marker($marker);

    $map = app('map')->create_map();
    echo "<html><head><script type='text/javascript'>var centreGot = false;</script>".$map['js']."</head><body>".$map['html']."</body></html>";
});