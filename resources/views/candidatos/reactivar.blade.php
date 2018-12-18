@extends('layouts.app')
@section('title', 'Reactivar')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                Listado de candidatos
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
                        Ubicacion
                    </th>
                    <th>
                        Sede
                    </th>
                    <th>
                        Estado
                    </th>                    
                    <th>
                        Está de baja
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
                                <button type="button" class="btn btn-warning btn-sm updateCandidato" baja="{{ $candidato->baja }}" pid="{{ $candidato->id }}">
                                    @if( $candidato->baja == '1' )
                                    SI
                                    @else
                                    NO
                                    @endif
                                </button>
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

<script type="text/javascript">
    $(function () {
        $(".updateCandidato").click(function () {
            var id = $(this).attr('pid');
            var option = 0;
            if($(this).attr('baja') == 0)
            {
                option = 1;
            }
            var obj = $(this);
            jQuery.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('/reactivar') }}",
                method: 'put',
                data: {
                    id: id,
                    option: option
                }
                ,
                success: function (result) {
                    if (result == "OK") {
                        obj.attr('baja', option);
                        if (option == 0) {
                            obj.html('NO');
                        } else {
                            obj.html('SI');
                        }
                    }
                }
            }
            );

        });
    });


</script>

@endsection