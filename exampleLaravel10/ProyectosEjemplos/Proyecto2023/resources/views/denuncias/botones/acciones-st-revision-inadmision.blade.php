@if(auth()->user()->hasRole('jefe_auditoria_setrass_ati'))
<div class="form-group col-md-3 mb-2 mb-md-0 d-flex  justify-content-end">
    @can('ejecutar_inadmision')
        <a href="/denuncias/inadmision/{{$denuncia->id}}" class="btn btn-accion-detalle bg-estatus-inadmision w-100">Notificar inadmisión</a>
    @endcan

</div>

<div class="form-group col-md-3 mb-2 mb-md-0 d-flex  justify-content-end">
    @can('ejecutar_inadmision')
        <a href="/denuncias/inadmision_no_procede/{{$denuncia->id}}" class="btn btn-accion-detalle bg-btn-guardar w-100 ">No procede inadmisión</a>
    @endcan
</div>
@endif
