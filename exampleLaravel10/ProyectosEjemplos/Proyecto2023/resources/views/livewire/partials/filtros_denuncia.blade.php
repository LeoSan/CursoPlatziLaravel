<p class="m-0 text-end fw-bold">
    <a class="text-graydark d-inline d-md-none text-sin-subrayado fs-movil" data-bs-toggle="collapse" href="#collapseFiltrosDenuncias" role="button" aria-expanded="true" aria-controls="collapseFiltrosDenuncias">
        Filtros<span class="image"><img src="{{ asset('images/icons/icon-arrow-down-fill.svg') }}" class="ms-1"></span>
    </a>
</p>
<div class="collapse show" id="collapseFiltrosDenuncias">
    <div class="" id="contenedorCollapseFiltrosDenuncias">
        <div class="row justify-content-start">
            <div class="col-md-4 col-sm-12 py-1">
                <label class="col-auto label-xs small text-gray pt-1 mb-0">Fecha de la denuncia:</label>
                <div class="row m-0 p-0">
                    <div class="col-6 p-0 pe-1">
                        <input type="{{$fecha_denuncia_desde||$fecha_denuncia_hasta?'date':'text'}}" class="form-control filtro-text w-100 input-filter-height filtro-fecha" placeholder="Desde"
                               wire:model="fecha_denuncia_desde">
                    </div>
                    <div class="col-6 p-0 ps-1">
                        <input type="{{$fecha_denuncia_desde||$fecha_denuncia_hasta?'date':'text'}}" class="form-control filtro-text w-100 input-filter-height filtro-fecha" placeholder="Hasta"
                               wire:model="fecha_denuncia_hasta">
                    </div>
                </div>
                @if(isset($filtros['fecha_denuncia']['error']))
                    <div class="row p-0 m-0 text-center">
                        <small class="text-danger" style="font-size: 10px">{{$filtros['fecha_denuncia']['error']}}</small>
                    </div>
                @endif
            </div>
            @can('ver_completa_bandeja_denuncias')
                @cannot('ver_limitada_bandeja_denuncias')
                    <div class="col-md-4 col-sm-12 py-1">
                        <label for="departamento_filtro" class="col-auto label-xs small text-gray pt-1 mb-0">Departamento:</label>
                        <select wire:model="departamento" class="form-select filtro-select input-filter-height" id="departamento_filtro">
                            <option value="">Todos</option>
                            @foreach($cat_departa as $i)
                                <option value="{{$i->id}}">{{$i->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-12 py-1">
                        <label for="origen_filtro" class="col-auto label-xs small text-gray pt-1 mb-0">Origen:</label>
                        <select wire:model="origen" class="form-select filtro-select input-filter-height" id="origen_filtro">
                            <option value="">Todos</option>
                            @foreach($cat_origen as $i)
                                <option value="{{$i->id}}">{{$i->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-12 py-1">
                        <label for="recepcion" class="col-auto  label-xs small text-gray pt-1 mb-0">Medio de recepción:</label>
                        <select wire:model="recepcion" class="form-select filtro-select input-filter-height" id="recepcion">
                            <option value="">Todos</option>
                            @foreach($cat_medio_recepcion as $i)
                                <option value="{{$i->id}}">{{$i->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    @can('ver_toda_bandeja_denuncias')
                        <div class="col-md-4 col-sm-12 py-1">
                            <label for="auditor_asignado" class="col-auto label-xs small text-gray pt-1 mb-0">Asignado a:</label>
                            <select wire:model="asignado" class="form-select filtro-select input-filter-height" id="auditor_asignado">
                                <option value="">Todos</option>
                                @foreach($cat_auditors as $i)
                                    <option value="{{$i->id}}">{{$i->complete_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    @endcan
                @endcannot
            @endcan

            <div class="col-md-4 col-sm-12 py-1">
                <label for="estatus_filtro" class="col-auto  label-xs small text-gray pt-1 mb-0">Estatus:</label>
                <select wire:model="estatus" class="form-select filtro-select input-filter-height" id="estatus_filtro">
                    <option value="">Todos</option>
                    @foreach($cat_estatus as $i)
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
