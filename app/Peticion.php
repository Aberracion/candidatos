<?php

namespace Candidatos;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;


class Peticion extends Model {

    public static function getPeticionesGridMapas($request) {
        $peticiones = Peticion::where('baja', 0);
        if (isset($request)) {
            if ($request->input('ubicacionPet') != "") {
                $peticiones->where('ubicacion', 'LIKE', '%' . $request->input('ubicacionPet') . '%');
            }
            if ($request->input('cliente') != "") {
                $peticiones->where('name', 'LIKE', '%' . $request->input('cliente') . '%');
            }
            if ($request->input('presencial') != "" && $request->input('presencial') != 0) {
                $peticiones->where('presencial', $request->input('presencial') - 1);
            }
        }

        return $peticiones->paginate(10, ['*'], 'peticion_page');
    }

}
