@php
$meses = [1=>"Enero",2=>"Febrero",3=>"Marzo",4=>"Abril",5=>"Mayo",6=>"Junio",7=>"Julio",8=>"Agosto",9=>"Septiembre",10=>"Octubre",11=>"Noviembre",12=>"Diciembre"]
@endphp
<div class="row">
    <div class="col-12 card bg-white border-0">
        <div class="card-body">
            <form action="{{route('reporte_mensual_pagos')}}" method="POST" class="necesita-validacion" novalidate>
                @csrf
                <div class="row">
                    <div class="col-12">
                        <h5 class="fw-semibold mb-4">Descargar reporte mensual de pagos</h5>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Año *</label>
                        <select name="anio" class="form-select input-regular-height" id="exportacion_pagos_anio" required>
                            <option value="">Seleccione el año</option>
                            @for($i=2017;$i<=date('Y');$i++)
                                <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                        <div class="invalid-feedback" data-default="El año es obligatorio"></div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Mes *</label>
                        <select name="mes" class="form-select input-regular-height" id="exportacion_pagos_mes" required disabled>
                            <option value="">Seleccione el año</option>
                            @foreach($meses as $k=>$i)
                                <option value="{{$k}}">{{$i}}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" data-default="El mes es obligatorio"></div>
                    </div>
                    <div class="form-group col-auto">
                        <label for="">&nbsp;</label>
                        <button type="submit" class="btn btn-default px-3 py-2 d-block input-regular-height" >
                            <strong class="text-gray">Exportar <i
                                class="fa fa-download"></i></strong>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
