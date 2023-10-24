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
                    Comentar informe de denuncia
                </small>
            </div>
            <div class="card-body">
                <form action="{{ route('denuncias.informe.comentar') }}" method="post" class="d-block pb-4 necesita-validacion" onsubmit="validarFormulario()" novalidate enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="denuncia" value="{{ $denuncia->id }}">
                    <input type="hidden" name="informe" value="{{ $informe->id }}">

                    <div class="bg-white px-1 py-2">
                        <div class="row mb-1">
                            @if($informe->documentos?->count())
                                @foreach($informe->documentos as $documento)
                                    <div class="mb-3 col-sm-8 col-md-6 col-lg-4 col-xl-3">
                                        <h5 class="fw-bold font-small-size">Documento</h5>
                                        <div
                                            class=" d-flex btn-file py-3 px-3 text-decoration-none rounded-2 mt-2">
                                            <div class="d-flex w-100 justify-content-between align-items-center">
                                                <div class="d-inline">
                                                    <div class="d-inline">
                                                        <a href="{{url('archivos/descarga/'.$documento->ruta)}}"
                                                           class="enlace">{{ $documento->descripcion  }}
                                                            <svg class="m-1" width="21" height="21" viewBox="0 0 21 21"
                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M10.5 11.25h3.75v2.25H10.5v-2.25zM9 10.5a.75.75 0 0 1 .75-.75h4.5V7.5h-7.5v6H9v-3zm12 0C21 16.29 16.29 21 10.5 21S0 16.29 0 10.5 4.71 0 10.5 0 21 4.71 21 10.5zm-5.25-3.75A.75.75 0 0 0 15 6H6a.75.75 0 0 0-.75.75v7.5c0 .414.335.75.75.75h9a.75.75 0 0 0 .75-.75v-7.5z"
                                                                    fill="#1C1C28" fill-rule="nonzero"/>
                                                            </svg>
                                                            <span class="d-flex fw-bold f-10">{{ $documento->nombre }}</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div class="item mb-4">
                            <div class="">
                                @if($informe->visita_campo)
                                    <i class="fa-solid fa-check text-success fs-6 me-1"></i>
                                @else
                                    <i class="fa-solid fa-xmark text-danger fs-6 me-1"></i>
                                @endif
                                <span class="fw-bold font-small-size">
                            Se realizó visita en campo
                        </span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h5 class="fw-bold font-small-size">
                                Observaciones
                            </h5>
                            <div class="mb-4 font-regular-size">
                                @if($informe->observaciones)
                                    {!! $informe->observaciones !!}
                                @else
                                    Dato no proporcionado
                                @endif
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="form-group col-md-12 mb-4">
                                <label class="form-label" for="comentarios">Comentarios *</label>
                                <textarea type="text" name="comentarios" class="form-control font-regular-size editor"
                                          rows="7" maxlength="1700" id="comentarios" required
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
                                <span class="">Enviar comentarios</span>
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>


    </div>{{-- Cierre - content - detalle  --}}

@endsection

