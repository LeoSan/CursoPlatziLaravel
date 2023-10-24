@extends('layouts.app')
@section('content')

    <!-- breadcrumb -->
    <div class="row d-flex justify-content-between align-items-center mb-3">
        <div class="col-12 col-md-6 row mt-1 mt-md-0">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{route('casos.index', ['asignado'=>auth()->id(), 'estatus'=>precargaEstatus()])}}" >Bandeja de casos</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ isset($caso->numero_expediente) ? $caso->numero_expediente : '## exp'}}
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-12 col-md-6 d-flex justify-content-start justify-content-md-end mt-1 mt-md-0">
            <svg xmlns="http://www.w3.org/2000/svg" height="1em" class="mt-1 me-1" viewBox="0 0 448 512">
                <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                <path
                    d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/>
            </svg>
            <a class="ml-1 fw-bold text-graydark text-sin-subrayado" href="{{session('url_casos')?session('url_casos'):route('casos.index', ['asignado'=>auth()->id(), 'estatus'=>precargaEstatus()])}}">Volver a la bandeja de casos</a>
        </div>
    </div>

    <!-- head and tabs -->
    <div class="row mb-3 font-regular-size">
        <div class="section">
            <div class="row">
                <div class="form-group col-12 col-md-auto">
                    <h5 class="fw-semibold m-0 p-0 ">
                        Expediente
                        {{ isset($caso->numero_expediente) ? $caso->numero_expediente : '##' }}
                    </h5>
                </div>
                <div class="form-group col-md-auto">
                    <div class="fw-semibold d-none d-md-inline">|</div>
                </div>
                <div class="form-group col-12 col-md-auto">
                    @include('partials.estatus', ['estatus' => $caso->estatus])
                    @if($caso->estatus->codigo=='convenio_pago' && $caso->has_pagos_vencidos)
                        <div class="w-auto text-start pendiente-box">
                            @include('partials.pago-pendiente')
                        </div>
                    @endif
                </div>
            </div>

            @include('partials.detalle-cobro')


            <nav class="pt-2">
                <div class="nav nav-tabs nav-tabs-usuario mt-3" id="nav-tab" role="tablist">
                    <button
                        class="nav-link nav-usuarios text-start p-0 me-4 {{!isset($tab_activa) || $tab_activa == null ? 'active' : ''}}"
                        id="nav-informacion-tab"
                        data-bs-toggle="tab" data-bs-target="#nav-informacion" type="button" role="tab"
                        aria-controls="nav-informacion" aria-selected="true">
                        Información
                    </button>
                    @foreach($caso->resoluciones as $resolucion)
                        <button
                            class="nav-link nav-usuarios p-0 me-4  {{ isset($tab_activa) && $tab_activa != null && $resolucion->tipo->codigo == $tab_activa ? 'active' : '' }}"
                            id="nav-{{ $resolucion->tipo->codigo }}_{{ $resolucion->id }}-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-{{ $resolucion->tipo->codigo }}_{{ $resolucion->id }}" type="button"
                            role="tab" aria-controls="nav-{{ $resolucion->tipo->codigo }}_{{ $resolucion->id }}"
                            aria-selected="false" data-resolucion_id="{{ $resolucion->id }}"
                            data-resolucion_codigo="{{ $resolucion->tipo->codigo }}"
                            onclick="obtenerInformacionResolucion(this)">

                            <span class="">
                                {{ $resolucion->tipo->nombre }}
                            </span>

                            @if(isset($resolucion->convenio->pendiente))
                                <span class="text-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                                        <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                        <path
                                            d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z"
                                            fill="currentColor"/>
                                    </svg>
                                </span>
                            @endif
                        </button>
                    @endforeach
                    <button
                        class="nav-link nav-usuarios text-start p-0 me-4"
                        id="nav-mensajes-tab"
                        data-bs-toggle="tab" data-bs-target="#nav-mensajes" type="button" role="tab"
                        aria-controls="nav-mensajes" aria-selected="true">
                        Mensajes ({{count($caso->gestionMensajes)}})
                    </button>
                </div>
            </nav>
        </div>
    </div>


    <!-- TAB CONTENT -->
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane {{!isset($tab_activa) || $tab_activa == null ? 'active' : ''}}" id="nav-informacion"
             role="tabpanel" aria-labelledby="nav-informacion-tab">

            <!-- Información general del caso -->
            <div class="row mt-4">
                <div class="section">
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
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-3 mb-2">
                                        <label for="">Departamento</label>
                                        <p>{{ $caso->departamento->nombre ?? 'Dato no proporcionado' }}</p>
                                    </div>
                                    <div class="form-group col-md-2 mb-2">
                                        <label class="form-label" for="">Municipio</label>
                                        <p>{{ $caso->municipio->nombre ?? 'Dato no proporcionado' }}</p>
                                    </div>
                                    <div class="form-group col-md-4 mb-2">
                                        <label class="form-label" for="">Fecha y hora de notificación</label>
                                        <p>{{ $caso->fecha_notificacion->format('d/m/Y').' '. $caso->hora_notificacion->format('H:i') }}</p>
                                    </div>
                                    <div class="form-group col-md-3 mb-2">
                                        <label class="form-label" for="">Número de expediente</label>
                                        <p>{{ $caso->numero_expediente ?? 'Dato no proporcionado' }}</p>
                                    </div>
                                    <div class="form-group col-md-3 mb-2">
                                        <label class="form-label" for="">Nombre del inspector</label>
                                        <p>{{ $caso->inspector->complete_name ?? 'Dato no proporcionado' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información general de la empresa notificada -->
            <div class="row mt-4">
                <div class="section">
                    <div class="text-danger d-flex align-items-center gap-2 py-2">
                        <span class="icon ">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="22px" height="18px" viewBox="0 0 22 18" version="1.1">
                                <g id="surface1">
                                    <path style=" stroke:none;fill-rule:nonzero;fill:rgb(85.882353%,27.843137%,23.529412%);fill-opacity:1;" d="M 19.820312 16 L 21.800781 16 L 21.800781 18 L 0 18 L 0 16 L 1.980469 16 L 1.980469 1 C 1.980469 0.449219 2.425781 0 2.972656 0 L 12.882812 0 C 13.429688 0 13.875 0.449219 13.875 1 L 13.875 16 L 15.855469 16 L 15.855469 6 L 18.828125 6 C 19.375 6 19.820312 6.449219 19.820312 7 Z M 5.945312 8 L 5.945312 10 L 9.910156 10 L 9.910156 8 Z M 5.945312 4 L 5.945312 6 L 9.910156 6 L 9.910156 4 Z M 5.945312 4 "/>
                                </g>
                            </svg>
                        </span>
                        <strong class="pt-1">Información de la empresa notificada</strong>
                    </div>
                    <div class="col-12">
                        <div class="card border-light-gray border-w-2 bg-white rounded-0">

                            <div class="card-body">
                                <div class="row">

                                    <div class="form-group col-md-4 mb-2">
                                        <label class="form-label" for="">Nombre comercial</label>
                                        <p>{{ $caso->empresa->nombre_comercial ?? 'Dato no proporcionado' }}</p>
                                    </div>
                                    <div class="form-group col-md-4 mb-2">
                                        <label class="form-label" for="">Razón social</label>
                                        <p>{{ $caso->empresa->razon_social ?? 'Dato no proporcionado' }}</p>
                                    </div>
                                    <div class="form-group col-md-4 mb-2">
                                        <label class="form-label" for="">Correo electrónico</label>
                                        <p>{{ $caso->empresa->correo ?? 'Dato no proporcionado' }}</p>
                                    </div>
                                    <div class="form-group col-md-4 mb-2">
                                        <label class="form-label" for="">Teléfono</label>
                                        <p>{{ $caso->empresa->telefono ?? 'Dato no proporcionado' }}</p>
                                    </div>
                                    <div class="form-group col-md-4 mb-2">
                                        <label class="form-label" for="">Representante legal</label>
                                        <p>{{ $caso->empresa->representante->nombre ?? 'Dato no proporcionado' }}</p>
                                    </div>
                                </div>
                            </div>

                            <h6 class="text-dark pb-2 px-3">
                                <strong>Representante legal</strong>
                            </h6>

                            <div class="card-body">
                                <div class="row">

                                    <div class="form-group col-md-4 mb-2">
                                        <label class="form-label" for="">Nombre</label>
                                        <p>{{ $caso->empresa->representante->nombre ?? 'Dato no proporcionado' }}</p>
                                    </div>
                                    <div class="form-group col-md-8 mb-2">
                                        <label class="form-label" for="">Número de documento nacional de
                                            identificación</label>
                                        <p>{{ $caso->empresa->representante->num_identificacion ?? 'Dato no proporcionado' }}</p>
                                    </div>

                                    <div class="form-group col-md-4 mb-2">
                                        <label class="form-label" for="">Correo electrónico</label>
                                        <p>{{ $caso->empresa->representante->correo ?? 'Dato no proporcionado' }}</p>
                                    </div>
                                    <div class="form-group col-md-8 mb-2">
                                        <label class="form-label" for="">Teléfono</label>
                                        <p>{{ $caso->empresa->representante->telefono ?? 'Dato no proporcionado' }}</p>
                                    </div>

                                </div>
                            </div>

                            <h6 class="text-dark pb-2 px-3"><strong>Dirección de la empresa notificada</strong></h6>

                            <div class="card-body">
                                <div class="row">

                                    <div class="form-group col-md-4 mb-2">
                                        <label class="form-label" for="">Departamento</label>
                                        <p>{{ $caso->domicilio->departamento->nombre ?? 'Dato no proporcionado' }}</p>
                                    </div>
                                    <div class="form-group col-md-4 mb-2">
                                        <label class="form-label" for="">Municipio</label>
                                        <p>{{ $caso->domicilio->municipio->nombre ?? 'Dato no proporcionado' }}</p>
                                    </div>
                                    <div class="form-group col-md-4 mb-2">
                                        <label class="form-label" for="">Ciudad</label>
                                        <p>{{ $caso->domicilio->ciudad ?? 'Dato no proporcionado' }}</p>
                                    </div>
                                    <div class="form-group col-md-4 mb-2">
                                        <label class="form-label" for="">Calle</label>
                                        <p>{{ $caso->domicilio->calle ?? 'Dato no proporcionado' }}</p>
                                    </div>
                                    <div class="form-group col-md-4 mb-2">
                                        <label class="form-label" for="">Número exterior</label>
                                        <p>{{ $caso->domicilio->num_exterior ?? 'Dato no proporcionado' }}</p>
                                    </div>
                                    <div class="form-group col-md-4 mb-2">
                                        <label class="form-label" for="">Número interior</label>
                                        <p>{{ $caso->domicilio->num_interior ?? 'Dato no proporcionado' }}</p>
                                    </div>
                                    <div class="form-group col-md-4 mb-2">
                                        <label class="form-label" for="">Código postal</label>
                                        <p>{{ $caso->domicilio->codigo_postal ?? 'Dato no proporcionado' }}</p>
                                    </div>

                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>

            <!-- Sanciones -->
            <div class="row mt-4">
                <div class="section">

                    <div class="text-danger d-flex align-items-center gap-2 py-2">
                        <span class="icon ">
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
                            <div class="card-body pb-4">
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table tabla-multas mb-0">
                                            <thead>
                                            <tr>
                                                <th class="">Año</th>
                                                <th class="">Tipo de infracción</th>
                                                <th class="">Monto de multa (en lempiras)</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($caso->sanciones as $sancion)
                                                <tr>
                                                    <td>{{ $sancion->tipo->anio }}</td>
                                                    <td>{{ $sancion->tipo->concepto }}</td>
                                                    <td>L {{ lempiras($sancion->cantidad_multa) }}</td>
                                                </tr>
                                            @endforeach
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td class="font-regular-size bg-graylight fw-semibold">Monto total de la multa</td>
                                                    <td>L {{ lempiras($caso->total_multa) }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documentos SETRASS -->
            <div class="row mt-4">
                <div class="section">

                    <div class="text-danger d-flex align-items-center gap-2 py-2">
                        <span class="icon ">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="14px" height="18px" viewBox="0 0 14 17" version="1.1">
                                <g id="surface1">
                                    <path style=" stroke:none;fill-rule:nonzero;fill:rgb(85.882353%,27.843137%,23.529412%);fill-opacity:1;" d="M 9.523438 1.191406 L 12.84375 4.277344 L 9.523438 4.277344 Z M 12.976562 16.628906 C 13.390625 16.628906 13.726562 16.320312 13.726562 15.933594 L 13.726562 5.441406 L 8.898438 5.441406 C 8.550781 5.441406 8.273438 5.179688 8.273438 4.855469 L 8.273438 0.371094 L 0.75 0.371094 C 0.335938 0.371094 0 0.679688 0 1.066406 L 0 15.933594 C 0 16.320312 0.335938 16.628906 0.75 16.628906 Z M 12.976562 16.628906 "/>
                                </g>
                            </svg>
                        </span>
                        <strong class="pt-1">Documentos SETRASS</strong>
                    </div>

                    <div class="col-12">
                        <div class="card bg-white border-light-gray border-w-2 rounded-0">
                            <div class="card-body pb-4">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        @include('components.carga-archivos',['codigo'=>'ficha_averiguacion','nombre'=>'Ficha de averiguación previa', 'entidad' => $caso,'eliminable'=>false])
                                    </div>
                                    @if($caso->documentos()->whereHas('categoria', function ($query) { $query->where('codigo', 'constancia_firmeza'); })->exists())
                                        <div class="col-md-4 mb-3">
                                            @include('components.carga-archivos',['codigo'=>'constancia_firmeza','nombre'=>'Constancia de firmeza', 'entidad' => $caso,'eliminable'=>false])
                                        </div>
                                    @endif

                                    @if($caso->documentos()->whereHas('categoria', function ($query) { $query->where('codigo', 'resolucion_certificada'); })->exists())
                                        <div class="col-md-4 mb-3">
                                            @include('components.carga-archivos',['codigo'=>'resolucion_certificada','nombre'=>'Resolución certificada', 'entidad' => $caso,'eliminable'=>false])
                                        </div>
                                    @endif

                                    @if($caso->documentos()->whereHas('categoria', function ($query) { $query->where('codigo', 'acuse_recibo'); })->exists())
                                        <div class="col-md-4">
                                            @include('components.carga-archivos',[
                                            'codigo'=>'acuse_recibo',
                                            'nombre'=>'Acuse de recibo',
                                            'entidad' => $caso,
                                            'numero_oficio'=>['required'=>false,'readonly'=>true],
                                            'fecha_oficio'=>['required'=>true,'readonly'=>true],
                                            'eliminable'=>false,
                                            ])
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información de entrada PGR -->
            @if($caso->estatus->codigo=="turnado_coordinador"||$caso->estatus->codigo=="turnado_procurador"||$caso->estatus->codigo=="proceso"||$caso->estatus->codigo=="proceso_demanda"||$caso->estatus->codigo=="pago_total"||$caso->estatus->codigo=="convenio_pago")
                <div class="row mt-4">
                    <div class="section">
                        <h6 class="text-danger py-2"><strong>Oficios de entrada PGR</strong></h6>
                        <div class="col-12 bg-white">
                            <div class="card bg-white border-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-4 mb-2">
                                            <label class="form-label" for="departamento_id">Número de expediente
                                                PGR</label>
                                            <p>{{@$caso->numero_expediente_pgr}}</p>
                                        </div>
                                        <div class="form-group col-md-4 mb-2">
                                            <label class="form-label" for="departamento_id">Fecha de recepción</label>
                                            <p>{{isset($caso->fecha_recepcion_pgr)?$caso->fecha_recepcion_pgr->format('d/m/Y'):''}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>


        @foreach($caso->resoluciones as $resolucion)
            <div
                class="tab-pane {{ isset($tab_activa) && $tab_activa != null && $resolucion->tipo->codigo == $tab_activa ? 'active' : '' }}"
                id="nav-{{ $resolucion->tipo->codigo }}_{{ $resolucion->id }}" role="tabpanel"
                aria-labelledby="nav-{{ $resolucion->tipo->codigo }}_{{ $resolucion->id }}-tab">
                @if($resolucion->tipo->codigo == 'pago_total')
                    @include('casos.resolucion.detalle.pago_total')
                @endif
                @if($resolucion->tipo->codigo == 'convenio_pago')
                    @include('casos.resolucion.detalle.convenio_pago')
                @endif
                @if($resolucion->tipo->codigo == 'demanda')
                    @include('casos.resolucion.detalle.demanda')
                @endif
                @if($resolucion->tipo->codigo == 'otro_descargo')
                    @include('casos.resolucion.detalle.otro_descargo')
                @endif
            </div>
        @endforeach

        <div class="tab-pane" id="nav-mensajes"
             role="tabpanel" aria-labelledby="nav-mensajes-tab">

            <!-- Mensajes del caso -->
            <div class="row mt-1">
                @forelse($caso->gestionMensajes as $mensaje)
                    <p class="text-estatus-{{$mensaje->estatus->codigo}} mb-0 mt-3">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                            <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M256 448c141.4 0 256-93.1 256-208S397.4 32 256 32S0 125.1 0 240c0 45.1 17.7 86.8 47.7 120.9c-1.9 24.5-11.4 46.3-21.4 62.9c-5.5 9.2-11.1 16.6-15.2 21.6c-2.1 2.5-3.7 4.4-4.9 5.7c-.6 .6-1 1.1-1.3 1.4l-.3 .3 0 0 0 0 0 0 0 0c-4.6 4.6-5.9 11.4-3.4 17.4c2.5 6 8.3 9.9 14.8 9.9c28.7 0 57.6-8.9 81.6-19.3c22.9-10 42.4-21.9 54.3-30.6c31.8 11.5 67 17.9 104.1 17.9zM128 208a32 32 0 1 1 0 64 32 32 0 1 1 0-64zm128 0a32 32 0 1 1 0 64 32 32 0 1 1 0-64zm96 32a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"
                                fill="currentColor"/>
                        </svg>
                        <span class="ms-1 fw-bold text-graydark">{{$mensaje->estatus->nombre}}</span></p>
                    <p class="font-small-size mb-0 fw-normal"><span
                            class="fw-bolder">Emisor:</span> {{$mensaje->creador->complete_name}}
                        | {{$mensaje->creador->perfil->show_name}}</p>
                    <p class="font-small-size mb-0 fw-normal"><span
                            class="fw-bolder">Receptor: </span>{{$mensaje->asignado->complete_name}}
                        | {{$mensaje->asignado->perfil->show_name}}</p>
                    <p class="font-small-size mb-0 me-2">{{$mensaje->created_at->format('d/m/Y H:i')}}</p>
                    <div>
                        <div class="bg-con-mensajes p-3 my-2 font-small-size mb-0 col-12 col-md-6">
                            @if($mensaje->observacion != null)
                                {!!$mensaje->observacion!!}
                            @else
                                <p class="mb-0">{{$mensaje->motivo->nombre}}</p>
                            @endif

                        </div>

                    </div>
                @empty
                    <div>
                        <div class="bg-sin-mensajes p-3 my-2 font-small-size mb-0 col-12 col-md-6">
                            Actualmente no hay mensajes
                        </div>
                        @endforelse
                    </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- BOTONES -->
        <div class="mt-4 d-flex seccion-acciones justify-content-end gap-2 gap-md-3 flex-wrap flex-md-nowrap">
            <div class="form-group mb-2 mb-md-0 w-100">
                <a class="btn btn-accion-detalle btn-default w-100"  href="{{session('url_casos')?session('url_casos'):route('casos.index', ['asignado'=>auth()->id(), 'estatus'=>precargaEstatus()])}}">
                    Cancelar
                </a>
            </div>
            @if($caso->estatus->codigo=='revision')
                @can('notificar_pgr_caso')
                    <div class="form-group mb-2 mb-md-0 w-100">
                        <a href="/casos/{{ $caso->id }}/no-procedente"
                           class="btn btn-accion-detalle bg-estatus-no_procedente">
                            <!--aquí el atributo de a qué form pertenece el submit-->
                            No procedente
                        </a>
                    </div>
                @endcan
                @can('rechazar_caso')
                    <div class="form-group mb-2 mb-md-0 w-100">
                        <a href="/casos/{{ $caso->id }}/rechazo/analista"
                           class="btn btn-accion-detalle bg-estatus-rechazado_analista w-100"
                           id="btn_rechazo_analista">
                            Regresar al inspector
                        </a>
                    </div>
                @endcan
                @can('notificar_pgr_caso')
                        <div class="form-group mb-2 mb-md-0 w-100">
                            <a href="/casos/{{ $caso->id }}/turno/seguimiento-pgr"
                                    class="btn btn-accion-detalle w-100 bg-estatus-pendiente" id="btn_seguimiento_caso">
                                <!--aquí el atributo de a qué form pertenece el submit-->
                                Solicitar seguimiento a PGR
                            </a>
                        </div>
                @endcan
            @endif
            @if(($caso->estatus->codigo=='pendiente' || $caso->estatus->codigo=='rechazado_coordinador')  && auth()->user()->can('asignar_coordinador_caso'))
                <div class="form-group mb-2 mb-md-0 w-100">
                    <a href="/casos/{{ $caso->id }}/turno/coordinador"
                       class="btn btn-accion-detalle bg-estatus-turnado_coordinador w-100"
                       id="btn_turno_coordinador">
                        Turnar a coordinador
                    </a>
                </div>
            @endif

            @if(isset($caso->id) &&  ($caso->estatus->codigo=='turnado_coordinador' || $caso->estatus->codigo=='rechazado_procurador') && auth()->user()->can('turnar_procurador_caso'))
                <div class="form-group mb-2 mb-md-0 w-100">
                    <a href="/casos/{{ $caso->id }}/rechazo/regional"
                       class="btn btn-accion-detalle bg-estatus-rechazado_coordinador w-100"
                       id="btn_rechazo_regional">
                        Regresar a DNPJ
                    </a>
                </div>
            @endif
            @if(isset($caso->id) &&  ($caso->estatus->codigo=='turnado_coordinador' || $caso->estatus->codigo == 'rechazado_procurador') && auth()->user()->can('turnar_procurador_caso'))
                <div class="form-group mb-2 mb-md-0 w-100">
                    <a href="/casos/{{ $caso->id }}/turno/procurador"
                       class="btn btn-accion-detalle bg-estatus-turnado_procurador w-100" id="btn_turno_procurador">
                        Turnar a procurador
                    </a>
                </div>
            @endif
            @if(isset($caso->id) &&  ($caso->estatus->codigo=='turnado_procurador' || $caso->estatus->codigo=="proceso" || $caso->estatus->codigo=="proceso_demanda" || $caso->estatus->codigo=="pago_total" || $caso->estatus->codigo=="convenio_pago") && auth()->user()->can('turnar_procurador_caso'))
                <div class="form-group mb-2 mb-md-0 w-100">
                    <a href="/casos/{{ $caso->id }}/turno/nuevoprocurador"
                       class="btn btn-accion-detalle bg-estatus-{{ $caso->estatus->codigo }} w-100"
                       id="btn_turno_nuevoprocurador">
                        Reasignar procurador
                    </a>
                </div>
            @endif
            @if(isset($caso->id) &&  $caso->estatus->codigo=='turnado_procurador' && auth()->user()->can('iniciar_proceso_caso'))
                <div class="form-group mb-2 mb-md-0 w-100">
                    <a href="/casos/{{ $caso->id }}/rechazo/procurador"
                       class="btn btn-accion-detalle bg-estatus-rechazado_procurador w-100"
                       id="btn_rechazo_regional">
                        Regresar a Coordinador
                    </a>
                </div>
            @endif
            @if(isset($caso->id) && ($caso->estatus->codigo=='turnado_procurador' || $caso->estatus->codigo=='info_pendiente') && auth()->user()->can('iniciar_proceso_caso'))
                <div class="form-group mb-2 mb-md-0 w-100">
                    <a href="/casos/{{ $caso->id }}/resolucion/iniciar_proceso"
                       class="btn btn-accion-detalle bg-estatus-proceso">
                        Iniciar proceso
                    </a>
                </div>
            @endif

            @if(isset($caso->id) && $caso->estatus->codigo =='proceso' && auth()->user()->can('informacion_pendiente'))
                <div class="form-group mb-2 mb-md-0 w-100">
                    <a href="#!"
                       class="btn btn-accion-detalle bg-secondary w-100"
                       data-bs-toggle="modal" data-bs-target="#infoPendienteModal">
                        Información pendiente
                    </a>
                </div>
            @endif
            @if(isset($caso->id) &&  ( $caso->estatus->codigo=='proceso' || $caso->estatus->codigo=='demanda' || ($caso->estatus->codigo=='convenio_pago' && $caso->convenio->pendiente != null) ) && (auth()->user()->can('resolucion_caso_convenio_pago') || auth()->user()->can('resolucion_caso_pago_total') || auth()->user()->can('resolucion_caso_proceso_demanda') || auth()->user()->can('otro_descargo')))
                <div class="form-group mb-2 mb-md-0 w-100 btn-group dropup">
                    <button type="button" class="btn btn-accion-detalle bg-descargo btn-lg btn-drop-resolucion" data-bs-toggle="dropdown">
                        <div class="row justify-content-between w-100">
                            <div class="col-11 text-center">
                                Descargo
                            </div>
                            <div class="col-auto text-end p-0">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 320 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#ffffff}</style><path d="M182.6 137.4c-12.5-12.5-32.8-12.5-45.3 0l-128 128c-9.2 9.2-11.9 22.9-6.9 34.9s16.6 19.8 29.6 19.8H288c12.9 0 24.6-7.8 29.6-19.8s2.2-25.7-6.9-34.9l-128-128z"/></svg>
                            </div>

                        </div>

                    </button>

                    </button>
                    <ul class="dropdown-menu w-100">
                        @if(isset($caso->id) &&  $caso->estatus->codigo=='proceso'  && (auth()->user()->can('resolucion_caso_convenio_pago')))
                            <li>
                                <div class="form-group mb-2 mb-md-0 w-100">
                                    <a href="{{route('casos.resolucion.convenio_pago',['caso_id' => $caso->id])}}" type="submit"
                                       form="form_registro_caso" class="dropdown-item w-100 bg-dropdown"
                                       data-bs-toggle="modal" data-bs-target="#procesoResolucion" data-tipo_resolucion="convenio"
                                       data-caso_id="{{$caso->id}}" onclick="getModalResolucion(this)">
                                        Convenio de pago
                                    </a>
                                </div>
                            </li>
                        @endif
                        @if(isset($caso->id) &&  ($caso->estatus->codigo=='proceso' || $caso->estatus->codigo == 'demanda') && (auth()->user()->can('resolucion_caso_pago_total')))
                        <li>
                            <div class="form-group mb-2 mb-md-0 w-100">
                                <a href="{{route('casos.resolucion.pago_total',['caso_id' => $caso->id])}}" type="submit"
                                   form="form_registro_caso" class="dropdown-item w-100 bg-dropdown"
                                   data-bs-toggle="modal" data-bs-target="#procesoResolucion" data-tipo_resolucion="pagoTotal"
                                   data-caso_id="{{$caso->id}}" onclick="getModalResolucion(this)">
                                    Pago total
                                </a>
                            </div>
                        </li>
                        @endif
                        @if(isset($caso->id) && ($caso->estatus->codigo =='proceso' || ($caso->estatus->codigo == 'convenio_pago' && $caso->convenio->pendiente != null)) && (auth()->user()->can('resolucion_caso_proceso_demanda')))
                        <li>
                            <div class="form-group mb-2 mb-md-0 w-100">
                                <a href="{{route('casos.resolucion.registro_demanda.detalle',['caso_id' => $caso->id])}}"
                                   class="dropdown-item w-100 bg-dropdown"
                                   data-bs-toggle="modal" data-bs-target="#procesoResolucion" data-tipo_resolucion="demanda"
                                   data-caso_id="{{$caso->id}}" onclick="getModalResolucion(this)">
                                    Proceso de demanda
                                </a>
                            </div>
                        </li>
                        @endif
                        @if(isset($caso->id) && $caso->estatus->codigo =='proceso' && (auth()->user()->can('otro_descargo')))
                        <li>
                            <div class="form-group mb-2 mb-md-0 w-100">
                                <a href="{{route('casos.showOtroDescargo',$caso->id)}}"
                                   class="dropdown-item w-100 bg-dropdown" >
                                    Otro descargo
                                </a>
                            </div>
                        </li>
                        @endif
                    </ul>
                </div>
            @endif

            @if($caso->estatus->codigo === 'convenio_pago' && (auth()->user()->can('resolucion_caso_convenio_pago')) )
                @if( ($caso->total_cobrado >= $caso->total_multa) || (($caso->convenio?->num_pagos +1) == $caso->convenio?->pagos?->where('pagado', true)->count()) )
                    <div class="form-group mb-2 mb-md-0 w-100">
                        <button type="button"
                                data-bs-toggle="modal" data-bs-target="#concluirModal"
                                class="btn btn-accion-detalle bg-estatus-pago_total">
                            Concluir convenio
                        </button>
                    </div>
                @endif
            @endif

        </div>
    </div>


    @include('casos.resolucion.partials.modal_concluir_convenio')
    @include('casos.resolucion.partials.modal_concluir_convenio_incompleto')
    @include('casos.resolucion.partials.modal_resoluciones')
    @include('casos.resolucion.partials.modal_info_pendiente')
@endsection
