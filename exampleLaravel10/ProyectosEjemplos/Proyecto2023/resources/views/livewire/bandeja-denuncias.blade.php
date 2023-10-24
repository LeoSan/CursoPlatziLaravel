<div>

    <div class="row">
        <div class="border-top mb-2"></div>
        <label class="form-label font-regular-size mb-1" for="busqueda">Buscar</label>
        <div class="col-md-12 py-1 d-flex justify-content-end text-end align-items-center">
            <input type="text" class="form-control busqueda_casos font-regular-size bg-white input-regular-height border-filter" wire:model="busqueda" value="{{$busqueda}}" placeholder="Busque por folio, expediente ATI, nombre del denunciante o correo electrónico">
            @if(isset($busqueda) && strlen($busqueda)>2)
                <button class="btn btn-default busqueda_casos ms-2 input-regular-height" wire:click="removeFiltro('busqueda')">Cancelar</button>
            @endif
        </div>
    </div>
    <div class="row mt-3 d-flex justify-content-start align-items-end">
        <label class="form-label font-regular-size mb-1">Filtrar</label>
        @include('livewire.partials.filtros_denuncia')
    </div>

    <div class="row">
        <div class="col-12">
            <div class="mt-2 d-none d-md-inline">
                <div class="table-responsive">
                    <table class="table text-center tabla-pgr">
                        <thead>
                        <tr>
                            @can('ver_completa_bandeja_denuncias')
                                @cannot('ver_limitada_bandeja_denuncias')
                                    <th class="ps-3 align-middle">Folio</th>
                                    <th class="align-middle">Expediente ATI</th>
                                    <th class="align-middle">Fecha de
                                        <div class="text-nowrap">la denuncia</div>
                                    </th>
                                    <th class="align-middle">Departamento / Municipio</th>
                                    <th class="align-middle">Origen</th>
                                    <th class="align-middle">Medio de recepción</th>

                                    <th class="align-middle">Nombre denunciante</th>
                                    <th class="align-middle">Correo electrónico</th>
                                    <th class="text-nowrap">Asignado a</th>
                                    <th class="pe-3 align-middle">Estatus</th>
                                @endcannot
                            @endcan
                            @can('ver_limitada_bandeja_denuncias')
                                @cannot('ver_completa_bandeja_denuncias')
                                    <th class="ps-3 align-middle">Expediente ATI</th>
                                    <th class="align-middle">Expediente DGIT</th>
                                    <th class="align-middle">Fecha de la denuncia</th>
                                    <th class="pe-3 align-middle">Estatus</th>
                                @endcannot
                            @endcan
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($denuncias as $denuncia)
                            <tr class="">
                                @can('ver_completa_bandeja_denuncias')
                                    @cannot('ver_limitada_bandeja_denuncias')
                                        <td class="ps-3 bg-white border-0 {{$denuncia->pintarBordeEstatus('admitida', 'solicitud_expediente', 'providencia')}} " >
                                            @include('denuncias.fragmentos.folio', ['denuncia' => $denuncia, 'estatus_providencia'=>$estatus_providencia])
                                        </td>
                                        <td class="bg-white border-0 {{$denuncia->pintarBordeEstatus('admitida', 'solicitud_expediente', 'providencia')}}">{{$denuncia->num_expediente??'Sin expediente asignado'}}</td>
                                        <td class="bg-white border-0 {{$denuncia->pintarBordeEstatus('admitida', 'solicitud_expediente', 'providencia')}}">{{$denuncia->created_at->format('d/m/Y')}}</td>
                                        <td class="bg-white border-0 {{$denuncia->pintarBordeEstatus('admitida', 'solicitud_expediente', 'providencia')}}">{{$denuncia->departamento_region->nombre }}
                                            / {{$denuncia->municipio_region->nombre }} </td>
                                        <td class="bg-white border-0 {{$denuncia->pintarBordeEstatus('admitida', 'solicitud_expediente', 'providencia')}}">{{$denuncia->origen->nombre}}</td>
                                        <td class="bg-white border-0 {{$denuncia->pintarBordeEstatus('admitida', 'solicitud_expediente', 'providencia')}}">{{$denuncia->medio_recepcion->nombre}}</td>

                                        @if($denuncia->sindicato_denunciante == 'N/A' )
                                            <td class="bg-white border-0 {{$denuncia->pintarBordeEstatus('admitida', 'solicitud_expediente', 'providencia')}}">{{$denuncia->NombreCompleto}}</td>
                                        @else
                                            <td class="bg-white border-0 {{$denuncia->pintarBordeEstatus('admitida', 'solicitud_expediente', 'providencia')}}">{{$denuncia->sindicato_denunciante}}</td>
                                        @endif

                                        <td class="bg-white border-0 {{$denuncia->pintarBordeEstatus('admitida', 'solicitud_expediente', 'providencia')}}">{{$denuncia->correo_denunciante}}</td>
                                        <td class="bg-white border-0 {{$denuncia->pintarBordeEstatus('admitida', 'solicitud_expediente', 'providencia')}}">{{ isset($denuncia->asignado_a->complete_name)?$denuncia->asignado_a->complete_name:'Sin usuario asignado' }}</td>
                                        <td class="pe-3 bg-white border-0 {{$denuncia->pintarBordeEstatus('admitida', 'solicitud_expediente', 'providencia')}}" style="width: 130px;">
                                            @include('denuncias.fragmentos.status', ['denuncia' => $denuncia])
                                        </td>
                                    @endcannot
                                @endcan
                                @can('ver_limitada_bandeja_denuncias')
                                    @cannot('ver_completa_bandeja_denuncias')
                                        <td class="ps-3 bg-white border-0 {{$denuncia->pintarBordeEstatus('admitida', 'solicitud_expediente', 'providencia')}}">
                                            <a href="{{route('denuncias.detalleDenunciaLimitada', $denuncia->id )}}"
                                               class="text-dark">
                                                <strong>{{$denuncia->num_expediente??'Sin expediente asignado'}}</strong></a>
                                        </td>
                                        <td class="bg-white border-0 {{$denuncia->pintarBordeEstatus('admitida', 'solicitud_expediente', 'providencia')}}">{{$denuncia->num_expediente_dgit ??'Sin expediente asignado'}}</td>
                                        <td class="bg-white border-0 {{$denuncia->pintarBordeEstatus('admitida', 'solicitud_expediente', 'providencia')}}">{{$denuncia->FechaRegistro}}</td>
                                        <td class="pe-3 bg-white border-0 {{$denuncia->pintarBordeEstatus('admitida', 'solicitud_expediente', 'providencia')}}">
                                            @include('denuncias.fragmentos.status', ['denuncia' => $denuncia])
                                        </td>
                                    @endcannot
                                @endcan
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
                @forelse($denuncias as $denuncia)
                    <div class="card my-2 card-bandeja-usuarios">
                        <div class="card-body">
                            <div class="row d-flex justify-content-between">
                                <div class="col-auto">
                                    <p class="mb-0 text-graydark fs-movil">{{$denuncia->sindicato_denunciante == 'N/A'?$denuncia->NombreCompleto:$denuncia->sindicato_denunciante}}</p>
                                </div>
                                <div class="col-auto d-flex justify-content-end fs-movil text-graydark">
                                    @include('partials.estatus', ['estatus' => $denuncia->estatus])
                                </div>
                            </div>
                            <p class="fw-normal mb-0 fs-movil text-graydark"><span
                                    class="fw-bold">Medio de recepción:</span> {{$denuncia->medio_recepcion->nombre}}
                            </p>
                            <p class="fw-normal mb-0 fs-movil text-graydark"><span
                                    class="fw-bold">Expediente ATI:</span> {{$denuncia->num_expediente??'Sin expediente asignado'}}
                            </p>
                            <p class="fw-normal mb-0 fs-movil text-graydark"><span
                                    class="fw-bold">Expediente PGR:</span> {{$denuncia->num_expediente_dgit??'Sin expediente signado'}}
                            </p>
                            <p class="text-end fs-movil">
                                @php
                                    if(auth()->user()->hasRole('denunciante') || ($estatus_providencia == $denuncia->estatus->id))
                                        $url = route('denuncias.informacion.adicional', $denuncia->id );
                                    else
                                        $url = route('denuncias.detalle', $denuncia->id );
                                @endphp
                                <a href="{{$url}}" class="text-estatus-{{ $denuncia->estatus->codigo }} fw-bold">
                                    <strong>
                                        Ver
                                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" height="0.5em"
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
            <div class="col-md-12 d-flex justify-content-center">{{$denuncias->links()}}</div>
            <div class="col-md-12 text-center text-small">
                <strong>{{ number_format($denuncias->firstItem()) }}</strong> <span>al</span>
                <strong>{{ number_format($denuncias->lastItem()) }}</strong> <span>de</span>
                <strong>{{ number_format($denuncias->total()) }}</strong> <span>registros</span>
            </div>
        </div>
    </div>
</div>
