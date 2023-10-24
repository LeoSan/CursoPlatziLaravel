@extends('auditorias.detalle.proceso.layout')
@section('content-ejecucion')
    <div class="bg-white px-3 pt-3 pb-4">
        @if($ejecucion->estatus->codigo === 'proceso')
            @include('auditorias.detalle.proceso.finalizar-sin-ejecucion', ['ejecucion' => $ejecucion ])
        @endif
        <h5 class="py-2 fw-semibold text-gray">
            Lista de verificacion
        </h5>
        <div class="contenido">
            @if(!$formulario)
                <div class="col-md-12">
                    <div class="p-2 border-info text-bluedark">
                        <i class="fa fa-info-circle text-bluedark text-bluedark"></i>
                        <small>
                            No existe un formulario para este tipo de inspección.
                        </small>
                    </div>
                </div>
            @else
                <form action="{{route('auditorias.ejecucion.proceso.storeLista',$ejecucion)}}" method="post" class="row necesita-validacion" id="form_lista_verificacion" novalidate>
                @csrf
                <div class="form-group mb-2">
                    <label for="proposito">Propósito *</label>
                    @if($ejecucion->estatus->codigo=='proceso')
                        <textarea name="proposito_lista" id="proposito" class="editor editor-sm" data-maxlength="512" required>{{@$ejecucion->proposito_lista}}</textarea>
                        <div class="invalid-feedback"></div>
                    @elseif($ejecucion->proposito_lista)
                        {!!$ejecucion->proposito_lista!!}
                    @else
                        <p>Dato no proporcionado</p>
                    @endif
                </div>
                <div class="form-group">
                    <label for="fuentes_informacion">Fuentes de información *</label>
                    @if($ejecucion->estatus->codigo=='proceso')
                        <textarea name="fuentes_lista" id="fuentes_informacion" class="editor editor-sm" data-maxlength="512" required>{{@$ejecucion->fuentes_lista}}</textarea>
                        <div class="invalid-feedback"></div>
                    @elseif($ejecucion->fuentes_lista)
                        {!!$ejecucion->fuentes_lista!!}
                    @else
                        <p>Dato no proporcionado</p>
                    @endif
                </div>
                <div class="col-md-12 mt-2">
                    @if($ejecucion->auditoria_no_ejecutada)
                        <div class="col-md-12">
                            <div class="p-2 border-info text-bluedark">
                                <i class="fa fa-info-circle text-bluedark text-bluedark"></i>
                                <small>
                                    No existe una lista de verificación en esta auditoría.
                                </small>
                            </div>
                        </div>
                    @else
                        @foreach($formulario->secciones as $seccion)
                            <table class="table tabla-pgr">
                                <thead>
                                    <tr>
                                        <th>{{$seccion->nombre}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($seccion->preguntas as $k=>$pregunta)
                                        <tr>
                                            <td>
                                                <div class="row">
                                                    <div class="{{$ejecucion->estatus->codigo=='proceso'?'col-md-6':'col-md-8'}}">
                                                        {!! $pregunta->pregunta !!}
                                                    </div>
                                                    <div class="{{$ejecucion->estatus->codigo=='proceso'?'col-md-6':'col-md-4'}}">
                                                        @if($ejecucion->estatus->codigo=='proceso')
                                                            <div class="form-group row">
                                                                <div class="col-md-4">
                                                                    <div class="form-check d-flex justify-content-center">
                                                                        <input class="form-check-input" type="radio" name="preguntas[{{$pregunta->id}}][respuesta]" value="cumplio" id="cumplio_{{$pregunta->id}}"
                                                                        {{@$respuestas[$pregunta->id]->respuesta=='cumplio'?'checked':''}}>
                                                                        <label for="cumplio_{{$pregunta->id}}" class="text-gray fw-normal ms-1">Cumplió</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-check d-flex justify-content-center">
                                                                        <input class="form-check-input" type="radio" name="preguntas[{{$pregunta->id}}][respuesta]" value="no_cumplio" id="no_cumplio_{{$pregunta->id}}"
                                                                        {{@$respuestas[$pregunta->id]->respuesta=='no_cumplio'?'checked':''}}>
                                                                        <label for="no_cumplio_{{$pregunta->id}}" class="text-gray fw-normal ms-1">No cumplió</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-check d-flex justify-content-center">
                                                                        <input class="form-check-input" type="radio" name="preguntas[{{$pregunta->id}}][respuesta]" value="no_aplica" id="na_{{$pregunta->id}}"
                                                                        {{@$respuestas[$pregunta->id]->respuesta=='no_aplica'?'checked':''}}>
                                                                        <label for="na_{{$pregunta->id}}" class="text-gray fw-normal ms-1">No aplica</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 text-center invalid-feedback" data-default="Seleccione una opción"></div>
                                                                <div class="col-12 border-top mt-2 pt-2">
                                                                    <div class="form-group">
                                                                        <label for="">Observaciones:</label>
                                                                        <textarea maxlength="256" name="preguntas[{{$pregunta->id}}][observaciones]" rows="2" class="form-control form-control-sm w-100">{{@$respuestas[$pregunta->id]->observaciones}}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="row">
                                                                <div class="col-12 text-center">
                                                                    <label for="">
                                                                        @switch(@$respuestas[$pregunta->id]->respuesta)
                                                                            @case('cumplio')
                                                                                Cumplió
                                                                            @break
                                                                            @case('no_cumplio')
                                                                                No cumplió
                                                                            @break
                                                                            @case('no_aplica')
                                                                                No aplica
                                                                            @break
                                                                        @endswitch
                                                                    </label>
                                                                </div>
                                                                @if(@$respuestas[$pregunta->id]->observaciones)
                                                                    <div class="col-12 text-center border-top mt-2 pt-2">
                                                                        <label for="">Observaciones</label>
                                                                        <p>{{$respuestas[$pregunta->id]->observaciones}}</p>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endforeach
                    @endif
                </div>
            </form>
            @endif
        </div>
    </div>

    <div class="d-flex justify-content-between my-4">
        <a href="{{ route('auditorias.ejecucion.detalle', ['ejecucion' => $ejecucion]) }}" class="btn btn-default input-regular-height align-items-center d-flex gap-2">
            <i class="fas fa-arrow-circle-left"></i>
            <span>Cancelar</span>
        </a>

        @if($ejecucion->estatus->codigo=='proceso' && $formulario)
            <button type="submit" form="form_lista_verificacion" class="btn btn-tertiary input-regular-height align-items-center d-flex gap-2">
                <span>Guardar y continuar</span>
                <i class="fas fa-arrow-circle-right"></i>
            </button>
        @else
            <a href="{{ route('auditorias.ejecucion.proceso.cedulas', ['ejecucion' => $ejecucion]) }}" class="btn btn-tertiary input-regular-height align-items-center d-flex gap-2">
                <span>Siguiente</span>
                <i class="fas fa-arrow-circle-right"></i>
            </a>
        @endif
    </div>
@endsection
