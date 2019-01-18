<?php

namespace Candidatos\Http\Controllers;

use Illuminate\Http\Request;
//use GeneaLabs\LaravelMaps\Facades\Map;
use Candidatos\Peticion;
use Candidatos\Candidato;


/**
 * Me parece que este controlador no se utiliza
 */
class GmapsController extends Controller {

    public function index(Request $request) {

        $candidatos = Candidato::getCandidatosGridMapas($request);
        $peticiones = Peticion::getPeticionesGridMapas($request);

        return view('mapas.index', compact('candidatos', 'peticiones'));
    }

}
