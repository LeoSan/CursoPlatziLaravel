<div class="row mt-3 p-3 rounded bg-white">
    <div class="row">
        <div class="col-md-4 mb-2">
            <label for="numero_pagos">Fecha del descargo</label>
            <p>{{$resolucion->fecha->format('d/m/Y H:i')}}</p>
        </div>
        <div class="col-md-auto mb-2">
            <label for="numero_pagos">Tipo de descargo</label>
            <p>{{$resolucion->motivo->nombre}}</p>
        </div>
        <div class="col-md-12 mb-2">
            <label for="numero_pagos">Observaciones</label>
            @if($resolucion->observaciones)
                {!! $resolucion->observaciones !!}
            @else
                <p>Dato no proporcionado</p>
            @endif
        </div>
    </div>
</div>
