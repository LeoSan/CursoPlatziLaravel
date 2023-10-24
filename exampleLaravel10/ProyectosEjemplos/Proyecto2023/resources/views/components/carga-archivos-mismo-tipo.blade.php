<div class="row componente-carga-archivo mx-0">
    <div class="form-group {{@$en_columnas?'col-md-6':''}}">
    @php
        $documento = isset($entidad) ? $entidad->documentos()->whereHas('categoria',function($q)use($codigo){
            $q->whereCodigo($codigo);
        })->first() : null;
    @endphp
    <input onchange="inputSimple(this)" type="file" id="{{ $codigo }}" data-type="{{ $codigo }}" name="documento[{{@$entidad->id}}][file]" class="archivo-input-simple form-control visually-hidden" accept="{{isset($accept)?$accept:'.jpg,.jpeg,.png,.heic,.pdf,.doc,docx,.docx'}}" {{!isset($documento->id)&&isset($required)&&$required==true?'required':''}}/>
    
    <input type="hidden" name="documento[{{@$entidad->id}}][codigo]" value="{{$codigo}}">
    <input type="hidden" name="documento[{{@$entidad->id}}][accept]" value="{{isset($accept)?str_replace('.','',$accept):'jpg,jpeg,png,heic,pdf,doc,docx'}}">
    <div class="boton-carga input-file d-flex flex-column btn-file py-3 px-3 text-decoration-none rounded-2 position-relative">
        <div class="d-flex w-100 justify-content-between align-items-center">
            <div class="info d-flex align-items-center fw-semibold text-dark pe-2">
                <div id="simple_{{ $codigo }}_check">
                    @if($documento)
                        <svg xmlns="http://www.w3.org/2000/svg" class="text-success me-2" height="1em" viewBox="0 0 512 512">
                            <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"
                                  fill="currentColor"/>
                        </svg>
                    @endif
                </div>
                <div class="d-inline">
                    <div id="simple_{{ $codigo }}_nombre" class="break-word d-inline ">
                        @if($documento)
                            <a href="{{ url('archivos/descarga/'.$documento->ruta) }}" target="_blank" class="enlace">{{ $documento->nombre }}</a>
                        @else
                            Cargar archivo
                        @endif
                    </div>
                    <div class="d-inline fw-normal mx-2">
                        <small id="simple_{{ $codigo }}_peso">
                            @if($documento)
                                {{ $documento->peso }}
                            @else
                                (Máximo 5 MB)
                            @endif
                        </small>
                    </div>
                </div>
            </div>
            <div class="icon">
                <div id="simple_{{ $codigo }}_accion">
                    @if($documento)
                        @if(!isset($eliminable)||$eliminable==true)
                            <a href="#!" class="accion-boton-limpiar text-decoration-none text-danger" data-type="{{ $codigo }}" data-required="{{isset($required)&&$required==true?'required':''}}" onclick="eliminarArchivo(this,{{$documento->id}})">
                                <svg xmlns="http://www.w3.org/2000/svg" class="text-success me-2" height="1em" viewBox="0 0 512 512">
                            <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"
                                  fill="currentColor"/>
                                </svg>
                            </a>
                        @endif
                    @else
                        <a href="javascript:void(0)" class="accion-boton-carga-simple text-decoration-none position-absolute w-100 h-100 start-0 top-0 mt-1" data-type="{{ $codigo }}" onclick="cargaSimple(this)">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512" class="position-absolute end-0 me-3 top-0 mt-3">
                                <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path d="M288 109.3V352c0 17.7-14.3 32-32 32s-32-14.3-32-32V109.3l-73.4 73.4c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3l128-128c12.5-12.5 32.8-12.5 45.3 0l128 128c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L288 109.3zM64 352H192c0 35.3 28.7 64 64 64s64-28.7 64-64H448c35.3 0 64 28.7 64 64v32c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V416c0-35.3 28.7-64 64-64zM432 456a24 24 0 1 0 0-48 24 24 0 1 0 0 48z"
                                      fill="currentColor" />
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
        </div>
</div>
<span class="text-danger txt-parrafo-error">{{ $errors->first('documento.'.$entidad->id.'.file')}}</span>
    <div class="text-danger" id="mensaje_error_simple_{{ $codigo }}" style="display: none;">
        <small>El archivo seleccionado excede el tamaño máximo permitido.</small>
    </div>
   <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>

</div>

@if(isset($numero_oficio) && @$numero_oficio['readonly'] == false)
    <div class="form-group {{@$en_columnas?'col-md-6':'mt-2'}}">
        @if(isset($documento) && @$numero_oficio['readonly']==true)
            <p class="m-0">{{$documento->num_oficio}}</p>
        @else
            <input type="text" class="form-control input-regular-height bg-w num-expediente" name="documento[{{@$entidad->id}}][numero_oficio]" placeholder="Escriba el número de expediente" {{@$numero_oficio['required']==true?'required':''}} value="{{$documento?$documento->num_oficio:old('numero_oficio_'.$codigo)}}" {{@$numero_oficio['readonly']==true?'readonly':''}} maxlength="255">
            <span class="text-danger txt-parrafo-error">{{ $errors->first('documento['.$entidad->id.'][numero_oficio]')}}</span>
            <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
        @endif
    </div>
@endif
@if( isset($documento) && ( isset($numero_oficio) || isset($fecha_oficio) ) && (@$numero_oficio['readonly']==true || @$fecha_oficio['readonly']==true))
<div class="form-group {{@$en_columnas?'col-md-6':'mt-2'}} text-center">
    <p class="m-0">{{$documento->num_oficio}}</p>
</div>
@endif
</div>
