@extends('layouts.app')
@section('content')
    <nav aria-label="breadcrumb" class="px-3 py-1">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item font-small-size"><a href="#">Seguimiento de casos</a></li>
            <li class="breadcrumb-item font-small-size"><a href="{{route('tiposInfraccion.index')}}">Tipos de Infracción</a></li>
            <li class="breadcrumb-item font-small-size active" aria-current="page">Registro de tipo de infracción</li>
        </ol>
    </nav>
    <div class="row">
        <div class="card col-12 bg-white border-0">
            <div class="card-body">
                <h5 class="title-principal">Agregar tipo de infracción</h5>
                <form action="{{route('tiposInfraccion.store')}}" method="post" class="row">
                    @csrf
                    <div class="col-md-2">
                        <label class="form-label" for="">Año</label>
                        <input type="text" class="numeric form-control" name="anio" placeholder="Introduzca el año" value="{{old('anio')}}" required maxlength="4" minlength="4">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label" for="">Concepto</label>
                        <input type="text" class="form-control" name="concepto" placeholder="Introduzca la descripción del tipo de infracción" value="{{old('concepto')}}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label" for="monto_infraccion">Monto de la multa (en lempiras)</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">L</span>
                            <input type="text" class="lempiras form-control" name="monto" placeholder="Introduzca el monto" value="{{old('monto')}}" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label" for="editable" class="">Editable</label>
                        <select name="editable" class="form-select" required>
                            <option value="">Seleccione</option>
                            <option value="1" {{old('editable')=="1"?'selected':''}}>Sí</option>
                            <option value="0" {{old('editable')=="0"?'selected':''}}>No</option>
                        </select>
                    </div>
                    <div class="col-md-12 mt-3 text-end">
                        <a href="{{url()->previous()}}" class="btn btn-default">Cancelar</a>
                        <button class="btn btn-primary btn-default btn-tertiary" type="submit">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
