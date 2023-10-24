@extends('layouts.app')
@section('content')
<x-bread-crumbs :itemsbread="$breadcrumbs"/>
    <div class="px-2 mb-2 pt-0">
        <h5 class="fw-semibold pb-2">
            <div class="">
                Levantar acta de Incumplimiento 
            </div>
        </h5>
    </div>
    <div class="px-2 pb-3 pt-2 bg-white">
        <form action="{{route('auditorias.registrar.acta.incumplimiento')}}" id="form_incumplimiento" class=" necesita-validacion" method="POST" autocomplete="off" accept-charset="UTF-8" enctype="multipart/form-data" novalidate onsubmit="validarFormulario(event)">
            @csrf
            <input type="hidden" id="inpId" name="id" value="{{$datosSolicitud->id}}"/>

            <div class="row form-group">
                <div class="col-4">
                    <div>
                        @include('components.carga-archivos', ['codigo' => 'acta_incumplimiento_auditoria', 'nombre'=>'Acta de incumplimiento','entidad' => null,'eliminable'=>true, 'required'=>true,'accept'=>'.jpg,.jpeg,.png,.pdf'])
                    </div>
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
                    <a href="{{ route('auditorias.solicitud_expediente.detalle',$datosSolicitud->id) }}" class="btn btn-accion-detalle btn-default w-100" >Cancelar</a>
                </div>
                <div class="form-group col-md-3 mb-2 mb-md-0 d-flex  justify-content-end">
                    <button id="btnIncumplimiento" type="submit" class="btn btn-accion-detalle bg-btn-guardar w-100">Guardar</button>
                </div>
            </div>
        </form>    
    </div>
@endsection
