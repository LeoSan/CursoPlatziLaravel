<div>
    <div class="row">
        <div class="col-12">
            <div class="border-top mb-2"></div>
        </div>
        <label class="form-label font-regular-size mb-1" for="busqueda">Buscar</label>
        <div class="col-md-12 py-1 d-flex justify-content-end text-end align-items-center">
            <input type="text" class="form-control busqueda_casos font-regular-size bg-white input-regular-height border-filter" wire:model="busqueda" value="{{$busqueda}}" placeholder="Busque por nombre o por sección">
            @if(isset($busqueda))
                <button class="btn btn-default busqueda_casos ms-2 input-regular-height" wire:click="removeFiltro('busqueda')">Cancelar</button>
            @endif
        </div>
    </div>
    <div class="row justify-content-end py-2">
        <div class="col-auto">
            <a href="{{route('plantillas.create')}}" class="btn btn-danger btn-general">Crear plantilla</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table tabla-pgr">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Sección</th>
                <th class="text-center">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @forelse($plantillas as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->nombre}}</td>
                    <td>{{$item->seccion->nombre}}</td>
                    <td class="text-center">
                        <a class="btn-link text-gray px-2" href="{{route('plantillas.create',$item->id)}}" >
                            <i class="fa fa-edit fs-6"></i> Editar
                        </a>
                        <button  class="btn-link text-danger" data-bs-toggle="modal" data-bs-target="#modalEliminarPlantilla"
                            onclick="document.getElementById('idEliminarPlantilla').value={{$item->id}}"
                        >
                            <i class="fas fa-trash-can fs-6"></i> Eliminar
                        </button>
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
        {!! $plantillas->links() !!}
    </div>
</div>
