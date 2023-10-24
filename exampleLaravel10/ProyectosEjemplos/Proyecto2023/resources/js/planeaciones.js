function inputsAuditoriasMensuales() {
    const inputsAuditoriasMensuales = document.querySelectorAll('.auditorias-mensuales');

    if (inputsAuditoriasMensuales) {
        inputsAuditoriasMensuales.forEach(function(elemento) {
            elemento.addEventListener('click', () => {
                elemento.select();
            });

            elemento.addEventListener('keyup', actualizarTotalAuditorias);
            elemento.addEventListener('change', actualizarTotalAuditorias);

            elemento.addEventListener('focusout', function() {
                if (this.value === '') {
                    this.value = 0;
                }
            });
        });

        // Función para actualizar el total de auditorías
        function actualizarTotalAuditorias() {
            const totalAuditoriasSpan = document.getElementById('total_auditorias');
            const totalAuditoriasInput = document.getElementById('total_auditorias_input');
            let total = 0;

            inputsAuditoriasMensuales.forEach(input => {
                if (input.value < 0) {
                    input.value = 0;
                }
                if (input.value > 100) {
                    input.value = 100;
                }
                if (input.value !== '' && input.value > 0) {
                    total += parseInt(input.value);
                }
            });

            totalAuditoriasSpan.textContent = `${total}`;
            totalAuditoriasInput.value = `${total}`;
        }
    }
}

inputsAuditoriasMensuales();


function inputDepartamento() {
    const inputDepartamentoElemento = document.getElementById('departamento_id');

    if (inputDepartamentoElemento) {
        inputDepartamentoElemento.addEventListener('click', function() {

        });
    }
}

inputDepartamento();


function inputsEliminarRegistro() {
    const inputsEliminarRegistroElementos = document.querySelectorAll('.eliminar-registro');
    const inputsConfirmarEliminarElemento = document.getElementById('confirmar_eliminar');

    if (inputsEliminarRegistroElementos) {
        inputsEliminarRegistroElementos.forEach(function(elemento) {
            elemento.addEventListener('click', () => {
                const item = elemento.dataset.item;
                inputsConfirmarEliminarElemento.setAttribute('form', `form_delete_registro_${item}`);
            });
        });
    }
}

inputsEliminarRegistro();



function beforeSubmitAuditoriasMensual() {
    const planMensualAuditoriasForm = document.getElementById('plan_mensual_auditorias_form');

    if (planMensualAuditoriasForm) {
        planMensualAuditoriasForm.addEventListener('submit', function (event) {
            let totalAuditorias = document.getElementById('total_auditorias_input');
            totalAuditorias = totalAuditorias.value;

            console.log(totalAuditorias,'totalAuditorias');

            if (totalAuditorias == '0') {
                event.preventDefault();

                const vacioModal = new Modal(document.getElementById('vacioModal'));

                vacioModal.show();
            }
        });

    }
}

beforeSubmitAuditoriasMensual();


function aniosExistentes() {
    const aniosElemento = document.getElementById('anio');

    if (aniosElemento) {
        aniosElemento.addEventListener('change', function (event) {
            const anioSeleccionado = this.value;
            let existentes = document.getElementById('existentes');
            existentes = existentes ? existentes.value : false;

            const existentesArray = existentes ? existentes.split(',') : false;

            if(existentesArray && existentesArray.includes(anioSeleccionado)) {
                document.getElementById('anio_invalido').style.display = 'block';
                aniosElemento.setCustomValidity('Selección inválida. ');
            } else {
                document.getElementById('anio_invalido').style.display = 'none';
                aniosElemento.setCustomValidity('');
            }

        });
    }

}

aniosExistentes();

const formGrupoAuditorias = document.getElementById('form_grupo_auditorias');
if (formGrupoAuditorias) {
    formGrupoAuditorias.addEventListener('submit', function (event) {
        const auditoriaElemento = document.getElementById('auditoria');

        if (!auditoriaElemento && formGrupoAuditorias.checkValidity()) {
            event.preventDefault();

            const dataValidate = {
                planeacion : document.getElementById('planeacion').value,
                departamento : document.getElementById('dom_departamento_id').value,
                municipio : document.getElementById('dom_municipio_caso').value,
                inspeccion : document.getElementById('tipo_inspeccion_id').value,
                cafta : document.getElementById('cafta').value,
                actividad : document.getElementById('actividad_economica_id').value,
                auditor : document.getElementById('auditor_responsable_id').value,
            }

            axios.post('/planeaciones/planeacion/auditoria/validate', dataValidate)
                .then(function (response) {
                    console.log(response);
                    if (response.data.data === true) {
                        document.getElementById('duplicateModalMessage').textContent = response.data.message;
                        const duplicatedModal = new Modal(document.getElementById('duplicatedModal'));

                        duplicatedModal.show();
                    } else {
                        formGrupoAuditorias.submit();
                    }
                })
                .catch(function (error) {
                    console.error(error);
                });
        }
    });

    const launchFormGrupoAuditorias = document.getElementById('launch_form_grupo_auditorias');
    if (launchFormGrupoAuditorias) {
        launchFormGrupoAuditorias.addEventListener('click', function (event) {
            formGrupoAuditorias.submit();
        });
    }
}

/**Solicitudes de expedientes auditoria */
window.obtenerJefeRegional= function (e,inputRegionalId, btn_submit, btn_modal,){
    let val_regional_id = document.getElementById(inputRegionalId);
    if(val_regional_id && e.value){
        axios.post(base_url+'/api/obtenerJefeRegional',{
            regional_id:e.value
        }).then(function (response) {
            if(response.data){
                document.getElementById('inpNombre').value=response.data.datos.inp_nombre;
                document.getElementById('inpEmail').value=response.data.datos.inp_email;
                document.getElementById('inpJefeRegional').value = response.data.datos.inp_id;
                if (parseInt(response.data.datos.inp_id) >  0){
                    document.getElementById(btn_submit).classList.remove("d-none");
                    document.getElementById(btn_modal).classList.add("d-none");
                }else{
                    document.getElementById(btn_submit).classList.add("d-none");
                    document.getElementById(btn_modal).classList.remove("d-none");
                }
                //Limpio front para no generar confusión en datos
                document.getElementById('tabla_solicitud').classList.add("d-none");
                document.getElementById('mes_filtro').value=0;
            }
        }).catch(function (response) {
            console.log(response);
        });
    }
}


window.obtenerSolicitudMesRegional= function (e,select_mes, select_regional, inpValor, inp_estatus, tbody, ttable, btn_submit, btn_modal, inp_jefe_regional ){
    let val_mes = document.getElementById(select_mes);
    let val_regional = document.getElementById(select_regional).value;
    let valor = document.getElementById(inpValor).textContent;
    let val_estatus = document.getElementById(inp_estatus).value;
    
    if(val_mes && e.value){
        axios.post(base_url+'/api/obtenerSolicitudRegionMes',{
            mes:e.value,
            regional:val_regional,
            valor:valor,
            estatus:val_estatus,
        }).then(function (response) {
                if(response.data){
                    if (response.data.is_solicitud ){
                        document.getElementById(ttable).classList.remove("d-none");
                        document.getElementById(tbody).innerHTML = response.data.html;
                        if (parseInt(document.getElementById(inp_jefe_regional).value) >  0){
                            document.getElementById(btn_submit).classList.remove("d-none");
                            document.getElementById(btn_modal).classList.add("d-none");
                        }else{
                            document.getElementById(btn_submit).classList.add("d-none");
                            document.getElementById(btn_modal).classList.remove("d-none");
                        }
                    }else{
                        document.getElementById(ttable).classList.remove("d-none");
                        document.getElementById(btn_submit).classList.add("d-none");
                        document.getElementById(btn_modal).classList.remove("d-none");
                        document.getElementById(tbody).innerHTML=response.data.html;
                    }
                }
            })
            .catch(function (response) {
                console.log(response);
            });
    }
}

const btnSolicitarExpediente = document.getElementById('btnSolicitarExpediente');
const btnGuardarSolicitud = document.getElementById('btnGuardarSolicitud');
const btnFinalizarCargaDocSeguiModal = document.getElementById('btnFinalizarCargaDocSeguiModal');
const btnGuardarCargaDocAuditoria = document.getElementById('btnGuardarCargaDocAuditoria');
const btnProrrogaModal = document.getElementById('btnProrrogaModal');
const btnGuardarProrroga = document.getElementById('btnGuardarProrroga');

if(btnSolicitarExpediente){
    btnSolicitarExpediente.addEventListener("click", function (event) {
        const formulario = document.getElementById("form_solicitar_Expedientes");
        const combo_mes  = document.getElementById("mes_filtro");
        const mes        = combo_mes.options[combo_mes.selectedIndex].text;
        const anio       = document.getElementById("inpAnio").value;
        const combo_regional = document.getElementById("regional");
        const regional       = combo_regional.options[combo_regional.selectedIndex].text;
        const numero         = document.getElementById('spanTotalExpdiente')? document.getElementById('spanTotalExpdiente').textContent : null;
        validarFormulario(event);
        if (formulario.checkValidity()){
            event.preventDefault(); // Evita que el formulario se envíe si no pasa la validación
            const modal_confirm = new Modal(document.getElementById('modal-confirm-solicitud'))
            modal_confirm.show();
            document.getElementById('msjConfirm').innerHTML ='Se solicitarán <b>'+numero+' expediente(s)</b>  correspondientes a las auditorías del  mes de <b> '+mes+' de '+anio+' a la regional '+regional+'</b>'; 
        }
    });
}

if (btnGuardarSolicitud){
    btnGuardarSolicitud.addEventListener("click", function (event) {
        const formulario = document.getElementById("form_solicitar_Expedientes");
        if (formulario.checkValidity()){
            event.preventDefault(); 
            formulario.submit();
        }
    });
}

if(btnFinalizarCargaDocSeguiModal){
    btnFinalizarCargaDocSeguiModal.addEventListener("click", function (event) {
        const formulario = document.getElementById("form_carga_documentos_seguimiento");
        if (formulario.checkValidity()){
            event.preventDefault(); // Evita que el formulario se envíe si no pasa la validación
            const modal_confirm = new Modal(document.getElementById('modal-confirm-solicitud'))
            modal_confirm.show();
            document.getElementById('msjConfirm').innerHTML ='Al finalizar el seguimiento a la auditoría ya no podrán realizarse cambios.'; 
        }
    });
}

if (btnGuardarCargaDocAuditoria){
    btnGuardarCargaDocAuditoria.addEventListener("click", function (event) {
        const formulario = document.getElementById("form_carga_documentos_seguimiento");
        if (formulario.checkValidity()){
            event.preventDefault(); 
            formulario.submit();
        }
    });
}
if(btnProrrogaModal){
    btnProrrogaModal.addEventListener("click", function (event) {
        const formulario = document.getElementById("form_prorroga_solicitud_expedientes");
        if (formulario.checkValidity()){
            event.preventDefault(); // Evita que el formulario se envíe si no pasa la validación
            const modal_confirm = new Modal(document.getElementById('modal-confirm-solicitud'))
            modal_confirm.show();
            const plazo  = document.getElementById("inpDiasPlazo").value;
            const numero_oficio  = document.getElementById("inpNumOficio").value;
            const nom_jefe_regional  = document.getElementById("inpJefeRegional").value;
            document.getElementById('msjConfirm').innerHTML =`Se ampliarán <b>${plazo}</b> días el plazo para que el jefe de la regional <b>${nom_jefe_regional}</b> pueda responder la solicitud de información con número de oficio <b>${numero_oficio}</b>.`; 
        }
    });
}

if (btnGuardarProrroga){
    btnGuardarProrroga.addEventListener("click", function (event) {
        const formulario = document.getElementById("form_prorroga_solicitud_expedientes");
        if (formulario.checkValidity()){
            event.preventDefault(); 
            formulario.submit();
        }
    });
}

