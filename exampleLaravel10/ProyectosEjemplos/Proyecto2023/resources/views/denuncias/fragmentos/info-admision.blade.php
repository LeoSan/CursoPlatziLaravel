@php ( $estatus = $denuncia->gestion()->whereHas('estatus',function($q){$q->whereCodigo('admitida');})->first() )
@php ( $documento = $denuncia->documentos()->whereHas('categoria',function($q){$q->whereCodigo('auto_admision_denuncia');})->first() )
<div class="row bg-white">
    <div class="col-12 text-danger">
        <h6 class="fw-bolder">Información de la admisión</h6>
    </div>
    <div class="row my-1">
        <div class="col">
            <p class="fw-bolder ms-0 m-1">Fecha de admisión</p>
            <p class="ms-0 m-1">{{$estatus->created_at->format('d/m/Y H:i')}}</p>
        </div>
        <div class="col">
            <p class="fw-bolder ms-0 m-1">Tipo de inspección</p>
            <p class="ms-0 m-1">{{@$denuncia->tipoInspeccion->nombre??'Dato no proporcionado'}}</p>
        </div>
        <div class="col">
            <p class="fw-bolder ms-0 m-1">Carácter de la denuncia</p>
            <p class="ms-0 m-1">{{$denuncia->caracter->nombre??'Dato no proporcionado'}}</p>
        </div>
    </div>
    <div class="row my-1">
        <div class="col-12">
            <span class="mb-3">Información adicional</span>
            <div class="text-justify f-10 break-w">{!!$estatus->observacion??'Dato no proporcionado'!!}</div>
        </div>
    </div>
    @isset($documento->ruta)
        <div class="row">
            <div class="col bg-white">
                @include('denuncias.fragmentos.documento', ['item' => $documento])
            </div>
        </div>
    @endisset
</div>

