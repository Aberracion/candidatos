@extends('layouts.app')
@section('title', 'Listado de Candidatos')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                Listado de candidatos
                <a href="{{ route('candidatos.create') }}" class="btn btn-success btn-sm float-right">Nuevo candidato</a>
            </div>
            <div class="card-body">
                @if(session('info'))
                <div class='alert alert-success'>
                    {{ session('info') }}
                </div>
                @endif
                <table class='table table-hover table-sm'>
                    <thead>
                    <th>
                        Nombre
                    </th>
                    <th>
                        Apellidos
                    </th>
                    <th>
                        Ubicación
                    </th>
                    <th>
                        Sede
                    </th>
                    <th>
                        Estado
                    </th>
                    <th>
                        Acción
                    </th>
                    </thead>
                    <tbody>
                        @foreach($candidatos as $candidato)
                        <tr>
                            <td>
                                {{ $candidato->nombre }}
                            </td>
                            <td>
                                {{ $candidato->apellidos }}
                            </td>
                            <td>
                                {{ $candidato->ubicacion }}
                            </td>
                            <td>
                                {{ $candidato->sede }}
                            </td>
                            <td>
                                {{ $candidato->estado }}
                            </td>
                            <td>
                                <a href="javascript:document.getElementById('delete-{{$candidato->id}}').submit()" class="btn btn-danger btn-sm float-right ml-2 deleteModal">Eliminar</a>
                                <form id="delete-{{$candidato->id}}" action="{{ route('candidatos.destroy', $candidato->id) }}" method="POST" class="deleteModal">
                                    @method('delete')
                                    @csrf
                                </form>
                                <a href="{{ route('candidatos.edit', $candidato->id) }}" class="btn btn-warning btn-sm float-right ml-2">Modificar</a>
                                <a href="{{ route('candidatos.show', $candidato->id) }}" class="btn btn-primary btn-sm float-right ml-2">Ver</a>

                                @if(!empty($candidato->cv))
                                <a href="/docs/curriculums/{{ $candidato->cv }}" class="btn btn-info btn-sm float-right ml-2">CV</a>
                                @endif

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
</div>

</h1>
@include('global.confirm')

<script type="text/javascript">
    $(function () {

        $(".deleteModal").click(function (event) {
            event.preventDefault();
            $("#confirmText").html("¿Desea eliminar el producto?");
            $("#confirmAceptar").attr('href', $(this).attr('href'));
            $("#confirm").modal('show');
        });
    });


</script>

@endsection