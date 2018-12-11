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
                        Nivel
                    </th>
                    </thead>
                    <tbody>
                        @foreach($candidatos as $candidato)
                        <tr>
                            <td>
                                {{ $candidato->candidato }}
                            </td>
                            <td>
                                {{ $candidato->ubicacion }}
                            </td>
                            <td>
                                {{ $candidato->estado }}
                            </td>
                            <td>
                                {{ $candidato->tecnologia }}
                            </td>
                            <td>
                                {{ $candidato->nivel }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $candidatos->links() }}
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
                        Ubicación
                    </th>
                    <th>
                        Presencial
                    </th>
                    </thead>
                    <tbody>
                        @foreach($peticiones as $peticion)
                        <tr>
                            <td>
                                {{ $peticion->name }}
                            </td>
                            <td>
                                {{ $peticion->ubicacion }}
                            </td>
                            <td>
                                {{ $peticion->presencial }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $peticiones->links() }}
            </div>
        </div>
    </div>
</div>