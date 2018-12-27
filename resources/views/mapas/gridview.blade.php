<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                @lang('texts.candidate.title')
            </div>
            <div class="card-body">
                <table class='table table-hover table-sm'>
                    <thead>
                    <th>
                        @lang('texts.candidate.candidate')
                    </th>
                    <th>
                        @lang('texts.candidate.location')
                    </th>
                    <th>
                        @lang('texts.candidate.state')
                    </th>
                    <th>
                        @lang('texts.candidate.tecnologic')
                    </th>
                    <th>
                        @lang('texts.candidate.assign')
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
                @lang('texts.petition.title')
            </div>
            <div class="card-body">
                <table class='table table-hover table-sm'>
                    <thead>
                    <th>
                        @lang('texts.petition.name')
                    </th>
                    <th>
                        @lang('texts.petition.context')
                    </th>
                    <th>
                        @lang('texts.petition.location')
                    </th>
                    <th>
                        @lang('texts.petition.in_person')
                    </th>
                    <th>
                        @lang('texts.petition.assign')
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
                                @lang('texts.no')
                                @else
                                @lang('texts.yes')
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