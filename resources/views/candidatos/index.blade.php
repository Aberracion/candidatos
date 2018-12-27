@extends('layouts.app')
@section('title', 'texts.candidate.list')
@section('content')
{{ app()->setLocale(session('language', 'en')) }}
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                @lang('texts.candidate.list')
                <a href="{{ route('candidatos.create') }}" class="btn btn-success btn-sm float-right">@lang('texts.button.new.candidate')</a>
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
                        @lang('texts.actions')
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
                                <a href="javascript:document.getElementById('delete-{{$candidato->id}}').submit()" class="btn btn-danger btn-sm float-right ml-2 deleteModal">@lang('texts.button.delete')</a>
                                <form id="delete-{{$candidato->id}}" action="{{ route('candidatos.destroy', $candidato->id) }}" method="POST" class="deleteModal">
                                    @method('delete')
                                    @csrf
                                </form>
                                <a href="{{ route('candidatos.edit', $candidato->id) }}" class="btn btn-warning btn-sm float-right ml-2">@lang('texts.button.update')</a>
                                <a href="{{ route('candidatos.show', $candidato->id) }}" class="btn btn-primary btn-sm float-right ml-2">@lang('texts.button.view')</a>

                                @if(!empty($candidato->cv))
                                <a href="/docs/curriculums/{{ $candidato->cv }}" class="btn btn-info btn-sm float-right ml-2">@lang('texts.button.cv')</a>
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
    var message = "<?php echo __('texts.confirm.candidate.delete');  ?>"
    $(function () {
        $(".deleteModal").click(function (event) {
            event.preventDefault();
            $("#confirmText").html(message);
            $("#confirmAceptar").attr('href', $(this).attr('href'));
            $("#confirm").modal('show');
        });
    });


</script>

@endsection