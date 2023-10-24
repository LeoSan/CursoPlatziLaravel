<div class="modal fade modal-denuncia" id="modal-confirm-solicitud" tabindex="-1" aria-labelledby="modalConfirmSolicitudLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalConfirmSolicitudLabel">Información</h5>
        <button type="button" class="btn-circle" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p id="msjConfirm">
          mensaje en espera...
        </p>
        <p class="p-0 m-0">
          ¿Desea continuar?
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button id="@if(isset($idBtnControl)){{$idBtnControl}}@endif" type="button" class="btn btn-tertiary py-2 rounded-1" data-bs-dismiss="modal">Continuar</button>
      </div>
    </div>
  </div>
</div>