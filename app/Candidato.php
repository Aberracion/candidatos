<?php

namespace Candidatos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Candidato extends Model {

    /**
     * Devuelve todos los candidatos para el mapa y el grid de la misma pantalla
     * teniendo en cuenta los filtros introducidos
     * @param type $request
     * @return type
     */
    public static function getCandidatosGridMapas($request) {
        $candidatos = DB::table('candidatos_map');
        if (isset($request)) {
            if ($request->input('ubicacionCand') != "") {
                $candidatos->where('ubicacion', 'LIKE', '%' . $request->input('ubicacionCand') . '%');
            }
            if ($request->input('tecnologia') != "") {
                $candidatos->where('tecnologias', 'LIKE', '%' . $request->input('tecnologia') . '%');
            }
            if ($request->input('nivel') != "" && $request->input('nivel') > 0) {
                if ($request->input('tecnologia') != ""){
                    $arr1 = explode(' - ', $request->input('tecnologia'));
                    $candidatos->where('tecnologias', 'LIKE', '%' . $request->input('nivel') . '%');
                    for ($i = $request->input('nivel')+1; $i <= 10; $i++) {
                        $search = $request->input('tecnologia').'('.$i.')';
                        $candidatos->orwhere('tecnologias', 'LIKE', '%' . $search . '%');
                    }

                } else {
                    $search = $request->input('nivel');
                    $candidatos->where('tecnologias', 'LIKE', '%' . $search . '%');
                }
                
                
            }
        }

        return $candidatos->paginate(10, ['*'], 'candidato_page');
    }
    public function peticiones()
    {
        return $this->belongsToMany (Peticion::class);
    }
}
