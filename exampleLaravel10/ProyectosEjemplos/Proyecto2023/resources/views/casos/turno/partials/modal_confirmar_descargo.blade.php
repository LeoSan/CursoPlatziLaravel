<div class="modal fade" id="modalOtroDescargo" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modalOtroDescargoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header modal-header bg-estatus-otro_descargo text-white">
                <h5 class="modal-title" id="tituloTotalPago">
                    Información
                </h5>
                <button type="button" class="btn-circle" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="alert-modal"></div>
                    <div class="col-12">
                        <p>
                            Esta acción cambiará el estatus del caso y no podrá ser modificado.
                        </p>
                        <p class="p-0"><strong class="text-gray">¿Desea continuar?</strong></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-resolucion-modal btn-default fw-semibold" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-resolucion-modal btn-cancelar-modal fw-semibold" onclick="submitFormOtroDescargo()">Continuar</button>
            </div>

        </div>
    </div>
</div>
