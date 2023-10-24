@extends('layouts.app')
@section('content')
    <nav aria-label="breadcrumb" class="px-3 py-1">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item font-small-size">
                <a href="#">
                    Administración
                </a>
            </li>
            <li class="breadcrumb-item font-small-size active" aria-current="page">
                Jurisdicción
            </li>
        </ol>
    </nav>
    <div class="row">
        <div class="card col-12 bg-white border-0">
            <div class="card-body">
                <div class="title-principal mb-2">
                    Jurisdicción
                </div>
                <div class="row pb-3 pt-2">
                    <div class="accordion" id="accordionMunicipio">

                        @foreach($departamentos as $departamento)
                            <div class="accordion-item border-0 mb-2 ">
                                <h2 class="accordion-header" id="heading{{ $loop->iteration }}">
                                    <button class="accordion-button bg-graylight border-bottom w-100 px-3 py-2 border-2 border-gray rounded-0 font-regular-size {{ $loop->first ? '': 'collapsed' }}" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->iteration }}"
                                            aria-expanded="{{ $loop->first ? 'true': 'false' }}"
                                            aria-controls="collapse{{ $loop->iteration }}">
                                        <div class="d-flex w-100 justify-content-between align-items-center">
                                            <div class="nombre">
                                                {{ $departamento->nombre }}
                                            </div>
                                            <div class="datos d-flex gap-3 pe-3 font-small-size fw-semibold">
                                                <div class="dato">
                                                    {{ $departamento->hijos->count() }} municipios
                                                </div>
                                                <div class="dato">
                                                    @php
                                                        $conJurisdiccion = $departamento->hijos->filter(function ($municipio) {
                                                            return $municipio->jurisdiccion !== null;
                                                        })->count();
                                                    @endphp
                                                    <i class="fa-solid fa-circle text-success"></i>
                                                    {{ $conJurisdiccion }} con auditor
                                                </div>
                                                <div class="dato">
                                                    @php
                                                        $sinJurisdiccion = $departamento->hijos->filter(function ($municipio) {
                                                            return $municipio->jurisdiccion === null;
                                                        })->count();
                                                    @endphp
                                                    <i class="fa-solid fa-circle text-warning"></i>
                                                    {{ $sinJurisdiccion }} sin auditor
                                                </div>
                                            </div>
                                        </div>
                                    </button>
                                </h2>
                                <div id="collapse{{ $loop->iteration }}"
                                     class="accordion-collapse collapse {{ $loop->first ? 'show': '' }}"
                                     aria-labelledby="heading{{ $loop->iteration }}"
                                     data-bs-parent="#accordionMunicipio">
                                    <div class="accordion-body bg-white font-regular-size p-0">
                                        <ul class="list-group bg-white list-group-flush">
                                            @foreach($departamento->hijos->sortBy('nombre') as $municipio)
                                                <li class="list-group-item bg-white">
                                                    <div class="d-flex gap-4 align-items-center">
                                                        @if($municipio->jurisdiccion !== null)
                                                            <i class="fa-solid fa-circle text-success"></i>
                                                        @else
                                                            <i class="fa-solid fa-circle text-warning"></i>
                                                        @endif
                                                        <div class="">
                                                            {{ $municipio->nombre }}
                                                        </div>
                                                        <form class="" method="post" action="{{ route('jurisdiccion.update') }}">
                                                            @csrf
                                                            <input type="hidden" name="municipio_id" value="{{ $municipio->id }}" />
                                                            <select name="usuario_id" id="" class="form-select font-regular-size usuario-jurisdiccion" onchange="submitJurisdiccion(this)">
                                                                <option value="">Seleccionar</option>
                                                                @foreach($auditores as $usuario)
                                                                    <option value="{{ $usuario->id }}" @if($municipio->jurisdiccion?->usuario_id == $usuario->id) selected @endif>
                                                                        {{ $usuario->complete_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </form>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
