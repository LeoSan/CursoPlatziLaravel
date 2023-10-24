<div>
    <div class="row">
        <div class="border-top mb-2"></div>
        <label class="form-label font-regular-size mb-1" for="busqueda">Buscar</label>
        <div class="col-md-12 py-1 d-flex justify-content-end text-end align-items-center">
            <input type="text" class="form-control busqueda_casos font-regular-size bg-white input-regular-height border-filter" wire:model="busqueda" value="{{$busqueda}}" placeholder="Busque por componente, acción, descripción o ip">
            @if(isset($busqueda) && strlen($busqueda)>2)
                <button class="btn btn-default busqueda_casos ms-2 input-regular-height" wire:click="removeFiltro('busqueda')">Cancelar</button>
            @endif
        </div>
    </div>

    <div class="row mt-3 d-flex justify-content-start align-items-end">
        <label class="form-label font-regular-size mb-0">Filtrar</label>
        @include('livewire.partials.filtros_bitacora')
    </div>

    <div class="mt-3">
        <div class="table-responsive">
            <table class="table text-start tabla-pgr">
                <thead>
                <tr>
                    <th class="ps-3">Dependencia</th>
                    <th>Componente</th>
                    <th>Acción</th>
                    <th>Descripción</th>
                    <th>Usuario</th>
                    <th>IP</th>
                    <th>Fecha</th>
                </tr>
                </thead>
                <tbody>
                @forelse($bitacoras as $item)
                    <tr class="align-middle">
                        <td class="ps-3 bg-white border-0">{{$item->dependencia->nombre}}</td>
                        <td class="bg-white border-0 ">{{$item->componente}}</td>
                        <td class="bg-white border-0 ">{{$item->accion}}</td>
                        <td class="bg-white border-0 ">{{$item->descripcion}}</td>
                        <td class="bg-white border-0 ">{{$item->usuario->complete_name}}</td>
                        <td class="bg-white border-0 ">{{$item->usuario_ip}}</td>
                        <td class="pe-3 bg-white border-0 ">{{$item->fecha_registro}}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="bg-white text-center border-0">
                            Sin resultados encontrados
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>


    <div class="text-sm-center">
        @include('livewire.partials.entries')
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12 d-flex justify-content-center">{{$bitacoras->links()}}</div>
        <div class="col-md-12 text-center text-small">
            <strong>{{ number_format($bitacoras->firstItem()) }}</strong> <span>al</span>
            <strong>{{ number_format($bitacoras->lastItem()) }}</strong> <span>de</span>
            <strong>{{ number_format($bitacoras->total()) }}</strong> <span>registros</span>
        </div>
    </div>

</div>

