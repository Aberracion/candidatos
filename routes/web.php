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
Route::resource('permisos', 'UserController');
Route::post('/permisos/changeRol', 'UserController@changeRol');
Route::get('/reactivacion', 'CandidatoController@reactivacion');
Route::put('/reactivar', 'CandidatoController@reactivar');
Route::match(array('GET', 'POST'), 'language', 'LanguageController@index')->name('language');
Route::get('welcome/{locale}', function ($locale) {
    App::setLocale($locale);

    //
});


Route::get('/', function () {
    //return view('welcome');
    if (Auth::check())
        return redirect()->route('maps');
    else
        return redirect()->route('login');
});


//Route::request('/gmaps', ['as ' => 'gmaps', 'uses' => 'GmapsController@index']);
//Route::controller('gmaps', 'GmapsController');

Route::match(array('GET', 'POST'), '/gmaps', ['as ' => 'gmaps', 'uses' => 'GmapsController@index']);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
