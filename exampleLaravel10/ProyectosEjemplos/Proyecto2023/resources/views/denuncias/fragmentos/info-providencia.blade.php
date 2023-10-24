    @forelse ($denuncia->gestion_denuncia as $items_pro )
        @if ($items_pro->estatus_id == obtenerIdCatalogoElementCodigo('providencia') )
            <div class="row bg-white">
                <div class="sub-titulo-red">
                    Información de la providencia
                </div>
                <div class="row">
                    <div class="col">
                        <span class="mb-3">Fecha de la providencia</span>
                        <p>{{ $items_pro->created_at->format('d/m/Y H:i')}}</p>
                    </div>
                    <div class="col">
                        <span class="mb-3">Motivo de la providencia</span>
                        <p>{{ obtenerCatalogoElementId($items_pro->motivo_id)}}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <span class="mb-3">Información adicional</span>
                        @isset($items_pro->observacion)
                            <div class="text-justify f-10 break-w">{!!$items_pro->observacion!!}</div>
                        @else
                            <p>Dato no proporcionado.</p>
                        @endisset
                    </div>
                </div>

                @isset($doc_providencia_denuncia->ruta)
                <div class="@isset($col){{$col}} @else {{$col}} @endisset bg-white">
                    
                    @include('denuncias.fragmentos.documento', ['item' => $doc_providencia_denuncia])

                </div>
                @endisset

                @if (strlen($denuncia->descripcion_denuncia_adicional) > 0 && strtoupper($denuncia->descripcion_denuncia_adicional) != 'NULL' )
                    <div class="@isset($col){{$col}} @else {{$col}} @endisset sub-titulo-red bg-white">
                        <div class="bg-border mb-3"></div>
                        Respuesta a la providencia
                    </div>
                    @if(!empty($items_pro->fecha_recepcion))
                        <div class="row">
                            <div class="col bg-white">
                                <span>Fecha de recepción</span>
                                <p>{{ empty($items_pro->fecha_recepcion)?$items_pro->created_at->format('d/m/Y'):$items_pro->fecha_recepcion->format('d/m/Y'); }}</p>
                            </div>
                        </div>
                    @endif
                    <div class="@isset($col){{$col}} @else {{$col}} @endisset  bg-white">
                        <span>Observaciones adicionales </span>
                        @isset($denuncia->descripcion_denuncia_adicional)
                            <div class="text-justify f-10 break-w mb-3">
                                {!!$denuncia->descripcion_denuncia_adicional!!}
                            </div>
                        @else
                            <p>Dato no proporcionado.</p>
                        @endisset
                            <div class="row bg-white">
                                @forelse($doc_resp_providencia as $key => $item)
                                    @include('denuncias.fragmentos.documento', ['item' => $item])
                                @empty
                                    <span class="mb-4">Documentos</span>
                                    <p>Dato no proporcionado.</p>
                                @endforelse
                            </div>
                        </div>
                @endif
            </div>
        @endif
    @empty

    @endforelse

