@extends('layouts.app')
@section('content')
    <x-bread-crumbs :itemsbread="$breadcrumbs"/>
    @php ( $is_plazo_vencido = empty($expediente->gestion()->whereHas('estatus',function($q){$q->whereCodigo('solicitud_plazo_vencido');})->orderBy('created_at', 'desc')->first()->vencido)? false : true) @endphp
    @php ( $datos_primer_plazo = $expediente->gestion()->whereHas('estatus',function($q){$q->whereCodigo('solicitud_solicitada');})->orderBy('created_at', 'desc')->first() ) @endphp

    <div class="row px-2 mb-2 pt-0">
        <div class="col-12">
            <h5 class="fw-semibold">
                <div class="">
                    Solicitud expedientes  {{ $elementos['titulo_anio'] }}
                </div>
            </h5>
            @include('partials.estatus-planeacion', ['estatus' => $expediente->estatus])
            <div class="border-light-gray border-bottom mt-2"></div>
        </div>
    </div>
    <div class="row p-3 mx-2 bg-white">
        <div class="text-gray fw-bold">
            Información de la auditoría
        </div>
        <div class="col-md-3">
            <label for="">Regional</label>
            <p>{{$ejecucion->grupo->municipio->nombre}}</p>
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
            <p>{{ obtenerMes($expediente->mes) }}</p>
        </div>
        <div class="col-md-3">
            <label for="">Auditor responsable</label>
            <p>{{$ejecucion->asignado->complete_name}}</p>
        </div>

        <div class="col-12">
            <div class="border-light-gray border-bottom"></div>
        </div>
    </div>
    <div class="row p-3 mx-2 bg-white">
        <div class="text-gray fw-bold">
            Solicitud de expedientes
        </div>
        <div class="col-md-3">
            <label for="">Fecha de solicitud</label>
            <p>{{$expediente->fecha_solicitud->format('d/m/Y')}}</p>
        </div>
        <div class="col-md-3">
            <label for="">Auditor que realizó la solicitud</label>
            <p>{{$expediente->creador->complete_name}}</p>
        </div>
        <div class="col-md-3">
            <label for="">Jefe regional que dio respuesta</label>
            <p>{{$expediente->auditor_regional->complete_name}}</p>
        </div>
        <div class="col-md-3">
            <label for="">Número de oficio de solicitud de información</label>
            <p>{{$expediente->numero_oficio}}</p>
        </div>
        <div class="col-md-3">
            <label for="">Total de expedientes solicitados</label>
            <p>{{$expediente->total_expdientes_solicitados}}</p>
        </div>
        <div class="col-md-3">
            <label for="">Total de expedientes recibidos</label>
            <p>{{ $elementos['total_recibido'] }}</p>
        </div>
        <div class="col-md-3">
            <label for="">Se dio respuesta en tiempo</label>
            <p>{{$expediente->vencido ==false? 'Si':'No'}}</p>
        </div>
        <div class="col-md-3">
            <label for="">Se recibó respuesta en físico</label>
            <p>{{$expediente->expediente_fisico ==true? 'Si':'No'}}</p>
        </div>

        <div class="col-sx-12 col-md-6">
            @forelse($elementos['oficio_solicitud_informacion_auditoria'] as $key => $item)
                @include('denuncias.fragmentos.documento', ['item' => $item])
            @empty
                <p>Dato no proporcionado.</p>
            @endforelse
        </div>
        <div class="col-sx-12 col-md-6">
            @forelse($elementos['oficio_orden_ejecucion_auditoria'] as $key => $item)
                @include('denuncias.fragmentos.documento', ['item' => $item])
            @empty
                <p>Dato no proporcionado.</p>
            @endforelse
        </div>

    </div>
    
    {{-- Mostrar datos prórroga --}}
    @if($is_plazo_vencido)
        <div class="row p-3 mx-2 bg-white">
            <div class="col-12">
                <div class="border-light-gray border-bottom"></div>
            </div>
            <div class="text-gray fw-bold mt-3">
                Prórroga
            </div>
            <div class="col-md-3">
                <label for="">Fecha de registro</label>
                <p>{{$datos_primer_plazo->created_at->format('d/m/Y')}}</p>
            </div>
            <div class="col-md-3">
                <label for="">Días de prórroga</label>
                <p>{{$expediente->plazo_respuesta_solicitud}}</p>
            </div>
            <div class="col-md-12">
                <label for="inpDescripcionAdicional" class="form-label">Observaciones</label>
                @isset($datos_primer_plazo->observacion)
                    <div class="text-justify f-10 break-w">{!!$datos_primer_plazo->observacion!!}</div>
                @else
                    <p>Dato no proporcionado.</p>
                @endisset
            </div>
            <div class="col-sx-12 col-md-6">
                @forelse($elementos['doc_oficio_solicitud_prorroga'] as $key => $item)
                    @include('denuncias.fragmentos.documento', ['item' => $item])
                @empty
                    <p>Dato no proporcionado.</p>
                @endforelse
            </div>
        </div>
    @endif



    {{-- Listado de Expdientes recibidos  --}}
    @if($expediente->estatus->codigo != 'solicitud_solicitada' && $expediente->estatus->codigo != 'solicitud_plazo_vencido'  )
        <div class="row p-3 mx-2 bg-white">
            <div class="text-gray fw-bold">
                Expedientes
            </div>
            <div class="table-responsive mt-3">
                <table class="table table-bordered">
                    @forelse($expediente->planeacion_auditorias as $grupo_auditoria)
                        @if($grupo_auditoria->planeacion_auditoria_mes($expediente->mes,$grupo_auditoria->id)->num_auditorias >0)
                        <thead>
                        <tr>
                            <th class="text-center bg-head-table" colspan="3">
                                Inspección {{$grupo_auditoria->inspeccion->nombre}} - {{$grupo_auditoria->actividadeconomica->nombre}} - CAFTA: {{$grupo_auditoria->cafta}} - {{ $grupo_auditoria->planeacion_auditoria_mes($expediente->mes,$grupo_auditoria->id)->num_auditorias}} expediente(s)
                            </th>
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
                                @if($expediente->estatus->codigo == 'solicitud_solicitada')
                                    <td class="align-middle text-center"><label for="">No cuento con expedientes</label></td>
                                @endif
                            </tr>
                            @foreach($grupo_auditoria->planeacion_auditoria_ejecuciones($expediente->mes,$grupo_auditoria->id) as $auditoria)
                                <tr>
                                    <td class="align-middle text-center">{{$auditoria->num_control}}</td>
                                    <td class="align-middle w-100">
                                        <div class="row mx-0">
                                            @if($expediente->estatus->codigo == 'solicitud_recibida')
                                                @if($auditoria->tiene_expediente==true)
                                                    @include('components.carga-archivos-mismo-tipo', [
                                                    'entidad' => $auditoria,
                                                    'id' => $auditoria->id,
                                                    'en_columnas'=>true,
                                                    'codigo' => 'expediente_respuesta_solicitud',
                                                    'required' => true,
                                                    'eliminable'=>false,
                                                    'nombre' => 'Expediente',
                                                    'numero_oficio'=>
                                                        [
                                                        'readonly'=>true,
                                                        'label'=>'Número de expediente de la DGIT',
                                                        'required' => true,
                                                        ]
                                                    ])
                                                @else
                                                <p class="mb-0">Expediente no recibido</p>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                    @if($expediente->estatus->codigo == 'solicitud_solicitada')
                                    <td class="align-middle">
                                        <div class="form-check">
                                            <input class="form-check-input check-no-expediente" type="checkbox" name="documento[{{@$auditoria->id}}][tiene_expediente]" onchange="activarCargaArchivos(this)">
                                            <label class="form-check-label mx-0 px-0 text-left" for="recordarCheckbox">
                                                No se han cargado expedientes
                                            </label>
                                        </div>
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
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
        </div>
    @endif
    <div class="row p-3 mx-2 bg-white">
        {{-- @can('solicitud_incumplimiento') --}}
            @if( $expediente->gestion()->first()->estatus->codigo == 'solicitud_incumplimiento')
                <div class="text-estatus-solicitud_incumplimiento mt-4 fw-bold">
                    Incumplimiento
                </div>
                <div class="col-12">
                    <label for="">Observaciones</label>
                    <div class="text-justify  break-w">
                        {!!$expediente->gestion()->first()->observacion!!}
                    </div>
                </div>
                <div class="col-sx-12 col-md-6 mt-2">
                    @forelse($elementos['acta_incumplimiento_auditoria'] as $key => $item)
                        @include('denuncias.fragmentos.documento', ['item' => $item])
                    @empty
                        <p>Dato no proporcionado.</p>
                    @endforelse
                </div>
                <div class="col-12">
                    <div class="border-light-gray border-bottom"></div>
                </div>
            @endif
        {{-- @endcan --}}


        {{-- Funcionalidad de botones --}}
        <div class="d-flex flex-row my-4  flex-sm-row flex-column">
            <div class="col">
                &nbsp;
            </div>
            <div class="col">
                &nbsp;
            </div>
            <div class="form-group col-md-3 mb-2 mb-md-0 d-flex  justify-content-end px-2">
                <a href="{{ route('auditorias.listado.solicitar.expediente') }}" class="btn btn-accion-detalle btn-default w-100" >Cancelar</a>
            </div>

            @switch($expediente->estatus->codigo)

                @case('solicitud_plazo_vencido')

                    @if(isset($expediente) && ($expediente->estatus->codigo=='solicitud_plazo_vencido') &&  (Auth::user()->hasRole('jefe_auditoria_setrass_ati') || Auth::user()->hasRole('auditor_setrass_ati')  )  )
                        @if($expediente->vencido && $expediente->plazo_respuesta_solicitud ==10 )
                            <div class="form-group col-md-3 mb-2 mb-md-0 d-flex  justify-content-end px-2">
                                <a class="btn btn-accion-detalle btn-tertiary  w-100" href="{{route('auditorias.showProrroga', $expediente->id )}}">
                                    Prórroga
                                </a>
                            </div>
                        @endif
                    @endif
                        
                    @can('solicitud_incumplimiento')
                    <div class="form-group col-md-3 mb-2 mb-md-0 d-flex  justify-content-end px-2">
                        <a  class="btn btn-accion-detalle bg-btn-guardar w-100" href="{{ route('auditorias.levantar.acta', $expediente->id) }}" >
                            Incumplimiento
                        </a>
                    </div>
                    @endcan

                @break
            @endswitch
        </div>
    </div>
@endsection
