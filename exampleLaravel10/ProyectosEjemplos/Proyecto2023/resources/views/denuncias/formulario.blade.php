@extends('layouts.public')
@section('content')

    @if (auth()->check())
        <x-bread-crumbs :itemsbread="$itemsbread"/>
    @endif

    @include('denuncias.partials.modal-aceptar')
    <div class="container form-denuncia">
        <div class="title-principal mb-3">
           Realizar una denuncia
        </div>
        <span class="subtitulo">
            Es muy importante que usted nos proporcione los siguientes datos para poder atender su denuncia.
        </span>
        {{-- Contenedor Tabs --}}
        <div class="row">
            {{--  Esferas   --}}
            <ul class="nav d-flex justify-content-center mb-2 mt-3 v-ls">
                <li class="nav-item tag-form" role="Datos del denunciante">
                    <button id="home-tab" class="tag-activo"  data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">1</button>
                </li>
                <li class="nav-item tag-form" role="Datos de la denuncia">
                    <button id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false" disabled>2</button>
                </li>
                <li class="nav-item tag-form" role="Pruebas de la denuncia" style="margin-left: 7px;">
                    <button id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false" disabled>3</button>
                </li>
            </ul>
            {{--  Titulo   --}}
            <ul class="nav d-flex justify-content-center v-tls">
            <li class="nav-item tag-titulo" role="Datos del denunciante">
                <span>&nbsp;Datos del denunciante</span>
            </li>
            <li class="nav-item tag-titulo" role="Datos de la denuncia">
                <span>Datos de la &nbsp;denuncia</span>
            </li>
            <li class="nav-item tag-titulo" role="Pruebas de la denuncia" style="width: 154px">
                <span>Pruebas de </br>la denuncia</span>
            </li>
            </ul>

            {{--  Alert Warning:: Alert validación backend --}}
            <div class="mb-2">
               @include('denuncias.partials.alert-danger')
            </div>

            {{--  Contenedor Page  --}}
            <div class="tab-content" id="myTabContent">
                {{--  Tab 1  --}}
                <div id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0" class="tab-pane fade show active bg-w">
                    <form id="form_1" class="necesita-validacion" autocomplete="off" accept-charset="UTF-8" novalidate>
                        @csrf
                            <div class="row mb-3 px-3">
                                @can('registrar_denuncias')
                                <div class="form-group col-md-4 mt-2">
                                    <label for="selMedioRecepcion" class="form-label">Medio de recepción *</label>
                                    <select id="selMedioRecepcion" name="medio_recepcion_id" class="form-select input-regular-height  bg-w" aria-label="Seleccionar Origen Denuncia"  required>
                                        <option value="" selected>Seleccione el medio de recepción</option>
                                        @foreach(getCatalogoElementos('medio_recepcion') as $i)
                                        <option data-codigo = "{{$i->codigo}}" value="{{$i->id}}">{{$i->nombre}}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                                </div>
                                @endcan
                                <div class="form-group col-md-4 mt-2">
                                    <label for="selOrigen" class="form-label">Origen de la denuncia *</label>
                                    <select id="selOrigen" name="origen_id" class="form-select input-regular-height bg-w" aria-label="Seleccionar Origen Denuncia"  required>
                                        <option value="" selected>Seleccione el origen de la denuncia</option>
                                        @foreach(getCatalogoElementos('origen_denuncia') as $i)
                                        <option value="{{$i->id}}">{{$i->nombre}}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                                </div>
                                <div class="form-group col-md-4 mt-2">
                                    &nbsp;
                                </div>
                                <div class="form-group col-md-4 mt-2">
                                    &nbsp;
                                </div>
                            </div>
                            <div class="px-3">
                                <div class="bg-border mb-3"></div>
                            </div>
                            <div id="divTitulo" class="title-principal mb-3 px-3">
                                Información personal
                            </div>
                            {{--  Sindicato  --}}
                            <div id="divSindicato" class="row mb-3 d-none px-3">
                                <div class="form-group col-md-12 mt-2">
                                    <label id="labelNombreSindicato" for="inpNomSindicato" class="form-label">Nombre del sindicato *</label>
                                    <input type="text" class="form-control input-regular-height bg-w" id="inpNomSindicato" name="sindicato_denunciante" aria-describedby="labelNombreSindicato" placeholder="Nombre del sindicato" maxLength="255"  required/>
                                    <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                                </div>
                            </div>
                            {{--  Persona  --}}
                            <div id="divPersona" class="row mb-3 px-3">
                                <div class="form-group col-md-4 mt-2">
                                    <label id="labelNombreDenunciante" for="inpNombreDenunciante" class="form-label">Nombre del denunciante *</label>
                                    <input type="text" class="form-control input-regular-height bg-w" id="inpNombreDenunciante" name="nombre_denunciante" aria-describedby="labelNombreDenunciante" placeholder="Nombre del denunciante" required maxLength="100" />
                                    <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                                </div>
                                <div class="form-group col-md-4 mt-2">
                                    <label id="labelPrimerApellido" for="inpPrimerApellido" class="form-label">Primer apellido *</label>
                                    <input type="text" class="form-control input-regular-height bg-w" id="inpPrimerApellido" name="primer_apellido_denunciante" aria-describedby="labelPrimerApellido" placeholder="Primer apellido"  required maxLength="50"  />
                                    <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                                </div>
                                <div class="form-group col-md-4 mt-2">
                                    <label id="labelSegundoApellido" for="inpSegundoApellido" class="form-label">Segundo apellido </label>
                                    <input type="text" class="form-control input-regular-height bg-w" id="inpSegundoApellido" name="segundo_apellido_denunciante" aria-describedby="labelSegundoApellido"  placeholder="Segundo apellido" maxLength="50" />
                                    <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                                </div>
                            </div>

                            <div class="row mb-3 px-3">
                                <div class="form-group col-md-4 mt-2">
                                    <label id="labelTelefono" for="inpTelefono" class="form-label">Teléfono </label>
                                    <input type="tel" class="form-control telefono input-regular-height bg-w" id="inpTelefono" name="telefono_denunciante" aria-describedby="labelTelefono" placeholder="55555555" minlength="8" maxLength="8" pattern="^\d{8}$"/>
                                    <div class="invalid-feedback fw-regular" data-default="El mínimo de caracteres es de 8">El mínimo de caracteres es de 8</div>
                                </div>
                                <div class="form-group col-md-4 mt-2">
                                    <label id="labelCorreo" for="inpCorreo" class="form-label">Correo electrónico *</label>
                                    <input type="email" class="form-control input-regular-height bg-w" id="inpCorreo" name="correo_denunciante" aria-describedby="labelCorreo" placeholder="Correo electrónico" required maxLength="255"  />
                                    <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                                </div>
                                <div class="form-group col-md-4 mt-2">
                                    <label id="labelConfCorreo" for="inpConfCorreo" class="form-label">Confirmar correo electrónico *</label>
                                    <input type="email" class="form-control input-regular-height bg-w" id="inpConfCorreo" name="inpConfCorreo" aria-describedby="labelConfCorreo" placeholder="Ingrese confirmación del correo" required maxLength="255" />
                                    <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                                </div>
                                <div class="form-group col-md-4 mt-3">
                                    <label id="labelDNI" for="inpDNI" class="form-label">Documento Nacional de Identificación (DNI) *</label>
                                    <input type="tel" class="form-control identificacion input-regular-height bg-w" id="inpDNI" name="dni_denunciante" aria-describedby="labelDNI" placeholder="DNI" minLength="13" required pattern="^\d{13}$">
                                    <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                                </div>
                            </div>
                        <div class="px-3">
                            <div class="bg-border mb-3"></div>
                        </div>
                        <div class="title-principal mb-3 px-3">
                            Domicilio del denunciante
                        </div>
                        <div class="px-3">
                            @include('components.domicilio.formulario', ['required'=>false])
                        </div>
                        <div class="row my-4">
                            <div class="form-group col-md-4 mt-2 ">
                                &nbsp;
                            </div>
                            <div class="form-group col-md-4 mt-2 ">
                                &nbsp;
                            </div>
                            <div class="form-group col-md-4 mt-2 d-flex justify-content-end">
                                <button type="submit" class="btn btn-denuncia icon-right-row">Siguiente</button>
                            </div>
                        </div>
                    </form>
                </div>
                {{--  Tab 2  --}}
                <div id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0" class="tab-pane fade bg-white">
                    <form id="form_2" class="necesita-validacion" autocomplete="off" accept-charset="UTF-8" enctype="multipart/form-data" novalidate>
                        <span id="isValor" class='opacity-0'>{{$parametros['id']}}</span>
                        <div class="row mb-3 px-3">
                            <div class="form-group col-md-8 mt-2">
                                <label id="labelNombreFuncionario" for="inpNombreFuncionario" class="form-label">Nombre del funcionario *</label>
                                <input type="text" class="form-control input-regular-height bg-w" id="inpNombreFuncionario" name="nombre_funcionario" aria-describedby="labelNombreFuncionario" placeholder="Nombre del funcionario" required maxLength="255" />
                                <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                            </div>

                            <div class="form-group col-md-4 mt-2">
                                <label id="labelFechaDenuncia" for="inpFechaDenuncia" class="form-label">Fecha de la denuncia</label>
                                <input type="text" class="form-control campo-dis" id="inpFechaDenuncia" name="inpFechaDenuncia" aria-describedby="labelFechaDenuncia" required maxLength="15" disabled value="{{$parametros['fecha_actual']}}" />
                            </div>


                            <div class="form-group col-md-4 mt-3">
                                <label for="selDepartamentoDenuncia" class="form-label">Departamento *</label>
                                <select id="selDepartamentoDenuncia" name="region_departamento_id" class="form-select input-regular-height bg-w" aria-label="select departamento" onchange="selectMunicipios(this,'selMunicipioDenuncia')" required >
                                    <option value="" selected>Seleccione el departamento</option>
                                    @foreach(getCatalogoElementos('departamentos') as $i)
                                    <option value="{{$i->id}}">{{$i->nombre}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                            </div>
                            <div class="form-group col-md-4 mt-3">
                                <label for="selMunicipioDenuncia" class="form-label">Municipio *</label>
                                <select id="selMunicipioDenuncia" name="region_municipio_id" class="form-select input-regular-height bg-w" aria-label="select municipio" required onchange="selectOficinaRegional(this,'selOficinaDenuncia')">
                                    <option value="" selected>Seleccione el municipio</option>
                                </select>
                                <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                            </div>
                            <div class="form-group col-md-4 mt-3">
                                <label for="selOficinaDenuncia" class="form-label">Oficina regional </label>
                                <select id="selOficinaDenuncia" name="oficina_regional_id" class="form-select campo-dis form-select-regional" aria-label="Default select example" required>
                                    <option value="" selected></option>
                                </select>
                                <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                            </div>


                            <div class="form-group col-md-12 mt-3">
                                <label for="inpDenuncia" class="form-label">Descripción de la denuncia *</label>
                                <textarea type="text" name="descripcion_denuncia" id="inpDenuncia" class="font-regular-size py-3 px-3 bg-white editor" rows="7" required maxlength="1700" placeholder="Describa la denuncia" rows="7"></textarea>
                                <div class="invalid-feedback" data-default="Este campo es obligatorio y debe tener máximo 1700 caracteres."></div>
                            </div>
                            <div class="form-group col-md-12 mt-3">
                                <div>
                                    @include('components.carga-archivos', ['nombre'=>'Archivo de la denuncia', 'codigo' => 'oficio_denuncia','minimo'=>1, 'accept'=>'.jpg,.jpeg,.png,.pdf'])
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="form-group col-md-4 mt-2 d-flex justify-content-start">
                                <button id="btnAnteriortab" type="button" class="btn btn-denuncia icon-left-row">Atrás</button>
                            </div>
                            <div class="form-group col-md-4 mt-2 ">
                                &nbsp;
                            </div>
                            <div class="form-group col-md-4 mt-2 d-flex justify-content-end">
                                <button type="submit" class="btn btn-denuncia icon-right-row">Siguiente</button>
                            </div>
                        </div>
                    </form>
                </div>
                {{--  Tab 3  --}}
                <div id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0" class="tab-pane fade">
                    <form id="form_3" class="form-air" autocomplete="off" accept-charset="UTF-8" enctype="multipart/form-data" class="necesita-validacion" novalidate>
                        <div class="row mb-3 px-3">
                            <div class="row d-flex justify-content-start">
                                <label id="labelNombreFuncionario" class="form-label">¿Cuentas con pruebas de los hechos? </label>
                                <div class="form-group justify-content-start">
                                    <input class="form-check-input" type="radio" name="cuenta_con_pruebas" id="flexRadioDefault1" onclick="validaPruebasDenuncias(this)" value="true" required>
                                    <label class="form-check-label" for="flexRadioDefault1"> Si</label>
                                    <input class="form-check-input ms-3" type="radio" name="cuenta_con_pruebas" id="flexRadioDefault2" onclick="validaPruebasDenuncias(this)" value="false" required>
                                    <label class="form-check-label" for="flexRadioDefault2">No</label><br>
                                    <div class="invalid-feedback" data-default="Dato obligatorio"></div>
                                </div>
                            </div>
                        </div>
                        <div class="px-3">
                            <div class="bg-border mb-3"></div>
                        </div>

                        <div id="divCargaPruebaDenuncias" style="display: none" class="px-3">
                            <div class="title-principal">Pruebas</div>
                            <div class="row">
                                <div class="form-group">
                                    @include('components.carga-archivos-multiple', ['codigo' => 'pruebas_denuncia','minimo'=>1])
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="form-group col-md-4 mt-2 d-flex justify-content-start">
                                <button id="btnAnteriortabDos" type="button" class="btn btn-denuncia icon-left-row">Atrás</button>
                            </div>
                            <div class="form-group col-md-4 mt-2 ">
                                &nbsp;
                            </div>
                            <div class="form-group col-md-4 mt-2 d-flex justify-content-end">
                                <button id="btnEnviarDenuncia" type="submit" class="btn btn-envio icon-right-row">Enviar denuncia</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
