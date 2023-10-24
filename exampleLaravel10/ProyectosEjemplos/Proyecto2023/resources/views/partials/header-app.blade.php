<div class="header header-app shadow-sm">
    <nav class="navbar navbar-expand-md navbar-dark
     bg-tertiary topbar px-1 px-md-3">
            <a class="navbar-brand d-flex flex-row align-items-center px-0" href="
            {{ Auth::user()->area->codigo == 'ati' ? route('denuncias.index') : route('casos.index', ['asignado'=>Auth::user()->id, 'estatus'=>precargaEstatus()])  }}">
            <span class="image">
                <img src="{{ asset('images/logo-w-2x.png') }}" width="140" alt="Logo {{ config('app.name', 'PRG') }}">
            </span>
            <div class="vr text-white mx-0 mx-md-3 d-none d-md-inline"></div>
            <div class="d-none d-md-inline fw-normal">
                {!!getNombreSistemaHtml(Auth::user()->id)!!}
            </div>
            <div class="d-inline d-md-none fw-normal f-8 mx-0">
                {!!getNombreSistemaHtml(Auth::user()->id)!!}
            </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">
                </ul>
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto py-1 py-md-0">
                    @auth
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle lh-sm text-white" href="#" role="button"
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <span class="title fw-semibold fs-small">
                                    {{ Auth::user()->name }}
                                </span>
                                <br>
                                <span class="title fw-normal fs-small">
                                    <small>{{ Auth::user()->posicion ?? 'Usuario' }}</small>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end fs-small" aria-labelledby="navbarDropdown">
                                @if(auth()->user()->is_admin)
                                    <a class="dropdown-item" href="{{ auth()->user()->admin_url }}">
                                        Administración
                                    </a>
                                    <a class="dropdown-item" href="{{ route('home')  }}">
                                        Inicio
                                    </a>
                                @endif
                                <a class="dropdown-item" href="{{ route('cuenta.password') }}">
                                    Cambiar contraseña
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endauth
                </ul>
            </div>
    </nav>
    <div class="bg-tertiaryAlt">
        <div class="container d-flex gap-4">
            @if(url_activa('admin*') || url_activa('auditorias*') || url_activa('denuncias*'))
                <button id="btnNavbar" class="btn d-md-none px-0">
                    <i class="fa fa-bars"></i> <span class="text-decoration-none">Menú</span>
                </button>
            @endif
        </div>
    </div>
</div>
