/*
 * Funcionamientos del Formulario Denuncias
*/
//Instancias de Objetos DOM
let form1 = document.getElementById("form_1");
let form2 = document.getElementById("form_2");
let form3 = document.getElementById("form_3");
var ftab  = false;//Variable sentinelas
var Stab  = false;//Variable sentinelas
let paso1 = document.getElementById('home-tab');
let paso2 = document.getElementById('profile-tab');
let paso3 = document.getElementById('contact-tab');

const btnAnteriortab         = document.getElementById('btnAnteriortab');
const btnAnteriortabDos      = document.getElementById('btnAnteriortabDos');
const btnDenunciaAceptada    = document.getElementById('btnDenunciaAceptada');
const btnValidaActualizacion = document.getElementById('btnValidaActualizacion');
const btnEnviarActualizacion = document.getElementById('btnEnviarActualizacion');
const btnEnviarSolicitudExpediente = document.getElementById('btnEnviarSolicitudExpediente');

let inpCorreo       = document.getElementById('inpCorreo');
let inpCorreoDgit   = document.getElementById('inpCorreoDgit');
let inpConfCorreo   = document.getElementById('inpConfCorreo');
let selOrigen       = document.getElementById('selOrigen');
let checkCorreoDgti = document.getElementById('checkCorreoDgti');
let cBoxRespuestaFisica = document.getElementById('cBoxRespuestaFisica');

//Listado de Operaciones
//Operación: Funcionalidad al dar clic al formulario dentro del #tag [Datos del denunciante ]
if (form1){
    form1.addEventListener("submit",function(e){
        e.preventDefault();
        validarFormulario(e)
        var validEmail =  /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;
        if((inpCorreo.value.length > 0 && inpConfCorreo.value.length > 0)){
            if (confirmaCorreo('inpCorreo', 'inpConfCorreo' ) == 'igual'){
            // Using test we can check if the text match the pattern
            if( validEmail.test(inpCorreo.value) ){
                imprimirMensajeValidacion(e, 'inpCorreo', '');
                imprimirMensajeValidacion(e, 'inpConfCorreo', '');
                if (!form1.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }else{
                    cambioTagGeneral(e, 'profile-tab', 'home-tab', 'contact-tab', 'home-tab-pane');
                    ftab = true;
                }
                
            }else{
                imprimirMensajeValidacion(e, 'inpCorreo', 'Por favor ingrese un correo válido');
                imprimirMensajeValidacion(e, 'inpConfCorreo', '');
            }

        }else{
            if( validEmail.test(inpCorreo.value) ){
                imprimirMensajeValidacion(e, 'inpCorreo', '');
                imprimirMensajeValidacion(e, 'inpConfCorreo', 'Por favor, confirma tu correo');
            }else{
                imprimirMensajeValidacion(e, 'inpCorreo', 'Por favor ingrese un correo válido');
                imprimirMensajeValidacion(e, 'inpConfCorreo', '');
                }
        }
    }
    if (!form1.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
    }
    });
}
//Operación: Funcionalidad al dar clic al formulario dentro del #tag [Datos de la Denuncia -> siguiente ]
if (form2){
    form2.addEventListener("submit",function(e){
        e.preventDefault();
        validarFormulario(e)
        if (!form2.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }else{
                    cambioTagGeneral(e, 'contact-tab', 'profile-tab', 'home-tab', 'contact-tab-pane');
                     Stab = true;
                }
    });
}
//Operaciones de los botones Circulares
//Operación:
if(paso1){
    paso1.addEventListener("click",function(e){
        e.preventDefault();
        cambioTagGeneral(e, 'home-tab', 'profile-tab', 'contact-tab', 'profile-tab-pane', true);
   });
}
//Operación:
if(paso2){
    paso2.addEventListener("click",function(e){
        e.preventDefault();
        if (ftab){
            cambioTagGeneral(e, 'profile-tab', 'home-tab', 'contact-tab', 'home-tab-pane', true);
        }
   });
}
//Operación:
if(paso3){
    paso3.addEventListener("click",function(e){
        e.preventDefault();
        if (Stab){
            cambioTagGeneral(e, 'contact-tab', 'profile-tab', 'home-tab', 'profile-tab-pane', false);
        }
   });
}

//Operación: Funcionalidad al dar clic al formulario dentro del #tag [Datos de la Denuncia -> regresar ]
if (btnAnteriortab){
    btnAnteriortab.addEventListener("click", function(e){
        cambioTagGeneral(e, 'home-tab', 'contact-tab', 'profile-tab', 'profile-tab-pane');
    });
}
//Operación: Funcionalidad al dar clic al formulario dentro del #tag [Datos de la Denuncia -> regresar ]
if (btnAnteriortabDos){
    btnAnteriortabDos.addEventListener("click", function(e){
        cambioTagGeneral(e,'profile-tab', 'contact-tab', 'home-tab', 'contact-tab-pane');
    });
}
//Operación: Permite indicar si es sindicato o persona normal
if (selOrigen){
    selOrigen.addEventListener("change", function(e){
        let datos_sindicato = document.getElementById('divSindicato');
        let datos_persona = document.getElementById('divPersona');
        let divTitulo = document.getElementById('divTitulo');
        let inpNomSindicato = document.getElementById('inpNomSindicato');
        let inpNombreDenunciante = document.getElementById('inpNombreDenunciante');
        let inpPrimerApellido = document.getElementById('inpPrimerApellido');
        let selected = selOrigen.options[selOrigen.selectedIndex].text;

        if (selected === 'Sindicato'){
            datos_sindicato.classList.remove("d-none");
            datos_persona.classList.add("d-none");
            divTitulo.innerHTML="Información general";
            inpNombreDenunciante.removeAttribute('required');
            inpPrimerApellido.removeAttribute('required');
            inpNomSindicato.setAttribute('required',true);
            inpNombreDenunciante.value='';
            inpPrimerApellido.value='';
        }else{
            datos_persona.classList.remove("d-none");
            datos_sindicato.classList.add("d-none");
            divTitulo.innerHTML="Informacion personal";
            inpNombreDenunciante.setAttribute('required',true);
            inpPrimerApellido.setAttribute('required',true);
            inpNomSindicato.removeAttribute('required');
            inpNomSindicato.value='';
        }
    });
}
//Operación: Carga toda la data y la envia al Api
if (form3){
    form3.addEventListener("submit",function(e){
        e.preventDefault();
        validarFormulario(e)
        var F1 = document.getElementById("form_1");
        var F2 = document.getElementById("form_2");
        var F3 = document.getElementById("form_3");
        var obj = {};
        var formData1 = new FormData(F1);
        var formData2 = new FormData(F2);
        var formData3 = new FormData(F3);
        let footer = document.getElementById('footer_eliminar');
        const selOficinaDenunciaInput = document.getElementById('selOficinaDenuncia');
        formData2.append("oficina_regional_id", selOficinaDenunciaInput.value);
        //Genero Matriz para los datos de cada formulario
        for (var key of formData1.keys()) {
            obj[key] = formData1.get(key);
        }
        for (var key of formData2.keys()) {
            obj[key] = formData2.get(key);
        }
        for (var key of formData3.keys()) {
            obj[key] = formData3.get(key);
        }

        const fileInput = document.getElementById('oficio_denuncia');
        formData3.append('documento_archivo_oficio_denuncia', fileInput.files[0]);//la clave esta aqui de los files[0]
        formData3.append('accept_oficio_denuncia', document.getElementById('accept_oficio_denuncia').value);//la clave esta aqui de los files[0]
        formData3.append('isValor', document.getElementById('isValor').textContent);//la clave esta aqui de los files[0]
        formData3.append('formulario', JSON.stringify(obj));
        
        //Valido si tiene purbeas y si al menos tiene un archivo cargado
         if (validaCampoFile("documentos_archivos_pruebas_denuncia_1") && obj['cuenta_con_pruebas'] == 'true'){
            document.getElementById('btnEnviarDenuncia').removeAttribute("disabled");
         }else{
            if (!validaCampoFile("documentos_archivos_pruebas_denuncia_1") && obj['cuenta_con_pruebas'] == 'true'){
                document.getElementById('selOficinaDenuncia').removeAttribute("disabled");
                document.getElementById('btnEnviarDenuncia').setAttribute("disabled", "true");
                enviarPostAxios(`${base_url}/api/sendDataDenuncia`, formData3);
            }
            else { 
                if(obj['cuenta_con_pruebas'] == 'false'){
                document.getElementById('selOficinaDenuncia').removeAttribute("disabled");
                document.getElementById('btnEnviarDenuncia').setAttribute("disabled", "true");
                enviarPostAxios(`${base_url}/api/sendDataDenuncia`, formData3);
                }
            }            
        }       
        
    });
}
//Operación: Carga toda la data y la envia al Api
if(btnDenunciaAceptada){
    btnDenunciaAceptada.addEventListener("click",function(e){
        if (localStorage.getItem("permiso_registro") == 'true'){
            location.replace(base_url+'/denuncias/registrar-denuncia');
        }else{
            location.replace(base_url+'/denuncias/registrar-denuncia');
        }
   });
}
//Operación: valida si esta check para habilitar campos
if(checkCorreoDgti){
    checkCorreoDgti.addEventListener("click",function(e){
        let    checked       = checkCorreoDgti.checked;
        const  inpCorreoDgit = document.getElementById('inpCorreoDgit');
        const  contCorreoDenuncia = document.getElementById('contCorreoDenuncia');

        if(checked){
            contCorreoDenuncia.classList.remove('d-none');
            inpCorreoDgit.removeAttribute("disabled");
        }else{
            contCorreoDenuncia.classList.add('d-none');
            inpCorreoDgit.setAttribute('disabled',true);
            inpCorreoDgit.value = '';
        }
   });
}
//Operación:
if(cBoxRespuestaFisica){
    cBoxRespuestaFisica.addEventListener("click",function(e){
        document.getElementById('divFechaReciboDenucnia').classList.toggle('d-none');
        //document.getElementById('inpCorreoDgit').value = '';
   });
}
//Operación:Permite entender y validar si es un usuario con el permiso
if(localStorage.getItem("permiso_registro") == 'true'){
    const select_medio_recepcion = document.getElementById('selMedioRecepcion');
    if (select_medio_recepcion){
        for(let i=0; i<select_medio_recepcion.options.length;i++){
            if (select_medio_recepcion.options[i].dataset.codigo === 'linea_recepcion'){
                select_medio_recepcion.options[i].style.display = 'none';
            }
        }
    }
}
//Operación: Permite validar el formulario de respuesta providencia
if(btnValidaActualizacion){
    btnValidaActualizacion.addEventListener("click",function(e){
        e.preventDefault();
        let is_submit = true;
        const observacion_adicional = document.getElementById('inpDescripcionAdicional').value;
        const inpFechaRecepcion = document.getElementById('inpFechaRecepcion');
        let edit_text = document.querySelector( '.tox-edit-area__iframe' );

        if (document.getElementById('cBoxRespuestaFisica') && document.getElementById('cBoxRespuestaFisica').checked){
            if (inpFechaRecepcion.value.length == 0){
                manejadorMesjValidacion('.msj-validacion', 'inpFechaRecepcion', 'Dato obligatorio.', 10000);
                inpFechaRecepcion.style.border="1px solid red";
                inpFechaRecepcion.classList.add('invalido');
                is_submit = false;

            }else{
                inpFechaRecepcion.classList.remove('invalido');
                inpFechaRecepcion.style.border="1px solid #c7c9d9";
            }
        }
        if (observacion_adicional.length == 0 || observacion_adicional == '' ){
            manejadorMesjValidacion('.msj-validacion', 'inpDescripcionAdicional', 'Dato obligatorio.', 10000);

            edit_text.style.border="1px solid red";
            edit_text.classList.add('invalido');
            is_submit = false;

        }else{
            edit_text.style.border="1px solid #c7c9d9";
            edit_text.classList.remove('invalido');
        }

        if (is_submit){
            if ( btnValidaActualizacion.dataset.modal == 'NoSoyModal'){
                abrirModal('confirmaActualizarModal');
            }
        }
   });
}
//Operación: Permite validar el formulario Solicitar Expediente
if(btnEnviarSolicitudExpediente){
    btnEnviarSolicitudExpediente.addEventListener("click",function(e){
        e.preventDefault();
        let is_submit = true;
        const inpUsuarioRegional = document.getElementById('usuario').value;
        const num_expediente_dgit = document.getElementById('num_expediente_dgit').value;
        const fileInput  = document.getElementById('oficio_solicitar_expediente');
        if (inpUsuarioRegional.length == 0 || inpUsuarioRegional == '' ){
            manejadorMesjValidacion('.msj-validacion', 'usuario', 'Dato obligatorio.', 10000);
            is_submit = false;
        }
        if (num_expediente_dgit.length == 0 || num_expediente_dgit == '' ){
            manejadorMesjValidacion('.msj-validacion', 'num_expediente_dgit', 'Dato obligatorio.', 10000);
            is_submit = false;
        }
        if (fileInput.files[0] == undefined ){
            manejadorMesjValidacion('.msj-validacion', 'oficio_solicitar_expediente', 'Dato obligatorio.', 10000);
            is_submit = false;
        }

        if (is_submit){
            document.getElementById('form_solicitar_expediente').submit();
        }
   });
}
//Operación:Permite enviar la información luego de ser validada
if(btnEnviarActualizacion){
    btnEnviarActualizacion.addEventListener("click",function(e){
        e.preventDefault();
        document.getElementById('btnValidaActualizacion').setAttribute("disabled", "true");
        document.getElementById('formDatosAdicional').submit();
   });
}

//Listado de Metodo
//Metodo: Permite realizar los  cambios dinamicos entre tags
const cambioTagGeneral = (e,tag_deseado, tag_ocultar_uno, tag_ocultar_dos, panel_actual, is_button_sup=false)=>{
    try {
        let val_deseado      = document.getElementById(tag_deseado);
        let val_ocultar_uno  = document.getElementById(tag_ocultar_uno);
        let val_ocultar_dos  = document.getElementById(tag_ocultar_dos);
        let panel_actualf    = document.getElementById(panel_actual);

        //Cambios de estados
        panel_actualf.classList.remove("show");
        panel_actualf.classList.remove("active");
        val_deseado.removeAttribute('disabled');

        if (!is_button_sup ){
            val_deseado.dispatchEvent(new Event('click'));//Trigger en Java Script
        }
        //Estilo Tag
        val_ocultar_uno.classList.remove("tag-activo");
        val_ocultar_dos.classList.remove("tag-activo");
        val_deseado.classList.add("tag-activo");
    } catch (error) {
        console.log(error);
    }
}
//Metodo: confirmación de correo
const confirmaCorreo = (campo_uno, campo_dos)=>{
    let correo = document.getElementById(campo_uno).value;
    let correo_confirmado = document.getElementById(campo_dos).value;
    if ((correo != correo_confirmado)){
        return 'diferente';
    }else{
        return 'igual';
    }
    
   
}
//Metodo: imprimir mensaje personalizado
const imprimirMensajeValidacion = (e, campo, mensaje)=>{
    e.preventDefault();
    let elemento = document.getElementById(campo);

    var invalidFeedback = elemento.closest('.form-group').querySelector('.invalid-feedback');
    if (invalidFeedback) {
    invalidFeedback.setAttribute("data-default", mensaje);
    
    elemento.setCustomValidity(mensaje);
    invalidFeedback.textContent = mensaje;
    }
}
//Metodo: Permite usar el axion en post request
const enviarPostAxios = async (api_url,payload ) =>{
    try {
        const {data, status } = await axios.post(api_url, payload, {headers: { 'Content-Type': 'multipart/form-data' }});
        if (status == 201){
            abrirModal('exampleModal', data.folio);
        }else{
            //Mensaje de validación Back
            mostrarAlertError('divValidateBack', 'spanValidateBack', data.error, true);
            document.getElementById('btnEnviarDenuncia').removeAttribute("disabled");
        }
    } catch (error) {
        console.log('er'+error['response']['status']);
        document.getElementById('btnEnviarDenuncia').setAttribute("disabled", "false");
        document.getElementById('btnEnviarDenuncia').removeAttribute("disabled");
        if(error['response']['status'] != 413){
        mostrarAlertError('divValidateBack', 'spanValidateBack', 'Ocurrio un fallo de conexión, vuelva intentarlo.', true);
        }
    }
}
//Metodo: permite mostrar el resultado dependiendo el status 200 ó 404
const mostrarAlertError=(divBack, spanBack, mensaje, addClass=null)=>{
    let divValidateBack = document.getElementById(divBack);
    let spanValidateBack = document.getElementById(spanBack);
        spanValidateBack.innerHTML = mensaje;
        divValidateBack.classList.add('show');
        if (addClass){
            divValidateBack.classList.add('my-1');
            divValidateBack.classList.add('py-3');
        }

        setTimeout(() => {
            divValidateBack.classList.remove('show');
            divValidateBack.classList.remove('my-1');
            divValidateBack.classList.remove('py-3');
        }, 10000);

}
//Metodo: Abre el modal
const abrirModal=(target, folio = null)=> {
    const modal = document.getElementById(target);

    //crea ka sombra
    const overlay = document.createElement('div');
    overlay.classList.add('modal-overlay', 'fade', 'show');
    document.body.appendChild(overlay);

    if (folio != null){
        //ingreso valor
        document.getElementById('valFolio').innerHTML = folio;
    }
    //abre modal
    modal.style.display = 'block';
    modal.classList.add('show');
    document.body.classList.add('modal-open');
}
//Metodo: PErmite validar si el archivo esta vacio o no
const validaCampoFile = (nombreFile )=>{
    
    const fileInput = document.getElementById(nombreFile);
    if(fileInput){
        const file = fileInput.files[0]; // Obtener el archivo cargado
        if (!file) {
            return  true;
        }
    }
    var ulElement = document.getElementById('lista_archivos_pruebas_denuncia');

    if(ulElement.getElementsByTagName('li').length == 1){
        return true;
    }
    return false;
}
//Metodo: permite realizar un cambio en el modal para que este pueda mostrar otra información
const manejadorMesjValidacion=(nomClass, idCampo, msj, timeout)=>{
    //e.preventDefault();
    const componente_mensaje = document.querySelectorAll(nomClass);
    componente_mensaje.forEach(span => {
        if (idCampo === span.dataset.campo){
            const parrafoValidacion = span.querySelector('p');
            parrafoValidacion.textContent = msj;
            document.getElementById(idCampo).focus();
            setTimeout(() => {
                parrafoValidacion.textContent = '';
            }, timeout);

        }
    });
}
//Metodo: Permite mostrar ocultar la carga de pruebas
window.validaPruebasDenuncias = function (e){
    const div_pruebas = document.getElementById('divCargaPruebaDenuncias');
    if (e.value === 'true'){
        div_pruebas.style.display = "block";
    }else{
        div_pruebas.style.display = "none";
    }
}
//Metodo: Permite reenviar al dar cli en cerrar
window.formatoClose = function (e, ruta=null){
    //e.preventDefault();
    if (btnDenunciaAceptada){
        btnDenunciaAceptada.dispatchEvent(new Event('click'))
    }else if(ruta){
        location.replace(base_url+ruta);
    }else{
        window.open(base_url+'/denuncias/registrar-denuncia', '_blank');
    }
}
//Metodo: Permite reenviar al dar cli en cerrar
window.cerrarAlertGeneral = function (e, divalert=null){
    let divValidateBack = document.getElementById(divalert);
    divValidateBack.classList.remove('show');
    divValidateBack.classList.remove('my-1');
    divValidateBack.classList.remove('py-3');
}
//Metodo: Permite reenviar al dar cli en cerrar
window.abrirModalConfirm = function (e, nombreModal=null){
    abrirModal(nombreModal);
}
