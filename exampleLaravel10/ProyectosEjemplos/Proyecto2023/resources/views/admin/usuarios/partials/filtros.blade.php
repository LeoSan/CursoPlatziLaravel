<div id="iframe_content">
    <form  action="{{ route('usuarios') }}" method="GET" name="search_form" id="search_form" autocomplete="off" accept-charset="UTF-8">
        <div class="w-100">
            <label class="form-label font-regular-size mb-2">Buscar</label>
        </div>
        <div class="col-md-12 d-flex justify-content-end text-end align-items-center">
            <input type="hidden" name="buscador" value="buscador">
            <input type="text" class="form-control busqueda_casos bg-white border-filter input-regular-height" name="busqueda" id="busqueda" placeholder="Busque por nombre, email o cargo" value="{{@$_GET['busqueda']??old('busqueda')}}">
            <button class="btn btn-secondary busqueda_casos ms-2 btn-pgr input-regular-height">Buscar</button>
            @if(isset($_GET['busqueda']) && $_GET['busqueda']!="")
                <a href="{{ route('usuarios') }}" class="btn btn-default busqueda_casos input-regular-height ms-2" id="btn_reset_busqueda" type="button">Cancelar</a>
            @endif
        </div>
    </form>
    <div class="pt-4">
        <form  action="{{ route('usuarios') }}" method="GET" name="search_form" id="search_form" autocomplete="off" accept-charset="UTF-8">
            <label class="form-label font-regular-size mb-0">Filtrar</label>
            <div class="row mb-3 d-flex justify-content-start align-items-end">
                <div class="col-md-5 col-sm-4 d-flex justify-content-end">
                    <div class="dropdown w-100">
                        <input type="hidden" name="buscador" value="filtro">
                        <button class="text-start d-flex justify-content-between align-items-center dropdown-toggle selection-empty dropdown-multiple filtro-select form-select input-filter-height" type="button" id="dropdown_perfiles" data-bs-toggle="dropdown" aria-expanded="false">Selecciona los perfiles</button>
                        <div class="dropdown-menu ps-3 pe-4" aria-labelledby="dropdown_perfiles" style="">
                            <div class="form-check">
                                <input class="form-check-input form-select-multiple" type="checkbox" data-input-name="perfiles" name="perfiles[]" value="TODOS" id="multiple_perfiles_TODOS" data-tag-name="TODOS">
                                <label class="form-check-label fw-normal" for="multiple_perfiles_TODOS">
                                    Todos
                                </label>
                            </div>
                            @foreach($roles as $rol)
                                <div class="form-check">
                                    <input class="form-check-input form-select-multiple" type="checkbox" data-input-name="perfiles" name="perfiles[]" value="{{$rol->id}}" data-tag-name="{{$rol->show_name}}" id="multiple_perfil_{{$rol->show_name}}">
                                    <label class="form-check-label fw-normal" for="multiple_perfil_{{$rol->show_name}}">
                                        {{$rol->show_name}}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-auto d-flex justify-content-end px-1">
                    <button class="btn btn-secondary busqueda_casos ms-2 input-regular-height mt-2 mt-md-0" type="submit">Filtrar</button>
                </div>
                <div class="col-auto d-flex justify-content-end px-1">
                    <a href="{{ route('usuarios') }}" class="btn btn-accion-detalle btn-default mt-2 mt-md-0" id="btn_reset_busqueda" type="button">Limpiar filtro</a>
                </div>
            </div>
            <div class="border-bottom mb-3"></div>
        </form>
    </div>
</div>
