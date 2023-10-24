<div class="modal fade" id="modalEliminarInhabiles" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEliminarInhabilesTitulo" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gray">
                <h5 class="modal-title text-white" id="modalEliminarInhabilesTitulo"></h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('diasinhabiles.store')}}" method="post" id="formEliminarInhabiles" class="necesita-validacion" novalidate>
                    @csrf
                    <input type="hidden" name="id" id="id_e">
                    <input type="hidden" name="accion" id="accion_e">
                </form>

                <span id="msjConfirmacion">Usted está seguro que desea eliminar este día inhábil. ¿Desea continuar? </span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formEliminarInhabiles" class="btn btn-danger text-white" id="btnFormEliminarInhabiles"></button>
            </div>
        </div>
    </div>
</div>
