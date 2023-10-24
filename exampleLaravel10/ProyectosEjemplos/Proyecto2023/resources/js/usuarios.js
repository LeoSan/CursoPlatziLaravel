window.getOpcionesEliminarUsuario = function(element){
    let footer = document.getElementById('footer_eliminar');
    var url = base_url +'/admin/usuarios/getElementosEliminar';
    document.querySelector('#reasignar_usuario').innerHTML = '';
    let formData = new FormData(document.querySelector('#formEliminarUsuario'));
    if (document.querySelector('.alert-modal') !== null){
        document.querySelector('.alert-modal').innerHTML = "";
    }
    formData.append("usuario_id", element.dataset.user_id);
    axios.post(url, formData, {
        headers: {
          "Content-Type": "multipart/form-data",
        },
    }).then(response => {
        if (response.data.mensaje == "200") {
            //console.log(response);
            document.querySelector('#reasignar_usuario').innerHTML = '';
            document.querySelector('#reasignar_usuario').innerHTML = response.data.html;
            document.querySelector('.error').innerHTML = '';
            if(response.data.footer_modal !='' && response.data.footer_modal != null){
                document.querySelector('#footer_eliminar').innerHTML = '';
                document.querySelector('#txt_reasignar').innerHTML = '';
                document.querySelector('#footer_eliminar').innerHTML=response.data.footer_modal;
                
            }
        }
        //console.log(response);
    }).catch(e => {
        console.error(e);
    });

};
window.eliminarUsuarioReasignarExpediente = function(form_id) {
    let form_usuario = document.querySelector('#'+form_id);
    if (document.querySelector('.alert-modal') !== null){
        document.querySelector('.alert-modal').innerHTML = "";
    };
    if (form_usuario !== null){
        let usuario_id = form_usuario.querySelector('#usuario_reasignar');
        if (usuario_id !== null){
          var usuario_reasignado = document.getElementById("usuario_reasignar");
          var valor_usuario_reasignado = usuario_reasignado.value;
            if (usuario_reasignado !== null || usuario_reasignado ==''){
                if(valor_usuario_reasignado == ""){
                    let mensaje = `  Dato obligatorio`;

                    if (document.querySelector('.error') !== null){
                        document.querySelector('.error').innerHTML = mensaje;
                        usuario_reasignado.classList.add("error-modal");
                    }

                }else{
                  document.querySelector('.error').innerHTML = "";
                  usuario_reasignado.classList.remove("error-modal");
                  document.querySelector('#'+form_id).submit();
                }
            }

        }else{
           document.querySelector('#'+form_id).submit();
        }

    }

}

window.selectPerfiles= function (e,inputPerfilesId){
    let inputPerfiles = document.getElementById(inputPerfilesId);
    if(inputPerfiles && e.value){
        axios.post(base_url+'/admin/usuarios/getPerfilesByAreaId',{
            area_id:e.value
        })
            .then(function (response) {
                if(response.data){
                    inputPerfiles.innerHTML=response.data.html;
                }
            })
            .catch(function (response) {
            console.log(response);
            });
    }else{
        inputPerfiles.innerHTML=`<option value="">Seleccione el perfil</option>`;
        inputPerfiles.value = "";
    }
}
