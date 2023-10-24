<ul class="navbar-nav bg-white sidebar accordion {{Agent::isMobile() ?'toggled':''}} {{ session('sidebar_collapse') ? 'toggled' : 'no' }}" " id="sidebar">
    <div class="text-center d-none d-md-inline bg-white">
        <a class="nav-link d-flex w-100 ps-3 mb-0" id="btnSidebar">
            <span class="d-flex align-items-center gap-2">
                <span class="image toggled-hidden text-black fw-bold f-12">
                    <img src="{{ asset('images/icons/ocultar-menu.svg') }}" alt="Logo {{ config('app.name', 'PRG') }}">
                </span>
                <span class="toggled-hidden text-black fw-bold f-12">Ocultar menú</span>
                <span class="image d-none toggled-visible text-black fw-bold f-12">
                    <img src="{{ asset('images/icons/menu-oculto.svg') }}" alt="Logo {{ config('app.name', 'PRG') }}">
                </span>
                <span class="d-none toggled-visible"></span>

            </span>
        </a>
    </div>
    @if(auth()->user()->can('gestionar_usuarios') || auth()->user()->can('gestionar_catalogos') || auth()->user()->can('gestion_diasinhabiles') || auth()->user()->can('gestionar_bitacoras'))
            <li class="nav-item {{active_class('admin/usuarios*')}} {{active_class('admin/catalogos*')}} {{active_class('admin/diasinhabiles*')}} {{active_class('admin/bitacora*')}}">
                <a class="nav-link d-flex w-100 py-3 justify-content-between pe-3  bg-item-menu  @if(request()->is('admin/usuarios*') || request()->is('admin/catalogos*') || request()->is('admin/diasinhabiles*') || request()->is('admin/bitacora*')) text-white bg-menu-principal @endif {{active_class('admin/usuarios*')=="active"?'':'collapsed'}}" href="#" data-bs-toggle="collapse" data-bs-target="#collapseAdministracion"
                   aria-expanded="{{active_class('admin/usuarios*')=="active" ?'true':'false'}}" aria-controls="collapseAdministracion">
                <span class="d-flex align-items-center gap-2">
                    <i class="fas fa-fw fa-cogs fs-5 @if(request()->is('admin/usuarios*') || request()->is('admin/catalogos*') || request()->is('admin/diasinhabiles*') || request()->is('admin/bitacora*')) text-white @else text-graylight @endif "></i>
                    <span class="toggled-hidden">Administración</span>
                    <span class="d-none toggled-visible"></span>
                </span>
                <span class="d-flex align-items-center justify-content-end gap-2 toggled-hidden">
                    <i class="fa-solid fa-caret-down @if(request()->is('admin/ati*')) text-white @else text-gray-light @endif"></i>
                    <i class="fa-solid fa-caret-up @if(request()->is('admin/ati*')) text-white @else text-gray-light @endif"></i>
                </span>
                </a>
                <div id="collapseAdministracion" class="collapse p-0 m-0 {{ !session('sidebar_collapse') && !Agent::isMobile() && ((active_class('admin/usuarios*')=="active") || (active_class('admin/catalogos*')=="active") || (active_class('admin/diasinhabiles*')=="active") || (active_class('admin/bitacora*')=="active")) ?'show':''}}" aria-labelledby="headingTwo" data-bs-parent="#sidebar">
                    <div class="bg-white collapse-inner p-0 overflow-hidden m-0">
                        <p class="d-flex w-100 align-items-center p-3 rounded-0 gap-2 px-2 m-0 py-3 text-black fw-bold f-10 d-none toggled-visible border-titulo-item" href="#">
                            <span>
                                Administración
                            </span>
                        </p>
                        @can('gestionar_usuarios')
                        <a class="collapse-item d-flex w-100 align-items-center rounded-0 gap-2 {{Agent::isMobile() ?'px-2 f-10':'px-5 f-12'}} m-0 py-2 @if(request()->is('admin/usuarios*')) text-white fw-semibold bg-bluelight @endif border-item" href="{{route('usuarios')}}">
                            <span class="d-flex align-items-center gap-2">
                                <span>Usuarios</span>
                            </span>
                        </a>
                        @endcan
                        @can('gestionar_catalogos')
                        <a class="collapse-item d-flex w-100 align-items-center rounded-0 gap-2 {{Agent::isMobile() ?'px-2 f-10':'px-5 f-12'}} m-0 py-2 @if(request()->is('admin/catalogos*')) text-white fw-semibold bg-bluelight  @endif border-item" href="{{route('catalogos.index')}}">
                            <span class="d-flex align-items-center gap-2">
                                <span>Catálogos</span>
                            </span>
                        </a>
                        @endcan
                        @can('gestion_diasinhabiles')
                        <a class="collapse-item d-flex w-100 align-items-center rounded-0 gap-2 {{Agent::isMobile() ?'px-2 f-10':'px-5 f-12'}} m-0 py-2 @if(request()->is('admin/diasinhabiles*')) text-white fw-semibold bg-bluelight  @endif border-item" href="{{route('diasinhabiles.index')}}">
                            <span class="d-flex align-items-center gap-2">
                                <span>Días inhábiles</span>
                            </span>
                        </a>
                        @endcan
                        @can('gestionar_bitacoras')
                        <a class="collapse-item d-flex w-100 align-items-center rounded-0 gap-2 {{Agent::isMobile() ?'px-2 f-10':'px-5 f-12'}} m-0 py-2 @if(request()->is('admin/bitacora*')) text-white fw-semibold bg-bluelight  @endif border-item" href="{{route('bitacora.index')}}">
                            <span class="d-flex align-items-center gap-2">
                                <span>Bitácora</span>
                            </span>
                        </a>
                        @endcan
                    </div>
                </div>
            </li>
    @endcan

    @can('gestionar_plantillas')
            <li class="nav-item {{active_class('admin/ati*')}}">
                <a class="nav-link d-flex w-100 py-3 justify-content-between pe-3  bg-item-menu  @if(request()->is('admin/ati*')) text-white bg-menu-principal @endif {{active_class('admin/ati*')=="active"?'':'collapsed'}}" href="#" data-bs-toggle="collapse" data-bs-target="#collapseGestionATI"
                   aria-expanded="{{active_class('admin/ati*')=="active"?'true':'false'}}" aria-controls="collapseGestionATI">
                <span class="d-flex align-items-center gap-2">
                    <i class="fas fa-fw fa-list-1-2 fs-5 @if(request()->is('admin/ati*')) text-white @else text-graylight @endif "></i>
                    <span class="toggled-hidden">ATI</span>
                    <span class="d-none toggled-visible"></span>
                </span>
                <span class="d-flex align-items-center justify-content-end gap-2 toggled-hidden">
                    <i class="fa-solid fa-caret-down @if(request()->is('admin/ati*')) text-white @else text-gray-light @endif"></i>
                    <i class="fa-solid fa-caret-up @if(request()->is('admin/ati*')) text-white @else text-gray-light @endif"></i>
                </span>
                </a>
                <div id="collapseGestionATI" class="collapse p-0 m-0 {{ !session('sidebar_collapse') && !Agent::isMobile() && ((active_class('admin/ati*')=="active") || (active_class('admin/ati*')=="active")) ?'show':''}}" aria-labelledby="headingTwo" data-bs-parent="#sidebar">
                    <div class="bg-white collapse-inner p-0 overflow-hidden m-0">
                        <p class="d-flex w-100 align-items-center p-3 rounded-0 gap-2 px-2 m-0 py-3 text-black fw-bold f-10 d-none toggled-visible border-titulo-item" href="#">
                            <span>
                                ATI
                            </span>
                        </p>
                        <a class="collapse-item d-flex w-100 align-items-center rounded-0 gap-2 {{Agent::isMobile() ?'px-2 f-10':'px-5 f-12'}} m-0 py-2 @if(request()->is('admin/ati/plantillas*')) text-white fw-semibold bg-bluelight @endif border-item" href="{{route('plantillas.index')}}">
                            <span class="d-flex align-items-center gap-2">
                                <span>Plantillas</span>
                            </span>
                        </a>
                        <a class="collapse-item d-flex w-100 align-items-center rounded-0 gap-2 {{Agent::isMobile() ?'px-2 f-10':'px-5 f-12'}} m-0 py-2 @if(request()->is('admin/ati/formularios*')) text-white fw-semibold bg-bluelight  @endif border-item" href="{{route('formularios.index')}}">
                            <span class="d-flex align-items-center gap-2">
                                <span>Formularios</span>
                            </span>
                        </a>
                        @can('gestionar_jurisdiccion')
                            <a class="collapse-item d-flex w-100 align-items-center rounded-0 gap-2 {{Agent::isMobile() ?'px-2 f-10':'px-5 f-12'}} m-0 py-2 @if(request()->is('admin/ati/jurisdiccion*')) text-white fw-semibold bg-bluelight  @endif border-item" href="{{route('jurisdiccion.index')}}">
                            <span class="d-flex align-items-center gap-2">
                                <span>Jurisdicción</span>
                            </span>
                            </a>
                        @endcan
                    </div>
                </div>
            </li>
    @endcan
    @can('gestionar_tipos_infraccion')
        <li class="nav-item {{active_class('admin/casos/tiposInfraccion*')}}">
            <a class="nav-link d-flex w-100 py-3 justify-content-between pe-3  bg-item-menu  @if(request()->is('admin/casos/tiposInfraccion*')) text-white bg-menu-principal @endif {{active_class('admin/casos/tiposInfraccion*')=="active"?'':'collapsed'}}" href="#" data-bs-toggle="collapse" data-bs-target="#collapseGestionCasos"
               aria-expanded="{{active_class('admin/casos/tiposInfraccion*')=="active"?'true':'false'}}" aria-controls="collapseGestionCasos">
                <span class="d-flex align-items-center gap-2">
                    <i class="fas fa-fw fa-list-alt fs-5 @if(request()->is('admin/casos/tiposInfraccion*')) text-white @else text-graylight @endif "></i>
                    <span class="toggled-hidden">Seguimiento de casos</span>
                    <span class="d-none toggled-visible"></span>
                </span>
                <span class="d-flex align-items-center justify-content-end gap-2 toggled-hidden">
                    <i class="fa-solid fa-caret-down @if(request()->is('admin/casos/tiposInfraccion*')) text-white @else text-gray-light @endif"></i>
                    <i class="fa-solid fa-caret-up @if(request()->is('admin/casos/tiposInfraccion*')) text-white @else text-gray-light @endif"></i>
                </span>
            </a>
            <div id="collapseGestionCasos" class="collapse p-0 m-0 {{ !session('sidebar_collapse') && !Agent::isMobile() && ((active_class('admin/casos/tiposInfraccion**')=="active") || (active_class('admin/casos/tiposInfraccion*')=="active")) ?'show':''}}
            " aria-labelledby="headingTwo" data-bs-parent="#sidebar">
                <div class="bg-white collapse-inner p-0 overflow-hidden m-0">
                    <p class="d-flex w-100 align-items-center p-3 rounded-0 gap-2 px-2 m-0 py-3 text-black fw-bold f-10 d-none toggled-visible border-titulo-item" href="#">
                        <span>
                            Seguimiento de casos
                        </span>
                    </p>
                    <a class="collapse-item d-flex w-100 align-items-center rounded-0 gap-2 m-0 py-2 {{Agent::isMobile() ?'px-2 f-10':'px-5 f-12'}} @if(request()->is('admin/casos/tiposInfraccion*')) text-white fw-semibold bg-bluelight @endif border-item" href="{{route('tiposInfraccion.index')}}">
                        <span class="d-flex align-items-center gap-2">
                            <span>Infracciones y montos</span>
                        </span>
                    </a>
                </div>
            </div>
        </li>
    @endcan
</ul>
