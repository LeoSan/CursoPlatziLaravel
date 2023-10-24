@extends('layouts.app')
@section('content')
<nav aria-label="breadcrumb" class="px-2 py-1">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item font-small-size"><a href="
            #">Administración</a></li>
        <li class="breadcrumb-item font-small-size active" aria-current="page">Días Inhábiles</li>
    </ol>
</nav>
<div class="row">
    <div class="card col-12 bg-white border-0">
        <div class="card-body">
            <div class="title-principal mb-2">
                Días Inhábiles
            </div>
            <div class="row pb-3 pt-2">
                <livewire:admin.inhabiles/>
            </div>
        </div>
    </div>
</div>
@include('admin.inhabiles.partials.modal_formulario')
@include('admin.inhabiles.partials.modal_confirm')
@endsection
