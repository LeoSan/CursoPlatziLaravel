@extends('auditorias.detalle.proceso.layout')
@section('content-ejecucion')
    <div class="bg-white px-0 py-0">
        <div class="accordion border-0" id="accordionPanelsStayOpenExample">
            @if($ejecucion->estatus->codigo === 'proceso')
                @include('auditorias.detalle.proceso.finalizar-sin-ejecucion', ['ejecucion' => $ejecucion ])
                <div class="accordion-item border-0 border-bottom">
                <h2 class="accordion-header border-0" id="panelsStayOpen-headingOne">
                    <button
                        class="accordion-button px-3 py-0 bg-white rounded-0 @if( $ejecucion->cedulas->count() && !request()->has('plantilla') ) collapsed @endif"
                        type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne"
                        aria-expanded="@if( !$ejecucion->cedulas->count() || request()->has('plantilla') ) true @else false @endif"
                        aria-controls="panelsStayOpen-collapseOne">
                        <h5 class="py-3 m-0 fw-semibold">
                            Crear nueva cédula de trabajo
                        </h5>
                    </button>
                </h2>
                <div id="panelsStayOpen-collapseOne"
                     class="accordion-collapse collapse @if( !$ejecucion->cedulas->count() || request()->has('plantilla') ) show @endif"
                     aria-labelledby="panelsStayOpen-headingOne">
                    <div class="accordion-body bg-white py-3 px-3">
                        <form action="{{ route('auditorias.store.plantilla') }}" method="post" class="row necesita-validacion" novalidate>
                            @csrf
                            <input type="hidden" name="seccion_id" value="{{ $seccion->id }}">
                            <input type="hidden" name="ejecucion_id" value="{{ $ejecucion->id }}">
                            <div class="form-group col-md-6 mb-3">
                                <label for="plantilla" class="form-label">Plantilla *</label>
                                <select id="plantilla" name="plantilla_id" class="form-select input-regular-height bg-white"
                                        data-seccion="cedulas-trabajo" data-ejecucion="{{ $ejecucion->id }}"
                                        aria-label="Seleccione una plantilla" required
                                        onchange="cargarPlantilla(this)">
                                    <option value="">Seleccione una plantilla</option>
                                    @foreach($plantillas as $plantilla)
                                        <option value="{{ $plantilla->id }}" @if(!$plantillaSeleccionada && $loop->first) selected @endif
                                                @if(isset($plantillaSeleccionada) && $plantillaSeleccionada->id === $plantilla->id) selected @endif>{{ $plantilla->nombre }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="identificador" class="form-label bg-white">Nombre de la cédula *</label>
                                <input type="text" id="identificador" name="identificador" required
                                       class="form-control input-regular-height bg-white"/>
                                <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                            </div>

                            @php($primerPlantilla = $plantillas->first())
                            <div class="form-group col-md-12 mb-3">
                                <label class="form-label" for="contenido">Cédula de trabajo *</label>
                                <textarea type="text" name="contenido" class="form-control font-regular-size editor-sin-limite"
                                          rows="10" required id="contenido" maxlength="50000"
                                          placeholder="Contenido de la cédula">{{ $primerPlantilla ? $primerPlantilla->contenido : @$plantillaSeleccionada->contenido }}</textarea>
                                <div class="invalid-feedback" data-default="Dato obligatorio."></div>
                            </div>

                            <div class="form-group col-md-12 text-end">
                                <button type="submit" class="btn btn-success input-regular-height">Guardar cédula
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif
            <div class="accordion-item border-0">
                <h2 class="accordion-header border-0" id="panelsStayOpen-headingTwo">
                    <button class="accordion-button px-3 py-0 bg-white rounded-0" type="button"
                            data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="true"
                            aria-controls="panelsStayOpen-collapseTwo">
                        <h5 class="py-3 m-0 fw-semibold">
                            Cédulas de trabajo
                        </h5>
                    </button>
                </h2>
                <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show"
                     aria-labelledby="panelsStayOpen-headingTwo">
                    <div class="accordion-body bg-white px-3 py-2">
                        <div class="col-12 table-responsive">
                            <table class="table text-center tabla-pgr m-0">
                                <thead class="mb-2">
                                <tr class="">
                                    <th class="text-start ps-4">Nombre</th>
                                    <th class="text-start">PDF</th>
                                    <th class="text-start">DOC</th>
                                    <th class="text-start">Archivo firmado</th>
                                    @if($ejecucion->estatus->codigo === 'proceso')
                                        <th class="text-start pe-4">Acciones</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($ejecucion->cedulas as $cedula)
                                    <tr>
                                        <td class="bg-white text-start border-0 align-middle ps-4">
                                            {{ $cedula->identificador ?? 'Cédula de trabajo' }}
                                        </td>

                                        <td class="bg-white text-start align-middle border-0">
                                            <a href="{{ route('auditorias.plantilla.pdf', ['id' => $cedula->id]) }}"
                                               class="text-decoration-none text-primary" target="_blank">
                                                <i class="fas fa-download"></i>
                                                <span class="text-decoration-underline">Descargar</span>
                                            </a>
                                        </td>

                                        <td class="bg-white text-start align-middle border-0">
                                            <a href="{{ route('auditorias.plantilla.doc', ['id' => $cedula->id]) }}"
                                               class="text-decoration-none text-primary" target="_blank">
                                                <i class="fas fa-download"></i>
                                                <span class="text-decoration-underline">Descargar</span>
                                            </a>
                                        </td>

                                        <td class="bg-white text-start align-middle border-0">
                                            @if($ejecucion->estatus->codigo === 'proceso' && $cedula->documento == null)
                                                <a href="#!" class="text-decoration-none text-success"
                                                   data-bs-toggle="modal" data-bs-target="#fileModal"
                                                   data-plantilla="{{ $cedula->id }}" onclick="cargarPlantillaFirmada(this)">
                                                    <i class="fas fa-file-upload"></i>
                                                    <span class="text-decoration-underline">Cargar archivo firmado</span>
                                                </a>
                                            @elseif($cedula->documento != null)
                                                <a href="{{url('archivos/descarga/'.$cedula->documento?->ruta)}}" target="_blank"
                                                   class="text-decoration-none text-primary">
                                                    <i class="fas fa-eye"></i>
                                                    <span class="text-decoration-underline">Ver</span>
                                                </a>
                                            @endif
                                            @if($ejecucion->estatus->codigo === 'proceso' && $cedula->documento != null)
                                                <a href="#" class="text-decoration-none text-danger ms-2"
                                                   data-bs-toggle="modal" data-bs-target="#deleteFirmaModal"
                                                   data-plantilla="{{ $cedula->id }}"
                                                   data-nombre="{{ $cedula->identificador }}"
                                                   onclick="eliminarPlantillaFirmada(this)">
                                                    <i class="fas fa-trash"></i>
                                                    <span class="text-decoration-underline">Eliminar</span>
                                                </a>
                                            @endif
                                        </td>
                                        @if($ejecucion->estatus->codigo === 'proceso')
                                        <td class="bg-white text-start align-middle border-0 pe-4">
                                            <a href="#!" class="text-decoration-none text-danger"
                                               data-bs-toggle="modal" data-bs-target="#deleteModal"
                                               data-plantilla="{{ $cedula->id }}"
                                               data-nombre="{{ $cedula->identificador }}"
                                               onclick="eliminarPlantilla(this)">
                                                <i class="fas fa-trash-alt"></i>
                                                <span class="text-decoration-underline">Eliminar</span>
                                            </a>
                                        </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12" class="bg-white border-0">
                                            Aun no existen cédulas guardadas en esta auditoría
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="d-flex justify-content-between my-4">
        <a href="{{ route('auditorias.ejecucion.proceso.lista', ['ejecucion' => $ejecucion]) }}"
           class="btn btn-default input-regular-height align-items-center d-flex gap-2">
            <i class="fas fa-arrow-circle-left"></i>
            <span>Regresar</span>
        </a>

        <a href="{{ route('auditorias.ejecucion.proceso.resultados', ['ejecucion' => $ejecucion]) }}"
           class="btn btn-tertiary input-regular-height align-items-center d-flex gap-2">
            @if($ejecucion->estatus->codigo === 'proceso')
                <span>Continuar</span>
            @else
                <span>Siguiente</span>
            @endif
            <i class="fas fa-arrow-circle-right"></i>
        </a>
    </div>

    @if($ejecucion->estatus->codigo === 'proceso')
        <div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
            <form action="{{ route('auditorias.store.plantilla.firma') }}" method="post" class="modal-dialog"
                  enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="seccion_id" value="{{ $seccion->id }}">
                <input type="hidden" id="file_plantilla_id" name="plantilla_id" value="">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white px-3 py-2">
                        <h5 class="modal-title fs-6 fw-semibold" id="fileModalLabel">Agregar archivo firmado</h5>
                        <button type="button" class="text-white" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa-solid fa-circle-xmark"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        @include('components.carga-archivos', ['en_columnas'=>false, 'codigo' => 'auditoria_plantilla_firmada', 'nombre'=>'Cargar la cédula de trabajo firmada','entidad' => null,'eliminable'=>true, 'required'=>true, 'accept' => '.jpg,.jpeg,.png,.heic,.pdf'])
                    </div>
                    <div class="modal-footer pt-0 pb-2 border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <form action="{{ route('auditorias.delete.plantilla') }}" method="post" class="modal-dialog">
                @csrf
                <input type="hidden" id="delete_plantilla_id" name="plantilla_id" value="">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white px-3 py-2">
                        <h5 class="modal-title fs-6 fw-semibold" id="deleteModalLabel">Eliminar registro</h5>
                        <button type="button" class="text-white" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa-solid fa-circle-xmark"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        ¿Desea eliminar la cédula de trabajo
                        <strong class="fw-semibold" id="delete_plantilla_nombre"></strong>?
                    </div>
                    <div class="modal-footer pt-0 pb-2 border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="modal fade" id="deleteFirmaModal" tabindex="-1" aria-labelledby="deleteModalLabel"
             aria-hidden="true">
            <form action="{{ route('auditorias.delete.plantilla.firma') }}" method="post" class="modal-dialog">
                @csrf
                <input type="hidden" id="delete_plantilla_firma_id" name="plantilla_id" value="">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white px-3 py-2">
                        <h5 class="modal-title fs-6 fw-semibold" id="deleteModalLabel">Eliminar archivo firmado</h5>
                        <button type="button" class="text-white" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa-solid fa-circle-xmark"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        ¿Desea eliminar el archivo firmado cargado a la cédula de trabajo
                        <strong class="fw-semibold" id="delete_plantilla_firma_nombre"></strong>?
                    </div>
                    <div class="modal-footer pt-0 pb-2 border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </div>
                </div>
            </form>
        </div>
    @endif
@endsection
