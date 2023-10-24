<div class="row mt-2 justify-content-between mb-0">
    <div class="col-12 py-2">
        <label class="form-label font-regular-size mb-1">Filtrar</label>
        <p class="m-0 text-end fw-bold">
            <a class="text-graydark d-inline d-md-none text-sin-subrayado fs-movil" data-bs-toggle="collapse" href="#collapseFiltrosUsuarios" role="button" aria-expanded="true" aria-controls="collapseFiltrosUsuarios">
                Filtros<span class="image"><img src="{{ asset('images/icons/icon-arrow-down-fill.svg') }}" class="ms-1"></span>
            </a>
        </p>
        <div class="collapse show" id="collapseFiltrosUsuarios">
            <div class="row justify-content-between">
                <div class="col-md-auto col-sm-6 my-1">
                    <label for="filtro_parent_id" class="label-xs text-gray small m-0">{{$catalogo->padre->singular}}:</label>
                    <ul class="nav nav-pills w-100">
                        <li class="nav-item dropdown w-100">
                            <div id="optionSelect" class="form-select filtro-select input-filter-height d-flex align-items-center ms-fs" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                                {{ isset($filtros['parent_id']['valor']) ? $filtros['parent_id']['valor'] : 'Seleccione algún '.strtolower($catalogo->padre->singular)}}
                            </div>
                            <ul class="dropdown-menu">
                                @foreach($padres as $k=>$v)
                                    <li>
                                        <div class="d-flex flex-row">
                                            <div class="px-2">
                                                <input wire:model="parent_id" class="form-check-input" type="checkbox" id="check_parent_id_{{$k}}" value="{{$k}}" />
                                            </div>
                                            <div class="dropdown-item px-2 font-select">
                                                {{$v}}
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
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
                                <button class="btn btn-default input-regular-height w-auto text-nowrap" wire:click="resetFiltros">Limpiar filtros</button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-12 mb-2">
        <div class="border-bottom"></div>
    </div>
</div>
