@extends('layouts.app')
@section('content')
    <x-bread-crumbs :itemsbread="$breadcrumbs"/>
    <div class="px-2 mb-2 pt-0">
        <h5 class="fw-semibold pb-2">
            <div class="">
                Solicitar expedientes
            </div>
        </h5>
    </div>
    <div class="px-2 pb-3 pt-2 bg-white">
        <form action="{{route('auditorias.registrar.solicitud.expediente')}}" id="form_solicitar_Expedientes" class="necesita-validacion" method="POST" autocomplete="off" accept-charset="UTF-8" enctype="multipart/form-data" novalidate onsubmit="validarFormulario(event)">
            @csrf
                <input type="hidden" id="inpJefeRegional" name="jefe_regional_id" value="0" />
                <input type="hidden" id="inpEstatus" name="estatus" value="{{$elementos['estatus_pendiente']}}" />
                <input type="hidden" id="inpAnio" name="anio" value="{{$elementos['titulo_anio']}}" />
                <div class="row mt-2 d-flex align-items-center">
                    @include('components.carga-archivos', ['en_columnas'=>true, 'codigo' => 'oficio_solicitud_informacion_auditoria', 'nombre'=>'Oficio de solicitud de información','entidad' => null,'eliminable'=>true, 'numero_oficio'=>['required'=>true,'readonly'=>false,'label'=>'Número de oficio de solicitud de información'], 'required'=>true, 'accept'=>'.jpg,.jpeg,.png,.pdf'])
                    @include('components.carga-archivos', ['en_columnas'=>true, 'codigo' => 'oficio_orden_ejecucion_auditoria', 'nombre'=>'Oficio de orden de ejecución de auditoría','entidad' => null,'eliminable'=>true, 'required'=>true,'accept'=>'.jpg,.jpeg,.png,.pdf'])
                </div>
                <div class="row form-group">
                    <div class="col-md-4 col-sm-12 py-1">
                        <label for="regional" class="col-auto  label-xs small text-gray pt-1 mb-0">Regional *</label>
                        <select class="form-select input-regular-height  bg-w" id="regional" name="regional"
                                onchange="obtenerJefeRegional(this,'regional','btnSolicitarExpediente', 'btnSolicitudModal',)"  
                                required>
                            <option value="">Seleccione</option>
                            @foreach ($elementos['cat_regional'] as $i )
                                <option value="{{$i->id}}">{{$i->nombre}}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                    </div>
                   
                    <div class="col-xs-12 col-md-4">
                        <label for="inpNombre" class="form-label">Nombre del Jefe Regional</label>
                        <input id="inpNombre" name="nombre"  type="text" class="form-control input-regular-height campo-dis" value="{{old('nombre')}}"  disabled />
                        <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                    </div>
                    <div class="col-xs-12 col-md-4">
                        <label for="inpEmail" class="form-label">Correo electrónico del Jefe Regional</label>
                        <input id="inpEmail" name="email"  type="text"  class="form-control input-regular-height campo-dis" value="{{old('email')}}"  disabled />
                        <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                    </div>
                  
                    <div class="col-md-4 col-sm-12 py-1">
                        <label for="mes_filtro" class="col-auto label-xs small text-gray pt-1 mb-0">Mes *</label>
                        <select class="form-select input-regular-height  bg-w" id="mes_filtro" name="mes"
                                onchange="obtenerSolicitudMesRegional(this,'mes_filtro', 'regional', 'inpValor', 'inpEstatus', 'tbody_solicitud', 'tabla_solicitud', 'btnSolicitarExpediente', 'btnSolicitudModal', 'inpJefeRegional')"  
                                required>
                            <option value="0">Seleccione</option>
                            @foreach($elementos['mes'] as $k => $i)
                                <option value="{{$k}}">{{$i}}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                    </div>                    
                </div>
             
                <div class="row">
                    <div class="col-12">
                        <div class="mt-2 d-none d-md-inline">
                            <div class="table-responsive">
                                <table id="tabla_solicitud"  class="table text-center tabla-pgr d-none">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Tipo de inspección </th>
                                            <th class="text-center">Actividad económica</th>
                                            <th class="text-center">CAFTA</th>
                                            <th class="text-center">Total de auditorías</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody_solicitud">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>              
                
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
                    <div class="form-group col-md-3 mb-2 mb-md-0 d-flex  justify-content-end">
                        <button id="btnSolicitarExpediente" type="submit" class="btn btn-accion-detalle bg-btn-guardar w-100">Solicitar información</button>
                        <button id="btnSolicitudModal" type="button" class="btn btn-accion-detalle bg-btn-guardar w-100 d-none" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Solicitar información
                        </button>
                   </div>
                </div>
        </form>
        <span id="inpValor" class='opacity-0'>{{$elementos['valor']}}</span>
        @include('auditorias.partials.modal-alert')
        @include('auditorias.partials.modal-confirm', ['idBtnControl'=>'btnGuardarSolicitud'])
    </div>
@endsection
