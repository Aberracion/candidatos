@extends('layouts.app_typeahead')
@section('title', 'texts.candidate.candidate')
@section('content')
{{ app()->setLocale(session('language', 'en')) }}
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                @lang('texts.candidate.candidate')
            </div>
            <div class="card-body">
                <form action="@if(!empty($candidato)) {{ route('candidatos.update', $candidato->id) }} @else {{ route('candidatos.store') }} @endif" method="POST" enctype="multipart/form-data">
                    @if(!empty($candidato))
                    @method('PUT')
                    @endif
                    @csrf
                    <div class="form-group">
                        <label for="nombre">@lang('texts.candidate.name')</label>
                        <input type="text" class="form-control" name="nombre" 
                               @if($editar==0) disabled=true @endif 
                               value="@if(!empty($candidato)) {{ $candidato->nombre }} @endif">
                    </div>
                    <div class="form-group">
                        <label for="">@lang('texts.candidate.lastname')</label>
                        <input type="text" class="form-control" name="apellidos" 
                               @if($editar==0) disabled=true @endif 
                               value="@if(!empty($candidato)) {{ $candidato->apellidos }} @endif">
                    </div>
                    <div class="form-group">
                        <label for="">@lang('texts.candidate.location')</label>
                        <input type="text" class="form-control" name="ubicacion" id="ubicacion" autocomplete="off"
                               @if($editar==0) disabled=true @endif 
                               value="@if(!empty($candidato)) {{ $candidato->ubicacion }} @endif">
                    </div>
                    <div class="form-group">
                        <label for="">@lang('texts.candidate.headquarters')</label>
                        <input type="text" class="form-control" name="sede" 
                               @if($editar==0) disabled=true @endif 
                               value="@if(!empty($candidato)) {{ $candidato->sede }} @endif">
                    </div>
                    <div class="form-group">
                        <label for="">@lang('texts.candidate.curriculum')</label>
                        @if(!empty($candidato->cv))
                        <a href="/docs/curriculums/{{ $candidato->cv }}" class="btn btn-info btn-sm ml-2">@lang('texts.button.cv')</a>
                        @endif
                        @if($editar==1)
                        <input type="file" class="form-control" name="cv">
                        @endif


                    </div>
                    <div class="form-group">
                        <label for="">@lang('texts.candidate.state')</label>
                        <input type="text" class="form-control" name="estado" 
                               @if($editar==0) disabled=true @endif 
                               value="@if(!empty($candidato)) {{ $candidato->estado }} @endif">
                    </div>

                    @include('candidatos.perfiles')

                    @include('candidatos.peticiones')

                    @if($editar==1)
                    <button type="submit" class="btn btn-primary">@lang('texts.button.save')</button>
                    <a href="{{ route('candidatos.index') }}" class="btn btn-danger">@lang('texts.button.cancel')</a>
                    @else
                    <a href="{{ route('candidatos.edit', $candidato->id) }}" class="btn btn-warning">@lang('texts.button.update')</a>
                    <a href="{{ route('candidatos.index') }}" class="btn btn-primary">@lang('texts.button.return')</a>
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

