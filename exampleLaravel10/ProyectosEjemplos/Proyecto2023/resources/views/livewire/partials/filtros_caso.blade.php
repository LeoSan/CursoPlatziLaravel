<p class="m-0 text-end fw-bold">
    <a class="text-graydark d-inline d-md-none text-sin-subrayado fs-movil" data-bs-toggle="collapse" href="#collapseFiltrosCasos" role="button" aria-expanded="true" aria-controls="collapseFiltrosCasos">
    Filtros<span class="image"><img src="{{ asset('images/icons/icon-arrow-down-fill.svg') }}" class="ms-1"></span>
    </a>
</p>
<div class="collapse show" id="collapseFiltrosCasos">
    <div class="" id="contenedorCollapseFiltrosCasos">
        <div class="row justify-content-between">

            <div class="col-lg-3 col-md-4 col-sm-6 pe-md-4 my-1">
                <label class="label-xs text-gray small m-0">Fecha de ingreso a DNPJ:</label>
                <div class="row m-0 p-0">
                    <div class="col-6 p-0 pe-1">
                        <input type="{{$fecha_ingreso_desde||$fecha_ingreso_hasta?'date':'text'}}" class="form-control filtro-text w-100 input-filter-height filtro-fecha" placeholder="Desde"
                               wire:model="fecha_ingreso_desde">
                    </div>
                    <div class="col-6 p-0 ps-1">
                        <input type="{{$fecha_ingreso_desde||$fecha_ingreso_hasta?'date':'text'}}" class="form-control filtro-text w-100 input-filter-height filtro-fecha" placeholder="Hasta"
                               wire:model="fecha_ingreso_hasta">
                    </div>
                </div>
                @if($filtros['fecha_ingreso']['error'])
                    <div class="row p-0 m-0 text-center">
                        <small class="text-danger" style="font-size: 10px">{{$filtros['fecha_ingreso']['error']}}</small>
                    </div>
                @endif
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6 pe-md-4 my-1">
                <label class="label-xs text-gray small m-0">Fecha de notificación: {{@$fecha_notificacion_desde}}</label>
                <div class="row m-0 p-0">
                    <div class="col-6 p-0 pe-1">
                        <input type="{{$fecha_notificacion_desde||$fecha_notificacion_hasta?'date':'text'}}" class="form-control filtro-text w-100 input-filter-height filtro-fecha" placeholder="Desde"
                               wire:model="fecha_notificacion_desde">
                    </div>
                    <div class="col-6 p-0 ps-1">
                        <input type="{{$fecha_notificacion_desde||$fecha_notificacion_hasta?'date':'text'}}" class="form-control filtro-text w-100 input-filter-height filtro-fecha" placeholder="Hasta"
                               wire:model="fecha_notificacion_hasta">
                    </div>
                </div>
                @if($filtros['fecha_notificacion']['error'])
                    <div class="row p-0 m-0 text-center">
                        <small class="text-danger" style="font-size: 10px">{{$filtros['fecha_notificacion']['error']}}</small>
                    </div>
                @endif
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 my-1">
                <label for="asignado_filtro" class="label-xs text-gray small m-0">Asignado a:</label>
                <select wire:model="asignado" class="form-select filtro-select input-filter-height" id="asignado_filtro">
                    <option value="">Todos</option>
                    @foreach($analistas as $i)
                        <option value="{{$i->id}}">{{$i->nombreCompleto}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-auto col-sm-6 my-1">
                <label for="estatus_filtro" class="label-xs text-gray small m-0">Estatus:</label>
                @include('livewire.partials.select-multiple-estatus', ['cat_estatus'=>$cat_estatus])
            </div>

            <div class="col-md-4  col-sm-6 pe-md-4 my-1">
                <label for="cobrar_desde" class="label-xs text-gray small m-0">Monto a cobrar:</label>
                <div class="row m-0 p-0">
                    <div class="col-6 p-0 pe-1">
                        <input type="text" class="form-control filtro-text lempiras input-filter-height w-100" placeholder="Mínimo"
                               wire:model="cobrar_desde" id="cobrar_desde">
                    </div>
                    <div class="col-6 p-0 ps-1">
                        <input type="text" class="form-control filtro-text lempiras input-filter-height w-100" placeholder="Máximo"
                               wire:model="cobrar_hasta">
                    </div>
                </div>
                @if($filtros['monto_cobrar']['error'])
                    <div class="row p-0 m-0 text-center">
                        <small class="text-danger" style="font-size: 10px">{{$filtros['monto_cobrar']['error']}}</small>
                    </div>
                @endif
            </div>

            <div class="col-md-4  col-sm-6 px-md-4 my-1">
                <label for="cobrado_desde" class="label-xs text-gray small m-0">Monto cobrado:</label>
                <div class="row m-0 p-0">
                    <div class="col-6 p-0 pe-1">
                        <input type="text" class="form-control filtro-text lempiras input-filter-height w-100" placeholder="Mínimo"
                               wire:model="cobrado_desde" id="cobrado_desde">
                    </div>
                    <div class="col-6 p-0 ps-1">
                        <input type="text" class="form-control filtro-text lempiras input-filter-height w-100" placeholder="Máximo"
                               wire:model="cobrado_hasta">
                    </div>
                </div>
                @if($filtros['monto_cobrado']['error'])
                    <div class="row p-0 m-0 text-center">
                        <small class="text-danger" style="font-size: 10px">{{$filtros['monto_cobrado']['error']}}</small>
                    </div>
                @endif
            </div>


            <div class="col-md-4  col-sm-6 ps-md-4 my-1">
                <label for="cobrado_intereses_desde" class="label-xs text-gray small m-0">Monto cobrado con intereses:</label>
                <div class="row m-0 p-0">
                    <div class="col-6 p-0 pe-1">
                        <input type="text" class="form-control filtro-text lempiras input-filter-height w-100" placeholder="Mínimo"
                               wire:model="cobrado_intereses_desde" id="cobrado_intereses_desde">
                    </div>
                    <div class="col-6 p-0 ps-1">
                        <input type="text" class="form-control filtro-text lempiras input-filter-height w-100" placeholder="Máximo"
                               wire:model="cobrado_intereses_hasta">
                    </div>
                </div>
                @if($filtros['monto_cobrado_intereses']['error'])
                    <div class="row p-0 m-0 text-center">
                        <small class="text-danger" style="font-size: 10px">{{$filtros['monto_cobrado_intereses']['error']}}</small>
                    </div>
                @endif
            </div>

            @if($filtrado)
                <div class="col-md-12 mt-4">
                    <div class="d-flex justify-content-between w-100 mb-1 align-items-center">
                        <div class="w-100">
                            <div class="row g-3">
                                @foreach($filtros as $k => $i)
                                    @if(isset($i['valor']))
                                        <div class="col-md-auto col-sm-12">
                                            <div class="badge rounded-pill text-bg-light px-2 py-0 w-100 badge-filtro">
                                                <small><strong>{{$i['texto']}}</strong></small>
                                                <small>{{$i['valor']}}</small>
                                                <button class="btn p-0 px-1 m-0" wire:click="removeFiltro('{{$k}}')">
                                                    <i class="fa fa-times text-danger"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-default input-regular-height w-auto text-nowrap" wire:click="resetFiltros">Limpiar Filtros</button>
                            <!--
                            <button class="btn btn-secondary input-regular-height">Buscar</button>
                            -->
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-12 mt-3">
                <div class="border-bottom"></div>
            </div>

        </div>
    </div>
</div>
