<div>
    <div class="row">
        <div class="col-12">
            <div class="border-top mb-2"></div>
        </div>
        <label class="form-label font-regular-size mb-1" for="busqueda">Buscar</label>
        <div class="col-md-12 py-1 d-flex justify-content-end text-end align-items-center">
            <input type="text" class="form-control busqueda_casos font-regular-size bg-white input-regular-height border-filter" wire:model="busqueda" value="{{$busqueda}}" placeholder="Busque por fecha o descripción">
            @if(isset($busqueda) && strlen($busqueda)>2)
                <button class="btn btn-default busqueda_casos ms-2 input-regular-height" wire:click="removeFiltro('busqueda')">Cancelar</button>
            @endif
        </div>
    </div>
    <div class="row justify-content-end py-2">
        <div class="col-auto">
            <button class="btn btn-danger btn-general" onclick="openModalFormulario('modalInhabiles', 'modalInhabilesTitulo', 'formInhabiles', 'btnFormInhabiles', 'crear', this)">Crear</button>
        </div>
    </div>

        <div class="table-responsive">
            <table class="table tabla-pgr">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Día</th>
                        <th>Descripción</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($inhabiles as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td>{{$item->fecha->format('d/m/Y')}}</td>
                        <td>{{$item->descripcion}}</td>
                        <td class="text-center">
                            @if( $item->fecha>=date('Y-m-d') )
                                <a class="btn-link text-gray px-2 cursor-p"
                                    data-id="{{$item->id}}"
                                    data-fecha="{{$item->fecha->format('Y-m-d')}}"
                                    data-descripcion="{{$item->descripcion}}"
                                    data-accion="editar"
                                    onclick="openModalFormulario('modalInhabiles', 'modalInhabilesTitulo', 'formInhabiles', 'btnFormInhabiles', 'editar', this)">
                                    <i class="fa fa-edit fs-6 px-2"></i>Editar
                                </a>

                                <a  class="btn-link  text-red-eliminar cursor-p"
                                    data-id="{{$item->id}}"
                                    data-accion="eliminar"
                                    onclick="openModalFormulario('modalEliminarInhabiles', 'modalEliminarInhabilesTitulo', 'formEliminarInhabiles', 'btnFormEliminarInhabiles', 'eliminar', this)"
                                    >
                                    <i class="fas fa-trash-can fs-6 px-2"></i>Eliminar
                                </a>
                            @endif

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="bg-white text-center border-0">
                            Sin resultados encontrados
                        </td>
                    </tr>
                @endforelse

                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center">
            {!! $inhabiles->links() !!}
        </div>

</div>
