@extends('layouts.app')
@section('content')
<x-bread-crumbs :itemsbread="$breadcrumbs"/>
<div class="row px-2 mb-2 pt-0">
    <div class="col-12">
        <h5 class="fw-semibold">
            <div class="">
                Respuesta a solicitud de expedientes
            </div>
        </h5>
        @include('partials.estatus-planeacion', ['estatus' => $expediente->estatus])
        <div class="border-light-gray border-bottom mt-2"></div>
    </div>
</div>
<div class="row p-3 mx-2 bg-white">
    <div class="col-md-4">
        <label for="">Regional</label>
        <p>{{ $expediente->regional->nombre }}</p>
    </div>
    <div class="col-md-4">
        <label for="">Mes</label>
        <p>{{ obtenerMes($expediente->mes) }}</p>
    </div>
    <div class="col-md-4">
        <label for="">Total de expedientes</label>
        <p>{{$expediente->total_expdientes_solicitados}}</p>
    </div>
    <div class="col-md-4">
        @include('components.carga-archivos',['codigo'=>'oficio_solicitud_informacion_auditoria','nombre'=>'Oficio de solicitud de información', 'entidad' => $expediente,'eliminable'=>false])
    </div>
    <div class="col-md-4">
         @include('components.carga-archivos',['codigo'=>'oficio_orden_ejecucion_auditoria','nombre'=>'Oficio de orden de ejecución de auditoría', 'entidad' => $expediente,'eliminable'=>false])
    </div>
            
    <form id="formRespuestaSolicitud" class="form-air necesita-validacion" method="POST" action="{{route('auditorias.respuesta.solicitud.expediente')}}" enctype="multipart/form-data" novalidate>
    @csrf
    <input type="hidden" name="solicitud_id" value="{{$expediente->id}}">
        @if(Auth::user()->hasRole('jefe_auditoria_setrass_ati') || Auth::user()->hasRole('auditor_setrass_ati'))
            <div class="row align-middle">
                @if($expediente->estatus->codigo != 'solicitud_recibida')
                <div class="form-group col-md-12 mb-2 d-flex align-items-center mt-3">
                    <input class="form-check-input check-no-expediente" type="checkbox" name="expediente_fisico" onchange="activarFecha(this)">
                    <label class="form-check-label mx-0 px-0 text-left mb-0 ms-1" for="recordarCheckbox">
                        Se recibió respuesta con expedientes en físico
                    </label>
                </div>
                <div class="form-group col-md-4 my-2" id="fecha-recepcion_expediente" style="display:none;">
                    <label class="form-label" id="label-fecha" for="fecha_entrega_expediente">Fecha de recepción de la respuesta</label>
                    <input id="fecha_entrega_expediente" name="fecha_entrega_expediente" type="date" class="form-control bg-white input-fecha input-regular-height" placeholder="Seleccione la fecha" maxlength="100" max="{{date('Y-m-d')}}" min="1970-01-01">
                    <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                </div>
                @else
                    @if($expediente->expediente_fisico==true)
                    <p class="f-18">El expediente se entregó en físico el día {{$expediente->fecha_expediente_fisico->format('d/m/Y')}}</p>
                    @endif

                @endif
            </div>
        @endif
        <div class="table-responsive mt-3">
            <table class="table table-bordered">
                @forelse($expediente->planeacion_auditorias as $grupo_auditoria)
                    @if($grupo_auditoria->planeacion_auditoria_mes($expediente->mes,$grupo_auditoria->id)->num_auditorias >0)
                    @if($expediente->estatus->codigo == 'solicitud_solicitada' || ($expediente->estatus->codigo=='solicitud_plazo_vencido' && Auth::user()->hasRole('jefe_auditoria_setrass_ati') ) || $expediente->estatus->codigo == 'solicitud_recibida')
                    <thead>
                    <tr>
                        <th class="text-center bg-head-table" colspan="3">
                            Inspección {{$grupo_auditoria->inspeccion->nombre}} - {{$grupo_auditoria->actividadeconomica->nombre}} - CAFTA: {{$grupo_auditoria->cafta}} - {{ $grupo_auditoria->planeacion_auditoria_mes($expediente->mes,$grupo_auditoria->id)->num_auditorias}} expediente(s)</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td class="align-middle w-80 text-center">
                                <div class="row mx-0">
                                    <div class="form-group col-md-6">
                                    <label for="">Expediente @if($expediente->estatus->codigo != 'solicitud_recibida') * @endif</label>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="" class="text-center">Número de expediente de la DGIT @if($expediente->estatus->codigo != 'solicitud_recibida') * @endif</label>
                                    </div>
                                </div>
                            </td>
                            @if($expediente->estatus->codigo == 'solicitud_solicitada' || ($expediente->estatus->codigo=='solicitud_plazo_vencido' && Auth::user()->hasRole('jefe_auditoria_setrass_ati') ))
                                <td class="align-middle text-center"><label for="">No cuento con expedientes</label></td>
                            @endif
                        </tr>
                        @foreach($grupo_auditoria->planeacion_auditoria_ejecuciones($expediente->mes,$grupo_auditoria->id) as $auditoria)
                            <tr>
                                <td class="align-middle text-center">{{$auditoria->num_control}}</td>
                                <td class="align-middle w-80" @if($expediente->estatus->codigo == 'solicitud_recibida') colspan="2" @endif>
                                    <div class=" mx-0">
                                        @if($expediente->estatus->codigo == 'solicitud_recibida' )
                                        @if($auditoria->tiene_expediente==true)
                                            @include('components.carga-archivos-mismo-tipo', [
                                            'entidad' => $auditoria,
                                            'id' => $auditoria->id,
                                            'en_columnas'=>true,
                                            'codigo' => 'expediente_respuesta_solicitud',
                                            'required' => true,
                                            'eliminable'=>false,
                                            'nombre' => 'Expediente',
                                            'accept'=>'.jpg,.jpeg,.png,.pdf',
                                            'numero_oficio'=>
                                                [
                                                'readonly'=>true,
                                                'required' => true,
                                                ]
                                            ])
                                        @else
                                        <p class="mb-0">Expediente no recibido</p>
                                        @endif
                                        @else
                                        @if($expediente->estatus->codigo == 'solicitud_solicitada' || ($expediente->estatus->codigo=='solicitud_plazo_vencido' && Auth::user()->hasRole('jefe_auditoria_setrass_ati') ))
                                        @include('components.carga-archivos-mismo-tipo', [
                                        'entidad' => $auditoria,
                                        'id' => $auditoria->id,
                                        'en_columnas'=>true,
                                        'codigo' => 'expediente_respuesta_solicitud',
                                        'required' => true,
                                        'accept'=>'.jpg,.jpeg,.png,.pdf',
                                        'numero_oficio'=>
                                            [
                                            'readonly'=>false,
                                            'required' => true,
                                            ]
                                        ])
                                        @endif
                                        @endif
                                    </div>  
                                </td>
                                @if($expediente->estatus->codigo == 'solicitud_solicitada' || $expediente->estatus->codigo=='solicitud_plazo_vencido' && Auth::user()->hasRole('jefe_auditoria_setrass_ati'))
                                <td class="align-middle">
                                    <div class="form-check text-center">
                                        <input class="form-check-input check-no-expediente " type="checkbox" name="documento[{{@$auditoria->id}}][tiene_expediente]" onchange="activarCargaArchivos(this)" style="float:none;">
                                    </div>
                                </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                    @endif
                    @endif
                @empty
                    <tr>
                        <td colspan="11" class="bg-white border-0">
                            Sin resultados encontrados
                        </td>
                    </tr>
                @endforelse
            </table>
        </div>
        <div class="d-flex flex-row my-4  flex-sm-row flex-column">
            <div class="col">
            &nbsp;
            </div>
            <div class="form-group col-md-3 mb-2 mb-md-0 d-flex  justify-content-end px-2 py-2">
                <a href="{{ route('auditorias.listado.solicitar.expediente') }}" class="btn btn-accion-detalle btn-default w-100" >Cancelar</a>
            </div>
            @if(isset($expediente) && ($expediente->estatus->codigo=='solicitud_plazo_vencido') &&  (Auth::user()->hasRole('jefe_auditoria_setrass_ati') || Auth::user()->hasRole('auditor_setrass_ati')  )  )
                @can('prorroga_solicitud_expedientes')
                    @if($expediente->vencido && $expediente->plazo_respuesta_solicitud ==10 )
                    <div class="form-group col-md-3 mb-2 mb-md-0 d-flex  justify-content-end px-2 py-2">
                        <a class="btn btn-accion-detalle btn-tertiary  w-100" href="{{route('auditorias.showProrroga', $expediente->id )}}">
                            Prórroga
                        </a>
                    </div>
                    @endif
                @endcan
                @can('solicitud_incumplimiento')
                    <div class="form-group col-md-3 mb-2 mb-md-0 d-flex  justify-content-end px-2 py-2">
                        <a  class="btn btn-accion-detalle bg-estatus-inadmision w-100" href="{{ route('auditorias.levantar.acta', $expediente->id) }}" >
                            Incumplimiento
                        </a>
                    </div>
                @endcan
            @endif    

            @if(isset($expediente) &&  ($expediente->estatus->codigo=='solicitud_solicitada' || ($expediente->estatus->codigo=='solicitud_plazo_vencido') && Auth::user()->hasRole('jefe_auditoria_setrass_ati') ) && auth()->user()->can('respuesta_solicitud_expediente'))
                <div class="form-group col-md-3 mb-2 mb-md-0 d-flex  justify-content-end px-2 py-2">
                    <button type="submit" class="btn btn-accion-detalle bg-btn-guardar w-100">Enviar expedientes</button>
                </div>
            @endif
        </div>
    </form>
</div>
@endsection
