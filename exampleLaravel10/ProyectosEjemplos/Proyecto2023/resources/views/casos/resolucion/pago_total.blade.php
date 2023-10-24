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
    <h5 class="text-estatus-pago_total">
        <small class="fw-semibold">
            Pago total
        </small>
    </h5>
</div>
<div class="bg-white p-3">
    <form method="post" action="{{route('casos.resolucion.crear_pago_total')}}" id="form_pago_total" class="necesita-validacion" novalidate>
    @csrf
        <input type="hidden" id="total_multa" value="{{lempiras($caso->total_multa)}}">
        <input type="hidden" name="caso_id" value="{{@$caso->id}}">
        <div class="row mt-3">
            <div class="row">
                <div class="form-group col-md-4 mb-2">
                    <label for="fecha">Fecha del pago *</label>
                    <input id="fecha_pago_total" type="date" class="form-control bg-white" name="fecha" value="{{ old('fecha') }}" max="9999-12-31" min="1970-01-01" required>
                    <span class="text-danger">{{ $errors->first('fecha')}}</span>
                    <div class="invalid-feedback fw-regular" data-default="Dato obligatorio o fecha inválida"></div>
                </div>
                <div class="form-group col-md-4 mb-2">
                    <label for="folio">Número de recibo de pago *</label>
                    <input type="text" class="form-control bg-white" name="num_recibo" value="{{ old('num_recibo') }}" placeholder="Escriba número de recibo del pago" id="num_recibo" required maxlength="150">
                    <span class="text-danger">{{ $errors->first('num_recibo')}}</span>
                    <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                </div>
                <div class="form-group col-md-4 mb-2">
                </div>
                <div class="form-group col-md-4 mb-2">
                    <label for="monto">Capital *</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text">L</span>
                        <input type="text" class="form-control bg-white montosPagoTotal" name="monto" id="monto_pago_total" placeholder="Escriba el monto pagado" value="{{ old('monto') }}" required maxlength="29">
                        <span class="text-danger">{{ $errors->first('monto')}}</span>
                        <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                    </div>
                </div>
                <div class="form-group col-md-4 mb-2">
                    <label for="monto">Intereses </label>
                    <div class="input-group mb-3">
                        <span class="input-group-text">L</span>
                        <input type="text" class="form-control bg-white interesPagoTotal" name="intereses" id="interes_pago_total" placeholder="Escriba el interés" value="{{ old('intereses') }}" maxlength="32">
                    </div>
                </div>
                <div class="form-group col-md-4 mb-2">
                    <label for="monto">Monto total</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control"  name="monto_total" id="monto_total_pago_total" value="{{ old('monto_total') }}" readonly>
                    </div>
                </div>
                @if(isset($mostrarTipoPago) && $mostrarTipoPago==true)
                <div class="form-group col-md-4 mb-2">
                    <label for="monto">Tipo de pago *</label>
                    <div class="input-group mb-3">
                        @if(isset($tiposPagos) && $tiposPagos->count()>0)
                            @foreach($tiposPagos as $tipoPago)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipoPago" id="inlineRadio1" value="{{$tipoPago->id}}" {{ old('tipoPago') == $tipoPago->id ? 'checked' : '' }} required>
                                    <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                                    <label class="form-check-label" for="inlineRadio1">{{$tipoPago->nombre}}</label>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
        <div class="row mt-4 justify-content-end">
            <div class="form-group col-md-3 mb-2 mb-md-0">
                <a href="{{route('casos.getResumen',['caso_id' => $caso->id])}}" class="btn btn-accion-detalle btn-default w-100 fw-semibold">Cancelar</a>
            </div>
            <div class="form-group col-md-3 mb-2 mb-md-0">
                <button type="submit" form="form_pago_total" class="btn btn-accion-detalle bg-estatus-pago_total w-100 fw-semibold">Guardar</button>
            </div>
        </div>
    </form>
</div>
    @include('casos.resolucion.partials.modal_total_pago_total')
@endsection
