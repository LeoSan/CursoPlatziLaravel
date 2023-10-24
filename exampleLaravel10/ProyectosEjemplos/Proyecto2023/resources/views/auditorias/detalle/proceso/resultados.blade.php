@extends('auditorias.detalle.proceso.layout')
@section('content-ejecucion')
    <div class="bg-white px-0 py-0">
        <div class="accordion border-0" id="accordionPanelsStayOpenExample">
            @if($ejecucion->estatus->codigo === 'proceso')
            @include('auditorias.detalle.proceso.finalizar-sin-ejecucion', ['ejecucion' => $ejecucion ])
                <div class="accordion-item border-0 border-bottom">
                <h2 class="accordion-header border-0" id="panelsStayOpen-headingOne">
                    <button
                        class="accordion-button px-3 py-0 bg-white rounded-0 @if( $ejecucion->resultados->count() && !request()->has('plantilla') ) collapsed @endif"
                        type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne"
                        aria-expanded="@if( !$ejecucion->resultados->count() || request()->has('plantilla') ) true @else false @endif"
                        aria-controls="panelsStayOpen-collapseOne">
                        <h5 class="py-3 m-0 fw-semibold">
                            Crear nuevo registro de resultados
                        </h5>
                    </button>
                </h2>
                <div id="panelsStayOpen-collapseOne"
                     class="accordion-collapse collapse @if( !$ejecucion->resultados->count() || request()->has('plantilla') ) show @endif"
                     aria-labelledby="panelsStayOpen-headingOne">
                    <div class="accordion-body bg-white py-3 px-3">
                        @if($ejecucion->resultados->count())
                            <div class="pt-2">
                                <p class="fs-6">
                                    Para agregar un documento nuevo es necesario eliminar el que ya se ha creado.
                                </p>
                                <p class="fs-6">
                                    Por favor elimine el archivo en la siguiente tabla <b class="fw-semibold">"Documento cargado"</b> y regrese a esta sección.
                                </p>
                            </div>
                        @else
                        <form action="{{ route('auditorias.store.plantilla') }}" method="post" class="row necesita-validacion" novalidate>
                            @csrf
                            <input type="hidden" name="seccion_id" value="{{ $seccion->id }}">
                            <input type="hidden" name="ejecucion_id" value="{{ $ejecucion->id }}">
                            <div class="form-group col-md-6 mb-3">
                                <label for="plantilla" class="form-label">Plantilla *</label>
                                <select id="plantilla" name="plantilla_id" class="form-select input-regular-height bg-white"
                                        data-seccion="resultados-preliminares" data-ejecucion="{{ $ejecucion->id }}"
                                        aria-label="Seleccione una plantilla" required
                                        onchange="cargarPlantilla(this)">
                                    <option value="">Seleccione una plantilla</option>
                                    @foreach($plantillas as $plantilla)
                                        <option value="{{ $plantilla->id }}" @if($loop->first) selected @endif
                                                @if(isset($plantillaSeleccionada) && $plantillaSeleccionada->id === $plantilla->id) selected @endif>{{ $plantilla->nombre }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                            </div>

                            @php($primerPlantilla = $plantillas->first())
                            <div class="form-group col-md-12 mb-3">
                                <label class="form-label" for="contenido">Registro de resultados preliminares *</label>
                                <textarea type="text" name="contenido" class="form-control font-regular-size editor-sin-limite"
                                          rows="10" required id="contenido" maxlength="50000"
                                          placeholder="Contenido del registro">{{ $primerPlantilla ? $primerPlantilla->contenido : @$plantillaSeleccionada->contenido }}</textarea>
                                <div class="invalid-feedback" data-default="Dato obligatorio."></div>
                            </div>

                            <div class="form-group col-md-12 text-end">
                                <button type="submit" class="btn btn-success input-regular-height">Guardar registro</button>
                            </div>
                        </form>
                        @endif
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
                            Documento cargado
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
                                    <th class="text-start ps-4">Documento</th>
                                    <th class="text-start">PDF</th>
                                    <th class="text-start">DOC</th>
                                    <th class="text-start">Archivo firmado</th>
                                    <th class="text-start pe-4">Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($ejecucion->resultados as $registo)
                                    <tr>
                                        <td class="bg-white text-start border-0 align-middle ps-4">
                                            Resultados preliminares
                                        </td>

                                        <td class="bg-white text-start align-middle border-0">
                                            <a href="{{ route('auditorias.plantilla.pdf', ['id' => $registo->id]) }}"
                                               class="text-decoration-none text-primary" target="_blank">
                                                <i class="fas fa-download"></i>
                                                <span class="text-decoration-underline">Descargar</span>
                                            </a>
                                        </td>

                                        <td class="bg-white text-start align-middle border-0">
                                            <a href="{{ route('auditorias.plantilla.doc', ['id' => $registo->id]) }}"
                                               class="text-decoration-none text-primary" target="_blank">
                                                <i class="fas fa-download"></i>
                                                <span class="text-decoration-underline">Descargar</span>
                                            </a>
                                        </td>

                                        <td class="bg-white text-start align-middle border-0">
                                            @if($ejecucion->estatus->codigo === 'proceso' && $registo->documento == null)
                                                <a href="#!" class="text-decoration-none text-success"
                                                   data-bs-toggle="modal" data-bs-target="#fileModal"
                                                   data-plantilla="{{ $registo->id }}" onclick="cargarPlantillaFirmada(this)">
                                                    <i class="fas fa-file-upload"></i>
                                                    <span class="text-decoration-underline">Cargar archivo firmado</span>
                                                </a>
                                            @elseif($registo->documento != null)
                                                <a href="{{url('archivos/descarga/'.$registo->documento?->ruta)}}" target="_blank"
                                                   class="text-decoration-none text-primary">
                                                    <i class="fas fa-eye"></i>
                                                    <span class="text-decoration-underline">Ver</span>
                                                </a>
                                            @endif
                                            @if($ejecucion->estatus->codigo === 'proceso' && $registo->documento != null)
                                                <a href="#" class="text-decoration-none text-danger ms-2"
                                                   data-bs-toggle="modal" data-bs-target="#deleteFirmaModal"
                                                   data-plantilla="{{ $registo->id }}"
                                                   data-nombre="Resultados preliminares"
                                                   onclick="eliminarPlantillaFirmada(this)">
                                                    <i class="fas fa-trash"></i>
                                                    <span class="text-decoration-underline">Eliminar</span>
                                                </a>
                                            @endif
                                        </td>
                                        <td class="bg-white text-start align-middle border-0 pe-4">
                                            @if($ejecucion->estatus->codigo === 'proceso')
                                                <a href="#!" class="text-decoration-none text-danger"
                                                   data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                   data-plantilla="{{ $registo->id }}"
                                                   data-nombre="Resultados preliminares"
                                                   onclick="eliminarPlantilla(this)">
                                                    <i class="fas fa-trash-alt"></i>
                                                    <span class="text-decoration-underline">Eliminar</span>
                                                </a>
                                            @else
                                                <span class="text-graylight">Acciones no disponibles</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12" class="bg-white border-0">
                                            Aun no existe registro de Resultados preliminares en esta auditoría
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
        <a href="{{ route('auditorias.ejecucion.proceso.cedulas', ['ejecucion' => $ejecucion]) }}" class="btn btn-default input-regular-height align-items-center d-flex gap-2">
            <i class="fas fa-arrow-circle-left"></i>
            <span>Regresar</span>
        </a>

        <a href="{{ route('auditorias.ejecucion.proceso.cierre', ['ejecucion' => $ejecucion]) }}" class="btn btn-tertiary input-regular-height align-items-center d-flex gap-2">
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
                        @include('components.carga-archivos', ['en_columnas'=>false, 'codigo' => 'auditoria_plantilla_firmada', 'nombre'=>'Cargar el documento de resultado firmado','entidad' => null,'eliminable'=>true, 'required'=>true, 'accept' => '.jpg,.jpeg,.png,.heic,.pdf'])
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
                        ¿Desea eliminar el registro de
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
                        ¿Desea eliminar el archivo firmado cargado al registro de resultados
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
