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

                <div class="form-group mb-3">
                    <label for="usuario">Procurador *</label>
                    <select name="usuario" id="usuario" class="bg-white selectpicker-usuarios input-regular-height font-regular-size" required>
                        <option value="">Escribe para seleccionar</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}">{{ $usuario->complete_name }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" data-default="Dato obligatorio"></div>
                </div>
                <div class="form-group">
                    <label for="instrucciones" class="fw-normal"><b>Instrucciones adicionales</b></label>
                    <textarea name="instrucciones" id="instrucciones" rows="4" class="form-control font-regular-size py-3 px-3 bg-white editor"
                              placeholder="Escriba las instrucciones" maxlength="1700">{{old('instrucciones')}}</textarea>
                </div>

            </div>
        </div>
        <div class="row mt-4 justify-content-end">
            <div class="form-group col-md-3 mb-2 mb-md-0">
                <a href="/casos/{{ $caso->id }}/informacion" class="btn btn-accion-detalle btn-default w-100 fw-semibold">
                    Cancelar
                </a>
            </div>
            <div class="form-group col-md-3 mb-2 mb-md-0">
                <button type="submit" class="btn btn-accion-detalle bg-estatus-{{ $estatus->codigo }} w-100 fw-semibold">
                    Reasignar procurador
                </button>
            </div>
        </div>
    </form>
@endsection
