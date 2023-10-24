@extends('layouts.app')
@section('content')
    @include('casos.partials.enlaces')
    <hr class="mt-0">

    <!--INFORMACIÓN GENERAL-->
    <form method="post" action="{{route('casos.store')}}" id="form_registro_caso" class="" enctype="multipart/form-data" novalidate>
        @csrf
        <input type="hidden" name="tipo_submit">
        <input type="hidden" name="caso_id" value="{{$caso->id??old('caso_id')}}">
        @if(@$caso->estatus->codigo=="rechazado_analista")
            <div class="row mt-3">
                <h6 class="text-danger py-2"><strong>Observaciones del analista</strong></h6>
                <div class="col-12">
                    <div class="card bg-white border-0">
                        <div class="card-body pb-4 pt-3">
                            <div class="row">
                                <div class="col-12">
                                    <p>
                                        {!! $caso->gestion()->first()->observacion !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <!--INFORMACIÓN GENERAL-->
        <div class="col-12 mt-3 mb-3">
            <div class="text-danger d-flex align-items-center gap-2 py-2">
                <span class="icon ">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewBox="0 0 18 18" version="1.1">
                        <g id="surface1">
                            <path style=" stroke:none;fill-rule:nonzero;fill:rgb(85.882353%,27.843137%,23.529412%);fill-opacity:1;" d="M 15.363281 2.636719 C 13.679688 0.941406 11.386719 -0.0078125 9 0 C 6.597656 0 4.335938 0.9375 2.636719 2.636719 C 0.941406 4.320312 -0.0078125 6.613281 0 9 C 0 11.402344 0.9375 13.664062 2.636719 15.363281 C 4.320312 17.058594 6.613281 18.007812 9 18 C 11.402344 18 13.664062 17.0625 15.363281 15.363281 C 17.058594 13.679688 18.007812 11.386719 18 9 C 18 6.597656 17.0625 4.335938 15.363281 2.636719 Z M 9 2.460938 C 10.066406 2.460938 10.933594 3.328125 10.933594 4.394531 C 10.933594 5.460938 10.066406 6.328125 9 6.328125 C 7.933594 6.328125 7.066406 5.460938 7.066406 4.394531 C 7.066406 3.328125 7.933594 2.460938 9 2.460938 Z M 11.460938 14.765625 L 6.539062 14.765625 L 6.539062 13.710938 L 7.59375 13.710938 L 7.59375 8.4375 L 6.539062 8.4375 L 6.539062 7.382812 L 10.40625 7.382812 L 10.40625 13.710938 L 11.460938 13.710938 Z M 11.460938 14.765625 "/>
                        </g>
                    </svg>
                </span>
                <strong class="pt-1">Información general</strong>
            </div>
            <div class="col-12">
                <div class="card border-light-gray border-w-2 bg-white rounded-0">
                    <div class="card-body pb-4 pt-3">
                        <div class="row">
                            <div class="form-group col-md-3 mb-3">
                                <label class="form-label" for="departamento_id">Departamento *</label>
                                <select name="caso_departamento_id" id="departamento_id" class="form-select input-regular-height bg-w"
                                        onchange="selectMunicipios(this,'municipio_caso')" required>
                                    <option value="">Seleccione</option>
                                    @foreach(getCatalogoElementos('departamentos') as $i)
                                        <option
                                            value="{{$i->id}}" {{( $caso->departamento_id==$i->id ? 'selected' : ( old('caso_departamento_id')==$i->id ? 'selected' :'' ) )}}>{{$i->nombre}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback fw-regular" data-default="Dato obligatorio">
                                </div>
                            </div>
                            <div class="form-group col-md-4 mb-3">
                                <label class="form-label" for="municipio_caso">Municipio *</label>
                                <select name="caso_municipio_id" id="municipio_caso" class="form-select input-regular-height  bg-w" required>
                                    <option value="">Seleccione el departamento</option>
                                    @foreach(getCatalogoElementos('municipios') as $i)
                                        <option
                                            value="{{$i->id}}" {{( $caso->municipio_id==$i->id ? 'selected' : ( old('caso_municipio_id')==$i->id ? 'selected' :'' ) )}}>{{$i->nombre}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback fw-regular" data-default="Dato obligatorio">
                                </div>
                            </div>
                            <div class="form-group col-md-3 mb-3">
                                <label class="form-label" for="fecha_notificacion">Fecha de notificación *</label>
                                <input type="date" class="form-control input-regular-height  bg-w" name="fecha_notificacion"
                                       id="fecha_notificacion"
                                       value="{{$caso->fecha_notificacion ? $caso->fecha_notificacion->format('Y-m-d') : old('fecha_notificacion')}}"
                                       max="{{date('Y-m-d')}}" min="1970-01-01"
                                       required
                                >
                                <div class="invalid-feedback fw-regular" data-default="Dato obligatorio o fecha inválida">
                                </div>
                            </div>
                            <div class="form-group col-md-2 mb-3">
                                <label class="form-label" for="hora_notificacion">Hora notificación *</label>
                                <input type="time" class="form-control input-regular-height  bg-w" name="hora_notificacion" id="hora_notificacion"
                                       value="{{$caso->hora_notificacion ? $caso->hora_notificacion->format('H:i:s') : old('hora_notificacion')}}" required
                                >
                                <div class="invalid-feedback fw-regular" data-default="Dato obligatorio u hora inválida">
                                </div>
                            </div>
                            <div class="form-group col-md-4 mb-3">
                                <label class="form-label" for="numero_expediente">Número de expediente *</label>
                                <input type="text" class="form-control input-regular-height  bg-w" name="numero_expediente" placeholder="ILN-"
                                       id="numero_expediente" required
                                       value="{{$caso->numero_expediente??old('numero_expediente')}}">
                                <div class="invalid-feedback fw-regular" data-default="Dato obligatorio">
                                </div>
                            </div>
                            <div class="form-group col-md-4 mb-3">
                                <label class="form-label" for="inspector">Nombre del inspector</label>
                                <p>{{isset($caso->id)?$caso->inspector->nombre_completo:Auth::user()->nombre_completo}}</p>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <div class="border-left-info px-2 py-2">
                                    <i class="fa fa-info-circle text-info"></i>
                                    <small>
                                        Sólo serán atendidos casos de la Ley de
                                        Inspección del Trabajo.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--INFORMACIÓN EMPRESA NOTIFICADA-->
        <div class="col-12 mt-3">
            <div class="text-danger d-flex align-items-center gap-2 py-2">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="22px" height="18px" viewBox="0 0 22 18" version="1.1">
                        <g id="surface1">
                            <path style=" stroke:none;fill-rule:nonzero;fill:rgb(85.882353%,27.843137%,23.529412%);fill-opacity:1;" d="M 19.820312 16 L 21.800781 16 L 21.800781 18 L 0 18 L 0 16 L 1.980469 16 L 1.980469 1 C 1.980469 0.449219 2.425781 0 2.972656 0 L 12.882812 0 C 13.429688 0 13.875 0.449219 13.875 1 L 13.875 16 L 15.855469 16 L 15.855469 6 L 18.828125 6 C 19.375 6 19.820312 6.449219 19.820312 7 Z M 5.945312 8 L 5.945312 10 L 9.910156 10 L 9.910156 8 Z M 5.945312 4 L 5.945312 6 L 9.910156 6 L 9.910156 4 Z M 5.945312 4 "/>
                        </g>
                    </svg>
                </span>
                <strong class="pt-1">Información de la empresa notificada</strong>
            </div>
            <div class="col-12">
                <div class="card bg-white border-light-gray border-w-2 rounded-0">
                    <div class="card-body pb-4 pt-3">
                        <div class="row">
                            <div class="form-group col-md-12 mb-3">
                                <label class="form-label" for="nombre_comercial">Nombre comercial *</label>
                                <input type="text" class="form-control input-regular-height bg-w" name="nombre_comercial"
                                       placeholder="Escriba el nombre comercial" id="nombre_comercial" required
                                       value="{{@$caso->empresa->nombre_comercial ?? old('nombre_comercial')}}" maxlength="255">
                                <div class="invalid-feedback fw-regular" data-default="Dato obligatorio">
                                </div>
                            </div>
                            <div class="form-group col-md-12 mb-3">
                                <label class="form-label" for="razon_social">Razón social *</label>
                                <input type="text" class="form-control input-regular-height bg-w" name="razon_social"
                                       placeholder="Escriba la razón social" id="razon_social" required
                                       value="{{@$caso->empresa->razon_social ?? old('razon_social')}}" maxlength="255">
                                <div class="invalid-feedback fw-regular" data-default="Dato obligatorio">
                                </div>
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label class="form-label" for="email_empresa">Correo electrónico de la empresa *</label>
                                <input type="email" class="form-control input-regular-height bg-w" name="email_empresa"
                                       placeholder="Escriba el correo electrónico de la empresa" id="email_empresa"
                                       required value="{{@$caso->empresa->correo ?? old('email_empresa')}}">

                                <div class="invalid-feedback fw-regular" data-default="Dato obligatorio">
                                </div>

                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label class="form-label" for="telefono_empresa">Teléfono de la empresa *</label>
                                <input type="text" class="form-control input-regular-height telefono  bg-w" minlength="8" name="telefono_empresa"
                                       placeholder="Escriba el teléfono de la empresa" id="telefono_empresa"
                                       required value="{{@$caso->empresa->telefono ?? old('telefono_empresa')}}" pattern="^\d{8}$">
                                <div class="invalid-feedback fw-regular" data-default="Dato obligatorio">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <h6 class="text-dark py-2 px-2">
                                <strong>Representante legal</strong>
                            </h6>
                            <div class="form-group col-md-6 mb-3">
                                <label class="form-label" for="nombre_representante">Nombre del representante legal *</label>
                                <input type="text" class="form-control input-regular-height bg-w" name="nombre_representante"
                                       placeholder="Escriba el nombre del representante" id="nombre_representante"
                                       required
                                       value="{{@$caso->empresa->representante->nombre ?? old('nombre_representante')}}">
                                <div class="invalid-feedback fw-regular" data-default="Dato obligatorio">
                                </div>
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label class="form-label" for="identificacion_representante">Documento Nacional de Identificación (DNI) *</label>
                                <input type="text" class="form-control input-regular-height identificacion  bg-w" minlength="13"
                                       name="identificacion_representante" placeholder="Escriba el número de documento"
                                       id="identificacion_representante" required
                                       value="{{@$caso->empresa->representante->num_identificacion ?? old('identificacion_representante')}}" pattern="^\d{13}$">
                                <div class="invalid-feedback fw-regular" data-default="Dato obligatorio">
                                </div>
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label class="form-label" for="email_representante">Correo electrónico del representante legal *</label>
                                <input type="email" class="form-control input-regular-height  bg-w" name="email_representante"
                                       placeholder="Escriba el correo electrónico del representante"
                                       id="email_representante" required
                                       value="{{@$caso->empresa->representante->correo ?? old('email_representante')}}">
                                <div class="invalid-feedback fw-regular" data-default="Dato obligatorio">
                                </div>
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label class="form-label" for="telefono_representante">Teléfono del representante legal *</label>
                                <input type="text" class="form-control input-regular-height telefono  bg-w" minlength="8"
                                       name="telefono_representante" placeholder="Escriba el teléfono del representante"
                                       id="telefono_representante" required
                                       value="{{@$caso->empresa->representante->telefono ?? old('telefono_representante')}}" pattern="^\d{8}$">
                                <div class="invalid-feedback fw-regular" data-default="Dato obligatorio">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <h6 class="text-dark pt-2 pb-1 mb-0 px-2">
                                <strong>Dirección de la empresa notificada</strong>
                            </h6>


                            @include('components.domicilio.formulario',['entidad'=>$caso])
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--SANCIONES - Multas -->
        <div class="col-12 mt-4">
            <div class="text-danger d-flex align-items-center gap-2 py-2">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewBox="0 0 18 18" version="1.1">
                        <g id="surface1">
                            <path style=" stroke:none;fill-rule:nonzero;fill:rgb(85.882353%,27.843137%,23.529412%);fill-opacity:1;" d="M 9 0 C 13.96875 0 18 4.03125 18 9 C 18 13.96875 13.96875 18 9 18 C 4.03125 18 0 13.96875 0 9 C 0 4.03125 4.03125 0 9 0 Z M 9.671875 0.828125 L 9.144531 1.429688 C 9.109375 1.46875 9.054688 1.492188 9 1.492188 C 8.945312 1.492188 8.894531 1.46875 8.859375 1.429688 L 8.328125 0.828125 C 8.289062 0.78125 8.226562 0.757812 8.164062 0.765625 C 8.105469 0.769531 8.050781 0.804688 8.019531 0.859375 L 7.621094 1.554688 C 7.59375 1.601562 7.546875 1.636719 7.492188 1.648438 C 7.441406 1.660156 7.382812 1.644531 7.339844 1.613281 L 6.699219 1.128906 C 6.652344 1.09375 6.585938 1.082031 6.527344 1.101562 C 6.46875 1.117188 6.421875 1.164062 6.40625 1.222656 L 6.15625 1.984375 C 6.136719 2.035156 6.097656 2.078125 6.046875 2.101562 C 6 2.121094 5.941406 2.121094 5.890625 2.097656 L 5.167969 1.753906 C 5.113281 1.726562 5.046875 1.730469 4.992188 1.757812 C 4.9375 1.789062 4.902344 1.84375 4.894531 1.90625 L 4.804688 2.699219 C 4.796875 2.753906 4.769531 2.804688 4.722656 2.835938 C 4.679688 2.867188 4.621094 2.878906 4.570312 2.863281 L 3.792969 2.671875 C 3.730469 2.660156 3.667969 2.675781 3.621094 2.714844 C 3.574219 2.753906 3.550781 2.816406 3.558594 2.875 L 3.628906 3.671875 C 3.632812 3.726562 3.613281 3.78125 3.574219 3.820312 C 3.539062 3.863281 3.484375 3.882812 3.429688 3.882812 L 2.628906 3.851562 C 2.566406 3.847656 2.507812 3.875 2.472656 3.925781 C 2.433594 3.972656 2.421875 4.039062 2.4375 4.097656 L 2.667969 4.863281 C 2.683594 4.917969 2.675781 4.972656 2.648438 5.019531 C 2.621094 5.066406 2.570312 5.097656 2.519531 5.105469 L 1.726562 5.238281 C 1.667969 5.25 1.613281 5.289062 1.585938 5.34375 C 1.558594 5.398438 1.5625 5.464844 1.589844 5.519531 L 1.96875 6.222656 C 1.996094 6.269531 2 6.328125 1.980469 6.378906 C 1.960938 6.429688 1.921875 6.472656 1.871094 6.492188 L 1.125 6.78125 C 1.066406 6.800781 1.023438 6.851562 1.007812 6.910156 C 0.992188 6.96875 1.007812 7.03125 1.046875 7.078125 L 1.558594 7.695312 C 1.59375 7.738281 1.609375 7.792969 1.601562 7.847656 C 1.59375 7.898438 1.5625 7.949219 1.515625 7.976562 L 0.839844 8.410156 C 0.789062 8.441406 0.757812 8.5 0.753906 8.5625 C 0.75 8.621094 0.777344 8.679688 0.824219 8.71875 L 1.453125 9.21875 C 1.542969 9.289062 1.550781 9.425781 1.46875 9.503906 L 0.894531 10.0625 C 0.847656 10.109375 0.828125 10.167969 0.839844 10.230469 C 0.847656 10.289062 0.886719 10.34375 0.941406 10.371094 L 1.65625 10.734375 C 1.757812 10.785156 1.792969 10.914062 1.726562 11.011719 L 1.277344 11.671875 C 1.242188 11.726562 1.234375 11.789062 1.257812 11.847656 C 1.277344 11.90625 1.324219 11.949219 1.386719 11.964844 L 2.160156 12.175781 C 2.269531 12.207031 2.328125 12.328125 2.285156 12.433594 L 1.976562 13.171875 C 1.953125 13.230469 1.960938 13.296875 1.992188 13.347656 C 2.023438 13.398438 2.082031 13.433594 2.144531 13.4375 L 2.941406 13.488281 C 3.058594 13.496094 3.140625 13.601562 3.117188 13.714844 L 2.964844 14.5 C 2.953125 14.5625 2.972656 14.625 3.015625 14.667969 C 3.058594 14.710938 3.117188 14.734375 3.179688 14.726562 L 3.972656 14.613281 C 4.085938 14.597656 4.191406 14.6875 4.191406 14.800781 L 4.203125 15.601562 C 4.203125 15.734375 4.332031 15.824219 4.457031 15.78125 L 5.210938 15.511719 C 5.261719 15.492188 5.320312 15.496094 5.367188 15.523438 C 5.414062 15.550781 5.449219 15.597656 5.460938 15.648438 L 5.632812 16.433594 C 5.644531 16.492188 5.6875 16.542969 5.742188 16.566406 C 5.800781 16.589844 5.863281 16.585938 5.917969 16.554688 L 6.605469 16.140625 C 6.652344 16.113281 6.707031 16.105469 6.757812 16.121094 C 6.8125 16.136719 6.855469 16.175781 6.875 16.226562 L 7.203125 16.957031 C 7.253906 17.078125 7.410156 17.109375 7.507812 17.019531 L 8.09375 16.476562 C 8.132812 16.4375 8.1875 16.421875 8.242188 16.425781 C 8.296875 16.429688 8.347656 16.460938 8.378906 16.503906 L 8.84375 17.15625 C 8.921875 17.261719 9.078125 17.261719 9.15625 17.15625 L 9.621094 16.503906 C 9.652344 16.460938 9.703125 16.429688 9.757812 16.425781 C 9.8125 16.421875 9.867188 16.4375 9.90625 16.476562 L 10.496094 17.019531 C 10.589844 17.109375 10.746094 17.078125 10.796875 16.957031 L 11.125 16.226562 C 11.144531 16.175781 11.1875 16.136719 11.242188 16.121094 C 11.292969 16.105469 11.351562 16.113281 11.398438 16.140625 L 12.082031 16.554688 C 12.136719 16.585938 12.199219 16.59375 12.257812 16.566406 C 12.3125 16.542969 12.355469 16.492188 12.367188 16.433594 L 12.539062 15.648438 C 12.550781 15.597656 12.585938 15.550781 12.632812 15.523438 C 12.679688 15.496094 12.738281 15.492188 12.789062 15.511719 L 13.542969 15.78125 C 13.601562 15.800781 13.667969 15.792969 13.71875 15.757812 C 13.769531 15.722656 13.796875 15.664062 13.800781 15.601562 L 13.808594 14.800781 C 13.808594 14.746094 13.835938 14.695312 13.875 14.660156 C 13.917969 14.621094 13.972656 14.605469 14.027344 14.613281 L 14.820312 14.726562 C 14.949219 14.742188 15.058594 14.628906 15.035156 14.5 L 14.882812 13.714844 C 14.871094 13.660156 14.886719 13.605469 14.917969 13.5625 C 14.953125 13.515625 15.003906 13.492188 15.058594 13.488281 L 15.859375 13.4375 C 15.921875 13.433594 15.976562 13.398438 16.007812 13.347656 C 16.039062 13.292969 16.046875 13.230469 16.023438 13.171875 L 15.714844 12.433594 C 15.695312 12.382812 15.695312 12.324219 15.71875 12.277344 C 15.746094 12.226562 15.789062 12.191406 15.84375 12.175781 L 16.613281 11.964844 C 16.675781 11.949219 16.722656 11.90625 16.746094 11.847656 C 16.765625 11.789062 16.757812 11.726562 16.722656 11.671875 L 16.273438 11.011719 C 16.242188 10.964844 16.234375 10.90625 16.246094 10.855469 C 16.261719 10.800781 16.296875 10.757812 16.34375 10.734375 L 17.058594 10.371094 C 17.113281 10.34375 17.152344 10.289062 17.164062 10.230469 C 17.171875 10.167969 17.152344 10.105469 17.105469 10.0625 L 16.535156 9.503906 C 16.492188 9.464844 16.472656 9.414062 16.476562 9.359375 C 16.480469 9.304688 16.507812 9.253906 16.550781 9.21875 L 17.175781 8.71875 C 17.226562 8.683594 17.25 8.621094 17.25 8.5625 C 17.246094 8.5 17.214844 8.445312 17.160156 8.410156 L 16.484375 7.976562 C 16.441406 7.949219 16.410156 7.898438 16.402344 7.847656 C 16.390625 7.792969 16.40625 7.738281 16.441406 7.695312 L 16.957031 7.078125 C 16.996094 7.03125 17.011719 6.96875 16.996094 6.910156 C 16.980469 6.851562 16.9375 6.800781 16.878906 6.78125 L 16.132812 6.492188 C 16.082031 6.472656 16.039062 6.429688 16.019531 6.378906 C 16.003906 6.328125 16.007812 6.269531 16.03125 6.222656 L 16.410156 5.519531 C 16.441406 5.464844 16.441406 5.398438 16.414062 5.34375 C 16.386719 5.289062 16.335938 5.25 16.277344 5.238281 L 15.484375 5.105469 C 15.429688 5.097656 15.382812 5.066406 15.355469 5.019531 C 15.324219 4.972656 15.316406 4.917969 15.332031 4.863281 L 15.5625 4.097656 C 15.582031 4.039062 15.570312 3.972656 15.53125 3.925781 C 15.492188 3.875 15.433594 3.847656 15.375 3.851562 L 14.570312 3.882812 C 14.515625 3.882812 14.464844 3.863281 14.425781 3.820312 C 14.390625 3.78125 14.371094 3.726562 14.375 3.671875 L 14.445312 2.875 C 14.453125 2.8125 14.425781 2.753906 14.378906 2.714844 C 14.332031 2.675781 14.269531 2.660156 14.210938 2.671875 L 13.433594 2.863281 C 13.378906 2.878906 13.324219 2.867188 13.277344 2.835938 C 13.234375 2.804688 13.203125 2.753906 13.195312 2.699219 L 13.105469 1.90625 C 13.097656 1.84375 13.0625 1.789062 13.007812 1.757812 C 12.953125 1.730469 12.890625 1.726562 12.835938 1.753906 L 12.109375 2.097656 C 12.0625 2.121094 12.003906 2.121094 11.953125 2.101562 C 11.902344 2.078125 11.863281 2.035156 11.847656 1.984375 L 11.597656 1.222656 C 11.578125 1.164062 11.53125 1.117188 11.472656 1.101562 C 11.414062 1.082031 11.351562 1.09375 11.300781 1.128906 L 10.660156 1.613281 C 10.617188 1.644531 10.5625 1.660156 10.507812 1.648438 C 10.453125 1.636719 10.40625 1.601562 10.378906 1.554688 L 9.984375 0.859375 C 9.953125 0.804688 9.898438 0.769531 9.835938 0.765625 C 9.777344 0.757812 9.714844 0.78125 9.675781 0.828125 Z M 9 2.25 C 12.726562 2.25 15.75 5.273438 15.75 9 C 15.75 12.726562 12.726562 15.75 9 15.75 C 5.273438 15.75 2.25 12.726562 2.25 9 C 2.25 5.273438 5.273438 2.25 9 2.25 Z M 8.574219 5.28125 L 6.671875 5.28125 L 6.671875 12 L 11.777344 12 L 11.777344 10.492188 L 8.574219 10.492188 Z M 8.574219 5.28125 "/>
                        </g>
                    </svg>
                </span>
                <strong class="pt-1">Multas</strong>
            </div>
            <div class="col-12">
                <div class="card bg-white border-light-gray border-w-2 rounded-0">
                    <div class="card-body pb-2 pt-4">

                        <div class="row">
                            {{-- Año --}}
                            <div class="form-group col-md-4">
                                <div class="tool-card-container">
                                    @include('casos.partials.tool-card', ['tool_card'=>'tool-anio', 'tipo'=> 'tool-card-anio' ,'mensaje'=>'Si selecciona un año distinto, <span class="textred">se eliminarán todas las multas registradas</span> para este caso.'])
                                    <span class="icon ">
                                        <svg width="21" height="21" viewBox="0 0 21 21" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.5 0C16.299 0 21 4.701 21 10.5S16.299 21 10.5 21 0 16.299 0 10.5 4.701 0 10.5 0zm1.51 5.5H7.09v2.295h1.95V16h2.97V5.5z" fill="#555770" fill-rule="evenodd"/>
                                        </svg>
                                    </span>
                                    <label class="form-label" for="anio_infraccion">Año *</label>
                                </div>

                                <select id="anio_infraccion" class="form-select input-regular-height bg-w"
                                        onclick="showTooltipClickAnioMulta('tool-anio', 'idTableMulta', 'bg-multa')"
                                        onchange="anioInfraccion(this,'infraccion_id', '{{$anio}}')" {{$caso->sanciones->count()>0?'':'required'}}>
                                    <option value="">Seleccione el año</option>
                                    @foreach($anios as $i)
                                        <option
                                            value="{{$i->anio}}" {{$anio==$i->anio?'selected':''}}>{{$i->anio}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback fw-regular" data-default="El año es obligatorio">
                                </div>
                            </div>
                            {{-- Tipo Multa --}}
                            <div class="form-group col-md-4">
                                <div class="tool-card-container">
                                    @include('casos.partials.tool-card', ['tool_card'=>'tool-multa','tipo'=> 'tool-card-multa' ,'mensaje'=>'Para seleccionar el tipo de infracción, primero debe seleccionar el año.'])
                                    <span class="icon">
                                        <svg width="21" height="21" viewBox="0 0 21 21" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.5 0C16.299 0 21 4.701 21 10.5S16.299 21 10.5 21 0 16.299 0 10.5 4.701 0 10.5 0zm-.15 5c-1.01 0-1.885.195-2.625.585-.74.39-1.315.925-1.725 1.605l2.205 1.23A2.154 2.154 0 0 1 10.08 7.4c.44 0 .775.095 1.005.285.23.19.345.455.345.795 0 .26-.065.518-.195.772-.13.255-.385.563-.765.923L6.54 13.85v1.86h8.175v-2.355h-4.05l1.98-1.83c.7-.64 1.172-1.213 1.418-1.718a3.647 3.647 0 0 0 .367-1.612c0-.64-.173-1.203-.517-1.688-.346-.484-.826-.857-1.44-1.117C11.858 5.13 11.15 5 10.35 5z" fill="#555770" fill-rule="evenodd"/>
                                        </svg>
                                    </span>
                                    <label class="form-label" for="infraccion_id">Tipo de infracción *</label>
                                </div>
                                <select id="infraccion_id" class="form-select input-regular-height bg-w campo-dis"
                                        onclick="showTooltipClick('tool-multa', 'infraccion_id', 'campo-dis')"
                                        onchange="selectedInfraccion(this,'monto_infraccion')" {{$caso->sanciones->count()>0?'':'required'}}  >
                                    <option value="">Seleccione el año</option>
                                </select>
                                <div class="invalid-feedback fw-regular" data-default="El tipo de infracción es obligatorio">
                                </div>
                            </div>
                            {{-- Monto --}}
                            <div class="form-group col-md-4">
                                <div class="tool-card-container">
                                    @include('casos.partials.tool-card', ['tool_card'=>'tool-monto','tipo'=> 'tool-card-monto' ,'mensaje'=>'No es posible editar el monto de la multa para el tipo de infracción seleccionado.'])
                                    <span class="icon">
                                        <svg width="21" height="21" viewBox="0 0 21 21" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.5 0C16.299 0 21 4.701 21 10.5S16.299 21 10.5 21 0 16.299 0 10.5 4.701 0 10.5 0zm3.57 5.5H6.48v2.295h4.14L8.745 9.82v1.875H9.99c1.07 0 1.605.34 1.605 1.02 0 .35-.15.62-.45.81-.3.19-.705.285-1.215.285-.5 0-1.007-.075-1.522-.225a4.841 4.841 0 0 1-1.388-.645l-1.08 2.235c.53.33 1.157.585 1.882.765.726.18 1.458.27 2.198.27 1.01 0 1.858-.163 2.543-.488.684-.324 1.195-.752 1.53-1.282.335-.53.502-1.105.502-1.725 0-.76-.233-1.408-.697-1.942-.465-.535-1.133-.893-2.003-1.073l2.175-2.34V5.5z" fill="#555770" fill-rule="evenodd"/>
                                        </svg>
                                    </span>
                                    <label class="form-label" for="monto_infraccion">Monto de la multa (en lempiras) *</label>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">L</span>
                                    <input type="text" class="form-control input-regular-height bg-w campo-dis" placeholder="Seleccione la infracción" maxlength="29"
                                            onclick="showTooltipClick('tool-monto', 'monto_infraccion', 'campo-dis')"
                                            id="monto_infraccion" readonly {{$caso->sanciones->count()>0?'':'required'}} />
                                    <div class="invalid-feedback fw-regular" data-default="El monto de la multa es obligatorio">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-end">
                            <div class="form-group col-md-2 d-flex align-items-center">
                                <button class="text-danger w-100 py-2" type="button"  disabled  onclick="agregarInfraccion()" id="btn_agregar_multa">
                                        <strong>Agregar multa </strong>
                                        <span class="icon">
                                            <svg width="22" height="22" viewBox="0 0 22 22" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                <defs>
                                                    <path d="M12.15 4.95a.5.5 0 0 1 .5.5v3.899l3.9.001a.5.5 0 0 1 .5.5v2.3a.5.5 0 0 1-.5.5l-3.9-.001v3.901a.5.5 0 0 1-.5.5h-2.3a.5.5 0 0 1-.5-.5v-3.901l-3.9.001a.5.5 0 0 1-.5-.5v-2.3a.5.5 0 0 1 .5-.5l3.899-.001.001-3.899a.5.5 0 0 1 .5-.5h2.3zM11 0C4.935 0 0 4.935 0 11s4.935 11 11 11 11-4.935 11-11S17.065 0 11 0" id="073nx0unha"/>
                                                </defs>
                                                <use fill="#DB473C" xlink:href="#073nx0unha" fill-rule="evenodd"/>
                                            </svg>
                                        </span>
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12" id="alerta_sanciones"></div>

                                <div id="divlistMultas" class="col-md-12 table-responsive {{count($caso->sanciones)?'show':'d-none'}}" >
                                    <table id="idTableMulta" class="table text-center tabla-casos text-sm w-100">
                                        <thead>
                                        <tr class="py-2">
                                            <th>Año</th>
                                            <th>Tipo de infracción</th>
                                            <th>Monto de multa (en lempiras)</th>
                                            <th>Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody id="body_tabla_sanciones">
                                        @forelse($caso->sanciones as $i)
                                            <tr class="bg-multa">
                                                <td style="max-width: 70px">
                                                    <input type="hidden" name="sanciones['{{$i->id}}']['infraccion_id']"
                                                        value="{{$i->tipo_id}}">
                                                    <input name="sanciones['{{$i->id}}']['anio']" type="hidden" value="{{$i->tipo->anio}}">
                                                    {{$i->tipo->anio}}
                                                </td>
                                                <td>
                                                    <input name="sanciones['{{$i->id}}']['concepto']" type="hidden" value="{{$i->tipo->concepto}}">
                                                    {{$i->tipo->concepto}}
                                                </td>
                                                <td style="min-width: 120px">
                                                    <input name="sanciones['{{$i->id}}']['monto']" id="monto-{{$i->id}}"
                                                        type="text" class="w-100 p-0 m-0 text-center monto_infraccion"
                                                        readonly maxlength="29" value="L {{lempiras($i->cantidad_multa)}}">
                                                </td>
                                                <td style="min-width: 100px">
                                                    @if($i->tipo->editable)
                                                        <button type="button" class="btn btn-sm btn-info my-1"
                                                                title="Editar infracción"
                                                                onclick="editarInfraccion(this,'{{$i->id}}')">
                                                            <i class="fa fa-edit text-white p-0 m-0"></i>
                                                        </button>
                                                    @endif
                                                    <button type="button" class="btn btn-sm btn-danger my-1"
                                                            title="Eliminar infracción" onclick="eliminarInfraccion(this)">
                                                        <i class="fa fa-trash text-white p-0 m-0"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr id="tr_info_sanciones">
                                                <td colspan="4" class="py-2">Sin infracciones</td>
                                            </tr>
                                        @endforelse
                                        <tr>
                                            <td class="bg-graylight">&nbsp;</td>
                                            <td colspan="1" class="py-2 px-3 text-end bg-graylight">
                                                <small>
                                                    Monto total de la multa
                                                </small>
                                            </td>
                                            <td colspan="1" class="py-2 bg-graylight">
                                                <small id="total_multa" class="fw-semibold">
                                                    L {{isset($caso->id) ? lempiras($caso->total_multa) : '0.00'}}
                                                </small>
                                            </td>
                                            <td class="bg-graylight">&nbsp;</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--DOCUMENTOS-->
        <div class="col-12 mt-4">
            <div class="text-danger d-flex align-items-center gap-2 py-2">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="14px" height="18px" viewBox="0 0 14 17" version="1.1">
                        <g id="surface1">
                            <path style=" stroke:none;fill-rule:nonzero;fill:rgb(85.882353%,27.843137%,23.529412%);fill-opacity:1;" d="M 9.523438 1.191406 L 12.84375 4.277344 L 9.523438 4.277344 Z M 12.976562 16.628906 C 13.390625 16.628906 13.726562 16.320312 13.726562 15.933594 L 13.726562 5.441406 L 8.898438 5.441406 C 8.550781 5.441406 8.273438 5.179688 8.273438 4.855469 L 8.273438 0.371094 L 0.75 0.371094 C 0.335938 0.371094 0 0.679688 0 1.066406 L 0 15.933594 C 0 16.320312 0.335938 16.628906 0.75 16.628906 Z M 12.976562 16.628906 "/>
                        </g>
                    </svg>
                </span>
                <strong class="pt-1">Documentos</strong>
            </div>
            <div class="col-12">
                <div class="card bg-white border-light-gray border-w-2 rounded-0">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-4">
                                @include('components.carga-archivos',['codigo'=>'ficha_averiguacion','nombre'=>'Ficha de averiguación previa', 'entidad' => $caso,'required'=>true,'accept'=>'.pdf,.png,.jpg,.jpge'])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--DIRECCIÓN DE LA EMPRESA-->
    <div class="row mt-4 justify-content-end">

        <div class="form-group col-md-3 mb-2 mb-md-0">
            <a class="btn btn-accion-detalle btn-default w-100"  href="{{session('url_casos')?session('url_casos'):route('casos.index', ['asignado'=>auth()->id(), 'estatus'=>precargaEstatus()])}}">
                Cancelar
            </a>
        </div>

        @if( isset($caso->id) && $caso->estatus->codigo=='captura')
            <div class="form-group col-md-3 mb-2 mb-md-0">
                <button type="button" data-bs-target="#eliminarCasoModal" data-bs-toggle="modal"
                        class="btn btn-accion-detalle btn-danger btn-pgr w-100" onclick="eliminarCaso({{$caso->id}})">
                    Eliminar Borrador
                </button>
            </div>
        @endif

        @if( !isset($caso->id) || $caso->estatus->codigo=='captura')
            <div class="form-group col-md-3 mb-2 mb-md-0">
                <button class="btn btn-accion-detalle btn-warning btn-pgr w-100" type="submit" form="form_registro_caso"
                        id="btn_borrador_caso">Guardar Cambios
                </button>
            </div>
        @endif
        <div class="form-group col-md-3 mb-2 mb-md-0">
            <button type="submit" form="form_registro_caso" class="btn btn-accion-detalle btn-success btn-pgr w-100"
                    id="btn_envio_caso">Enviar a Revisión
            </button>
        </div>

        @if(isset($caso->id) &&  $caso->estatus->codigo=='revision' && auth()->user()->can('notificar_pgr_caso'))
            <div class="form-group col-md-3 mb-2 mb-md-0">
                <a href="/casos/{{ $caso->id }}/rechazo/analista" class="btn btn-accion-detalle btn-turno w-100"
                   id="btn_rechazo_analista">Regresar al inspector</a>
            </div>
        @endif

        @if( isset($caso->id) &&  ($caso->estatus->codigo=='pendiente' || $caso->estatus->codigo=='rechazado_coordinador')  && auth()->user()->can('asignar_coordinador_caso'))
            <div class="form-group col-md-3 mb-2 mb-md-0">
                <a href="/casos/{{ $caso->id }}/turno/coordinador" class="btn btn-accion-detalle btn-turno w-100"
                   id="btn_turno_coordinador">Turnar a coordinador</a>
            </div>
        @endif


        @if(isset($caso->id) &&  $caso->estatus->codigo=='turnado_coordinador' && auth()->user()->can('turnar_procurador_caso'))
            <div class="form-group col-md-3 mb-2 mb-md-0">
                <a href="/casos/{{ $caso->id }}/turno/procurador" class="btn btn-accion-detalle btn-turno w-100"
                   id="btn_turno_procurador">Turnar a procurador</a>
            </div>
        @endif

        @if(isset($caso->id) &&  $caso->estatus->codigo=='turnado_coordinador' && auth()->user()->can('turnar_procurador_caso'))
            <div class="form-group col-md-3 mb-2 mb-md-0">
                <a href="/casos/{{ $caso->id }}/rechazo/regional" class="btn btn-accion-detalle btn-turno w-100"
                   id="btn_rechazo_regional">Regresar a DNPJ</a>
            </div>
        @endif

    </div>
    @include('casos.partials.eliminar_caso')
@endsection
