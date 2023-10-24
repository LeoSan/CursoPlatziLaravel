<div class="bg-white pt-1">

    <h5 class="fw-bold text-danger fs-6 mb-2">
        Informe del auditor
    </h5>

    <div class="row mb-1">
        @if($informe->documentos?->count())
            @foreach($informe->documentos as $documento)
                @include('denuncias.fragmentos.documento', ['item' => $documento, 'doclabel' => 'Documento'])
            @endforeach
        @endif
    </div>

    <div class="item mb-4">
        <div class="fs-6">
            @if($informe->visita_campo)
                <i class="fa-solid fa-check text-success fs-5 me-1"></i>
            @else
                <i class="fa-solid fa-xmark text-danger fs-5 me-1"></i>
            @endif
            <span class="fw-normal">
                Se realizó visita en campo
            </span>
        </div>
    </div>

    <div class="mb-4">
        <p class="fw-bold">
            Observaciones
        </p>
        <div class="mb-4 font-regular-size">
            @if($informe->observaciones)
                {!! $informe->observaciones !!}
            @else
                Dato no proporcionado
            @endif
        </div>
    </div>

    @if($informe->comentarios)
        <hr class="border-light-gray">

        <div class="mb-4">
            <h5 class="fw-bold text-danger fs-6 mb-2">
                Comentarios
            </h5>
            <div class="mb-4 font-regular-size">
                {!! $informe->comentarios !!}
            </div>
        </div>

        @if($informe->adjuntos?->count())
            <h5 class="fw-semibold fs-6">Adjuntos</h5>
            <div class="row mb-1">
                @foreach($informe->adjuntos as $documento)

                    @include('denuncias.fragmentos.documento', ['item' => $documento])

                @endforeach
            </div>
        @endif
    @endif


    @forelse ($denuncia->gestion_denuncia as $items_gestion )
        @if ($items_gestion->estatus_id == obtenerIdCatalogoElementCodigo('finalizado'))
            <div class="mb-4">
                <div class="bg-border mb-3"></div>
                <div class="col-12 text-danger">
                    <h6 class="fw-bolder">Informe enviado al ministro</h6>
                </div>

                <div class="mb-4 font-regular-size">
                    <span class="mb-3">Fecha de entrega al ministro</span>
                    <p>{{ formatoFecha($items_gestion->fecha_recepcion) }}</p>
                </div>
                @isset($doc_informe_final->ruta)
                    <div class="row bg-white">

                        @include('denuncias.fragmentos.documento', ['item' => $doc_acuse_recibo_informe_final_denuncia])

                        @include('denuncias.fragmentos.documento', ['item' => $doc_informe_final])

                    </div>
                @endisset
            </div>

        @endif
    @empty
        {{''}}
    @endforelse
</div>
