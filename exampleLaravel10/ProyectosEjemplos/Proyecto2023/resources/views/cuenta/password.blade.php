@extends('layouts.app')
@section('content')
<div class="row">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Cambiar contraseña</li>
        </ol>
    </nav>
</div>
<div class="bg-white p-3">
    <div class="row">
        <h5><strong>CAMBIAR CONTRASEÑA</strong></h5>
    </div>
	<form class="needs-validation" method="post" action="{{route('cuenta.actualizar.password')}}" >
	@csrf
		<div class="row mt-3">
			<div class="col-12">
                <p class="text-muted">Los datos marcados con asterisco (*) son obligatorios</p>
            </div>
            <div class="col-md-6 mb-3">
                <label for="password_actual" class="form-label fw-bold">* Contraseña Actual</label>
                <input type="password" name="password_actual" class="form-control @error('contraseña_actual') is-invalid @enderror bg-white" id="password_actual" required placeholder="Ingrese tu contraseña actual" minlength="6" maxlength="20" value="{{ old('password_actual')}}">
            </div>
            <div class="w-100"></div>
			<div class="col-md-6 mb-3">
                <label for="password" class="form-label fw-bold">* Nueva Contraseña</label>
                <input type="password" name="password" class="form-control @error('contraseña') is-invalid @enderror bg-white" id="password" required placeholder="Ingrese su nueva contraseña" minlength="6" maxlength="20" value="{{ old('password')}}">
                <div class="small">
                    Se requieren por lo menos 6 caracteres.
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="password_confirmation" class="form-label fw-bold">* Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" class="form-control @error('contraseña_confirmation') is-invalid @enderror bg-white" required id="password_confirmation" placeholder="Confirme su nueva contraseña" minlength="6" maxlength="20" value="{{ old('password_confirmation')}}">
            </div>
		</div>
		<div class="text-end">
			<button class="btn btn-gral" type="submit">Actualizar</button>
		</div>
  </form>
</div>
@endsection