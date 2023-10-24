window.selectMunicipios= function (e,inputMunicipioId){
    let inputMunicipio = document.getElementById(inputMunicipioId);
    if(inputMunicipio && e.value){
        axios.post(base_url+'/api/getMunicipiosByDepartamentoId',{
            departamento_id:e.value
        })
            .then(function (response) {
                if(response.data){
                    inputMunicipio.innerHTML=response.data.html;
                }
            })
            .catch(function (response) {
                console.log(response);
            });
    }else{
        inputMunicipio.innerHTML=`<option value="">Seleccione un departamento</option>`;
        inputMunicipio.value = "";
    }
}

window.selectOficinaRegional= function (e,inputSelect){
    let selectOficinaRegional = document.getElementById(inputSelect);
    if(selectOficinaRegional && e.value){
        axios.post(base_url+'/api/getOficinaRegionalByMunicipiosId',{
            municipio_id:e.value
        })
            .then(function (response) {
                if(response.data){
                    selectOficinaRegional.disabled = false;
                    selectOficinaRegional.innerHTML=response.data.html;
                    auditorPorRegion(response.data.region, response.data.auditor);
                    selectOficinaRegional.disabled = true;
                }
            })
            .catch(function (response) {
                console.log(response);
            });
    }else{
        selectOficinaRegional.innerHTML=`<option value="">Seleccione un departamento</option>`;
        selectOficinaRegional.value = "";
    }
}

function auditorPorRegion(id, auditorId) {
    const auditorForm = document.getElementById('auditor_responsable_id');

    if (auditorForm) {
        auditorForm.value = auditorId;
    }
}
