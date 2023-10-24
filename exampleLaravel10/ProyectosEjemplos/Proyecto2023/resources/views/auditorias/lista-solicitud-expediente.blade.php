@extends('layouts.app')
@section('content')
    <x-bread-crumbs :itemsbread="$breadcrumbs"/>
    <div class="pb-3 pt-0">
        <h5 class="fw-semibold">
            <div class="">
                Solicitudes de expedientes {{$elementos['titulo_anio'] }}
            </div>
        </h5>
    </div>
    <div class="px-3 pt-1">
        <livewire:bandeja-solicitud-expedientes/>
    </div>
@endsection
