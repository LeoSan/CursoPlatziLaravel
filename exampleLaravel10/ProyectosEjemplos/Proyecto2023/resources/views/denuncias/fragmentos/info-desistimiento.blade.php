@php ( $estatus = $denuncia->gestion()->whereHas('estatus',function($q){$q->whereCodigo('desestimado');})->first() )
@php ( $documento = $denuncia->documentos()->whereHas('categoria',function($q){$q->whereCodigo('desistimiento_denuncia');})->first() )
<div class="row bg-white">
    <div class="col-12 text-danger">
        <h6 class="fw-bolder">Información de la desestimación</h6>
    </div>
    <div class="row my-1">
        <div class="col">
            <p class="fw-bolder ms-0 m-1">Fecha de la desestimación</p>
            <p class="ms-0 m-1">{{$estatus->created_at->format('d/m/Y H:i')}}</p>
        </div>
        <div class="col">
            <p class="fw-bolder ms-0 m-1">Motivo de la desestimación</p>
            <p class="ms-0 m-1">{{$estatus->motivo->nombre}}</p>
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
