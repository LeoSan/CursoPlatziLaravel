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

    <div class="pb-4">
        <div class="d-flex flex-row justify-content-between">
            <h5 class="fw-semibold d-flex gap-3 align-items-end">
                <div class="">
                    Plan anual de auditorías {{ $planeacion->anio }}
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

        @include('planeaciones.partials.wizard', ['step' => 'auditorias'])

        <div class="bg-white px-4 py-3 my-4">

            <div class="d-flex w-100 justify-content-end">
                <a href="{{ route('planeaciones.planeacion.auditoria.crear', $planeacion->id) }}"
                   class="btn btn-secondary input-regular-height d-flex align-items-center gap-2">
                    <i class="fas fa-plus-circle"></i>
                    <span>Agregar grupo de auditorías</span>
                </a>
            </div>

            <div class="table-responsive mt-2">
                <table class="table text-center tabla-pgr mb-0">
                    <thead class="mb-2">
                    <tr class="">
                        <th class="text-start align-middle ps-3">Departamento</th>
                        <th class="text-start align-middle">Municipio</th>
                        <th class="text-start align-middle">Regional</th>
                        <th class="text-start align-middle">Tipo de inspección</th>
                        <th class="text-start align-middle">Actividad económica</th>
                        <th class="text-start align-middle">CAFTA</th>
                        <th class="text-start align-middle">Auditor responsable</th>
                        <th class="text-start align-middle">Total auditorías</th>
                        <th class="text-start align-middle pe-3">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($planeacion->auditorias as $auditoria)
                        <tr>
                            <td class="bg-white text-start border-0 align-middle ps-3">
                                {{ $auditoria->departamento?->nombre }}
                            </td>

                            <td class="bg-white text-start align-middle border-0">
                                {{ $auditoria->municipio?->nombre }}
                            </td>

                            <td class="bg-white text-start align-middle border-0">
                                {{ $auditoria->region?->nombre }}
                            </td>

                            <td class="bg-white text-start align-middle border-0">
                                {{ $auditoria->inspeccion?->nombre }}
                            </td>

                            <td class="bg-white text-start align-middle border-0">
                                {{ $auditoria->actividadeconomica?->nombre }}
                            </td>

                            <td class="bg-white text-start align-middle border-0">
                                {{ $auditoria->cafta }}
                            </td>

                            <td class="bg-white text-start align-middle border-0">
                                {{ $auditoria->auditor?->complete_name }}
                            </td>

                            <td class="bg-white text-start align-middle border-0">
                                @if($auditoria->total_auditorias)
                                    <a class="fw-semibold" data-bs-toggle="modal"
                                       href="#" role="button" data-bs-target="#auditoriaMeses{{ $auditoria->id }}">
                                        Ver plan mensual
                                    </a>
                                @else
                                    <em class="text-graylight italic">Sin registro mensual</em>
                                @endif
                            </td>

                            <td class="bg-white text-start border-0 align-middle pe-3">
                                <div class="d-flex gap-2 fs-6">
                                    <a href="{{ route('planeaciones.planeacion.auditoria.editar', $auditoria->id) }}"
                                       class="item">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="#!" class="item text-danger eliminar-registro"
                                       data-item="{{ $auditoria->id }}" data-bs-toggle="modal"
                                       data-bs-target="#deleteModal">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                    <form action="{{ route('planeaciones.planeacion.auditoria.delete') }}" method="post"
                                          id="form_delete_registro_{{ $auditoria->id }}">
                                        @csrf
                                        <input type="hidden" name="auditoria" value="{{ $auditoria->id }}">
                                    </form>
                                </div>
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

        <div class="d-flex justify-content-between my-4">
            <a href="{{ route('planeaciones.editar-planeacion', $planeacion->id) }}"
               class="btn btn-default input-regular-height align-items-center d-flex gap-2">
                <i class="fas fa-arrow-circle-left"></i>
                <span>Regresar</span>
            </a>


            <a href="#!" data-bs-toggle="modal"
               @if(@$planeacion->auditorias && count($planeacion->auditorias))
                   @if($planeacion->auditorias->whereIn('total_auditorias', [0, null])->count())
                       data-bs-target="#vacioGrupoModal"
                   @else
                        data-bs-target="#registroModal"
                   @endif
               @else
                   data-bs-target="#vacioModal"
               @endif
               class="btn btn-tertiary input-regular-height align-items-center d-flex gap-2">
                <span>Terminar registro</span>
                <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>

    </div>

    @foreach($planeacion->auditorias as $auditoria)
        <!-- Modal -->
        <div class="modal fade" id="auditoriaMeses{{ $auditoria->id }}" tabindex="-1"
             aria-labelledby="auditoriaMesesLabel{{ $auditoria->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header border-0 pb-2">
                        <h5 class="modal-title fw-semibold fs-6" id="auditoriaMesesLabel{{ $auditoria->id }}">Plan
                            mensual</h5>
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


    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white px-3 py-2">
                    <h5 class="modal-title fs-6 fw-semibold" id="deleteModalLabel">Eliminar auditoría</h5>
                    <button type="button" class="text-white" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    ¿Realmente desea eliminar este registro de auditoría?
                </div>
                <div class="modal-footer pt-0 pb-2 border-0">
                    <button type="button" class="btn btn-secondary py-2 rounded-1" data-bs-dismiss="modal">Cancelar
                    </button>
                    <button type="submit" form="form_delete_registro_" id="confirmar_eliminar"
                            class="btn btn-danger py-2 rounded-1">Borrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="registroModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-tertiary text-white px-3 py-2">
                    <h5 class="modal-title fs-6 fw-semibold" id="registroModalLabel">Registrar plan</h5>
                    <button type="button" class="text-white" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    @if($planeacion->anio === date('Y'))
                        <p>
                            Dado que está por registrar una
                            <b class="fw-semibold">Planeación anual de auditorías</b>
                            para el año corriente, éste comenzará su vigencia inmediatamente. ¿Desea continuar?
                        </p>
                        <p class="p-0 m-0">
                            Una vez guardado no será posible modificarlo.
                        </p>
                    @else
                        <p>
                            Sus cambios han sido guardados automáticamente, si termina el registro del Plan anual de auditoría {{ $planeacion->anio }} ya no será posible modificarlo.
                        </p>
                        <p class="p-0 m-0">
                            ¿Desea continuar?
                        </p>
                    @endif
                </div>
                <div class="modal-footer pt-0 pb-2 border-0">
                    <button type="button" class="btn btn-secondary py-2 rounded-1" data-bs-dismiss="modal">Cancelar
                    </button>
                    <a href="{{ route('planeaciones.planeacion.registro', $planeacion->id) }}"
                       class="btn btn-tertiary py-2 rounded-1">
                        Registrar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="vacioModal" tabindex="-1" aria-labelledby="vacioModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white px-3 py-2">
                    <h5 class="modal-title fs-6 fw-semibold" id="vacioModalLabel">Registro incompleto</h5>
                    <button type="button" class="text-white" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="p-0 m-0">
                        Es necesario registrar al menos un grupo de auditorías.
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

    <div class="modal fade" id="vacioGrupoModal" tabindex="-1" aria-labelledby="vacioGrupoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white px-3 py-2">
                    <h5 class="modal-title fs-6 fw-semibold" id="vacioGrupoModalLabel">Registro incompleto</h5>
                    <button type="button" class="text-white" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="p-0 m-0">
                        Hay registros de grupos de auditorías sin completar. Es necesario planear al menos una auditoría.
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
