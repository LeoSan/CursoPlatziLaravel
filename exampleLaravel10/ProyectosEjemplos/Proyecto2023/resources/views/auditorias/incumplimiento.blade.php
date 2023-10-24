@extends('layouts.app')
@section('content')
    <x-bread-crumbs :itemsbread="$breadcrumbs"/>
    <div class="row px-2 mb-2 pt-0">
        <div class="col-12">
            <h5 class="fw-semibold">
                Ejecución de auditorías {{ date('Y') }} / {{$ejecucion->num_auditoria ?? 'Sin número asignado'}}
            </h5>
            @include('partials.estatus-planeacion', ['estatus' => $ejecucion->estatus])
            <div class="border-light-gray border-bottom my-2"></div>
            <h5 class="fw-semibold">
                Incumplimiento {{$ejecucion->tiene_expediente?'':'por falta de expediente'}}
            </h5>
        </div>
    </div>
    <div class="row p-3 mx-2 bg-white">
        <form action="{{route('auditorias.storeIncumplimiento')}}" class="necesita-validacion" method="POST" autocomplete="off" enctype="multipart/form-data" novalidate onsubmit="validarFormulario(event)">
            @csrf
            <input type="hidden" name="ejecucion_id" value="{{$ejecucion->id}}"/>
            <div class="row form-group">
                <div class="col-4">
                    <div>
                        @include('components.carga-archivos', ['codigo' => 'acta_incumplimiento_auditoria', 'nombre'=>'Acta de incumplimiento','entidad' => null,'eliminable'=>true, 'required'=>true,'accept'=>'.jpg,.jpeg,.png,.pdf'])
                    </div>
                </div>
            </div>
            <div class="row form-group my-4">
                <div class="col-12">
                    <label for="fundamentacion" class="form-label">Fundamentación del incumplimiento *</label>
                    <textarea id="fundamentacion" name="fundamentacion_incumplimiento" class="editor" required>{{old('fundamentacion_incumplimiento')}}</textarea>
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
                    <a href="{{route('auditorias.ejecucion.detalle', $ejecucion->id)}}" class="btn btn-accion-detalle btn-default w-100" >Cancelar</a>
                </div>
                @can('incumplimiento_auditorias')
                    <div class="form-group col-md-3 mb-2 mb-md-0 d-flex  justify-content-end">
                        <button id="btnIncumplimientoSinExpediente" type="submit" class="btn btn-accion-detalle bg-btn-guardar w-100">Guardar</button>
                    </div>
                @endcan
            </div>
        </form>
    </div>
@endsection
