@extends('auditorias.detalle.layout')
@section('content-detalle')
    <div class="row p-3 mx-2 bg-white">
        @if($ejecucion->informe_auditoria == false)
        <div class="col-md-12">
            <div class="p-2 border-info text-bluedark">
                <i class="fa fa-info-circle text-bluedark text-bluedark"></i>
                <small>
                    <strong>Nota:</strong> Deberá cargar los documentos escaneados con las validaciones y firmas correspondientes.
                </small>
            </div>
        </div>
        <div class="col-md-12"><div class="border-light-gray border-bottom mt-2"></div></div>
        @endif
        <form id="fomGuardarInformeAuditoria" class="necesita-validacion" method="POST" action="{{route('auditorias.store.informe-auditoria')}}" enctype="multipart/form-data" novalidate>
        @csrf
        <input type="hidden" name="ejecucion_id" value="{{$ejecucion->id}}">
        <div class="col-md-12 py-2">
            <h6 class="mb-0 fw-bold">
                @if($ejecucion->auditoria_no_ejecutada == true)
                    Auditoría no ejecutada
                @else
                     Auditoría ejecutada
                @endif
            </h6>
        </div>
        <div class="col-md-12 py-2 row">
            <div class="col-md-6 py-2">
                @if($ejecucion->informe_auditoria == false)
                    @include('components.carga-archivos',['codigo'=>'informe_auditoria','nombre'=>'Informe de auditoria', 'entidad' => $ejecucion,'required'=>true,'accept'=>'.pdf'])
                    @isset($plantilla_informe_auditoria->id)
                        <div class="col-12 mt-2 text-small">
                            <a href="{{ route('plantillas.descargaDoc', $plantilla_informe_auditoria->id) }}"
                               class="text-decoration-none text-primary" target="_blank">
                                <i class="fas fa-download"></i>
                                <span class="text-decoration-underline">Descargar formato de informe de auditoria</span>
                            </a>
                        </div>
                    @endisset
                @else
                    @include('components.carga-archivos',['codigo'=>'informe_auditoria','nombre'=>'Informe de auditoria', 'entidad' => $ejecucion,'eliminable'=>false,])
                @endif
                <span class="text-danger txt-parrafo-error">{{ $errors->first('documento_archivo_informe_auditoria')}}</span>
            </div>
        </div>
        
        <div class="col-md-12"><div class="border-light-gray border-bottom mt-2"></div></div>
        <div class="col-md-12 py-2 row">
            <div class="col-md-6 py-2">
                @if($ejecucion->informe_auditoria == false)
                    @include('components.carga-archivos',['codigo'=>'cedula_hallazgos','nombre'=>'Cédula de hallazgos', 'entidad' => $ejecucion,'required'=>true,'accept'=>'.pdf'])
                    @isset($plantilla_cedula_hallazgos->id)
                        <div class="col-12 mt-2 text-small">
                            <a href="{{ route('plantillas.descargaDoc', $plantilla_cedula_hallazgos->id) }}"
                               class="text-decoration-none text-primary" target="_blank">
                                <i class="fas fa-download"></i>
                                <span class="text-decoration-underline">Descargar formato de cédula de hallazgos</span>
                            </a>
                        </div>
                    @endisset
                @else
                    @include('components.carga-archivos',['codigo'=>'cedula_hallazgos','nombre'=>'Cédula de hallazgos', 'entidad' => $ejecucion,'eliminable'=>false])
                @endif
                <span class="text-danger txt-parrafo-error">{{ $errors->first('documento_archivo_cedula_hallazgos')}}</span>
            </div>
            @if($ejecucion->informe_auditoria == false)
            <div class="col-md-12 py-2 row">
                <div class="form-group col-md-12 mb-0 d-flex align-items-center">
                    <input class="form-check-input" type="checkbox" name="con_hallazgos">
                    <label class="form-check-label mx-0 px-0 mt-1 text-left mb-0 ms-1 fw-regular" for="con_hallazgos">
                            Se encontraron hallazgos para notificar al secretario
                    </label>
                </div>
            </div>
            @else
            <div class="form-group col-md-12 mb-2">
                <label class="form-check-label mx-0 px-0 mt-1 text-left mb-0 fw-regular" for="auditoria_ejecutada">
                    Se encontraron hallazgos para notificar al secretario
                </label>
                @if($ejecucion->hallazgos_a_notificar == true)
                    <p class="mb-0">Si</p>
                @else
                    <p class="mb-0">No</p>
                @endif
            </div>
            @endif
        </div>
        @if($ejecucion->auditoria_no_ejecutada == true)
        <div id="seccion_acta_incumplimiento">
            <div class="col-md-12"><div class="border-light-gray border-bottom mt-2"></div></div>
            <div class="col-md-12 py-2 row">
                <div class="col-md-6 py-2">
                    @if($ejecucion->informe_auditoria == false)
                        @include('components.carga-archivos',['codigo'=>'acta_incumplimiento_auditoria','nombre'=>'Acta de incumplimiento', 'entidad' => $ejecucion,'accept'=>'.pdf','required'=>true])                        
                    @else
                        @include('components.carga-archivos',['codigo'=>'acta_incumplimiento_auditoria','nombre'=>'Acta de incumplimiento', 'entidad' => $ejecucion,'eliminable'=>false])
                    @endif
                    <span class="text-danger txt-parrafo-error">{{ $errors->first('documento_archivo_acta_incumplimiento_auditoria')}}</span>
                </div>
            </div>
        </div>
        @endif
        
        <div class="col-md-12"><div class="border-light-gray border-bottom mt-2"></div></div>
        <div class="col-md-12 py-2">
        </div>
        <div id="seccion_seguimiento">
            <div class="col-md-12 py-2">
                <div class="form-group col-md-12 mb-0 d-flex align-items-center">
                    @if($ejecucion->informe_auditoria == false)
                        @if($ejecucion->auditoria_no_ejecutada == false)
                            <input class="form-check-input" type="checkbox" name="con_seguimiento" onclick="activarFechaSeguimiento(this)">
                            <label class="form-check-label mx-0 px-0 mt-1 text-left mb-0 ms-1 fw-regular" for="con_seguimiento">
                                Se dará seguimiento a la auditoria
                            </label>
                        @endif
                    @else
                        @if($ejecucion->auditoria_no_ejecutada == false)
                            <div class="form-group col-md-6 mb-2">
                                <label class="form-check-label mx-0 px-0 mt-1 text-left mb-0 fw-regular" for="auditoria_ejecutada">
                                    Se dará seguimiento a la auditoria
                                </label>
                                @if($ejecucion->seguimiento == true)
                                    <p class="mb-0">Si</p>
                                @else
                                    <p class="mb-0">No</p>
                                @endif
                            </div>
                        @endif
                    @endif
                    
                </div>
            </div>
            <div class="col-md-12 py-2" id="fecha_seguimiento" style="display:none;">
                <div class="form-group col-md-4 mb-2">
                    <label class="form-label" id="label_fecha_seguimiento" for="fecha_entrega_expediente">Fecha de seguimiento *</label>
                    <input  name="fecha_seguimiento" id="input-fecha-seguimiento" type="date" class="form-control bg-white input-fecha input-regular-height" placeholder="Seleccione la fecha" maxlength="100" min="{{date('Y-m-d')}}">
                    <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                </div>
            </div>
            @if($ejecucion->auditoria_no_ejecutada == false)
            <div class="col-md-12 py-2">
                <div class="form-group col-md-6 mb-2">
                    @if($ejecucion->informe_auditoria == true)
                        <div class="form-group col-md-6 mb-2">
                            <label class="form-check-label mx-0 px-0 mt-1 text-left mb-0 fw-regular" for="auditoria_ejecutada">
                                Fecha de seguimiento
                            </label>
                            @if($ejecucion->fecha_seguimiento != null)
                                <p class="mb-0">{{$ejecucion->fecha_seguimiento->format('d/m/Y')}}</p>
                            @else
                                <p class="mb-0">No</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
            @endif

        </div>
        
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
            @if(isset($ejecucion->id) &&  $ejecucion->estatus->codigo=='elaboracion_informe' && auth()->user()->can('cargar_informe_auditoria'))
            <div class="form-group col-md-3 mb-2 mb-md-0 d-flex  justify-content-end">
                <button id="btnGenerarInformeAuditoria" type="submit" class="btn btn-accion-detalle bg-btn-guardar w-100">Finalizar</button>
                <button id="btnInformeAuditoriadModal" type="button" class="btn btn-accion-detalle bg-btn-guardar w-100 d-none" data-bs-toggle="modal" data-bs-target="#modalInformeAuditoria">
                </button> 
           </div>
           @endif
        </div>
    </form>
    <div class="modal fade modal-denuncia" id="modal-confirm-informe-auditoria" tabindex="-1" aria-labelledby="modalConfirmSolicitudLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalConfirmSolicitudLabel">Información</h5>
            <button type="button" class="btn-circle" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p id="msjConfirm">
              Se solicitarán N° expediente(s) correspondientes a las auditorías del mes de <mes> de <año> a la regional <regional>
            </p>
            <p class="p-0 m-0">
              ¿Desea continuar?
            </p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button id="btnGuardarInformeAuditoria" type="button" class="btn btn-tertiary py-2 rounded-1" data-bs-dismiss="modal">Continuar</button>
          </div>
        </div>
      </div>
    </div>
    </div>
@endsection
