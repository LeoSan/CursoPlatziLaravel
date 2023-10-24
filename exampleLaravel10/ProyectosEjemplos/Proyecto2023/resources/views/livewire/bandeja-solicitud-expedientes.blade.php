<div>
    <div class="row">
        <div class="border-top mb-2"></div>
        <label class="form-label font-regular-size mb-1" for="busqueda">Buscar</label>
        <div class="col-md-12 py-1 d-flex justify-content-end text-end align-items-center">
            <input type="text" class="form-control busqueda_casos font-regular-size bg-white input-regular-height border-filter" wire:model="busqueda" value="{{$busqueda}}" placeholder="Busque por número de oficio">
            @if(isset($busqueda) && strlen($busqueda)>2)
                <button class="btn btn-default busqueda_casos ms-2 input-regular-height" wire:click="removeFiltro('busqueda')">Cancelar</button>
            @endif
        </div>
    </div>

    <div class="row mt-3 d-flex justify-content-start align-items-end">
        <label class="form-label font-regular-size mb-1">
                Filtrar
        </label>
        @include('livewire.partials.filtros_solicitud_expedientes')
    </div>
    @if(auth()->user()->can('solicitud_expediente'))
    <div class="row pt-3 pb-2">
        <div class="col-lg-12 col-md-12 col-sm-12 text-end mt-2 mt-md-0">
            <a href="{{ route('auditorias.formulario.solicitud.expediente') }}" class="btn btn-secondary input-regular-height">Solicitar expedientes</a>
        </div> 
    </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="mt-2 d-none d-md-inline">
                <div class="table-responsive">
                    <table class="table text-center tabla-pgr">
                        <thead>
                        <tr>
                            <th class="text-center">Número de oficio </th>
                            <th class="text-center">Regional</th>
                            <th class="text-center">Mes</th>
                            <th class="text-center">Fecha de solicitud</th>
                            <th class="text-center">Auditor</th>
                            <th class="text-center">Total de expedientes solicitados</th>
                            <th class="text-center">Estatus</th>
                            
                        </tr>
                        </thead>
                        <tbody>
                            @forelse($datosAuditorias as $item)
                                    @if(Auth::user()->hasRole('jefe_auditoria_setrass_ati')  || Auth::user()->hasRole('auditor_setrass_ati')  )
                                        <td class="align-middle">
                                            @if ($item->estatus->codigo == 'solicitud_solicitada' || $item->estatus->codigo == 'solicitud_plazo_vencido')
                                                <a href="{{ route('auditorias.solicitud_expediente.detalle',$item->id) }}" class="text-dark">
                                                    <strong>{{$item->numero_oficio}}</strong>
                                                </a>
                                            @else
                                                <a href="{{ route('auditorias.detalle.expediente', [$item->id]) }}" class="text-dark">
                                                    <strong>{{$item->numero_oficio}}</strong>
                                                </a>
                                            @endif
                                        </td>
                                    @else
                                        <td class="align-middle">
                                            <a href="{{ route('auditorias.solicitud_expediente.detalle',$item->id) }}" class="text-dark">
                                                <strong>{{$item->numero_oficio}}</strong>
                                            </a>
                                        </td>
                                    @endif
                                    <td class="align-middle">{{$item->regional->nombre}}</td>
                                    <td class="align-middle">{{ obtenerMes($item->mes)}}</td>
                                    <td class="align-middle">{{$item->fecha_solicitud->format('d/m/Y')}}</td>
                                    <td class="align-middle">{{$item->creador->complete_name}}</td>
                                    <td class="align-middle">{{$item->total_expdientes_solicitados}}</td>
                                    <td class="align-middle">
                                        @include('auditorias.partials.status', ['solicitud' => $item])
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="bg-white border-0">
                                        Sin resultados encontrados
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="text-sm-center">
            @include('livewire.partials.entries')
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12 d-flex justify-content-center">{{$datosAuditorias->links()}}</div>
            <div class="col-md-12 text-center text-small">
                <strong>{{ number_format($datosAuditorias->firstItem()) }}</strong> <span>al</span>
                <strong>{{ number_format($datosAuditorias->lastItem()) }}</strong> <span>de</span>
                <strong>{{ number_format($datosAuditorias->total()) }}</strong> <span>registros</span>
            </div>
        </div>
    </div>
</div>