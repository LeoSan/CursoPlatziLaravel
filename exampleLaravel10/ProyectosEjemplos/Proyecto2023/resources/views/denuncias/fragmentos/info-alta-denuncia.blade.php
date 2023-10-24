
@forelse ($denuncia->gestion_denuncia as $items_pro )
    @if ($items_pro->estatus_id == obtenerIdCatalogoElementCodigo('en_revision'))
    <div class="row bg-white">
        <div class="row">
            <div class="col">
                <span>¿Se notificó a la DGIT?</span>
                @if (  strlen($denuncia->correo_dgit) > 0   == 1)
                    <p> Sí | {{  strtolower($denuncia->correo_dgit)}}</p>
                @else
                    <p> No</p>
                @endif
            </div>
            <div class="col">
                <span>Número de expediente DGIT</span>
                <p>{{$denuncia->num_expediente_dgit}}</p>
            </div>
            <div class="col">
                <span>Número de expediente ATI</span>
                <p>{{$denuncia->num_expediente}}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <span>Observaciones</span>
                @isset($items_pro->observacion)
                    <div class="text-justify f-10 break-w">{!!$items_pro->observacion!!}</div>
                @else
                    <p>Dato no proporcionado.</p>
                @endisset

            </div>
        </div>
        @isset($doc_alta_denun->ruta)
        <div class="col-12 mb-3">
            @include('denuncias.fragmentos.documento', ['item' => $doc_alta_denun])
        </div>
        @endisset
    </div>


    @endif
@empty

@endforelse
