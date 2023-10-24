<div class="col-md-4 col-sm-12 py-1">
    <label for="dependencia_filtro" class="col-auto col-form-label small text-gray pb-0">Usuarios:</label>
    <ul class="nav nav-pills w-100">
        <li class="nav-item dropdown w-100">
            <div id="optionSelect" class="form-select filtro-select input-filter-height d-flex align-items-center ms-fs" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                {{ isset($filtros['usuarios']['valor']) ? $filtros['usuarios']['valor'] : 'Seleccione algún usuario'   }}
            </div>
            <ul class="dropdown-menu">

              @foreach($cat_usuarios as $item)
                <li>
                    <div class="d-flex flex-row">
                        <div class="px-2">
                            <input wire:model="usuarios" class="form-check-input  multi-select-usuario " type="checkbox" id="CheckUsuario_{{$item->id}}" data-tag-name="{{$item->complete_name}}" type="checkbox" value="{{$item->id}}" />
                        </div>
                        <div class="dropdown-item px-2 font-select">
                            {{$item->complete_name}}
                        </div>
                    </div>
                </li>
              @endforeach
            </ul>
        </li>
    </ul>
</div>
