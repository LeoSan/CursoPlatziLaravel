<div class="modal fade" id="eliminarCasoModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="eliminarCasoModalTitulo" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="eliminarCasoModalTitulo">Eliminar caso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-center">
                    ¿Desea eliminar la información de este caso?
                </p>
                <form action="{{route('casos.eliminar')}}" method="post" id="form_eliminar_caso">
                    @method('DELETE')
                    @csrf
                    <input type="hidden" name="caso_id" id="eliminar_caso_id" value="">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="form_eliminar_caso" class="btn btn-danger text-white">Eliminar</button>
            </div>
        </div>
    </div>
</div>
