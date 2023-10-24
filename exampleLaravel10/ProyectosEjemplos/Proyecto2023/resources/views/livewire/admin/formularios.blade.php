<div>
    <div class="row">
        <div class="col-12">
            <div class="border-top mb-2"></div>
        </div>
        <label class="form-label font-regular-size mb-1" for="busqueda">Buscar</label>
        <div class="col-md-12 py-1 d-flex justify-content-end text-end align-items-center">
            <input type="text" class="form-control busqueda_casos font-regular-size bg-white input-regular-height border-filter" wire:model="busqueda" value="{{$busqueda}}" placeholder="Busque por nombre o por tipo de inspección">
            @if(isset($busqueda))
                <button class="btn btn-default busqueda_casos ms-2 input-regular-height" wire:click="removeFiltro('busqueda')">Cancelar</button>
            @endif
        </div>
    </div>
    <div class="row justify-content-end py-2">
        <div class="col-auto">
            <a href="{{route('formularios.create')}}" class="btn btn-danger btn-general">Crear formulario</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table tabla-pgr text-center">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Tipo de inspección</th>
                <th>Cantidad de secciones</th>
                <th>Cantidad de preguntas</th>
                <th>Estatus</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @forelse($formularios as $formulario)
                <tr>
                    <td>{{$formulario->id}}</td>
                    <td>{{$formulario->nombre}}</td>
                    <td>{{$formulario->tipoInspeccion->nombre}}</td>
                    <td>{{$formulario->secciones->count()}}</td>
                    <td>{{$formulario->preguntas->count()}}</td>
                    <td>
                        <div class="d-flex justify-content-center">
                            @include('partials.estatus',['estatus'=>$formulario->estatus])
                        </div>
                    </td>
                    <td>
                        <a class="btn-link text-gray px-2" href="{{route('formularios.create',$formulario->id)}}" >
                            <i class="fa fa-edit fs-6"></i> Editar
                        </a>
                        @if($formulario->estatus->codigo=='formulario_borrador')
                            <button  class="btn-link text-danger" data-bs-toggle="modal" data-bs-target="#modalEliminarFormulario"
                                     onclick="document.getElementById('idEliminarFormulario').value={{$formulario->id}}">
                                <i class="fas fa-trash-can fs-6"></i> Eliminar
                            </button>
                        @endif
                    </td>
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
    <div class="d-flex justify-content-center">
        {!! $formularios->links() !!}
    </div>
    @include('admin.formularios.partials.modal_eliminar')
</div>
