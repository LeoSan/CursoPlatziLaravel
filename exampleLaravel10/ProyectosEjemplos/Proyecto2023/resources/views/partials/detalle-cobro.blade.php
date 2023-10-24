<div class="d-flex flex-column detalle-cobro detalles align-items-center pt-2 w-100">
    <div class="item d-flex w-100 gap-2">
        <span class="text-graylight">Total de la multa:</span>
        <strong class="fw-semibold">L {{ lempiras($caso->total_multa) }}</strong>
    </div>
    <div class="item d-flex w-100 gap-2">
        <span class="text-graylight">Cobrado sin intereses:</span>
        <strong class="fw-semibold">L {{ lempiras($caso->total_cobrado) }}</strong>
    </div>
    <div class="item d-flex w-100 gap-2">
        <span class="text-graylight">Cobrado con intereses:</span>
        <strong class="fw-semibold">L {{ lempiras($caso->total_cobrado_intereses) }}</strong>
    </div>
</div>
