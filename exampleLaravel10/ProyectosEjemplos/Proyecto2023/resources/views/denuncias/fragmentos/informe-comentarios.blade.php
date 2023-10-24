<div class="bg-white pt-1">
    @if($informe->comentarios)
    <div class="mb-4">
        <h5 class="fw-bold text-danger fs-6">
            Comentarios
        </h5>
        <div class="mb-4 font-regular-size">
            {!! $informe->comentarios !!}
        </div>
    </div>
    @endif

    <div class="row mb-1">
        @if($informe->adjuntos?->count())
            <h5 class="fw-semibold fs-6">Adjuntos</h5>
            @foreach($informe->adjuntos as $documento)
                
                @include('denuncias.fragmentos.documento', ['item' => $documento])

            @endforeach
        @endif
    </div>
</div>
