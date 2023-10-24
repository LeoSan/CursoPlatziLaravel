@php
    use App\Http\Livewire\BandejaSolicitudExpedientes;
@endphp

<div class="d-flex align-items-center gap-2 text-estatus-{{ $solicitud->estatus->codigo }}">
    <div class="icon d-flex">
        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
            <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
            <path d="M0 96C0 60.7 28.7 32 64 32H384c35.3 0 64 28.7 64 64V416c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V96z" fill="currentColor" />
        </svg>
    </div>
    <div class="text fw-semibold text-estatus-{{$solicitud->estatus->codigo}} text-start">{{ $solicitud->estatus->nombre }}
        @switch($solicitud->estatus->codigo)
            @case('solicitud_solicitada')
                </br>
                <spam class="f-10 text-gray">
                    {{ BandejaSolicitudExpedientes::calculoDiasPlazo($solicitud->fecha_solicitud, $solicitud->plazo_respuesta_solicitud)}}
                    @if ((BandejaSolicitudExpedientes::calculoDiasPlazo($solicitud->fecha_solicitud, $solicitud->plazo_respuesta_solicitud)) == 1 || (BandejaSolicitudExpedientes::calculoDiasPlazo($solicitud->fecha_solicitud, $solicitud->plazo_respuesta_solicitud)) == -1  ) Día restante  @else Días restantes @endif
                </spam>
            @break
            
        @endswitch
    </div>
</div>