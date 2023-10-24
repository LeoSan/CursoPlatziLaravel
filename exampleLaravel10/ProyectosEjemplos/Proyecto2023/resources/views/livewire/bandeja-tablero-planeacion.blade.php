<div>
    <div class="row d-flex justify-content-start align-items-end pt-3 pb-4">
        <h5 class="fw-semibold fs-6">
            Filtrar
        </h5>
        @include('livewire.partials.filtros_planeacion_dashboard')
    </div>

    <h4 class="pb-3 fs-5 text-tertiary">
        @if($filtrado)
            Mostrando resultados <b class="fw-semibold">filtrados</b>
        @else
            Mostrando todos los resultados
        @endif
    </h4>

    <div class="row mb-5">
        <h5 class="fw-semibold fs-6">
            Avance
        </h5>
        <div class="mb-4">
            @php
                $completadas = (@$totales->whereIn('estatus.codigo', ['finalizada' ,'incumplimiento', 'incumplimiento_sin_expediente'])->count());
                $porcentaje = $completadas && $totales->count() ? $completadas * 100 / $totales->count() : 0;
                $minimoMovil = 25;
            @endphp
            <div class="simple-chart pt-3 pt-md-2 align-items-center w-100">
                <div class="d-flex align-items-center w-100 position-relative">
                    <div class="bar py-3 px-2 bg-default-gray rounded-1 w-100">
                        <div class="position-absolute top-0 end-0 mt-1 me-2 text-end">
                            <span class=" text-graylight fw-semibold font-small-size me-0 text-end">100%</span>
                            <div class="rounded-1 text-end text-graylight py-2 mt-3">
                                <h5 class="fs-5 m-0 p-0">{{ @$totales->count() }}</h5>
                                <p class="m-0 p-0 font-small-size">
                                    Total
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="bar py-3 @if($porcentaje < $minimoMovil) px-1 @else px-2 @endif bg-tertiary rounded-1 position-absolute right-0 top-0 h-100"
                         style="width: {{ $porcentaje }}%">
                        <div class="position-absolute top-0 end-0 mt-1  @if($porcentaje < $minimoMovil) text-start start-0 @else text-end end-0 @endif ">
                            <span class=" fw-semibold font-small-size @if($porcentaje < $minimoMovil) text-tertiary position-absolute start-100 text-start ms-2 mt-1 @else text-white text-end me-2 @endif">{{ number_format($porcentaje, 1) }}%</span>
                            <div class="bg-default-gray rounded-1 px-2 py-2 mt-3 " style="min-width: 85px; @if($porcentaje < $minimoMovil) width: 85px !important; margin-top: 40px !important; @else @endif">
                                <h5 class="fs-5 m-0 p-0 text-tertiary">{{ $completadas }}</h5>
                                <p class="m-0 p-0 text-graylight font-small-size">
                                    Auditorías <br> atendidas
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="py-3"></div>

        <div class="d-flex flex-row justify-content-between font-regular-size pt-5 w-100">
            <div class="">
                <i class="fas fa-square mb-1 text-tertiary"></i>
                <span class=" text-graylight">Auditorías atendidas:</span>
                <span class="fs-5 text-graylight fw-normal">
                    {{ @$totales->whereIn('estatus.codigo', ['finalizada', 'incumplimiento', 'incumplimiento_sin_expediente'])->count() }}
                </span>
            </div>
            <div class="">
                <i class="far fa-square mb-1 text-gray"></i>
                <span class=" text-graylight">Auditorías pendientes:</span>
                <span class="fs-5 text-graylight fw-normal">
                    {{ @$totales->count() - @$totales->where('estatus.codigo', 'finalizada')->count() - @$totales->whereIn('estatus.codigo', ['incumplimiento', 'incumplimiento_sin_expediente'])->count() }}
                </span>
            </div>
            <div class="">
                <i class="fas fa-square mb-1 text-graylight"></i>
                <span class=" text-graylight">Total en la planeación:</span>
                <span class="fs-5 text-graylight fw-normal">
                    {{ @$totales->count() }}
                </span>
            </div>
        </div>

    </div>



    <div class="row mb-4">
        <h5 class="fw-semibold fs-6">
            Resumen de auditorías atendidas ({{ @$totales->whereIn('estatus.codigo', ['finalizada' ,'incumplimiento', 'incumplimiento_sin_expediente'])->count() }})
        </h5>
        <div class="mb-3">
            @php
                $atentidas = (@$totales->whereIn('estatus.codigo', ['finalizada' ,'incumplimiento', 'incumplimiento_sin_expediente'])->count());
                $finalizadas = (@$totales->whereIn('estatus.codigo', ['finalizada'])->count());
                $finalizadasPorcentaje = $finalizadas && $totales->count() ? $finalizadas * 100 / $atentidas : 0;

                $incumplimiento = (@$totales->whereIn('estatus.codigo', ['incumplimiento'])->count());
                $incumplimientoPorcentaje = $incumplimiento && $totales->count() ? $incumplimiento * 100 / $atentidas : 0;

                $incumplimientosin = (@$totales->whereIn('estatus.codigo', ['incumplimiento_sin_expediente'])->count());
                $incumplimientosinPorcentaje = $incumplimientosin && $totales->count() ? $incumplimientosin * 100 / $atentidas : 0;
            @endphp
            <div class="simple-chart pt-3 pt-md-2 align-items-center w-100">
                <div class="d-flex align-items-center w-100 position-relative">
                    <div class="bar bg-default-gray rounded-1 w-100 d-flex">
                        <div class="position-absolute top-0 end-0 me-2 z-1 text-end pt-1">
                            <span class=" text-graylight fw-semibold font-small-size me-0 opacity-50 text-end">100%</span>
                        </div>


                        <div class="bg-estatus-finalizado position-relative z-2 rounded-1 h-100" style="width: {{ $finalizadasPorcentaje }}%">
                            <div class="top-0 end-0 py-1 text-end end-0 ">
                                <span class=" fw-semibold font-small-size text-white text-end me-2">{{ number_format($finalizadasPorcentaje, 1) }}%</span>
                            </div>
                        </div>
                        <div class="bg-estatus-incumplimiento position-relative z-2 rounded-1 h-100" style="width: {{ $incumplimientoPorcentaje }}%">
                            <div class="top-0 end-0 py-1 text-end end-0 ">
                                <span class=" fw-semibold font-small-size text-white text-end me-2">{{ number_format($incumplimientoPorcentaje, 1) }}%</span>
                            </div>
                        </div>
                        <div class="bg-estatus-incumplimiento_sin_expediente position-relative z-2 rounded-1 h-100" style="width: {{ $incumplimientosinPorcentaje }}%">
                            <div class="top-0 end-0 py-1 text-end end-0 ">
                                <span class=" fw-semibold font-small-size text-white text-end me-2">{{ number_format($incumplimientosinPorcentaje, 1) }}%</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-row justify-content-between font-regular-size pt-0 w-100">
            <div class="">
                <i class="fas fa-square mb-1 text-estatus-finalizada"></i>
                <span class=" text-graylight">Finalizadas:</span>
                <span class="fs-5 text-graylight fw-normal">
                    {{ @$finalizadas }}
                </span>
            </div>
            <div class="">
                <i class="fas fa-square mb-1 text-estatus-incumplimiento"></i>
                <span class=" text-graylight">Incumplimientos:</span>
                <span class="fs-5 text-graylight fw-normal">
                    {{ @$incumplimiento }}
                </span>
            </div>
            <div class="">
                <i class="fas fa-square mb-1 text-estatus-incumplimiento_sin_expediente"></i>
                <span class=" text-graylight">Incumplimientos sin expediente:</span>
                <span class="fs-5 text-graylight fw-normal">
                    {{ @$incumplimientosin }}
                </span>
            </div>
        </div>

    </div>

    <div class="py-2">
    </div>


    <div class="row">
        <div class="col-12">
            <div class="mt-2 d-none d-md-inline">
                <div class="table-responsive">
                    <table class="table text-center tabla-pgr font-small-size">
                        <thead>
                        <tr>

                            <th class="ps-3 align-middle">Número de auditoría</th>
                            <th class="align-middle">Regional</th>
                            <th class="align-middle">Tipo de inspección</th>
                            <th class="align-middle">Actividad económica</th>
                            <th class="align-middle">Mes</th>
                            <th class="align-middle">Auditor responsable</th>
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
                                    {{ $auditoria->grupo?->region?->nombre ?? 'Sin información' }}
                                </td>
                                <td class="bg-white border-0">
                                    {{ $auditoria->grupo?->inspeccion?->nombre }}
                                </td>
                                <td class="bg-white border-0">
                                    {{ $auditoria->grupo?->actividadeconomica?->nombre }}
                                </td>
                                <td class="bg-white border-0 text-capitalize">
                                    @php
                                        $fecha = \Carbon\Carbon::parse("2023-$auditoria->mes-01");
                                        $mesTraducido = $fecha->translatedFormat('F');
                                    @endphp
                                    {{ $mesTraducido }}
                                </td>
                                <td class="bg-white border-0">
                                    {{ $auditoria->asignado?->complete_name ?? 'Sin información' }}
                                </td>
                                <td class="bg-white border-0">
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
                                <span class="fw-bold">Región:</span>
                                {{ $auditoria->grupo?->region?->nombre }}
                            </p>
                            <p class="fw-normal mb-0 fs-movil text-graydark">
                                <span class="fw-bold">Tipo de inspección:</span>
                                {{ $auditoria->grupo?->inspeccion?->nombre }}
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

