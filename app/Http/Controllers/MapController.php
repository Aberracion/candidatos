<?php

namespace Candidatos\Http\Controllers;

use Candidatos\Peticion;
use Candidatos\Candidato;
use Candidatos\Poblacion;
use Illuminate\Http\Request;

class MapController extends Controller
{

    public function show_map(Request $request)
    {

    	$candidatos_filtro = Candidato::getCandidatosGridMapas($request);
        $peticiones_filtro = Peticion::getPeticionesGridMapas($request);

        $candidato = Candidato::where('baja', 0)->get();
        $peticion_pres = Peticion::where('baja', 0)
                ->where('presencial', 1)
                ->get();
        $peticion_no_pres = Peticion::where('baja', 0)
                ->where('presencial', 0)
                ->get(); 
        $ubicaciones_m = array();                
        $ubicaciones_p = array();
        $ubicaciones_n = array();
        foreach ($candidato as $candidato_m)
            {
        		$latitud = Poblacion::select("latitud")
                	->where('poblacion', $candidato_m->ubicacion)
                	->get(); 
         		$longitud = Poblacion::select("longitud")
                	->where('poblacion', $candidato_m->ubicacion)
                	->get();
                $latitud_m = str_replace(",",".", $latitud[0]->latitud);  
                $longitud_m = str_replace(",",".", $longitud[0]->longitud);
                $fullname_m = $candidato_m->nombre. ' ' .$candidato_m->apellidos;    
                $ubicaciones_m[] = ['name' => $fullname_m, 'ubicacion' => $candidato_m->ubicacion, 'latitud' => $latitud_m,'longitud' => $longitud_m];
            }
        foreach ($peticion_pres as $peticion_p)
            {
        		$latitud = Poblacion::select("latitud")
                	->where('poblacion', $peticion_p->ubicacion)
                	->get(); 
         		$longitud = Poblacion::select("longitud")
                	->where('poblacion', $peticion_p->ubicacion)
                	->get();
                $latitud_p = str_replace(",",".", $latitud[0]->latitud);  
                $longitud_p = str_replace(",",".", $longitud[0]->longitud);       
                $ubicaciones_p[] = ['name' => $peticion_p->name, 'ubicacion' => $peticion_p->ubicacion, 'latitud' => $latitud_p,'longitud' => $longitud_p];
            }
        foreach ($peticion_no_pres as $peticion_n)
            {
        		$latitud = Poblacion::select("latitud")
                	->where('poblacion', $peticion_n->ubicacion)
                	->get(); 
         		$longitud = Poblacion::select("longitud")
                	->where('poblacion', $peticion_n->ubicacion)
                	->get();                 
                $latitud_n = str_replace(",",".", $latitud[0]->latitud);  
                $longitud_n = str_replace(",",".", $longitud[0]->longitud);       
                $ubicaciones_n[] = ['name' => $peticion_n->name, 'ubicacion' => $peticion_n->ubicacion, 'latitud' => $latitud_n,'longitud' => $longitud_n];
            }
        return view('maps.show', compact('candidato', 'peticion_pres', 'peticion_no_pres', 'ubicaciones_p', 'ubicaciones_n', 'ubicaciones_m', 'candidatos_filtro', 'peticiones_filtro'));
    }
}
