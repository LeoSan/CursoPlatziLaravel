@extends('layouts.app')
@section('content')

    @include('denuncias.partials.modal-aceptar')
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
                    <div class="card-header">Solicitar Expediente</div>
                    <div class="card-body">
                        <form action="{{route('denuncias.guardar.solicitar.expediente')}}" id="form_solicitar_expediente" class="form-air px-3 necesita-validacion" method="POST" autocomplete="off" accept-charset="UTF-8" enctype="multipart/form-data" novalidate>
                            @csrf
                            <input id="inpHiDenunciaId" name="denuncia_id" type="hidden" value="{{$denuncia->id}}" />
                            <input id="inpHiExpedienteUsuarioId" name="expediente_usuario_id" type="hidden" value="{{$denuncia->usuario_asignado_id}}" />
                                <div class="row form-group mb-3">
                                    <div class="col">
                                        <label for="usuario" class="form-label">Jefe regional de inspección</label>
                                        <select name="usuario" id="usuario" class="bg-white selectpicker-usuarios input-regular-height font-regular-size" required>
                                            <option value="">Escribe para seleccionar</option>
                                            @foreach($usuario_region_list as $usuario)
                                                <option {{ ( $usuario->regional_id == $denuncia->oficina_regional_id) ? 'selected' : '' }} value="{{ $usuario->id }}">{{ $usuario->NombreCompleto }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            El Jefe regional de inspección es requerido.
                                        </div>
                                    </div>

                                </div>
                                <div class="row form-group mb-3">
                                    <div class="col">
                                        <label for="usuario" class="form-label">Número de expediente DGIT *</label>
                                        <input id="num_expediente_dgit" name="num_expediente_dgit" type="text" class="form-control" maxlength="50"  value="{{ old('num_expediente_dgit',$denuncia->num_expediente_dgit)}}" required/>
                                        <div class="invalid-feedback">
                                            El número de expediente DGIT es requerido.
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group mb-3">
                                    <div class="col-12">
                                        <label for="inpDescripcion" class="form-label">Información adicional *</label>
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
                                            @include('components.carga-archivos', ['codigo' => 'oficio_solicitar_expediente', 'nombre'=>'Oficio para solicitar expediente','required'=>true, 'entidad' => $denuncia])
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
                                        <button type="submit" form="form_solicitar_expediente" class="btn btn-accion-detalle bg-btn-guardar w-100">Guardar</button>
                                    </div>
                                </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
