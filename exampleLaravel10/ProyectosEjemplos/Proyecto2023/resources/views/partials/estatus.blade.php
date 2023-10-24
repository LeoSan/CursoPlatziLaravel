<div class="d-flex align-items-center gap-1 text-estatus-{{ $estatus->codigo }}">
    <div class="icon">
        <svg xmlns="http://www.w3.org/2000/svg" height="0.9em" viewBox="0 0 512 512" class="">
            <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
            <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512z" fill="currentColor"/>
        </svg>
    </div>
    <div class="text fw-semibold text-start">{{ $estatus->nombre }}</div>
</div>
