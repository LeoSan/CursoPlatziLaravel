@extends('layouts.app')
@section('content')

    <div class="container">

        <x-bread-crumbs :itemsbread="$itemsbread" />

        <div class="d-flex mb-2 align-items-center mb-4">
            <div class="form-group">
                <h5 class="fw-semibold m-0 p-0 ">
                    Denuncia {{$denuncia->folio}}
                </h5>
            </div>
            <div class="form-group">
                <div class="fw-normal text-graylight d-none d-md-inline px-2">|</div>
            </div>
            <div class="form-group">
                @include('partials.estatus', ['estatus' => $denuncia->estatus])
            </div>
        </div>

        <div class="card bg-white">
            <div class="card-header fw-semibold fs-5">
                <small>
                    @if($denuncia->informe?->comentarios) Atender comentarios de @else Cargar @endif informe de denuncia
                </small>
            </div>
            <div class="card-body">
                <form action="{{ route('denuncias.informe.procesar') }}" method="post" class="d-block pb-4 necesita-validacion" onsubmit="validarFormulario()" novalidate enctype="multipart/form-data">
                    @csrf
                    @if($denuncia->informe?->comentarios)
                    @endif
                    <input type="hidden" name="actualizacion" value="{{ (bool)$denuncia->informe?->comentarios }}">
                    <input type="hidden" name="denuncia" value="{{ $denuncia->id }}">

                    <div class="bg-white px-1 py-2">

                        <div class="row">
                            <div class="form-group col-12 col-md-6 col-lg-5 col-xl-4 mb-4">
                                @include('components.carga-archivos', ['codigo'=>'informe_denuncia','nombre' => 'Informe de denuncia', 'required' => true, 'eliminable' => true, 'entidad' => null])
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" name="visita_campo" id="visita_campo">
                                    <label class="form-check-label" for="visita_campo">
                                        Se realiza visita en campo
                                    </label>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="form-group col-md-12 mb-3">
                                <label class="form-label" for="observaciones">Observaciones</label>
                                <textarea type="text" name="observaciones" class="form-control font-regular-size editor"
                                          rows="7" maxlength="1700" id="observaciones"
                                          placeholder="Escriba las observaciones"></textarea>
                                <div class="invalid-feedback">Este campo debe tener máximo 1700 caracteres.</div>
                            </div>
                        </div>

                    </div>

                    <div class="mt-4 d-flex seccion-acciones w-100 justify-content-end gap-2 gap-md-3 flex-wrap flex-md-nowrap">
                        <div class="form-group mb-2 mb-md-0 w-100">
                            <a class="btn btn-accion-detalle btn-default w-100" href="{{ route('denuncias.detalle', ['id' => $denuncia->id]) }}">
                                Cancelar
                            </a>
                        </div>
                        <div class="form-group mb-2 mb-md-0 w-100">
                            <button type="submit" class="btn btn-accion-detalle btn-success w-100">
                                @if($denuncia->informe?->comentarios)
                                    <span class="">Enviar correcciones</span>
                                @else
                                    <span class="">Enviar a revisión</span>
                                @endif
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>


    </div>{{-- Cierre - content - detalle  --}}

@endsection

