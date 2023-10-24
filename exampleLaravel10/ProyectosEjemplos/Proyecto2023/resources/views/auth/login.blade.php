@extends('layouts.default')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card border-0 shadow-sm">
                    <div class="card-body px-5 py-5">

                        <div class="d-flex w-100">
                            <img src="{{ asset('images/logo2x.png') }}" width="200" alt="">
                        </div>
                        <hr class="border-light my-4">

                        <div class="head text-right mb-2">
                            <h5 class="modal-title fw-semibold text-tertiary mb-0">{{ __('Iniciar sesión') }}</h5>
                            <p class="text-secondary mb-0 p-0 fw-semibold">{{ __('Acceso exclusivo a funcionarios') }}</p>
                        </div>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group py-3">
                                <label for="email" class="fw-semibold mb-2 fs-small">Correo electrónico</label>
                                <input id="email"
                                       type="email"
                                       name="email"
                                       class="form-control py-3 px-3 fs-small @error('email') is-invalid border-danger @enderror"
                                       placeholder="Escribe tu dirección de correo"
                                       value="{{ $email ?? old('email') }}"
                                       required autocomplete="email" autofocus/>

                                @error('email')
                                <span class="invalid-feedback mt-1" role="alert">
                                    <b class="fw-normal">{{ $message }}</b>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group py-3">
                                <label for="password"
                                       class="fw-semibold mb-2 fs-small">{{ __('Contraseña') }}</label>
                                <input id="password"
                                       type="password"
                                       name="password"
                                       class="form-control py-3 px-3 fs-small @error('password') is-invalid border-danger @enderror"
                                       required
                                />

                                @error('password')
                                <span class="invalid-feedback mt-1" role="alert">
                                    <b class="fw-normal">{{ $message }}</b>
                                </span>
                                @enderror
                            </div>

                            <div class="d-flex py-2 w-100 justify-content-between fs-small">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="recordarCheckbox">
                                    <label class="form-check-label" for="recordarCheckbox">
                                        Recordarme
                                    </label>
                                </div>

                                <div class="forgot">
                                    <a href="{{ route('password.request') }}" class="text-tertiary fw-semibold">Olvidé
                                        mi contraseña</a>
                                </div>
                            </div>

                            <div class="form-group py-2">
                                <button type="submit"
                                        class="btn btn-secondary text-white fw-semibold fs-small p-special w-100">
                                    {{ __('Acceder') }}
                                </button>
                            </div>

                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
