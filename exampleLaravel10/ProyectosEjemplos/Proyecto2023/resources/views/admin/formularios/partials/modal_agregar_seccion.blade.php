<div class="modal fade" id="modalAgregarSeccion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalAgregarSeccionTitulo" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-gray">
                <h5 class="modal-title text-white" id="modalAgregarSeccionTitulo">Agregar sección</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('formularios.secciones.store')}}" method="post" id="formAgregarFormularioSeccion" class="necesita-validacion" novalidate>
                    @csrf
                    <input type="hidden" name="formulario_id" value="{{$formulario->id}}">
                    <input type="hidden" name="seccion_id" id="idFormularioSeccion">
                    <div class="form-group">
                        <label for="nombreFormularioSeccion">Nombre *</label>
                        <input name="nombre" type="text" class="form-control bg-white" placeholder="Escriba el nombre de la sección" id="nombreFormularioSeccion" required maxlength="100">
                        <div class="invalid-feedback"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formAgregarFormularioSeccion" class="btn btn-danger text-white" id="btnFormAgregarFormularioSeccion">Guardar</button>
            </div>
        </div>
    </div>
</div>
