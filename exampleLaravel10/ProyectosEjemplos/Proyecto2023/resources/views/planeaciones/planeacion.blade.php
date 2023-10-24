@extends('layouts.app')
@section('content')

    <nav aria-label="breadcrumb" class="py-1">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-small-size"><a class="text-graylight" href="#">Auditorías</a></li>
            <li class="breadcrumb-item font-small-size"><a class="text-graylight" href="{{ route('planeaciones') }}">Planeaciones anuales de auditorías</a></li>
            <li class="breadcrumb-item font-small-size active" aria-current="page">Planeación anual {{ @$planeacion->anio }}</li>
        </ol>
    </nav>

    <div class="pb-4">
        <div>
            <h5 class="fw-semibold d-flex gap-3 align-items-end">
                <div class="">
                    Plan anual de auditorías {{ $planeacion->anio }}
                </div>
                <div class="">
                    |
                </div>
                <small class="pt-1">
                    @if($planeacion->estatus)
                        @include('partials.estatus-planeacion', ['estatus' => $planeacion->estatus])
                    @else
                        <span class="text-graylight fw-light">Sin estatus</span>
                    @endif
                </small>
            </h5>
        </div>

        <div class="mt-4">

            <div class="d-flex align-items-center justify-content-between">
                <nav class="">
                    <div class="nav nav-tabs nav-tabs-usuario" id="nav-tab" role="tablist">
                        <button
                            class="nav-link nav-usuarios text-start p-0 me-5 mb-2 fw-semibold active"
                            id="nav-resumen-tab"
                            data-bs-toggle="tab" data-bs-target="#nav-resumen" type="button" role="tab"
                            aria-controls="nav-resumen" aria-selected="true">
                            Resumen
                        </button>

                        <button
                            class="nav-link nav-usuarios text-start p-0 me-5 mb-2 fw-semibold"
                            id="nav-generales-tab"
                            data-bs-toggle="tab" data-bs-target="#nav-generales" type="button" role="tab"
                            aria-controls="nav-generales" aria-selected="false">
                            Datos generales
                        </button>

                        <button
                            class="nav-link nav-usuarios text-start p-0 me-5 mb-2 fw-semibold"
                            id="nav-auditorias-tab"
                            data-bs-toggle="tab" data-bs-target="#nav-auditorias" type="button" role="tab"
                            aria-controls="nav-auditorias" aria-selected="false">
                            Grupo de auditorías
                        </button>
                    </div>
                </nav>
                <div class="back">
                    <a href="{{ route('planeaciones') }}" class="d-flex text-decoration-none font-small-size fw-semibold align-items-center text-gray gap-2">
                        <i class="fas fa-arrow-left"></i>
                        <span class="text-decoration-underline">
                            Volver a planeación <span class="d-none d-md-inline">anual de auditorías</span>
                        </span>
                    </a>
                </div>
            </div>


            <div class="tab-content pt-1">

                <div class="tab-pane active" id="nav-resumen"
                     role="tabpanel" aria-labelledby="nav-resumen-tab">


                    <div class="">
                        <livewire:bandeja-tablero-planeacion anio="{{ $planeacion->anio }}"/>
                    </div>
                </div>

                <div class="tab-pane fade pt-3" id="nav-generales" role="tabpanel" aria-labelledby="nav-generales-tab">
                    <div class="d-flex flex-column gap-3">
                        <div class="item">
                            <h5 class="fw-semibold fs-6">
                                Objetivo
                            </h5>
                            <div class="mb-4 font-regular-size">
                                {!! $planeacion->objetivo !!}
                            </div>
                        </div>
                        <div class="item">
                            <h5 class="fw-semibold fs-6">
                                Alcance
                            </h5>
                            <div class="mb-4 font-regular-size">
                                {!! $planeacion->alcance !!}
                            </div>
                        </div>
                        <div class="item">
                            <h5 class="fw-semibold fs-6">
                                Criterios
                            </h5>
                            <div class="mb-4 font-regular-size">
                                {!! $planeacion->criterio !!}
                            </div>
                        </div>
                        <div class="item">
                            <h5 class="fw-semibold fs-6">
                                Recursos
                            </h5>
                            <div class="mb-4 font-regular-size">
                                {!! $planeacion->recursos !!}
                            </div>
                        </div>
                        <div class="item">
                            <h5 class="fw-semibold fs-6 mb-2">
                                Planeación anual de auditorías
                            </h5>
                            <div class="mb-4 font-regular-size row">
                                <div class="col-12 col-md-6 col-lg-4">
                                    @include('components.carga-archivos',['codigo'=>'plan_anual_auditorias','nombre'=>'Descarga documento', 'entidad' => $planeacion, 'eliminable'=>false])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="nav-auditorias" role="tabpanel" aria-labelledby="nav-auditorias-tab">

                    <div class="table-responsive mt-2">
                        <table class="table text-center tabla-pgr">
                            <thead class="mb-2">
                            <tr class="">
                                <th class="text-start align-middle ps-4">Departamento</th>
                                <th class="text-start align-middle">Municipio</th>
                                <th class="text-start align-middle">Regional</th>
                                <th class="text-start align-middle">Tipo de inspección</th>
                                <th class="text-start align-middle">Actividad económica</th>
                                <th class="text-start align-middle">CAFTA</th>
                                <th class="text-start align-middle">Auditor responsable</th>
                                <th class="text-start align-middle">Total auditorías</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($planeacion->auditorias as $auditoria)
                                <tr>
                                    <td class="bg-white text-start border-0 align-middle ps-4">
                                        {{ $auditoria->departamento->nombre }}
                                    </td>

                                    <td class="bg-white text-start align-middle border-0">
                                        {{ $auditoria->municipio->nombre }}
                                    </td>

                                    <td class="bg-white text-start align-middle border-0">
                                        {{ $auditoria->region->nombre }}
                                    </td>

                                    <td class="bg-white text-start align-middle border-0">
                                        {{ $auditoria->inspeccion->nombre }}
                                    </td>

                                    <td class="bg-white text-start align-middle border-0">
                                        {{ $auditoria->actividadeconomica->nombre }}
                                    </td>

                                    <td class="bg-white text-start align-middle border-0">
                                        {{ $auditoria->cafta }}
                                    </td>

                                    <td class="bg-white text-start align-middle border-0">
                                        {{ $auditoria->auditor->complete_name }}
                                    </td>

                                    <td class="bg-white text-center align-middle border-0 pe-4">
                                        <a class="fw-semibold" data-bs-toggle="modal"
                                           href="#" role="button" data-bs-target="#auditoriaMeses{{ $auditoria->id }}">
                                            {{ $auditoria->total_auditorias }}
                                        </a>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="bg-white border-0">
                                        Sin resultados encontrados
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>

        </div>

    </div>

    @foreach($planeacion->auditorias as $auditoria)
        <!-- Modal -->
        <div class="modal fade" id="auditoriaMeses{{ $auditoria->id }}" tabindex="-1" aria-labelledby="auditoriaMesesLabel{{ $auditoria->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header border-0 pb-2">
                        <h5 class="modal-title fw-semibold fs-6" id="auditoriaMesesLabel{{ $auditoria->id }}">Plan mensual</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body py-0">

                        <div class="table-responsive mt-2 d-none d-md-inline">
                            <table class="table text-center tabla-pgr mb-0">
                                <thead class="mb-2">
                                <tr class="">
                                    <th class="text-start align-middle ps-4">Mes</th>
                                    <th class="text-start align-middle">Número de auditorías</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($auditoria->meses->where('num_auditorias', '!=', 0) as $mes)
                                    <tr>
                                        <td class="bg-white text-start border-0 align-middle ps-4 text-capitalize">
                                            @php
                                                $fecha = \Carbon\Carbon::parse("2023-$mes->mes-01");
                                                $nombreMesEnEspanol = $fecha->translatedFormat('F');
                                            @endphp
                                            {{ $nombreMesEnEspanol }}
                                        </td>

                                        <td class="bg-white text-start align-middle border-0">
                                            {{ $mes->num_auditorias }}
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="bg-white border-0">
                                            Sin resultados encontrados
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="modal-footer border-0 pt-1">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection
