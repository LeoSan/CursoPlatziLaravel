
var monto_original = null;
var expediente = document.getElementById('numero_expediente');
var maskOptions = {
    mask: 'ILN-*************',
    placeholder: 'ILN-*************'
};
if(expediente)
    var mask = imask(expediente, maskOptions);

let form_registro_caso = document.getElementById('form_registro_caso');
if(form_registro_caso){
    form_registro_caso.addEventListener('keypress', function (e) {
        var key = e.charCode || e.keyCode || 0;
        if (key === 13) {
            e.preventDefault();
        }
    });
    form_registro_caso.addEventListener('submit',function(e){
        let tipo_envio = document.getElementsByName('tipo_submit')[0].value;
        let infracciones = document.querySelectorAll('.monto_infraccion').length;
        e.preventDefault();
        if(tipo_envio==='borrador')
            form_registro_caso.submit();
        else{
            form_registro_caso.classList.add("necesita-validacion");
            validarFormulario(event)
            if (form_registro_caso.checkValidity() !== false){
                if(infracciones===0){
                    document.getElementById('alerta_sanciones').innerHTML=
                        `<div class="alert alert-danger alert-dismissible">
                        <strong>¡Advertencia! </strong>
                        Debe agregar por lo menos una infracción en la tabla de sanciones.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`;
                    document.getElementById('anio_infraccion').focus();
                }
                else
                    form_registro_caso.submit();
            }
        }
    });
}

window.anioInfraccion= function (e,selectInfracciones, valor_select = null){
    let select = document.getElementById(selectInfracciones);
    if(select && e.value){
            axios.post(base_url+'/api/getInfraccionesByAnio',{
                anio:e.value
            })
            .then(function (response) {
                if(response.data){
                    select.innerHTML=response.data.html;
                    select.removeAttribute('disabled');
                    select.classList.remove('campo-dis');
                   //Regla Nueva: Si el usuario cambia de año este debe limpiar los registros de las multas de la tabla dinamica
                   //Esto es para validar si es un formulario nuevo o un formulario pre recargado ya con valores para este caso el anio.
                   if (  parseInt(valor_select)!=parseInt(e.value) ){
                        eliminarRegistrosTablaMultas('idTableMulta', 'bg-multa');
                   }

                }
            })
            .catch(function (response) {
                console.log(response);
            });
    }else{
        select.innerHTML=`<option value="">Seleccione el año</option>`;
        select.value = "";
        select.classList.add("campo-dis");
        document.getElementById('monto_infraccion').classList.add("campo-dis");
    }
}

var inputMulta = document.getElementById('monto_infraccion');
if(inputMulta){
    let btnAgregar = document.getElementById('btn_agregar_multa');
    inputMulta.addEventListener('keyup',function(e){
        let valor = this.value;
        this.value = lempiras(valor);
        if(this.value!=="")
            btnAgregar.removeAttribute('disabled');
        else
            btnAgregar.setAttribute('disabled',true);
    }) ;
    inputMulta.addEventListener('change',function(e){
        let valor = this.value;
        this.value = lempiras(valor);
        if(this.value!=="")
            btnAgregar.removeAttribute('disabled');
         else
            btnAgregar.setAttribute('disabled',true);
    });
}

window.selectedInfraccion= function (e,inputMontoInfraccion){
    let inputMonto = document.getElementById(inputMontoInfraccion);
    if(inputMonto && e.value){
        let sancion = document.querySelector(`#${e.id} option[value="${e.value}"]`).dataset;
        inputMonto.value=`${sancion.monto}`;
        monto_original = `${sancion.monto}`;
        if(parseInt(sancion.editable)){
            inputMonto.setAttribute('placeholder','Escriba el monto');
            inputMonto.removeAttribute('readonly');
            inputMonto.classList.remove('campo-dis');

        }else{
            inputMonto.setAttribute('readonly',true);
            inputMonto.setAttribute('placeholder','Seleccione la infracción');
            inputMonto.classList.add('campo-dis');
        }
    }else{
        inputMonto.value="";
        inputMonto.setAttribute('readonly',true);
        inputMonto.classList.add('campo-dis');
    }
    inputMonto.dispatchEvent(new Event('change'));
}

window.calculoTotalMulta = function(){

    let anio = document.getElementById('anio_infraccion');
    let total = new BigNumber(0);
    let items = 0;
    var infracciones = document.querySelectorAll('.monto_infraccion');
    Array.prototype.slice.call(infracciones)
        .forEach(function(e){
                items++;
                let valor = new BigNumber(e.value.replace('L ','').replaceAll(',',''));
                total = total.plus(valor);
        });
    document.getElementById('total_multa').innerHTML=`L ${lempiras(total.toFixed(2))}`;
    if(items===0){
        let tbody = document.getElementById('body_tabla_sanciones');
        let html = `<tr id="tr_info_sanciones">
                                            <td colspan="4">Sin infracciones</td>
                                        </tr>`;
        tbody.innerHTML=html+tbody.innerHTML;
        anio.removeAttribute('disabled');
        document.getElementById('anio_infraccion').setAttribute('required');
        document.getElementById('infraccion_id').setAttribute('required');
        document.getElementById('monto_infraccion').setAttribute('required');
    }else{
        document.getElementById('anio_infraccion').removeAttribute('required');
        document.getElementById('infraccion_id').removeAttribute('required');
        document.getElementById('monto_infraccion').removeAttribute('required');
    }

}

window.editarInfraccion = function(e,uid){
    e.setAttribute('disabled','disabled');
    let input = document.getElementById(`monto-${uid}`);
    input.removeAttribute('readonly');
    input.value = input.value.replace('L ','');
    input.addEventListener('keyup',function(){
        let valor = input.value;
        input.value = lempiras(valor);
    });
    input.focus();
    input.addEventListener('focusout',function(){
        input.value = 'L '+input.value.replace('L ','');
        input.setAttribute('readonly','readonly');
        e.removeAttribute('disabled');
        input.removeEventListener('keyup',null);
        input.removeEventListener('focusout',null);
        calculoTotalMulta();
    })
}

window.eliminarInfraccion = function(e){
    e.parentElement.parentElement.remove();
    calculoTotalMulta();
}

window.agregarInfraccion = function(){
    
    let uid = uuid();
    let change = new Event('change');
    let anio = document.getElementById('anio_infraccion');
    let infraccion = document.getElementById('infraccion_id');
    let sancion = document.querySelector(`#infraccion_id option[value="${infraccion.value}"]`).dataset;
    let monto = document.getElementById('monto_infraccion');
    let tbody = document.getElementById('body_tabla_sanciones');
    let editar = '';
    let val_monto = monto.value; 

    monto_original = monto_original.replace(/,/g, "");
    val_monto = monto.value.replace(/,/g, "");

    //console.log("monto_original->", parseFloat(monto_original));
    //console.log("monto_nuevo->", parseFloat(val_monto));

    if (parseFloat(val_monto) < parseFloat(monto_original)){
        imprimeAlertaMonto('El monto es inferior.');
        return false; 
    }


   if(monto.value.length == 0 || monto.value == '' || monto.value == '0.00' ){
        imprimeAlertaMonto('Debe agregar por lo menos un monto para la multa.');
   }else{
    document.getElementById('alerta_sanciones').innerHTML = '';
    document.getElementById('divlistMultas').classList.remove("d-none");
    if(parseInt(sancion.editable))
        editar = `<button type="button" class="btn btn-sm btn-info my-1" title="Eliminar infracción" onclick="editarInfraccion(this,'${uid}')">
                    <i class="fa fa-edit text-white p-0 m-0"></i>
                </button>`;
    if(document.getElementById('tr_info_sanciones'))document.getElementById('tr_info_sanciones').remove();
    let html =
        `<tr class="bg-multa">
            <td style="max-width: 70px">
                <input type="hidden" name="sanciones['${uid}']['infraccion_id']" value="${infraccion.value}">
                <input name="sanciones['${uid}']['anio']" type="text" class="w-100 p-0 m-0 text-center" readonly value="${anio.value}">
            </td>
            <td><input name="sanciones['${uid}']['concepto']" type="text" class="w-100 p-0 m-0 text-center" readonly value="${sancion.concepto}"></td>
            <td><input name="sanciones['${uid}']['monto']" id="monto-${uid}" type="text" class="w-100 p-0 m-0 text-center monto_infraccion" maxlength="29" readonly value="L ${monto.value}"></td>
            <td>
                ${editar}
                <button type="button" class="btn btn-sm btn-danger my-1" title="Eliminar infracción" onclick="eliminarInfraccion(this)">
                    <i class="fa fa-trash text-white p-0 m-0"></i>
                </button>
            </td>
        </tr>`;
    tbody.innerHTML=html+tbody.innerHTML;

    /*anio.value="";
    anio.dispatchEvent(change);*/
    //anio.setAttribute('disabled',true);
    infraccion.value="";
    infraccion.dispatchEvent(change);
    monto.value="";
    monto.dispatchEvent(change);
    calculoTotalMulta();

   }

}

let btn_borrador = document.getElementById('btn_borrador_caso');
if(btn_borrador){
    btn_borrador.addEventListener('click',function(){
        document.getElementsByName('tipo_submit')[0].value="borrador";
    });
}

let btn_envio_caso = document.getElementById('btn_envio_caso');
if(btn_envio_caso){
    btn_envio_caso.addEventListener('click',function(){
        document.getElementsByName('tipo_submit')[0].value="envio";
    });
}

window.eliminarCaso = function(caso_id){
    document.getElementById('eliminar_caso_id').value=caso_id;
}

window.addEventListener('load',function(){
    let select = document.getElementById('anio_infraccion');
   if(select)
       select.dispatchEvent(new Event('change'));
});


let btn_seguimiento_caso = document.getElementById('btn_seguimiento_caso');
if(btn_seguimiento_caso){
    btn_seguimiento_caso.addEventListener('click',function(){
        document.getElementsByName('tipo_submit')[0].value="envio";
    });
}

let form_seguimiento_pgr = document.getElementById('form_seguimiento_pgr');
if(form_seguimiento_pgr){
    form_seguimiento_pgr.addEventListener('keypress', function (e) {
        var key = e.charCode || e.keyCode || 0;
        if (key === 13) {
            e.preventDefault();
        }
    });
    form_seguimiento_pgr.addEventListener('submit',function(e){
        let tipo_envio = document.getElementsByName('tipo_submit')[0].value;
        e.preventDefault();
        if(tipo_envio==='borrador'){
            form_seguimiento_pgr.submit();
        }
        else{
            form_seguimiento_pgr.classList.add("necesita-validacion");
            validarFormulario(event);
            if (form_seguimiento_pgr.checkValidity() === false)
                //form_seguimiento_pgr.reportValidity();
                e.preventDefault();
            else
                form_seguimiento_pgr.submit();
        }
    });
}

if(screen.width < 576){
    var elementoCollapse = document.getElementById("collapseFiltrosCasos");
    if(elementoCollapse)
        elementoCollapse.className += "collapse";
}

let form_otro_descargo = document.getElementById('form_otro_descargo');
if(form_otro_descargo) {
    form_otro_descargo.addEventListener('submit', function (e) {
        e.preventDefault();
        if (form_otro_descargo.checkValidity() !== false){
                const modalOtroDescargo = new Modal(document.getElementById('modalOtroDescargo'))
                modalOtroDescargo.show();
        }
    });
    window.submitFormOtroDescargo = function(){
        form_otro_descargo.submit();
    }
}


const eliminarRegistrosTablaMultas = (ids_tabla, nom_class)=>{
    //Primero : Elimino los montos relacionados con el año ya previamente seleccionado
    let tabla = document.getElementById(ids_tabla);
    let filas = tabla.getElementsByTagName("tr");

    // Recorre las filas y elimina aquellas que tengan la clase "bg-multa"
    for (var i = filas.length - 1; i >= 0; i--) {
        if (filas[i].classList.contains(nom_class)) {
            tabla.deleteRow(i);
        }
    }

    //Segundo: Limpio el campo monto
    document.getElementById('monto_infraccion').value="";
    document.getElementById('monto_infraccion').classList.add("campo-dis");
    //Tercero: Oculto el encabezado de la tabla multas
    document.getElementById('divlistMultas').classList.add("d-none");
}

const imprimeAlertaMonto =(text)=>{
    document.getElementById('alerta_sanciones').innerHTML=
    `<div class="alert alert-danger alert-dismissible">
    <strong>¡Advertencia! </strong>
    `+text+`
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>`;
}
