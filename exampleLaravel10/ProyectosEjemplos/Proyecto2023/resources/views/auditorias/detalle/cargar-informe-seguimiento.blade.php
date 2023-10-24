@extends('auditorias.detalle.layout')
@section('content-detalle')
    
    <div class="bg-white px-3 pt-3 pb-4">
       @if ($ejecucion->seguimiento == true )
            <form action="{{route('auditoria.registrar.informe')}}" id="form_carga_documentos_seguimiento" class="necesita-validacion" method="POST" autocomplete="off" accept-charset="UTF-8" enctype="multipart/form-data" novalidate onsubmit="validarFormulario(event)">
                @csrf
                <input id="id" name="id" type="hidden" value="{{$ejecucion->id}}" />
                <div class="contenido">
                    <div class="col-md-12 py-2 row">
                        <div class="col-md-6 py-2">
                            @isset($elementos['informe_seguimiento_recomendacion_auditoria'][0]->id)
                                @include('components.carga-archivos',['codigo'=>'informe_seguimiento_recomendacion_auditoria','nombre'=>'Informe de auditoria', 'entidad' => $ejecucion,'eliminable'=>false])
                            @else
                                @include('components.carga-archivos', [  'codigo' => 'informe_seguimiento_recomendacion_auditoria', 'nombre'=>'Seguimiento de recomendación','entidad' => null,'eliminable'=>true,  'required'=>true, 'accept'=>'.pdf'])
                                @isset($plantilla['formato_seguimiento_recomendaciones_auditoria']->id)
                                    <div class="col-12 mt-2 text-small">
                                        <a href="{{ route('plantillas.descargaDoc', $plantilla['formato_seguimiento_recomendaciones_auditoria']->id) }}"
                                            class="text-decoration-none text-primary" target="_blank">
                                                <i class="fas fa-download"></i>
                                                <span class="text-decoration-underline">Descargar formato de seguimiento de recomendación</span>
                                        </a>
                                    </div>
                                @endisset
                           
                            @endisset
                        </div>
                    </div>

                    <div class="col-md-12 py-2 row">
                        <div class="col-md-6 py-2">
                            @isset($elementos['informe_seguimiento_resultados_auditoria'][0]->id)
                                @include('components.carga-archivos',['codigo'=>'informe_seguimiento_resultados_auditoria','nombre'=>'Informe de auditoria', 'entidad' => $ejecucion,'eliminable'=>false])                               
                            @else
                                @include('components.carga-archivos', [  'codigo' => 'informe_seguimiento_resultados_auditoria', 'nombre'=>'Informe de resultados de seguimiento','entidad' => null,'eliminable'=>true,  'required'=>true, 'accept'=>'.pdf'])
                                @isset($plantilla['formato_informe_seguimiento_resultados_auditoria']->id)
                                    <div class="col-12 mt-2 text-small">
                                        <a href="{{ route('plantillas.descargaDoc', $plantilla['formato_informe_seguimiento_resultados_auditoria']->id) }}"
                                            class="text-decoration-none text-primary" target="_blank">
                                                <i class="fas fa-download"></i>
                                                <span class="text-decoration-underline">Descargar formato de seguimiento de recomendación</span>
                                        </a>
                                    </div>
                                @endisset
                            @endisset
                        </div>
                    </div>                    
                    <div class="d-flex flex-row my-4  flex-sm-row flex-column justify-content-end">
                        <div class="col-md-3 px-2">
                            <a href="{{ route('auditorias.seguimiento') }}" class="btn btn-accion-detalle btn-default w-100" >Cancelar</a>
                        </div>
                        @isset($elementos['informe_seguimiento_recomendacion_auditoria'][0]->id)
                            {{''}}
                        @else 
                            <div class="col-md-3 px-2">
                                <button id="btnFinalizarCargaDocSeguiModal" type="submit" class="btn btn-accion-detalle bg-btn-guardar w-100">Finalizar</button>
                            </div>
                        @endisset
                    </div>   
            </form>
            @include('auditorias.partials.modal-confirm', ['idBtnControl'=>'btnGuardarCargaDocAuditoria'])
       @endif     
    </div>
@endsection
