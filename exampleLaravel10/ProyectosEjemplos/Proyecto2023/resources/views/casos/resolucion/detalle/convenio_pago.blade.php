<div class="bg-white px-4 py-3">
    @php($convenio = $resolucion->convenio)
    @php($pagos = $resolucion->convenio->pagos)
    <input type="hidden" id="total_multa" value="{{ $caso->total_multa }}">
    <input type="hidden" id="total_cobrado" value="{{ $caso->total_cobrado }}">
    <div class="row">
        <div class="form-group col-md-6">
            <label for="numero_pagos">Número de pagos</label>
            <p>{{ $convenio->num_pagos }}</p>
        </div>
        <hr>
        <div class="form-group col-md-4">
            <label for="total_multa">Monto a cobrar</label>
            <p>L {{ lempiras($caso->total_multa) }}</p>
        </div>
        <div class="form-group col-md-4">
            <label for="total_cobrado">
                Total cobrado (sin intereses)
            </label>
            <p>L {{ lempiras($caso->total_cobrado) }}</p>
        </div>
        <div class="form-group col-md-4">
            <label for="total_cobrado_intereses">
                Total cobrado (con intereses)
            </label>
            <p>L {{ lempiras($caso->total_cobrado_intereses) }}</p>
        </div>
    </div>
    <hr>
    <div class="row">
        @if(isset($pagos) && $pagos->count()>0)
            @foreach($pagos->sortBy('num_pago') as $pago)
                <div class="col-12 mt-3 mb-3" id="pago_{{ $pago->num_pago }}">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="fw-semibold mb-2 font-regular-size">
                            Pago {{$pago->num_pago==0?'de Prima':$pago->num_pago}}
                        </h5>
                        <div class="font-small-size">
                            @if(!$pago->pagado && $pago->vencido)
                                @include('partials.pago-pendiente')
                            @endif
                        </div>
                    </div>

                    <div class="card border-1 @if(!$pago->pagado && $pago->fecha < date('Y-m-d'). ' 00:00:00') border-danger @else border-gray @endif">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-4 mb-2">
                                    <label for="fecha_pago_convenio">Fecha del convenio</label>
                                    <div class="d-flex gap-2 align-items-center">
                                        <div class="pt-1">
                                            {{ $pago->fecha->format('d/m/Y') }}
                                        </div>
                                        @if(!$pago->pagado && $pago->fecha < date('Y-m-d') . ' 00:00:00')
                                            <div class="text-danger">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                                                    <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                    <path d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z"
                                                          fill="currentColor" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group col-md-4 mb-2">
                                    <label for="monto">Monto</label>
                                    <p>L {{ lempiras($pago->monto) }}</p>
                                </div>
                                @if((auth()->user()->can('resolucion_caso_convenio_pago')))
                                    <div class="form-group col-12 my-2">
                                        <label for="fecha_pago">¿El pago ya fue realizado?</label>
                                        <div class="d-flex align-items-center gap-1">
                                            <label class="form-check-label"
                                                   for="input_pagado_{{ $pago->num_pago }}">No</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input input-pagado"
                                                       data-pago="{{ $pago->num_pago }}" type="checkbox"
                                                       id="input_pagado_{{ $pago->num_pago }}"
                                                       {{ $pago->pagado || $caso->multa_pagada || $caso->estatus->codigo != 'convenio_pago' ? 'disabled '.($pago->pagado?'checked':'') :''}}
                                                       onchange="mostrarPago(this)" >
                                                <label class="form-check-label"
                                                       for="input_pagado_{{ $pago->num_pago }}">Si</label>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="form-group col-12 my-2">
                                        <label for="fecha_pago">¿El pago ya fue realizado?</label>
                                        <p>{{ $pago->pagado ? 'Si' : 'No' }}</p>
                                    </div>
                                @endif
                            </div>

                            @if(!$pago->pagado && (auth()->user()->can('resolucion_caso_convenio_pago')) )
                                <div id="pago_convenio_{{ $pago->num_pago }}" style="display: none;">
                                    <form action="/casos/convenio-pago" method="post" class="row" id="pago_convenio_form_{{ $pago->num_pago }}" novalidate onsubmit="validarFormulario(event)">
                                        @csrf
                                        <input type="hidden" name="convenio" value="{{ $convenio->id }}">
                                        <input type="hidden" name="num_pago" value="{{ $pago->num_pago }}">
                                        <hr>
                                        <h6 class="fw-semibold mb-3">
                                            <small>
                                                Detalles del pago
                                            </small>
                                        </h6>
                                        <div class="form-group col-md-6 mt-1 mb-2">
                                            <label for="fecha_pago">Fecha de realización del pago *</label>
                                            <input type="date"
                                                   class="form-control bg-white input-regular-height fecha-convenio-demandas"
                                                   name="fecha_pagado" id="fecha_pagado_{{ $pago->num_pago }}"
                                                   max="{{ date('Y-m-d') }}" required>
                                            <div class="invalid-feedback fw-regular" data-default="Dato obligatorio o fecha inválida"></div>
                                        </div>

                                        <div class="form-group col-md-6 mt-1 mb-2">
                                            <label for="num_recibo">Número de recibo de pago *</label>
                                            <input type="text" class="form-control bg-white input-regular-height"
                                                   name="num_recibo"
                                                   id="num_recibo_{{ $pago->num_pago }}" placeholder="" maxlength="100" required>
                                            <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                                        </div>

                                        <div class="form-group col-md-4 mt-1 mb-2">
                                            <label for="fecha_pago">Capital *</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">L</span>
                                                <input type="text"
                                                       class="form-control bg-white monto_pago input-regular-height convenio_monto_pagado" onkeyup="this.value = lempiras(this.value)"
                                                       name="monto_pagado"
                                                       id="monto_pagado_{{ $pago->num_pago }}"
                                                       data-pago="{{ $pago->num_pago }}"
                                                       placeholder="Escriba el monto" required maxlength="29">
                                                <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-4 mt-1 mb-2">
                                            <label for="fecha_pago">Intereses</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">L</span>
                                                <input type="text"
                                                       class="form-control bg-white monto_pago input-regular-height convenio_monto_intereses" onkeyup="this.value = lempiras(this.value)"
                                                       name="intereses"
                                                       id="intereses_{{ $pago->num_pago }}"
                                                       data-pago="{{ $pago->num_pago }}"
                                                       placeholder="Escriba el monto" maxlength="29">
                                            </div>
                                        </div>

                                        <div class="form-group col-md-4 mt-1 mb-2">
                                            <label for="fecha_pago">Monto pagado</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">L</span>
                                                <input type="text"
                                                       class="form-control bg-white monto_pago input-regular-height input-disabled convenio_monto_total"
                                                       name="monto_pagado_intereses"
                                                       id="monto_pagado_intereses_{{ $pago->num_pago }}" placeholder="0.00" value="0.00"
                                                       disabled required>
                                            </div>
                                        </div>

                                        <div class="d-flex gap-4 pt-3 justify-content-end seccion-acciones">
                                            <div class="w-100">
                                                <button type="button"
                                                        class="btn btn-accion-detalle btn-default w-100 cancelar-pago"
                                                        data-pago="{{ $pago->num_pago }}">
                                                    Cancelar
                                                </button>
                                            </div>
                                            @if(($convenio->num_pagos) == $pagos->where('pagado', true)->count())
                                                <div class="w-100">
                                                    <button type="button"
                                                            data-pago="{{ $pago->num_pago }}"
                                                            class="btn btn-accion-detalle bg-estatus-convenio_pago convenio-incompleto w-100">
                                                        Guardar
                                                    </button>
                                                </div>
                                            @else
                                                <div class="w-100">
                                                    <button type="submit"
                                                            class="btn btn-accion-detalle bg-estatus-convenio_pago w-100">
                                                        Guardar
                                                    </button>
                                                </div>
                                            @endif
                                        </div>

                                    </form>
                                </div>
                            @elseif($pago->pagado)
                                <div class="row">
                                    <div class="form-group col-md-4 mb-2">
                                        <label for="fecha_pago_convenio">Fecha de realización del pago</label>
                                        @if($pago->fecha_pagado)
                                            <p>{{ $pago->fecha_pagado->format('d/m/Y') }}</p>
                                        @else
                                            <p class="text-gray">Dato no proporcionado</p>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-4 mb-2">
                                        <label for="monto">Número de recibo</label>
                                        <p>{{ $pago->num_recibo }}</p>
                                    </div>
                                    <div class="form-group col-md-4 mb-2">
                                        <label for="monto">{{$pago->num_pago==0?"Monto pagado":'Capital'}}</label>
                                        <p>L {{ lempiras($pago->monto_pagado) }}</p>
                                    </div>
                                    @if($pago->num_pago!=0)
                                        <div class="form-group col-md-4 mb-2">
                                            <label for="monto">Intereses</label>
                                            <p>L {{ lempiras($pago->intereses) }}</p>
                                        </div>
                                        <div class="form-group col-md-4 mb-2">
                                            <label for="monto">Monto pagado (con intereses)</label>
                                            <p>L {{ lempiras($pago->monto_pagado_intereses) }}</p>
                                        </div>
                                    @endif

                                </div>
                            @endif


                        </div>
                    </div>
                </div>
            @endforeach
        @endif

    </div>

</div>



