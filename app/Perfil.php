<?php

namespace Candidatos;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model {

    public static function actualizarPerfiles($id, $tecnologias) {
        Perfil::where('baja', 0)
                ->where('id_candidato', '=', $id)
                ->update(['baja' => 1]);


        foreach ($tecnologias['name'] as $key => $tecnologia) {
            $tec = Perfil::where('id_candidato', $id)
                    ->where('tecnologia', '=', $tecnologia)
                    ->first();
            if ($tec) {
                Perfil::where('id_candidato', $id)
                        ->where('tecnologia', '=', $tecnologia)
                        ->update(['baja' => 0, 'nivel' => $tecnologias['level'][$key]]);
            } else if ($tecnologia != null) {
                $perfil = new Perfil();
                $perfil->id_candidato = $id;
                $perfil->nivel = $tecnologias['level'][$key];
                $perfil->tecnologia = $tecnologia;
                $perfil->baja = 0;
                $perfil->save();
            }
        }
    }

}
