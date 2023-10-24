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
                    <div class="card-header">Finalizar denuncia</div>
                    <div class="card-body">
                        <form action="{{route('denuncias.guardar.finalizacion')}}" id="form_finaliza_denuncia" class="form-air necesita-validacion" method="POST" autocomplete="off" accept-charset="UTF-8" enctype="multipart/form-data" novalidate onsubmit="validarFormulario(event)">
                            @csrf
                            <input id="inpHiDenunciaId" name="denuncia_id" type="hidden" value="{{$denuncia->id}}" />
                                <div class="row form-group mb-3">
                                    <div class="col-4">
                                        <label for="inpFechaentrega" class="form-label">Fecha de entrega al ministro *</label>
                                        <input id="inpFechaentrega" name="fecha_entrega"  type="date" class="form-control" max="{{ date('Y-m-d') }}"  value="{{old('fecha_entrega')}}" required />
                                        <div class="invalid-feedback fw-normal" data-default="Dato obligatorio."></div>
                                    </div>
                                </div>
                                <div class="row form-group mb-4">
                                    <div class="col-12">
                                        <div>
                                            @include('components.carga-archivos', ['codigo' => 'informe_final', 'nombre'=>'Informe final','entidad' => $denuncia,'eliminable'=>true, 'required'=>true])
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group mb-4">
                                    <div class="col-12">
                                        <div>
                                            @include('components.carga-archivos', ['codigo' => 'acuse_recibo_informe_final', 'nombre'=>'Acuse de recibo','entidad' => $denuncia,'eliminable'=>true, 'required'=>true])
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
                                        <button id="btnFinalizacionProceso" type="submit" class="btn btn-accion-detalle bg-btn-guardar w-100">Guardar</button>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
