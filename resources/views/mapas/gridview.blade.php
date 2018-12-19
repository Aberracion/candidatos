<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                Candidatos
            </div>
            <div class="card-body">
                <table class='table table-hover table-sm'>
                    <thead>
                    <th>
                        Candidato
                    </th>
                    <th>
                        Ubicación
                    </th>
                    <th>
                        Estado
                    </th>
                    <th>
                        Tecnología
                    </th>
                    <th>
                        Asignaciones
                    </th>
                    </thead>
                    <tbody>
                        @foreach($candidatos_filtro as $candidato_filtro)
                        <tr>
                            <td>
                                {{ $candidato_filtro->candidato }}
                            </td>
                            <td>
                                {{ $candidato_filtro->ubicacion }}
                            </td>
                            <td>
                                {{ $candidato_filtro->estado }}
                            </td>
                            <td>
                                {{ $candidato_filtro->tecnologias }}
                            </td>
                            <td>
                                {{ $candidato_filtro->asignado }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $candidatos_filtro->links() }}
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                Peticiones
            </div>
            <div class="card-body">
                <table class='table table-hover table-sm'>
                    <thead>
                    <th>
                        Nombre
                    </th>
                    <th>
                        Contexto
                    </th>
                    <th>
                        Ubicación
                    </th>
                    <th>
                        Presencial
                    </th>
                    <th>
                        Asignados
                    </th>
                    </thead>
                    <tbody>
                        @foreach($peticiones_filtro as $peticion_filtro)
                        <tr>
                            <td>
                                {{ $peticion_filtro->name }}
                            </td>
                            <td>
                                {{ $peticion_filtro->contexto }}
                            </td>
                            <td>
                                {{ $peticion_filtro->ubicacion }}
                            </td>
                            <td>
                                @if($peticion_filtro->presencial == 0)
                                NO
                                @else
                                SI
                                @endif
                            </td>
                            <td>
                                {{ $peticion_filtro->asignados }}                                
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $peticiones_filtro->links() }}
            </div>
        </div>
    </div>
</div>