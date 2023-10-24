@extends('layouts.app')
@section('content')
    <div class="row font-regular-size">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('casos.index')}}">Bandeja de casos</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ isset($caso->numero_expediente) ? $caso->numero_expediente : '## exp'}}
                </li>
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

    <form action="/casos/turno" method="post" class="necesita-validacion" novalidate>
        <div class="row mb-3">
            <h5 class="mb-3 text-estatus-{{ $estatus->codigo }}">
                <small class="fw-semibold">
                    {{ $tipo_turno }}
                </small>
            </h5>

            @csrf
            <input type="hidden" name="caso" value="{{ $caso->id }}">
            <input type="hidden" name="estatus" value="{{ $estatus->id }}">
            <input type="hidden" name="tipo_turno" value="turnarCaso">
            <div class="bg-white p-3">

                <div class="d-flex flex-column gap-3 gap-md-4 flex-md-row w-100">
                    <div class="form-group w-100 mb-0 mb-md-3">
                        <label for="numero_expediente_pgr">Número de expediente PGR *</label>
                        <input type="text" class="form-control font-regular-size input-regular-height bg-w"
                               name="numero_expediente_pgr"
                               placeholder="Escribe el número de expediente" id="numero_expediente_pgr" value="{{isset($caso->numero_expediente_pgr)&& $caso->numero_expediente_pgr != null ? $caso->numero_expediente_pgr :  old('numero_expediente_pgr')}}"
                               required maxlength="255">
                        <span class="text-danger">{{ $errors->first('numero_expediente_pgr')}}</span>
                        <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                    </div>

                    <div class="form-group w-100 mb-0 mb-md-3">
                        <label for="fecha_recepcion_pgr">Fecha de ingreso a DNPJ *</label>
                        <input type="date" class="form-control font-regular-size input-regular-height bg-w"
                               name="fecha_recepcion_pgr" id="fecha_recepcion_pgr" max="{{ date('Y-m-d') }}" value="{{isset($caso->fecha_recepcion_pgr) ? $caso->fecha_recepcion_pgr->format('Y-m-d') :  old('fecha_recepcion_pgr')}}" min="1970-01-01" required>
                        <span class="text-danger">{{ $errors->first('fecha_recepcion_pgr')}}</span>
                        <div class="invalid-feedback fw-regular" data-default="Dato obligatorio o fecha inválida"></div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="form-group mb-3">
                    <label for="usuario">Coordinador *</label>
                    <select name="usuario" id="usuario" class="bg-white selectpicker-usuarios input-regular-height font-regular-size" required>
                        <option value="">Escribe para seleccionar</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}">{{ $usuario->complete_name }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                </div>

                <div class="form-group">
                    <label for="instrucciones" class="fw-normal"><b>Instrucciones adicionales</b></label>
                    <textarea name="instrucciones" id="instrucciones" rows="4" class="form-control font-regular-size py-3 px-3 bg-white editor"
                              placeholder="Escriba las instrucciones" maxlength="1700">{{old('instrucciones')}}</textarea>
                    <span class="text-danger">{{ $errors->first('instrucciones')}}</span>
                </div>

            </div>
        </div>
        <div class="row mt-4 justify-content-end">
            <div class="form-group col-md-3 mb-2 mb-md-0">
                <a href="/casos/{{ $caso->id }}/informacion" class="btn btn-accion-detalle btn-default w-100 fw-semibold">
                Cancelar</a>
            </div>
            <div class="form-group col-md-3 mb-2 mb-md-0">
                <button type="submit" class="btn btn-accion-detalle bg-estatus-{{ $estatus->codigo }} w-100 fw-semibold">
                Turnar a coordinador</button>
            </div>
        </div>
    </form>
@endsection
