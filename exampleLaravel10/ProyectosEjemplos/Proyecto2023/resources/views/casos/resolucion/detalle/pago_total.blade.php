<div class="row mt-3 p-3 rounded bg-white">
    @php($pago = $resolucion->pagototal)
    <div class="row">
        <div class="form-group col-md-4 mb-2">
            <label for="numero_pagos">Fecha de pago total</label>
            <p>{{$pago->fecha->format('d/m/Y')}}</p>
        </div>
        <div class="form-group col-md-4 mb-2">
            <label for="numero_pagos">Número de recibo de pago</label>
            <p class="text-break">{{$pago->num_recibo}}</p>
        </div>
        <div class="form-group col-md-4 mb-2">
            <label for="numero_pagos">Monto pagado</label>
            <p>L {{ lempiras($pago->monto) }}</p>
        </div>
        <div class="form-group col-md-4 mb-2">
            <label for="numero_pagos">Intereses</label>
            <p>L {{ lempiras($pago->interes) }}</p>
        </div>
        <div class="form-group col-md-4 mb-2">
            <label for="numero_pagos">Monto total</label>
            <p>L {{ lempiras($pago->monto_total) }}</p>
        </div>
        @if($pago->tipo_pago_id != null)
        <div class="form-group col-md-4 mb-2">
            <label for="numero_pagos">Tipo de pago</label>
            <p>{{ $pago->tipoPago->nombre }}</p>
        </div>
        @endif
    </div>
</div>
