@extends('layouts.app')
@section('content')
<x-bread-crumbs :itemsbread="$itemsbread"/>
<div class="container  detalle-denuncia">
    <div class="row mb-3">
        <div class="col d-flex">
            <div class="title-principal">Denuncia {{$denuncia->num_expediente}}</div>
            <div class="d-flex flex-row">
                <div> &nbsp; | &nbsp;</div>
                <div class="icon-status bg-estatus-{{ $denuncia->estatus->codigo}}"></div>
                <div class="text-estatus-{{$denuncia->estatus->codigo}} fw-bolder" >{{$denuncia->estatus->nombre}}</div>
            </div>
        </div>
    </div>
    {{-- Inicio Acordion --}}
    <div class="accordion" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
              <button class="accordion-button collapsed titulo-bg-gray" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                    <svg width="19" height="15" viewBox="0 0 19 15" xmlns="http://www.w3.org/2000/svg">
                        <g fill="#555770" fill-rule="nonzero">
                            <path d="M2.111 14.266H16.89c1.161 0 2.111-.95 2.111-2.111V6.65H0v5.505c0 1.16.95 2.11 2.111 2.11zM19 4.443c0-1.161-.95-2.111-2.111-2.111h-8.88v-.22C8.009.95 7.059 0 5.898 0H2.11C.95 0 0 .95 0 2.111V4.961h19v-.518z"/>
                        </g>
                    </svg>                
                    <span class="px-3">
                        Solicitud de expediente DGIT
                    </span>
              </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show p-3" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="row bg-white sub-titulo-red">
                    Información solicitada
                </div>
                <div class="row bg-white">

                        <div class="col-sm-4 col-xs-12 col-md-6">
                            <span>Expediente DGIT</span>
                            <p>{{$denuncia->num_expediente_dgit}}</p>
                        </div>
                        <div class="col-12 bg-white">
                            @include('denuncias.fragmentos.documento', ['item' => $doc_oficio_solicitar_expediente])
                        </div>
                        <div class="col-sm-12 col-xs-12">
                            <span>Información adicional</span>
                            <p>{!!$denuncia_solicitud_expediente->observacion??'Dato no proporcionado'!!}</p>
                        </div>
                </div>
                <div class="row bg-white">
                    <div class="sub-titulo-red">
                        Respuesta
                    </div>
                    @if($denuncia->estatus->codigo == 'solicitud_expediente')
                    <form method="post" id="formRespuestaSolicitud" action="{{route('denuncias.store_respuesta_solitud_expediente')}}" enctype="multipart/form-data" class="necesita-validacion" novalidate>
                            @csrf
                            <input type="hidden" name="denuncia_id" value="{{$denuncia->id}}">
                            <div class="row">
                                <div class="form-group col-md-12 mb-2">
                                    <label for="detalle_respuesta" class="fw-normal"><b>Detalle de la respuesta</b></label>
                                    <textarea name="detalle_respuesta" class="form-control editor" rows="15">{{old('detalle_respuesta')}}</textarea>
                                </div>
                            </div>
                            <div class="row bg-white">
                                <div class="form-group">
                                    @include('components.carga-archivos-multiple', ['codigo' => 'respuesta_solicitud_expediente','minimo'=>1])
                                </div>
                            </div>
                        </form>
                    @endif
                    @if($denuncia->estatus->codigo != 'solicitud_expediente')
                    <div class="bg-white">
                    <div class="col-12">
                        <span>Detalle de la respuesta</span>
                        <p>{!!$denuncia->solicitudExpedienteDGIT('expediente_recibido')->observacion ??'Dato no proporcionado'!!}</p>
                    </div>
                    <div class="col-sm-12 col-xs-12">
                        <span class="mb-4">Documentos</span>
                        <div class="row bg-white">
                            @forelse($docs_respuesta_solicitud_expediente as $key => $item)
                                @include('denuncias.fragmentos.documento', ['item' => $item])
                            @empty
                                <p>Dato no proporcionado.</p>
                            @endforelse
                        </div>

                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="row mt-4 justify-content-end">
    <div class="form-group col-md-3 mb-2 mb-md-0">
        <a href="{{route('denuncias.index')}}" class="btn btn-accion-detalle btn-default w-100">Cancelar</a>
    </div>
    @if(@$denuncia->estatus->codigo == "solicitud_expediente")
    <div class="form-group col-md-3 mb-2 mb-md-0" id="div_boton_convenio">
        <button type="submit" form="formRespuestaSolicitud" class="btn btn-accion-detalle bg-btn-guardar w-100">Enviar respuesta</button>
    </div>
    @endif
</div>
</div>

@endsection

