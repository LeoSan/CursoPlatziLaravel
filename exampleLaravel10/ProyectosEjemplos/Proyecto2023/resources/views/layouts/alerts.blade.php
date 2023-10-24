{{-- error message --}}
<div class="alert alert-danger alert-dismissible my-2" role="alert" id="alert-error" style="display:none;">
    <div class="d-flex justify-content-start fs-small">
        <i class="fa-solid fa-circle-exclamation my-1 me-2"></i>
        <div>
            <small>
                <p class="mb-0" id="textErrorAlert"></p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </small>
        </div>
    </div>
</div>
@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show my-2" role="alert">
        <div class="d-flex justify-content-start fs-small">
            <i class="fa-solid fa-circle-exclamation my-1 me-2"></i>
            <div>
                <small>
                    <strong class="fw-semibold">¡Error!</strong> {{ $errors->first() }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </small>
            </div>
        </div>
    </div>
@endif

{{-- success message --}}
@if(session()->has('success') && session('success')!='')
    <div class="alert alert-success alert-dismissible fade show my-3" role="alert">
        <div class="d-flex justify-content-start">
            <i class="fa-solid fa-circle-check my-1 me-2"></i>
            <div>
                <small>
                    <strong class="fw-semibold">¡Éxito!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </small>
            </div>
        </div>
    </div>
@endif
{{-- error message --}}
@if(session()->has('error') && session('error')!='')
    <div class="alert alert-danger alert-dismissible fade show my-2" role="alert">
        <div class="d-flex justify-content-start fs-small">
            <i class="fa-solid fa-circle-exclamation my-1 me-2"></i>
            <div>
                <small>
                    <strong class="fw-semibold">¡Error!</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </small>
            </div>
        </div>
    </div>
@endif

{{-- alert AJAX --}}
<div class="alerta"></div>
