<div class="form-wizard-second d-flex justify-content-center align-items-start my-4">
    <div class=" d-flex flex-column justify-content-center align-items-center gap-1 mx-3">
        <div class="tag-form-second">
            <div  class="@if(isset($step) && $step == 'generales') tag-activo-second @else tag-inactivo-second @endif">1</div>
        </div>
        <div class="tag-titulo-second font-small-size fw-semibold text-center">
            Datos generales
        </div>
    </div>
    <div class=" d-flex flex-column justify-content-center align-items-center gap-1 mx-3">
        <div class="tag-form-second">
            <div  class="@if(isset($step) && $step == 'auditorias') tag-activo-second @else tag-inactivo-second @endif">2</div>
        </div>
        <div class="tag-titulo-second font-small-size fw-semibold text-center">
            Auditorías
        </div>
    </div>
    <!--
    <div class="step d-flex flex-column justify-content-center align-items-center gap-1">
        <div class="step-number rounded-5 text-white z-1 d-flex justify-content-center font-regular-size align-items-center fw-semibold @if(isset($step) && $step == 'auditoria') bg-primary @else bg-grayAlt @endif">
            03
        </div>
        <div class="step-label font-small-size fw-semibold text-center @if(isset($step) && $step == 'auditoria') text-primary @else text-grayAlt @endif">
            Nuevo grupo de auditorías
        </div>
    </div>
    <div class="step d-flex flex-column justify-content-center align-items-center gap-1">
        <div class="step-number rounded-5 text-white z-1 d-flex justify-content-center font-regular-size align-items-center fw-semibold @if(isset($step) && $step == 'mensual') bg-primary @else bg-grayAlt @endif">
            04
        </div>
        <div class="step-label font-small-size fw-semibold text-center @if(isset($step) && $step == 'mensual') text-primary @else text-grayAlt @endif">
            Plan mensual
        </div>
    </div>
    -->
</div>
