<div class="row mt-3 p-3 rounded bg-white">
    @php($demanda = $resolucion->demanda)
    <div class="row">
        <div class="form-group col-md-4 mb-2">
            <label for="numero_pagos">Fecha de la demanda</label>
            <p>{{$demanda->fecha->format('d/m/Y')}}</p>
        </div>
        <div class="form-group col-md-4 mb-2">
            <label for="numero_pagos">Número de expediente</label>
            <p>{{$demanda->num_expediente}}</p>
        </div>
        <div class="form-group col-md-4 mb-2">
            <label for="numero_pagos">Nombre del juzgado</label>
            <p>{{$demanda->nom_juzgado}}</p>
        </div>
        <div class="form-group col-md-4 mb-2">
            <label for="numero_pagos">Nombre del juez</label>
            <p>{{$demanda->nom_juez}}</p>
        </div>
        <div class="form-group col-md-4 mb-2">
             @include('components.carga-archivos',['codigo'=>'caratula_expediente','nombre'=>'Carátula del expediente', 'entidad' => $demanda,'eliminable'=>false])
        </div>
    </div>
</div>
