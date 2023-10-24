<form action="/casos/convenio-concluir" method="post" id="convenio_concluir_form">
    @csrf
    <input type="hidden" name="caso" value="{{ $caso->id }}">
</form>

<!-- Modal -->
<div class="modal fade" id="concluirModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-estatus-pago_total text-white">
                <h5 class="modal-title fw-semibold" id="staticBackdropLabel">
                    <small>
                        Concluir Convenio
                    </small>
                </h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Se concluirá el convenio de pago y el caso se registrará como pago total</p>
                <p><b>¿Desea continuar?</b></p>
            </div>
            <div class="modal-footer d-flex flex-nowrap">
                <button type="button" class="btn btn-default btn-accion-detalle" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" id="convenio_concluir" class="btn bg-estatus-pago_total btn-accion-detalle">Concluir</button>
            </div>
        </div>
    </div>
</div>
