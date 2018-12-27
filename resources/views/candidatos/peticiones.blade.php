
<div class="form-row align-items-center">
	<div  class="col"><b>@lang('texts.petition.title')</b></div>
	<div  class="col"></div>
	<div  class="col"><b>@lang('texts.candidate.assign')</b></div>	
</div>
<div class="form-row align-items-center">
	<div  class="col"></div>
		<p></p>
	<div  class="col"  style=" display: flex;   justify-content: center;   align-items: center;">
	</div>
	<div  class="col"></div>	
</div>
<div class="form-row align-items-center">
	<div  class="col">
		<select name="origen[]" id="origen" multiple="multiple" size="8" class="form-control">
			@if(!empty($peticiones_libres))
				@foreach($peticiones_libres as $peticion)
					<option value="{{ $peticion['id'] }}" @if($editar==0) disabled=true @endif>{{ $peticion['name'] }}</option>
				@endforeach
			@endif
		</select>
	</div>
	<div  class="col"">
		<div style=" display: flex;   justify-content: center;   align-items: center;">
				<input type="button" class="pasar izq btn btn-primary"  style="margin: 5px;" value="@lang('texts.button.pass') »" @if($editar==0) disabled=true @endif />
				<input type="button" class="quitar der btn btn-primary"  style="margin: 5px;" value="« @lang('texts.button.quit')" @if($editar==0) disabled=true @endif />
		</div>
		<div style=" display: flex;   justify-content: center;   align-items: center;">
				<input type="button" class="pasartodos izq btn btn-primary"  style="margin: 5px;" value="@lang('texts.all') »" @if($editar==0) disabled=true @endif>
				<input type="button" class="quitartodos der btn btn-primary"  style="margin: 5px;" value="« @lang('texts.all')" @if($editar==0) disabled=true @endif>
		</div>
	</div>
	<div  class="col">
		<select name="destino[]" id="destino" multiple="multiple" size="8" class="form-control">
			@if(!empty($candidato->peticiones))
			    @foreach($candidato->peticiones as $asignacion)
			    	@if ($asignacion->baja == 0)
						<option value="{{ $asignacion->id }}" @if($editar==0) disabled=true @endif>{{ $asignacion->name }}</option>
					@endif
    			@endforeach
    		@endif
		</select>
	</div>
</div>
<br>

<script type="text/javascript">

$().ready(function() 
    {
        $('.pasar').click(function() { return !$('#origen option:selected').remove().appendTo('#destino'); });  
        $('.quitar').click(function() { return !$('#destino option:selected').remove().appendTo('#origen'); });
        $('.pasartodos').click(function() { $('#origen option').each(function() { $(this).remove().appendTo('#destino'); }); });
        $('.quitartodos').click(function() { $('#destino option').each(function() { $(this).remove().appendTo('#origen'); }); });
        $('.submit').click(function() { $('#destino option').prop('selected', 'selected'); });
    });

</script>