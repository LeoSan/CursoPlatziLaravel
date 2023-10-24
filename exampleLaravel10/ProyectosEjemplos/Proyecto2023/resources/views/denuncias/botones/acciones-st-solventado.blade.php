@can('ejecutar_desestimar')
        <div class="form-group col-md-3 mb-2 mb-md-0 d-flex  justify-content-end px-2">
            <a class="btn btn-accion-detalle bg-estatus-inadmision w-100" href="{{route('denuncias.desestimar',$denuncia->id)}}">Desestimar</a>
        </div>
@endcan
@can('ejecutar_solicitud_exp')
    <div class="form-group col-md-3 mb-2 mb-md-0 d-flex  justify-content-end">
        <a id="btnFormSolicitudExpediente" href="{{route('denuncias.form.solicitar.expediente', ['id'=>$denuncia->id])}}"  type="button" class="btn btn-accion-detalle bg-btn-guardar w-100">Solicitar expediente</a>
    </div>
@endcan
