@extends('layouts.app')
@section('content')
    <x-bread-crumbs :itemsbread="$itemsbread"/>
    <div class="row">
        <x-modal-confirm/>
    </div>
    <div class="row p-3 px-3 bg-white">
        <form action="{{route('plantillas.store')}}" method="post" class="row necesita-validacion" novalidate>
            @csrf
            <input type="hidden" name="plantilla_id" value="{{@$plantilla->id}}">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nombre">Nombre *</label>
                    <input name="nombre" id="nombre" type="text" class="form-control bg-white" placeholder="Escriba el nombre de la plantilla"  required maxlength="100" value="{{@$plantilla->nombre??old('nombre')}}">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="col-md-6 form-group">
                <label for="seccion_id">Sección *</label>
                <select name="seccion_id" id="seccion_id" class="form-select" required>
                    <option value="">Seleccione una opción</option>
                    @foreach(getCatalogoElementos('secciones_plantillas','nombre') as $i)
                        <option value="{{$i->id}}" {{@$plantilla->seccion_id==$i->id?'selected':(old('seccion_id')==$i->id?'selected':'')}}>{{$i->nombre}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="col-md-12 form-group mt-2">
                <label for="contenido">Contenido *</label>
                <textarea name="contenido" id="contenido" class="editor-sin-limite" required>{{@$plantilla->contenido??old('contenido')}}</textarea>
                <div class="invalid-feedback"></div>
            </div>
            <div class="col-md-12 mt-2 d-flex justify-content-end">
                <a href="{{route('plantillas.index')}}" class="btn btn-default me-2">Cancelar</a>
                <button type="submit" class="btn btn-tertiary text-white">{{isset($plantilla->id)?'Actualizar':'Guardar'}}</button>
            </div>
        </form>
    </div>
@endsection
