@extends('layouts.app')
@section('content')
    <nav aria-label="breadcrumb" class="px-3 py-1">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item font-small-size"><a href="#">Seguimiento de casos</a></li>
            <li class="breadcrumb-item font-small-size active" aria-current="page">Tipos de infracción</li>
        </ol>
    </nav>
    <div class="row">
        <div class="card col-12 bg-white border-0">
            <div class="card-body">
                <div class="title-principal mb-2">
                    Tipos de Infracción
                </div>
                @include('admin.tipos_infraccion.partials.filtros')
                <div class="row">
                    <div class="col-md-12 text-end">
                        <a href="{{route('tiposInfraccion.create')}}" class="btn btn-danger d-inline-flex align-items-center w-auto input-regular-height">AGREGAR TIPO DE INFRACCIÓN</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 table-responsive">
                      <table class="table text-center tabla-multas">
                          <thead>
                              <tr>
                                  <th>Año</th>
                                  <th>Tipo de infracción</th>
                                  <th>Monto de multa</th>
                                  <th>Estatus</th>
                                  <th>Editable</th>
                                  <th>Acciones</th>
                              </tr>
                          </thead>
                          <tbody>
                                @foreach($infracciones as $i)
                                    <tr>
                                        <td>{{$i->anio}}</td>
                                        <td>{{$i->concepto}}</td>
                                        <td>L {{lempiras($i->monto)}}</td>
                                        <td>
                                            <div class="row justify-content-center">
                                                <div class="col-auto p-0">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input infracciones" type="checkbox" id="flexSwitchCheckChecked" {{$i->activo?'checked':''}} disabled>
                                                    </div>
                                                </div>
                                                <div class="col-auto p-0">
                                                    <span class="{{$i->activo?'text-success fw-bold':''}} ">{{$i->activo?'Activo':'Inactivo'}}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="row justify-content-center">
                                                <div class="col-auto p-0">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input infracciones" type="checkbox" id="flexSwitchCheckChecked" {{$i->editable?'checked':''}} disabled>
                                                    </div>
                                                </div>
                                                <div class="col-auto p-0">
                                                    <span class="{{$i->editable?'text-success fw-bold':''}} ">{{$i->editable?'Editable':'No editable'}}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <button type="button"
                                                    class="btn-link fw-bolder text-{{$i->activo ? ($i->sanciones->count()>0?'secondary':'danger') : 'success'}}"
                                                    data-bs-target="#modalTipoInfraccion"
                                                    data-bs-toggle="modal"
                                                    data-id="{{$i->id}}"
                                                    data-anio="{{$i->anio}}"
                                                    data-concepto="{{$i->concepto}}"
                                                    data-activo="{{$i->activo}}"
                                                    data-eliminable="{{$i->sanciones->count()>0}}"
                                                    onclick="accionTipoInfraccion(this)">
                                                <i class="fa {{$i->activo ? ($i->sanciones->count()>0?'fa-ban':'fa-trash-alt') :'fa-check'}}"></i> {{$i->activo ? ($i->sanciones->count()>0?'Deshabilitar':'Eliminar') : 'Habilitar'}}
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                          </tbody>
                      </table>
                    </div>
                    <div class="col-12">
                        <div class="row justify-content-center">
                            <div class="col-md-12 d-flex justify-content-center">{{$infracciones->appends($_GET)->links()}}</div>
                            <div class="col-md-12 text-center text-small">
                                <strong>{{ number_format($infracciones->firstItem()) }}</strong> <span>al</span>
                                <strong>{{ number_format($infracciones->lastItem()) }}</strong> <span>de</span>
                                <strong>{{ number_format($infracciones->total()) }}</strong> <span>registros</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.tipos_infraccion.partials.modal_accion')

@endsection
