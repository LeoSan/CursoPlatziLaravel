<div class="form-group componente-carga-archivo {{@$en_columnas?'col-md-4':''}}">
    @php
        $documento = isset($entidad) ? $entidad->documentos()->whereHas('categoria',function($q)use($codigo){
            $q->whereCodigo($codigo);
        })->first() : null;
    @endphp
    <label class="form-label m-0" for="{{ $codigo }}" >{{$nombre??'Nombre del archivo'}}{{!isset($documento->id)&&isset($required)&&$required==true?' *':''}}</label>
    <input onchange="inputSimple(this)" type="file"  id="{{ $codigo }}" data-type="{{ $codigo }}"
           name="documento_archivo_{{ $codigo }}" class="archivo-input-simple form-control visually-hidden"
           accept="{{isset($accept)?$accept:'.jpg,.jpeg,.png,.heic,.pdf,.doc,.docx'}}"
        {{!isset($documento->id)&&isset($required)&&$required==true?'required':''}}/>
    <input type="hidden" id="accept_{{$codigo}}" name="accept_{{$codigo}}" value="{{isset($accept)?str_replace('.','',$accept):'jpg,jpeg,png,heic,pdf,doc,docx'}}">

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
                    <div id="simple_{{ $codigo }}_nombre" class="break-word d-inline">
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
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                                    <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                    <path d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm96 64c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16z"
                                          fill="currentColor" />
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

        @if( isset($documento) && ( isset($numero_oficio) || isset($fecha_oficio) ) && (@$numero_oficio['readonly']==true || @$fecha_oficio['readonly']==true))
            <div class="datos-extras d-flex w-100 gap-3 mt-3 py-1 px-3 rounded">
                <div class="w-100 border-end">
                    <label for="" class="text-gray m-0 fw-semibold">Número oficio</label>
                    <div class="">{{ @$documento->num_oficio }}</div>
                </div>
                @if(empty(@$fecha_oficio['hidden']))
                    <div class="w-100">
                        <label for="" class="text-gray m-0 fw-semibold">Fecha del oficio</label>
                        <div class="">{{ @$documento->fecha_oficio? $documento->fecha_oficio->format('d/m/Y'):'' }}</div>
                    </div>
                @endif
            </div>
        @endif
    </div>
    <div class="text-danger" id="mensaje_error_simple_{{ $codigo }}" style="display: none;">
        <small>El archivo seleccionado excede el tamaño máximo permitido.</small>
    </div>
   <div class="invalid-feedback fw-regular" data-default="Dato obligatorio."></div>


</div>
@if(isset($numero_oficio) && @$numero_oficio['readonly'] == false)
    <div class="form-group {{@$en_columnas?'col-md-4':'mt-2'}}">
        <label for="numero_oficio_{{$codigo}}" class="form-label m-0"> {{empty(@$numero_oficio['label'])? 'Número de oficio' : @$numero_oficio['label']  }} {{@$numero_oficio['required']==true?' *':''}}</label>
        @if(isset($documento) && @$numero_oficio['readonly']==true)
            <p class="m-0">{{$documento->num_oficio}}</p>
        @else
            <input type="text" class="form-control input-regular-height bg-w" name="numero_oficio_{{$codigo}}" maxlength="30" placeholder="Escriba el número de oficio" {{@$numero_oficio['required']==true?'required':''}} value="{{$documento?$documento->num_oficio:old('numero_oficio_'.$codigo)}}" {{@$numero_oficio['readonly']==true?'readonly':''}} maxlength="255">
            <div class="invalid-feedback fw-regular" data-default="Dato obligatorio."></div>
        @endif
    </div>
@endif
@if(isset($fecha_oficio) && @$fecha_oficio['readonly'] == false)
    <div class="form-group {{@$en_columnas?'col-md-4':'mt-2 mb-2'}}">
        <label for="fecha_oficio_{{$codigo}}" class="form-label m-0"> {{empty(@$fecha_oficio['label'])? 'Fecha de entrega a PGR' : @$fecha_oficio['label']  }} {{@$fecha_oficio['required']==true?' *':''}}</label>
        @if (isset($documento) && @$fecha_oficio['readonly']==true)
            <p class="m-0">{{$documento->fecha_oficio->format('Y-m-d')}}</p>
        @else
            <input type="date" class="form-control input-regular-height bg-w" name="fecha_oficio_{{$codigo}}"
            value="{{$documento && $documento->fecha_oficio ? $documento->fecha_oficio->format('Y-m-d') : old('fecha_oficio_'.$codigo) }}"
            min="1970-01-01" max="{{ empty(@$fecha_oficio['fechas_futuras'])? date('Y-m-d') : '' }}"
            {{@$fecha_oficio['readonly']==true?'readonly':''}} {{@$fecha_oficio['required']==true?'required':''}}>
            <div class="invalid-feedback fw-regular" data-default="Dato obligatorio o fecha inválida"></div>
        @endif
    </div>
@endif
