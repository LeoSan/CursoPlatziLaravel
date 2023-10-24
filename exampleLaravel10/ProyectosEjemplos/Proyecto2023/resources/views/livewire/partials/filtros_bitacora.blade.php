<p class="m-0 text-end fw-bold">
    <a class="text-graydark d-inline d-md-none text-sin-subrayado fs-movil" data-bs-toggle="collapse" href="#collapseFiltrosDenuncias" role="button" aria-expanded="true" aria-controls="collapseFiltrosDenuncias">
        Filtros<span class="image"><img src="{{ asset('images/icons/icon-arrow-down-fill.svg') }}" class="ms-1"></span>
    </a>
</p>
<div class="collapse show" id="collapseFiltrosDenuncias">
    <div class="" id="contenedorCollapseFiltrosDenuncias">
        <div class="row justify-content-start">
            @can('ver_toda_bitacoras')
                <div class="col-md-4 col-sm-12 py-1">
                    <label for="dependencia_filtro" class="col-auto col-form-label small text-gray pb-0">Dependencia:</label>
                    <select wire:model="dependencia" class="form-select filtro-select input-filter-height" id="dependencia_filtro">
                        <option value="">Todos</option>
                        @foreach($cat_dependencia as $i)
                            <option value="{{$i->id}}">{{$i->nombre}}</option>
                        @endforeach
                    </select>
                </div>
            @endcan

            <div class="col-md-4 col-sm-12 py-1">
                <label for="componente_filtro" class="col-auto col-form-label small text-gray pb-0">Componente:</label>
                    <select wire:model="componente" class="form-select filtro-select input-filter-height" id="componente_filtro">
                        <option value="">Todos</option>
                        @foreach($cat_componente_array as $key => $valor)
                            <option value="{{$valor}}">{{$valor}}</option>
                        @endforeach
                    </select>
            </div>

            <div class="col-md-4 col-sm-12 py-1">
                <label for="accion_filtro" class="col-auto col-form-label small text-gray pb-0">Acción:</label>
                <select wire:model="accion" class="form-select filtro-select input-filter-height" id="accion_filtro">
                    <option value="">Todos</option>
                    @foreach($cat_accion_array as $key => $valor)
                        <option value="{{$valor}}">{{$valor}}</option>
                    @endforeach
                </select>
            </div>

            @can('ver_toda_bitacoras')
                @include('livewire.partials.select-multiple', ['cat_usuarios'=>$cat_usuarios])
            @endcan

            <div class="col-md-4 col-sm-12 py-1">
                <label class="col-auto col-form-label small text-gray pb-0">Fecha:</label>
                <div class="row m-0 p-0">
                    <div class="col-6 p-0 pe-1">
                        <input type="{{$fecha_desde||$fecha_hasta?'date':'text'}}" class="form-control filtro-text w-100 input-filter-height filtro-fecha" placeholder="Desde"
                               wire:model="fecha_desde">
                    </div>
                    <div class="col-6 p-0 ps-1">
                        <input type="{{$fecha_desde||$fecha_hasta?'date':'text'}}" class="form-control filtro-text w-100 input-filter-height filtro-fecha" placeholder="Hasta"
                               wire:model="fecha_hasta">
                    </div>
                </div>
                @if(isset($filtros['fecha']['error']))
                    <div class="row p-0 m-0 text-center">
                        <small class="text-danger" style="font-size: 10px">{{$filtros['fecha']['error']}}</small>
                    </div>
                @endif
            </div>

            @if($filtrado)
                <div class="col-md-12 mt-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="w-100">
                            <div class="row">
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
                        <div class="">
                            <button class="btn btn-default input-regular-height text-nowrap" wire:click="resetFiltros">Limpiar filtros</button>
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
