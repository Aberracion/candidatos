<?php

namespace Candidatos\Http\Controllers;

use Candidatos\Peticion;
use Candidatos\Candidato;
use Illuminate\Http\Request;

class MapController extends Controller
{

    public function show_map()
    {
        $candidato = Candidato::where('baja', 0);
        $peticion_pres = Peticion::where('baja', 0)
                ->where('presencial', 1)
                ->get();
        $peticion_no_pres = Peticion::where('baja', 0)
                ->where('presencial', 0)
                ->get(); 
        $ubicaciones = array();
        foreach ($peticion_pres as $peticion_p)
            {
                $ubicaciones[] = $peticion_p->ubicacion;
            }
        foreach ($peticion_no_pres as $peticion_n)
            {
                $ubicaciones[] = $peticion_n->ubicacion;
            }
        return view('maps.show', compact('candidato', 'peticion_pres', 'peticion_no_pres', 'ubicaciones'));
    }
}
