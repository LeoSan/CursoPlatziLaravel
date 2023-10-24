<p class="m-0 text-end fw-bold">
    <a class="text-graydark d-inline d-md-none text-sin-subrayado fs-movil" data-bs-toggle="collapse" href="#collapseFiltrosTablero" role="button" aria-expanded="true" aria-controls="collapseFiltrosTablero">
        Filtros
        <span class="image">
            <img src="{{ asset('images/icons/icon-arrow-down-fill.svg') }}" class="ms-1">
        </span>
    </a>
</p>
<div class="collapse show" id="collapseFiltrosTablero">
    <div class="" id="contenedorCollapseFiltrosTablero">
        <div class="row">
            <div class="col-lg-4 col-md-5 col-sm-6 pe-md-4 my-1">
                <label class="label-xs text-gray small m-0">Periodo de notificación del caso:</label>
                <div class="row m-0 p-0">
                    <div class="col-6 p-0 pe-1">
                        <input type="{{$periodo_desde||$periodo_hasta?'date':'text'}}" class="form-control filtro-text w-100 input-filter-height filtro-fecha" placeholder="Desde"
                               wire:model="periodo_desde">
                    </div>
                    <div class="col-6 p-0 ps-1">
                        <input type="{{$periodo_desde||$periodo_hasta?'date':'text'}}" class="form-control filtro-text w-100 input-filter-height filtro-fecha" placeholder="Hasta"
                               wire:model="periodo_hasta">
                    </div>
                </div>
                @if(isset($filtros['periodo']['error']))
                    <div class="row p-0 m-0 text-center">
                        <small class="text-danger" style="font-size: 10px">{{$filtros['periodo']['error']}}</small>
                    </div>
                @endif
            </div>
            <div class="col-lg-auto col-md-auto col-sm-6 pe-md-4 my-1">
                <label for="estatus_filtro" class="label-xs text-gray small m-0">Estatus:</label>
                @include('livewire.partials.select-multiple-estatus', ['cat_estatus'=>$cat_estatus])
            </div>
        </div>
    </div>
</div>
    @if($filtrado)
            <div class="row d-flex align-items-center">
                <div class="col-lg-10 col-md-8">
                    <div class="row">
                        @foreach($filtros as $k => $i)
                            @if(isset($i['valor']))
                                <div class="col-md-auto col-sm-12 my-1">
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
                <div class="col-lg-2 col-md-4 col-sm-12 my-1">
                    <button class="btn btn-default busqueda_casos ms-md-2 input-regular-height w-100" wire:click="resetFiltros">Limpiar filtros</button>
                </div>
            </div>
    @endif

