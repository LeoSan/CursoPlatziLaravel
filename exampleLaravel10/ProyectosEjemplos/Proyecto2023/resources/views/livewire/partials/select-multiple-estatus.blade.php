<ul class="nav nav-pills">
    <li class="nav-item dropdown">
        <div id="optionSelect" class="form-select filtro-select input-filter-height d-flex align-items-center ms-fs" data-bs-toggle="dropdown" role="button" aria-expanded="false">
            {{ isset($filtros['estatus']['valor']) ? $filtros['estatus']['valor'] : 'Seleccione algún estatus'   }}
        </div>
        <ul class="dropdown-menu">
            @foreach($cat_estatus as $item)
                <li>
                    <div class="d-flex flex-row">
                        <div class="px-2">
                            <input wire:model="estatus" class="form-check-input  multi-select-usuario " type="checkbox" id="CheckUsuario_{{$item->id}}" data-tag-name="{{$item->nombre}}" type="checkbox" value="{{$item->id}}" />
                        </div>
                        <div class="dropdown-item px-2 font-select">
                            {{$item->nombre}}
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </li>
</ul>
