<p class="m-0 text-end fw-bold">
    <a class="text-graydark d-inline d-md-none text-sin-subrayado fs-movil" data-bs-toggle="collapse" href="#collapseFiltros" role="button" aria-expanded="true" aria-controls="collapseFiltros">
        Filtros<span class="image"><img src="{{ asset('images/icons/icon-arrow-down-fill.svg') }}" class="ms-1"></span>
    </a>
</p>
<div class="collapse show" id="collapseFiltros">
    <div class="" id="contenedorCollapseFiltros">
        <div class="row justify-content-start">
            <div class="col-md-4 col-sm-12 py-1">
                <label for="region" class="col-auto  label-xs small text-gray pt-1 mb-0">Regional:</label>
                <select wire:model="region" class="form-select filtro-select input-filter-height" id="region">
                    <option value="">Seleccione</option>
                    @foreach ($cat_region as $i )
                        <option value="{{$i->id}}">{{$i->nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 col-sm-12 py-1">
                <label for="mes_filtro" class="col-auto label-xs small text-gray pt-1 mb-0">Mes:</label>
                <select wire:model="mes" class="form-select filtro-select input-filter-height" id="mes_filtro">
                    <option value="">Todos</option>
                    @foreach($cat_meses as $k => $i)
                        <option value="{{$k}}">{{$i}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 col-sm-12 py-1">
                <label class="col-auto label-xs small text-gray pt-1 mb-0">Fecha de solicitud:</label>
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
                @if(isset($filtros['fecha_solicitud']['error']))
                    <div class="row p-0 m-0 text-center">
                        <small class="text-danger" style="font-size: 10px">{{$filtros['fecha_solicitud']['error']}}</small>
                    </div>
                @endif
            </div>            
            <div class="col-md-4 col-sm-12 py-1">
                <label for="auditor" class="col-auto label-xs small text-gray pt-1 mb-0">Auditor:</label>
                <select wire:model="auditor" class="form-select filtro-select input-filter-height" id="auditor">
                    <option value="">Seleccione</option>
                    @foreach ($cat_auditors as $i )
                        <option value="{{$i->id}}">{{$i->complete_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 col-sm-12 py-1">
                <label for="estatus" class="col-auto label-xs small text-gray pt-1 mb-0">Estatus:</label>
                <select wire:model="estatus" class="form-select filtro-select input-filter-height" id="estatus">
                    <option value="">Seleccione</option>
                    @foreach ($cat_estatus as $i )
                        <option value="{{$i->id}}">{{$i->nombre}}</option>
                    @endforeach
                </select>
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
