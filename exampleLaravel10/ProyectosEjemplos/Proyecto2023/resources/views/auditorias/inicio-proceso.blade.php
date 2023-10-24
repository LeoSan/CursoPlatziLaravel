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
                Iniciar proceso de auditoría
            </h5>
        </div>
    </div>
    <div class="row p-3 mx-2 bg-white">
        <form action="{{route('auditorias.storeIniciarProceso')}}" class="necesita-validacion" method="POST" autocomplete="off" enctype="multipart/form-data" novalidate onsubmit="validarFormulario(event)">
            @csrf
            <input type="hidden" name="ejecucion_id" value="{{$ejecucion->id}}"/>
            <div class="row">
                @include('components.carga-archivos', ['en_columnas'=>true,'codigo' => 'acta_inicio_auditoria', 'nombre'=>'Acta de inicio de auditoría', 'entidad' => $ejecucion,'eliminable'=>true, 'required'=>true,'accept'=>'.jpg,.jpeg,.png,.pdf',
                        'numero_oficio'=>['required'=>true],'fecha_oficio'=>['required'=>true,'label'=>'Fecha de inicio de la auditoría','fechas_futuras'=>true]])
                @isset($plantilla->id)
                    <div class="col-12 mt-2 text-small">
                        <a href="{{ route('plantillas.descargaDoc', $plantilla->id) }}"
                           class="text-decoration-none text-primary" target="_blank">
                            <i class="fas fa-download"></i>
                            <span class="text-decoration-underline">Descargar formato de Acta de inicio de auditoría</span>
                        </a>
                    </div>
                @endisset
            </div>
            <div class="row justify-content-end mt-4">
                <div class="col-md-3 mb-2 px-2">
                    <a href="{{route('auditorias.ejecucion.detalle', $ejecucion->id)}}" class="btn btn-accion-detalle btn-default w-100" >Cancelar</a>
                </div>
                @can('iniciar_proceso_auditorias')
                    <div class="col-md-3 mb-2">
                        <button type="submit" class="btn btn-accion-detalle bg-estatus-proceso w-100">Iniciar proceso</button>
                    </div>
                @endcan
            </div>
        </form>
    </div>
@endsection
