@extends('layouts.app')
@section('title', 'texts.user.list')
@section('content')
{{ app()->setLocale(session('language', 'en')) }}
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                @lang('texts.user.list')
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
                        @lang('texts.user.name')
                    </th>
                    <th>
                        @lang('texts.user.email')
                    </th>
                    <th>
                        @lang('texts.user.verified')
                    </th>
                    <th>
                        @lang('texts.user.admin')
                    </th>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>
                                {{ $user->name }}
                            </td>
                            <td>
                                {{ $user->email }}
                            </td>
                            <td>
                                @if ( empty($user->email_verified_at) )
                                @lang('texts.no')
                                @else
                                @lang('texts.yes')
                                @endif
                            </td>
                            <td>
                                <select class="btn btn-warning btn-sm updateUser" pid="{{ $user->role_user_id }}"
                                        @if($user->name == 'superadmin')
                                        disabled="true"
                                        @endif
                                        >
                                        @foreach($roles as $rol)
                                        <option value="{{ $rol->id }}"
                                        @if($rol->id == $user->role_id)
                                        selected
                                        @endif

                                        >
                                        @if(App::isLocale('en'))
                                        {{ $rol->description_en }}
                                        @else
                                        {{ $rol->description_es }}
                                        @endif
                                </option>
                                @endforeach
                            </select>
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
        $(".updateUser").change(function () {
            var id = $(this).attr('pid');
            var option = $(this).val();

            var obj = $(this);
            jQuery.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('/permisos/changeRol') }}",
                method: 'post',
                data: {
                    id: id,
                    option: option
                }
                ,
                success: function (result) {
                    if (result == "OK") {
                    }
                }
            }
            );

        });
    });


</script>

@endsection