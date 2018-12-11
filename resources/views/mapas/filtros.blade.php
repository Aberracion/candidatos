<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                Filtros
            </div>
            <div class="card-body">
                <form action="{{ url('maps') }}" method="POST" name="filtros">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Ubicación de la petición</label>
                            <input type="text" class="form-control ftext" name="ubicacionPet" value="{{ app('request')->input('ubicacionPet') }}" />
                        </div>
                        <div class="form-group col-md-6">
                            <label>Ubicación del candidato</label>
                            <input type="text" class="form-control ftext" name="ubicacionCand" value="{{ app('request')->input('ubicacionCand') }}" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Cliente</label>
                            <input type="text" class="form-control ftext" name="cliente" value="{{ app('request')->input('cliente') }}"/>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Tecnología</label>
                            <input type="text" class="form-control ftext" name="tecnologia" value="{{ app('request')->input('tecnologia') }}"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Presencial</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="radio" name="presencial" value="0" class="fradio"
                                           @if(app('request')->input('presencial') == 0)
                                           checked="checked"
                                           @endif
                                           /> Todos
                                </div>
                                <div class="col-md-4">
                                    <input type="radio"  name="presencial" value="1" class="fradio"
                                           @if(app('request')->input('presencial') == "1")
                                           checked="checked"
                                           @endif /> No
                                </div>
                                <div class="col-md-4">
                                    <input type="radio"  name="presencial" value="2" class="fradio"
                                           @if(app('request')->input('presencial') == "2")
                                           checked="checked"
                                           @endif/> Si
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Nivel tecnológico Mínimo</label>
                            <input type="number" class="form-control ftext" name="nivel" value="{{ app('request')->input('nivel') }}"/>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                    <button onclick="javascript:resetear()" class="btn btn-primary">Resetear</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script language="javascript">
    function resetear() {
        $('.ftext').val('');
        $('.fradio').val(0);
    }
</script>