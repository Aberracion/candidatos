@extends('layouts.app')
@section('title', 'Nuevo Candidato')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                Crear candidato
            </div>
            <div class="card-body">
                <form action="@if(!empty($candidato)) {{ route('candidatos.update', $candidato->id) }} @else {{ route('candidatos.store') }} @endif" method="POST" enctype="multipart/form-data">
                    @if(!empty($candidato))
                    @method('PUT')
                    @endif
                    @csrf
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" name="nombre" value="@if(!empty($candidato)) {{ $candidato->nombre }} @endif">
                    </div>
                    <div class="form-group">
                        <label for="">Apellidos</label>
                        <input type="text" class="form-control" name="apellidos" value="@if(!empty($candidato)) {{ $candidato->apellidos }} @endif">
                    </div>
                    <div class="form-group">
                        <label for="">Ubicación</label>
                        <input type="text" class="form-control" name="ubicacion" value="@if(!empty($candidato)) {{ $candidato->ubicacion }} @endif">
                    </div>
                    <div class="form-group">
                        <label for="">Sede</label>
                        <input type="text" class="form-control" name="sede" value="@if(!empty($candidato)) {{ $candidato->sede }} @endif">
                    </div>
                    <div class="form-group">
                        <label for="">Curriculum</label>
                        <input type="file" class="form-control" name="cv">
                    </div>
                    <div class="form-group">
                        <label for="">Estado</label>
                        <input type="text" class="form-control" name="estado" value="@if(!empty($candidato)) {{ $candidato->estado }} @endif">
                    </div>

                    <table class="form-group w-100">
                        <thead>
                        <th></th>
                        <th>Tecnología</th>
                        <th>Nivel</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <button class="addTecnologic">+</button>
                                </td>
                                <td><input type="text" class="form-control" name="tecnologias[name][]"></td>
                                <td><input type="number" class="form-control" name="tecnologias[level][]"></td>
                            </tr>
                        </tbody>
                    </table>


                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="{{ route('candidatos.index') }}" class="btn btn-danger">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {

        $(".addTecnologic").click(function (event) {
            event.preventDefault();
            $("tbody").append("<tr><td><button class='removeTecnologic'>-</button></td><td>\n\
                <input type='text' class='form-control' name='tecnologias[name][]'></td><td><input type='number' class='form-control' name='tecnologias[level][]'></td></tr>");
            $(".removeTecnologic").click(function (event) {
                event.preventDefault();
                $(this).parent().parent().remove();
            });
        });

        $(".removeTecnologic").click(function (event) {
            event.preventDefault();
            $(this).parent().parent().remove();
        });
    });


</script>
@endsection