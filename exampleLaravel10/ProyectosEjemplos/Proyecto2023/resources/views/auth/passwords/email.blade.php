@extends('layouts.default')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card border-0 shadow-sm">
                    <div class="card-body px-5 py-5">

                        <div class="head text-right">
                            <h5 class="modal-title fw-semibold text-tertiary mb-2">{{ __('Recuperar contraseña') }}</h5>
                        </div>

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="form-group py-3">
                                <label for="email" class="fw-semibold mb-2 fs-small">Correo electrónico</label>
                                <input type="email"
                                       name="email"
                                       class="form-control py-3 px-3 fs-small @error('email') is-invalid border-danger @enderror"
                                       placeholder="Escribe tu dirección de correo" value="{{ $email ?? old('email') }}"
                                       required autocomplete="email" autofocus/>

                                @error('email')
                                <span class="invalid-feedback mt-1" role="alert">
                                    <b class="fw-normal">{{ $message }}</b>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group py-2">
                                <button type="submit"
                                        class="btn btn-secondary text-white fw-semibold fs-small p-special w-100">
                                    {{ __('Enviar enlace para recuperar contraseña') }}
                                </button>
                            </div>
                        </form>

                        <hr class="border-light my-4">

                        <div class="d-flex w-100 justify-content-center fs-small">
                            <div class="login text-center">
                                <a href="{{ route('login') }}" class="text-tertiary fw-semibold">
                                    Volver al inicio de sesión
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
