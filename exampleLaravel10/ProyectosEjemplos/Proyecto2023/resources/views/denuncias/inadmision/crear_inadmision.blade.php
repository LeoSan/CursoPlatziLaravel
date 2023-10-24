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
                    <div class="card-header">Inadmisión denuncia</div>
                    <div class="card-body">
                        <form method="post" action="{{route('denuncias.guardar_inadmision')}}" class="necesita-validacion" enctype="multipart/form-data" novalidate>
                            @csrf
                            <input type="hidden" name="denuncia_id" value="{{$denuncia->id}}">
                            <div class="row mt-3">
                                <div class="form-group col-md-12 mb-2">
                                    <label for="motivo">Motivo de inadmisión</label>
                                    <select name="motivo" class="form-select input-regular-height bg-white" required>
                                        <option value="">Seleccione el motivo</option>
                                        @foreach($motivos_inadmision as $motivo)
                                            <option value="{{$motivo->id}}"
                                            @if($denuncia->estatus->codigo != 'pendiente' && $denuncia->inadmision() !=null)
                                            {{$denuncia->inadmision()->motivo_id}}
                                                @if($denuncia->inadmision()->motivo_id == $motivo->id)
                                                    selected
                                                @endif
                                            @else
                                                {{ old('motivo') == $motivo->id ? 'selected' : '' }}
                                            @endif
                                                >{{$motivo->nombre}}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        El motivo de la inadmisión es requerido.
                                    </div>
                                    <span class="text-danger txt-parrafo-error">{{ $errors->first('motivo')}}</span>
                                </div>
                                <div class="form-group col-md-12 mb-2">
                                    <label for="informacion_adicional" class="fw-normal"><b>Información adicional</b></label>
                                    <textarea name="informacion_adicional" class="form-control editor" rows="7" maxlength="900">
                                        @if($denuncia->estatus->codigo != 'pendiente' && $denuncia->inadmision() !=null)
                                            {{$denuncia->inadmision()->observacion}}
                                        @else
                                            {{ old('informacion_adicional') }}
                                        @endif
                                    </textarea>
                                    <span class="text-danger txt-parrafo-error">{{ $errors->first('informacion_adicional')}}</span>
                                </div>
                                <div class="form-group col-md-12 mb-2">
                                    @if($denuncia->estatus->codigo != 'pendiente' && $denuncia->inadmision() !=null)
                                        @include('components.carga-archivos',['codigo'=>'oficio_inadmision_denuncia','nombre'=>'Oficio de inadmisión', 'entidad' => $denuncia,'eliminable'=>true])
                                    @else
                                        @include('components.carga-archivos', ['codigo' => 'oficio_inadmision_denuncia','nombre'=>'Oficio de inadmisión','required'=>true])
                                    @endif

                                </div>
                            </div>
                            <div class="row mt-4 justify-content-end">
                                <div class="form-group col-md-3 mb-2 mb-md-0">
                                    <a href="{{route('denuncias.detalle',['id' =>  $denuncia->id])}}" class="btn btn-accion-detalle btn-default w-100 fw-semibold">Cancelar</a>
                                </div>
                                @if($denuncia->inadmision() !=null)
                                    <div class="form-group col-md-3 mb-2 mb-md-0" id="div_boton_convenio">
                                        <button type="submit" class="btn btn-accion-detalle btn-secondary w-100 fw-semibold">Notificar inadmisión </button>
                                    </div>
                                @else
                                    <div class="form-group col-md-3 mb-2 mb-md-0" id="div_boton_convenio">
                                        <button type="submit" class="btn btn-accion-detalle btn-secondary w-100 fw-semibold">{{$text_boton}}</button>
                                    </div>
                                @endif

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

