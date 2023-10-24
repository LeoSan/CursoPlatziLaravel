<input type="hidden" name="entidad" value="{{isset($entidad->id)?$entidad->getMorphClass():''}}">
<input type="hidden" name="entidad_id" value="{{@$entidad->id}}">
<div class="row">
    <div class="form-group col-md-4 mt-3">
        <label class="form-label" for="dom_departamento_id">Departamento {{isset($required)&&$required==false?'':'*'}} {{@$entidad->domicilio->departamento_id}}</label>
        <select name="departamento_id" id="dom_departamento_id" class="form-select input-regular-height   bg-w" onchange="selectMunicipios(this,'dom_municipio_caso')" {{isset($required)&&$required==false?'':'required'}}>
            <option value="">Seleccione el departamento</option>
            @foreach(getCatalogoElementos('departamentos') as $i)
                <option value="{{$i->id}}" {{( @$entidad->domicilio->departamento_id==$i->id ? 'selected' : ( old('departamento_id')==$i->id ? 'selected' :'' ) )}}>{{$i->nombre}}</option>
            @endforeach
        </select>
        <div class="invalid-feedback fw-regular" data-default="Dato obligatorio."></div>
    </div>

    <div class="form-group col-md-4 mt-3">
        <label class="form-label" for="dom_municipio_caso">Municipio {{isset($required)&&$required==false?'':'*'}}</label>
        <select name="municipio_id" id="dom_municipio_caso" class="form-select input-regular-height  bg-w" {{isset($required)&&$required==false?'':'required'}}>
            <option value="">Seleccione el municipio</option>
            @foreach(getCatalogoElementos('municipios') as $i)
                <option value="{{$i->id}}" {{( @$entidad->domicilio->municipio_id==$i->id ? 'selected' : ( old('municipio_id')==$i->id ? 'selected' :'' ) )}}>{{$i->nombre}}</option>
            @endforeach
        </select>
        <div class="invalid-feedback fw-regular" data-default="Dato obligatorio."></div>
    </div>
    <div class="form-group col-md-4 mt-3">
        <label class="form-label" for="dom_ciudad">Ciudad</label>
        <input type="text" class="form-control input-regular-height  bg-w" placeholder="Escriba la ciudad" name="ciudad" id="dom_ciudad"
               value="{{@$entidad->domicilio->ciudad??old('ciudad')}}" maxlength="255">
    </div>
    <div class="form-group col-md-4 mt-3">
        <label class="form-label" for="calle">Calle {{isset($required)&&$required==false?'':'*'}}</label>
        <input type="text" class="form-control input-regular-height  bg-w" placeholder="Escriba el nombre de la calle" name="calle" id="calle" {{isset($required)&&$required==false?'':'required'}}
               value="{{@$entidad->domicilio->calle??old('calle')}}" maxlength="255">
        <div class="invalid-feedback fw-regular" data-default="Dato obligatorio."></div>
    </div>
    <div class="form-group col-md-3 mt-3">
        <label class="form-label" for="num_exterior">Número exterior {{isset($required)&&$required==false?'':'*'}}</label>
        <input type="text" class="form-control input-regular-height  bg-w" placeholder="Escriba el número exterior" name="num_exterior" id="num_exterior" {{isset($required)&&$required==false?'':'required'}}
               value="{{@$entidad->domicilio->num_exterior??old('num_exterior')}}" maxlength="255">
        <div class="invalid-feedback fw-regular" data-default="Dato obligatorio."></div>
    </div>
    <div class="form-group col-md-3 mt-3">
        <label class="form-label" for="num_interior">Número interior</label>
        <input type="text" class="form-control input-regular-height  bg-w" placeholder="Escriba el número interior" name="num_interior" id="num_interior"
               value="{{@$entidad->domicilio->num_interior??old('num_interior')}}" maxlength="255">
    </div>
    <div class="form-group col-md-2 mt-3">
        <label class="form-label" for="codigo_postal">Código postal</label>
        <input type="text" class="form-control input-regular-height cp  bg-w" placeholder="00000" name="codigo_postal" id="codigo_postal" maxlength="5" value="{{@$entidad->domicilio->codigo_postal??old('codigo_postal')}}">
    </div>
</div>
