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

    <form action="{{ route('casos.no-procedente-crear') }}" method="post" autocomplete="off" accept-charset="UTF-8" class="necesita-validacion" novalidate>
        <h5 class="mb-3 text-estatus-{{ $estatus->codigo }}">
            <small class="fw-semibold">
                Caso no procedente
            </small>
        </h5>
        <div class="row mb-3 bg-w px-3 py-3" >

            @csrf
            <input type="hidden" name="caso_id" value="{{ $caso->id }}">
            <div class="bg-white p-3">
                <div class="form-group">
                    <label for="motivos" class="fw-normal"><b>Motivos por los que no procede el caso *</b></label>
                    <textarea name="motivos" class="form-control editor" rows="7" required maxlength="1700">{{old('motivos')}}</textarea>
                    <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                    <span class="text-danger txt-parrafo-error">{{ $errors->first('motivos')}}</span>
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
                    No procedente
                </button>
            </div>
        </div>
    </form>
@endsection
