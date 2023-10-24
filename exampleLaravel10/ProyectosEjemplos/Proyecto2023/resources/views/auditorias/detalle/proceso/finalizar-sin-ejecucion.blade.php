<div class="form-group col-md-12 py-2 text-end">
    <button data-bs-toggle="modal" data-bs-target="#finalizarSinEjecucionModal" class="btn btn-danger input-regular-height">Finalizar sin ejecución
    </button>
</div>
<div class="modal fade" id="finalizarSinEjecucionModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <form action="{{ route('auditorias.ejecucion.proceso.finalizar-sin-ejecutar') }}" method="post" class="modal-dialog">
        @csrf
        <input type="hidden" name="ejecucion_id" value="{{$ejecucion->id}}">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white px-3 py-2">
                <h5 class="modal-title fs-6 fw-semibold" id="deleteModalLabel">Finalizar sin ejecución</h5>
                <button type="button" class="text-white" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-circle-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                Al seleccionar esta opción deberá cargar el informe y ya no será posible modificar la ejecución de la auditoría.
                ¿Desea continuar?
            </div>
            <div class="modal-footer pt-0 pb-2 border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-danger">Continuar</button>
            </div>
        </div>
    </form>
</div>