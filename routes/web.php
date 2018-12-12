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
Route::match(array('GET', 'POST'), 'maps', 'MapController@show_map')->name('maps');
Route::get('import', 'ImportController@import');
Route::get('autocomplete', 'PeticionController@autocomplete')->name('autocomplete');

Route::get('/', function () {
    //return view('welcome');
    return redirect()->route('maps');
});


//Route::request('/gmaps', ['as ' => 'gmaps', 'uses' => 'GmapsController@index']);
//Route::controller('gmaps', 'GmapsController');

Route::match(array('GET', 'POST'), '/gmaps', ['as ' => 'gmaps', 'uses' => 'GmapsController@index']);
