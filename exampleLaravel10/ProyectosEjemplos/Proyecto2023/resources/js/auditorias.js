window.activarFecha = function(e) {
    var fechaExpediente = document.getElementById('fecha_entrega_expediente');
    var seccionfechaExpediente = document.getElementById('fecha-recepcion_expediente');
    var inputFecha = fechaExpediente.querySelector('.input-fecha');

    let alerta = fechaExpediente.closest(".form-group").querySelector(".invalid-feedback");
    if(e.checked){
        fechaExpediente.setAttribute("required","true");
        seccionfechaExpediente.style.display = 'block';
    }else{
        fechaExpediente.removeAttribute("required");
        seccionfechaExpediente.style.display = 'none';

    }
}

window.cargarPlantilla = function (e){
    const plantilla = e.value;
    const ejecucion = e.dataset.ejecucion;
    const seccion = e.dataset.seccion;
    window.location.href = `/auditorias/ejecucion/${ejecucion}/proceso/${seccion}?plantilla=${plantilla}`;
}

window.cargarPlantillaResultados = function (e){
    const plantilla = e.value;
    const ejecucion = e.dataset.ejecucion;
    const seccion = e.dataset.seccion;
    window.location.href = `/auditorias/ejecucion/${ejecucion}/proceso/${seccion}?plantilla=${plantilla}`;
}

window.eliminarPlantilla = function (e){
    document.getElementById('delete_plantilla_id').value = e.dataset.plantilla;
    document.getElementById('delete_plantilla_nombre').textContent = e.dataset.nombre;
}

window.eliminarPlantillaFirmada = function (e){
    document.getElementById('delete_plantilla_firma_id').value = e.dataset.plantilla;
    document.getElementById('delete_plantilla_firma_nombre').textContent = e.dataset.nombre;
}

window.cargarPlantillaFirmada = function (e){
    document.getElementById('file_plantilla_id').value = e.dataset.plantilla;
}

window.reasignacionEjecucion = function (e){
    document.getElementById('reasignacion_auditor_asignado_id').value = e.dataset.auditor;
    document.getElementById('reasignacion_ejecucion_id').value = e.dataset.ejecucion;
}

window.activarAuditoriaNoEjecutada = function(e){
    var seccionAuditoriaNoEjecutada = document.getElementById('seccion_acta_incumplimiento');
    var fileActaIncumplimiento = document.getElementById('acta_incumplimiento_auditoria');
    var seccionSeguimiento = document.getElementById('seccion_seguimiento');
    var inputFechaSeguimiento = document.getElementById('input-fecha-seguimiento');

    if(e.checked){
        seccionAuditoriaNoEjecutada.style.display = 'block';
        fileActaIncumplimiento.setAttribute("required","true");
        seccionSeguimiento.style.display = 'none';
        inputFechaSeguimiento.removeAttribute("required");
    }else{
        seccionAuditoriaNoEjecutada.style.display = 'none';
        fileActaIncumplimiento.removeAttribute("required");
        seccionSeguimiento.style.display = 'block';

    }
}

window.activarFechaSeguimiento = function(e) {
    var fechaSeguimiento = document.getElementById('fecha_seguimiento');
    var inputFechaSeguimiento = document.getElementById('input-fecha-seguimiento');
    if(e.checked){
        fechaSeguimiento.style.display = 'block';
        inputFechaSeguimiento.setAttribute("required","true");
    }else{
        fechaSeguimiento.style.display = 'none';
        inputFechaSeguimiento.removeAttribute("required");

    }
}

const btnGenerarInformeAuditoria = document.getElementById('btnGenerarInformeAuditoria');
const btnGuardarInformeAuditoria = document.getElementById('btnGuardarInformeAuditoria');

if(btnGenerarInformeAuditoria){
    btnGenerarInformeAuditoria.addEventListener("click", function (event) {
        const formulario = document.getElementById("fomGuardarInformeAuditoria");



        if (formulario.checkValidity()){
            event.preventDefault(); // Evita que el formulario se envíe si no pasa la validación
            const modal_confirm = new Modal(document.getElementById('modal-confirm-informe-auditoria'))
            modal_confirm.show();
            document.getElementById('msjConfirm').innerHTML ='Al finalizar la auditoría ya no podrán realizarse cambios.';
        }
    });
}
if (btnGuardarInformeAuditoria){
    btnGuardarInformeAuditoria.addEventListener("click", function (event) {
        const formulario = document.getElementById("fomGuardarInformeAuditoria");
        if (formulario.checkValidity()){
            event.preventDefault();
            formulario.submit();
        }
    });
}
