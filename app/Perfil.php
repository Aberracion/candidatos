<?php

namespace Candidatos;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model {

    /**
     * Da de baja todos los perfiles del candidatos y da de alta los que reciba
     * @param type $id
     * @param type $tecnologias
     */
    public static function actualizarPerfiles($id, $tecnologias) {
        if (isset($tecnologias['name'])) {
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

}
