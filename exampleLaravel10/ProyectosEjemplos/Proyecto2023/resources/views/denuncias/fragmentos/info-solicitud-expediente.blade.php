    @forelse ($denuncia->gestion_denuncia as $items_pro )
        @if ( $items_pro->estatus_id  ==  obtenerIdCatalogoElementCodigo('expediente_recibido'))
            <div class="row  bg-white sub-titulo-red">
                <div class="bg-border mb-3"></div>
                Respuesta
            </div>
            <div class="row bg-white">
                <div class="col-12">
                    <span>Detalle de la respuesta</span>
                    <p>{!!$denuncia->solicitudExpedienteDGIT('expediente_recibido')->observacion ??'Dato no proporcionado'!!}</p>
                </div>
                <div class="col-12 bg-white">
                    @forelse($docs_respuesta_solicitud_expediente as $key => $item)
                        @include('denuncias.fragmentos.documento', ['item' => $item])
                    @empty
                        <p>Dato no proporcionado.</p>
                    @endforelse

                </div>
            </div>
        @endif
        @if ( $items_pro->estatus_id  ==  obtenerIdCatalogoElementCodigo('solicitud_expediente'))
            <div class="row bg-white">
                <div class="col-12 text-danger">
                    <h6 class="fw-bolder">Información de la solicitud</h6>
                </div>
                <div class="row">
                    <div class="col">
                        <span class="mb-3">Fecha</span>
                        <p>{{ $items_pro->created_at->format('d/m/Y H:i') }} </p>
                    </div>
                    <div class="col">
                        <span class="mb-3">Jefe regional de inspección</span>
                        <p>{{$items_pro->asignado->NombreCompleto}}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <span class="mb-3">Información adicional</span>
                        @isset($items_pro->observacion)
                            <div class="text-justify f-10 break-w">{!!$items_pro->observacion!!}</div>
                        @else
                            <p>Dato no proporcionado.</p>
                        @endisset
                    </div>
                </div>

                @isset($doc_solicitar_expe->ruta)
                    @include('denuncias.fragmentos.documento', ['item' => $doc_solicitar_expe])
                @endisset
            </div>
        @endif
    @empty

    @endforelse

