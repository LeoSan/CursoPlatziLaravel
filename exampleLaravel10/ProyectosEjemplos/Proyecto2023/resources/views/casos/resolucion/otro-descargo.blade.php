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

    <form action="{{route('casos.storeOtroDescargo')}}" method="post" class="necesita-validacion" novalidate id="form_otro_descargo">
        <div class="mb-3">
            <h5 class="mb-3 text-estatus-otro_descargo">
                <small class="fw-semibold">
                    Otro descargo
                </small>
            </h5>

            @csrf
            <input type="hidden" name="caso_id" value="{{ $caso->id }}">
            <div class="bg-white p-3">
                <div class="form-group">
                    <label for="motivo">Tipo de descargo *</label>
                    <select name="motivo" id="motivo"
                            class="bg-white selectpicker-motivos input-regular-height font-regular-size" required>
                        <option value="">Escribe para seleccionar</option>
                        @foreach(getCatalogoElementos('tipos_descargo') as $motivo)
                            <option value="{{ $motivo->id }}">{{ $motivo->nombre }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" data-default="El tipo de descargo es obligatorio">
                    </div>
                </div>
                <div class="form-group mt-2">
                    <label for="observaciones">Observaciones</label>
                    <textarea name="observaciones" id="observaciones" rows="4" class="form-control font-regular-size py-3 px-3 bg-white editor"
                              placeholder="Escriba las observaciones" maxlength="1700">{{old('observaciones')}}</textarea>
                </div>
            </div>
        </div>
        <div class="row mt-4 justify-content-end">
            <div class="form-group col-md-3 mb-2 mb-md-0">
                <a href="{{url()->previous()}}"
                   class="btn btn-accion-detalle btn-default w-100 fw-semibold">
                    Cancelar
                </a>
            </div>
            <div class="form-group col-md-3 mb-2 mb-md-0">
                <button type="submit" class="btn btn-accion-detalle bg-btn-guardar text-white w-100 fw-semibold">
                    Guardar
                </button>
            </div>
        </div>
    </form>
    @include('casos.turno.partials.modal_confirmar_descargo')
@endsection
