window.formularioCatalogos = function(accion,el=null){
    let data = el.dataset;
    let form = document.getElementById('formCatalogoElementos');
    form.reset();
    let modal = new Modal(document.getElementById('modalCatalogoElementos'));
    let titulo = document.getElementById('modalCatalogoElementosTitulo');
    let btn = document.getElementById('btnFormCatalogoElementos');
    document.getElementById('catalogoElementoId').value=null;
    if(accion!==""){
        if(accion==="crear"){
            titulo.innerHTML="Crear elemento";
            btn.innerHTML="Crear";
        }else if(accion==="editar"){
            titulo.innerHTML="Editar elemento";
            btn.innerHTML="Guardar";
            document.getElementById('catalogoElementoId').value=data.id;
            document.getElementById('nombre_elemento').value=data.nombre;
            document.getElementById('codigo_elemento').value=data.codigo;
            if(data.categoria)
            document.getElementById('categoria_elemento').value=data.categoria;
            if(data.descripcion)
                document.getElementById('descripcion_elemento').value=data.descripcion;
            if(data.parent_id)
                document.getElementById('padre_elemento').value=data.parent_id;
        }
        modal.show();
    }
}

//Días Inhabiles

window.openModalFormulario = function(nombre_modal, nombre_titulo, nombre_form, btnFormulario, accion, el=null){
    let data = el.dataset;
    let form = document.getElementById(nombre_form);
    form.reset();
    let modal = new Modal(document.getElementById(nombre_modal));
    let titulo = document.getElementById(nombre_titulo);
    let btn = document.getElementById(btnFormulario);

    console.log(data);

    if(accion!==""){
        if(accion==="crear"){
            titulo.innerHTML="Crear día inhábil";
            btn.innerHTML="Crear";
            document.getElementById('accion').value='crear';

        }

        if(accion==="eliminar"){
            titulo.innerHTML="Eliminar día inhábil";
            btn.innerHTML="Eliminar";
            let formulario = Object.entries(data);
            document.getElementById('id_e').value = data.id;
            document.getElementById('accion_e').value = data.accion;

        }

        if(accion==="editar"){
            titulo.innerHTML="Editar día inhábil";
            btn.innerHTML="Guardar";
            let formulario = Object.entries(data);
            //Cargo Los datos en el formulario
            formulario.forEach((item, index)=>{
                document.getElementById(item[0]).value=item[1];
            })
        }
        modal.show();
    }
}
