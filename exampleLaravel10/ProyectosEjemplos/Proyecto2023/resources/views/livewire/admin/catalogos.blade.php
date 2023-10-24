<div>
    <div class="row">
        <div class="col-12">
            <div class="border-top mb-2"></div>
        </div>
        <label class="form-label font-regular-size mb-1" for="busqueda">Buscar</label>
        <div class="col-md-12 py-1 d-flex justify-content-end text-end align-items-center">
            <input type="text" class="form-control busqueda_casos font-regular-size bg-white input-regular-height border-filter" wire:model="busqueda" value="{{$busqueda}}" placeholder="Busque por nombre o código">
            @if(isset($busqueda) && strlen($busqueda)>2)
                <button class="btn btn-default busqueda_casos ms-2 input-regular-height" wire:click="removeFiltro('busqueda')">Cancelar</button>
            @endif
        </div>
    </div>
    @if($catalogos->count() > 0)
        <div class="table-responsive">
            <table class="table tabla-pgr">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Código</th>
                        <th>Catálogo padre</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($catalogos as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td>{{$item->nombre}}</td>
                        <td>{{$item->codigo}}</td>
                        <td>{{@$item->padre->nombre}}</td>
                        <td class="text-center">
                            <a class="btn-link text-gray" href="{{route('catalogos.show',$item->id)}}">
                                <i class="fa fa-lg fa-eye"></i> Detalle
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center">
            {!! $catalogos->links() !!}
        </div>
    @else
        <div class="alert alert-info">
            Sin resultados encontrados
        </div>
    @endif
</div>
