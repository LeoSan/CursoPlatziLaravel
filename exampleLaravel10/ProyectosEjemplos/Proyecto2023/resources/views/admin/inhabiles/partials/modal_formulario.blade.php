<div class="modal fade" id="modalInhabiles" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalInhabilesTitulo" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gray">
                <h5 class="modal-title text-white" id="modalInhabilesTitulo"></h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('diasinhabiles.store')}}" method="post" id="formInhabiles" class="necesita-validacion" novalidate>
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="accion" id="accion">
                    
                    <div class="form-group">
                        <label for="fecha">Fecha *</label>
                        <input id="fecha" name="fecha" type="date" class="form-control bg-white" placeholder="Seleccione la fecha"  required maxlength="100">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción *</label>
                        <input id="descripcion" name="descripcion" type="text" class="form-control bg-white" placeholder="Escriba la descripción"  maxlength="100" required>
                        <div class="invalid-feedback"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formInhabiles" class="btn btn-danger text-white" id="btnFormInhabiles"></button>
            </div>
        </div>
    </div>
</div>
