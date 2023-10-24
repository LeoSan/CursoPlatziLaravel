<div class="modal fade" id="modalEliminarPlantilla" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEliminarPlantillaTitulo" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gray">
                <h5 class="modal-title text-white">Eliminar plantilla</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('plantillas.destroy')}}" method="post" id="formEliminarPlantilla" class="necesita-validacion" novalidate>
                    @csrf
                    <input type="hidden" name="id" id="idEliminarPlantilla">
                </form>
                <p class="text-center">
                    ¿Desea eliminar esta plantilla?
                </p>
                <p class="text-center"> Si es así de click en <strong>Eliminar</strong>.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formEliminarPlantilla" class="btn btn-danger text-white">Eliminar</button>
            </div>
        </div>
    </div>
</div>
