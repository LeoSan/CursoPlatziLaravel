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
                    <div class="card-header">Reasignar denuncia a auditor</div>
                    <div class="card-body">
                        <form action="{{route('denuncias.guardar.reasignar.auditor')}}" id="form_reasignar_auditor_denuncia" class="form-air necesita-validacion" method="POST" autocomplete="off" accept-charset="UTF-8" enctype="multipart/form-data" novalidate onsubmit="validarFormulario(event)">
                            @csrf
                            <input id="inpHiDenunciaId" name="denuncia_id" type="hidden" value="{{$denuncia->id}}" />
                                <div class="row form-group mb-3">
                                    <div class="col-12">
                                        <label for="inpFechaentrega" class="form-label">Auditor *</label>
                                        <select name="usuario" id="usuario" class="bg-white selectpicker-usuarios input-regular-height font-regular-size msj-alert-ati" required>
                                            <option value="">Escriba para seleccionar</option>
                                            @foreach($usu_auditor_list as $usuario)
                                                <option value="{{ $usuario->id }}">{{ $usuario->NombreCompleto }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback fw-normal" data-default="Dato obligatorio."></div>
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
                                        <button id="btnReasignarAuditor" type="submit" class="btn btn-accion-detalle bg-btn-guardar w-100">Guardar</button>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
