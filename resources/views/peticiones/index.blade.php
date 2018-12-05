@extends('layouts.app')
@section('title', 'Listado de Peticiones')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                Listado de Peticiones
                <a href="{{ route('peticiones.create') }}" class="btn btn-success btn-sm float-right">Nueva peticion</a>
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
                        Contexto
                    </th>
                    <th>
                        Mail Comercial
                    </th>
                    <th>
                        Ubicación
                    </th>
                    <th>
                        Presencial
                    </th>
                    <th>
                        Acción
                    </th>
                    </thead>
                    <tbody>
                        @foreach($peticiones as $peticion)                        
                        <tr>
                            <td>
                                {{ $peticion->name }}
                            </td>
                            <td>
                                {{ $peticion->contexto }}
                            </td>
                            <td>
                                {{ $peticion->mail_comercial }}
                            </td>
                            <td>
                                {{ $peticion->ubicacion }}
                            </td>
                            <td>
                                @if($peticion->presencial==1)
                                    Sí
                                @else 
                                    No
                                @endif
                            </td>
                            <td>
                                <a href="javascript:document.getElementById('delete-{{$peticion->id}}').submit()" class="btn btn-danger btn-sm float-right ml-2 deleteModal">Eliminar</a>
                                <form id="delete-{{$peticion->id}}" action="{{ route('peticiones.destroy', $peticion->id) }}" method="POST" class="deleteModal">
                                    @method('delete')
                                    @csrf
                                </form>
                                <a href="{{ route('peticiones.edit', $peticion->id) }}" class="btn btn-warning btn-sm float-right ml-2">Modificar</a>
                                <a href="{{ route('peticiones.show', $peticion->id) }}" class="btn btn-primary btn-sm float-right ml-2">Ver</a>

                            </td>
                        </tr>
                        @endforeach                        
                    </tbody>
                </table>
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