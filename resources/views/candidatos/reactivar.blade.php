@extends('layouts.app')
@section('title', 'texts.candidate.reactivation')
@section('content')
{{ app()->setLocale(session('language', 'en')) }}
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                @lang('texts.candidate.list')
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
                        @lang('texts.candidate.name')
                    </th>
                    <th>
                        @lang('texts.candidate.lastname')
                    </th>
                    <th>
                        @lang('texts.candidate.location')
                    </th>
                    <th>
                        @lang('texts.candidate.headquarters')
                    </th>
                    <th>
                        @lang('texts.candidate.state')
                    </th>                    
                    <th>
                        @lang('texts.candidate.low')
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
                                    @lang('texts.yes')
                                    @else
                                    @lang('texts.no')
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
    var no = "<?php echo __('texts.no'); ?>";
    var yes = "<?php echo __('texts.yes'); ?>";
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
                            obj.html(no);
                        } else {
                            obj.html(yes);
                        }
                    }
                }
            }
            );

        });
    });


</script>

@endsection