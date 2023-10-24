@extends('layouts.app')
@section('content')
<x-bread-crumbs :itemsbread="$itemsbread"/>
<x-modal-confirm/>
<div class="row">
    <div class="card col-12 bg-white border-0">
        <div class="card-body">
            <div class="row pb-3 pt-2">
                <livewire:admin.catalogo-elementos :catalogo_id="$catalogo->id" :elemento_id="@$elemento->id"/>
            </div>
        </div>
    </div>
</div>
    @include('admin.catalogos.partials.modal_formulario')
@endsection

