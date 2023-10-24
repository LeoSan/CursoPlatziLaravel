@extends('layouts.default')

@section('content')
    <div class="welcome d-flex vh-100 bg-xlight">
        <div class="seccion-info w-50 p-5 d-flex flex-column justify-content-center">
            <div class="seccion-logo">
                <img src="{{ asset('images/logo.png') }}" width="200" alt="">
            </div>
            <div class="seccion-intro text-gray">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. A aliquid architecto asperiores autem
                consequatur culpa delectus deleniti deserunt dolor dolorem eligendi enim esse eum facere illo impedit
                ipsa iste labore, laboriosam laborum magnam minus nemo nisi odit officia officiis quas qui quia quidem
                repellendus sequi sint sit soluta sunt voluptates.
            </div>
            <div class="seccion-accion">
                <a href="{{route('denuncias.registro')}}" class="btn btn-secondary text-white fw-semibold w-100">
                    Presentar denuncia
                </a>
            </div>
            <div class="seccion-acceso">
                <div class="mb-1">
                    <b>¿Eres funcionario?</b>
                </div>
                <div>
                    <a href="#!" class="abrir-modal" data-target="#modal-login">
                        <b>
                            Iniciar sesión
                        </b>
                    </a>
                </div>
            </div>
        </div>
        <div class="seccion-alt bg-light w-50"></div>
    </div>

    <div class="modal fade @if($errors->any()) modal-init @endif" id="modal-login">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header px-5 pb-2 pt-5 border-0">
                    <h5 class="modal-title fw-semibold text-tertiary">Iniciar Sesión</h5>
                    <a href="#!" class="cerrar-modal close" data-dismiss="modal">&times;</a>
                </div>

                <div class="modal-body px-5 pt-1 pb-5">

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group py-2">
                            <label for="email" class="fw-semibold mb-2 fs-small">Correo electrónico</label>
                            <input id="email"
                                   type="email"
                                   name="email"
                                   class="form-control py-3 px-3 fs-small @error('email') is-invalid border-danger @enderror"
                                   placeholder="Escribe tu dirección de correo"
                                   value="{{ $email ?? old('email') }}"
                                   required autocomplete="email" autofocus
                            />

                            @error('email')
                            <span class="invalid-feedback mt-1" role="alert">
                                    <b class="fw-normal">{{ $message }}</b>
                                </span>
                            @enderror

                        </div>

                        <div class="form-group py-2">
                            <label for="password" class="fw-semibold mb-2 fs-small">Contraseña</label>
                            <input id="password"
                                   type="password"
                                   name="password"
                                   class="form-control py-3 px-3 fs-small @error('password') is-invalid border-danger @enderror"
                                   placeholder="Escribe tu contraseña"
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
                                <a href="{{ route('password.request') }}" class="text-tertiary fw-semibold">Olvidé mi
                                    contraseña</a>
                            </div>
                        </div>


                        <div class="form-group py-2">
                            <button type="submit"
                                    class="btn btn-secondary text-white fw-semibold fs-small p-special w-100">
                                Iniciar Sesión
                            </button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
@endsection
