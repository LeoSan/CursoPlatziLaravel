@extends('layouts.app')
@section('content')
    <nav aria-label="breadcrumb" class="px-3 py-1">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item font-small-size"><a href="#">ATI</a></li>
            <li class="breadcrumb-item font-small-size active" aria-current="page">Plantillas</li>
        </ol>
    </nav>
    <div class="row">
        <div class="card col-12 bg-white border-0">
            <div class="card-body">
                <div class="title-principal mb-2">
                    Plantillas
                </div>
                <div class="row pb-3 pt-2">
                    <livewire:admin.plantillas/>
                </div>
            </div>
        </div>
    </div>
    @include('admin.plantillas.partials.modal_eliminar')
@endsection
