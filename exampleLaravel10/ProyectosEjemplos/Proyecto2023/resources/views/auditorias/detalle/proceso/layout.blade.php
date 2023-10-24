@extends('auditorias.detalle.layout')
@section('content-detalle')

    <ul class="d-flex justify-content-center flex-wrap list-unstyled mb-3 mt-1 v-ls form-wizard-big">
        <li class="@if(request()->route()->getName() === 'auditorias.ejecucion.proceso.lista') activo @endif d-flex flex-column align-items-center">
            <div class="step d-flex bg-primary p-2 align-items-center rounded-circle justify-content-center">
                <a @if(request()->route()->getName() !== 'auditorias.ejecucion.proceso.lista') href="{{ route('auditorias.ejecucion.proceso.lista', ['ejecucion' => @$ejecucion->id]) }}"
                   @endif
                   class="inner rounded-circle align-items-center justify-content-center w-100 h-100 fw-bold d-flex text-white rounded-circle border-0">1</a>
            </div>
            <div class="name mt-2 text-center text-graydark fw-semibold font-regular-size">
                <a @if(request()->route()->getName() !== 'auditorias.ejecucion.proceso.lista') href="{{ route('auditorias.ejecucion.proceso.lista', ['ejecucion' => @$ejecucion->id]) }}" @endif>
                    Lista de <br>
                    verificación
                </a>
            </div>
        </li>

        <li class="@if(request()->route()->getName() === 'auditorias.ejecucion.proceso.cedulas') activo @endif d-flex flex-column align-items-center">
            <div class="step d-flex bg-primary p-2 align-items-center rounded-circle justify-content-center">
                <a @if(request()->route()->getName() !== 'auditorias.ejecucion.proceso.cedulas') href="{{ route('auditorias.ejecucion.proceso.cedulas', ['ejecucion' => @$ejecucion->id]) }}"
                   @endif
                   class="inner rounded-circle align-items-center justify-content-center w-100 h-100 fw-bold d-flex text-white rounded-circle border-0">2</a>
            </div>
            <div class="name mt-2 text-center text-graydark fw-semibold font-regular-size">
                <a @if(request()->route()->getName() !== 'auditorias.ejecucion.proceso.cedulas') href="{{ route('auditorias.ejecucion.proceso.cedulas', ['ejecucion' => @$ejecucion->id]) }}" @endif>
                    Cédulas <br>
                    de trabajo
                </a>
            </div>
        </li>

        <li class="@if(request()->route()->getName() === 'auditorias.ejecucion.proceso.resultados') activo @endif d-flex flex-column align-items-center">
            <div class="step d-flex bg-primary p-2 align-items-center rounded-circle justify-content-center">
                <a @if(request()->route()->getName() !== 'auditorias.ejecucion.proceso.resultados') href="{{ route('auditorias.ejecucion.proceso.resultados', ['ejecucion' => @$ejecucion->id]) }}"
                   @endif
                   class="inner rounded-circle align-items-center justify-content-center w-100 h-100 fw-bold d-flex text-white rounded-circle border-0">3</a>
            </div>
            <div class="name mt-2 text-center text-graydark fw-semibold font-regular-size">
                <a @if(request()->route()->getName() !== 'auditorias.ejecucion.proceso.resultados') href="{{ route('auditorias.ejecucion.proceso.resultados', ['ejecucion' => @$ejecucion->id]) }}" @endif>
                    Resultados <br>
                    preliminares
                </a>
            </div>
        </li>

        <li class="@if(request()->route()->getName() === 'auditorias.ejecucion.proceso.cierre') activo @endif d-flex flex-column align-items-center">
            <div class="step d-flex bg-primary p-2 align-items-center rounded-circle justify-content-center">
                <a @if(request()->route()->getName() !== 'auditorias.ejecucion.proceso.cierre') href="{{ route('auditorias.ejecucion.proceso.cierre', ['ejecucion' => @$ejecucion->id]) }}"
                   @endif
                   class="inner rounded-circle align-items-center justify-content-center w-100 h-100 fw-bold d-flex text-white rounded-circle border-0">4</a>
            </div>
            <div class="name mt-2 text-center text-graydark fw-semibold font-regular-size">
                <a @if(request()->route()->getName() !== 'auditorias.ejecucion.proceso.cierre') href="{{ route('auditorias.ejecucion.proceso.cierre', ['ejecucion' => @$ejecucion->id]) }}" @endif>
                    Acta de cierre <br>
                    de auditoría
                </a>
            </div>
        </li>

    </ul>

    <div class="px-2">
        @yield('content-ejecucion')
    </div>
@endsection
