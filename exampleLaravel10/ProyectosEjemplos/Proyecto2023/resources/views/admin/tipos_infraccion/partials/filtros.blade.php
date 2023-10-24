<form method="GET" class="row pb-2" action="{{route('tiposInfraccion.index')}}" id="formBusquedaTiposInfraccion">

    <div class="col-md-12 py-2 d-flex justify-content-end text-end align-items-center border-bottom mb-1">
        <input type="text" class="form-control busqueda_casos font-regular-size bg-white input-regular-height" value="{{@$_GET['busqueda']??old('busqueda')}}" name="busqueda" id="busqueda" placeholder="Busque por tipo de infracción">
        <button type="submit" class="btn btn-secondary busqueda_casos ms-2 input-regular-height">Buscar</button>
        @if(isset($_GET['busqueda']) && $_GET['busqueda']!="")
            <button class="btn btn-default busqueda_casos ms-2 input-regular-height" id="btn_reset_busqueda" type="button">Cancelar</button>
        @endif
    </div>
    <div class="col-md-12">
        <div class="row justify-content-between mb-2">
            <div class="col-md-2">
                <label for="anio_infraccion" class="label-xs text-gray small m-0">Año:</label>
                <select name="anio" class="form-select filtro-select" id="anio_infraccion">
                    <option value="">Todos</option>
                    @foreach($anios as $i)
                        <option value="{{$i->anio}}" {{@$_GET['anio']==$i->anio?'selected':old('anio')}}>{{$i->anio}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="asignado_filtro" class="label-xs text-gray small m-0">Monto de multa:</label>
                <div class="row m-0 p-0">
                    <div class="col-6 p-0 pe-1">
                        <input type="text" class="form-control filtro-text lempiras w-100" placeholder="Mínimo"
                               name="minimo" value="{{@$_GET['minimo']??old('minimo')}}">
                    </div>
                    <div class="col-6 p-0 ps-1">
                        <input type="text" class="form-control filtro-text lempiras w-100" placeholder="Máximo"
                               name="maximo" value="{{@$_GET['maximo']??old('maximo')}}">
                    </div>
                </div>
                @if(isset($filtros['monto'])&&$filtros['monto']['error'])
                    <div class="row p-0 m-0 text-center">
                        <small class="text-danger" style="font-size: 10px">{{$filtros['monto']['error']}}</small>
                    </div>
                @endif
            </div>
            <div class="col-md-2">
                <label for="estatus_infraccion" class="label-xs text-gray small m-0">Estatus:</label>
                <select name="estatus" class="form-select filtro-select" id="estatus_infraccion">
                    <option value="">Todos</option>
                    <option value="1" {{@$_GET['estatus']=="1"?'selected':old('estatus')}}>Activos</option>
                    <option value="0" {{@$_GET['estatus']=="0"?'selected':old('estatus')}}>Inactivos</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="editable_infraccion" class="label-xs text-gray small m-0">Editable:</label>
                <select name="editable" class="form-select filtro-select" id="editable_infraccion">
                    <option value="">Todos</option>
                    <option value="1" {{@$_GET['editable']=="1"?'selected':old('editable')}}>Sí</option>
                    <option value="0" {{@$_GET['editable']=="0"?'selected':old('editable')}}>No</option>
                </select>
            </div>
        </div>
    </div>
        <div class="col-md-8">
            @if($filtrado)
                <div class="row my-2">
                    <div class="col-lg-10 col-md-8 mb-sm-2">
                        <div class="row g-3">
                            @foreach($filtros as $k => $i)
                                @if(isset($i['valor']) && $i['valor']!="")
                                    <div class="col-md-auto col-sm-12">
                                        <div class="badge rounded-pill text-bg-light px-2 py-0 w-100 badge-filtro">
                                            <small><strong>{{$i['texto']}}</strong></small>
                                            <small>{{$i['valor']}}</small>
                                            <a href="{{route('tiposInfraccion.index',array_merge($_GET,[$k=>null]))}}" class="btn p-0 px-1 m-0">
                                                <i class="fa fa-times text-danger"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-md-4">
            <div class="row justify-content-end">
                <div class="col-md-auto">
                    <button class="btn btn-secondary input-regular-height w-100">Filtrar
                    </button>
                </div>
                @if($filtrado)
                    <div class="col-md-auto">
                        <a href="{{route('tiposInfraccion.index')}}" class="btn btn-secondary input-regular-height w-100" style="line-height: 30px">Limpiar
                            FILTROS
                        </a>
                    </div>
                @endif
            </div>
        </div>
    <div class="col-12 border-bottom pb-1"></div>
</form>
