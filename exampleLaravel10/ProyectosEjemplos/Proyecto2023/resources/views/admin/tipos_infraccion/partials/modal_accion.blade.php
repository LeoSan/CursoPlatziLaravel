<div class="modal fade modal-denuncia" id="modalTipoInfraccion" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modalTipoInfraccionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloModalTipoInfraccion">
                    ELIMINAR USUARIO
                </h5>
                <button type="button" class="btn-circle" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formTipoInfraccion" action="{{ route('tiposInfraccion.deshabilitarEliminar') }}" method="post">
                @csrf
                <input type="hidden" name="tipo_id" id="idModalTipoInfraccion">
                <input type="hidden" name="accion" id="accionModalTipoInfraccion">
                <div class="modal-body">
                    <div class="row">
                        <div class="alert-modal"></div>
                        <div class="col-12" id="textoModalTipoInfraccion"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="formTipoInfraccion" class="btn btn-cancelar-modal" id="btnModalTipoInfraccion"></button>
                </div>
            </form>
        </div>
    </div>
</div>
