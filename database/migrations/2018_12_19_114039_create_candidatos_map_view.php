<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidatosMapView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection()->getPdo()
                ->exec('CREATE VIEW candidatos_map AS select y.id, y.candidato, y.ubicacion, y.estado, y.tecnologias, group_concat(distinct y.asignaciones separator " - ") asignado
from
(select distinct
x.id, x.candidato, x.ubicacion, x.estado, group_concat(distinct x.tecno separator " - ") tecnologias, (select peticions.name from peticions where peticions.id=candidato_peticion.peticion_id) as asignaciones
from
	(select candidatos.id, CONCAT(candidatos.nombre, " ", candidatos.apellidos) as candidato, candidatos.ubicacion, candidatos.estado, CONCAT(perfils.tecnologia,"(", perfils.nivel,")") as tecno 
		from candidatos
		left join perfils on candidatos.id = perfils.id_candidato
		where candidatos.baja = 0
		and (perfils.baja = 0 or perfils.baja is null)
		) X
	left join candidato_peticion on x.id = candidato_peticion.candidato_id
	group by x.id,
	candidato_peticion.peticion_id) Y
	group by y.id, y.tecnologias');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::connection()->getPdo()
                ->exec('DROP VIEW candidatos_map');
    }
}
