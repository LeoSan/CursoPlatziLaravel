@extends('layouts.app')
@section('content')
    <x-bread-crumbs :itemsbread="$breadcrumbs"/>
    <div class="px-2 mb-2 pt-0">
        <h5 class="fw-semibold pb-2">
            <div class="">
                Seguimiento auditorías
            </div>
        </h5>
        <div class="border-light-gray border-bottom"></div>
    </div>

    <div class="px-2 pb-3 pt-2">
        <livewire:bandeja-seguimiento-auditorias/>
    </div>

    <!-- Modal -->
    @include('auditorias.partials.modal-reasignar-auditor',['auditores' => $elementos['auditores']] )
@endsection
