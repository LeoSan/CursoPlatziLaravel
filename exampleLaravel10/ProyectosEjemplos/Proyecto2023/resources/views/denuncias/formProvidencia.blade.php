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
                    <div class="card-header">Providencia</div>
                    <div class="card-body">
                        <form action="{{route('denuncias.guardar.providencia')}}" id="form_providencia_denuncia" class="form-air necesita-validacion" method="POST" autocomplete="off" accept-charset="UTF-8" enctype="multipart/form-data" novalidate>
                            @csrf
                            <input id="inpHiDenunciaId" name="denuncia_id" type="hidden" value="{{$denuncia->id}}" />
                            <input id="inpHiExpedienteUsuarioId" name="expediente_usuario_id" type="hidden" value="{{$denuncia->usuario_asignado_id}}" />
                                <div class="row form-group mb-2">
                                    <div class="col">
                                        <label for="inpDato" class="form-label">Motivo de providencia *</label>
                                        <select id="selMotivo" name="motivo_id" class="form-select" aria-label="Seleccione motivo de la providencia"  required>
                                            <option value="" selected>Seleccione</option>
                                                @foreach(getCatalogoElementos('providencia_denuncia_ati') as $i)
                                                <option {{ old('motivo_id') == $i->id ? "selected" : "" }} value="{{$i->id}}">{{$i->nombre}}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback msj-alert-ati" for="selMotivo" >
                                            Dato obligatorio.
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group mb-3">
                                    <div class="col-12">
                                        <label for="inpDescripcion" class="form-label">Observaciones *</label>
                                        <textarea id="inpDescripcion" name="observacion" class="editor" required>{{old('observacion')}}</textarea>
                                        @error('observacion')
                                            <span class="text-danger mt-1" role="alert">
                                                <b class="fw-normal">{{ $message }}</b>
                                            </span>
                                        @enderror
                                        <div class="invalid-feedback fw-normal" data-default="Este campo es requerido."></div>
                                    </div>
                                </div>


                                <div class="row form-group mb-2">
                                    <div class="col-12">
                                        <div>
                                            @include('components.carga-archivos', ['codigo' => 'providencia_denuncia', 'nombre'=>'Oficio providencia', 'entidad' => $denuncia])
                                        </div>
                                    </div>
                                </div>
                                {{-- Funcionalidad de botones --}}
                                <div class="d-flex flex-row mt-4  m-rls flex-sm-row flex-column">
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
                                        <button id="btnProvidencia" type="submit" class="btn btn-accion-detalle bg-btn-guardar w-100">Guardar</button>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
