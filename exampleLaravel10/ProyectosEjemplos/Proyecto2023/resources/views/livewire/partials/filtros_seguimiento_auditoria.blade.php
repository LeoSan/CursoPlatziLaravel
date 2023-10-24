<p class="m-0 text-end fw-bold">
    <a class="text-graydark d-inline d-md-none text-sin-subrayado fs-movil" data-bs-toggle="collapse" href="#collapseFiltrosDenuncias" role="button" aria-expanded="true" aria-controls="collapseFiltrosDenuncias">
        Filtros<span class="image"><img src="{{ asset('images/icons/icon-arrow-down-fill.svg') }}" class="ms-1"></span>
    </a>
</p>
<div class="collapse show" id="collapseFiltrosDenuncias">
    <div class="" id="contenedorCollapseFiltrosDenuncias">
        <div class="row justify-content-start">

            <div class="col-md-4 col-sm-12 py-1">
                <label for="departamento_filtro" class="col-auto label-xs small text-gray pt-1 mb-0">Departamento:</label>
                <select wire:model="departamento" id="departamento_filtro"
                        class="form-select filtro-select input-filter-height">
                    <option value="">Todos</option>
                    @foreach($cat_departa as $i)
                        <option value="{{$i->id}}">{{$i->nombre}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 col-sm-12 py-1">
                <label for="municipio_filtro" class="col-auto label-xs small text-gray pt-1 mb-0">Municipio:</label>
                <select wire:model="municipio" id="municipio_filtro"
                        class="form-select filtro-select input-filter-height">
                    <option value="">Todos</option>
                    @foreach($cat_municipio as $i)
                        <option value="{{$i->id}}">{{$i->nombre}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 col-sm-12 py-1">
                <label for="region_filtro" class="col-auto label-xs small text-gray pt-1 mb-0">Regional:</label>
                <select wire:model="region" class="form-select filtro-select input-filter-height" id="region_filtro">
                    <option value="">Todos</option>
                    @foreach($cat_region as $i)
                        <option value="{{$i['id']}}">{{$i['nombre']}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 col-sm-12 py-1">
                <label for="tipo_inspeccion_filtro" class="col-auto label-xs small text-gray pt-1 mb-0">Tipo de inspección:</label>
                <select wire:model="tipo_inspeccion" class="form-select filtro-select input-filter-height" id="tipo_inspeccion_filtro">
                    <option value="">Todos</option>
                    @foreach($cat_tipo_inspeccion as $i)
                        <option value="{{$i->id}}">{{$i->nombre}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 col-sm-12 py-1">
                <label for="actividad_filtro" class="col-auto label-xs small text-gray pt-1 mb-0">Actividad económica:</label>
                <select wire:model="actividad_economica" class="form-select filtro-select input-filter-height" id="actividad_filtro">
                    <option value="">Todos</option>
                    @foreach($cat_actividad as $i)
                        <option value="{{$i->id}}">{{$i->nombre}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 col-sm-12 py-1">
                <label for="cafta_filtro" class="col-auto label-xs small text-gray pt-1 mb-0">CAFTA:</label>
                <select wire:model="cafta" class="form-select filtro-select input-filter-height" id="cafta_filtro">
                    <option value="">Todos</option>
                    @foreach($cat_cafta as $k => $i)
                        <option value="{{$k}}">{{$i}}</option>
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

            @if( Auth::user()->hasRole('jefe_auditoria_setrass_ati') )
                <div class="col-md-4 col-sm-12 py-1">
                    <label for="asignado_filtro" class="col-auto label-xs small text-gray pt-1 mb-0">Auditor:</label>
                    <select wire:model="asignado" class="form-select filtro-select input-filter-height" id="asignado_filtro">
                        <option value="">Todos</option>
                        @foreach($cat_asignado as $i)
                            <option value="{{$i->id}}">{{$i->complete_name}}</option>
                        @endforeach
                    </select>
                </div>
            @endif


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
