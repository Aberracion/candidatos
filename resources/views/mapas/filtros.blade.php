<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                @lang('texts.filter.title')
            </div>
            <div class="card-body">
                <form action="{{ url('maps') }}" method="POST" name="filtros">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>@lang('texts.filter.petition')</label>
                            <input type="text" class="form-control ftext1" id='ftext' name="ubicacionPet" value="{{ app('request')->input('ubicacionPet') }}" />
                        </div>
                        <div class="form-group col-md-6">
                            <label>@lang('texts.filter.candidate')</label>
                            <input type="text" class="form-control ftext" name="ubicacionCand" value="{{ app('request')->input('ubicacionCand') }}" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>@lang('texts.filter.client')</label>
                            <input type="text" class="form-control ftext" name="cliente" value="{{ app('request')->input('cliente') }}"/>
                        </div>
                        <div class="form-group col-md-6">
                            <label>@lang('texts.filter.tecnologic')</label>
                            <input type="text" class="form-control ftext" name="tecnologia" value="{{ app('request')->input('tecnologia') }}"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>@lang('texts.filter.in_person')</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="radio" name="presencial" value="0" class="fradio"
                                           @if(app('request')->input('presencial') == 0)
                                           checked="checked"
                                           @endif
                                           /> @lang('texts.all')
                                </div>
                                <div class="col-md-4">
                                    <input type="radio"  name="presencial" value="1" class="fradio"
                                           @if(app('request')->input('presencial') == "1")
                                           checked="checked"
                                           @endif /> @lang('texts.no')
                                </div>
                                <div class="col-md-4">
                                    <input type="radio"  name="presencial" value="2" class="fradio"
                                           @if(app('request')->input('presencial') == "2")
                                           checked="checked"
                                           @endif/> @lang('texts.yes')
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>@lang('texts.filter.level')</label>
                            <input type="number" class="form-control ftext" name="nivel" value="{{ app('request')->input('nivel') }}"/>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">@lang('texts.button.filter')</button>
                    <button onclick="javascript:resetear()" class="btn btn-primary">@lang('texts.button.reset')</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script language="javascript">
    
    function resetear() {
        $('.ftext').val('');
        $('.fradio').val(0);
        return false;
    }
</script>