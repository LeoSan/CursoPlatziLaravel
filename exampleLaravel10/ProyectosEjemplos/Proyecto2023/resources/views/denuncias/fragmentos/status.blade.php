@php
    use App\Http\Livewire\BandejaDenuncias;
@endphp
<span class="badge rounded-circle bg-estatus-{{ $denuncia->estatus->codigo}}">&nbsp;</span>
<strong class="text-estatus-{{ $denuncia->estatus->codigo}}">{{$denuncia->estatus->nombre}}</strong>

@switch( $denuncia->estatus->codigo)
    @case('solicitud_expediente')
        </br>
        <spam class="f-10">
            {{ BandejaDenuncias::calculoDiasPlazo($denuncia)}}
        </spam>
    @break
    @case('providencia')
        </br>
        <spam class="f-10">
            {{ BandejaDenuncias::calculoDiasPlazo($denuncia)}}
        </spam>
    @break
    @default
        {{-- Contador para llevar seguimiento a partir del estatus de Admisión --}}
        @if ( $denuncia->hasEstatus('admitida') && !$denuncia->hasEstatus('finalizado')  )
        </br>
        <spam class="f-10">
            {{ BandejaDenuncias::calculoDiasPlazo($denuncia)}}
        </spam>
        @endif
@endswitch



