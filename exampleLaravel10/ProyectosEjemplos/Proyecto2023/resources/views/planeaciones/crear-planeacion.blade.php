@extends('layouts.app')
@section('content')

    <nav aria-label="breadcrumb" class="py-1">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-small-size"><a href="#">Auditorías</a></li>
            <li class="breadcrumb-item font-small-size"><a href="{{ route('planeaciones') }}">Planeaciones anuales de auditorías</a></li>
            <li class="breadcrumb-item font-small-size active" aria-current="page">Planeación anual {{ @$planeacion->anio }}</li>
        </ol>
    </nav>

    <form action="{{ route('planeaciones.planeacion.create') }}" method="post" class="d-block pb-4 necesita-validacion" novalidate enctype="multipart/form-data">
        @csrf
        @if(isset($planeacion))
            <input type="hidden" name="planeacion" value="{{ $planeacion->id }}">
        @endif

        <div class="d-flex flex-row justify-content-between align-items-center pb-2">
            <h5 class="fw-semibold d-flex gap-3 m-0 align-items-end">
                <div class="">
                    Nuevo plan anual de auditorías
                </div>
            </h5>
            <div class="back">
                <a href="{{ route('planeaciones') }}" class="d-flex text-decoration-none font-small-size fw-semibold align-items-center text-gray gap-2">
                    <i class="fas fa-arrow-left"></i>
                    <span class="text-decoration-underline">
                            Volver a planeación <span class="d-none d-md-inline">anual de auditorías</span>
                        </span>
                </a>
            </div>
        </div>

        @include('planeaciones.partials.wizard', ['step' => 'generales'])

        <div class="bg-white px-4 py-3 my-4">
            @if(@$registrados && count($registrados))
                <input type="hidden" id="existentes" value="{{ implode(',', $registrados) }}">
            @endif

            <div class="row">
                <div class="form-group col-12 col-md-6 mb-3">
                    <label class="form-label" for="anio">Año *</label>
                    <select name="anio" id="anio" class="form-select input-regular-height" required>
                        <option value="">Seleccione</option>
                        @php
                            $añoActual = date('Y');
                        @endphp
                        @for($i = $añoActual; $i <= $añoActual + 3; $i++)
                            <option value="{{ $i }}" @if(isset($planeacion) && $i == $planeacion->anio) selected @endif>{{ $i }}</option>
                        @endfor
                    </select>
                    <div class="invalid-feedback" data-default="Este campo es obligatorio."></div>
                    <div class="text-danger font-regular-size pt-1" id="anio_invalido" style="display: none;">
                        Ya se ha registrado la Planeación anual de auditorías para el año seleccionado. Elija otra opción.
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-12 mb-3">
                    <label class="form-label" for="objetivo">Objetivo *</label>
                    <textarea type="text" name="objetivo" class="form-control font-regular-size editor"
                              rows="7" required maxlength="1700"
                              placeholder="Escriba el objetivo" rows="4">{{ @$planeacion->objetivo }}</textarea>
                    <div class="invalid-feedback" data-default="Este campo es obligatorio y debe tener máximo 1700 caracteres."></div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-12 mb-3">
                    <label class="form-label" for="alcance">Alcance *</label>
                    <textarea type="text" name="alcance" class="form-control font-regular-size editor"
                              rows="7" required maxlength="1700"
                              placeholder="Escriba el alcance" rows="4">{{ @$planeacion->alcance }}</textarea>
                    <div class="invalid-feedback" data-default="Este campo es obligatorio y debe tener máximo 1700 caracteres."></div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-12 mb-3">
                    <label class="form-label" for="criterio">Criterio *</label>
                    <textarea type="text" name="criterio" class="form-control font-regular-size editor"
                              rows="7" required maxlength="1700"
                              placeholder="Escriba el criterio" rows="4">{{ @$planeacion->criterio }}</textarea>
                    <div class="invalid-feedback" data-default="Este campo es obligatorio y debe tener máximo 1700 caracteres."></div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-12 mb-3">
                    <label class="form-label" for="recursos">Recursos *</label>
                    <textarea type="text" name="recursos" class="form-control font-regular-size editor"
                              rows="7" required maxlength="1700"
                              placeholder="Escriba los recursos" rows="4">{{ @$planeacion->recursos }}</textarea>
                    <div class="invalid-feedback" data-default="Este campo es obligatorio y debe tener máximo 1700 caracteres."></div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-12 col-md-6 col-lg-5 col-xl-4 mb-3">
                    @include('components.carga-archivos',['codigo'=>'plan_anual_auditorias','nombre'=>'Plan anual de auditorías', 'required' => true,'eliminable'=>true, 'entidad' => @$planeacion])
                </div>

            </div>

        </div>

        <div class="d-flex justify-content-between my-4">
            <a href="{{ route('planeaciones') }}" class="btn btn-default input-regular-height align-items-center d-flex gap-2">
                <i class="fas fa-arrow-circle-left"></i>
                <span>Cancelar</span>
            </a>

            <button type="submit" class="btn btn-secondary input-regular-height align-items-center d-flex gap-2">
                <span>Guardar y continuar</span>
                <i class="fas fa-arrow-circle-right"></i>
            </button>

        </div>

    </form>
@endsection
