@extends('layouts.app')
@section('content')
    <x-bread-crumbs :itemsbread="$itemsbread"/>

    <div class="container title-principal mb-3 detalle-denuncia">
        <div class="row mb-4">
            <div class="col d-flex flex-row">
                <div>Denuncia {{$denuncia->folio}}</div>
                <div class="d-flex flex-row">
                    <div> &nbsp; | &nbsp;</div>
                    <div class="icon-status bg-estatus-{{ $denuncia->estatus->codigo}}"></div>
                    <div class="text-estatus-{{$denuncia->estatus->codigo}} fw-bolder" >{{$denuncia->estatus->nombre}}</div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card bg-white">
                    <div class="card-header">Alta de la denuncia</div>
                    <div class="card-body">
                        <form action="{{route('denuncias.guardar.alta')}}" id="form_alta_denuncia" class="form-air necesita-validacion" method="POST" autocomplete="off" accept-charset="UTF-8" enctype="multipart/form-data" novalidate onsubmit="validarFormulario(event)">
                            @csrf
                            <input id="inpHiDenunciaId" name="denuncia_id" type="hidden" value="{{$denuncia->id}}" />
                            <input id="inpHiExpedienteUsuarioId" name="expediente_usuario_id" type="hidden" value="{{$usuario_asignado_id}}" />
                            <input id="inpHiNum_expediente" name="num_expediente" type="hidden" value="{{$num_exp}}" />
                                <div class="row form-group mb-3">
                                    <div class="col">
                                        <label for="inpDato" class="form-label">Número de expediente ATI</label>
                                        <input id="inpDato" type="text" class="form-control campo-dis" maxlength="50" disabled value="{{$num_exp}}" required />
                                    </div>
                                </div>
                                <div class="row form-group mb-3">
                                    <div class="col">
                                        <label for="inpDato" class="form-label">Número de expediente DGIT *</label>
                                        <input id="inpNumExpDgit" name="num_expediente_dgit" type="text" class="form-control" placeholder="Número de expediente DGIT" maxlength="50" onkeyup="validaCampos(this, 'alphanumerico', 'inpNumExpDgit')" value="{{old('num_expediente_dgit')}}"  required />
                                        <div class="invalid-feedback fw-normal" data-default="El número de expediente DGIT es requerido."></div>
                                    </div>
                                </div>
                                <div class="row form-group mb-3">
                                    <div class="col-12">
                                        <label for="inpDescripcion" class="form-label">Observaciones *</label>
                                        <textarea id="inpDescripcion" name="observacion_alta" class="editor" required>{{old('observacion_alta')}}</textarea>
                                        @error('observacion_alta')
                                            <span class="text-danger mt-1" role="alert">
                                                <b class="fw-normal">{{ $message }}</b>
                                            </span>
                                        @enderror
                                        <div class="invalid-feedback fw-normal" data-default="Este campo es requerido."></div>
                                    </div>
                                </div>
                                <div class="row form-group mb-4">
                                    <div class="col-12">
                                        <div>
                                            @include('components.carga-archivos', ['codigo' => 'alta_denuncia', 'nombre'=>'Oficio de alta de la denuncia'])
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mb-2">
                                    <div class="border-left-info px-2 py-2">
                                        <i class="fa fa-info-circle text-info "></i>
                                        <small class="f-12">
                                            Si la inspección de la cual es parte la denuncia está en curso, haga clic en este check para notificar a la DGIT de esta denuncia
                                        </small>
                                    </div>
                                </div>

                                <div class="row form-group mb-2">
                                    <div class="col">
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" name="notificacion_dgit" id="checkCorreoDgti" value="1">
                                            <label class="form-check-label" for="checkCorreoDgti">Notificar a la DGIT</label>
                                        </div>
                                    </div>
                                </div>
                                <div id="contCorreoDenuncia" class="row form-group mb-2 d-none">
                                    <div class="col">
                                        <label for="inpCorreoDgit" class="form-label mt-2">Correo electrónico *</label>
                                        <input id="inpCorreoDgit" name="correo_dgit" type="email" class="form-control" placeholder="Correo electrónico" maxlength="150" required disabled/>
                                        <div class="invalid-feedback fw-normal" data-default="El correo electrónico es requerido.">
                                        </div>
                                    </div>
                                </div>

                                {{-- Funcionalidad de botones --}}
                                <div class="d-flex flex-row mt-4 flex-sm-row flex-column">
                                    <div class="col">
                                        &nbsp;
                                    </div>
                                    <div class="col">
                                        &nbsp;
                                    </div>
                                    <div class="form-group col-md-3 mb-2 mb-md-0 d-flex  justify-content-end px-2">
                                        <a href="{{route('denuncias.detalle', ['id'=>$denuncia->id])}}" class="btn btn-accion-detalle btn-default w-100" >Cancelar</a>
                                    </div>
                                    <div class="form-group col-md-3 mb-2 mb-md-0 d-flex  justify-content-end">
                                        <button id="btnAltaDenuncia" type="submit" class="btn btn-accion-detalle bg-btn-guardar w-100">Guardar</button>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
