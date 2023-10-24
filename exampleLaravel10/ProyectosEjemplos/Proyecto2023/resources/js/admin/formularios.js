window.formularioPregunta = function(seccion_id,pregunta_id=null,pregunta=null,descripcion=null){
    let form = document.getElementById('formAgregarPregunta');
    form.reset();
    document.getElementById('tituloFormularioPregunta').innerHTML='Agregar pregunta';
    document.getElementById('pregunta_seccion_id').value=seccion_id;
    document.getElementById('pregunta_id').value="";
    if(pregunta_id && pregunta){
        let editor = tinymce.get("pregunta");
        document.getElementById('tituloFormularioPregunta').innerHTML='Editar pregunta';
        document.getElementById('pregunta_id').value=pregunta_id;
        editor.setContent(pregunta);
        document.getElementById('descripcion_pregunta').value=descripcion??'';
    }
    document.getElementById('divFormularioPregunta').classList.remove('d-none');
}

window.cancelarAgregarPregunta = function(){
    let form = document.getElementById('formAgregarPregunta');
    form.reset();
    document.getElementById('divFormularioPregunta').classList.add('d-none');
}

window.formularioSeccion=function(id=null,nombre=null){
    document.getElementById('modalAgregarSeccionTitulo').innerHTML="Agregar sección";
    document.getElementById('idFormularioSeccion').value="";
    let modal = new Modal(document.getElementById('modalAgregarSeccion'));
    let form = document.getElementById('formAgregarFormularioSeccion');
    form.reset();
    if(id && nombre){
        document.getElementById('modalAgregarSeccionTitulo').innerHTML="Editar sección";
        document.getElementById('idFormularioSeccion').value=id;
        document.getElementById('nombreFormularioSeccion').value=nombre;
    }
    modal.show();
}

