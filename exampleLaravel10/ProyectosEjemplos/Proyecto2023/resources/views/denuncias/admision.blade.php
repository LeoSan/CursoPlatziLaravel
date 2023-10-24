@extends('layouts.app')
@section('content')
    <div class="container">
        <x-bread-crumbs :itemsbread="$itemsbread"/>
    </div>
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
                    <div class="card-header">Admitir denuncia</div>
                    <div class="card-body">
                        <form action="{{route('denuncias.storeAdmision')}}"       id="form_admitir_denuncia"     class="form-air necesita-validacion" method="POST" autocomplete="off" accept-charset="UTF-8" enctype="multipart/form-data" novalidate>
                            @csrf
                            <input name="denuncia_id" type="hidden" value="{{$denuncia->id}}" />
                            <div class="row form-group mb-2">
                                <div class="col">
                                    <label for="tipo_inspeccion" class="form-label">Tipo de inspección *</label>
                                    <select id="tipo_inspeccion" name="tipo_inspeccion_id" class="form-select" aria-label="Seleccione el tipo de inspección" required>
                                        <option value="" selected>Seleccione</option>
                                        @foreach(getCatalogoElementos('tipos_inspeccion') as $i)
                                            <option value="{{$i->id}}" {{old('tipo_inspeccion_id') && old('tipo_inspeccion_id')==$i->id?'selected':''}}>{{$i->nombre}}</option>
                                        @endforeach
                                    </select>
                                    @error('tipo_inspeccion_id')
                                        <span class="text-danger mt-1" role="alert">
                                            <b class="fw-normal">{{ $message }}</b>
                                        </span>
                                    @enderror
                                    <div class="invalid-feedback" for="tipo_inspeccion">
                                        Dato obligatorio
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group mb-2">
                                <div class="col">
                                    <label for="caracter_denuncia" class="form-label">Carácter de la denuncia *</label>
                                    <select id="caracter_denuncia" name="caracter_id" class="form-select" aria-label="Seleccione el caracter de la denuncia" required>
                                        <option value="" selected>Seleccione</option>
                                        @foreach(getCatalogoElementos('caracteres_denuncia') as $i)
                                            <option value="{{$i->id}}" {{old('caracter_id') && old('caracter_id')==$i->id?'selected':''}}>{{$i->nombre}}</option>
                                        @endforeach
                                    </select>
                                    @error('caracter_denuncia')
                                        <span class="text-danger mt-1" role="alert">
                                            <b class="fw-normal">{{ $message }}</b>
                                        </span>
                                    @enderror
                                    <div class="invalid-feedback" for="caracter_id">
                                        Dato obligatorio
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group mb-2">
                                <div class="col-12">
                                    <label for="informacion_adicional" class="form-label fw-normal"><strong>Observaciones *</strong></label>
                                    <textarea id="informacion_adicional" name="observaciones" class="editor" required maxlength="1700">{{old('observaciones')}}</textarea>
                                    @error('observacion')
                                        <span class="text-danger mt-1" role="alert">
                                            <b class="fw-normal">{{ $message }}</b>
                                        </span>
                                    @enderror
                                    <div class="invalid-feedback" for="informacion_adicional">
                                        Dato obligatorio
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group mb-2">
                                <div class="col-12">
                                    @include('components.carga-archivos', ['codigo' => 'auto_admision_denuncia', 'nombre'=>'Auto de admisión de la denuncia', 'required'=>true, 'entidad' => $denuncia])
                                </div>
                            </div>

                            {{-- Funcionalidad de botones --}}
                            <div class="row justify-content-end">
                                <div class="form-group col-md-3 mb-2 mb-md-0 d-flex  justify-content-end px-2">
                                    <a href="{{route('denuncias.detalle', ['id'=>$denuncia->id])}}" class="btn btn-accion-detalle btn-default w-100" >Cancelar</a>
                                </div>
                                <div class="form-group col-md-3 mb-2 mb-md-0 d-flex  justify-content-end">
                                    <button type="submit" class="btn btn-accion-detalle bg-btn-guardar w-100">Admitir</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
