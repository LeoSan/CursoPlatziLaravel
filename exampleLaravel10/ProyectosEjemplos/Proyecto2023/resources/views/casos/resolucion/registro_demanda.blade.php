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
    <h5 class="text-estatus-demanda">
        <small class="fw-semibold">
            Registro de demanda
        </small>
    </h5>
</div>
<div class="bg-white p-3">
    <form method="post" action="{{route('casos.resolucion.crear_demanda')}}" id="form_registro_caso" enctype="multipart/form-data" class="necesita-validacion" novalidate>
    @csrf
        <input type="hidden" name="caso_id" value="{{@$caso->id}}">
        <div class="row mt-3">
            <div class="col-12">
                <div class="row">
                    <div class="form-group col-md-6 mb-2">
                        <label for="fecha_demanda">Fecha de la demanda *</label>
                        <input type="date" class="form-control bg-white" name="fecha_demanda" id="fecha_demanda" value="{{ old('fecha_demanda') }}" max="9999-12-31" min="1970-01-01" required>
                        <span class="text-danger">{{ $errors->first('fecha_demanda')}}</span>
                        <div class="invalid-feedback fw-regular" data-default="Dato obligatorio o fecha inválida"></div>
                    </div>
                    <div class="form-group col-md-6 mb-2">
                        <label for="numero_expediente">Número de expediente del juzgado *</label>
                        <input type="text" class="form-control bg-white" name="numero_expediente" placeholder="Escriba el número del expediente" value="{{ old('numero_expediente') }}" required maxlength="255">
                        <span class="text-danger">{{ $errors->first('numero_expediente')}}</span>
                        <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                    </div>
                    <div class="form-group col-md-6 mb-2">
                        <label for="nombre_juzgado">Nombre del juzgado *</label>
                        <input type="text" class="form-control bg-white" name="nombre_juzgado" placeholder="Escriba el nombre del juzgado"  value="{{ old('nombre_juzgado') }}" required maxlength="255">
                        <span class="text-danger">{{ $errors->first('nombre_juzgado')}}</span>
                        <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                    </div>
                    <div class="form-group col-md-6 mb-2">
                        <label for="nombre_juez">Nombre del juez *</label>
                        <input type="text" class="form-control bg-white" name="nombre_juez" placeholder="Escriba el nombre del juez"  value="{{ old('nombre_juez') }}" required maxlength="255"
                        >
                        <span class="text-danger">{{ $errors->first('nombre_juez')}}</span>
                        <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                    </div>
                    <div class="form-group col-md-6 mb-2">
                        @include('components.carga-archivos', ['codigo' => 'caratula_expediente','nombre'=>'Carátula del expediente','required'=>true])
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4 justify-content-end">
            <div class="form-group col-md-3 mb-2 mb-md-0">
                <a href="{{route('casos.getResumen',['caso_id' => $caso->id])}}" class="btn btn-accion-detalle btn-default w-100 fw-semibold">Cancelar</a>
            </div>
            <div class="form-group col-md-3 mb-2 mb-md-0">
                <button type="submit" form="form_registro_caso" class="btn btn-accion-detalle bg-estatus-demanda w-100 fw-semibold">Guardar</button>
            </div>
        </div>
    </form>
</div>

@endsection
