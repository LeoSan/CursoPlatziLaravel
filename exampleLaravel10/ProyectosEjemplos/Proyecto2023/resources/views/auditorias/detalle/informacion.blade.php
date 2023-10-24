@extends('auditorias.detalle.layout')
@section('content-detalle')
    <div class="row p-3 mx-2 bg-white">
        <div class="col-12">
            <div class="text-gray fw-bold">
                Información de la auditoría
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <label for="">Número de auditoría</label>
                <p>{{$ejecucion->num_auditoria ?? 'Sin número asignado'}}</p>
            </div>
            <div class="col-md-3">
                <label for="">Departamento</label>
                <p>{{$ejecucion->grupo->departamento->nombre}}</p>
            </div>
            <div class="col-md-3">
                <label for="">Municipio</label>
                <p>{{$ejecucion->grupo->municipio->nombre}}</p>
            </div>
            <div class="col-md-3">
                <label for="">Regional</label>
                <p>{{$ejecucion->grupo->region->nombre}}</p>
            </div>
            <div class="col-md-3">
                <label for="">Tipo de inspección</label>
                <p>{{$ejecucion->grupo->inspeccion->nombre}}</p>
            </div>
            <div class="col-md-3">
                <label for="">Actividad económica</label>
                <p>{{$ejecucion->grupo->actividadEconomica->nombre}}</p>
            </div>
            <div class="col-md-3">
                <label for="">CAFTA</label>
                <p>{{$ejecucion->grupo->cafta??'No'}}</p>
            </div>
            <div class="col-md-3">
                <label for="">Mes</label>
                <p>{{$ejecucion->nombremes}}</p>
            </div>
            <div class="col-md-3">
                <label for="">Auditor responsable</label>
                <p>{{$ejecucion->asignado->complete_name}}</p>
            </div>
        </div>
        @if($ejecucion->solicitud)
            <div class="row my-2">
                <div class="col-12 mb-3">
                    <div class="border-light-gray border-bottom"></div>
                </div>
                <div class="col-12">
                    <div class="text-gray fw-bold">
                        Solicitud de expediente
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        @include('components.carga-archivos',['codigo'=>'oficio_solicitud_informacion_auditoria','nombre'=>'Oficio de solicitud de información',
                            'entidad' => $ejecucion->solicitud, 'eliminable'=>false])
                    </div>
                    <div class="col-md-4">
                        <label for="">Número de oficio de solicitud de información</label>
                        <p>{{$ejecucion->solicitud->numero_oficio}}</p>
                    </div>
                    <div class="col-md-4">
                        @include('components.carga-archivos',['codigo'=>'oficio_orden_ejecucion_auditoria','nombre'=>'Oficio de orden de ejecución de auditoría', 'entidad' => $ejecucion->solicitud, 'eliminable'=>false])
                    </div>
                </div>
                <div class="row mt-md-2">
                    <div class="col-md-4">
                        <label for="">Nombre del jefe Regional</label>
                        <p>{{$ejecucion->solicitud->auditor_regional->complete_name}}</p>
                    </div>
                    @if($ejecucion->tiene_expediente)
                        <div class="col-md-4">
                            @include('components.carga-archivos',['codigo'=>'expediente_respuesta_solicitud','nombre'=>'Expediente','entidad' => $ejecucion, 'eliminable'=>false])
                        </div>
                    @else
                        <div class="col-12">
                            <p class="fw-semibold">El jefe regional indicó que no se cuenta con un expediente con las características señaladas en la solicitud.</p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @can('incumplimiento_auditorias')
            @if( $ejecucion->observaciones_incumplimiento )
                <div class="row my-2">
                    <div class="col-12 mb-3">
                        <div class="border-light-gray border-bottom"></div>
                    </div>
                    <div class="col-12">
                        <div class="text-gray fw-bold">
                            Incumplimiento {{$ejecucion->tiene_expediente?'':'por falta de expediente'}}
                        </div>
                    </div>
                    <div class="col-md-6">
                        @include('components.carga-archivos',['codigo'=>'acta_incumplimiento_auditoria','nombre'=>'Acta de incumplimiento','entidad' => $ejecucion, 'eliminable'=>false])
                    </div>
                    <div class="col-12">
                        <label for="">Fundamentación del incumplimiento</label>
                        <div class="text-justify  break-w">
                            {!!$ejecucion->observaciones_incumplimiento!!}
                        </div>
                    </div>
                </div>
            @endif
            @if( $ejecucion->num_auditoria )
                <div class="row my-2">
                    <div class="col-12 mb-3">
                        <div class="border-light-gray border-bottom"></div>
                    </div>
                    <div class="col-12">
                        <div class="text-gray fw-bold">
                            Inicio de proceso de auditoría
                        </div>
                    </div>
                    <div class="col-md-4">
                        @include('components.carga-archivos',['codigo'=>'acta_inicio_auditoria','nombre'=>'Acta de inicio de proceso de auditoría','entidad' => $ejecucion, 'eliminable'=>false])
                    </div>
                    <div class="col-md-4">
                        <label for="">Número de oficio</label>
                        <div class="text-justify  break-w">
                            {{$ejecucion->num_oficio}}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="">Fecha de inicio de la auditoría</label>
                        <div class="text-justify  break-w">
                            {{$ejecucion->fecha_entrega_oficio}}
                        </div>
                    </div>
                </div>
            @endif
        @endcan
        <div class="d-flex flex-row my-4  flex-sm-row flex-column justify-content-end">
            <div class="col-md-3 px-2">
                <a href="{{ route('auditorias.ejecuciones') }}" class="btn btn-accion-detalle btn-default w-100" >Cancelar</a>
            </div>
            @if($ejecucion->estatus->codigo=='expediente_recibido_sin_informacion'||$ejecucion->estatus->codigo=='expediente_recibido')
                @can('incumplimiento_auditorias')
                    <div class="col-md-3 px-2">
                        <a  class="btn btn-accion-detalle bg-btn-incumplimiento w-100" href="{{ route('auditorias.showIncumplimiento', $ejecucion->id) }}" >
                            Incumplimiento
                        </a>
                    </div>
                @endcan
                @if($ejecucion->estatus->codigo=='expediente_recibido')
                    @can('iniciar_proceso_auditorias')
                        <div class="col-md-3 px-2">
                            <a  class="btn btn-accion-detalle bg-estatus-proceso w-100" href="{{ route('auditorias.showIniciarProceso', $ejecucion->id) }}" >
                                Iniciar proceso
                            </a>
                        </div>
                    @endcan
                @endif
            @endif
        </div>
    </div>
@endsection
