@extends('layouts.app')
@section('content')
<nav aria-label="breadcrumb" class="px-3 py-1">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item font-small-size"><a href="
            #">Administración</a></li>
        <li class="breadcrumb-item font-small-size active" aria-current="page">Bitácora</li>
    </ol>
</nav>
<div class="row">
    <div class="card col-12 bg-white border-0">
        <div class="card-body">
            <div class="title-principal mb-2">
                Bitácora
            </div>
            <div class="row pb-3 pt-2">
                <livewire:bandeja-bitacora :usuario_id="@$_GET['usuario_id']" :busqueda="@$_GET['busqueda']"/>
            </div>
        </div>
    </div>
</div>
@endsection
