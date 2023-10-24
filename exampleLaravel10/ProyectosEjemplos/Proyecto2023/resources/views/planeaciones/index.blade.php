@extends('layouts.app')
@section('content')

    <nav aria-label="breadcrumb" class="px-2 py-1">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-small-size"><a href="#">Auditorías</a></li>
            <li class="breadcrumb-item font-small-size active" aria-current="page">Planeaciones anuales de auditorías</li>
        </ol>
    </nav>

    <div class="px-2 pb-3 pt-0">
        <h5 class="fw-semibold">
            <div class="">
                Planeación anual de auditorías
            </div>
        </h5>
    </div>

    <div class="px-2 pb-4 pt-0">
        <div class="d-flex justify-content-end">
            <a href="{{ route('planeaciones.crear-planeacion') }}" class="d-flex gap-2 btn btn btn-secondary input-regular-height">
                <span>Nuevo plan anual</span>
                <i class="fas fa-plus-circle ms-1"></i>
            </a>
        </div>

        <div class="mt-1">
            <div class="row justify-content-between">
                <div class="col-12 table-responsive mt-2">
                    <table class="table text-center tabla-pgr">
                        <thead class="mb-2">
                        <tr class="">
                            <th class="text-start ps-4">Plan</th>
                            <th class="text-start">Planeadas</th>
                            <th class="text-start">Atendidas</th>
                            <th class="text-start">Pendientes</th>

                            <th class="text-start " colspan="2">Estatus</th>

                        </tr>
                        </thead>
                        <tbody>
                        @forelse($planeaciones as $planeacion)
                            <tr>
                                <td class="bg-white text-start border-0 align-middle ps-4">
                                    @if($planeacion->estatus?->codigo === 'planeacion')
                                        <a href="{{ route('planeaciones.editar-planeacion', $planeacion->id) }}" class="text-graydark">
                                            <strong>
                                                Plan anual de auditorías {{ $planeacion->anio }}
                                            </strong>
                                        </a>
                                    @else
                                        <a href="{{ route('planeaciones.planeacion', $planeacion->id) }}" class="text-graydark">
                                            <strong>
                                                Plan anual de auditorías {{ $planeacion->anio }}
                                            </strong>
                                        </a>
                                    @endif
                                </td>

                                <td class="bg-white text-start align-middle border-0">
                                    {{ $planeacion->auditorias?->sum('total_auditorias') }}
                                </td>
                                <td class="bg-white text-start align-middle border-0">
                                    {{ $planeacion->ejecuciones?->whereIn('estatus.codigo', ['finalizada', 'incumplimiento', 'incumplimiento_sin_expediente'])->count() }}
                                </td>
                                <td class="bg-white text-start align-middle border-0">
                                    {{ $planeacion->ejecuciones?->whereNotIn('estatus.codigo', ['finalizada', 'incumplimiento', 'incumplimiento_sin_expediente'])->count() }}
                                </td>

                                <td class="bg-white text-start border-0 align-middle" @if($planeacion->estatus?->codigo !== 'planeacion' && $planeacion->estatus?->codigo !== 'registrado') colspan="2" @endif>
                                    @if($planeacion->estatus)
                                        @include('partials.estatus-planeacion', ['estatus' => $planeacion->estatus])
                                    @else
                                        Sin estatus
                                    @endif
                                </td>

                                @if($planeacion->estatus?->codigo === 'planeacion' || $planeacion->estatus?->codigo === 'registrado')
                                <td class="bg-white text-start border-0 align-middle">
                                    <div class="d-flex gap-2 fs-6">
                                        <a href="{{ route('planeaciones.editar-planeacion', $planeacion->id) }}" class="item">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        @if($planeacion->estatus?->codigo === 'registrado')
                                            <a href="#!" class="item item-delete text-danger eliminar-registro" data-item="{{ $planeacion->id }}" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </a>
                                            <form action="{{ route('planeaciones.planeacion.delete') }}" method="post" id="form_delete_registro_{{ $planeacion->id }}">
                                                @csrf
                                                <input type="hidden" name="planeacion" value="{{ $planeacion->id }}">
                                            </form>
                                        @endif
                                    </div>
                                </td>
                                @endif
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

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white px-3 py-2">
                    <h5 class="modal-title fs-6 fw-semibold" id="deleteModalLabel">Eliminar planeacion</h5>
                    <button type="button" class="text-white" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    ¿Realmente desea eliminar este registro de planeación?
                </div>
                <div class="modal-footer pt-0 pb-2 border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="form_delete_registro_" id="confirmar_eliminar" class="btn btn-danger">Borrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
