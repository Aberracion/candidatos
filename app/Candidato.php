<?php

namespace Candidatos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Candidato extends Model {

    public static function getCandidatosGridMapas($request) {
        $candidatos = DB::table('candidatos')
                ->leftJoin('perfils', 'candidatos.id', '=', 'perfils.id_candidato')
                ->select(DB::raw("CONCAT(candidatos.nombre, ' ', candidatos.apellidos) as candidato"), 'candidatos.ubicacion', 'candidatos.estado', 'perfils.tecnologia', 'perfils.nivel')
                ->where('candidatos.baja', 0)
                ->where(function($q) {
                    $q->where('perfils.baja', 0)
                    ->orWhereNull('perfils.baja');
                })
                ->orderBy('candidato', 'asc')
                ->orderBy('nivel', 'desc')
                ->orderBy('tecnologia', 'asc');
        if (isset($request)) {
            if ($request->input('ubicacionCand') != "") {
                $candidatos->where('candidatos.ubicacion', 'LIKE', '%' . $request->input('ubicacionCand') . '%');
            }
            if ($request->input('tecnologia') != "") {
                $candidatos->where('perfils.tecnologia', 'LIKE', '%' . $request->input('tecnologia') . '%');
            }
            if ($request->input('nivel') != "" && $request->input('nivel') > 0) {
                $candidatos->where('perfils.nivel', '>=', $request->input('nivel'));
            }
        }

        return $candidatos->paginate(10);
    }

}
