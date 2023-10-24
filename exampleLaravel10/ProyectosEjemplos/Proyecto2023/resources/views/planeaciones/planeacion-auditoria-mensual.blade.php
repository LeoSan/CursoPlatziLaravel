@extends('layouts.app')
@section('content')

    <nav aria-label="breadcrumb" class="py-1">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-small-size"><a class="text-graylight" href="#">Auditorías</a></li>
            <li class="breadcrumb-item font-small-size"><a class="text-graylight" href="{{ route('planeaciones') }}">Planeaciones anuales de auditorías</a></li>
            @if($planeacion->estatus->codigo === 'planeacion')
                <li class="breadcrumb-item font-small-size"><a class="text-graylight" href="{{ route('planeaciones.editar-planeacion', ['id' => $planeacion->id]) }}">Planeación anual {{ @$planeacion->anio }}</a></li>
            @else
                <li class="breadcrumb-item font-small-size"><a class="text-graylight" href="{{ route('planeaciones.planeacion', ['id' => $planeacion->id]) }}">Planeación anual {{ @$planeacion->anio }}</a></li>
            @endif
            <li class="breadcrumb-item font-small-size active" aria-current="page">Auditorías</li>
        </ol>
    </nav>

    <form action="{{ route('planeaciones.planeacion.auditoria.mensual.create') }}" id="plan_mensual_auditorias_form" method="post" class="d-block pb-4">
        @csrf
        <input type="hidden" name="auditoria" value="{{ $auditoria->id }}">
        <div>
            <h5 class="fw-semibold d-flex gap-3 align-items-end">
                <div class="">
                    Plan anual de auditorías {{ $planeacion->anio }}
                </div>
            </h5>
        </div>

        @include('planeaciones.partials.wizard', ['step' => 'auditorias'])

        <div class="bg-white px-4 py-4 my-4">

            <div class="d-flex w-100 justify-content-start">
                <h4 class="fw-semibold fs-5">Plan mensual de grupo de auditorías</h4>
            </div>

            <div class="row">
                <div class="form-group col-12 col-md-4 mb-3">
                    <label class="form-label" for="departamento_id">Departamento</label>
                    <p class="m-0">{{ $auditoria->departamento?->nombre }}</p>
                </div>

                <div class="form-group col-12 col-md-4 mb-3">
                    <label class="form-label" for="municipio_id">Municipio</label>
                    <p class="m-0">{{ $auditoria->municipio?->nombre }}</p>
                </div>

                <div class="form-group col-12 col-md-4 mb-3">
                    <label class="form-label" for="municipio_id">Región</label>
                    <p class="m-0">{{ $auditoria->region?->nombre }}</p>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-12 col-md-4 mb-3">
                    <label class="form-label" for="tipo_inspeccion_id">Tipo de inspección</label>
                    <p class="m-0">{{ $auditoria->inspeccion?->nombre }}</p>
                </div>

                <div class="form-group col-12 col-md-4 mb-3">
                    <label class="form-label" for="cafta">CAFTA</label>
                    <p class="m-0">{{ $auditoria->cafta }}</p>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-12 col-md-4 mb-3">
                    <label class="form-label" for="actividad_economica_id">Actividad económica</label>
                    <p class="m-0">{{ $auditoria->actividadeconomica?->nombre }}</p>
                </div>

                <div class="form-group col-12 col-md-4 mb-3">
                    <label class="form-label" for="auditor_responsable_id">Auditor responsable</label>
                    <p class="m-0">{{ $auditoria->auditor?->complete_name }}</p>
                </div>
            </div>


            <div class="d-flex w-100 justify-content-start pt-3 pb-2">
                <h4 class="fw-semibold fs-6">Número de auditorías por mes</h4>
            </div>

            <div class="row">

                @for ($i = 1; $i <= 12; $i++)
                    <div class="form-group col-6 col-md-4 col-lg-3 mb-3">
                        <div class="d-flex align-items-end justify-content-between py-2 px-3 rounded-1 bg-default-gray">
                            @php
                                $fecha = \Carbon\Carbon::parse("2023-$i-01");
                                $mesTraducido = $fecha->translatedFormat('F');
                            @endphp
                            <label class="form-label m-0 font-regular-size pb-2 text-capitalize text-secondary" for="no_auditorias_{{ $i }}">{{ $mesTraducido }}</label>
                            @php($mes = $auditoria->meses?->where('mes', $i)->first())
                            <input type="number" min="0" max="100" class="form-control font-regular-size auditorias-mensuales text-end pe-1 bg-white" style="width: 40%; max-width: 60%" id="no_auditorias_{{ $i }}" name="no_auditorias[]" value="{{ $mes ? $mes->num_auditorias : 0 }}" required />
                        </div>
                    </div>
                @endfor

            </div>

            <div class="d-flex w-100 justify-content-end pt-1 pb-0">
                <h4 class="fw-semibold bg-default-gray w-50 justify-content-end text-end py-3 rounded-1 px-3 fs-6 m-0">
                    <small>Total de auditorías:</small>
                    <span id="total_auditorias">{{ $auditoria->total_auditorias ? $auditoria->total_auditorias : 0 }}</span>
                    <input type="hidden" name="total_auditorias" id="total_auditorias_input" value="{{ $auditoria->total_auditorias ? $auditoria->total_auditorias : 0 }}">
                </h4>
            </div>

        </div>

        <div class="d-flex justify-content-between my-4">
            <a href="{{ route('planeaciones.planeacion.auditoria.editar', $auditoria->id) }}" class="btn btn-default input-regular-height align-items-center d-flex gap-2">
                <i class="fas fa-arrow-circle-left"></i>
                <span>Regresar</span>
            </a>

            <button type="submit" class="btn btn-tertiary input-regular-height align-items-center d-flex gap-2">
                <span>Guardar</span>
                <i class="fas fa-circle-check"></i>
            </button>
        </div>

    </form>


    <div class="modal fade" id="vacioModal" tabindex="-1" aria-labelledby="vacioModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white px-3 py-2">
                    <h5 class="modal-title fs-6 fw-semibold" id="vacioModalLabel">Registrar plan mensual</h5>
                    <button type="button" class="text-white" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="p-0 m-0">
                        Es necesario planear al menos una auditoría.
                    </p>
                </div>
                <div class="modal-footer pt-0 pb-2 border-0">
                    <button type="button" class="btn btn-secondary py-2 m-0 mb-1 rounded-1" data-bs-dismiss="modal">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
