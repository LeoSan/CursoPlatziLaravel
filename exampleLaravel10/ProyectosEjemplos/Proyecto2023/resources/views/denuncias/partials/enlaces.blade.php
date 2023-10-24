<div class="main-tabs d-flex flex-column flex-md-row gap-3 gap-md-5 py-3">
    <div class=" p-0">
        <a href="{{ route('denuncias.index') }}" class="fw-bold p-0 rounded-0 pb-1 {{ request()->routeIs('denuncias.index') ? ' active' : '' }}">
            @role('denunciante')
                Mis Denuncias
            @else
                Denuncias
            @endrole
        </a>
    </div>
    <div class=" p-0">
        <a href="{{ route('planeaciones') }}" class="fw-bold p-0 rounded-0 pb-1 {{ request()->routeIs('auditorias.planeaciones') ? ' active' : '' }}">
            Auditorías
        </a>
    </div>

</div>
