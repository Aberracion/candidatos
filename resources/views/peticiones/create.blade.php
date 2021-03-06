@extends('layouts.app_typeahead')
@section('title', 'texts.petition.petition')
@section('content')
{{ app()->setLocale(session('language', 'en')) }}
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                @lang('texts.petition.petition')
            </div>
            <div class="card-body">
                <form action="@if(!empty($peticion)) {{ route('peticiones.update', $peticion->id) }} @else {{ route('peticiones.store') }} @endif" method="POST" enctype="multipart/form-data">
                    @if(!empty($peticion))
                    @method('PUT')
                    @endif
                    @csrf
                    <div class="form-group">
                        <label for="nombre"> @lang('texts.petition.name')</label>
                        <input type="text" class="form-control" name="nombre" 
                               @if($editar==0) disabled=true @endif 
                               value="@if(!empty($peticion)) {{ $peticion->name }} @endif">
                    </div>
                    <div class="form-group">
                        <label for=""> @lang('texts.petition.context')</label>
                        <input type="text" class="form-control" name="contexto" 
                               @if($editar==0) disabled=true @endif 
                               value="@if(!empty($peticion)) {{ $peticion->contexto }} @endif">
                    </div>
                    <div class="form-group">
                        <label for=""> @lang('texts.petition.mail')</label>
                        <input type="text" class="form-control" name="mail_comercial" 
                               @if($editar==0) disabled=true @endif 
                               value="@if(!empty($peticion)) {{ $peticion->mail_comercial }} @endif">
                    </div>
                    <div class="form-group">
                        <label for=""> @lang('texts.petition.location')</label>
                        <input type="text" class="form-control" name="ubicacion" id="ubicacion" autocomplete="off" @if($editar==0) disabled=true @endif 
                               value="@if(!empty($peticion)) {{ $peticion->ubicacion }} @endif">
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" name="presencial" @if($editar==0) disabled=true @endif 
                               value="1" @if(!empty($peticion)) @if($peticion->presencial==1) checked @endif @endif>
                        <label for="" class="form-check-label"> @lang('texts.petition.in_person')</label>
                    </div>

                    @include('peticiones.candidatos')

                    @if($editar==1)
                    <button type="submit" class="btn btn-primary">@lang('texts.button.save')</button>
                    <a href="{{ route('peticiones.index') }}" class="btn btn-danger">@lang('texts.button.cancel')</a>
                    @else
                    <a href="{{ route('peticiones.edit', $peticion->id) }}" class="btn btn-warning">@lang('texts.button.update')</a>
                    <a href="{{ route('peticiones.index') }}" class="btn btn-primary">@lang('texts.button.return')</a>
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
        source:  function (query, process) {
        return $.get(path, { query: query }, function (data) {
                return process(data);
            });
        }
    });

</script>
@endsection