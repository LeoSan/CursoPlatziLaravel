@extends('layouts.app')
@section('content')
    <x-bread-crumbs :itemsbread="$breadcrumbs"/>
    <div class="row px-2 mb-2 pt-0">
        <div class="col-12">
            <h5 class="fw-semibold">
                Ejecución de auditorías {{ date('Y') }} / {{$ejecucion->num_auditoria ?? 'Sin número asignado'}}
            </h5>
            @include('partials.estatus-planeacion', ['estatus' => $ejecucion->estatus])
            <div class="border-light-gray border-bottom mt-2"></div>
        </div>
    </div>


    <nav class="pt-2 pb-4 px-2">
        <div class="nav nav-tabs nav-tabs-auditorias" id="nav-tab" role="tablist">
            <a @if(request()->route()->getName() !== 'auditorias.ejecucion.detalle')
                   href="{{ route('auditorias.ejecucion.detalle', ['ejecucion' => @$ejecucion->id]) }}"
               @endif
                class="nav-link text-start p-0 me-4 @if(request()->route()->getName() == 'auditorias.ejecucion.detalle') active @endif">
                Información general
            </a>

            @if($ejecucion->estatus->codigo == 'proceso' || $ejecucion->estatus->codigo == 'elaboracion_informe' || $ejecucion->estatus->codigo == 'finalizada')
            <a @if(!preg_match('/^auditorias\.ejecucion\.proceso\..*$/', request()->route()->getName()))
                   href="{{ route('auditorias.ejecucion.proceso.lista', ['ejecucion' => @$ejecucion->id]) }}"
               @endif
               class="nav-link text-start p-0 me-4 @if(preg_match('/^auditorias\.ejecucion\.proceso\..*$/', request()->route()->getName())) active @endif ">
                Ejecución de auditoría
            </a>
            @endif

            @if(($ejecucion->estatus->codigo == 'elaboracion_informe' && auth()->user()->can('cargar_informe_auditoria'))|| $ejecucion->estatus->codigo == 'finalizada')
            <a @if(!preg_match('/^auditorias\.ejecucion\.informe\..*$/', request()->route()->getName()))
                   href="{{ route('auditorias.ejecucion.informe.auditoria', ['ejecucion' => @$ejecucion->id]) }}"
               @endif
               class="nav-link text-start p-0 me-4 @if(preg_match('/^auditorias\.ejecucion\.informe\.auditoria\.*$/', request()->route()->getName())) active @endif ">
                Informe de auditoría
            </a>
            @endif
            @if($ejecucion->seguimiento == true)
                <a @if(!preg_match('/^auditoria\.seguimiento\.informe\..*$/', request()->route()->getName()))
                    href="{{ route('auditoria.seguimiento.informe', ['ejecucion' => @$ejecucion->id]) }}"
                @endif
                class="nav-link text-start p-0 me-4 @if('auditoria.seguimiento.informe' == request()->route()->getName()) active @endif ">
                    Seguimiento de auditoría
                </a>
            @endif

        </div>
    </nav>

    @yield('content-detalle')
@endsection