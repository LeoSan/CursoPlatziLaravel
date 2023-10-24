@extends('layouts.app')
@section('content')
<x-bread-crumbs :itemsbread="$breadcrumbs"/>
    <div class="px-2 mb-2 pt-0">
        <h5 class="fw-semibold pb-2">
            <div class="">
                Prórroga 
            </div>
        </h5>
    </div>
    <div class="px-2 pb-3 pt-2 bg-white">
        <form action="{{route('auditorias.storeProrroga')}}" id="form_prorroga_solicitud_expedientes" class=" necesita-validacion" method="POST" autocomplete="off" accept-charset="UTF-8" enctype="multipart/form-data" novalidate onsubmit="validarFormulario(event)">
            @csrf
            <input type="hidden" id="inpId"           name="id" value="{{$expediente->id}}"/>
            <input type="hidden" id="inpJefeRegional" name="nombre_jefe_regional" value="{{$expediente->regional->nombre}}"/>
            <input type="hidden" id="inpNumOficio"    name="inpNumOficio" value="{{$expediente->numero_oficio}}"/>

            <div class="row form-group">
                <div class="col-4">
                    <div>
                        @include('components.carga-archivos', ['codigo' => 'oficio_solicitud_prorroga_expedientes', 'nombre'=>'Oficio de solicitud de prórroga','entidad' => null,'eliminable'=>true, 'required'=>true,'accept'=>'.jpg,.jpeg,.png,.pdf'])
                    </div>
                </div>
                <div class="col-4">
                    <label>Días de prórroga *</label>
                    <input id="inpDiasPlazo" name="plazo_respuesta_solicitud" class="form-control input-regular-height bg-w" type="text" max="5" maxlength="1" required onkeypress="validaCampos(this,'prorroga', 'inpDiasPlazo')" pattern="^[1-5]$" />
                    <div class="invalid-feedback fw-normal" data-default="Dato obligatorio y un máximo de 5 días"></div> 
                </div>
            </div>

            <div class="row form-group my-4">
                <div class="col-12">
                    <label for="inpObservacion" class="form-label">Observaciones *</label>
                    <textarea id="inpObservacion" name="observacion" class="editor" required>{{old('observacion')}}</textarea>
                    @error('observacion')
                        <span class="text-danger mt-1" role="alert">
                            <b class="fw-normal">{{ $message }}</b>
                        </span>
                    @enderror
                    <div class="invalid-feedback fw-normal" data-default="Dato obligatorio."></div>
                </div>
            </div>
        
            {{-- Funcionalidad de botones --}}
            <div class="d-flex flex-row mt-4 flex-sm-row flex-column">
                <div class="col">
                    &nbsp;
                </div>
                <div class="col">
                    &nbsp;
                </div>
                <div class="form-group col-md-3 mb-2 mb-md-0 d-flex  justify-content-end px-2">
                    @if($expediente->estatus->codigo=='solicitud_plazo_vencido')
                        <a href="{{ route('auditorias.solicitud_expediente.detalle',$expediente->id) }}" class="btn btn-accion-detalle btn-default w-100" >Cancelar</a>
                    @else
                        <a href="{{route('auditorias.detalle.expediente', $expediente->id)}}" class="btn btn-accion-detalle btn-default w-100" >Cancelar</a>
                    @endif
                </div>
                <div class="form-group col-md-3 mb-2 mb-md-0 d-flex  justify-content-end">
                    <button id="btnProrrogaModal" type="submit" class="btn btn-accion-detalle bg-btn-guardar w-100">Guardar</button>
                </div>
            </div>
        </form>    
    </div>
    @include('auditorias.partials.modal-confirm', ['idBtnControl'=>'btnGuardarProrroga'])
@endsection
