<?php

namespace Candidatos\Http\Controllers;

use Illuminate\Http\Request;
use Candidatos\Poblacion;
use Candidatos\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function import()
    {
    	Excel::load('poblacion.csv', function($reader) {

     		foreach ($reader->get() as $poblacion) {
     			Poblacion::create([
     				'provincia' => $poblacion->provincia,
     				'poblacion' => $poblacion->poblacion,
     				'latitud' => $poblacion->latitud,     				
     				'longitud' => $poblacion->longitud
     			]);
      		}
		});
		return Poblacion::all();
    }
}