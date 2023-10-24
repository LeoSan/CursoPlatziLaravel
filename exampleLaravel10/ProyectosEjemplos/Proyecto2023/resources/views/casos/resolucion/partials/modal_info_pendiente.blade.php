<div class="modal fade" id="infoPendienteModal" tabindex="-1" aria-labelledby="infoPendienteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white px-3 py-2">
                <h5 class="modal-title fs-6 fw-semibold" id="infoPendienteModalLabel">Información pendiente</h5>
                <button type="button" class="text-white" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-circle-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <p class="">
                    Se cambiará el estatus a <b class="fw-semibold">Información pendiente</b>,
                    con lo cual el caso quedará en pausa hasta que inicie nuevamente el proceso.
                </p>
                <p class="p-0 m-0">
                    ¿Desea continuar?
                </p>
                <form action="{{ route('casos.cambioInfoPendiente', ['id' => $caso->id]) }}" id="formCambioInfoPendiente" method="post">
                    @csrf
                </form>
            </div>
            <div class="modal-footer pt-0 pb-2 border-0">
                <button type="button" class="btn btn-secondary py-2 rounded-1" data-bs-dismiss="modal">
                    No
                </button>
                <button type="submit" form="formCambioInfoPendiente" class="btn btn-primary py-2 rounded-1">
                    Sí, continuar
                </button>
            </div>
        </div>
    </div>
</div>
