<div class="modal fade" id="modalEliminarFormulario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEliminarFormularioTitulo" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-gray">
                <h5 class="modal-title text-white">Eliminar formulario</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('formularios.destroy')}}" method="post" id="formEliminarFormulario" class="necesita-validacion" novalidate>
                    @csrf
                    <input type="hidden" name="formulario_id" id="idEliminarFormulario">
                </form>
                <p>
                    ¿Desea eliminar este formulario?
                </p>
                <p> Si es así de click en <strong>Eliminar</strong>.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formEliminarFormulario" class="btn btn-danger text-white">Eliminar</button>
            </div>
        </div>
    </div>
</div>
