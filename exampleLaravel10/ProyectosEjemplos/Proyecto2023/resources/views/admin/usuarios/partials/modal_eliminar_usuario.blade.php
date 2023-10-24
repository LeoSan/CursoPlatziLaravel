<div class="modal fade modal-denuncia" id="eliminarUsuarioModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="eliminarUsuarioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Eliminar
                </h5>
                <button type="button" class="btn-circle" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEliminarUsuario" class="form_disable_button" action="{{ route('usuarios.eliminar') }}" method="post">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <p>
                            <strong class="text-gray" id="txt_reasignar">
                            </strong>
                        </p>
                        <div id="reasignar_usuario">
                        </div>
                        <div class="error text-danger fw-regular"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="footer_eliminar">
                <button type="button" class="btn btn-default fw-semibold" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" form="formEliminarUsuario" class="btn btn-secondary" onclick="eliminarUsuarioReasignarExpediente('formEliminarUsuario')">Eliminar</button>
            </div>
            </form>
            <form id="formEliminarUsuario" class="form_disable_button" action="" method="post">
                @csrf
            </form>
        </div>
    </div>
</div>

