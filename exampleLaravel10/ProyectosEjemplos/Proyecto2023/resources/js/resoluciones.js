window.obtenerInformacionResolucion = function(element){

    var url = base_url +'/resoluciones/obtenerDetalleResolucion';
    const resolucion_id = element.dataset.resolucion_id;
    const resolucion_codigo = element.dataset.resolucion_codigo;
    const id_nav = '#'+resolucion_codigo;
    var token = document.head.querySelector('meta[name="csrf-token"]');
    axios.post(url, {
        _token: token.content,
        resolucion_id: resolucion_id
    }).then(response => {
        if (response.data.mensaje == "200") {

            if (document.querySelector('#nav-'+resolucion_codigo+'_'+resolucion_id) !== null){
                document.querySelector('#nav-'+resolucion_codigo+'_'+resolucion_id).innerHTML = response.data.html;
            }
        }
    }).catch(e => {
        console.error(e);
    });

};

window.addEventListener('DOMContentLoaded', (evento) => {
    if (document.querySelector('#fecha_demanda') !== null){
        document.querySelector('#fecha_demanda').max = new Date().toISOString().split("T")[0];
    }
    if (document.querySelector('#fecha_pago_total') !== null){
        document.querySelector('#fecha_pago_total').max = new Date().toISOString().split("T")[0];

    }
});

window.getModalResolucion = function(element){
    var tipoResolucion = element.dataset.tipo_resolucion;
    var caso_id = element.dataset.caso_id;
    var titulo ='', parrafo = '',boton = '',clases = '',url = '';
    switch (tipoResolucion) {
      case 'demanda':
        titulo = 'Iniciar proceso de Demanda';
        parrafo = 'Se iniciará el proceso de demanda de este caso';
        boton = 'Iniciar proceso';
        clases = 'modal-header bg-estatus-demanda text-white';
        var url = base_url +'/resoluciones/registro_demanda/'+caso_id;
        break;
    case 'convenio':
        titulo = 'Iniciar proceso Convenio de pago';
        parrafo = 'Se iniciará el proceso de convenio de pago de este caso';
        boton = 'Iniciar proceso';
        clases = 'modal-header bg-estatus-convenio_pago text-white';
        var url = base_url +'/resoluciones/convenio_pago/'+caso_id;
        break;
    case 'pagoTotal':
        titulo = 'Iniciar proceso de Pago total';
        parrafo = 'Se iniciará el proceso de pago total de este caso';
        boton = 'Iniciar proceso';
        clases = 'modal-header bg-estatus-pago_total text-white';
        var url = base_url +'/resoluciones/pago_total/'+caso_id;
        break;
      default:
        console.log(`Sorry, we are out of ${expr}.`);
    }
    if (document.querySelector('#tituloModalResoluciones') !== null){
        document.querySelector('#tituloModalResoluciones').textContent= titulo;
    }
    if (document.querySelector('#parrafoModalResoluciones') !== null){
        document.querySelector('#parrafoModalResoluciones').textContent= parrafo;

    }
    if (document.querySelector('#botonModalResoluciones') !== null){
        document.querySelector('#botonModalResoluciones').textContent= boton;
        document.querySelector('#botonModalResoluciones').setAttribute("href", '');
        document.querySelector('#botonModalResoluciones').setAttribute("href", url);
    }
    if (document.querySelector('#bgTituloModal') !== null){
        document.querySelector('#bgTituloModal').className= '';
        document.querySelector('#bgTituloModal').className= clases;

    }
    console.log(tipoResolucion);

};

window.numPagos = function(element){
    var num = document.getElementById("numero_pagos").value;
    var html = '';
    if(!isNaN(num) && num >0 ){
        for (var i = 1; i <= num; i++) {
            html +=
            `<div class="col-12 mt-3 bg-white">
                <p class="fw-semibold mb-2 font-regular-size">Pago ${i}</p>
                <div class="card border border-gray">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-4 mb-2">
                                <label for="monto">Monto *</label>
                                <div class="input-group mb-3 bg-white">
                                    <span class="input-group-text">L</span><input type="text" class="form-control bg-white monto_pago input-regular-height" name="monto[]" id="num_convenio" placeholder="Escriba el monto" maxlength="29"  required>
                                    <div class="invalid-feedback fw-regular" data-default="Dato obligatorio">Dato obligatorio</div>
                                </div>
                            </div>
                            <div class="form-group col-md-4 mb-2">
                                <label for="fecha_pago">Fecha *</label>
                                <input type="date" class="form-control bg-white fecha-convenio-demandas input-regular-height" name="fecha_pago[]" id="fecha_pago" min="${new Date().toISOString().split('T')[0]}" max="9999-12-31" onchange="validaFechaInhabil(this)" required>
                                <div class="invalid-feedback fw-regular" data-default="Dato obligatorio o fecha inválida">Dato obligatorio o fecha inválida</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;
        }
        html+=`<div class="col-12 mt-3 bg-white text-end">
                    <span class="fw-bold">Total por pagar: </span> <span id="total_por_pagar"></span>
                </div>`;
    }


    document.getElementById('div_numero_pagos').innerHTML = html;
    var pagos = document.querySelectorAll('.monto_pago');
    Array.prototype.slice.call(pagos)
        .forEach(function(n){
            n.addEventListener('keyup',function(e){
                let valor = n.value;
                n.value = lempiras(valor);
            });
            n.addEventListener('keyup',function(){
               calculoTotalPagos();
            });
        });

}
window.sumatoria_pagos = null;
window.calculoTotalPagos = function(){
    let items = 0;
    let total = new BigNumber(0);
    let pagos = document.querySelectorAll('.monto_pago');
    Array.prototype.slice.call(pagos)
        .forEach(function(e){
            items++;
            if(e.value!==""){
                let valor = new BigNumber(e.value.replace('L ','').replaceAll(',',''));
                total = total.plus(valor);
            }
        });
    let total_pagos = total;
    window.sumatoria_pagos = total_pagos;
    let total_multa = new BigNumber(document.getElementById('total_multa').value.replaceAll(',',''));
    if(!total_pagos.isEqualTo(total_multa)){
        document.getElementById('parrafoTotalPago').innerHTML =
            `La suma total de los pagos a realizar
                <strong>(L ${lempiras(total_pagos.toFixed(2))})</strong>
                es ${(total_pagos.isGreaterThan(total_multa))?'mayor':'menor'} al total de la multa
                <strong>(L ${lempiras(total_multa.toFixed(2))})</strong>.`;
    }
    document.getElementById('total_por_pagar').innerHTML=`L ${lempiras(total.toFixed(2))}`;
}

let monto_pago_total = document.getElementById('monto_pago_total');
if(monto_pago_total)
    monto_pago_total.addEventListener('keyup',function(e){
            let valor = this.value;
            this.value = lempiras(valor);
    });
let interes_pago_total = document.getElementById('interes_pago_total');
if(interes_pago_total)
    interes_pago_total.addEventListener('keyup',function(e){
            let valor = this.value;
            this.value = lempiras(valor);
    });

var montos = document.querySelector(".montosPagoTotal");
if(montos)
    montos.addEventListener("blur", function( event ) {
        let monto = document.getElementById('monto_pago_total').value;
        let interes = document.getElementById('interes_pago_total').value;
        let total = new BigNumber(0);
        if(monto != null && monto != ''){
            monto = new BigNumber(monto.replaceAll(',',''));
            if(interes != null && interes != ''){
                interes = new BigNumber(interes.replaceAll(',',''))
                total = monto.plus(interes);
            }else{
                total = monto;
            }
        }
        total = lempiras(total.toFixed(2));
        document.getElementById('monto_total_pago_total').value=total;
    }, true);

var interes = document.querySelector(".interesPagoTotal");
if(interes)
    interes.addEventListener("blur", function( event ) {
        let monto = document.getElementById('monto_pago_total').value;
        let interes = document.getElementById('interes_pago_total').value;
        let total = new BigNumber(0);
        if(monto != null && monto != ''){
            monto = new BigNumber(monto.replaceAll(',',''));
            if(interes != null && interes != ''){
                interes = new BigNumber(interes.replaceAll(',',''))
                total = monto.plus(interes);
            }else{
                total = monto;
            }
        }
        total = lempiras(total.toFixed(2));
        document.getElementById('monto_total_pago_total').value= total;
    }, true);


