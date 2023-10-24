<div class="modal fade" id="modalCatalogoElementos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="modalCatalogoElementosTitulo" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gray">
                <h5 class="modal-title text-white" id="modalCatalogoElementosTitulo"></h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('catalogos.elementos.store',[$catalogo->id])}}" method="post"
                      id="formCatalogoElementos" class="necesita-validacion" novalidate>
                    @csrf
                    <input type="hidden" name="id" id="catalogoElementoId">
                    <div class="form-group">
                        <label for="nombre_elemento">Nombre *</label>
                        <input name="nombre" type="text" class="form-control bg-white"
                               placeholder="Escriba el nombre del elemento" id="nombre_elemento" required
                               maxlength="100">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="codigo_elemento">Código *</label>
                        <input name="codigo" type="text" class="form-control bg-white"
                               placeholder="Escriba el código del elemento" id="codigo_elemento" required
                               maxlength="100">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="descripcion_elemento">Descripción</label>
                        <input name="descripcion" type="text" class="form-control bg-white"
                               placeholder="Escriba la descripción del elemento" id="descripcion_elemento"
                               maxlength="100">
                        <div class="invalid-feedback"></div>
                    </div>
                    @if(isset($catalogo->padre))
                        <div class="form-group">
                            <label for="padre_id">{{$catalogo->padre->singular}} *</label>
                            <select name="parent_id" id="padre_elemento" class="form-select bg-white" required>
                                <option value="">Seleccione una opción</option>
                                @foreach($catalogo->padre->elementos as $e)
                                    <option value="{{$e->id}}">{{$e->nombre}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    @endif

                    @if($catalogo->codigo == 'municipios')
                        <div class="form-group">
                            <label for="padre_id">Regional</label>
                            <select name="categoria_id" id="categoria_elemento" class="form-select bg-white">
                                <option value="">Seleccione una opción</option>
                                @foreach($regiones as $e)
                                    <option value="{{$e->id}}">{{$e->nombre}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    @endif
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formCatalogoElementos" class="btn btn-danger text-white"
                        id="btnFormCatalogoElementos"></button>
            </div>
        </div>
    </div>
</div>
