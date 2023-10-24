<ul class="navbar-nav bg-white sidebar accordion {{Agent::isMobile() ?'toggled':''}} {{ session('sidebar_collapse') ? 'toggled' : 'no' }}" id="sidebar">
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

    <li class="nav-item {{active_class('denuncias*')}}">
        <a class="nav-link d-flex w-100 py-3 justify-content-between pe-3 bg-item-menu  @if(request()->is('denuncias*')) text-white bg-menu-principal @endif" href="#" data-bs-toggle="collapse" data-bs-target="#collapseDenuncias"
               aria-expanded="{{active_class('denuncias*')=="active"?'true':'false'}}"
               aria-controls="collapseDenuncias">
            <span class="d-flex align-items-center gap-2">
                <svg width="23" height="21" viewBox="0 0 23 21" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 9.692C0 4.218 5.194 0 11.308 0c6.113 0 11.307 4.218 11.307 9.692s-5.194 9.693-11.307 9.693c-1.21 0-2.378-.163-3.475-.466l-4.258 2.004a.808.808 0 0 1-1.11-.986l1.067-3.204C1.38 14.986 0 12.493 0 9.693zm7.27-4.038a.808.808 0 1 0 0 1.615h3.23a.808.808 0 1 0 0-1.615H7.27zm-.808 4.038c0-.446.361-.807.807-.807h8.077a.808.808 0 1 1 0 1.615H7.27a.808.808 0 0 1-.807-.808zm.807 2.423a.808.808 0 1 0 0 1.616h8.077a.808.808 0 1 0 0-1.616H7.27z" fill="@if(request()->is('denuncias*')) #FFFFFF @else #C7C9D9 @endif" fill-rule="evenodd"/>
                </svg>
                <span class="toggled-hidden">Denuncias</span>
                <span class="d-none toggled-visible"></span>
            </span>
            <span class="d-flex align-items-center justify-content-end gap-2 toggled-hidden">
                <i class="fa-solid fa-caret-down @if(request()->is('denuncias*')) text-white @else text-gray-light @endif"></i>
                <i class="fa-solid fa-caret-up @if(request()->is('denuncias*')) text-white @else text-gray-light @endif"></i>
            </span>
        </a>
        <div id="collapseDenuncias"
                 class="collapse p-0 m-0 {{ !session('sidebar_collapse') && !Agent::isMobile() && active_class('denuncias*')=="active"?'show':''}}"
                 aria-labelledby="headingTwo" data-bs-parent="#sidebar">
                <div class="bg-white collapse-inner p-0 overflow-hidden m-0">
                    <p class="d-flex w-100 align-items-center p-3 rounded-0 gap-2 px-2 m-0 py-3 text-black fw-bold f-10 d-none toggled-visible border-titulo-item"
                       href="#">
                        <span>
                            Denuncias
                        </span>
                    </p>
                    <a class="collapse-item d-flex w-100 align-items-center p-3 rounded-0 gap-2 {{Agent::isMobile() ?'px-2 f-10':'px-5 f-12'}} m-0 py-2 @if(request()->is('denuncias*')) text-white fw-semibold bg-bluelight @endif border-item"
                       href="{{route('denuncias.index')}}">
                        <span>
                            Bandeja de denuncias
                        </span>
                    </a>
                    @can('registrar_denuncias')
                    <a class="collapse-item d-flex w-100 align-items-center  rounded-0 gap-2 {{Agent::isMobile() ?'px-2 f-10':'px-5 f-12'}} m-0 py-2 @if(request()->is('denuncias/registrar-denuncia*')) text-white fw-semibold bg-bluelight @endif border-item"
                       href="#!" onclick="formatoClose(this)">
                        <span>
                            Ir a crear denuncia
                            <img src="{{ asset('images/icons/ir_crear_denuncia.svg') }}" alt="Logo {{ config('app.name', 'PRG') }}" class="ms-1">
                        </span>
                    </a>
                    <script>
                        localStorage.setItem('permiso_registro', true);
                    </script>
                    @endcan
                </div>
            </div>
    </li>

    @canany(['auditorias_ejecucion', 'auditorias_planeacion','solicitud_expediente','respuesta_solicitud_expediente'])
        <li class="nav-item {{active_class('planeaciones*')}}">
            <a class="nav-link d-flex w-100 py-3 justify-content-between pe-3 bg-item-menu @if(request()->is('planeaciones*') || request()->is('auditorias*') ) text-white bg-menu-principal @endif {{!Agent::isMobile() && (active_class('planeaciones*') =="active" || active_class('auditorias*') =="active" ) ?'':'collapsed'}}"
               href="#"
               data-bs-toggle="collapse" data-bs-target="#collapseAuditorias"
               aria-expanded="{{ ((active_class('planeaciones*')=="active") || (active_class('auditorias*')=="active")) ?'true':'false'}}"
               aria-controls="collapseAuditorias">
                <span class="d-flex align-items-center gap-2">
                <svg width="19" height="22" viewBox="0 0 19 22" xmlns="http://www.w3.org/2000/svg">
                    <g fill="@if(request()->is('planeaciones*') || request()->is('auditorias*') ) #FFFFFF @else #C7C9D9 @endif"" fill-rule="nonzero">
                        <path d="M17.743 1.462h-2.865a.262.262 0 0 0-.263.263v1.732a.93.93 0 0 1-.928.928H5.313a.93.93 0 0 1-.928-.928V1.725a.262.262 0 0 0-.263-.263H1.257C.563 1.462 0 2.024 0 2.718v17.948c0 .694.563 1.257 1.257 1.257h16.486c.694 0 1.257-.563 1.257-1.257V2.718c0-.694-.563-1.256-1.257-1.256zM4.385 16.808h-.731a.733.733 0 0 1-.73-.731c0-.402.328-.73.73-.73h.73c.403 0 .731.328.731.73 0 .402-.328.73-.73.73zm0-3.654h-.731a.733.733 0 0 1-.73-.73c0-.403.328-.732.73-.732h.73c.403 0 .731.33.731.731 0 .402-.328.73-.73.73zm0-3.654h-.731a.733.733 0 0 1-.73-.73c0-.403.328-.732.73-.732h.73c.403 0 .731.33.731.731 0 .402-.328.731-.73.731zm10.961 7.308H8.038a.733.733 0 0 1-.73-.731c0-.402.329-.73.73-.73h7.308c.402 0 .73.328.73.73 0 .402-.328.73-.73.73zm0-3.654H8.038a.733.733 0 0 1-.73-.73c0-.403.329-.732.73-.732h7.308c.402 0 .73.33.73.731 0 .402-.328.73-.73.73zm0-3.654H8.038a.733.733 0 0 1-.73-.73c0-.403.329-.732.73-.732h7.308c.402 0 .73.33.73.731 0 .402-.328.731-.73.731z"/>
                        <path d="M12.74 2.923H6.26a.413.413 0 0 1-.414-.413V.515c0-.285.23-.515.515-.515h6.278c.284 0 .515.23.515.515V2.51a.413.413 0 0 1-.413.413z"/>
                    </g>
                </svg>
                <span class="toggled-hidden">Auditorías</span>
                <span class="d-none toggled-visible"></span>
                </span>
                <span class="d-flex align-items-center justify-content-end gap-2 toggled-hidden">
                <i class="fa-solid fa-caret-down @if(request()->is('planeaciones*') || request()->is('auditorias*')) text-white @else text-gray-light @endif"></i>
                <i class="fa-solid fa-caret-up @if(request()->is('planeaciones*') || request()->is('auditorias*')) text-white @else text-gray-light @endif"></i>
            </span>
            </a>
            <div id="collapseAuditorias"
                 class="collapse p-0 m-0 {{ !session('sidebar_collapse') && !Agent::isMobile() && ((active_class('planeaciones*')=="active") || (active_class('auditorias*')=="active")) ?'show':''}}"
                 aria-labelledby="headingTwo" data-bs-parent="#sidebar">
                <div class="bg-white collapse-inner p-0 overflow-hidden m-0">
                    <p class="d-flex w-100 align-items-center p-3 rounded-0 gap-2 {{Agent::isMobile() ?'px-2 f-10':'px-5 f-12'}} m-0 py-3 text-black fw-bold f-10 d-none toggled-visible border-titulo-item"
                       href="#">
                        <span>
                            Auditorías
                        </span>
                    </p>
                    @can('auditorias_planeacion')
                        <a class="collapse-item d-flex w-100 align-items-center p-3 rounded-0 gap-2 {{Agent::isMobile() ?'px-2 f-10':'px-5 f-12'}} m-0 py-2 @if(request()->is('planeaciones*')) text-white fw-semibold bg-bluelight @endif border-item"
                           href="{{route('planeaciones')}}">
                            <span>
                                Planeación anual
                            </span>
                        </a>
                    @endcan
                    @canany (['solicitud_expediente','respuesta_solicitud_expediente'])
                        <a class="collapse-item d-flex w-100 align-items-center p-3  rounded-0 gap-2 {{Agent::isMobile() ?'px-2 f-10':'px-5 f-12'}}  m-0 py-2 @if(request()->is('auditorias/expedientes*')) text-white fw-semibold bg-bluelight @endif border-item"
                            href="{{route('auditorias.listado.solicitar.expediente')}}">
                             <span>
                                Solicitudes de expedientes
                             </span>
                         </a>
                    @endcan
                    <a class="collapse-item d-flex w-100 align-items-center p-3  rounded-0 gap-2 {{Agent::isMobile() ?'px-2 f-10':'px-5 f-12'}} m-0 py-2 @if(request()->is('auditorias/ejecucion*')) text-white fw-semibold bg-bluelight @endif border-item f-10"
                        href="{{route('auditorias.ejecuciones')}}">
                         <span>
                            Ejecución
                         </span>
                    </a>
                    <a class="collapse-item d-flex w-100 align-items-center p-3  rounded-0 gap-2 {{Agent::isMobile() ?'px-2 f-10':'px-5 f-12'}} m-0 py-2 @if(request()->is('auditorias/informe*')) text-white fw-semibold bg-bluelight @endif border-item"
                       href="#!">
                        <span>
                            Informe de auditoría
                        </span>
                    </a>
                    <a class="collapse-item d-flex w-100 align-items-center p-3  rounded-0 gap-2 {{Agent::isMobile() ?'px-2 f-10':'px-5 f-12'}} m-0 py-2 @if(request()->is('auditorias/ejecucion/seguimiento')) text-white fw-semibold bg-bluelight @endif border-item"
                        href="{{route('auditorias.seguimiento')}}">
                        <span>
                            Seguimiento
                        </span>
                    </a>
                </div>
            </div>
        </li>
    @endcan
</ul>
