<div class="row  bg-white sub-titulo-red">
    Datos del denunciante
</div>
{{-- Datos del Denunciante --}}
<div class="row bg-white">
    <div class="col-sm-4 col-xs-12 ">
        <span>Origen de la denuncia</span>
        <p>{{$denuncia->origen->nombre}}</p>
    </div>
</div>{{-- Fin row --}}
<div class="row bg-white">
    @if($denuncia->sindicato_denunciante == 'N/A')
        <div class="col-sm-4 col-xs-12">
            <span>Nombre</span>
            <p class="text-break">{{$denuncia->nombre_denunciante}}</p>
        </div>
        <div class="col-sm-4 col-xs-12">
            <span>Primer apellido</span>
            <p class="text-break">{{$denuncia->primer_apellido_denunciante}}</p>
        </div>
        <div class="col-sm-4 col-xs-12">
            <span>Segundo apellido</span>
            <p class="text-break">{{$denuncia->segundo_apellido_denunciante}}</p>
        </div>
    @else
        <div class="col-sm-4 col-xs-12">
            <span>Nombre del sindicato</span>
            <p>{{$denuncia->sindicato_denunciante}}</p>
        </div>
    @endif
</div>{{-- Fin row --}}
<div class="row bg-white">
    <div class="col-sm-4 col-xs-12">
        <span>Documento de Identificación Nacional</span>
        <p>{{$denuncia->dni_denunciante}}</p>
    </div>
    <div class="col-sm-4 col-xs-12">
        <span>Tel&eacute;fono</span>
        <p>{{$denuncia->telefono_denunciante}}</p>
    </div>
    <div class="col-sm-4 col-xs-12">
        <span>Correo electrónico</span>
        <p>{{$denuncia->correo_denunciante}}</p>
    </div>
</div>{{-- Fin row --}}

{{-- Datos direccion --}}
@empty($denuncia->domicilio)
    <div class="row bg-white sub-titulo-gray ">
        Domicilio del Denunciante
    </div>
    <div class="row bg-white">
        <p class="mt-3 text-break">Dato no proporcionado.</p>
    </div>
@else
    <div class="row bg-white sub-titulo-gray ">
        Domicilio del Denunciante
    </div>
    <div class="row bg-white py-2">
        <div class="col-sm-4 col-xs-12">
            <span>Calle</span>
            @empty($denuncia->domicilio->calle)
                <p>Dato no proporcionado</p>
            @else
                <p class="text-break">{{$denuncia->domicilio->calle}}</p>
            @endempty
        </div>
        <div class="col-sm-4 col-xs-12">
            <span>Número exterior</span>
            @empty($denuncia->domicilio->num_exterior)
                <p>Dato no proporcionado</p>
            @else
                <p class="text-break">{{$denuncia->domicilio->num_exterior}}</p>
            @endempty
            
        </div>
        <div class="col-sm-4 col-xs-12">
            <span>Número interior</span>
            @empty($denuncia->domicilio->num_interior)
                <p>Dato no proporcionado</p>
            @else
                <p class="text-break">{{$denuncia->domicilio->num_interior}}</p>
            @endempty
            
        </div>
    </div>
    <div class="row bg-white">
        <div class="col-sm-4 col-xs-12">
            <span>Departamento</span>
            @empty($denuncia->domicilio->departamento->nombre)
                <p>Dato no proporcionado</p>
            @else
                <p>{{$denuncia->domicilio->departamento->nombre}}</p>
            @endempty
        </div>
        <div class="col-sm-4 col-xs-12">
        <span>Municipio</span>
        @empty($denuncia->domicilio->municipio->nombre)
            <p>Dato no proporcionado</p>
        @else
            <p>{{$denuncia->domicilio->municipio->nombre}}</p>
        @endempty
        </div>
        <div class="col-sm-4 col-xs-12">
        <span>Ciudad</span>
        @empty($denuncia->domicilio->ciudad)
            <p>Dato no proporcionado</p>
        @else
            <p class="text-break">{{$denuncia->domicilio->ciudad}}</p>
        @endempty
        </div>
        <div class="col-sm-4 col-xs-12">
        <span>C&oacute;digo postal</span>
        @empty($denuncia->domicilio->codigo_postal)
            <p>Dato no proporcionado</p>
        @else
            <p>{{$denuncia->domicilio->codigo_postal}}</p>
        @endempty
        </div>
    </div>
@endempty

<div class="row bg-white sub-titulo-red">
    <div class="bg-border mb-3"></div>
    Datos de la denuncia
</div>
<div class="row bg-white">
    <div class="col-sm-4 col-xs-12">
        <span>Fecha</span>
        <p>{{$denuncia->created_at->format('d/m/Y H:i')}}</p>
    </div>
    <div class="col-sm-4 col-xs-12">
        <span>Medio de recepción</span>

        @isset($denuncia->medio_recepcion->nombre)
            <p>{{$denuncia->medio_recepcion->nombre}}</p>
        @else
            <p>Dato no proporcionado.</p>
        @endisset
    </div>
</div>
<div class="row bg-white">
    <div class="col-sm-4 col-xs-12">
        <span>Nombre funcionario</span>
        <p class="text-break">{{$denuncia->nombre_funcionario}}</p>
    </div>
    <div class="col-sm-4 col-xs-12">
        <span>Departamento / Municipio</span>
        <p>{{$denuncia->departamento_region->nombre}} / {{$denuncia->municipio_region->nombre}}</p>
    </div>
    <div class="col-sm-4 col-xs-12">
        <span>Oficina regional</span>
        <p>{{$denuncia->oficina->nombre}}</p>
    </div>
</div>


<div class="row bg-white">
    <div class="col-12">
        <span>Descripción de la denuncia</span>
        <div class="text-justify f-10 break-w">{!!$denuncia->descripcion_denuncia!!}</div>
    </div>

    @isset($documento->ruta)
        @include('denuncias.fragmentos.documento', ['item' => $documento])
    @endisset
</div>
