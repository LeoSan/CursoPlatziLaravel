<div class="modal fade" id="modalTotalPago" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modalTotalPagoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header modal-header bg-estatus-convenio_pago text-white">
                <h5 class="modal-title" id="tituloTotalPago">
                    Información
                </h5>
                <button type="button" class="btn-circle" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="alert-modal"></div>
                    <div class="col-12">
                        <p id="parrafoTotalPago">
                        </p>
                        <p id="parrafoContinuarConvenio" class="p-0"><strong class="text-gray">¿Desea continuar?</strong></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-resolucion-modal btn-default fw-semibold" data-bs-dismiss="modal" id="btnCancelarModalTotalPago">Cancelar</button>
                <button type="submit" onclick="submitFormConvenioPago()" class="btn btn-resolucion-modal btn-cancelar-modal fw-semibold" id="btnModalTotalPago">Guardar</button>
            </div>

        </div>
    </div>
</div>

