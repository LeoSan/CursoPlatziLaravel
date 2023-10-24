@extends('layouts.app')
@section('content')
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('casos.index')}}">Bandeja de casos</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{@$caso->numero_expediente ? $caso->numero_expediente : 'Nuevo caso'}}</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <h5><strong>Nuevo Caso</strong></h5>
    </div>
    <!--INFORMACIÓN GENERAL-->
    <form method="post" action="{{route('casos.store')}}" id="form_registro_caso">
        @csrf
        <input type="hidden" name="tipo_submit">
        <input type="hidden" name="caso_id" value="{{@$caso->id}}">
        <div class="row mt-3">
            <h6 class="text-danger"><strong>Información general</strong></h6>
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-4 mb-2">
                                <label for="departamento_id">Departamento</label>
                                <select name="caso_departamento_id" id="departamento_id" class="form-select" onchange="selectMunicipios(this,'municipio_caso')">
                                    <option value="">Selecciona el departamento</option>
                                    @foreach(getCatalogoElementos('departamentos') as $i)
                                        <option value="{{$i->id}}">{{$i->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4 mb-2">
                                <label for="municipio_caso">Municipio</label>
                                <select name="caso_municipio_id" id="municipio_caso" class="form-select">
                                    <option value="">Selecciona el departamento</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2 mb-2">
                                <label for="fecha_registro">Fecha</label>
                                <input type="date" class="form-control" name="fecha_registro" id="fecha_registro" max="9999-12-31" required
                                >
                            </div>
                            <div class="form-group col-md-2 mb-2">
                                <label for="fecha_registro">Hora</label>
                                <input type="time" class="form-control" name="fecha_registro" id="fecha_registro" required
                                >
                            </div>
                            <div class="form-group col-md-4 mb-2">
                                <label for="numero_expediente">Número de expediente</label>
                                <input type="text" class="form-control" name="numero_expediente" placeholder="ILN-" id="numero_expediente" required
                                >
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <div class="border-left-info px-2 py-1">
                                    <i class="fa fa-info-circle text-info"></i> Sólo serán atendidos casos de la Ley de Inspección del Trabajo
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--INFORMACIÓN EMPRESA NOTIFICADA-->
        <div class="row mt-3">
            <h6 class="text-danger"><strong>Información empresa notificada</strong></h6>
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-12 mb-2">
                                <label for="nombre_empresa">Nombre comercial</label>
                                <input type="text" class="form-control" name="nombre_empresa" placeholder="Escribe el nombre comercial" id="nombre_empresa">
                            </div>
                            <div class="form-group col-md-12 mb-2">
                                <label for="razon_social">Razón social</label>
                                <input type="text" class="form-control" name="razon_social" placeholder="Escribe la razón social" id="razon_social">
                            </div>
                            <div class="form-group col-md-6 mb-2">
                                <label for="email_empresa">Correo electrónico de la empresa</label>
                                <input type="email" class="form-control" name="email_empresa" placeholder="Escribe el correo electrónico de la empresa" id="email_empresa">
                            </div>
                            <div class="form-group col-md-6 mb-2">
                                <label for="telefono_empresa">Teléfono de la empresa</label>
                                <input type="text" class="form-control" name="telefono_empresa" placeholder="Escribe el correo electrónico de la empresa" id="telefono_empresa">
                            </div>
                        </div>
                        <div class="row  mt-2">
                            <p class="my-2"><strong>REPRESENTANTE LEGAL</strong></p>
                            <div class="form-group col-md-6 mb-2">
                                <label for="nombre_representante">Nombre del representante legal</label>
                                <input type="text" class="form-control" name="nombre_representante" placeholder="Escribe el nombre del representante" id="nombre_representante">
                            </div>
                            <div class="form-group col-md-6 mb-2">
                                <label for="identificacion_representante">Número de documento de identificación nacional</label>
                                <input type="text" class="form-control" name="identificacion_representante" placeholder="Escribe el número de documento" id="identificacion_representante">
                            </div>
                            <div class="form-group col-md-6 mb-2">
                                <label for="email_representante">Correo electrónico del representante legal</label>
                                <input type="email" class="form-control" name="email_representante" placeholder="Escribe el correo electrónico del representante" id="email_representante">
                            </div>
                            <div class="form-group col-md-6 mb-2">
                                <label for="telefono_representante">Teléfono del representante legal</label>
                                <input type="text" class="form-control" name="telefono_representante" placeholder="Escribe el teléfono del representante" id="telefono_representante">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--SANCIONES-->
        <div class="row mt-3">
            <h6 class="text-danger"><strong>Sanciones</strong></h6>
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="row my-2">
                            <div class="col-12">
                                <div class="border-left-info px-2 py-1">
                                    <i class="fa fa-info-circle text-info"></i> Para agregar una infracción, selecciona el año, el tipo, verifica el monto y da clic en el botón de agregar.
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-2 mb-2">
                                <label for="anio_infraccion">Año</label>
                                <select id="anio_infraccion" class="form-select" onchange="anioInfraccion(this,'infraccion_id')">
                                    <option value="">Selecciona el año</option>
                                    @foreach($anios as $i)
                                        <option value="{{$i->anio}}">{{$i->anio}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4 mb-2">
                                <label for="infraccion_id">Tipo de infracción</label>
                                <select id="infraccion_id" class="form-select" onchange="selectedInfraccion(this,'monto_infraccion')">
                                    <option value="">Selecciona el año</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4 mb-2">
                                <label for="monto_infraccion">Monto de la multa (en lempiras)</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">L</span>
                                    <input type="text" class="form-control" placeholder="Selecciona la infracción" id="monto_infraccion" readonly>
                                </div>
                            </div>
                            <div class="form-group col-md-2 my-2 d-flex align-items-center">
                                <button class="btn btn-primary btn-pgr2 w-100 mt-1" type="button" disabled onclick="agregarInfraccion()" id="btn_agregar_multa">Agregar multa</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table class="table-bordered text-center tabla-casos text-sm w-100">
                                    <thead>
                                    <tr>
                                        <th style="max-width: 70px">Año</th>
                                        <th class="w-50">Tipo de infracción</th>
                                        <th class="w-auto">Monto de multa (en lempiras)</th>
                                        <th style="min-width: 100px">Función</th>
                                    </tr>
                                    </thead>
                                    <tbody id="body_tabla_sanciones">
                                        <tr id="tr_info_sanciones">
                                            <td colspan="4">Sin infracciones</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Monto total de la multa</td>
                                            <td colspan="2"><strong id="total_multa">L 0.00</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--DIRECCIÓN DE LA EMPRESA-->
        <div class="row mt-3">
            <h6 class="text-danger"><strong>Dirección de la empresa</strong></h6>
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-body">
                        @include('componentes.domicilio.formulario',$caso)
                    </div>
                </div>
            </div>
        </div>
        <!--DOCUMENTOS-->
        <div class="row mt-3">
            <h6 class="text-danger"><strong>Documentos SETRASS</strong></h6>
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-5 mb-2">
                                <label for="contancia_archivo">Constancia de firmeza</label>
                                <input type="file" class="form-control">
                            </div>
                            <div class="form-group col-md-5 mb-2">
                                <label for="resolucion_archivo">Resolución certificada</label>
                                <input type="file" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-5 mb-2">
                                <label for="acuse_archivo">Acuse de recibo</label>
                                <input type="file" class="form-control">
                            </div>
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="form-group col-md-6 mb-2">
                                        <label for="numero_oficio">Número de oficio</label>
                                        <input type="text" class="form-control" name="numero_oficio" placeholder="Escribe el número de oficio" id="numero_oficio">
                                    </div>
                                    <div class="form-group col-md-6 mb-2">
                                        <label for="fecha_entrega">Fecha de entrega a PGR</label>
                                        <input type="date" class="form-control" name="fecha_entrega" placeholder="Escribe el número de oficio" id="fecha_entrega" max="9999-12-31">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    <!--DIRECCIÓN DE LA EMPRESA-->
    <div class="row mt-3">
        <div class="col-md-3">
            <button class="btn btn-primary btn-pgr w-100">Cancelar</button>
        </div>
        <div class="col-md-3">
            <button class="btn btn-danger btn-pgr w-100">Eliminar Borrador</button>
        </div>
        <div class="col-md-3">
            <button class="btn btn-warning btn-pgr w-100" id="guardar_cambios_caso">Guardar Cambios</button>
        </div>
        <div class="col-md-3">
            <button type="submit" form="form_registro_caso" class="btn btn-success btn-pgr w-100">Enviar a Revisión</button>
        </div>
    </div>
@endsection
