<div class="col-xs-12 col-md-10 col-sm-4 mb-3">
    <div class="form-group ">
        <label class="form-label mb-2" >{{ isset($doclabel) && $doclabel ? $doclabel : $item->descripcion }}</label>
        <div class="boton-carga input-file d-flex flex-column btn-file py-3 px-3 text-decoration-none rounded-2 position-relative">
            <div class="d-flex w-100 justify-content-between align-items-center">
                <div class="info d-flex align-items-center fw-semibold text-dark pe-2">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="text-success me-2" height="1em" viewBox="0 0 512 512">
                            <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" fill="currentColor"></path>
                        </svg>
                    </div>
                    <div class="d-inline">
                        <div  class="break-word d-inline ">
                            <a href="{{url('archivos/descarga/'.$item->ruta)}}" target="_blank" class="enlace">{{ $item->nombre }}</a>
                        </div>
                        <p class="fw-normal mb-0">
                            {{ $item->peso }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
