@extends('layouts.app')

@section('content')

@if($editable==true)
<nav aria-label="breadcrumb" class="px-3 py-1">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item font-small-size"><a href="
            #">Administración</a></li>
        <li class="breadcrumb-item font-small-size"><a href="{{route('usuarios')}}">Usuarios</a></li>
        @if(isset($usuario->id))
            <li class="breadcrumb-item font-small-size active" aria-current="page">Actualizar usuario</li>
        @else
            <li class="breadcrumb-item font-small-size active" aria-current="page">Registro de usuario</li>
        @endif
    </ol>
</nav>
<div class="bg-white p-3">
    <div class="row">
        @if(isset($usuario->id))
            <h5><strong>Actualizar Usuario</strong>- {{$usuario->complete_name}}</h5>
        @else
            <h5><strong>Registro de usuario</strong></h5>
        @endif

    </div>
    <form class="necesita-validacion form_disable_button" method="post" action="{{ route('usuarios.store') }}" autocomplete="off" accept-charset="UTF-8" novalidate>
        @csrf
        <input type="hidden" name="user_id" id="usuario_id" value="{{ @$usuario->id }}" />
        <div class="row mt-3">
            <div class="form-group col-md-4 mb-3">
                <label for="nombre" class="form-label fw-bold">Nombre *</label>
                @if($editable==true)
                <input type="text" name="nombre" class="@error('nombre') is-invalid @enderror form-control input-regular-height  bg-w" id="nombre" placeholder="Ingrese el nombre"  value="{{ old('nombre', isset($usuario->id) ? $usuario->name:'') }}" maxlength="100" onkeydown="return /^[a-z\s\u00C0-\u00ff]+$/i.test(event.key)" required>
                <span class="text-danger txt-parrafo-error">{{ $errors->first('nombre')}}</span>
                <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                @else
                   <p>{{ $usuario->name}}</p>
                @endif
            </div>
            <div class="form-group col-md-4 mb-3">
                <label for="primer_apellido" class="form-label fw-bold">Primer apellido *</label>
                @if($editable==true)
                <input type="text" name="primer_apellido" class="form-control @error('primer_apellido') is-invalid @enderror bg-white" id="primer_apellido" placeholder="Ingrese el primer apellido" value="{{ old('primer_apellido', isset($usuario->id) ? $usuario->first_name:'') }}" maxlength="50" onkeydown="return /^[a-z\s\u00C0-\u00ff]+$/i.test(event.key)" required>
                <span class="text-danger txt-parrafo-error">{{ $errors->first('primer_apellido')}}</span>
                <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                @else
                   <p>{{ $usuario->first_name}}</p>
                @endif
            </div>
            <div class=" form-group col-md-4 mb-3">
                <label for="segundo_apellido" class="form-label fw-bold">Segundo apellido</label>
                @if($editable==true)
                <input type="text" name="segundo_apellido" class="form-control @error('segundo_apellido') is-invalid @enderror bg-white" id="segundo_apellido" placeholder="Ingrese el segundo apellido"  value="{{ old('segundo_apellido', isset($usuario->id) ? $usuario->last_name:'') }}" maxlength="50" onkeydown="return /^[a-z\s\u00C0-\u00ff]+$/i.test(event.key)">
                <span class="text-danger txt-parrafo-error">{{ $errors->first('segundo_apellido')}}</span>
                @else
                   <p>{{ $usuario->last_name}}</p>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4 mb-3">
                <label for="email" class="form-label fw-bold">Correo electrónico *</label>
                @if($editable==true)
                    @if(isset($usuario->id))
                    <p>{{ $usuario->email}}</p>
                    @else
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror bg-white" id="email" placeholder="Ingrese el email" value="{{ old('email', isset($usuario->id) ? $usuario->email:'') }}" maxlength="255" required>
                    <span class="text-danger txt-parrafo-error">{{ $errors->first('email')}}</span>
                    <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                    @endif
                @else
                   <p>{{ $usuario->email}}</p>
                @endif
            </div>
            <div class="form-group col-md-4 mb-3">
                <label for="telefono" class="form-label fw-bold">Teléfono *</label>
                @if($editable==true)
                <input type="text" name="telefono" minlength="8" class="form-control w-60 @error('telefono') is-invalid @enderror bg-white telefono" id="telefono" placeholder="Ingrese el teléfono" value="{{ old('telefono', isset($usuario->id) ? $usuario->phone:'') }}" pattern="^\d{8}$" required>

                <span class="text-danger txt-parrafo-error">{{ $errors->first('telefono')}}</span>
                <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                @else
                   <p>{{ $usuario->phone}}</p>
                @endif
            </div>
            <div class="form-group col-md-4 mb-3">
                <label for="regional" class="form-label">Regional *</label>
                @if($editable==true)
                <select class="form-select @error('regional') is-invalid @enderror bg-white" aria-label="Default select example" name="regional" required>
                  <option value="">Seleccione regional</option>
                    @if(isset($regiones) && $regiones->count()>0)
                        @foreach($regiones as $region)
                            <option value="{{$region->id}}" {{ old('regional',@$usuario->regional_id) == $region->id ? 'selected' : '' }}>{{$region->nombre}}</option>
                        @endforeach
                    @endif
                </select>
                <span class="text-danger txt-parrafo-error">{{ $errors->first('regional')}}</span>
                <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                @else
                   <p>{{ $usuario->regional_id}}</p>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4 mb-3">
                <label for="area" class="form-label">Área de adscripción *</label>
                @if($editable==true)
                <select class="form-select @error('area') is-invalid @enderror bg-white" aria-label="Default select example" name="area" onchange="selectPerfiles(this,'dom_perfiles_usuarios')" required>
                    <option value="">Seleccione el área de adscripción</option>
                    @if(isset($areas) && $areas->count()>0)
                        @foreach($areas as $area)
                            <option value="{{$area->id}}" {{ old('area',@$usuario->area_adscripcion_id) == $area->id ? 'selected' : '' }}>{{$area->nombre}}</option>
                        @endforeach
                    @endif
                </select>
                <span class="text-danger txt-parrafo-error">{{ $errors->first('area')}}</span>
                <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                @else
                   <p>{{ $usuario->area_adscripcion_id}}</p>
                @endif
            </div>
            <div class="form-group col-md-4 mb-3">
                <label for="cargo" class="form-label">Cargo *</label>
                @if($editable==true)
                <input type="text" name="cargo" class="form-control @error('cargo') is-invalid @enderror bg-white" id="cargo" placeholder="Ingresa el cargo"  value="{{ old('cargo', isset($usuario->id) ? $usuario->cargo:'') }}" maxlength="50" required>
                <span class="text-danger txt-parrafo-error">{{ $errors->first('cargo')}}</span>
                <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                @else
                   <p>{{ $usuario->cargo}}</p>
                @endif
            </div>
            <div class="form-group col-md-4 mb-3">
                <label for="perfil" class="form-label">Perfil *</label>
                @if($editable==true)
                <select class="form-select @error('regional') is-invalid @enderror bg-white" aria-label="Default select example" name="perfil" required id="dom_perfiles_usuarios">
                  <option value="">Seleccione el perfil</option>
                    @if(isset($roles) && $roles->count()>0)
                        @foreach($roles as $rol)
                            <option value="{{$rol->id}}" {{ old('perfil',@$usuario->perfil_id) == $rol->id ? 'selected' : '' }}>{{$rol->show_name}}</option>
                        @endforeach
                    @endif
                </select>
                <span class="text-danger txt-parrafo-error">{{ $errors->first('perfil')}}</span>
                <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                @else
                   <p>{{ $usuario->rol_name}}</p>
                @endif
            </div>
        </div>
        <div class="text-end">
            <a href="{{route('usuarios')}}" class="btn btn-default busqueda_casos ms-2 input-regular-height">{{ isset($usuario->id) ? 'Cerrar' : 'Cancelar' }}</a>
            <button class="btn btn-default-primary btn-default btn-tertiary busqueda_casos ms-2 input-regular-height" type="submit">{{ isset($usuario->id) ? 'Actualizar y continuar' : 'Guardar y continuar' }}</button>
        </div>
    </form>
</div>
@else
<nav aria-label="breadcrumb" class="px-3 py-1">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item font-small-size"><a href="
            #">Administración</a></li>
        <li class="breadcrumb-item font-small-size"><a href="{{route('usuarios')}}">Usuarios</a></li>
        <li class="breadcrumb-item font-small-size active" aria-current="page">Detalle usuario</li>
    </ol>
</nav>
<div class="bg-white p-3">
    <div class="row">
        <h5><strong>Detalle del Usuario</strong>
            @if(isset($usuario))
             - {{$usuario->complete_name}}
            @endif
        </h5>
    </div>
    <nav>
        <div class="nav nav-tabs nav-tabs-usuario mt-3" id="nav-tab" role="tablist">
            <button class="nav-link active nav-usuarios text-start p-0 me-4" id="nav-informacion-tab" data-bs-toggle="tab" data-bs-target="#nav-informacion" type="button" role="tab" aria-controls="nav-informacion" aria-selected="true">Información del usuario</button>
            <button class="nav-link nav-usuarios p-0" id="nav-permisos-tab" data-bs-toggle="tab" data-bs-target="#nav-permisos" type="button" role="tab" aria-controls="nav-permisos" aria-selected="false">Permisos y privilegios</button>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-informacion" role="tabpanel" aria-labelledby="nav-informacion-tab">
            <form class="needs-validation form_disable_button" method="post" action="{{ route('usuarios.store') }}" autocomplete="off" accept-charset="UTF-8">
            @csrf
                <input type="hidden" name="user_id" id="usuario_id" value="{{ @$usuario->id }}" />
                <div class="row mt-4">
                    <div class="col-md-4 mb-3">
                        <label for="nombre" class="form-label fw-bold">Nombre</label>
                        @if($editable==true)
                        <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" id="nombre" placeholder="Ingresa tu nombre"  value="{{ old('nombre', isset($usuario->id) ? $usuario->name:'') }}" maxlength="100">
                        <span class="text-danger">{{ $errors->first('nombre')}}</span>
                        @else
                           <p>{{ $usuario->name}}</p>
                        @endif
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="primer_apellido" class="form-label fw-bold">Primer apellido</label>
                        @if($editable==true)
                        <input type="text" name="primer_apellido" class="form-control @error('primer_apellido') is-invalid @enderror" id="primer_apellido" placeholder="Ingresa tu primer apellido" value="{{ old('primer_apellido', isset($usuario->id) ? $usuario->first_name:'') }}" maxlength="50">
                        <span class="text-danger">{{ $errors->first('primer_apellido')}}</span>
                        @else
                           <p>{{ $usuario->first_name}}</p>
                        @endif
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="segundo_apellido" class="form-label fw-bold">Segundo apellido</label>
                        @if($editable==true)
                        <input type="text" name="segundo_apellido" class="form-control @error('segundo_apellido') is-invalid @enderror" id="segundo_apellido" placeholder="Ingresa tu segundo apellido"  value="{{ old('segundo_apellido', isset($usuario->id) ? $usuario->last_name:'') }}" maxlength="50">
                        @else
                           <p>{{ $usuario->last_name}}</p>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="email" class="form-label fw-bold">Correo electrónico</label>
                        @if($editable==true)
                            @if(isset($usuario->id))
                            <p>{{ $usuario->email}}</p>
                            @else
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="usuario" placeholder="Ingresa tu email" value="{{ old('email', isset($usuario->id) ? $usuario->email:'') }}" maxlength="255">
                            <span class="text-danger">{{ $errors->first('email')}}</span>
                            @endif
                        @else
                           <p>{{ $usuario->email}}</p>
                        @endif
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="telefono" class="form-label fw-bold">Teléfono</label>
                        @if($editable==true)
                        <input type="text" name="telefono" class="form-control w-60 @error('telefono') is-invalid @enderror" id="telefono" placeholder="" value="{{ old('telefono', isset($usuario->id) ? $usuario->phone:'') }}" maxlength="25" data-regex="^([0-9\s\-\(\)+#])*$">
                        <span class="text-danger">{{ $errors->first('telefono')}}</span>
                        @else
                           <p>{{ $usuario->phone}}</p>
                        @endif
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="regional" class="form-label">Regional</label>
                        @if($editable==true)
                        <select class="form-select @error('regional') is-invalid @enderror" aria-label="Default select example" name="regional">
                          <option value="">Seleccione regional</option>
                          <option value="1" @if(isset($usuario->id) && $usuario->regional_id==1) selected @endif>One</option>
                          <option value="2">Two</option>
                          <option value="3">Three</option>
                        </select>
                        <span class="text-danger">{{ $errors->first('regional')}}</span>
                        @else
                           <p>{{ $usuario->region}}</p>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="area" class="form-label">Área de adscripción</label>
                        @if($editable==true)
                        <select class="form-select @error('area') is-invalid @enderror" aria-label="Default select example" name="area">
                          <option value="">Seleccione área</option>
                          <option value="1">One</option>
                          <option value="2">Two</option>
                          <option value="3">Three</option>
                        </select>
                        <span class="text-danger">{{ $errors->first('area')}}</span>
                        @else
                           <p>{{ $usuario->area}}</p>
                        @endif
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="cargo" class="form-label">Cargo</label>
                        @if($editable==true)
                        <input type="text" name="cargo" class="form-control @error('cargo') is-invalid @enderror" id="cargo" placeholder="Ingresa tu cargo"  value="{{ old('cargo', isset($usuario->id) ? $usuario->cargo:'') }}" maxlength="50">
                        <span class="text-danger">{{ $errors->first('cargo')}}</span>
                        @else
                           <p>{{ $usuario->cargo}}</p>
                        @endif
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="perfil" class="form-label">Perfil</label>
                        @if($editable==true)
                        <select class="form-select @error('regional') is-invalid @enderror" aria-label="Default select example" name="perfil">
                          <option value="">Seleccione perfil</option>
                            @if(isset($roles) && $roles->count()>0)
                                @foreach($roles as $rol)
                                    <option value="{{$rol->id}}" @if(isset($usuario->id) && $usuario->perfil_id==$rol->id) selected @endif>{{$rol->show_name}}</option>
                                @endforeach
                            @endif
                        </select>
                        <span class="text-danger">{{ $errors->first('perfil')}}</span>
                        @else
                           <p>{{ $usuario->rol_name}}</p>
                        @endif
                    </div>
                </div>
                @if($editable==true)
                <div class="row @if (!isset($usuario) && old('user_core_id', @$user_core['user_core_id']) != "") d-none @endif" id="display_contraseña">
                    <div class="col-md-6 mb-3">
                        <label for="contraseña" class="form-label fw-bold">Contraseña</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="contraseña" placeholder="Ingresa tu contraseña" value="@if(isset($usuario->id))******@endif">
                        <span class="text-danger">{{ $errors->first('password')}}</span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="contraseña_confirmation" class="form-label fw-bold">* Confirmar Contraseña</label>
                        <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" placeholder="Confirma tu nueva contraseña" value="@if(isset($usuario->id))******@endif">
                    </div>
                </div>
                <div class="text-end">
                    <a href="{{route('usuarios')}}" class="btn btn-link-gray text-decoration-none fw-bold">{{ isset($usuario->id) ? 'Cerrar' : 'Cancelar' }}</a>
                    <button class="btn btn-primary fw-bold p-2 fs-6" type="submit">{{ isset($usuario->id) ? 'Actualizar y continuar' : 'Guardar y continuar' }}</button>
                </div>
                @endif
            </form>
            <div class="text-end">
                <a href="{{route('usuarios')}}" class="btn btn-default busqueda_casos ms-2 input-regular-height">Regresar</a>
                <a href="{{ route('usuarios.show', ['user_id' => $usuario->id]) }}" class="btn btn-default-primary btn-tertiary busqueda_casos ms-2 input-regular-height">Editar</a>
            </div>
        </div>
        @include('admin.usuarios.permisos')
    </div>
</div>
@endif
@endsection
