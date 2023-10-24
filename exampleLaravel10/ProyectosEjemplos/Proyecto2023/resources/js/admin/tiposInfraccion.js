window.accionTipoInfraccion = function(e){
    let data = e.dataset;
    let accion, texto;
    if(parseInt(data.activo)){
        if(!parseInt(data.eliminable)){
            accion = 'Eliminar';
            texto = `<p class="fw-bold p-1 m-1">¿Desea eliminar esta opción?</p><p class="p-1 m-1">Si confirma se hará un borrado lógico, de lo contrario no se realizará ninguna acción.</p>`;
        }else{
            accion = 'Deshabilitar';
            texto = `<p class="fw-bold p-1 m-1">¿Desea deshabilitar esta opción?</p><p class="p-1 m-1">Si confirma se dejará de mostrar la opción en el catálogo al llenar los casos, de lo contrario no se realizará ninguna acción.</p>`;
        }
    }else{
        accion = 'Habilitar';
        texto = `<p class="fw-bold p-1 m-1">¿Desea habilitar esta opción?</p><p class="p-1 m-1">Si confirma se mostrará la opción en el catálogo al llenar los casos, de lo contrario no se realizará ninguna acción.</p>`;
    }
    document.getElementById('tituloModalTipoInfraccion').innerHTML = accion;
    document.getElementById('idModalTipoInfraccion').value = data.id;
    document.getElementById('accionModalTipoInfraccion').value = accion.toLowerCase();
    document.getElementById('textoModalTipoInfraccion').innerHTML = texto;
    document.getElementById('btnModalTipoInfraccion').innerHTML = accion.toUpperCase();

}
let form = document.getElementById('formBusquedaTiposInfraccion');
if(form){
    let btn = document.getElementById('btn_reset_busqueda');
    if(btn)
        btn.addEventListener('click',function(){
            let busqueda = document.getElementById('busqueda');
            busqueda.value="";
            form.submit();
        })
}
