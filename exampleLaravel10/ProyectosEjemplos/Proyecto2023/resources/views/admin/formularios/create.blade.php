@extends('layouts.app')
@section('content')
    <div class="row px-3 mt-2">
        <x-bread-crumbs :itemsbread="$itemsbread"/>
        <x-modal-confirm/>
    </div>
    <div class="row p-3 px-3 bg-white">
        @isset($formulario->id)
            <div class="col-12">
                @include('partials.estatus', ['estatus' => $formulario->estatus])
            </div>
        @endisset
        <form action="{{route('formularios.store')}}" method="post" class="row necesita-validacion" novalidate>
            @csrf
            <input type="hidden" name="formulario_id" value="{{@$formulario->id}}">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nombre">Nombre *</label>
                    <input name="nombre" id="nombre" type="text" class="form-control bg-white" placeholder="Escriba el nombre del formulario"  required maxlength="100" value="{{@$formulario->nombre??old('nombre')}}">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="col-md-6 form-group">
                <label for="tipo_inspeccion_id">Tipo de inspección *</label>
                <select name="tipo_inspeccion_id" id="tipo_inspeccion_id" class="form-select" required>
                    <option value="">Seleccione una opción</option>
                    @foreach(getCatalogoElementos('tipos_inspeccion','nombre') as $i)
                        <option value="{{$i->id}}" {{@$formulario->tipo_inspeccion_id==$i->id?'selected':( old('tipo_inspeccion_id')==$i->id ?'selected': '')}}>{{$i->nombre}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="col-md-12 mt-2 d-flex justify-content-end">
                <a href="{{route('formularios.index')}}" class="btn btn-default me-2">Cancelar</a>
                <button type="submit" class="btn btn-tertiary text-white">{{isset($formulario->id)?'Actualizar':'Guardar'}}</button>
            </div>
        </form>
    </div>

    @if(isset($formulario->id))
        <div class="row p-3 px-3 bg-white mt-3">
            <div class="col-md-4 text-center border-end">
                <h5>Secciones</h5>
                @if($formulario->secciones->count()==0)
                    <div class="alert alert-info p-2 text-small mb-2">Actualmente no existen secciones registradas.</div>
                @else
                    <ul class="nav nav-pills flex-column" id="tabsSecciones" role="tablist">
                        @foreach($formulario->secciones as $i=>$seccion)
                            <li class="nav-item mb-1" role="presentation">
                                <a class="nav-link {{isset($_GET['seccion_id'])?($_GET['seccion_id']==$seccion->id?'active':''):($i==0?'active':'')}} formulario-seccion" href="#" id="seccion{{$seccion->id}}-tab" data-bs-toggle="tab" data-bs-target="#seccion{{$seccion->id}}" role="tab" aria-controls="seccion{{$seccion->id}}" aria-selected="true">
                                    {{($i+1).'. '.$seccion->nombre}} - <span class="fs-movil">{{$seccion->preguntas->count()}} pregunta(s)</span>

                                    <div class="btn-group dropleft float-end">
                                        <button type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-ellipsis-vertical text-gray"></i>
                                        </button>
                                        <div class="dropdown-menu text-center p-1">
                                            <button  class="btn-link text-gray text-small" onclick="formularioSeccion({{$seccion->id}},'{{$seccion->nombre}}')">
                                                <i class="fa fa-edit fs-6"></i> Editar
                                            </button>
                                            <button  class="btn-link text-danger text-small" data-bs-toggle="modal" data-bs-target="#modalEliminarSeccion"
                                                     onclick="document.getElementById('idEliminarSeccion').value={{$seccion->id}}"
                                            >
                                                <i class="fas fa-trash-can fs-6"></i> Eliminar
                                            </button>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
                <div class="row justify-content-end mt-2">
                    <div class="col-auto">
                        <button class="btn btn-sm btn-danger" onclick="formularioSeccion()">Agregar sección</button>
                    </div>
                </div>
            </div>
            <div class="col-md-8 text-center">
                <h5 class="m-0">Preguntas</h5>
                @if($formulario->secciones->count()==0)
                    <div class="alert alert-info p-2 text-small mt-2">Para agregar preguntas es necesario seleccionar una sección.</div>
                @else
                    <div class="tab-content">
                        @foreach($formulario->secciones as $i=>$seccion)
                            <div class="tab-pane fade {{isset($_GET['seccion_id'])?($_GET['seccion_id']==$seccion->id?'show active':''):($i==0?'show active':'')}}" id="seccion{{$seccion->id}}" role="tabpanel" aria-labelledby="seccion{{$seccion->id}}-tab">
                                <div class="row">
                                    <div class="col-12 mb-2"><strong>Sección: </strong>{{($i+1).'. '.$seccion->nombre}}</div>
                                    @if($seccion->preguntas->count()==0)
                                        <div class="col-12">
                                            <div class="alert alert-info p-2 text-small my-2">Actualmente no existen preguntas registradas en esta sección.</div>
                                        </div>
                                    @else
                                        @foreach($seccion->preguntas as $k=>$pregunta)
                                            <div class="col-12 px-4">
                                                <div class="row bg-graylight mb-1 pt-3">
                                                    <div class="col-md-1">
                                                        <strong>{{$k+1}}.-</strong>
                                                    </div>
                                                    <div class="col-md-10 text-start">
                                                        {!! $pregunta->pregunta !!}
                                                    </div>
                                                    <div class="col-md-1 float-end">
                                                        <div class="btn-group dropleft">
                                                            <button type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="fa fa-ellipsis-vertical"></i>
                                                            </button>
                                                            <div class="dropdown-menu text-center p-1">
                                                                <!-- Dropdown menu links -->
                                                                <button  class="btn-link text-gray text-small" onclick="formularioPregunta({{$seccion->id}},{{$pregunta->id}},`{!! $pregunta->pregunta !!}`,'{{@$pregunta->descripcion??''}}')">
                                                                    <i class="fa fa-edit fs-6"></i> Editar
                                                                </button>
                                                                <button  class="btn-link text-danger text-small" data-bs-toggle="modal" data-bs-target="#modalEliminarPregunta"
                                                                         onclick="document.getElementById('idEliminarPregunta').value={{$pregunta->id}}"
                                                                >
                                                                    <i class="fas fa-trash-can fs-6"></i> Eliminar
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @isset($pregunta->descripcion)
                                                        <div class="col-md-11 offset-md-1 text-start">
                                                            <p class="text-small"><strong>Descripción: </strong>{{$pregunta->descripcion}}</p>
                                                        </div>
                                                    @endisset
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="row justify-content-end my-2">
                                    <div class="col-auto">
                                        <button class="btn btn-sm btn-danger" onclick="formularioPregunta({{$seccion->id}})" id="btnAgregarPregunta{{$seccion->id}}">Agregar pregunta</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                <div class="row text-start d-none" id="divFormularioPregunta">
                    <div class="col-12" id="tituloFormularioPregunta">Agregar pregunta</div>
                    <form action="{{route('formularios.preguntas.store')}}" method="post" class="necesita-validacion" novalidate id="formAgregarPregunta">
                        @csrf
                        <input type="hidden" name="formulario_id" value="{{$formulario->id}}">
                        <input type="hidden" name="seccion_id" id="pregunta_seccion_id">
                        <input type="hidden" name="pregunta_id" id="pregunta_id">
                        <div class="form-group">
                            <label for="pregunta">Pregunta *</label>
                            <textarea name="pregunta" id="pregunta" class="editor" required>{{old('pregunta')}}</textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="descripcion_pregunta">Descripción</label>
                            <input name="descripcion" type="text" class="form-control bg-white" placeholder="Escriba la descripción de la pregunta" id="descripcion_pregunta" maxlength="100">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group text-end mt-2">
                            <button type="button" class="btn btn-default me-2" onclick="cancelarAgregarPregunta()">Cancelar</button>
                            <button type="submit" class="btn btn-tertiary text-white">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>

            @if($formulario->estatus->codigo=='formulario_borrador')
                <div class="container mt-3">
                    <div class="mt-4 d-flex seccion-acciones justify-content-end gap-2 gap-md-3 flex-wrap flex-md-nowrap">
                        <div class="form-group mb-2 mb-md-0 w-100">
                            <a
                                @if($formulario->seccionesConPreguntas->count()!=$formulario->secciones->count()||$formulario->secciones->count()==0)
                                    data-bs-toggle="modal" data-bs-target="#modalFormularioIncompleto"
                                @elseif(isset($formularioActivo->id))
                                    data-bs-toggle="modal" data-bs-target="#modalFormularioExistente"
                                @else
                                    href="{{route('formularios.activar',$formulario->id)}}"
                                @endif
                               class="btn btn-accion-detalle bg-estatus-formulario_activo w-100">
                                Activar formulario
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        @include('admin.formularios.partials.modal_formulario_incompleto')
        @include('admin.formularios.partials.modal_formulario_existente')
        @include('admin.formularios.partials.modal_agregar_seccion')
        @include('admin.formularios.partials.modal_eliminar_seccion')
        @include('admin.formularios.partials.modal_eliminar_pregunta')
    @endif

@endsection
