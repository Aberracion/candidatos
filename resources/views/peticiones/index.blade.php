@extends('layouts.app')
@section('title', 'texts.petition.list')
@section('content')
{{ app()->setLocale(session('language', 'en')) }}
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                @lang('texts.petition.list')
                <a href="{{ route('peticiones.create') }}" class="btn btn-success btn-sm float-right">@lang('texts.button.new.petition')</a>
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
                        @lang('texts.petition.name')
                    </th>
                    <th>
                        @lang('texts.petition.context')
                    </th>
                    <th>
                        @lang('texts.petition.mail')
                    </th>
                    <th>
                        @lang('texts.petition.location')
                    </th>
                    <th>
                        @lang('texts.petition.in_person')
                    </th>
                    <th>
                        @lang('texts.actions')
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
                                    @lang('texts.yes')
                                @else 
                                    @lang('texts.no')
                                @endif
                            </td>
                            <td>
                                <a href="javascript:document.getElementById('delete-{{$peticion->id}}').submit()" class="btn btn-danger btn-sm float-right ml-2 deleteModal">@lang('texts.button.delete')</a>
                                <form id="delete-{{$peticion->id}}" action="{{ route('peticiones.destroy', $peticion->id) }}" method="POST" class="deleteModal">
                                    @method('delete')
                                    @csrf
                                </form>
                                <a href="{{ route('peticiones.edit', $peticion->id) }}" class="btn btn-warning btn-sm float-right ml-2">@lang('texts.button.update')</a>
                                <a href="{{ route('peticiones.show', $peticion->id) }}" class="btn btn-primary btn-sm float-right ml-2">@lang('texts.button.view')</a>

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
    var message = "<?php echo __('texts.confirm.petition.delete');  ?>"
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