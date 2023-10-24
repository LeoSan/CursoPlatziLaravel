@extends('layouts.app')
@section('content')
    <nav aria-label="breadcrumb" class="px-2 py-1">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-small-size"><a href="#">Denuncias</a></li>
            <li class="breadcrumb-item font-small-size active" aria-current="page">Bandeja de denuncias</li>
        </ol>
    </nav>
    <div class="px-2 pb-3 pt-0">
        <h5 class="fw-semibold">
            <div class="">
                Bandeja de denuncias
            </div>
        </h5>
    </div>
    <div class="px-2 pb-4 pt-0">
        <livewire:bandeja-denuncias :busqueda="@$_GET['busqueda']"/>
    </div>
@endsection
