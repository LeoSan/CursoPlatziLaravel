<div class="border carga-archivos px-3 py-3" id="seccion_carga_multiple">

    <input type="hidden" id="conteo_archivos_{{ $codigo }}" value="1">
    <input type="hidden" id="accept_archivos_{{ $codigo }}" value="{{isset($accept)?$accept:'.jpg,.jpeg,.png,.heic,.pdf,.doc,.docx'}}">
    <input type="hidden" name="accept_{{$codigo}}" value="{{isset($accept)?str_replace('.','',$accept):'jpg,jpeg,png,heic,pdf,doc,docx'}}">
    <div class="carga">
        <div class="row">
            <div class="form-group mb-4 col-12 @if(!@$small) col-md-6 @endif">
                <label for="{{ $codigo }}" class="mb-2">Archivo</label>
                <div class="boton-carga accion-boton-carga input-file d-flex btn-file text-decoration-none rounded-2" data-type="{{ $codigo }}" id="boton_carga_{{$codigo}}">
                    <div class="d-flex w-100 justify-content-between align-items-center">
                        <div class="info d-flex align-items-center fw-semibold text-dark pe-2">
                            <div id="multiple_{{ $codigo }}_check">

                            </div>
                            <div id="multiple_{{ $codigo }}_nombre">
                                Seleccionar archivo
                            </div>
                            <div id="multiple_{{ $codigo }}_peso" class="fw-normal mx-2">
                                <small>
                                    (Máximo 5 MB)
                                </small>
                            </div>
                        </div>
                        <div class="icon">
                            <div id="{{ $codigo }}_accion">
                                <div class="text-decoration-none">
                                    <img src="{{ asset('images/icons/icon-upload.svg') }}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="fw-regular text-danger" id="mensaje_error_multiple_{{ $codigo }}" style="display: none">
                    El archivo seleccionado excede el tamaño máximo permitido.
                </div>
                <div class="fw-regular text-danger" id="mensaje_seleccion_multiple_{{ $codigo }}" style="display: none">
                    Seleccione el archivo que desea cargar.
                </div>
            </div>
            <div class="form-group mb-4 col-12 @if(!@$small) col-md-6 @endif">
                <label for="archivo_descripcion_{{ $codigo }}" class="mb-2">Descripción (máximo 200 caracteres) *</label>
                <input type="text" class="form-control" id="archivo_descripcion_{{ $codigo }}" placeholder="Escriba una breve descripción del archivo" maxlength="200" onkeyup="contadorCaracteres(this)" data-type="{{ $codigo }}">
                <div class="text-danger" id="mensaje_contador_caracter_{{ $codigo }}">
                </div>
                <div class="fw-regular text-danger" id="mensaje_descripcion_archivo_{{ $codigo }}" style="display: none">
                    Dato obligatorio
                </div>
            </div>

        </div>



        <div class="form-group w-full d-flex flex-row justify-content-end">
            <a href="#" class="fw-bold text-turquoise accion-boton-nuevo"
                    data-type="{{ $codigo }}">
                Agregar archivo
                <img src="{{ asset('images/icons/icon-add.svg') }}" alt="">
            </a>
        </div>
    </div>

    <div class="resultado">
        <h5 class="fw-bold text-graydark font-regular-size mb-2">
            Archivos agregados {{isset($minimo)&&$minimo>0?' *':''}}
        </h5>

        <div id="archivos_{{ $codigo }}" class="visually-hidden">
            <div id="archivo_item_{{ $codigo }}_1" class="archivo-item">
                <input type="file" class="archivo-input" data-type="{{ $codigo }}"
                       name="documentos_archivos_{{ $codigo }}[1]"
                       id="documentos_archivos_{{ $codigo }}_1" accept="{{isset($accept)?$accept:'.jpg,.jpeg,.png,.heic,.pdf,.doc,.docx'}}" />
                <input type="text" name="documentos_textos_{{ $codigo }}[1]" id="documentos_textos_{{ $codigo }}_1" />
            </div>
        </div>

        <input type="number" min="{{$minimo??0}}" class="d-none" id="minimo_{{$codigo}}" {{isset($minimo)&&$minimo>0?'required':''}}>

        <ul id="lista_archivos_{{ $codigo }}" class="archivos bg-default-gray m-0 font-regular-size p-0 list-group border">
            <li class="d-flex justify-content-between align-items-center px-3 py-2 lista-archivos" id="lista_archivos_vacio_{{ $codigo }}">
                <div class="text-center py-2">
                    Sin archivos seleccionados
                </div>
            </li>
        </ul>
        <div class="invalid-feedback fw-regular" data-default="Debe cargar por lo menos {{$minimo??''}} archivo(s)" id="msj_error_documentos_archivos">
            Debe cargar por lo menos {{$minimo??''}} archivo(s)
        </div>

    </div>
</div>
