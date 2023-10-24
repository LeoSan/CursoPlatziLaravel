<div>
    <div class="row mb-2">
        <label class="form-label font-regular-size mb-1" for="busqueda">Buscar</label>
        <div class="col-md-12 py-1 d-flex justify-content-end text-end align-items-center">
            <input type="text" class="form-control busqueda_casos font-regular-size bg-white input-regular-height border-filter" wire:model="busqueda" value="{{$busqueda}}" placeholder="Busque por nombre o código">
            @if(isset($busqueda) && strlen($busqueda)>2)
                <button class="btn btn-default busqueda_casos ms-2 input-regular-height" wire:click="removeFiltro('busqueda')">Cancelar</button>
            @endif
        </div>
    </div>
    @if($catalogo->padre)
        @include('livewire.admin.partials.filtro-catalogo')
    @endif
    <div class="col-12 bg-white p-3">
        <div class="row justify-content-between">
            <div class="col-auto title-principal mb-3">
                {{$catalogo->nombre}}
            </div>
            <div class="col-auto">
                <button class="btn btn-danger btn-general" onclick="formularioCatalogos('crear',this)">Crear elemento</button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table tabla-pgr">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Código</th>
                    <th>Descripción</th>
                    @if($catalogo->padre)
                        <th>{{$catalogo->padre->singular}}</th>
                    @endif
                    @if($catalogo->codigo == 'municipios')
                        <th>Regional</th>
                    @endif
                    <th class="text-center">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @forelse($elementos as  $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td>{{$item->nombre}}</td>
                        <td>{{$item->codigo}}</td>
                        <td>{{$item->descripcion}}</td>
                        @if($catalogo->padre)
                            <td>{{@$item->padre->nombre}}</td>
                        @endif
                        @if($catalogo->codigo == 'municipios')
                            <td>{{@$item->categoria->nombre}}</td>
                        @endif
                        <td class="text-center">
                            @if( $item->hijos->count()>0 )
                                <a class="btn-link mx-2 text-gray" href="{{route('catalogos.show',[$item->hijos->first()->catalogo_id,'parent_id[]'=>$item->id])}}">
                                    <i class="fa fa-lg fa-eye" ></i> Ver detalle
                                </a>
                            @endif
                            @if($catalogo->editable)
                                <button class="btn-link mx-2 text-gray"
                                        data-parent_id="{{$item->parent_id}}"
                                        data-id="{{$item->id}}"
                                        data-nombre="{{$item->nombre}}"
                                        data-codigo="{{$item->codigo}}"
                                        data-orden="{{$item->orden}}"
                                        data-descripcion="{{$item->descripcion}}"
                                        @if($catalogo->codigo == 'municipios') data-categoria="{{$item->categoria_id}}" @endif
                                        onclick="formularioCatalogos('editar',this)">
                                    <i class="fa fa-lg fa-edit"></i> Editar
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="alert alert-info">
                            Sin resultados encontrados
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="row justify-content-center overflow-auto">
            <div class="col-auto">
                {!! $elementos->links() !!}
            </div>
        </div>
    </div>
</div>
