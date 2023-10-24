@extends('layouts.app')
@section('content')
    <div class="row font-regular-size">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('casos.index')}}">Bandeja de casos</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ isset($caso->numero_expediente) ? $caso->numero_expediente : '## exp'}}
                </li>
            </ol>
        </nav>
    </div>
    <div class="row mb-3 font-regular-size">
        <div>
            <h5 class="p-0 mb-2">
                <strong class="fw-semibold">
                    Expediente
                    {{ isset($caso->numero_expediente) ? $caso->numero_expediente : '##'}}
                </strong>
            </h5>
        </div>

        @include('partials.estatus', ['estatus' => $caso->estatus])
    </div>

    @if($caso->estatus->codigo=='revision' && auth()->user()->can('notificar_pgr_caso'))
        <h5 class="mb-3 text-estatus-{{ $estatus->codigo }}">
            <small class="fw-semibold">
                Solicitar seguimiento a PGR
            </small>
        </h5>
        <form method="post" action="{{route('casos.notificarPGR')}}" class="bg-w px-3 pb-3 pt-3"  id="form_seguimiento_pgr" enctype="multipart/form-data" novalidate>
        @csrf
            <input type="hidden" name="tipo_submit">
            <input type="hidden" name="caso_id" value="{{$caso->id}}">
            <div class="row mt-2">
                <div class="col-md-4">
                    @include('components.carga-archivos',['codigo'=>'constancia_firmeza','nombre'=>'Constancia de firmeza', 'entidad' => $caso,'required'=>true])
                </div>
                <div class="col-md-4">
                    @include('components.carga-archivos',['codigo'=>'resolucion_certificada','nombre'=>'Resolución certificada', 'entidad' => $caso,'required'=>true])
                </div>
            </div>
            <div class="row mt-2 d-flex align-items-center">
                @include('components.carga-archivos',['en_columnas'=>true,'codigo'=>'acuse_recibo','nombre'=>'Acuse de recibo', 'entidad' => $caso,
                    'numero_oficio'=>['required'=>true,'readonly'=>false],
                    'fecha_oficio'=>['required'=>true,'readonly'=>false],
                    'required'=>true])
            </div>
        </form>
    @endif
    <div class="row">
        <!-- BOTONES -->
        <div class="mt-4 d-flex seccion-acciones justify-content-end gap-2 gap-md-4 flex-wrap flex-md-nowrap">
            <div class="form-group mb-2 mb-md-0 w-100">
                <a href="{{route('casos.informacion',$caso->id)}}" class="btn btn-accion-detalle btn-default w-100">
                    Cancelar
                </a>
            </div>
            @if($caso->estatus->codigo=='revision')
                @can('notificar_pgr_caso')
                    <div class="form-group mb-2 mb-md-0 w-100">
                        <button type="submit" form="form_seguimiento_pgr"
                                class="btn btn-accion-detalle bg-estatus-en_revision w-100" id="btn_borrador_caso">
                            <!--aquí el atributo de a qué form pertenece el submit-->
                            Guardar Cambios
                        </button>
                    </div>
                    <div class="form-group mb-2 mb-md-0 w-100">
                        <button type="submit" form="form_seguimiento_pgr"
                                class="btn btn-accion-detalle w-100 bg-estatus-pendiente" id="btn_seguimiento_caso">
                            <!--aquí el atributo de a qué form pertenece el submit-->
                            Solicitar seguimiento a PGR
                        </button>
                    </div>
                @endcan
            @endif
        </div>
    </div>
@endsection
