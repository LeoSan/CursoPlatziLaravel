@extends('layouts.app')
@section('content')
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('casos.index')}}">Bandeja de casos</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$caso->numero_expediente}}</li>
            </ol>
        </nav>
    </div>
    <div class="row mb-3 font-regular-size">
        <div>
            <h5 class="p-0 mb-2">
                <strong class="fw-semibold">
                    Expediente
                    {{ isset($caso->numero_expediente) ? $caso->numero_expediente : '##'}}
                </strong>
            </h5>
        </div>

        @include('partials.estatus', ['estatus' => $caso->estatus])

        @include('partials.detalle-cobro')
    </div>
    <div class="row mb-3">
        <h5 class="text-estatus-convenio_pago">
            <small class="fw-semibold">
                Convenio de pago
            </small>
        </h5>
    </div>
    <div class="bg-white p-3">
        <form method="post" action="{{route('casos.resolucion.crear_convenio_pago')}}" id="form_convenio_pago" class="necesita-validacion" novalidate>
            @csrf
            <input type="hidden" id="total_multa" value="{{lempiras($caso->total_multa)}}">
            <input type="hidden" name="caso_id" value="{{$caso->id}}">


            <div class="row">
                <div class="col-12 mt-3 bg-white">
                    <span class="fw-bold">Prima</span>
                </div>
                <div class="form-group col-md-4 mb-2">
                    <label for="monto_prima">Monto *</label>
                    <div class="input-group mb-3 bg-white">
                        <span class="input-group-text">L</span>
                        <input type="text" class="form-control bg-white lempiras monto_pago" name="monto_prima" id="monto_prima" placeholder="Escriba el monto" step=".01" value="{{ old('monto_prima')}}" required maxlength="29" onchange="calculoTotalPagos()">
                        <div class="invalid-feedback" data-default="Dato obligatorio"></div>
                    </div>
                </div>
                <div class="form-group col-md-4 mb-2">
                    <label for="fecha_pago_prima">Fecha *</label>
                    <input type="date" class="form-control bg-white" name="fecha_pago_prima" id="fecha_pago_prima" max="{{date('Y-m-d')}}" value="{{ old('fecha_pago_prima')}}" min="1970-01-01" required>
                    <div class="invalid-feedback" data-default="Dato obligatorio o fecha inválida"></div>
                </div>
                <div class="form-group col-md-4 mb-2">
                    <label for="num_recibo">Número de recibo de pago *</label>
                    <input type="text" class="form-control bg-white"
                           name="num_recibo_prima" placeholder="Escriba el número de recibo de pago" value="{{old('num_recibo_prima')}}" maxlength="100" required>
                    <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                </div>
                <div class="form-group col-md-4 mb-2">
                    <label for="numero_pagos">Número de pagos *</label>
                    <select name="numero_pagos" id="numero_pagos" class="input-regular-height font-regular-size selectpicker-usuarios form-select bg-white" onchange="numPagos(this)"
                            required>
                        <option value="">Seleccione el número de pagos</option>
                        @for ($i = 1; $i <= config('num_pagos', 12); $i++)
                            <option value="{{$i}}" {{old('numero_pagos')==$i ? 'selected' :'' }}>{{$i}}</option>
                        @endfor
                        {{ config('app.name', 'SETRASS') }}
                    </select>
                    <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                </div>
            </div>
            <div class="row mt-3" id="div_numero_pagos">
                @if(old('numero_pagos'))
                    @for( $i =0; $i < old('numero_pagos'); $i++)
                        <div class="col-12 mt-3 bg-white">
                            <h6 class="fw-semibold mb-2 font-regular-size">Pago {{$i}}</h6>
                            <div class="card border border-dark">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-4 mb-2">
                                            <label for="monto">Monto</label>
                                            <div class="input-group mb-3 bg-white">
                                                <span class="input-group-text">L</span>
                                                <input type="text" class="form-control bg-white lempiras" name="monto[]"
                                                       id="num_convenio" placeholder="Escriba el monto" step=".01"
                                                       value="{{ old('monto.'.$i)}}" required maxlength="29">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4 mb-2">
                                            <label for="fecha_pago">Fecha</label>
                                            <input type="date" class="form-control bg-white fecha-convenio-demandas"
                                                   name="fecha_pago[]" id="fecha_pago" max="9999-12-31"
                                                   min="{{date('Y-m-d')}}"
                                            value="{{ old('fecha_pago.'.$i)}}"  required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor
                @endif
                <div class="col-12 mt-3 bg-white text-end">
                    <span class="fw-bold">Total por pagar: </span> <span id="total_por_pagar"></span>
                </div>
            </div>
            <div class="row mt-4 justify-content-end">
                <div class="form-group col-md-3 mb-2 mb-md-0">
                    <a href="{{route('casos.getResumen',['caso_id' => $caso->id])}}" class="btn btn-accion-detalle btn-default w-100 fw-semibold">Cancelar</a>
                </div>
                <div class="form-group col-md-3 mb-2 mb-md-0" id="div_boton_convenio">
                    <button type="submit" form="form_convenio_pago" class="btn btn-accion-detalle bg-estatus-convenio_pago w-100 fw-semibold">Guardar</button>
                </div>
            </div>
        </form>
    </div>
    @include('casos.resolucion.partials.modal_total_pago')
@endsection


