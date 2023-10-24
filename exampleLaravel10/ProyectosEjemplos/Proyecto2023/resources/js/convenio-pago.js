var pagos = document.querySelectorAll('.monto_pago');
Array.prototype.slice.call(pagos)
    .forEach(function (n) {
        n.addEventListener('keyup', function (e) {
            let valor = n.value;
            n.value = lempiras(valor);
        });
    });


function iniciarpago() {

}

function botonesCancelarAccion() {
    const botonesCancelar = document.querySelectorAll('.cancelar-pago');

    if (botonesCancelar) {
        botonesCancelar.forEach(function(elemento) {
            elemento.addEventListener('click', function() {
                const pago = this.dataset.pago;
                const elementoPadre = document.getElementById(`pago_convenio_${pago}`);
                const elementoCheck = document.getElementById(`input_pagado_${pago}`);
                elementoPadre.style.display = 'none';
                elementoCheck.checked = false;

            });
        });
    }
}

function elementosInteresesLempiras() {
    const elementosIntereses = document.querySelectorAll('.convenio_monto_intereses');

    if (elementosIntereses) {
        elementosIntereses.forEach(function(elemento) {
            elemento.addEventListener('keyup', function() {
                const pago = this.dataset.pago;
                const monto = new BigNumber(elemento.value.replace(/,/g, ''));

                const elementoPadre = document.getElementById(`pago_convenio_${pago}`);
                const elementoOtro = elementoPadre.querySelector('.convenio_monto_pagado');
                const elementoTotal = elementoPadre.querySelector('.convenio_monto_total');

                let sumado = monto.plus(new BigNumber(elementoOtro.value.replace(/,/g, '')));
                elementoTotal.value = lempiras(sumado.toFixed(2));

            });
        });
    }
}

function elementosMontosLempiras() {
    const elementosMontos = document.querySelectorAll('.convenio_monto_pagado');

    if (elementosMontos) {
        elementosMontos.forEach(function(elemento) {
            elemento.addEventListener('keyup', function() {
                const pago = this.dataset.pago;
                const monto = elemento.value;

                const elementoPadre = document.getElementById(`pago_convenio_${pago}`);
                const elementoOtro = elementoPadre.querySelector('.convenio_monto_intereses');
                const elementoTotal = elementoPadre.querySelector('.convenio_monto_total');

                let sumado = monto;

                if (elementoOtro.value !== '') {
                    sumado = parseFloat(monto.replace(/,/g, '')) + parseFloat(elementoOtro.value.replace(/,/g, ''));
                    if (isNaN(sumado)) {
                        sumado = 0;
                    }
                    sumado = sumado.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                }

                elementoTotal.value = sumado;


            });
        });
    }
}

window.mostrarPago = function(el){
    const pago = el.dataset.pago;
    const elementoPadre = document.getElementById(`pago_convenio_${pago}`);
    if (el.checked) {
        elementoPadre.style.display = 'block';
        elementosMontosLempiras();
        elementosInteresesLempiras();
        botonesCancelarAccion();
        convenioIncompleto();
    } else {
        elementoPadre.style.display = 'none';
    }
}

const elementoConcluir = document.getElementById('convenio_concluir');

if (elementoConcluir) {
    elementoConcluir.addEventListener('click', function() {
        const totalMulta = document.getElementById('total_multa').value;
        const totalCobrado = document.getElementById('total_cobrado').value;

        if (parseFloat(totalCobrado) >= parseFloat(totalMulta)) {
            document.getElementById('convenio_concluir_form').submit();
        } else {
            alert('No es posible concluir el convenio hasta que se cubra el monto total de la multa')
        }
    });
}


function convenioIncompleto() {
    const convenioIncompletoElementos = document.querySelectorAll('.convenio-incompleto');
    const concluirIncompletoSubmit = document.getElementById('concluir_incompleto_submit');

    if (convenioIncompletoElementos) {
        convenioIncompletoElementos.forEach(function(elemento) {
            elemento.addEventListener('click', function() {
                const formPago = this.dataset.pago;
                const formulario = document.getElementById(`pago_convenio_form_${formPago}`);
                const submitBoton = document.getElementById('concluir_incompleto_submit');

                let pagoCantidad = document.getElementById(`monto_pagado_${formPago}`).value;
                let totalCobrado = document.getElementById('total_cobrado').value;
                let totalMulta = document.getElementById('total_multa').value;

                pagoCantidad = parseFloat(pagoCantidad.replace(/,/g, ''));
                totalCobrado = parseFloat(totalCobrado.replace(/,/g, ''));
                totalMulta = parseFloat(totalMulta.replace(/,/g, ''));

                concluirIncompletoSubmit.setAttribute('form',`pago_convenio_form_${formPago}`);

                if (!formulario.checkValidity()) {
                    var inputsInvalidos = formulario.querySelectorAll(':invalid');
                    inputsInvalidos.forEach(function (inputInvalido) {
                        var invalidFeedback = inputInvalido.closest('.form-group').querySelector('.invalid-feedback');
                        var msgDefault = invalidFeedback.dataset.default;
                        var msgValidacion = tipoValidacion(inputInvalido,msgDefault);
                        if (invalidFeedback) {
                            invalidFeedback.textContent = msgValidacion;
                            invalidFeedback.style.removeProperty('display');
                        }
                    });
                    formulario.classList.add('validado');
                } else {
                    if ((pagoCantidad + totalCobrado) < totalMulta) {
                        const modalIncompleto = new Modal(document.getElementById('concluirIncompletoModal'))
                        modalIncompleto.show();
                    } else {
                        formulario.submit();
                    }
                }
            });
        });
    }
}

convenioIncompleto();

let form_convenio_pago = document.getElementById('form_convenio_pago');
if(form_convenio_pago) {
    form_convenio_pago.addEventListener('submit', function (e) {
        let total_multa = new BigNumber(document.getElementById('total_multa').value.replaceAll(',',''));
        let btn_modal = document.getElementById('btnModalTotalPago');
        let btn_cancelar = document.getElementById('btnCancelarModalTotalPago');
        let parrafo_continuar = document.getElementById('parrafoContinuarConvenio');
        e.preventDefault();
        if (form_convenio_pago.checkValidity() !== false){
            if( sumatoria_pagos!==null && !sumatoria_pagos.isEqualTo(total_multa) ){
                const modalTotalPago = new Modal(document.getElementById('modalTotalPago'))
                if(sumatoria_pagos.isLessThan(total_multa)){
                    btn_modal.classList.add('d-none');
                    btn_cancelar.innerHTML=`Aceptar`;
                    parrafo_continuar.innerHTML=`Los montos deben coincidir para poder continuar.`;
                }
                else{
                    btn_modal.classList.remove('d-none');
                    btn_cancelar.innerHTML=`Cancelar`;
                    parrafo_continuar.innerHTML=`<strong class="text-gray">¿Desea continuar?</strong>`;
                }
                modalTotalPago.show();
            }else{
                form_convenio_pago.submit();
            }
        }

    });
    window.submitFormConvenioPago = function(){
        form_convenio_pago.submit();
    }
}
