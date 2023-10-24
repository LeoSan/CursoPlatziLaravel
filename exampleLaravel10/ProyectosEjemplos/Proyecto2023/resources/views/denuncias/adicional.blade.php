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

    {{-- Inicio Acordion --}}
    <div class="accordion" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button titulo-bg-gray" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <svg width="19" height="19" viewBox="0 0 19 19" xmlns="http://www.w3.org/2000/svg" >
                        <path d="M9.5 0C4.262 0 0 4.262 0 9.5S4.262 19 9.5 19 19 14.738 19 9.5 14.738 0 9.5 0zm1.583 15.438a.396.396 0 0 1-.396.395H8.313a.396.396 0 0 1-.396-.396V9.5H7.52a.396.396 0 0 1-.396-.396V7.521c0-.219.177-.396.396-.396h3.167c.218 0 .395.177.395.396v7.917zM9.5 6.332c-.873 0-1.583-.71-1.583-1.583s.71-1.583 1.583-1.583 1.583.71 1.583 1.583-.71 1.583-1.583 1.583z" fill="#555770" fill-rule="nonzero"/>
                    </svg>
                    <span class="px-2">
                        Información general
                    </span>
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse @if ($denuncia->estatus_id == obtenerIdCatalogoElementCodigo('pendiente') ) {{'show'}} @endif" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body bg-white">
                    {{-- Fragmento Datos de la denuncia --}}
                    @include('denuncias.fragmentos.info-datos-denuncia', ['denuncia' => $denuncia, 'documento'=>$documento])
                    {{-- fragmento Listado Archivos pruebas de las denuncias --}}
                    @include('denuncias.fragmentos.info-pruebas-denuncia', ['doc_list' => $doc_evidencias_denuncia,'denuncia' => $denuncia, 'col'=>'row'])
                </div>
            </div>
        </div>

        @can('registrar_denuncias')
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
              <button class="accordion-button collapsed titulo-bg-gray" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    <svg width="16" height="13" viewBox="0 0 16 13" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.711 1.693 14.307.289A.955.955 0 0 0 13.605 0a.955.955 0 0 0-.702.289L6.132 7.071 3.097 4.026a.955.955 0 0 0-.702-.29.956.956 0 0 0-.702.29L.289 5.43A.956.956 0 0 0 0 6.132c0 .275.096.509.289.702l3.737 3.736 1.404 1.404a.955.955 0 0 0 .702.29c.275 0 .509-.097.702-.29l1.403-1.404 7.474-7.473A.956.956 0 0 0 16 2.395a.956.956 0 0 0-.289-.702z" fill="#555770" fill-rule="nonzero"/>
                    </svg>
                    <span class="px-2">
                        Alta de la denuncia
                    </span>
              </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse  @if ($denuncia->estatus_id == obtenerIdCatalogoElementCodigo('en_revision') ) {{'show'}} @endif" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="accordion-body bg-white">
                    {{-- Fragmento Datos de la denuncia --}}
                    @include('denuncias.fragmentos.info-alta-denuncia', ['denuncia' => $denuncia, 'doc_alta_denun'=>$doc_alta_denuncia])
                </div>
            </div>
        </div>
        @endcan

        @if($denuncia->hasEstatus('providencia'))
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed titulo-bg-gray" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        <svg width="20" height="17" viewBox="0 0 20 17" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1.482 16.786a.696.696 0 0 1-.696-.695v-2.433c0-.383.312-.694.696-.695h11.17a3.304 3.304 0 0 0 3.306-3.301A3.304 3.304 0 0 0 12.65 6.36H9.65l.493 1.398a.694.694 0 0 1-1.1.767L4.75 4.985a.717.717 0 0 1 0-1.072L9.043.373a.697.697 0 0 1 1.1.767L9.65 2.538h3.001c3.94 0 7.135 3.19 7.135 7.124 0 3.934-3.194 7.124-7.135 7.124H1.482z" fill="#555770" fill-rule="nonzero"/>
                        </svg>                   

                        <span class="px-2">
                            Providencia
                        </span> 
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse {{$denuncia->estatus->codigo=='providencia' || $denuncia->estatus->codigo=='solventado' ? 'show' : ''}}" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                    <div class="accordion-body bg-white">
                        {{-- Fragmento Datos de la denuncia --}}
                        @include('denuncias.fragmentos.info-providencia', ['denuncia' => $denuncia, 'doc_providencia_denuncia'=>$doc_providencia_denuncia, 'doc_resp_providencia'=>$doc_resp_providencia, 'col'=>'col-12'])

                            {{-- Si soy Denunciante y mi Plazo es menor 16 Puedo aun Dar respuesta  --}}
                            @if ( auth()->user()->hasRole('denunciante') && $denuncia->gestion()->first()->vencido==false && $denuncia->estatus->codigo=='providencia'  )
                                @include('denuncias.fragmentos.info-adicional-form', ['denuncia'=>$denuncia])
                            @endif
                            {{-- Si No sOY Denunciante y el plazo esta vencido si me deja cargar información nueva --}}
                            @if ( !auth()->user()->hasRole('denunciante') )
                                @include('denuncias.fragmentos.info-adicional-form', ['denuncia'=>$denuncia])
                            @endif

                    </div>
                </div>
            </div>
        @endif

        @if ($denuncia->estatus->codigo=='desestimado' || $denuncia->hasEstatus('desestimado'))
            <div class="accordion-item rounded-0 mb-2 border-0">
                <h2 class="accordion-header" id="headigDesestimacion">
                    <button class="accordion-button collapsed titulo-bg-gray text-gray fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDesestimacion" aria-expanded="false" aria-controls="collapseDesestimacion">
                        <svg width="22" height="20" viewBox="0 0 22 20" xmlns="http://www.w3.org/2000/svg">
                            <g fill="#555770" fill-rule="nonzero">
                                <path d="M8.258 11.371h-4.47a.75.75 0 0 1-.758-.757c0-.417.334-.758.758-.758h3.576a7.624 7.624 0 0 1-.5-1.432H3.788a.755.755 0 0 1-.758-.757c0-.417.334-.758.758-.758h2.856c-.008-.129-.008-.25-.008-.379 0-.901.152-1.765.425-2.575H2.727A2.73 2.73 0 0 0 0 6.682v7.863a2.72 2.72 0 0 0 2.44 2.705v1.598A1.147 1.147 0 0 0 3.59 20c.258 0 .508-.083.713-.25l1.705-1.34a5.296 5.296 0 0 1 3.28-1.145h5.242c1.5 0 2.728-1.22 2.728-2.72v-.393a8.036 8.036 0 0 1-9-2.78zm.37 2.955h-4.84a.755.755 0 0 1-.758-.758c0-.416.334-.757.758-.757h4.84a.76.76 0 0 1 .758.757.76.76 0 0 1-.757.758z"/>
                                <path d="M14.674 0c3.599 0 6.53 2.932 6.53 6.53a6.536 6.536 0 0 1-6.53 6.53 6.531 6.531 0 0 1-6.53-6.53A6.536 6.536 0 0 1 14.674 0zm1.296 4.356c-.099 0-.185.036-.257.109l-1.035 1.034-1.035-1.034a.352.352 0 0 0-.257-.109.358.358 0 0 0-.263.109l-.514.514a.358.358 0 0 0-.109.263c0 .1.036.185.109.257l1.034 1.035L12.61 7.57a.352.352 0 0 0-.109.257c0 .103.036.19.109.263l.514.515c.073.072.16.108.263.108.1 0 .185-.036.257-.108l1.035-1.035 1.035 1.035a.352.352 0 0 0 .257.108c.103 0 .19-.036.263-.108l.515-.515a.358.358 0 0 0 .108-.263c0-.099-.036-.185-.108-.257l-1.035-1.035L16.748 5.5a.351.351 0 0 0 .108-.257.358.358 0 0 0-.108-.263l-.515-.514a.358.358 0 0 0-.263-.109z"/>
                            </g>
                        </svg>
                        <span class="px-2">
                        Desestimación
                        </span>
                    </button>
                </h2>
                <div id="collapseDesestimacion" class="accordion-collapse collapse {{$denuncia->estatus->codigo=='desestimado'?'show':''}}" aria-labelledby="headigDesestimacion" data-bs-parent="#accordionDetalle">
                    <div class="accordion-body bg-white">
                        @include('denuncias.fragmentos.info-desistimiento')
                    </div>
                </div>
            </div>
        @endif        

        @if($denuncia->hasEstatus('admitida'))
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingAdmision">
                    <button class="accordion-button collapsed titulo-bg-gray text-gray fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdmision" aria-expanded="false" aria-controls="collapseAdmision">
                    <svg width="19" height="15" viewBox="0 0 19 15" xmlns="http://www.w3.org/2000/svg">
                            <g fill="#555770" fill-rule="nonzero">
                                <path d="M2.111 14.266H16.89c1.161 0 2.111-.95 2.111-2.111V6.65H0v5.505c0 1.16.95 2.11 2.111 2.11zM19 4.443c0-1.161-.95-2.111-2.111-2.111h-8.88v-.22C8.009.95 7.059 0 5.898 0H2.11C.95 0 0 .95 0 2.111V4.961h19v-.518z"/>
                            </g>
                        </svg>
                        <span class="px-2">
                            Admisión
                        </span>
                    </button>
                </h2>
                <div id="collapseAdmision" class="accordion-collapse collapse {{$denuncia->estatus->codigo=='admitida'?'show':''}} " aria-labelledby="headingAdmision" data-bs-parent="#accordionDetalle">
                    <div class="accordion-body bg-white">
                        {{-- Fragmento de información de Inadmision --}}
                        @include('denuncias.fragmentos.info-admision')
                    </div>
                </div>
            </div>
        @endif

    </div>{{-- fin - content - acordion  --}}


    @if ( auth()->user()->hasRole('denunciante') )
        {{-- Funcionalidad de botones --}}
        <div class="row mt-4">
            <div class="col">
                &nbsp;
            </div>
            <div class="col">
                &nbsp;
            </div>
            <div class="col">
                &nbsp;
            </div>

            <div class="col d-flex justify-content-end">
                <a href="{{route('denuncias.index')}}" class="btn btn-accion-detalle btn-default w-100">
                    Cancelar
                </a>
            </div>
        </div>
    @endif

</div>
@include('denuncias.partials.modal-confirm', ['id_boton'=>'btnEnviarActualizacion', 'msj_confirm'=>'¿Usted está seguro que desea actualizar los datos?', 'nomBoton'=>'Aceptar', 'accion'=>'ClickEnviarActualizacion'])
@endsection
