@if ($denuncia->inadmision()->estatus_id == obtenerIdCatalogoElementCodigo('inadmision') || $denuncia->inadmision()->estatus_id == obtenerIdCatalogoElementCodigo('revision_inadmision'))
    <div class="row bg-white">
        <div class="sub-titulo-red">
            Información de inadmisión
        </div>
        <div class="row">
            <div class="col">
                <span class="mb-3">Motivo de la inadmisión</span>
                <p>{{ obtenerCatalogoElementId($denuncia->inadmision()->motivo_id)}}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <span class="mb-3">Información adicional</span>
                <div class="text-justify f-10 break-w">{!!$denuncia->inadmision()->observacion??'Dato no proporcionado.'!!}</div>
            </div>
        </div>
        @isset($doc_oficio_inadmsion_denuncia->ruta)
        
            @include('denuncias.fragmentos.documento', ['item' => $doc_oficio_inadmsion_denuncia])

        @endisset
    </div>
@endif





