{{--  MODAL con el folio --}}
<div class="modal fade modal-denuncia" id="confirmaActualizarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div id="modalHeader" class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Confirmar </h5>
          <button type="button" class="btn-circle" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <span id="msjConfirmacion"> {{$msj_confirm}} </span>
        </div>
        <div class="modal-footer">
          <button data-dismiss="modal" type="button" class="btn btn-secondary">Cancelar</button>
            @switch($accion)
                @case('modalSolicitarExpediente')
                    <a id="{{$id_boton}}" href="{{route('denuncias.form.solicitar.expediente', ['id'=>$denuncia->id])}}"  type="button" class="btn btn-green a-pta">{{$nomBoton}}</a>
                @break
                @case('ClickEnviarActualizacion')
                    <button id="{{$id_boton}}"  data-modal="SiSoyModal" data-dismiss="modal" type="button" class="btn btn-green">{{$nomBoton}}</button>
                @break
            @endswitch
        </div>
      </div>
    </div>
</div>
