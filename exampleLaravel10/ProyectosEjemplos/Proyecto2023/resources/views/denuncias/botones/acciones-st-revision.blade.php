@can('ejecutar_providencia')
<div class="form-group col-md-3 mb-2 mb-md-0 d-flex  justify-content-end">
    <a type="button" class="btn btn-accion-detalle bg-estatus-inadmision w-100" href="{{route('denuncias.form.providencia', ['id'=>$denuncia->id])}}">
        Providencia
    </a>
</div>
@endcan
@can('ejecutar_solicitud_exp')
    <div class="form-group col-md-3 mb-2 mb-md-0 d-flex  justify-content-end">
        @if ( $denuncia->estatus_id == obtenerIdCatalogoElementCodigo('en_revision'))
            <button class="btn btn-accion-detalle bg-btn-guardar w-100"  onclick="abrirModalConfirm(this, 'confirmaActualizarModal')" >
                Solicitar expediente
            </button>
        @else
            <a id="btnFormSolicitudExpediente" href="{{route('denuncias.form.solicitar.expediente', ['id'=>$denuncia->id])}}"  type="button" class="btn btn-accion-detalle bg-btn-guardar w-100">Solicitar expediente</a>
        @endif
    </div>
@endcan
