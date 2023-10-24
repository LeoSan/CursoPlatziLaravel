<div class="header">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm px-1 px-md-3">
        <a class="navbar-brand d-flex flex-row " href="{{ url('/') }}">
        <span class="image">
            <img src="{{ asset('images/logo2x.png') }}" width="140" alt="Logo {{ config('app.name', 'SETRASS') }}">
        </span>
            <span class="separator border-end border-light"></span>
            <span class="title fs-6 lh-sm d-flex flex-column justify-content-center">
            <span class="text-secondary fw-semibold">Sistema de</span>
            <span class="text-tertiary fw-bold">Denuncia</span>
        </span>
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
                <!-- Authentication Links -->
                @guest
                    <li></li>
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle lh-sm" href="#" role="button"
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
                @endguest
            </ul>
        </div>
    </nav>
    <div class="bg-tertiaryAlt">
        <div class="container d-flex">
            @if(url_activa('admin*'))
                <button id="btnNavbar" class="btn d-md-none">
                    <i class="fa fa-bars"></i> <span class="text-decoration-none">Menú</span>
                </button>
            @endif
        </div>
    </div>
</div>
