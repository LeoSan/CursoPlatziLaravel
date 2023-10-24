@can('ejecutar_inadmision')
    <div class="form-group col-md-3 mb-2 mb-md-0 d-flex  justify-content-end">
        <a href="/denuncias/inadmision/{{$denuncia->id}}" class="btn btn-accion-detalle bg-estatus-inadmision w-100 ">Inadmisión</a>
    </div>
@endcan

@can('ejecutar_alta_denuncia')
    <div class="form-group col-md-3 mb-2 mb-md-0 d-flex  justify-content-end">
            <a type="button" class="btn btn-accion-detalle bg-btn-guardar w-100" href="{{route('denuncias.form.alta', ['id'=>$denuncia->id])}}">
               Alta de la denuncia
            </a>
    </div>
@endcan
