<div>
    <div class="row">
        <label class="form-label font-regular-size mb-1" for="busqueda">Buscar</label>
        <div class="col-md-12 py-1 d-flex justify-content-end text-end align-items-center">
            <input type="text" class="form-control busqueda_casos font-regular-size bg-white input-regular-height border-filter" wire:model="busqueda"  placeholder="Busque por número de auditoría">
            @if(isset($busqueda) && strlen($busqueda)>2)
                <button class="btn btn-default busqueda_casos ms-2 input-regular-height" wire:click="removeFiltro('busqueda')">Cancelar</button>
            @endif
        </div>
    </div>    
    <div class="row d-flex justify-content-start align-items-end py-3">
        <label class="form-label font-regular-size mb-1">Filtrar</label>
        @include('livewire.partials.filtros_seguimiento_auditoria')
    </div>
    <div class="row">
        <div class="col-12">
            <div class="mt-2 d-none d-md-inline">
                <div class="table-responsive">
                    <table class="table text-center tabla-pgr">
                        <thead>
                        <tr>

                            <th class="ps-3 align-middle">Número de auditoría</th>
                            <th class="align-middle">Departamento</th>
                            <th class="align-middle">Municipio</th>
                            <th class="align-middle">Regional</th>
                            <th class="align-middle">Tipo de inspección</th>
                            <th class="align-middle">Actividad económica</th>
                            <th class="align-middle">CAFTA</th>
                            <th class="align-middle">Mes</th>
                            <th class="align-middle">Auditor responsable</th>
                            <th class="align-middle">Año</th>
                            <th class="align-middle">Estatus</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($auditorias as $auditoria)
                            <tr class="">
                                <td class="ps-3 bg-white border-0">
                                    <a href="{{route('auditorias.ejecucion.detalle', $auditoria->id )}}"
                                       class="text-dark">
                                        <strong>
                                            {{$auditoria->num_auditoria ??'Sin número asignado'}}
                                        </strong>
                                    </a>
                                </td>
                                <td class="bg-white border-0">
                                    {{ $auditoria->grupo?->departamento?->nombre ?? 'Sin información'}}
                                </td>
                                <td class="bg-white border-0">
                                    {{ $auditoria->grupo?->municipio?->nombre ?? 'Sin información'}}
                                </td>
                                <td class="bg-white border-0">
                                    {{ $auditoria->grupo?->region?->nombre ?? 'Sin información' }}
                                </td>
                                <td class="bg-white border-0">
                                    {{ $auditoria->grupo?->inspeccion?->nombre }}
                                </td>
                                <td class="bg-white border-0">
                                    {{ $auditoria->grupo?->actividadeconomica?->nombre }}
                                </td>
                                <td class="bg-white border-0">
                                    {{ $auditoria->grupo?->cafta ?? 'Sin información' }}
                                </td>
                                <td class="bg-white border-0 text-capitalize">
                                    @php
                                        $fecha = \Carbon\Carbon::parse("2023-$auditoria->mes-01");
                                        $mesTraducido = $fecha->translatedFormat('F');
                                    @endphp
                                    {{ $mesTraducido }}
                                </td>
                                <td class="bg-white border-0">
                                    @if(auth()->user()->can('reasignar_auditor'))
                                        <a href="#!" class="fw-semibold text-tertiary text-decoration-none" data-bs-toggle="modal"
                                           data-bs-target="#reasignarModal" data-ejecucion="{{ $auditoria->id }}" data-auditor="{{ $auditoria->asignado?->id }}" onclick="reasignacionEjecucion(this)">
                                        <span data-bs-toggle="tooltip" data-bs-placement="bottom" title="Reasignar auditor">
                                            <span class="text-decoration-underline">
                                                {{ $auditoria->asignado?->complete_name ?? 'Sin información' }}
                                            </span>
                                            <i class="fas fa-pencil"></i>
                                        </span>
                                        </a>
                                    @else
                                        {{ $auditoria->asignado?->complete_name ?? 'Sin información' }}
                                    @endif
                                </td>
                                <td class="bg-white border-0">
                                    <b>{{ $auditoria->grupo->planeacion->anio ?? 'Sin información' }}</b>
                                </td>

                                <td class="bg-white border-0 text-nowrap">
                                    @include('partials.estatus-planeacion', ['estatus' => $auditoria->estatus])
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="bg-white border-0">
                                    Sin resultados encontrados
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-12 mt-3 d-inline d-md-none">
                @forelse($auditorias as $auditoria)
                    <div class="card my-2 card-bandeja-usuarios">
                        <div class="card-body">
                            <div class="row d-flex justify-content-between">
                                <div class="col-auto">
                                    <p class="mb-0 text-graydark fs-movil">
                                        {{ $auditoria->num_auditoria ?? 'Sin número asignado' }}
                                    </p>
                                </div>
                                <div class="col-auto d-flex justify-content-end fs-movil text-graydark">
                                    @include('partials.estatus', ['estatus' => $auditoria->estatus])
                                </div>
                            </div>
                            <p class="fw-normal mb-0 fs-movil text-graydark">
                                <span class="fw-bold">Departamento:</span>
                                {{ $auditoria->grupo?->departamento?->nombre }}
                            </p>
                            <p class="fw-normal mb-0 fs-movil text-graydark">
                                <span class="fw-bold">Región:</span>
                                {{ $auditoria->grupo?->region?->nombre }}
                            </p>
                            <p class="fw-normal mb-0 fs-movil text-graydark">
                                <span class="fw-bold">Tipo de inspección:</span>
                                {{ $auditoria->grupo?->inspeccion?->nombre }}
                            </p>
                            <p class="fw-normal mb-0 fs-movil text-graydark">
                                <span class="fw-bold">CAFTA:</span>
                                {{ $auditoria->cafta }}
                            </p>
                            <p class="fw-normal mb-0 fs-movil text-graydark">
                                <span class="fw-bold">Auditor responsable:</span>
                                {{ $auditoria->auditor?->complete_name }}
                            </p>
                            <p class="fw-normal mb-0 fs-movil text-graydark">
                                <span class="fw-bold">Mes:</span>
                                {{ $auditoria->mes }}
                            </p>
                            <p class="text-end fs-movil">
                                <a href="{{route('auditorias.ejecucion.detalle',$auditoria)}}" class="text-estatus-{{ $auditoria->estatus->codigo }} fw-bold">
                                    <strong>
                                        Ver
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="0.5em"
                                             class="mt-n4" viewBox="0 0 512 512">
                                            <path
                                                d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"
                                                fill="currentColor"/>
                                        </svg>
                                    </strong>
                                </a>
                            </p>
                        </div>
                    </div>
                @empty
                    <p class="mb-0 fs-movil text-graydark">Sin resultados encontrados</p>
                @endforelse
            </div>
        </div>

        <div class="text-sm-center">
            @include('livewire.partials.entries')
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12 d-flex justify-content-center">{{$auditorias->links()}}</div>
            <div class="col-md-12 text-center text-small">
                <strong>{{ number_format($auditorias->firstItem()) }}</strong> <span>al</span>
                <strong>{{ number_format($auditorias->lastItem()) }}</strong> <span>de</span>
                <strong>{{ number_format($auditorias->total()) }}</strong> <span>registros</span>
            </div>
        </div>
    </div>
</div>

