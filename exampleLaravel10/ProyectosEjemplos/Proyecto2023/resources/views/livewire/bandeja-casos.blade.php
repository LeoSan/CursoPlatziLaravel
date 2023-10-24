<div>
    <div class="row">
        <div class="border-top mb-2"></div>
        <label class="form-label font-regular-size mb-1" for="busqueda">Buscar</label>
        <div class="col-md-12 py-1 d-flex justify-content-end text-end align-items-center">
            <input type="text" class="form-control busqueda_casos font-regular-size bg-white input-regular-height border-filter" wire:model="busqueda" value="{{$busqueda}}" placeholder="Busque por razón social o expediente">
            @if(isset($busqueda) && strlen($busqueda)>2)
                <button class="btn btn-default busqueda_casos ms-2 input-regular-height" wire:click="removeFiltro('busqueda')">Cancelar</button>
            @endif
        </div>
    </div>
    <div class="row mt-2 justify-content-between mb-0">
        <div class="">
            <div class="py-2">
                <label class="form-label font-regular-size mb-1">Filtrar</label>
                @include('livewire.partials.filtros_caso')
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-lg-12 col-md-12 col-sm-12 text-end mt-2 mt-md-0">
            @can('exportar_casos')
                <button type="button" class="btn btn-link input-regular-height" wire:click="export"><strong class="text-gray">Exportar CSV <i
                        class="fa fa-download"></i></strong></button>
            @endcan
        </div>
    </div>
    <div class="row justify-content-between">
        <div class="col-12 table-responsive mt-2 d-none d-md-inline">
            <table class="table tabla-pgr">
                <thead class="mb-2">
                    <tr class="text-center">
                        <th class="ps-3 align-middle">Expediente SETRASS</th>
                        <th class="align-middle">Expediente PGR</th>
                        <th class="align-middle">Razón social</th>
                        <th class="align-middle">Fecha de notificación</th>
                        <th class="align-middle">Fecha de ingreso <span class="text-nowrap">a DNPJ</span></th>
                        <th class="align-middle">Monto a cobrar</th>
                        <th class="align-middle">Monto cobrado</th>
                        <th class="align-middle">Monto cobrado <span class="text-nowrap">con intereses</span></th>
                        <th class="align-middle text-nowrap">Asignado a</th>
                        <th class="pe-3 align-middle">Estatus</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($casos as $caso)
                    <tr class="">
                        <td class="bg-white border-0">
                            <a href="{{route('casos.informacion',$caso->id)}}" class="text-graydark">
                                <strong>
                                    {{$caso->numero_expediente??"Pendiente"}}
                                </strong>
                            </a>
                        </td>
                        <td class="bg-white fw-semibold border-0">
                            {{$caso->numero_expediente_pgr??"Pendiente"}}
                        </td>
                        <td class="bg-white border-0">
                            {{$caso->empresa->razon_social??''}}
                        </td>
                        <td class="bg-white border-0">
                            {{$caso->fecha_notificacion ? $caso->fecha_notificacion->format('d/m/Y') : ''}}
                        </td>
                        <td class="bg-white border-0">
                            {{$caso->fecha_recepcion_pgr ? $caso->fecha_recepcion_pgr->format('d/m/Y') : ''}}
                        </td>
                        <td class="bg-white border-0">
                            L {{lempiras($caso->total_multa)}}</td>
                        <td class="bg-white border-0">
                            L {{lempiras($caso->total_cobrado)}}</td>
                        <td class="bg-white border-0">
                            L {{lempiras($caso->total_cobrado_intereses)}}</td>
                        <td class="bg-white border-0">
                            {{$caso->asignado ? $caso->asignado->nombre_completo : 'No asignado'}}
                        </td>
                        <td class="bg-white border-0">
                            @include('partials.estatus', ['estatus' => $caso->estatus])

                            @if($caso->estatus->codigo=='convenio_pago' && $caso->has_pagos_vencidos)
                                <div class="w-auto text-start pendiente-box">
                                    @include('partials.pago-pendiente')
                                </div>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="bg-white text-center border-0">
                            Sin resultados encontrados
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="col-12 mt-3 d-inline d-md-none">
            @forelse($casos as $caso)
                <div class="card my-2 card-bandeja-usuarios">
                    <div class="card-body pt-2">
                        <div class="row d-flex justify-content-end ">
                            <div class="col-auto d-flex justify-content-end fs-movil text-graydark">
                                @include('partials.estatus', ['estatus' => $caso->estatus])
                            </div>
                            @if($caso->convenio?->pendiente)
                                <div class="col-auto">
                                    @include('partials.pago-pendiente')
                                </div>
                            @endif
                        </div>
                        <p class="mb-0 text-graydark fs-movil">{{$caso->empresa->razon_social??''}}</p>
                        <p class="fw-normal mb-0 fs-movil text-graydark"><span class="fw-bold">Expediente SETRASS:</span> {{$caso->numero_expediente??"Pendiente"}}</p>
                        <p class="fw-normal mb-0 fs-movil text-graydark"><span class="fw-bold">Expediente PGR:</span> {{$caso->numero_expediente_pgr??"Pendiente"}}</p>
                        <p class="fw-normal mb-0 fs-movil text-graydark"><span class="fw-bold">Monto a cobrar:</span> L {{lempiras($caso->total_multa)}}</p>
                        <p class="fw-normal mb-0 fs-movil text-graydark"><span class="fw-bold">Monto cobrado:</span> L {{lempiras($caso->total_cobrado)}}</p>
                        <p class="text-end fs-movil">
                            <a href="{{route('casos.informacion',$caso->id)}}" class="text-estatus-{{ $caso->estatus->codigo }} fw-bold">
                            <strong>
                                Ver
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" height="0.5em" class="mt-n4" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z" fill="currentColor"/></svg>
                            </strong>
                            </a>
                        </p>
                    </div>
                </div>
            @empty
                <p class="mb-0 fs-movil text-graydark">Sin resultados encontrados</p>
            @endforelse
        </div>
        <div class="text-sm-center">
            @include('livewire.partials.entries')
        </div>
        <div class="row justify-content-center mt-2 mt-md-0">
            <div class="col-md-12 d-flex justify-content-center">{{$casos->links()}}</div>
            <div class="col-auto text-small">
                <strong>{{ number_format($casos->firstItem()) }}</strong> <span>al</span>
                <strong>{{ number_format($casos->lastItem()) }}</strong> <span>de</span>
                <strong>{{ number_format($casos->total()) }}</strong> <span>registros</span>
            </div>
        </div>
    </div>
</div>
