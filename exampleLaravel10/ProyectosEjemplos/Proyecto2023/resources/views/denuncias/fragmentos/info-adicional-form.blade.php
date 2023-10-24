<form id="formDatosAdicional" class="form-air necesita-validacion" method="POST" action="{{route('denuncias.actualizar')}}" enctype="multipart/form-data" novalidate>
    @csrf
    <input type="hidden" name="denuncia_id" value="{{$denuncia->id}}"/>

    <div class="row bg-white sub-titulo-red">
        <div class="bg-border mb-3"></div>
        Respuesta providencia
    </div>

    {{-- Genera el Check Box  --}}
    @if (Auth::user()->can('gestionar_denuncias'))
    <div class="row bg-white">
        <div class="row d-flex justify-content-between">
                <div class="row px-4">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input"  name="respuesta_fisica" id="cBoxRespuestaFisica"  value="true" title="Usted podra indicar si recibio la respuesta de providencia de forma física"  @if (old('respuesta_fisica'))
                            {{'checked'}}
                            @endif/>
                        <label for="cBoxRespuestaFisica" class="form-label" >Se recibió respuesta de forma física</label>
                    </div>
                </div>
                <div id="divFechaReciboDenucnia" class="col-12
                    @if (old('respuesta_fisica'))
                        {{''}}
                    @else
                        {{'d-none'}}
                    @endif ">

                    <div class="col-4">
                        <label for="inpFechaRecepcion">Fecha de recepción *</label>
                        <input type="date" id="inpFechaRecepcion" name="fecha_recepcion_providencia" max="{{ date('Y-m-d') }}" class="form-control" value="{{old('fecha_recepcion_providencia')}}" required />
                    </div>
                </div>

                <div class="col-12">
                    <div class="col d-flex justify-content-star">
                        <span class="msj-validacion text-danger" data-campo="inpFechaRecepcion">
                            <p></p>
                        </span>
                    </div>
                </div>

        </div>
    </div>
    @endif

    @if ($denuncia->diasVencimientoProvidencia >= 0 || !Auth::user()->hasRole('denunciante'))
    <div class="row bg-white">
        <div class="col-12">
            <label for="inpDescripcionAdicional" class="form-label">Observaciones adicionales *</label>
            <textarea id="inpDescripcionAdicional" name="descripcion_denuncia_adicional" class="form-control editor" rows="7" required>{{old('descripcion_denuncia_adicional')}}</textarea>
        </div>
        <span class="col-12 msj-validacion" data-campo="inpDescripcionAdicional">
            <p></p>
        </span>
    </div>
    @endif

    <div class="row bg-white">
        <div class="col">
            <div>
                @include('components.carga-archivos-multiple', ['codigo' => 'pruebas_denuncia_resp_providencia'])
            </div>
        </div>
    </div>

    {{-- Funcionalidad de botones --}}
    <div class="d-flex flex-row mt-2 flex-sm-row flex-column">
        <div class="col">
            &nbsp;
        </div>
        <div class="col">
            &nbsp;
        </div>
        <div class="form-group col-md-3 mb-2 mb-md-0 d-flex  justify-content-end px-2">
            <a href="{{route('denuncias.index', ['id'=>$denuncia->id])}}" class="btn btn-accion-detalle btn-default w-100" >Cancelar</a>
        </div>
        @if($denuncia->estatus->codigo == 'providencia' && $denuncia->gestion()->first()->vencido==true)
            @can('ejecutar_desestimar')
                <div class="form-group col-md-3 mb-2 mb-md-0 d-flex  justify-content-end">
                    <a class=" btn btn-accion-detalle bg-estatus-inadmision w-100" href="{{route('denuncias.desestimar',$denuncia->id)}}">Desestimar</a>
                </div>
            @endcan
        @endif

        <div class="form-group col-md-3 mb-2 mb-md-0 d-flex  justify-content-end px-2">
             <button type="submit" id="btnValidaActualizacion" data-modal="NoSoyModal" class="btn btn-accion-detalle bg-btn-guardar w-100">Actualizar</button>
        </div>

    </div>
</form>
