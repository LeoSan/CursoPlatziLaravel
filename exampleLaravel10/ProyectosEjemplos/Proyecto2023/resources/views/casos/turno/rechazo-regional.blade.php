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

    <form action="/casos/rechazo" method="post" class="necesita-validacion" novalidate>
        <div class="mb-3">
            <h5 class="mb-3 text-estatus-{{ $estatus->codigo }}">
                <small class="fw-semibold">
                    {{ $tipo_turno }}
                </small>
            </h5>

            @csrf
            <input type="hidden" name="caso" value="{{ $caso->id }}">
            <input type="hidden" name="estatus" value="{{ $estatus->id }}">
            <input type="hidden" name="tipo_turno" value="rechazoRegional">
            <div class="bg-white p-3">

                @if($usuarios)
                <div class="form-group mb-3">
                    <label for="usuario">Auxiliar DNPJ *</label>
                        <select name="usuario" id="usuario" class="bg-white selectpicker-usuarios input-regular-height font-regular-size" required>
                            <option value="">Escribe para seleccionar</option>
                            @foreach($usuarios as $usuario)
                                <option value="{{ $usuario->id }}">{{ $usuario->complete_name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                </div>
                @else
                    <input type="hidden" name="usuario" id="usuario_seleccionado" value="{{ $asignado->id }}">
                @endif

                <div class="form-group">
                    @if($motivos && count($motivos))
                        <label for="usuario">Motivo *</label>
                        <select name="motivo" id="motivo" class="bg-white selectpicker-motivos input-regular-height font-regular-size" required>
                            <option value="">Escribe para seleccionar</option>
                            @foreach($motivos as $motivo)
                                <option value="{{ $motivo->id }}">{{ $motivo->nombre }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                    @endif
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
                <button type="submit" class="btn bg-estatus-{{ $estatus->codigo }} btn-accion-detalle text-white w-100 fw-semibold">
                    Regresar a DNPJ
                </button>
            </div>
        </div>
    </form>
@endsection
