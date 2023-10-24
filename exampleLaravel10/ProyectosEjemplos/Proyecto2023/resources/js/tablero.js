let form_tablero = document.getElementById('form_tablero');
if(form_tablero){
    let btn = document.getElementById('btn_reset_tablero');
    if(btn)
        btn.addEventListener('click',function(){
            document.getElementById('filtro_periodo_tablero').value='';
            form_tablero.submit();
        })
}


let exportacion_pagos_anio = document.getElementById('exportacion_pagos_anio');
let exportacion_pagos_mes = document.getElementById('exportacion_pagos_mes');
if(exportacion_pagos_anio){
    exportacion_pagos_anio.addEventListener('change',function(){
        let anio = exportacion_pagos_anio.value;
        let elemento_default = exportacion_pagos_mes.querySelector('option[value=""]');
        if((isNaN(anio) || anio==="")){
            exportacion_pagos_mes.setAttribute('disabled',true);
            elemento_default.textContent = 'Seleccione el año';
        }
        else{
            exportacion_pagos_mes.removeAttribute('disabled');
            elemento_default.textContent = 'Seleccione el mes';
        }
    })
}

window.validacionFechasTablero = function(){
    let desde = document.getElementById('periodo_desde');
    let hasta = document.getElementById('periodo_hasta');
    let alerta = document.getElementById('periodo_validacion');
    let btn = document.getElementById('btn_filtrar_tablero');
    btn.removeAttribute('disabled');
    let msg="";
    if(desde&&hasta){
        let fechaDesde = desde.value;
        let fechaHasta = hasta.value;
        if(!(fechaDesde&&fechaHasta) &&(fechaDesde||fechaHasta)){
            msg="Seleccione ambas fechas para filtrar.";
            btn.setAttribute('disabled');
        }
        if((fechaDesde&&fechaHasta) &&(fechaDesde>fechaHasta)){
            msg="La fecha final es menor a la inicial.";
            btn.setAttribute('disabled');
        }
        alerta.innerHTML=msg;
    }
}
