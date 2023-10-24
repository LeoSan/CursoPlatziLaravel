<div class="modal fade" id="concluirIncompletoModal" tabindex="-1" aria-labelledby="concluirIncompletoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white px-3 py-2">
                <h5 class="modal-title fs-6 fw-semibold" id="concluirIncompletoModalLabel">
                    Registrar pago
                </h5>
                <button type="button" class="text-white" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-circle-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    Está por registrar el último pago del convenio, sin embargo, no se cubre el monto total de la multa. En caso de continuar el convenio será concluido.
                </p>
                <p class="p-0 m-0">
                    ¿Desea continuar?
                </p>
            </div>
            <div class="modal-footer pt-0 pb-2 border-0">
                <button type="button" class="btn btn-secondary py-2 rounded-1" data-bs-dismiss="modal">
                    Cancelar
                </button>

                <button type="submit" class="btn btn-warning py-2 rounded-1" data-bs-dismiss="modal"
                        id="concluir_incompleto_submit" form="">
                    Continuar
                </button>
            </div>
        </div>
    </div>
</div>
