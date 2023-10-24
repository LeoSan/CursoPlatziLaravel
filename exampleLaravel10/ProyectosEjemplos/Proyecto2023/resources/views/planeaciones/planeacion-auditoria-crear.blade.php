@extends('layouts.app')
@section('content')

    <nav aria-label="breadcrumb" class="py-1">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-small-size"><a href="#">Auditorías</a></li>
            <li class="breadcrumb-item font-small-size"><a class="text-graylight" href="{{ route('planeaciones') }}">Planeaciones anuales de auditorías</a></li>
            @if($planeacion->estatus->codigo === 'planeacion')
                <li class="breadcrumb-item font-small-size"><a class="text-graylight" href="{{ route('planeaciones.planeacion.auditoria.editar', ['id' => $planeacion]) }}">Planeación anual {{ @$planeacion->anio }}</a></li>
            @else
                <li class="breadcrumb-item font-small-size"><a class="text-graylight" href="{{ route('planeaciones.planeacion', ['id' => $planeacion]) }}">Planeación anual {{ @$planeacion->anio }}</a></li>
            @endif
            <li class="breadcrumb-item font-small-size active" aria-current="page">Auditorías</li>
        </ol>
    </nav>

    <form action="{{ route('planeaciones.planeacion.auditoria.create') }}" novalidate method="post" id="form_grupo_auditorias" class="d-block pb-4 necesita-validacion">
        @csrf
        @if(isset($planeacion))
            <input type="hidden" name="planeacion" id="planeacion" value="{{ $planeacion->id }}">
        @endif
        @if(isset($auditoria))
            <input type="hidden" name="auditoria" id="auditoria" value="{{ $auditoria->id }}">
        @endif
        <div>
            <h5 class="fw-semibold d-flex gap-3 align-items-end">
                <div class="">
                    Plan anual de auditorías {{ $planeacion->anio }}
                </div>
            </h5>
        </div>

        @include('planeaciones.partials.wizard', ['step' => 'auditorias'])

        <div class="bg-white px-4 py-4 my-4">

            <div class="d-flex w-100 justify-content-start">
                <h4 class="fw-semibold fs-5">Nuevo grupo de auditorías</h4>
            </div>

            <div class="row">
                <div class="form-group col-12 col-md-4 mb-3">
                    <label class="form-label" for="dom_departamento_id">Departamento *</label>
                    <select type="text" name="departamento_id" id="dom_departamento_id"
                            onchange="selectMunicipios(this,'dom_municipio_caso')" required
                            class="form-control form-select input-regular-height font-regular-size">
                        <option value="">Seleccione</option>
                        @foreach(getCatalogoElementos('departamentos') as $i)
                            <option value="{{$i->id}}" {{( @$auditoria->departamento_id == $i->id ? 'selected' : ( old('departamento_id') == $i->id ? 'selected' :'' ) )}} >
                                {{$i->nombre}}
                            </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" data-default="Este campo es obligatorio."></div>
                </div>

                <div class="form-group col-12 col-md-4 mb-3">
                    <label class="form-label" for="dom_municipio_caso">Municipio *</label>
                    <select type="text" name="municipio_id" id="dom_municipio_caso" required
                            onchange="selectOficinaRegional(this,'selOficinaDenuncia')"
                            class="form-control form-select input-regular-height font-regular-size">
                        <option value="">Seleccione un departamento</option>
                        @if(isset($municipios))
                            @foreach($municipios as $item)
                                <option value="{{ $item->id }}" {{( @$auditoria->municipio_id == $item->id ? 'selected' : ( old('municipio_id') == $i->id ? 'selected' :'' ) )}} >
                                    {{ $item->nombre }}
                                </option>
                            @endforeach
                        @else
                            @foreach(getCatalogoElementos('municipios') as $i)
                                <option value="{{$i->id}}" {{( @$auditoria->municipio_id == $i->id ? 'selected' : ( old('municipio_id') == $i->id ? 'selected' :'' ) )}} >
                                    {{$i->nombre}}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    <div class="invalid-feedback" data-default="Este campo es obligatorio."></div>
                </div>

                <div class="form-group col-12 col-md-4">
                    <label for="selOficinaDenuncia" class="form-label">Oficina Regional</label>
                    <select id="selOficinaDenuncia" name="oficina_regional_id" class="form-select campo-dis input-regular-height form-select-regional" aria-label="Default select example" disabled>
                        <option value=""></option>
                        @if(@$auditoria->region)
                            <option value="{{ $auditoria->region->id }}" selected>
                                {{ $auditoria->region->nombre }}
                            </option>
                        @endif
                    </select>
                    <div class="invalid-feedback" data-default="Este campo es obligatorio."></div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-12 col-md-6 mb-3">
                    <label class="form-label" for="tipo_inspeccion_id">Tipo de inspección *</label>
                    <select type="text" name="tipo_inspeccion_id" id="tipo_inspeccion_id" required
                            class="form-control form-select input-regular-height font-regular-size">
                        <option value="">Seleccione</option>
                        @foreach($tipos_inspeccion as $item)
                            <option value="{{ $item->id }}" {{( @$auditoria->tipo_inspeccion_id == $item->id ? 'selected' : ( old('tipo_inspeccion_id') == $i->id ? 'selected' :'' ) )}} >
                                {{ $item->nombre }}
                            </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" data-default="Este campo es obligatorio."></div>
                </div>

                <div class="form-group col-12 col-md-6 mb-3">
                    <label class="form-label" for="cafta">CAFTA *</label>
                    <select type="text" name="cafta" id="cafta" required
                            class="form-control form-select input-regular-height font-regular-size">
                        <option value="">Seleccione</option>
                        <option value="Si" {{( @$auditoria->cafta == 'Si' ? 'selected' : ( old('cafta') == 'Si' ? 'selected' :'' ) )}} >
                            Sí
                        </option>
                        <option value="No" {{( @$auditoria->cafta == 'No' ? 'selected' : ( old('cafta') == 'No' ? 'selected' :'' ) )}} >
                            No
                        </option>
                    </select>
                    <div class="invalid-feedback" data-default="Este campo es obligatorio."></div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-12 col-md-6 mb-3">
                    <label class="form-label" for="actividad_economica_id">Actividad económica *</label>
                    <select type="text" name="actividad_economica_id" id="actividad_economica_id" required
                            class="form-control form-select input-regular-height font-regular-size">
                        <option value="">Seleccione</option>
                        @foreach($actividades_economicas as $item)
                            <option value="{{ $item->id }}" {{( @$auditoria->actividad_economica_id == $item->id ? 'selected' : ( old('actividad_economica_id') == $i->id ? 'selected' :'' ) )}} >
                                {{ $item->nombre }}
                            </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" data-default="Este campo es obligatorio."></div>
                </div>

                <div class="form-group col-12 col-md-6 mb-3">
                    <label class="form-label" for="auditor_responsable_id">Auditor responsable *</label>
                    <select type="text" name="auditor_responsable_id" id="auditor_responsable_id" required
                            class="form-control form-select input-regular-height font-regular-size">
                        <option value="">Seleccione</option>
                        @foreach($auditores as $item)
                            <option value="{{ $item->id }}" {{( @$auditoria->auditor_responsable_id == $item->id ? 'selected' : ( old('auditor_responsable_id') == $i->id ? 'selected' :'' ) )}} >
                                {{ $item->complete_name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" data-default="Este campo es obligatorio."></div>
                </div>
            </div>

        </div>

        <div class="d-flex justify-content-between my-4">
            <a href="{{ route('planeaciones.planeacion.auditorias', $planeacion->id) }}" class="btn btn-default input-regular-height align-items-center d-flex gap-2">
                <i class="fas fa-arrow-circle-left"></i>
                <span>Cancelar</span>
            </a>

            <button type="submit" class="btn btn-tertiary input-regular-height align-items-center d-flex gap-2">
                <span>Continuar</span>
                <i class="fas fa-arrow-circle-right"></i>
            </button>
        </div>

    </form>

    <div class="modal fade" id="duplicatedModal" tabindex="-1" aria-labelledby="duplicatedModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white px-3 py-2">
                    <h5 class="modal-title fs-6 fw-semibold" id="duplicatedModalLabel">Registrar grupo de auditorías</h5>
                    <button type="button" class="text-white" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="" id="duplicateModalMessage"></p>
                    <p class="p-0 m-0">
                        ¿Desea continuar?
                    </p>
                </div>
                <div class="modal-footer pt-0 pb-2 border-0">
                    <button type="button" class="btn btn-secondary py-2 rounded-1" data-bs-dismiss="modal">
                        No
                    </button>
                    <button type="button" id="launch_form_grupo_auditorias" class="btn btn-warning py-2 rounded-1">
                        Sí, continuar
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
