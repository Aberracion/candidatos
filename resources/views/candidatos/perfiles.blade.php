<table class="form-group w-100">
    <thead>
    <th>@if($editar==1)<button class="addTecnologic">+</button>@endif</th>
    <th>@lang('texts.candidate.tecnologic')</th>
    <th>@lang('texts.candidate.level')</th>
</thead>
<tbody>
    @if(!empty($perfiles))
    @foreach($perfiles as $perfil)
    <tr>
        <td>
            @if($editar==1)<button class="removeTecnologic">-</button>@endif
        </td>
        <td><input type="text" class="form-control" name="tecnologias[name][]" 
                   value="{{ $perfil->tecnologia }}" @if($editar==0) disabled=true @endif></td>
        <td><input type="number" class="form-control" name="tecnologias[level][]" 
                   value="{{ $perfil->nivel }}" @if($editar==0) disabled=true @endif></td>
    </tr>
    @endforeach
    @endif
</tbody>
</table>

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