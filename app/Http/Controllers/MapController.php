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
        $candidatos_full = array();
  
        foreach ($candidatos_filtro as $candidato_m)
            {
        		$latitud = Poblacion::select("latitud")
                	->where('poblacion', $candidato_m->ubicacion)
                	->get(); 
         		$longitud = Poblacion::select("longitud")
                	->where('poblacion', $candidato_m->ubicacion)
                	->get();
                $latitud_m = str_replace(",",".", $latitud[0]->latitud);  
                $longitud_m = str_replace(",",".", $longitud[0]->longitud);
                $fullname_m = '<a href="./candidatos/'.$candidato_m->id.'">'.$candidato_m->candidato.'</a>';
                $ubicaciones_m[] = ['id' => $candidato_m->id, 'name' => $fullname_m, 'ubicacion' => $candidato_m->ubicacion, 'latitud' => $latitud_m,'longitud' => $longitud_m];
     
            }
 

		$result = array();
        $candidatos_unicos = array();
		foreach ($ubicaciones_m as $ubicacion_m) {
			$name = $ubicacion_m['ubicacion'];
            array_push($candidatos_unicos,$ubicacion_m['name']);
			if (isset($result[$name])){
				$result[$name]['name'].="<br>".$ubicacion_m['name']."<br>";
                
			}
			else
			{
				$result[$name] = $ubicacion_m;
			}

		}
 
        $ubicaciones_m = array_values($result);

        foreach ($peticiones_filtro as $peticion)
            {
        		$latitud = Poblacion::select("latitud")
                	->where('poblacion', $peticion->ubicacion)
                	->get(); 
         		$longitud = Poblacion::select("longitud")
                	->where('poblacion', $peticion->ubicacion)
                	->get();
                $latitud_p = str_replace(",",".", $latitud[0]->latitud);  
                $longitud_p = str_replace(",",".", $longitud[0]->longitud); 


                $fullname_p = '<a href="./peticiones/'.$peticion->id.'">'.$peticion->name.'</a>';
                if ($peticion->presencial==1){
                    $ints = (float)$longitud_p;
                    $ints = $ints+0.01;
                    $longitud_p =(string)$ints;
                    $ubicaciones_p[] = ['name' => $fullname_p, 'ubicacion' => $peticion->ubicacion, 'latitud' => $latitud_p,'longitud' => $longitud_p];
                }
                else
                {
                    $ints = (float)$longitud_p;
                    $ints = $ints-0.01;
                    $longitud_p =(string)$ints;
                    $ubicaciones_n[] = ['name' => $fullname_p, 'ubicacion' => $peticion->ubicacion, 'latitud' => $latitud_p,'longitud' => $longitud_p];  
                }   
                
            }

        $result_p = array();
        foreach ($ubicaciones_p as $ubicacion_p) {
            $name = $ubicacion_p['ubicacion'];

            if (isset($result_p[$name])){
                $result_p[$name]['name'].="<br>".$ubicacion_p['name']."<br>";
            }
            else
            {
                $result_p[$name] = $ubicacion_p;
            }

        }

        $ubicaciones_p = array_values($result_p);

        $result_np = array();
        foreach ($ubicaciones_n as $ubicacion_n) {
            $name = $ubicacion_n['ubicacion'];

            if (isset($result_np[$name])){
                $result_np[$name]['name'].="<br>".$ubicacion_n['name']."<br>";
            }
            else
            {
                $result_np[$name] = $ubicacion_n;
            }

        }
        
        $ubicaciones_n = array_values($result_np);

        return view('maps.show', compact('candidato', 'peticion_pres', 'peticion_no_pres', 'ubicaciones_p', 'ubicaciones_n', 'ubicaciones_m', 'candidatos_filtro', 'peticiones_filtro'));
    }
}