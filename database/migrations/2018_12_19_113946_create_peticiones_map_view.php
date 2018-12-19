<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeticionesMapView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection()->getPdo()
                ->exec('CREATE VIEW peticiones_map AS select x.id, x.name, x.contexto, x.mail_comercial, x.ubicacion, x.presencial, group_concat(distinct x.asignado separator ", ") asignados				
from
(select distinct peticions.id, peticions.name, peticions.contexto, peticions.mail_comercial, peticions.ubicacion, peticions.presencial, (select CONCAT(candidatos.nombre, " ", candidatos.apellidos) from candidatos where candidatos.id=candidato_peticion.candidato_id and candidatos.baja=0) asignado
		from peticions
		left join candidato_peticion on candidato_peticion.peticion_id = peticions.id
		where peticions.baja = 0) X
		group by x.id;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::connection()->getPdo()
                ->exec('DROP VIEW peticiones_map');
    }
}
