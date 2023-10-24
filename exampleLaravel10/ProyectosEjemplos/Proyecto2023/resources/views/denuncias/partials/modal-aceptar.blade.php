{{--  MODAL con el folio --}}
<div class="modal fade modal-denuncia" id="exampleModal"  data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Denuncia enviada</h5>
          <button type="button" class="btn-circle" data-dismiss="modal" aria-label="Close" onclick="formatoClose(this)"></button>
        </div>
        <div class="modal-body">
            <p>La solicitud fue registrada con éxito con el folio <span id="valFolio" class="fw-bold"></span>.</p>
            <p>Recibirá un correo electrónico con información que le permitirá dar seguimiento.</p>
        </div>
        <div class="modal-footer">
          <button id="btnDenunciaAceptada" type="button" class="btn btn-secondary">Aceptar</button>
        </div>
      </div>
    </div>
</div>
