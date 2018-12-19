@extends('layouts.app_typeahead')
@section('title', 'Candidato')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                Candidato
            </div>
            <div class="card-body">
                <form action="@if(!empty($candidato)) {{ route('candidatos.update', $candidato->id) }} @else {{ route('candidatos.store') }} @endif" method="POST" enctype="multipart/form-data">
                    @if(!empty($candidato))
                    @method('PUT')
                    @endif
                    @csrf
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" name="nombre" 
                               @if($editar==0) disabled=true @endif 
                               value="@if(!empty($candidato)) {{ $candidato->nombre }} @endif">
                    </div>
                    <div class="form-group">
                        <label for="">Apellidos</label>
                        <input type="text" class="form-control" name="apellidos" 
                               @if($editar==0) disabled=true @endif 
                               value="@if(!empty($candidato)) {{ $candidato->apellidos }} @endif">
                    </div>
                    <div class="form-group">
                        <label for="">Ubicación</label>
                        <input type="text" class="form-control" name="ubicacion" id="ubicacion" autocomplete="off"
                               @if($editar==0) disabled=true @endif 
                               value="@if(!empty($candidato)) {{ $candidato->ubicacion }} @endif">
                    </div>
                    <div class="form-group">
                        <label for="">Sede</label>
                        <input type="text" class="form-control" name="sede" 
                               @if($editar==0) disabled=true @endif 
                               value="@if(!empty($candidato)) {{ $candidato->sede }} @endif">
                    </div>
                    <div class="form-group">
                        <label for="">Curriculum</label>
                        @if(!empty($candidato->cv))
                        <a href="/docs/curriculums/{{ $candidato->cv }}" class="btn btn-info btn-sm ml-2">CV</a>
                        @endif
                        @if($editar==1)
                        <input type="file" class="form-control" name="cv">
                        @endif


                    </div>
                    <div class="form-group">
                        <label for="">Estado</label>
                        <input type="text" class="form-control" name="estado" 
                               @if($editar==0) disabled=true @endif 
                               value="@if(!empty($candidato)) {{ $candidato->estado }} @endif">
                    </div>

                    @include('candidatos.perfiles')

                    @include('candidatos.peticiones')

                    @if($editar==1)
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="{{ route('candidatos.index') }}" class="btn btn-danger">Cancelar</a>
                    @else
                    <a href="{{ route('candidatos.edit', $candidato->id) }}" class="btn btn-warning">Editar</a>
                    <a href="{{ route('candidatos.index') }}" class="btn btn-primary">Volver</a>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    var path = "{{ route('autocomplete') }}";

    $('#ubicacion').typeahead({
        minLength: 2,
        hint: true,
        source: function (query, process) {
            return $.get(path, {query: query}, function (data) {
                return process(data);
            });
        }
    });

</script>

@endsection

