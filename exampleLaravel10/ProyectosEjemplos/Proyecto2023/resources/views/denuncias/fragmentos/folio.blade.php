@role('denunciante')
    <a href="{{route('denuncias.informacion.adicional', $denuncia->id )}}" class="text-dark">
        <strong>{{$denuncia->folio??"Sin expediente asignado"}}</strong>
    </a>
@else
    {{-- Solo en caso de estatus providencia el auditor o jefe de auditoria podra cargar de manera presencial nuevos datos --}}
    @if ($estatus_providencia == $denuncia->estatus->id)
        <a href="{{route('denuncias.informacion.adicional', $denuncia->id )}}" class="text-dark">
            <strong>{{$denuncia->folio??"Sin expediente asignado"}}</strong>
        </a>
    @else
        <a href="{{route('denuncias.detalle', $denuncia->id )}}" class="text-dark">
            <strong>{{$denuncia->folio??"Sin expediente asignado"}}</strong>
        </a>
    @endif
@endrole
