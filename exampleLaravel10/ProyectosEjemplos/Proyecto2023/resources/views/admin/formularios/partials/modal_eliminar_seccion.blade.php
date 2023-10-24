<div class="modal fade" id="modalEliminarSeccion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEliminarSeccionTitulo" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-gray">
                <h5 class="modal-title text-white" id="modalEliminarSeccionTitulo">Eliminar sección</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('formularios.secciones.destroy')}}" method="post" id="formEliminarSeccion" class="necesita-validacion" novalidate>
                    @csrf
                    <input type="hidden" name="seccion_id" id="idEliminarSeccion">
                </form>
                <p class="text-center">
                    ¿Desea eliminar esta sección?
                </p>
                <p class="text-center"> Si es así de click en <strong>Eliminar</strong>.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formEliminarSeccion" class="btn btn-danger text-white">Eliminar</button>
            </div>
        </div>
    </div>
</div>
