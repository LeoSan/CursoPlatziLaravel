<div class="modal fade" id="modalFormularioExistente" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalFormularioExistenteTitulo" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-estatus-formulario_activo">
                <h5 class="modal-title text-white">Información</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>
                    Actualmente existe un formulario activo para el tipo de inspección {{$formulario->tipoInspeccion->nombre}}.
                </p>
                <p>
                    Al activarlo, el formulario activo pasará a estatus <strong>histórico.</strong>
                </p>
                <p class="p-0"><strong class="text-gray">¿Desea continuar?</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Cancelar</button>
                <a href="{{route('formularios.activar',$formulario->id)}}" class="btn bg-estatus-formulario_activo text-white">Aceptar y continuar</a>
            </div>
        </div>
    </div>
</div>
